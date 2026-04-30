<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrpayment extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('qrapp/Qrpayment_model');
        if (!$this->session->userdata('isAdmin')) {
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = 'QR Payment Setting';
        $data['module'] = "qrapp";
        $data['payment_methods'] = $this->Qrpayment_model->get_all_methods();
        $data['page'] = "qr_payment_setting";
        echo Modules::run('template/layout', $data);
    }

    public function update_status() {
        $id = $this->input->post('id', TRUE);
        $status = $this->input->post('status', TRUE);
        $this->Qrpayment_model->update_status($id, $status);
        echo json_encode(['success' => true]);
    }
}
