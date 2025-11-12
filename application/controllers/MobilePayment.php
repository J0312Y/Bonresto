<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MobilePayment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('App_android_model');
    }

    public function process() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Invalid request data'
            ));
            return;
        }

        // Valider les données requises
        $required_fields = array('order_id', 'payment_method_id', 'phone_number');
        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => "Missing required field: $field"
                ));
                return;
            }
        }

        // Traiter le paiement
        $result = $this->App_android_model->process_mobile_payment(
            $data['order_id'],
            $data
        );

        echo json_encode($result);
    }

    public function webhook_airtel() {
        // TODO: Implémenter le webhook Airtel Money
        $json = file_get_contents('php://input');
        log_message('debug', 'Airtel Money Webhook: ' . $json);
        echo "OK";
    }

    public function webhook_mtn() {
        // TODO: Implémenter le webhook MTN Money
        $json = file_get_contents('php://input');
        log_message('debug', 'MTN Money Webhook: ' . $json);
        echo "OK";
    }
}