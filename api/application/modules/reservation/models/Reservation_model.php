<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_model extends CI_Model {
	
	private $table = 'tblreservation';
 
	public function create($data = array())
	{
		return $this->db->insert($this->table, $data);
	}
	public function insertcustomer($data = array(), $mobile = ""){
		$this->db->select('*');
        $this->db->from('customer_info');
		$this->db->where('customer_phone',$mobile);
		 $query = $this->db->get();
        if ($query->num_rows() > 0) {
           $customer=$query->result();
		  return $returnid =   $customer->customer_id;
        } 
		else{
		$this->db->insert('customer_info', $data);
		return $returnid = $this->db->insert_id();
		}
		}
	public function delete($id = null)
	{
		$this->db->where('reserveid',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
	public function update($data = array())
	{
		return $this->db->where('reserveid',$data["reserveid"])
			->update($this->table, $data);
	}

    public function read_reservation($limit = null, $start = null)
	{
	    $this->db->select('tblreservation.*,customer_info.*,rest_table.tablename,rest_table.person_capicity as tablecapacity');
        $this->db->from($this->table);
		$this->db->join('customer_info','customer_info.customer_id = tblreservation.cid','left');
		$this->db->join('rest_table','rest_table.tableid = tblreservation.tableid','left');
        $this->db->order_by('reserveid', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	} 

	public function findById($id = null)
	{ 
		return $this->db->select("*")->from($this->table)
			->where('reserveid',$id) 
			->get()
			->row();
	} 
	public function findByCusId($id = null)
	{ 
		return $this->db->select("*")->from('customer_info')
			->where('customer_id',$id) 
			->get()
			->row();
	}
public function findBytableId($id = null)
	{ 
		return $this->db->select("*")->from('rest_table')
			->where('tableid',$id) 
			->get()
			->row();
	}
public function count_reservation()
	{
		$this->db->select('tblreservation.*,customer_info.*,rest_table.tablename,rest_table.person_capicity');
        $this->db->from($this->table);
		$this->db->join('customer_info','customer_info.customer_id = tblreservation.cid','left');
		$this->db->join('rest_table','rest_table.tableid = tblreservation.tableid','left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();  
        }
        return false;
	}
 public function customer_dropdown()
	{
		$data = $this->db->select("*")
			->from('customer_info')
			->get()
			->result();

		$list[''] = 'Select Customer';
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->customer_id] = $value->customer_name;
			return $list;
		} else {
			return false; 
		}
	}
	public function table_dropdown()
		{
			$data = $this->db->select("*")
				->from('rest_table')
				->get()
				->result();
	
			$list[''] = 'Select Table';
			if (!empty($data)) {
				foreach($data as $value)
					$list[$value->tableid] = $value->tablename;
				return $list;
			} else {
				return false; 
			}
		}
	
	public function read_gettable(){
			$data = $this->db->select("*")
				->from('rest_table')
				->get()
				->result();
				
				return $data;
		}
	// Sixieme copie de la logique de disponibilite du projet. Memes defauts
	// corriges qu'ailleurs : injection SQL par concatenation, filtre
	// `person_capicity` en egalite stricte, retour en chaine la ou
	// where_not_in() attend un tableau, et checkfree() en egalite exacte
	// sur la capacite de table.
	public function bookedpeople($newdate = null, $gettime = null){
		$newdate = $newdate ?? $this->input->post('getdate');
		$gettime = $gettime ?? $this->input->post('time');
		$this->db->select('SUM(person_capicity) as totalperson');
        $this->db->from('tblreservation');
		$this->db->where('reserveday', $newdate);
		$this->db->where('formtime <=', $gettime);
		$this->db->where('totime >=', $gettime);
		$this->db->where_in('status', RESERVATION_STATUTS_OCCUPANTS);
		$query = $this->db->get();
		return $query->row();
		}
	public function checktable($id){
		$this->db->select('tableid');
        $this->db->from('rest_table');
        $this->db->where('tableid', $id);
		$this->db->where('status', 1);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
            return $query->row();    
        }
        return false;
		}  
	public function checkavailtable($newdate = null, $gettime = null, $nopeople = null){
		if ($newdate === null) {
			$bookdate = str_replace('/','-',$this->input->post('getdate'));
			$newdate  = date('Y-m-d' , strtotime($bookdate));
		}
		$gettime = $gettime ?? $this->input->post('time');
		$this->db->select('tableid');
        $this->db->from('tblreservation');
		$this->db->where('reserveday', $newdate);
		$this->db->where('formtime <', $gettime);
		$this->db->where('totime >', $gettime);
		$this->db->where_in('status', RESERVATION_STATUTS_OCCUPANTS);
		$query = $this->db->get();
		$totalid = [];
		foreach($query->result() as $selectedtable){
			$totalid[] = $selectedtable->tableid;
		}
		return $totalid;
		}
	public function checkfree($invalue,$person){
		$this->db->select('*');
        $this->db->from('rest_table');
		if (!empty($invalue)) {
			$this->db->where_not_in('tableid', (array) $invalue);
		}
		$this->db->where('person_capicity>=', $person);
		$this->db->order_by('person_capicity', 'ASC');
		$query = $this->db->get();
		 if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
		}
 public function getproduct(){
	 
	    $this->db->select('product_tbl.product_name,visit_comp_product_gap.product_id,visit_comp_product_gap.comp_product_name,visit_comp_product_gap.comp_product_qty');
        $this->db->from('product_tbl');
		$this->db->join('visit_comp_product_gap','visit_comp_product_gap.product_id = product_tbl.product_id','Inner');
		$this->db->where('visit_comp_product_gap.comp_product_name!=','none');
		$this->db->group_by('visit_comp_product_gap.product_id'); 
        $this->db->order_by('visit_comp_product_gap.product_id', 'Asc');
        $query = $this->db->get();
        
            $allproduct= $query->result();
			$singleproduct=''; 
			foreach($allproduct as $single){
				$singleproduct.="'".$single->product_name."',";
				}  
			$singleproduct=trim($singleproduct,',');
			return  $singleproduct;
	 }
  public function getquantity(){
	  $this->db->select('product_tbl.product_name,visit_comp_product_gap.product_id,visit_comp_product_gap.comp_product_name,visit_comp_product_gap.comp_product_qty,SUM(visit_comp_product_gap.comp_product_qty) as qty');
        $this->db->from('product_tbl');
		$this->db->join('visit_comp_product_gap','visit_comp_product_gap.product_id = product_tbl.product_id','Inner');
		$this->db->where('visit_comp_product_gap.comp_product_name!=','none');
		$this->db->group_by('visit_comp_product_gap.comp_product_name'); 
        $this->db->order_by('visit_comp_product_gap.product_id', 'Asc');
        $query = $this->db->get();
        
            $allproduct= $query->result();
			$singleproduct='';
		 
			foreach($allproduct as $single){
				 $singleproduct.="{ name: '$single->comp_product_name', data: [5, 3, 4, 7, 2]},";
				 }  
			$singleproduct=trim($singleproduct,',');
			
			return  $singleproduct;
	  }
	public function alloffdays()
	{
	    $this->db->select('*');
        $this->db->from('reservationofday');
        $this->db->order_by('offdayid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	}
	public function unavailablecreate($data = array())
	{
		return $this->db->insert('reservationofday', $data);
	}
	public function deleteunavailable($id = null)
	{
		$this->db->where('offdayid',$id)
			->delete('reservationofday');

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	} 
	public function updateunavail($data = array())
	{
		return $this->db->where('offdayid',$data["offdayid"])
			->update('reservationofday', $data);
	}
	public function findByIdunavail($id = null)
	{ 
		return $this->db->select("*")->from('reservationofday')
			->where('offdayid',$id) 
			->get()
			->row();
	}
  public function read($select_items, $table, $where_array)
    {
	    $this->db->select($select_items);
        $this->db->from($table);
        foreach ($where_array as $field => $value) {
            $this->db->where($field, $value);
        }
        return $this->db->get()->row();
    }
	public function updatesetting($data = array())
	{
		return $this->db->where('id',$data["id"])->update('setting', $data);
	} 
}
