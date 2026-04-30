<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentSetting extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('permission');
        $this->permission->check_admin_auth();
        $this->load->model('PaymentSetting_model');
    }

    public function index()
    {
        $data['title'] = 'Payment Settings';
        $data['payments'] = $this->PaymentSetting_model->get_all_methods();
        $data['module'] = 'qrapp';
        $data['page'] = 'payment_setting_list';
        echo Modules::run('template/layout', $data);
    }

    public function toggle_status()
    {
        $id = $this->input->post('id', true);
        $method = $this->PaymentSetting_model->get_method($id);

        if ($method) {
            $new_status = $method->is_active ? 0 : 1;
            $this->PaymentSetting_model->update_status($id, $new_status);
            echo json_encode(['status'=>1,'new_status'=>$new_status]);
        } else {
            echo json_encode(['status'=>0]);
        }
    }
}
