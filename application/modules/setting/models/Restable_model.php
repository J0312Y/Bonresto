<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restable_model extends CI_Model {
	
	private $table = 'rest_table';
 
	public function create($data = array())
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	public function addrow($data = array()){
			$this->db->insert('table_setting', $data);
		}
	public function delete($id = null)
	{
		$this->db->where('tableid',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
	
	public function deleterow($id = null)
	{
		$this->db->where('tableid',$id)
			->delete('table_setting');

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 




	public function update($data = array())
	{
		return $this->db->where('tableid',$data["tableid"])
			->update($this->table, $data);
	}

    public function read($limit = null, $start = null)
	{
	    $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('tableid', 'desc');
       
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	} 

	public function findById($id = null)
	{ 
		return $this->db->select("*")->from($this->table)
			->where('tableid',$id) 
			->get()
			->row();
	} 
	public function ckeckseting($id = null)
		{ 
			return $this->db->select("*")->from('table_setting')
				->where('tableid',$id) 
				->get()
				->row();
		} 
 
public function countlist()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();  
        }
        return false;
	}
public function tablelist(){
		$this->db->select('rest_table.*,table_setting.settingid,table_setting.tableid as settingtable,table_setting.iconpos');
        $this->db->from($this->table);
		$this->db->join('table_setting','table_setting.tableid=rest_table.tableid','left');
        $this->db->order_by('table_setting.settingid', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	}
public function sortingtable($data = array()){
	   
		return $this->db->where('tableid',$data["tableid"])
			->update('table_setting', $data);
	}
public function createfloor($data = array())
	{
		$this->db->insert('tbl_tablefloor', $data);
		return $this->db->insert_id();
	}
public function updatefloor($data = array())
	{
		return $this->db->where('tbfloorid',$data["tbfloorid"])
			->update('tbl_tablefloor', $data);
	}

    public function readfloor()
	{
	    $this->db->select('*');
        $this->db->from('tbl_tablefloor');
        $this->db->order_by('tbfloorid', 'desc');
    
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	} 

	public function findByfloorId($id = null)
	{ 
		return $this->db->select("*")->from('tbl_tablefloor')
			->where('tbfloorid',$id) 
			->get()
			->row();
	}
	public function deletefloor($id = null)
	{
		$this->db->where('tbfloorid',$id)
			->delete('tbl_tablefloor');

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
	
/***For Room Setting on QR*************/
public function createroom($data = array())
	{
		$this->db->insert('tbl_room', $data);
		return $this->db->insert_id();
	}
public function updateroom($data = array())
	{
		return $this->db->where('id',$data["id"])
			->update('tbl_room', $data);
	}

    public function readroom()
	{
	    $this->db->select('tbl_room.*,tbl_tablefloor.floorName');
        $this->db->from('tbl_room');
		$this->db->join('tbl_tablefloor','tbl_tablefloor.tbfloorid=tbl_room.floorno','left');
        $this->db->order_by('id', 'asc');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	} 

	public function findByroomId($id = null)
	{ 
		return $this->db->select("*")->from('tbl_room')
			->where('id',$id) 
			->get()
			->row();
	}
	public function deleteroom($id = null)
	{
		$this->db->where('id',$id)
			->delete('tbl_room');

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function updateQrCode($tableid, $qr_path)
	{
		return $this->db->where('tableid', $tableid)
			->update($this->table, ['qr_code' => $qr_path]);
	}

	public function readAll()
	{
		return $this->db->select('*')->from($this->table)
			->order_by('tableid', 'asc')
			->get()->result();
	}

	/**
	 * Get all tables with their layout settings for a given floor
	 */
	public function get_tables_with_settings($floor_id = null)
	{
		$this->db->select('rest_table.*, table_setting.settingid, table_setting.pos_x, table_setting.pos_y, table_setting.width, table_setting.height, table_setting.shape, table_setting.rotation');
		$this->db->from($this->table);
		$this->db->join('table_setting', 'table_setting.tableid = rest_table.tableid', 'left');
		if ($floor_id) {
			$this->db->where('rest_table.floor', $floor_id);
		}
		$this->db->order_by('rest_table.tableid', 'asc');
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : [];
	}

	/**
	 * Save table layout positions from the floor plan editor
	 */
	public function save_table_layout($tables)
	{
		foreach ($tables as $t) {
			$existing = $this->db->select('settingid')->from('table_setting')
				->where('tableid', $t['tableid'])->get()->row();

			$data = [
				'tableid'  => $t['tableid'],
				'pos_x'    => isset($t['pos_x']) ? (int)$t['pos_x'] : 0,
				'pos_y'    => isset($t['pos_y']) ? (int)$t['pos_y'] : 0,
				'width'    => isset($t['width']) ? (int)$t['width'] : 80,
				'height'   => isset($t['height']) ? (int)$t['height'] : 80,
				'shape'    => isset($t['shape']) ? $t['shape'] : 'square',
				'rotation' => isset($t['rotation']) ? (int)$t['rotation'] : 0,
			];

			if ($existing) {
				$this->db->where('settingid', $existing->settingid)->update('table_setting', $data);
			} else {
				$data['iconpos'] = '';
				$this->db->insert('table_setting', $data);
			}
		}
		return true;
	}

}
