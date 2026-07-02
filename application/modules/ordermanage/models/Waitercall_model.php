<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Waitercall_model extends CI_Model {

    public function create($data)
    {
        $this->db->insert('waiter_call', $data);
        return $this->db->insert_id();
    }

    public function getPending()
    {
        return $this->db->select('waiter_call.*, rest_table.tablename')
            ->from('waiter_call')
            ->join('rest_table', 'rest_table.tableid = waiter_call.table_id', 'left')
            ->where('waiter_call.status', 0)
            ->order_by('waiter_call.created_at', 'DESC')
            ->get()->result();
    }

    public function getPendingCount()
    {
        return $this->db->where('status', 0)->count_all_results('waiter_call');
    }

    public function getAll($limit = 50)
    {
        return $this->db->select('waiter_call.*, rest_table.tablename')
            ->from('waiter_call')
            ->join('rest_table', 'rest_table.tableid = waiter_call.table_id', 'left')
            ->order_by('waiter_call.created_at', 'DESC')
            ->limit($limit)
            ->get()->result();
    }

    public function acknowledge($id, $user_id)
    {
        return $this->db->where('id', $id)->update('waiter_call', [
            'status'          => 1,
            'acknowledged_at' => date('Y-m-d H:i:s'),
            'acknowledged_by' => $user_id
        ]);
    }

    public function complete($id)
    {
        return $this->db->where('id', $id)->update('waiter_call', ['status' => 2]);
    }

    public function hasRecentCall($table_id, $call_type, $minutes = 5)
    {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));
        return $this->db->where('table_id', $table_id)
            ->where('call_type', $call_type)
            ->where('status', 0)
            ->where('created_at >=', $cutoff)
            ->count_all_results('waiter_call') > 0;
    }
}
