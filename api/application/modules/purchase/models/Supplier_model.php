<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {
	
	private $table = 'supplier';
 
	public function create($data = array())
	{
		return $this->db->insert($this->table, $data);
		
	}
	public function delete($id = null)
	{
		$this->db->where('supid',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}
	
	 //Supplier Previous balance adjustment
      public function previous_balance_add($balance, $supplier_id, $sino) {
        $data = array(
            'transaction_id' => $sino,
            'supplier_id'    => $supplier_id,
            'chalan_no'      => 'Adjustment ',
            'deposit_no'     => NULL,
            'amount'         => $balance,
            'description'    => "Previous adjustment with software",
            'payment_type'   => "NA",
            'cheque_no'      => "NA",
            'date'           => date("Y-m-d"),
            'status'         => 1,
            'd_c'            => 'c'
        );
     
        $this->db->insert('supplier_ledger', $data);
    }

	public function update($data = array())
	{
		return $this->db->where('supid',$data["supid"])
			->update($this->table, $data);
	}

    public function read($limit = null, $start = null)
	{
	   $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('supid', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	} 
	
	public function supplierlist()
	{
	   $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('supid', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	} 

	public function findById($id = null)
	{ 
		return $this->db->select("*")->from($this->table)
			->where('supid',$id) 
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
	
	public function customerlist($limit = null, $start = null)
	{
	   $this->db->select('*');
        $this->db->from('customer_info');
        $this->db->order_by('customer_id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();    
        }
        return false;
	}
	public function countcustomerlist()
	{
		$this->db->select('*');
        $this->db->from('customer_info');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();  
        }
        return false;
	} 
	    // count ledger info
    public function count_supplier_product_info() {
        $this->db->select('*');
        $this->db->from('supplier_ledger');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }
	public function supplier_ledger_report($supplierid= null,$fromdate= null,$todate= null,$limit = null, $start = null){
			$this->db->select('supplier_ledger.*,supplier.supName');
			$this->db->from('supplier_ledger');
			$this->db->join('supplier','supplier.supid=supplier_ledger.supplier_id','left');
			if(!empty($supplierid)){
			$this->db->where('supplier_ledger.supplier_id', $supplierid);
			$this->db->where(array('date >=' => $fromdate, 'date <=' => $todate));
			}
			$this->db->limit($limit, $start);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();    
			}
			return false;
		}
    //To get certain supplier's chalan info by which this company got products day by day
    public function suppliers_ledger($supplier_id, $start, $end) {
        $this->db->select('supplier_ledger.*,supplier.supName');
        $this->db->from('supplier_ledger');
		$this->db->join('supplier','supplier.supid=supplier_ledger.supplier_id','left');
        $this->db->where('supplier_ledger.supplier_id', $supplier_id);
        $this->db->where(array('date >=' => $start, 'date <=' => $end));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
	public function supplier_duepaid_report($supplier_id) {
        $this->db->select('*');
        $this->db->from('supplier_ledger');
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
	public function suppliers_balance($supplier_id) {
        $this->db->select('*');
        $this->db->from('supplier_ledger');
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
}
