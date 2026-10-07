<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_report extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Audit F-13 : le mode strict doit etre arme ici comme dans les
        // autres controleurs du module, sans quoi une quantite decimale hors
        // borne est tronquee en silence au lieu de lever une erreur.
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
        $this->load->model('stock_report_model');
    }

    public function index()
    {
        $this->permission->method('purchase', 'read')->redirect();

        $data['title']       = display('stock_report');
        $data['stock_value'] = $this->stock_report_model->total_stock_value();
        $data['summary']     = $this->stock_report_model->summary();
        $data['top_consumed'] = $this->stock_report_model->top_consumed();
        $data['dormant']     = $this->stock_report_model->dormant_stock(30);

        $data['module'] = 'purchase';
        $data['page']   = 'stock_report';
        echo modules::run('template/layout', $data);
    }

    /**
     * AJAX endpoint for daily consumption chart data.
     */
    public function chart_data()
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

        $days = $this->input->get('days') ?: 30;
        $consumption = $this->stock_report_model->daily_consumption($days);

        $labels = [];
        $values = [];
        foreach ($consumption as $row) {
            $labels[] = date('d/m', strtotime($row->day));
            $values[] = (float) $row->consumed;
        }

        $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'labels' => $labels,
                'values' => $values,
            ]));
    }
}
