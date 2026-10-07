<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reorder extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Audit F-13 : le mode strict doit etre arme ici comme dans les
        // autres controleurs du module, sans quoi une quantite decimale hors
        // borne est tronquee en silence au lieu de lever une erreur.
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
        $this->load->model('reorder_model');
    }

    public function index()
    {
        $this->permission->method('purchase', 'read')->redirect();

        $data['title'] = display('reorder_suggestions');
        $items = $this->reorder_model->get_below_min();

        // Enrich with avg consumption and last supplier
        foreach ($items as &$item) {
            $item->avg_daily    = $this->reorder_model->get_avg_consumption($item->id);
            $item->suggested_qty = max($item->deficit, ceil($item->avg_daily * 7)); // deficit or 7 days of supply
            $last = $this->reorder_model->get_last_supplier($item->id);
            $item->last_supplier = $last ? $last->supName : '—';
            $item->last_price    = $last ? $last->price : 0;
            $item->last_supid    = $last ? $last->supid : null;
        }

        $data['items']   = $items;
        $data['module']  = 'purchase';
        $data['page']    = 'reorder';
        echo modules::run('template/layout', $data);
    }

    /**
     * Generate a pre-filled purchase order from selected ingredients.
     */
    public function generate_po()
    {
        $this->permission->method('purchase', 'create')->redirect();

        $ids  = $this->input->post('ingredient_id');
        $qtys = $this->input->post('order_qty');

        if (empty($ids) || !is_array($ids)) {
            $this->session->set_flashdata('exception', display('no_ingredient_selected'));
            redirect('purchase/reorder');
            return;
        }

        // Store selected items in session for purchase form to pick up
        $reorder_items = [];
        for ($i = 0; $i < count($ids); $i++) {
            if (empty($qtys[$i]) || $qtys[$i] <= 0) continue;
            $ingredient = $this->db->select('id, ingredient_name')
                ->where('id', $ids[$i])
                ->get('ingredients')
                ->row();
            if ($ingredient) {
                $reorder_items[] = [
                    'ingredient_id'   => $ingredient->id,
                    'ingredient_name' => $ingredient->ingredient_name,
                    'quantity'        => (float) $qtys[$i],
                ];
            }
        }

        $this->session->set_userdata('reorder_items', $reorder_items);
        $this->session->set_flashdata('message', count($reorder_items) . ' ' . display('items_preloaded'));
        redirect('purchase/purchase/create');
    }
}
