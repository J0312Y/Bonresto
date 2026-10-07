<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_transfer extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Audit F-13 : le mode strict doit etre arme ici comme dans les
        // autres controleurs du module, sans quoi une quantite decimale hors
        // borne est tronquee en silence au lieu de lever une erreur.
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
        $this->load->model('transfer_model');
        $this->load->library('stock_movement_lib');
    }

    /**
     * List transfers (outgoing + incoming).
     */
    public function index()
    {
        $this->permission->method('purchase', 'read')->redirect();

        $tenant_id = defined('CURRENT_TENANT_ID') ? CURRENT_TENANT_ID : 0;

        $data['title']    = display('inter_site_transfer');
        $data['outgoing'] = $this->transfer_model->get_outgoing($tenant_id);
        $data['incoming'] = $this->transfer_model->get_incoming($tenant_id);
        $data['pending_count'] = count($this->transfer_model->get_pending_incoming($tenant_id));

        $data['module'] = 'purchase';
        $data['page']   = 'stock_transfer_list';
        echo modules::run('template/layout', $data);
    }

    /**
     * Create transfer form.
     */
    public function create()
    {
        $this->permission->method('purchase', 'update')->redirect();

        $tenant_id = defined('CURRENT_TENANT_ID') ? CURRENT_TENANT_ID : 0;
        $group_id  = defined('CURRENT_GROUP_ID') ? CURRENT_GROUP_ID : 0;

        $data['title']    = display('new_transfer');
        $data['siblings'] = $this->transfer_model->get_siblings($group_id, $tenant_id);

        $data['ingredients'] = $this->db->select('i.id, i.ingredient_name, i.stock_qty, u.uom_short_code')
            ->from('ingredients i')
            ->join('unit_of_measurement u', 'u.id = i.uom_id', 'left')
            ->where('i.is_active', 1)
            ->where('i.stock_qty >', 0)
            ->order_by('i.ingredient_name')
            ->get()
            ->result();

        $data['module'] = 'purchase';
        $data['page']   = 'stock_transfer_create';
        echo modules::run('template/layout', $data);
    }

    /**
     * Send transfer.
     */
    public function send()
    {
        $this->permission->method('purchase', 'update')->redirect();

        $tenant_id     = defined('CURRENT_TENANT_ID') ? CURRENT_TENANT_ID : 0;
        $to_tenant_id  = (int) $this->input->post('to_tenant_id');
        $notes         = $this->input->post('notes', true);
        $ingredient_ids = $this->input->post('ingredient_id');
        $quantities    = $this->input->post('quantity');

        if (empty($ingredient_ids) || !is_array($ingredient_ids) || empty($to_tenant_id)) {
            $this->session->set_flashdata('exception', display('missing_data'));
            redirect('purchase/stock_transfer/create');
            return;
        }

        // `quantity` est indexe en parallele de `ingredient_id`. Un envoi qui
        // ne porte que `ingredient_id[]` le laissait a null, et $quantities[$i]
        // lisait alors un offset sur null.
        if (!is_array($quantities)) {
            $quantities = [];
        }

        // Le libelle « stock insuffisant » n'est pas encore en base, et
        // display() rend false sur une phrase absente : on garde un repli.
        $libelle_insuffisant = display('insufficient_stock') ?: 'Stock insuffisant';

        $this->db->trans_start();

        // ── Premiere passe : verrouiller et verifier, sans rien ecrire ──
        //
        // La suffisance du stock se controlait sur une lecture libre, puis la
        // deduction s'ecrivait en GREATEST(stock_qty - qty, 0). Deux
        // transferts simultanes du meme ingredient passaient donc tous les
        // deux le controle, et le GREATEST ramenait le stock a zero sans rien
        // dire : la marchandise partait vers deux restaurants alors qu'elle
        // n'existait qu'une fois. Le grand livre enregistrait les deux
        // sorties completes — l'ecart devenait invisible a la piste d'audit
        // meme qui sert a le reperer.
        //
        // Les lignes sont desormais prises en FOR UPDATE et conservees
        // jusqu'au commit : le second envoi attend, relit le stock deja
        // diminue, et refuse sa ligne. Le GREATEST perd sa raison d'etre —
        // sous verrou la quantite est connue exacte, et plafonner a zero ne
        // servait qu'a masquer le depassement.
        $items        = [];
        $insufficient = [];

        for ($i = 0; $i < count($ingredient_ids); $i++) {
            $qty = isset($quantities[$i]) ? (float) $quantities[$i] : 0;
            if ($qty <= 0) continue;

            $ingredient = $this->db->query(
                'SELECT id, ingredient_name, stock_qty, uom_id FROM ingredients WHERE id = ? FOR UPDATE',
                [(int) $ingredient_ids[$i]]
            )->row();

            if (!$ingredient) continue;

            if ($ingredient->stock_qty < $qty) {
                // Ces lignes etaient ecartees en silence : l'expediteur
                // croyait avoir transfere ce qu'il venait de saisir.
                $insufficient[] = $ingredient->ingredient_name;
                continue;
            }

            $uom = $this->db->select('uom_short_code')
                ->where('id', $ingredient->uom_id)
                ->get('unit_of_measurement')
                ->row();

            $items[] = [
                'ingredient_id'   => $ingredient->id,
                'ingredient_name' => $ingredient->ingredient_name,
                'quantity'        => $qty,
                'unit'            => $uom ? $uom->uom_short_code : '',
                'new_stock_qty'   => $ingredient->stock_qty - $qty,
            ];
        }

        if (empty($items)) {
            $this->db->trans_complete();
            $this->session->set_flashdata('exception', empty($insufficient)
                ? display('transfer_error')
                : $libelle_insuffisant . ' : ' . implode(', ', $insufficient));
            redirect('purchase/stock_transfer/create');
            return;
        }

        // ── Le transfert est inscrit AVANT que le stock ne bouge ──
        //
        // Les deux bases ne partagent pas de transaction : l'une des deux
        // ecritures peut echouer seule. Dans cet ordre-ci, l'echec laisse un
        // transfert sans deduction — visible, et supprime juste en dessous.
        // Dans l'ordre precedent — stock deduit et valide, puis transfert
        // cree — l'echec laissait du stock deduit sans aucun transfert a
        // confirmer ni a rejeter : une perte silencieuse que rien ne
        // permettait de rattraper.
        $transfer_id = $this->transfer_model->create_transfer(
            $tenant_id, $to_tenant_id, $items, $notes,
            $this->session->userdata('id')
        );

        if (empty($transfer_id)) {
            $this->db->trans_complete();
            $this->session->set_flashdata('exception', display('transfer_error'));
            redirect('purchase/stock_transfer/create');
            return;
        }

        // ── Seconde passe : les lignes sont toujours verrouillees par cette
        // meme transaction, les quantites lues plus haut restent valables ──
        foreach ($items as $item) {
            $this->db->set('stock_qty', $item['new_stock_qty']);
            $this->db->where('id', $item['ingredient_id']);
            $this->db->update('ingredients');

            // La reference portait $to_tenant_id alors que reference_type
            // vaut 'stock_transfer' : l'historique affichait
            // « stock_transfer #<id de tenant> », un numero de transfert qui
            // n'en etait pas un.
            $this->stock_movement_lib->record(
                $item['ingredient_id'],
                'transfer_out',
                -$item['quantity'],
                $transfer_id,
                'stock_transfer'
            );
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $message = display('transfer_sent_success') . ' #' . $transfer_id;
            if (!empty($insufficient)) {
                $message .= ' — ' . $libelle_insuffisant . ' : ' . implode(', ', $insufficient);
            }
            $this->session->set_flashdata('message', $message);
        } else {
            // Le stock n'a pas bouge : ce transfert ne doit pas subsister.
            $this->transfer_model->delete_transfer($transfer_id);
            $this->session->set_flashdata('exception', display('transfer_error'));
        }

        redirect('purchase/stock_transfer');
    }

    /**
     * Pending incoming transfers.
     */
    public function pending()
    {
        $this->permission->method('purchase', 'read')->redirect();

        $tenant_id = defined('CURRENT_TENANT_ID') ? CURRENT_TENANT_ID : 0;

        $data['title']   = display('pending_transfers');
        $data['pending'] = $this->transfer_model->get_pending_incoming($tenant_id);

        // Load items for each pending transfer
        foreach ($data['pending'] as &$t) {
            $t->items = $this->transfer_model->get_transfer_items($t->id);
        }

        $data['module'] = 'purchase';
        $data['page']   = 'stock_transfer_pending';
        echo modules::run('template/layout', $data);
    }

    /**
     * Confirm incoming transfer.
     */
    public function confirm($transfer_id)
    {
        $this->permission->method('purchase', 'update')->redirect();

        $transfer_id = (int) $transfer_id;
        $tenant_id = defined('CURRENT_TENANT_ID') ? CURRENT_TENANT_ID : 0;
        $transfer  = $this->transfer_model->get_transfer($transfer_id);

        if (!$transfer || $transfer->to_tenant_id != $tenant_id || $transfer->status !== 'pending') {
            $this->session->set_flashdata('exception', display('transfer_invalid'));
            redirect('purchase/stock_transfer/pending');
            return;
        }

        // ── Revendiquer le transfert AVANT de crediter quoi que ce soit ──
        //
        // Le controle « status === pending » juste au-dessus est une lecture.
        // Deux confirmations simultanees du meme transfert le passaient donc
        // toutes les deux, creditaient le stock chacune de son cote, et
        // inscrivaient deux entrees au grand livre pour un seul envoi : le
        // site destinataire se retrouvait avec le double de la marchandise
        // recue. L'ancien code aggravait le probleme en n'ecrivant le statut
        // qu'apres le credit, ce qui elargissait la fenetre a toute la duree
        // de la transaction locale.
        //
        // claim_pending() porte la condition dans l'UPDATE lui-meme : une
        // seule requete peut emporter la ligne, et c'est elle seule qui
        // credite.
        if (!$this->transfer_model->claim_pending($transfer_id, $this->session->userdata('id'))) {
            $this->session->set_flashdata('exception', display('transfer_invalid'));
            redirect('purchase/stock_transfer/pending');
            return;
        }

        $items = $this->transfer_model->get_transfer_items($transfer_id);

        $this->db->trans_start();

        foreach ($items as $item) {
            // Find matching ingredient by name in this tenant's DB
            $local = $this->db->select('id')
                ->where('ingredient_name', $item->ingredient_name)
                ->where('is_active', 1)
                ->get('ingredients')
                ->row();

            if ($local) {
                // Ajout relatif, et non valeur absolue : une addition ne peut
                // pas depasser de borne, l'operation reste donc juste meme si
                // une autre ecriture touche la ligne entre-temps.
                $this->db->set('stock_qty', 'stock_qty+' . (float) $item->quantity, false);
                $this->db->where('id', $local->id);
                $this->db->update('ingredients');

                $this->stock_movement_lib->record(
                    $local->id,
                    'transfer_in',
                    $item->quantity,
                    $transfer_id,
                    'stock_transfer'
                );

                // Passe par le modele : `saas_db` y est protege, et l'atteindre
                // depuis ici tombait dans CI_Model::__get(), renvoyait null, et
                // faisait echouer confirm() des la premiere ligne reconnue.
                $this->transfer_model->map_item_to_local($item->id, $local->id);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('message', display('transfer_confirmed') . ' #' . $transfer_id);
        } else {
            // Le stock n'a pas ete credite : rendre le transfert a l'etat
            // « pending » pour qu'il reste confirmable plus tard.
            $this->transfer_model->release_claim($transfer_id);
            $this->session->set_flashdata('exception', display('confirmation_error'));
        }

        redirect('purchase/stock_transfer/pending');
    }

    /**
     * Reject incoming transfer — restore stock on sender side.
     */
    public function reject($transfer_id)
    {
        $this->permission->method('purchase', 'update')->redirect();

        $transfer_id = (int) $transfer_id;
        $tenant_id = defined('CURRENT_TENANT_ID') ? CURRENT_TENANT_ID : 0;
        $transfer  = $this->transfer_model->get_transfer($transfer_id);

        if (!$transfer || $transfer->to_tenant_id != $tenant_id || $transfer->status !== 'pending') {
            $this->session->set_flashdata('exception', display('transfer_invalid'));
            redirect('purchase/stock_transfer/pending');
            return;
        }

        $this->transfer_model->update_status($transfer_id, 'rejected', $this->session->userdata('id'));
        $this->session->set_flashdata('message', display('transfer_rejected'));

        redirect('purchase/stock_transfer/pending');
    }
}
