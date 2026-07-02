<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrtable_model extends CI_Model {

    private $table = 'rest_table'; // <- on utilise rest_table

    public function get_all_tables()
    {
        return $this->db->select('*')->from($this->table)->get()->result();
    }

    public function get_table_by_id($table_id)
    {
        return $this->db->select('*')->from($this->table)->where('tableid', $table_id)->get()->row();
    }

    public function update_qr_code($table_id, $qr_code)
    {
        return $this->db->where('tableid', $table_id)->update($this->table, ['qr_code' => $qr_code]);
    }
}
