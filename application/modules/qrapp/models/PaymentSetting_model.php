<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentSetting_model extends CI_Model {

    private $table = 'payment_method';

    public function get_all_methods()
    {
        return $this->db->order_by('payment_method_id','asc')->get($this->table)->result();
    }

    public function get_method($id)
    {
        return $this->db->where('payment_method_id', $id)->get($this->table)->row();
    }

    public function update_status($id, $status)
    {
        $this->db->where('payment_method_id', $id)
                 ->update($this->table, ['is_active'=>$status]);
    }
}
