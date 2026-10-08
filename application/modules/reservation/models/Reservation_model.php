<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_model extends CI_Model {
	
	private $table = 'tblreservation';
 
	public function create($data = array())
	{
		return $this->db->insert($this->table, $data);
	}
	public function insertcustomer($data = array(), $mobile = "")
	{
    $this->db->select('*');
    $this->db->from('customer_info');
    $this->db->where('customer_phone', $mobile);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        // row() retourne directement un objet et évite l’erreur "array"
        $customer = $query->row();
        return $customer->customer_id; 
    } 
    else {
        $this->db->insert('customer_info', $data);
        return $this->db->insert_id();
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
	
			$list[0] = 'Select Table';
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
	public function bookedpeople($newdate = null, $gettime = null){
		// Valeurs liees plutot que concatenees : la clause etait construite
		// par interpolation avec l'echappement desactive, donc injectable.
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
		// Meme correction que Hungry_model::checkavailtable() :
		//  - valeurs liees au lieu d'etre concatenees (injection SQL) ;
		//  - le filtre `person_capicity='$nopeople'` est supprime : une
		//    reservation occupe sa table quel que soit le nombre de couverts,
		//    et l'egalite exacte laissait passer les conflits.
		if ($newdate === null) {
			$bookdate = str_replace('/','-',$this->input->post('getdate'));
			$newdate  = date('Y-m-d' , strtotime($bookdate));
		}
		$gettime = $gettime ?? $this->input->post('time');
		$this->db->select('tableid');
        $this->db->from('tblreservation');
		$this->db->where('reserveday', $newdate);
		// Bornes : `formtime <` ratait la reservation qui COMMENCE a l'heure
		// demandee — une table prise a 20h00 restait proposee a 20h00. La
		// borne de fin reste stricte : une reservation qui se termine a 20h00
		// libere bien la table a 20h00.
		$this->db->where('formtime <=', $gettime);
		$this->db->where('totime >', $gettime);
		$this->db->where_in('status', RESERVATION_STATUTS_OCCUPANTS);
		$query = $this->db->get();
		$totalid = [];
		 if ($query->num_rows() > 0) {
           $gettable=$query->result();
		   foreach($gettable as $selectedtable){
			   $totalid[] = $selectedtable->tableid;
			   }
			return $totalid;
        }
        return [];
		}
	public function checkfree($invalue,$person){
		$this->db->select('*');
        $this->db->from('rest_table');
		if (!empty($invalue)) {
			$this->db->where_not_in('tableid', (array) $invalue);
		}
		// Etait une egalite stricte : une demande pour 3 ne se voyait jamais
		// proposer une table de 4, alors qu'elle convient. Tri croissant pour
		// ne pas gaspiller les grandes tables sur les petites tablees.
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

	// ── Arrival system ─────────────────────────────────────────────────

	/**
	 * Today's confirmed reservations with customer, table info and pre-order items.
	 */
	public function get_today_reservations()
	{
		$reservations = $this->db
			->select('r.*, c.customer_name, c.customer_phone, c.customer_email, c.customer_token,
			          t.tablename, t.person_capicity as table_capacity')
			->from('tblreservation r')
			->join('customer_info c', 'c.customer_id = r.cid', 'left')
			->join('rest_table t', 't.tableid = r.tableid', 'left')
			->where('r.reserveday', date('Y-m-d'))
			->where('r.status', 2)
			->where('r.arrival_status', 0)
			->order_by('r.formtime', 'ASC')
			->get()->result();

		if (!$reservations) return [];

		foreach ($reservations as &$res) {
			$res->preorder_items = $this->db
				->select('p.*, f.kitchenid, k.kitchen_name')
				->from('reservation_preorder p')
				->join('item_foods f', 'f.ProductsID = p.product_id', 'left')
				->join('tbl_kitchen k', 'k.kitchenid = f.kitchenid', 'left')
				->where('p.reservation_id', $res->reserveid)
				->get()->result();
		}

		return $reservations;
	}

	/**
	 * Single reservation with its pre-order items (including kitchenid).
	 */
	public function get_reservation_with_preorder($reserveid)
	{
		$reservation = $this->findById($reserveid);
		if (!$reservation) return null;

		$reservation->customer = $this->findByCusId($reservation->cid);
		$reservation->table    = $this->findBytableId($reservation->tableid);

		$reservation->preorder_items = $this->db
			->select('p.*, f.kitchenid, f.cookedtime')
			->from('reservation_preorder p')
			->join('item_foods f', 'f.ProductsID = p.product_id', 'left')
			->where('p.reservation_id', $reserveid)
			->get()->result();

		return $reservation;
	}

	/**
	 * Find a matching reservation for a table today.
	 * Returns the reservation with a 'match_type' property:
	 *   'on_time'  — within ±30 min window (check-in OK)
	 *   'early'    — client arrived before the window
	 *   'late'     — client arrived after the window
	 *   null       — no reservation found
	 */
	public function match_reservation_by_table($table_id)
	{
		$now_ts    = time();
		$now       = date('H:i:s', $now_ts);

		// Find any confirmed reservation for this table today
		$reservation = $this->db
			->select('r.*, c.customer_name, c.customer_phone, t.tablename')
			->from('tblreservation r')
			->join('customer_info c', 'c.customer_id = r.cid', 'left')
			->join('rest_table t', 't.tableid = r.tableid', 'left')
			->where('r.tableid', $table_id)
			->where('r.reserveday', date('Y-m-d'))
			->where('r.status', 2)
			->where('r.arrival_status', 0)
			->order_by('ABS(TIME_TO_SEC(TIMEDIFF(r.formtime, "' . $now . '")))', 'ASC', FALSE)
			->limit(1)
			->get()->row();

		if (!$reservation) return null;

		// Use timestamps for comparison to avoid midnight crossing issues
		$res_ts = strtotime(date('Y-m-d') . ' ' . $reservation->formtime);
		$diff_seconds = $now_ts - $res_ts;

		if (abs($diff_seconds) <= 1800) {
			// Within ±30 min window
			$reservation->match_type = 'on_time';
		} elseif ($diff_seconds < 0) {
			// Client arrived more than 30 min before reservation
			$reservation->match_type = 'early';
		} else {
			// Client arrived more than 30 min after reservation
			$reservation->match_type = 'late';
		}

		return $reservation;
	}

	/**
	 * Mark reservation as arrived and store the converted order_id.
	 */
	public function mark_arrived($reserveid, $order_id)
	{
		return $this->db->where('reserveid', $reserveid)
			->where('arrival_status', 0)
			->update($this->table, [
				'arrival_status'     => 1,
				'arrival_time'       => date('Y-m-d H:i:s'),
				'converted_order_id' => $order_id,
				'qr_checkin_pending' => 0,
			]);
	}

	/**
	 * Mark reservation as no-show.
	 */
	public function mark_noshow($reserveid)
	{
		return $this->db->where('reserveid', $reserveid)
			->update($this->table, ['arrival_status' => 2, 'qr_checkin_pending' => 0]);
	}
}
