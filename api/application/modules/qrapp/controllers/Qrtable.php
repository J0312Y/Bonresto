<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrtable extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('permission');
        $this->permission->check_admin_auth();
        $this->load->model('Qrtable_model');
        $this->load->library('ciqrcode');
    }
    
    // Liste des tables QR
    public function index()
    {
        $data['title']  = 'Liste des Tables QR';
        $data['tables'] = $this->Qrtable_model->get_all_tables();
        $data['module'] = "qrapp";
        $data['page']   = "qrtable_list";
        echo Modules::run('template/layout', $data);
    }

    // Générer QR pour une seule table
    public function generate_qr($table_id)
    {
        $table = $this->Qrtable_model->get_table_by_id($table_id);
        if (!$table) {
            $this->session->set_flashdata('exception', 'Table introuvable.');
            redirect('qrapp/qrtable');
        }

        $qr_folder = FCPATH . 'uploads/qrcodes/';
        if (!file_exists($qr_folder)) mkdir($qr_folder, 0777, true);

        $qr_data = base_url('qr-menu/' . $table->tableid);
        $file_name = 'table_' . $table->tableid . '.png';
        $save_path = $qr_folder . $file_name;

        $params['data'] = $qr_data;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = $save_path;

        $this->ciqrcode->generate($params);
        $this->Qrtable_model->update_qr_code($table->tableid, $file_name);

        $this->session->set_flashdata('message', 'QR Code généré avec succès pour la table ' . $table->tablename);
        redirect('qrapp/qrtable');
    }

    // Générer tous les QR Codes pour les tables sans QR
    public function generate_all_qr()
    {
        $tables = $this->Qrtable_model->get_all_tables();
        $qr_folder = FCPATH . 'uploads/qrcodes/';
        if (!file_exists($qr_folder)) mkdir($qr_folder, 0777, true);

        $count = 0;
        foreach ($tables as $table) {
            if (empty($table->qr_code)) {
                $qr_data = base_url('qr-menu/' . $table->tableid);
                $file_name = 'table_' . $table->tableid . '.png';
                $save_path = $qr_folder . $file_name;

                $params['data'] = $qr_data;
                $params['level'] = 'H';
                $params['size'] = 10;
                $params['savename'] = $save_path;
                $this->ciqrcode->generate($params);

                $this->Qrtable_model->update_qr_code($table->tableid, $file_name);
                $count++;
            }
        }

        $this->session->set_flashdata('message', "$count QR Codes générés avec succès !");
        redirect('qrapp/qrtable');
    }

    // Imprimer tous les QR Codes
    public function print_qr()
    {
        $data['tables'] = $this->Qrtable_model->get_all_tables();
        $this->load->view('qr_print', $data);
    }
    public function update_payment_status()
{
    $id = $this->input->post('id');
    $is_active = $this->input->post('is_active');

    if ($id === null) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }

    $updated = $this->db->where('id', $id)
                        ->update('payment_method', ['is_active' => $is_active]);

    if ($updated) {
        $msg = $is_active ? 'Payment method activated' : 'Payment method deactivated';
        echo json_encode(['success' => true, 'message' => $msg]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }
}
    

}
