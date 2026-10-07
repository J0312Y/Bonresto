<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expiry_tracking extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Audit F-13 : le mode strict doit etre arme ici comme dans les
        // autres controleurs du module, sans quoi une quantite decimale hors
        // borne est tronquee en silence au lieu de lever une erreur.
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
        $this->load->model('batch_model');
    }

    public function index()
    {
        $this->permission->method('purchase', 'read')->redirect();

        $data['title'] = display('expiry_tracking');

        $days = $this->input->get('days') ?: 30;
        $data['days']     = $days;
        $data['expiring'] = $this->batch_model->get_expiring($days);
        $data['expired']  = $this->batch_model->get_expired();

        $data['module'] = 'purchase';
        $data['page']   = 'expiry_tracking';
        echo modules::run('template/layout', $data);
    }
}
