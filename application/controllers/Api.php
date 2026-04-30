<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function save_fcm_token()
    {
        // Require an active user session before accepting tokens
        if (!$this->session->userdata('isLogIn') && !$this->session->userdata('customer_id')) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['fcm_token'])) {
            $token = substr(preg_replace('/[^a-zA-Z0-9\-_:]+/', '', $input['fcm_token']), 0, 255);
            $data  = ['token' => $token, 'created_at' => date('Y-m-d H:i:s')];
            $this->db->insert('fcm_tokens', $data);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No token received']);
        }
    }
}
