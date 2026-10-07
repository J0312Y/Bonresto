<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_price_history extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Audit F-13 : le mode strict doit etre arme ici comme dans les
        // autres controleurs du module, sans quoi une quantite decimale hors
        // borne est tronquee en silence au lieu de lever une erreur.
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
        $this->load->model('purchase_model');
    }

    public function index($ingredient_id = null)
    {
        $this->permission->method('purchase', 'read')->redirect();

        $data['title'] = display('supplier_price_history');

        $data['ingredients'] = $this->db->select('id, ingredient_name')
            ->where('is_active', 1)
            ->order_by('ingredient_name')
            ->get('ingredients')
            ->result();

        $data['selected_id'] = $ingredient_id;
        $data['history'] = [];

        if ($ingredient_id) {
            $data['history'] = $this->db->select('pd.purchasedate, pd.price, pd.quantity, pd.totalprice, s.supName')
                ->from('purchase_details pd')
                ->join('purchaseitem pi', 'pd.purchaseid = pi.purID')
                ->join('supplier s', 'pi.suplierID = s.supid', 'left')
                ->where('pd.indredientid', (int) $ingredient_id)
                ->order_by('pd.purchasedate', 'ASC')
                ->get()
                ->result();

            $data['ingredient_name'] = $this->db->select('ingredient_name')
                ->where('id', $ingredient_id)
                ->get('ingredients')
                ->row()->ingredient_name ?? '';
        }

        $data['module'] = 'purchase';
        $data['page']   = 'supplier_price_history';
        echo modules::run('template/layout', $data);
    }

    /**
     * AJAX endpoint for chart data.
     */
    public function chart_data($ingredient_id = null)
    {
        // Meme oubli que barcode_lookup : un endpoint JSON sans controle
        // de droits, et aucune garde d'authentification globale derriere
        // pour le rattraper. access() plutot que redirect() — l'appelant
        // attend du JSON, pas une 302 vers /login.
        if (!$this->permission->method('purchase', 'read')->access()) {
            $this->output->set_status_header(403)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'forbidden']));
            return;
        }

        if (empty($ingredient_id)) {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(['datasets' => []]));
            return;
        }

        $rows = $this->db->select('pd.purchasedate, pd.price, s.supName')
            ->from('purchase_details pd')
            ->join('purchaseitem pi', 'pd.purchaseid = pi.purID')
            ->join('supplier s', 'pi.suplierID = s.supid', 'left')
            ->where('pd.indredientid', (int) $ingredient_id)
            ->order_by('pd.purchasedate', 'ASC')
            ->get()
            ->result();

        // Group by supplier
        $suppliers = [];
        foreach ($rows as $r) {
            $name = $r->supName ?: display('unknown_label');
            if (!isset($suppliers[$name])) {
                $suppliers[$name] = [];
            }
            $suppliers[$name][] = [
                'x' => $r->purchasedate,
                'y' => (float) $r->price,
            ];
        }

        $colors = ['#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#e67e22', '#34495e'];
        $datasets = [];
        $i = 0;
        foreach ($suppliers as $name => $points) {
            $color = $colors[$i % count($colors)];
            $datasets[] = [
                'label'           => $name,
                'data'            => $points,
                'borderColor'     => $color,
                'backgroundColor' => $color . '20',
                'fill'            => false,
                'tension'         => 0.3,
            ];
            $i++;
        }

        $this->output->set_content_type('application/json')
            ->set_output(json_encode(['datasets' => $datasets]));
    }
}
