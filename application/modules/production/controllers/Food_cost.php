<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Food_cost extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Audit F-13 : le mode strict doit etre arme ici comme dans les
        // autres controleurs du module, sans quoi une quantite decimale hors
        // borne est tronquee en silence au lieu de lever une erreur.
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
        $this->load->model('production_model');
    }

    public function index()
    {
        $this->permission->method('production', 'read')->redirect();

        $data['title'] = display('recipe_cost');
        $data['items'] = $this->production_model->food_cost_list();

        $data['module'] = 'production';
        $data['page']   = 'food_cost';
        echo modules::run('template/layout', $data);
    }
}
