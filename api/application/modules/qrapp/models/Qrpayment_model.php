<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrpayment_model extends CI_Model {

    public function get_all_methods() {
        return $this->db->select('*')
            ->from('payment_method')
            ->order_by('payment_method_id', 'asc')
            ->get()
            ->result();
    }

    public function update_status($id, $status) {
        return $this->db->where('payment_method_id', $id)
                        ->update('payment_method', ['is_active' => $status]);
    }
}
