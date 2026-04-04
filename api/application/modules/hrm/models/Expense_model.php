<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_model extends CI_Model {

    public function expense_insert(){
        $voucher_no = date('Ymdhis');
        $expense_type = $this->input->post('expense_type');
        $pay_type = $this->input->post('paytype');
        $Credit   = $this->input->post('amount');
        $VDate    = $this->input->post('dtpDate');
        $bank_id = $this->input->post('bank_id');
       
        // bank summary credit
        $data = array(
            'date'        => $VDate,
            'ac_type'     => 'Credit (-)',
            'bank_id'     => $bank_id,
            'description' => $expense_type.' Expense',
            'deposite_id' => $voucher_no,
            'dr'          =>  null,
            'cr'          => (!empty($Credit) ? $Credit : null),
            'ammount'     => $Credit,
            'status'      => 1
        );

        $expense = array(
            'voucher_no'     =>  $voucher_no,
            'type'           =>  $expense_type,
            'date'           =>  $VDate,
            'amount'         =>  $Credit,
        ); 
        
        $this->db->insert('expense',$expense);
            
        if($pay_type == 1){

        }else{
            $this->db->insert('bank_summary', $data);
        }

        return true;
    }

        public function expense_list($limit = null, $start = null)
    {
             return $this->db->select('*')   
            ->from('expense')
            ->order_by('id', 'desc')
            ->limit($limit, $start)
            ->get()
            ->result_array();
    }

    public function expense_delete($id = null)
    {
        $this->db->where('voucher_no',$id)
            ->delete('expense');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    } 
    // expense item delete
    public function expense_item_delete($id = null){
    
        $this->db->where('id',$id)
            ->delete('expense_item');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function expense_item_insert(){
        $expense_type = $this->input->post('expense_item_name');
        
        $expense = array(
            'expense_item_name' =>  $expense_type,
        ); 
		
        $this->db->insert('expense_item',$expense);
              
        return true;
    }

     
    // expense item list
    public function expense_item_list(){
         return $this->db->select('*')   
            ->from('expense_item')
            ->order_by('id', 'desc')
            ->get()
            ->result_array();
    }
    // bank list
    public function bank_list(){
     return $this->db->select('*')   
            ->from('tbl_bank')
            ->get()
            ->result_array();
    }

      public function get_expense_statement($expense,$from_date,$to_date){
		 $condition="date BETWEEN '".$from_date."' AND '".$to_date."'";
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('type', $expense);
        $this->db->where($condition);
        $query = $this->db->get();
	
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
}
