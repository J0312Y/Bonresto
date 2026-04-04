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
                'message' => 'Données de requête invalides',
                'bgColor' => '2'
            ));
            return;
        }

        // Valider les données requises
        $required_fields = array('order_id', 'payment_method_id', 'phone_number');
        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => "Champ requis manquant: $field",
                    'bgColor' => '2'
                ));
                return;
            }
        }

        // Traiter le paiement
        $result = $this->App_android_model->process_mobile_payment(
            $data['order_id'],
            $data
        );

        // Ensure bgColor is set on success/error responses
        if (!isset($result['bgColor'])) {
            $result['bgColor'] = ($result['status'] === 'success') ? '1' : '2';
        }

        echo json_encode($result);
    }

    public function webhook_airtel() {
        // Implement Airtel Money webhook handler
        $json = file_get_contents('php://input');
        log_message('debug', 'Airtel Money Webhook Received: ' . $json);

        $data = json_decode($json, true);
        if (!$data) {
            log_message('error', 'Airtel webhook: invalid JSON');
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
            return;
        }

        // Example expected payload handling: adapt based on Airtel's webhook structure
        $transactionId = $data['transaction_id'] ?? null;
        $status = $data['status'] ?? null;

        if ($transactionId) {
            // update mobile_transactions table if present
            if ($this->App_android_model->db->table_exists('mobile_transactions')) {
                $update = ['status' => $status ?? 'unknown', 'updated_at' => date('Y-m-d H:i:s')];
                $this->App_android_model->db->where('transaction_id', $transactionId)->update('mobile_transactions', $update);
            }
        }

        // Respond with 200 OK to acknowledge receipt
        echo json_encode(['status' => 'ok']);
    }

    public function webhook_mtn() {
        // TODO: Implémenter le webhook MTN Money
        $json = file_get_contents('php://input');
        log_message('debug', 'MTN Money Webhook: ' . $json);
        echo "OK";
    }
}