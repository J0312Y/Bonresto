<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrorder_model extends CI_Model {

    public function get_all_qr_orders_with_table() {
        $this->db->select('o.*, t.tablename, c.customer_name, w.name as waiter_name');
        $this->db->from('customer_order o');
        $this->db->join('tablelist t', 'o.table_no = t.tableid', 'left');
        $this->db->join('customer c', 'o.customer_id = c.customer_id', 'left');
        $this->db->join('waiter w', 'o.waiter_id = w.waiter_id', 'left');
        $this->db->where('t.qr_code IS NOT NULL'); // filtrer uniquement les tables avec QR Code
        $this->db->order_by('o.order_id', 'DESC');
        return $this->db->get()->result();
    }
}
