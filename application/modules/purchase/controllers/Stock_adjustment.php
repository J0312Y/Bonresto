<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_adjustment extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Ce controleur ecrit du stock. Comme Purchase.php, il doit le faire
        // en mode strict : sans cela une quantite decimale trop longue, ou
        // hors borne, est tronquee en silence au lieu de lever une erreur.
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
        $this->load->library('stock_movement_lib');
    }

    /**
     * Adjustment history list.
     */
    public function index()
    {
        $this->permission->method('purchase', 'read')->redirect();

        $filters = [
            'movement_type' => 'adjustment',
            'date_from'     => $this->input->get('date_from'),
            'date_to'       => $this->input->get('date_to'),
            'limit'         => 50,
            'offset'        => $this->input->get('offset') ?: 0,
        ];

        $data['title']      = display('adjustment_history');
        $data['movements']  = $this->stock_movement_lib->get_all_movements($filters);
        $data['filters']    = $filters;
        $data['module']     = 'purchase';
        $data['page']       = 'adjustment_list';
        echo modules::run('template/layout', $data);
    }

    /**
     * Single ingredient adjustment form.
     */
    public function create($ingredient_id = null)
    {
        $this->permission->method('purchase', 'update')->redirect();

        $data['title'] = display('stock_adjustment');

        if ($ingredient_id) {
            $data['ingredient'] = $this->db->select('id, ingredient_name, stock_qty, min_stock')
                ->where('id', $ingredient_id)
                ->get('ingredients')
                ->row();
        }

        $data['ingredients'] = $this->db->select('id, ingredient_name, stock_qty')
            ->where('is_active', 1)
            ->order_by('ingredient_name')
            ->get('ingredients')
            ->result();

        $data['reasons'] = ['count_correction', 'damage', 'theft', 'expired', 'other'];

        $data['module'] = 'purchase';
        $data['page']   = 'adjustment_form';
        echo modules::run('template/layout', $data);
    }

    /**
     * Save single adjustment.
     */
    public function save()
    {
        $this->permission->method('purchase', 'update')->redirect();

        $ingredient_id = (int) $this->input->post('ingredient_id');
        $actual_qty    = (float) $this->input->post('actual_qty');
        $reason        = $this->input->post('reason');
        $notes         = $this->input->post('notes', true);

        // Lecture du stock, calcul de l'ecart et ecriture doivent tenir sous
        // un meme verrou de ligne.
        //
        // Sans FOR UPDATE, une sortie de stock concurrente — une commande
        // encaissee — s'intercalait entre la lecture et l'ecriture. Le stock
        // final restait juste, puisqu'on ecrit une valeur absolue, mais le
        // `quantity_change` inscrit au grand livre devenait faux : il
        // mesurait un ecart par rapport a un stock qui n'existait plus. Or
        // c'est exactement cet ecart que le grand livre sert a detecter.
        //
        // FOR UPDATE n'a d'effet qu'a l'interieur d'une transaction : elle
        // ouvre donc AVANT la lecture, et non juste avant l'UPDATE.
        $this->db->trans_start();

        $ingredient = $this->db->query(
            'SELECT id, stock_qty, ingredient_name FROM ingredients WHERE id = ? FOR UPDATE',
            [$ingredient_id]
        )->row();

        if (!$ingredient) {
            $this->db->trans_complete();
            $this->session->set_flashdata('exception', display('ingredient_not_found'));
            redirect('purchase/stock_adjustment/create');
            return;
        }

        $diff = $actual_qty - $ingredient->stock_qty;

        if ($diff == 0) {
            $this->db->trans_complete();
            $this->session->set_flashdata('exception', display('no_difference'));
            redirect('purchase/stock_adjustment/create/' . $ingredient_id);
            return;
        }

        $this->db->set('stock_qty', $actual_qty);
        $this->db->where('id', $ingredient_id);
        $this->db->update('ingredients');

        $this->stock_movement_lib->record(
            $ingredient_id,
            'adjustment',
            $diff,
            null,
            null,
            null,
            $notes,
            $reason
        );

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('message', display('stock_adjusted_success') . ' (' . $ingredient->ingredient_name . ' : ' . $ingredient->stock_qty . ' → ' . $actual_qty . ')');
        } else {
            $this->session->set_flashdata('exception', display('adjustment_error'));
        }

        redirect('purchase/stock_adjustment');
    }

    /**
     * Bulk inventory count form — shows all active ingredients.
     */
    public function bulk()
    {
        $this->permission->method('purchase', 'update')->redirect();

        $data['title'] = display('physical_inventory');
        $data['ingredients'] = $this->db->select('ingredients.id, ingredients.ingredient_name, ingredients.stock_qty, ingredients.min_stock, unit_of_measurement.uom_short_code')
            ->from('ingredients')
            ->join('unit_of_measurement', 'unit_of_measurement.id = ingredients.uom_id', 'left')
            ->where('ingredients.is_active', 1)
            ->order_by('ingredients.ingredient_name')
            ->get()
            ->result();

        $data['module'] = 'purchase';
        $data['page']   = 'bulk_adjustment';
        echo modules::run('template/layout', $data);
    }

    /**
     * Save bulk adjustments from physical inventory count.
     */
    public function save_bulk()
    {
        $this->permission->method('purchase', 'update')->redirect();

        $ids      = $this->input->post('ingredient_id');
        $actuals  = $this->input->post('actual_qty');
        // save() filtrait deja ses notes, save_bulk non. Elles ressortent
        // telles quelles dans adjustment_list, et global_xss_filtering est a
        // false : c'etait la voie d'entree d'un XSS stocke.
        $notes    = $this->input->post('notes', true);

        if (empty($ids) || !is_array($ids)) {
            $this->session->set_flashdata('exception', display('no_data_received'));
            redirect('purchase/stock_adjustment/bulk');
            return;
        }

        // `actual_qty` et `notes` sont indexes en parallele de
        // `ingredient_id`. Un envoi qui ne porte que `ingredient_id[]` les
        // laissait a null, et $actuals[$i] lisait alors un offset sur null.
        if (!is_array($actuals)) {
            $actuals = [];
        }
        if (!is_array($notes)) {
            $notes = [];
        }

        $this->db->trans_start();
        $adjusted = 0;

        for ($i = 0; $i < count($ids); $i++) {
            $ingredient_id = (int) $ids[$i];
            $actual        = isset($actuals[$i]) ? $actuals[$i] : null;

            if ($actual === '' || $actual === null) continue;

            $actual = (float) $actual;

            // Meme verrou de ligne que save() — voir le commentaire la-bas.
            $ingredient = $this->db->query(
                'SELECT id, stock_qty FROM ingredients WHERE id = ? FOR UPDATE',
                [$ingredient_id]
            )->row();

            if (!$ingredient) continue;

            $diff = $actual - $ingredient->stock_qty;
            if ($diff == 0) continue;

            $this->db->set('stock_qty', $actual);
            $this->db->where('id', $ingredient_id);
            $this->db->update('ingredients');

            $this->stock_movement_lib->record(
                $ingredient_id,
                'adjustment',
                $diff,
                null,
                null,
                null,
                !empty($notes[$i]) ? $notes[$i] : display('physical_inventory'),
                'count_correction'
            );

            $adjusted++;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('message', $adjusted . ' ' . display('ingredients_adjusted'));
        } else {
            $this->session->set_flashdata('exception', display('inventory_error'));
        }

        redirect('purchase/stock_adjustment');
    }

    /**
     * AJAX barcode lookup for bulk inventory scanning.
     */
    public function barcode_lookup()
    {
        // Seule methode du controleur qui ne verifiait aucun droit, et il
        // n'existe pas de garde d'authentification globale pour rattraper
        // l'oubli : hooks.php ne porte que CORS, licence et tenant. En
        // l'etat, l'endpoint laissait enumerer tout le catalogue
        // d'ingredients et ses niveaux de stock sans aucune session.
        //
        // access() plutot que redirect() : l'appelant attend du JSON, une
        // 302 vers /login ne lui apprendrait rien.
        if (!$this->permission->method('purchase', 'read')->access()) {
            $this->output->set_status_header(403)
                ->set_content_type('application/json')
                ->set_output(json_encode(['found' => false, 'error' => 'forbidden']));
            return;
        }

        $barcode = $this->input->get('barcode', true);

        if (empty($barcode)) {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(['found' => false]));
            return;
        }

        $ingredient = $this->db->select('id, ingredient_name, stock_qty')
            ->where('barcode', $barcode)
            ->where('is_active', 1)
            ->get('ingredients')
            ->row();

        if ($ingredient) {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(['found' => true, 'id' => $ingredient->id, 'name' => $ingredient->ingredient_name]));
        } else {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(['found' => false]));
        }
    }
}
