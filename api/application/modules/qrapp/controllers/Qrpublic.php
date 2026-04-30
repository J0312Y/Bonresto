<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrpublic extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('qrapp/Qrtable_model');
        $this->load->model('qrapp/Qrorder_model');
        $this->load->database();
    }

    
    public function index($table_id = null)
    {
        if (empty($table_id)) {
            show_404();
        }

        // Récupère les infos de la table
        $data['table'] = $this->db->where('tableid', $table_id)->get('rest_table')->row();

        if (!$data['table']) {
            show_error("Table introuvable ou QR invalide.");
        }

        // Récupère les produits actifs (par ex. à commander)
        $data['products'] = $this->db->where('status', 1)->get('product_information')->result();

        $data['title'] = "Commande - Table " . $data['table']->tablename;
        $this->load->view('qrapp/qrpublic/index', $data);
    }

    // Soumission de commande
    public function submit_order()
    {
        $table_id = $this->input->post('table_id');
        $items = $this->input->post('product_id');
        $quantities = $this->input->post('quantity');

        if (empty($items)) {
            $this->session->set_flashdata('error', "Veuillez choisir au moins un produit.");
            redirect('qrorder/' . $table_id);
        }

        // Création commande QR
        $orderData = [
            'table_no' => $table_id,
            'order_type' => 'QR',
            'order_date' => date('Y-m-d H:i:s'),
            'total_amount' => 0,
        ];
        $this->db->insert('customer_order', $orderData);
        $order_id = $this->db->insert_id();

        $total = 0;
        foreach ($items as $i => $pid) {
            $qty = intval($quantities[$i]);
            $product = $this->db->where('product_id', $pid)->get('product_information')->row();
            if ($product) {
                $lineTotal = $product->price * $qty;
                $total += $lineTotal;
                $this->db->insert('order_details', [
                    'order_id' => $order_id,
                    'product_id' => $pid,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'total_price' => $lineTotal
                ]);
            }
        }

        // Mise à jour du total
        $this->db->where('order_id', $order_id)->update('customer_order', ['total_amount' => $total]);

        $data['message'] = "Votre commande a bien été enregistrée !";
        $this->load->view('qrapp/qrpublic/success', $data);
    }
}
