<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrorder extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('permission');
        $this->permission->check_admin_auth(); // Vérifie l'admin
        $this->load->model('Qrorder_model');   // Charge le modèle
    }

    // Liste des commandes QR
    public function index()
    {
        $data['title']  = 'Liste des commandes QR';
        $data['module'] = 'qrapp';
        $data['page']   = 'qrorder_list';
        echo Modules::run('template/layout', $data);
    }

    // Récupération JSON pour DataTable (server-side)
    public function allqrorder()
    {
        $list = $this->Qrorder_model->get_all_qr_orders();

        $data = array();
        $sl = 0;
        foreach ($list as $order) {
            $sl++;
            $row = array();
            $row[] = $sl;
            $row[] = $order->saleinvoice;
            $row[] = $order->customer_name;
            $row[] = $order->customer_type;
            $row[] = $order->waiter_name;
            $row[] = $order->table_no;
            $row[] = $order->payment_status;
            $row[] = $order->order_date;
            $row[] = number_format($order->totalamount, 2); 
            // Pas de colonne action pour ton vieux écran
            $data[] = $row;
        }

        $output = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => $this->Qrorder_model->count_all(),
            "recordsFiltered" => $this->Qrorder_model->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }
}
