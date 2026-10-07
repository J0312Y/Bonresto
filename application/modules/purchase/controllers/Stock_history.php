<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_history extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Audit F-13 : le mode strict doit etre arme ici comme dans les
        // autres controleurs du module, sans quoi une quantite decimale hors
        // borne est tronquee en silence au lieu de lever une erreur.
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
        $this->load->library('stock_movement_lib');
    }

    /**
     * GET /purchase/stock_history/movements/{ingredient_id}
     * Returns paginated JSON of stock movements for an ingredient.
     *
     * Query params: movement_type, date_from, date_to, limit, offset
     */
    public function movements($ingredient_id = null)
    {
        $this->permission->method('purchase', 'read')->redirect();

        if (empty($ingredient_id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'ingredient_id required']));
            return;
        }

        $filters = [
            'movement_type' => $this->input->get('movement_type'),
            'date_from'     => $this->input->get('date_from'),
            'date_to'       => $this->input->get('date_to'),
            'limit'         => $this->input->get('limit') ?: 50,
            'offset'        => $this->input->get('offset') ?: 0,
        ];

        $movements = $this->stock_movement_lib->get_movements($ingredient_id, $filters);
        $total     = $this->stock_movement_lib->count_movements($ingredient_id, $filters);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'total'     => $total,
                'limit'     => (int) $filters['limit'],
                'offset'    => (int) $filters['offset'],
                'movements' => $movements,
            ]));
    }

    /**
     * View stock movement history page for a specific ingredient.
     * GET /purchase/stock_history/view/{ingredient_id}
     */
    public function view($ingredient_id = null)
    {
        $this->permission->method('purchase', 'read')->redirect();

        if (empty($ingredient_id)) {
            redirect('purchase/purchase');
        }

        $ingredient = $this->db->select('id, ingredient_name, stock_qty, min_stock')
            ->where('id', $ingredient_id)
            ->get('ingredients')
            ->row();

        if (!$ingredient) {
            redirect('purchase/purchase');
        }

        $filters = [
            'movement_type' => $this->input->get('movement_type'),
            'date_from'     => $this->input->get('date_from'),
            'date_to'       => $this->input->get('date_to'),
            'limit'         => 50,
            'offset'        => $this->input->get('offset') ?: 0,
        ];

        $data['title']      = display('movement_history') . ' — ' . $ingredient->ingredient_name;
        $data['ingredient'] = $ingredient;
        $data['movements']  = $this->stock_movement_lib->get_movements($ingredient_id, $filters);
        $data['total']      = $this->stock_movement_lib->count_movements($ingredient_id, $filters);
        $data['filters']    = $filters;

        $data['module'] = 'purchase';
        $data['page']   = 'stock_history';
        echo modules::run('template/layout', $data);
    }
}
