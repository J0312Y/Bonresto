<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function save_fcm_token()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        log_message('debug', json_encode($input));
        if(isset($input['fcm_token'])) {
            $data = ['token' => $input['fcm_token'], 'created_at' => date('Y-m-d H:i:s')];
            $this->db->insert('fcm_tokens', $data);

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No token received']);
        }
    }
}
