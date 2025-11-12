<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model {
	
	private $table = 'purchaseitem';

	public function __construct()
	{
		parent::__construct();
	}

	public function create()
	{
		// start transaction
		$this->db->trans_start();

		$saveid = $this->session->userdata('id');
		$p_id = $this->input->post('product_id');
		$payment_type = $this->input->post('paytype', true);
		$bankid = '';

		$pamount = $this->input->post('paidamount', true);
		if ($pamount === null || $pamount === '') {
			$pamount = $this->input->post('grand_total_price', true);
		}

		if ($payment_type == 2) {
			$bankid = $this->input->post('bank', true);
		}

		$purchase_date = $this->input->post('purchase_date');
		$newdate = $purchase_date ? date('Y-m-d', strtotime(str_replace('/', '-', $purchase_date))) : date('Y-m-d');
		$expire_date = $this->input->post('expire_date');
		$exdate = $expire_date ? date('Y-m-d', strtotime(str_replace('/', '-', $expire_date))) : null;

		$data = array(
			'invoiceid'				=>	$this->input->post('invoice_no', true),
			'suplierID'			    =>	$this->input->post('suplierid', true),
			'paymenttype'			=>  $payment_type,
			'total_price'	        =>	$this->input->post('grand_total_price', true),
			'paid_amount'	        =>	$pamount,
			'bankid'	            =>	$bankid,
			'details'	            =>	$this->input->post('purchase_details', true),
			'purchasedate'		    =>	$newdate,
			'purchaseexpiredate'	=>	$exdate,
			'savedby'			    =>	$saveid
		);

		$this->db->insert($this->table, $data);
		$returnid = $this->db->insert_id();

		$rate = (array) $this->input->post('product_rate', true) ?: array();
		$quantity = (array) $this->input->post('product_quantity', true) ?: array();
		$t_price = (array) $this->input->post('total_price', true) ?: array();

		if (!empty($p_id) && is_array($p_id)) {
			for ($i = 0, $n = count($p_id); $i < $n; $i++) {
				$product_quantity = isset($quantity[$i]) ? (float)$quantity[$i] : 0;
				$product_rate = isset($rate[$i]) ? (float)$rate[$i] : 0;
				$product_id = $p_id[$i];
				$total_price = isset($t_price[$i]) ? $t_price[$i] : 0;

				$data1 = array(
					'purchaseid'		=>	$returnid,
					'indredientid'		=>	$product_id,
					'quantity'			=>	$product_quantity,
					'price'				=>	$product_rate,
					'totalprice'		=>	$total_price,
					'purchaseby'		=>	$saveid,
					'purchasedate'		=>	$newdate,
					'purchaseexpiredate'=>	$exdate
				);

				if (!empty($product_quantity)) {
					/* add stock in ingredients */
					$this->db->set('stock_qty', 'stock_qty+' . (float)$product_quantity, FALSE);
					$this->db->where('id', $product_id);
					$this->db->update('ingredients');
					/* end add ingredients */
					$this->db->insert('purchase_details', $data1);
				}
			}
		}

		// Bank summary for credit
		$banksummary = array(
			'date'          =>  $newdate,
			'ac_type'       =>  'Credit(-)',
			'bank_id'       =>  $bankid,
			'description'   =>  'product purchase',
			'deposite_id'   =>  $this->input->post('invoice_no', true),
			'dr'            =>  null,
			'cr'            =>  $pamount,
			'ammount'       =>  $pamount,
			'status'        =>  1
		);

		$ledger = array(
			'transaction_id'  => $this->input->post('invoice_no', true),
			'chalan_no'       => $this->input->post('invoice_no', true),
			'supplier_id'     => $this->input->post('suplierid'),
			'amount'          => $this->input->post('grand_total_price'),
			'date'            => $newdate,
			'description'     => $this->input->post('purchase_details'),
			'status'          => 1,
			'd_c'             => 'c',
		);

		$ledger_debit = array(
			'transaction_id'  => $this->input->post('invoice_no', true),
			'chalan_no'       => $this->input->post('invoice_no', true),
			'supplier_id'     => $this->input->post('suplierid'),
			'amount'          => $pamount,
			'date'            =>  $newdate,
			'description'     =>  'Purchase From Supplier. ' . $this->input->post('purchase_details'),
			'status'          =>  1,
			'd_c'             => 'd',
		);

		$this->db->insert('supplier_ledger', $ledger);

		if ($payment_type == 1) {
			$this->db->insert('supplier_ledger', $ledger_debit);
		}
		if ($payment_type == 2) {
			$this->db->insert('bank_summary', $banksummary);
			$this->db->insert('supplier_ledger', $ledger_debit);
		}

		// complete transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			log_message('error', 'Purchase_model::create transaction failed. invoice: ' . $this->input->post('invoice_no', true));
			return false;
		}

		return true;
	}

	public function delete($id = null)
	{
		if ($id === null) {
			return false;
		}

		$this->db->where('purID', $id)
			->delete($this->table);

		$this->db->where('purchaseid', $id)
			->delete('purchase_details');

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function update()
	{
		// start transaction
		$this->db->trans_start();

		$id = $this->input->post('purID');
		if (empty($id)) {
			log_message('error', 'Purchase_model::update missing purID');
			return false;
		}

		$saveid = $this->session->userdata('id');
		$p_id = (array) $this->input->post('product_id', true);
		$payment_type = $this->input->post('paytype', true);
		$bankid = '';

		$pamount = $this->input->post('paidamount', true);
		if ($pamount === null || $pamount === '') {
			$pamount = $this->input->post('grand_total_price', true);
		}

		if ($payment_type == 2) {
			$bankid = $this->input->post('bank', true);
		}

		$oldinvoice = $this->input->post('oldinvoice', true);
		$oldsupplier = $this->input->post('oldsupplier', true);
		$length = count($p_id);
		$purchase_date = $this->input->post('purchase_date');
		$newdate = $purchase_date ? date('Y-m-d', strtotime(str_replace('/', '-', $purchase_date))) : date('Y-m-d');
		$expire_date = $this->input->post('expire_date');
		$exdate = $expire_date ? date('Y-m-d', strtotime(str_replace('/', '-', $expire_date))) : null;

		$data = array(
			'invoiceid'				=>	$this->input->post('invoice_no', true),
			'suplierID'			    =>	$this->input->post('suplierid', true),
			'paymenttype'			=>  $payment_type,
			'bankid'			    =>  $bankid,
			'total_price'	        =>	$this->input->post('grand_total_price', true),
			'paid_amount'	        =>	$pamount,
			'details'	            =>	$this->input->post('purchase_details', true),
			'purchasedate'		    =>	$newdate,
			'purchaseexpiredate'	=>	$exdate,
			'savedby'			    =>	$saveid
		);

		$this->db->where('purID', $id)
			->update($this->table, $data);

		$rate = (array) $this->input->post('product_rate', true) ?: array();
		$quantity = (array) $this->input->post('product_quantity', true) ?: array();
		$t_price = (array) $this->input->post('total_price', true) ?: array();

		if (!empty($p_id) && is_array($p_id)) {
			for ($i = 0, $n = count($p_id); $i < $n; $i++) {
				$product_quantity = isset($quantity[$i]) ? (float)$quantity[$i] : 0;
				$product_rate = isset($rate[$i]) ? (float)$rate[$i] : 0;
				$product_id = $p_id[$i];
				$total_price = isset($t_price[$i]) ? $t_price[$i] : 0;

				$this->db->select('*');
				$this->db->from('purchase_details');
				$this->db->where('purchaseid', $id);
				$this->db->where('indredientid', $product_id);
				$query = $this->db->get();

				if ($query->num_rows() > 0) {

					$dataupdate = array(
						'purchaseid'		=>	$id,
						'indredientid'		=>	$product_id,
						'quantity'			=>	$product_quantity,
						'price'				=>	$product_rate,
						'totalprice'		=>	$total_price,
						'purchaseby'		=>	$saveid,
						'purchasedate'		=>	$newdate,
						'purchaseexpiredate'=>	$exdate
					);

					if (!empty($product_quantity) || $product_quantity === 0) {
						/* update stock in ingredients by difference */
						$olderqty = $query->row();
						$older_qty_val = isset($olderqty->quantity) ? (float)$olderqty->quantity : 0;
						$addv = $product_quantity - $older_qty_val;
						$this->db->set('stock_qty', 'stock_qty+' . (float)$addv, FALSE);
						$this->db->where('id', $product_id);
						$this->db->update('ingredients');
						/* end update ingredients */
						$this->db->where('purchaseid', $id);
						$this->db->where('indredientid', $product_id);
						$this->db->update('purchase_details', $dataupdate);
					}
				} else {
					$data1 = array(
						'purchaseid'		=>	$id,
						'indredientid'		=>	$product_id,
						'quantity'			=>	$product_quantity,
						'price'				=>	$product_rate,
						'totalprice'		=>	$total_price,
						'purchaseby'		=>	$saveid,
						'purchasedate'		=>	$newdate
					);
					if (!empty($product_quantity)) {
						$this->db->insert('purchase_details', $data1);
						/* add to ingredients stock */
						$this->db->set('stock_qty', 'stock_qty+' . (float)$product_quantity, FALSE);
						$this->db->where('id', $product_id);
						$this->db->update('ingredients');
					}
				}
			}
		}

		// Remove purchase_details that are not present in posted p_id list
		$this->db->select('*');
		$this->db->from('purchase_details');
		$this->db->where('purchaseid', $id);
		$query = $this->db->get();
		$details = $query->result_array();
		$test = array();
		$k = 0;
		foreach ($details as $single) {
			$k++;
			$test[$k] = $single['indredientid'];
		}

		$result = array();
		if (!empty($test)) {
			$result = array_diff($test, $p_id);
		}

		if (!empty($result)) {
			foreach ($result as $delval) {
				// when deleting, optionally reduce stock_qty if needed (business rule)
				$this->db->where('indredientid', $delval);
				$this->db->where('purchaseid', $id);
				$this->db->delete('purchase_details');
			}
		}

		// Remove old ledger / bank_summary entries based on old invoice
		if (!empty($oldinvoice)) {
			$this->db->where('transaction_id', $oldinvoice)->delete('supplier_ledger');
			$this->db->where('deposite_id', $oldinvoice)->delete('bank_summary');
		}

		// Bank summary for credit
		$banksummary = array(
			'date'          =>  $newdate,
			'ac_type'       =>  'Credit(-)',
			'bank_id'       =>  $bankid,
			'description'   =>  'product purchase',
			'deposite_id'   =>  $this->input->post('invoice_no', true),
			'dr'            =>  null,
			'cr'            =>  $pamount,
			'ammount'       =>  $pamount,
			'status'        =>  1
		);

		$ledger = array(
			'transaction_id'  => $this->input->post('invoice_no', true),
			'chalan_no'       => $this->input->post('invoice_no', true),
			'supplier_id'     => $this->input->post('suplierid'),
			'amount'          => $this->input->post('grand_total_price'),
			'date'            => $newdate,
			'description'     => $this->input->post('purchase_details'),
			'status'          => 1,
			'd_c'             => 'c',
		);

		$ledger_debit = array(
			'transaction_id'  => $this->input->post('invoice_no', true),
			'chalan_no'       => $this->input->post('invoice_no', true),
			'supplier_id'     => $this->input->post('suplierid'),
			'amount'          => $pamount,
			'date'            =>  $newdate,
			'description'     =>  'Purchase From Supplier. ' . $this->input->post('purchase_details'),
			'status'          =>  1,
			'd_c'             => 'd',
		);

		$this->db->insert('supplier_ledger', $ledger);

		if ($payment_type == 1) {
			$this->db->insert('supplier_ledger', $ledger_debit);
		}
		if ($payment_type == 2) {
			$this->db->insert('bank_summary', $banksummary);
			$this->db->insert('supplier_ledger', $ledger_debit);
		}

		// complete transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			log_message('error', 'Purchase_model::update transaction failed. purID: ' . $id);
			return false;
		}

		return true;
	}

	public function makeproduction()
	{
		$saveid = $this->session->userdata('id');
		$p_id = (array) $this->input->post('product_id');
		$purchase_date = $this->input->post('purchase_date');
		$newdate = $purchase_date ? date('Y-m-d', strtotime(str_replace('/', '-', $purchase_date))) : date('Y-m-d');

		$data = array(
			'itemid'				=>	$this->input->post('foodid', true),
			'itemquantity'			=>	$this->input->post('pro_qty', true),
			'saveddate'		    	=>	$newdate,
			'savedby'			    =>	$saveid
		);

		$this->db->insert('production', $data);
		$returnid = $this->db->insert_id();
		$quantity = (array) $this->input->post('product_quantity');

		if (!empty($p_id) && is_array($p_id)) {
			for ($i = 0, $n = count($p_id); $i < $n; $i++) {
				$product_quantity = isset($quantity[$i]) ? (float)$quantity[$i] : 0;
				$product_id = $p_id[$i];

				$data1 = array(
					'productionid'		=>	$returnid,
					'ingredientid'		=>	$product_id,
					'qty'				=>	$product_quantity,
					'createdby'			=>	$saveid,
					'created_date'		=>	$newdate
				);

				if (!empty($product_quantity)) {
					$this->db->insert('production_details', $data1);
				}
			}
		}

		return true;
	}

	public function read($limit = null, $start = null)
	{
		$this->db->select('purchaseitem.*,supplier.supName');
		$this->db->from($this->table);
		$this->db->join('supplier', 'purchaseitem.suplierID = supplier.supid', 'left');
		$this->db->order_by('purID', 'desc');
		if ($limit !== null) {
			$this->db->limit($limit, $start);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
	}

	public function findById($id = null)
	{
		if ($id === null) return false;
		return $this->db->select("*")->from($this->table)
			->where('purID', $id)
			->get()
			->row();
	}

	public function settinginfo()
	{
		return $this->db->select("*")->from('setting')
			->get()
			->row();
	}

	public function currencysetting($id = null)
	{
		if ($id === null) return false;
		return $this->db->select("*")->from('currency')
			->where('currencyid', $id)
			->get()
			->row();
	}

	public function finditem($product_name)
	{
		$this->db->select('*');
		$this->db->from('ingredients');
		$this->db->where('is_active', 1);
		$this->db->like('ingredient_name', $product_name);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}

	public function get_total_product($product_id)
	{
		$this->db->select('*');
		$this->db->from('ingredients');
		$this->db->where('id', $product_id);
		$query = $this->db->get()->row();
		$available_quantity = isset($query->stock_qty) ? $query->stock_qty : 0;
		$data2 = array(
			'total_purchase'  => $available_quantity
		);

		return $data2;
	}

	public function iteminfo($id)
	{
		$this->db->select('purchase_details.*,ingredients.ingredient_name,ingredients.stock_qty,unit_of_measurement.uom_short_code');
		$this->db->from('purchase_details');
		$this->db->join('ingredients', 'purchase_details.indredientid=ingredients.id', 'left');
		$this->db->join('unit_of_measurement', 'unit_of_measurement.id = ingredients.uom_id', 'inner');
		$this->db->where('purchaseid', $id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
	}

	// item Dropdown
	public function item_dropdown()
	{
		$data = $this->db->select("*")
			->from('item_foods')
			->get()
			->result();

		$list[''] = 'Select ' . display('item_name');
		if (!empty($data)) {
			foreach ($data as $value)
				$list[$value->ProductsID] = $value->ProductName;
			return $list;
		} else {
			return false;
		}
	}

	// ingredient Dropdown
	public function ingrediant_dropdown()
	{
		$data = $this->db->select("*")
			->from('ingredients')
			->where('is_active', 1)
			->get()
			->result();

		$list[''] = 'Select ' . display('item_name');
		if (!empty($data)) {
			foreach ($data as $value)
				$list[$value->id] = $value->ingredient_name;
			return $list;
		} else {
			return false;
		}
	}

	public function ingrediantlist()
	{
		$data = $this->db->select("*")->from('ingredients')->where('is_active', 1)->get()->result();
		//echo $this->db->last_query();
		return $data;
	}

	// supplier Dropdown
	public function supplier_dropdown()
	{
		$data = $this->db->select("*")
			->from('supplier')
			->get()
			->result();

		$list[''] = 'Select ' . display('supplier_name');
		if (!empty($data)) {
			foreach ($data as $value)
				$list[$value->supid] = $value->supName;
			return $list;
		} else {
			return false;
		}
	}

	public function suplierinfo($id)
	{
		if ($id === null) return false;
		return $this->db->select("*")->from('supplier')
			->where('supid', $id)
			->get()
			->row();
	}

	public function countlist()
	{
		$this->db->select('purchaseitem.*,supplier.supName');
		$this->db->from($this->table);
		$this->db->join('supplier', 'purchaseitem.suplierID = supplier.supid', 'left');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return false;
	}

	public function invoicebysupplier($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('suplierID', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
	}

	public function getinvoice($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('invoiceid', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return false;
	}

	public function pur_return_insert()
	{
		/* purchase Return Insert */
		$po_no = $this->input->post('invoice');
		$createby = $this->session->userdata('id');
		$createdate = date('Y-m-d H:i:s');
		$postData = array(
			'po_no'			        =>	$po_no,
			'supplier_id'		    =>	$this->input->post('supplier_id', true),
			'return_date'           =>  $this->input->post('return_date', true),
			'totalamount'           =>  $this->input->post('grand_total_price', true),
			'return_reason'         =>  $this->input->post('reason', true),
			'createby'		        =>	$createby,
			'createdate'		    =>	$createdate
		);

		$grand_total_price = (float)$this->input->post('grand_total_price', true);

		// start transaction
		$this->db->trans_start();

		$this->db->insert('purchase_return', $postData);
		$id = $this->db->insert_id();
		/***************End**********************/

		/* update Purchase stock and Amount */
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('invoiceid', $po_no);
		$query = $this->db->get();
		$purchase = $query->row();

		if ($purchase) {
			$purchaseid = isset($purchase->purID) ? $purchase->purID : null;
			$current_total_price = isset($purchase->total_price) ? (float)$purchase->total_price : 0;
			$updategrandtotal = $current_total_price - $grand_total_price;
			$updateData = array('total_price' => $updategrandtotal);

			$this->db->where('invoiceid', $po_no)
				->update('purchaseitem', $updateData);
		} else {
			// invoice not found - log and rollback
			log_message('error', "pur_return_insert: Aucun enregistrement d'achat trouvé pour invoiceid={$po_no}");
			$this->db->trans_complete();
			return false;
		}
		/***************End**********************/

		$p_id = (array)$this->input->post('product_id');
		$pq = (array)$this->input->post('total_price');
		$rate = (array)$this->input->post('product_rate');
		$quantity = (array)$this->input->post('total_qntt');
		$p_discount = (array)$this->input->post('discount');

		for ($i = 0, $n = count($p_id); $i < $n; $i++) {
			$product_quantity = isset($quantity[$i]) ? (float)$quantity[$i] : 0;
			$product_rate = isset($rate[$i]) ? (float)$rate[$i] : 0;
			$product_id = $p_id[$i];
			$removeprice = isset($pq[$i]) ? $pq[$i] : 0;
			$pdiscount = isset($p_discount[$i]) ? $p_discount[$i] : 0;

			if ($product_quantity > 0) {
				$data = array(
					'preturn_id'        =>  $id,
					'product_id'		=>	$product_id,
					'qty'			    =>	$product_quantity,
					'product_rate'	    =>	$product_rate,
					'discount'			=>	$pdiscount
				);

				$this->db->insert('purchase_return_details', $data);

				$this->db->select('*');
				$this->db->from('purchase_details');
				if (isset($purchaseid)) {
					$this->db->where('purchaseid', $purchaseid);
				} else {
					// missing purchaseid - skip further updates for safety
					continue;
				}
				$this->db->where('indredientid', $product_id);
				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					$purchasedetails = $query->row();
					$rateprice = $product_quantity * $product_rate;
					$qtotalpr = isset($purchasedetails->totalprice) ? ((float)$purchasedetails->totalprice - (float)$removeprice) : 0;
					$adjustqty = isset($purchasedetails->quantity) ? ((float)$purchasedetails->quantity - $product_quantity) : 0;
					$qtyData = array(
						'quantity'   =>	$adjustqty,
						'totalprice' => $qtotalpr
					);

					/* decrease stock in ingredients */
					$this->db->set('stock_qty', 'stock_qty-' . (float)$product_quantity, FALSE);
					$this->db->where('id', $product_id);
					$this->db->update('ingredients');
					/* end update ingredients */

					$this->db->where('purchaseid', $purchaseid)
						->where('indredientid', $product_id)
						->update('purchase_details', $qtyData);
				}
			}
		}

		// complete transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			log_message('error', 'Purchase_model::pur_return_insert transaction failed. po_no: ' . $po_no);
			return false;
		}

		return true;
	}

	public function readinvoice($limit = null, $start = null)
	{
		$this->db->select('purchase_return.*,supplier.supName');
		$this->db->from('purchase_return');
		$this->db->join('supplier', 'purchase_return.supplier_id = supplier.supid', 'left');
		$this->db->order_by('purchase_return.preturn_id', 'desc');
		if ($limit !== null) {
			$this->db->limit($limit, $start);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
	}

	public function countreturnlist()
	{
		$this->db->select('purchase_return.*,supplier.supName');
		$this->db->from('purchase_return');
		$this->db->join('supplier', 'purchase_return.supplier_id = supplier.supid', 'left');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return false;
	}

	public function findByreturnId($id = null)
	{
		if ($id === null) return false;
		$this->db->select('purchase_return.*,supplier.supName');
		$this->db->from('purchase_return');
		$this->db->join('supplier', 'purchase_return.supplier_id = supplier.supid', 'left');
		$this->db->where('preturn_id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return false;
	}

	public function returniteminfo($id)
	{
		$this->db->select('purchase_return_details.*,ingredients.ingredient_name,unit_of_measurement.uom_short_code');
		$this->db->from('purchase_return_details');
		$this->db->join('ingredients', 'purchase_return_details.product_id=ingredients.id', 'left');
		$this->db->join('unit_of_measurement', 'unit_of_measurement.id = ingredients.uom_id', 'inner');
		$this->db->where('preturn_id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
	}
}
