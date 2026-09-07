<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_model extends CI_Model {

	private $table = 'production_details';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('stock_movement_lib');
		$this->load->library('batch_lib');
	}
 
	public function create()
	{
		$this->db->trans_start();
		$saveid=$this->session->userdata('id');
		$p_id = $this->input->post('product_id');
		$purchase_date = str_replace('/','-',$this->input->post('production_date',true));
		$newdate= date('Y-m-d' , strtotime($purchase_date));
		$expire_date = str_replace('/','-',$this->input->post('expire_date'));
		$exdate= date('Y-m-d' , strtotime($expire_date));
		$foodid = $this->input->post('foodid');
		$fvid=$this->input->post('foodvarientid');
		$foodqty = $this->input->post('pro_qty');
		$data=array(
			'itemid'				  =>	$this->input->post('foodid'),
			'itemvid'				  =>	$this->input->post('foodvarientid'),
			'itemquantity'			  =>	$this->input->post('pro_qty',true),
			'savedby'	     		  =>	$saveid,
			'saveddate'	              =>	$newdate,
			'productionexpiredate'	  =>	$exdate
		);
		/* Server-side stock validation before deducting */
		$stockCheck = $this->checkingredientstock($foodid, $fvid, $foodqty);
		if ($stockCheck !== 1 && $stockCheck !== '1') {
			$this->db->trans_complete();
			return false;
		}

		// Audit F-17 : un decompte refuse faute de stock doit annuler la
		// production, pas la laisser s'enregistrer sans matiere premiere.
		if (!$this->checkproductiondetails($foodid,$fvid,$foodqty)) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->insert('production',$data);

		$returnid = $this->db->insert_id();
		$this->db->trans_complete();
		return $this->db->trans_status();

	}

	#check productiondetails
	public function checkproductiondetails($foodid,$fvid,$foodqty)
	{
		$suffisant = true;

		$checksetitem=$this->db->select('ProductsID,isgroup')->from('item_foods')->where('ProductsID',$foodid)->where('isgroup',1)->get()->row();
		if(!empty($checksetitem)){
			$groupitemlist=$this->db->select('items,varientid,item_qty')->from('tbl_groupitems')->where('gitemid',$checksetitem->ProductsID)->get()->result();
			foreach($groupitemlist as $groupitem){
				$this->db->select('*');
				$this->db->from('production_details');
				$this->db->where('foodid',$groupitem->items);
				$this->db->where('pvarientid',$groupitem->varientid);
				$productiondetails = $this->db->get()->result();
					 foreach($productiondetails as $productiondetail){
							$r_stock = (float)($productiondetail->qty) * ((float)($foodqty) * (float)($groupitem->item_qty));
							/*add stock in ingredients*/
							// Audit F-17 : le controle de disponibilite et le decompte etaient
							// deux instructions distinctes. Deux caisses enregistrant en meme
							// temps le dernier plat passaient toutes deux le controle. La
							// condition portee par l'UPDATE lui-meme rend l'operation atomique.
							$this->db->set('stock_qty', 'stock_qty - '.sprintf('%.4F', $r_stock), FALSE);
							$this->db->where('id', intval($productiondetail->ingredientid));
							$this->db->where('stock_qty >=', $r_stock);
							$this->db->update('ingredients');

							if ($this->db->affected_rows() < 1) {
								log_message('error', 'Stock insuffisant : ingredient '
									. intval($productiondetail->ingredientid) . ', demande ' . $r_stock);
								$suffisant = false;
							}
							/*end add ingredients*/

							/* Log stock movement for production */
							$this->stock_movement_lib->record(
								$productiondetail->ingredientid,
								'production',
								-$r_stock,
								$foodid,
								'production'
							);

							/* FIFO batch deduction */
							$this->batch_lib->deduct_fifo($productiondetail->ingredientid, $r_stock);
					 }
				}
		}else{
			$this->db->select('*');
				$this->db->from('production_details');
				$this->db->where('foodid',$foodid);
				$this->db->where('pvarientid',$fvid);
				$productiondetails = $this->db->get()->result();
				foreach($productiondetails as $productiondetail){
					$r_stock = (float)($productiondetail->qty) * (float)($foodqty);
					/*add stock in ingredients*/
						// Audit F-17 : le controle de disponibilite et le decompte etaient
						// deux instructions distinctes. Deux caisses enregistrant en meme
						// temps le dernier plat passaient toutes deux le controle. La
						// condition portee par l'UPDATE lui-meme rend l'operation atomique.
						$this->db->set('stock_qty', 'stock_qty - '.sprintf('%.4F', $r_stock), FALSE);
						$this->db->where('id', intval($productiondetail->ingredientid));
						$this->db->where('stock_qty >=', $r_stock);
						$this->db->update('ingredients');

						if ($this->db->affected_rows() < 1) {
							log_message('error', 'Stock insuffisant : ingredient '
								. intval($productiondetail->ingredientid) . ', demande ' . $r_stock);
							$suffisant = false;
						}
						/*end add ingredients*/

						/* Log stock movement for production */
						$this->stock_movement_lib->record(
							$productiondetail->ingredientid,
							'production',
							-$r_stock,
							$foodid,
							'production'
						);

						/* FIFO batch deduction */
						$this->batch_lib->deduct_fifo($productiondetail->ingredientid, $r_stock);
				}
			}
			
		


	
		return $suffisant;
	}
	
	public function delete($id = null)
	{
		$this->db->trans_start();
		/* Get production run details to restore stock */
		$production = $this->db->select('itemid, itemvid, itemquantity')
			->from('production')
			->where('productionid', $id)
			->get()->row();

		if ($production) {
			/* Restore ingredient stock that was deducted during this production run */
			$checksetitem = $this->db->select('ProductsID,isgroup')
				->from('item_foods')
				->where('ProductsID', $production->itemid)
				->where('isgroup', 1)
				->get()->row();

			if (!empty($checksetitem)) {
				$groupitemlist = $this->db->select('items,varientid,item_qty')
					->from('tbl_groupitems')
					->where('gitemid', $checksetitem->ProductsID)
					->get()->result();
				foreach ($groupitemlist as $groupitem) {
					$productiondetails = $this->db->select('ingredientid, qty')
						->from('production_details')
						->where('foodid', $groupitem->items)
						->where('pvarientid', $groupitem->varientid)
						->get()->result();
					foreach ($productiondetails as $detail) {
						$restore_qty = (float)($detail->qty) * ((float)($production->itemquantity) * (float)($groupitem->item_qty));
						$this->db->set('stock_qty', 'stock_qty + '.sprintf('%.4F', $restore_qty), FALSE);
						$this->db->where('id', intval($detail->ingredientid));
						$this->db->update('ingredients');

						/* Log stock movement for production delete (restore) */
						$this->stock_movement_lib->record(
							$detail->ingredientid,
							'production_delete',
							$restore_qty,
							$id,
							'production'
						);
					}
				}
			} else {
				$productiondetails = $this->db->select('ingredientid, qty')
					->from('production_details')
					->where('foodid', $production->itemid)
					->where('pvarientid', $production->itemvid)
					->get()->result();
				foreach ($productiondetails as $detail) {
					$restore_qty = (float)($detail->qty) * (float)($production->itemquantity);
					$this->db->set('stock_qty', 'stock_qty + '.sprintf('%.4F', $restore_qty), FALSE);
					$this->db->where('id', intval($detail->ingredientid));
					$this->db->update('ingredients');

					/* Log stock movement for production delete (restore) */
					$this->stock_movement_lib->record(
						$detail->ingredientid,
						'production_delete',
						$restore_qty,
						$id,
						'production'
					);
				}
			}
		}

		$this->db->where('productionid', $id)
			->delete('production');

		$this->db->trans_complete();
		return $this->db->trans_status();
	} 

    public function deleteitem($id = null,$qid=null)
	{
		$this->db->select('menu_id');
		$this->db->from('order_menu');
		$this->db->where('menu_id',$id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			// Item is used in orders — cannot delete
			return false;
		}
		else{
			$this->db->where('pro_detailsid',$qid)->delete($this->table);
			if ($this->db->affected_rows()) {
				return true;
			} else {
				return false;
			}
		}
	} 


	/*change it*/
	public function update()
	{
		$saveid=$this->session->userdata('id');
		$updateid =  $this->input->post('itemid');
		$p_id = $this->input->post('product_id');
		$itemid=$this->input->post('foodid');
		$itemvarient=$this->input->post('foodvarientid');
		$quantity = $this->input->post('product_quantity',true);
		$newdate= date('Y-m-d');
     
		
		$this->db->where('foodid',$itemid)->where('pvarientid',$itemvarient)->delete('production_details');

		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_id = $p_id[$i];
				$data1 = array(
				'foodid'		    =>	$itemid,
				'pvarientid'		=>	$itemvarient,
				'ingredientid'		=>	$product_id,
				'qty'				=>	$product_quantity,
				'createdby'			=>	$saveid,
				'created_date'		=>	$newdate
			);

				if(!empty($quantity))
				{
					$this->db->insert('production_details',$data1);
				}

		}
		return true;
	}
	
	
	public function makeproduction()
	{
		$saveid=$this->session->userdata('id');
		$p_id = $this->input->post('product_id');
		$itemid=$this->input->post('foodid');
		$itemvarient=$this->input->post('foodvarientid');
		$quantity = $this->input->post('product_quantity',true);
		$newdate= date('Y-m-d');
		$this->db->select('*');
		$this->db->from('production_details');
		$this->db->where('foodid',$itemid);
		$this->db->where('pvarientid',$itemvarient);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return false;
		}
		else{
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_id = $p_id[$i];
			
			$data1 = array(
				'foodid'		    =>	$itemid,
				'pvarientid'		=>	$itemvarient,
				'ingredientid'		=>	$product_id,
				'qty'				=>	$product_quantity,
				'createdby'			=>	$saveid,
				'created_date'		=>	$newdate
			);

			if(!empty($quantity))
			{
				$this->db->insert('production_details',$data1);
			}
			
		}
		if(empty($quantity))
			{
				return false;
			}
		return true;
		}
	}
	/*work on older methods*/
    public function read($limit = null, $start = null)
	{
	    $this->db->select('production_details.foodid,production_details.pvarientid,item_foods.ProductName,variant.variantName,variant.variantid');
        $this->db->from('production_details');
		$this->db->join('item_foods','item_foods.ProductsID = production_details.foodid','left');
		$this->db->join('variant','variant.variantid = production_details.pvarientid','left');
		$this->db->group_by('production_details.pvarientid');
        if ($limit !== null) {
			$this->db->limit($limit, $start);
		}
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
        	$data = $this->totalcal($query->result());
            return $data;
        }
        return false;
	}
	
	 public function readset($id,$vid)
	{
	    $this->db->select('production_details.foodid,item_foods.ProductName,variant.variantName,variant.variantid');
        $this->db->from('production_details');
		$this->db->join('item_foods','item_foods.ProductsID = production_details.foodid','left');
		$this->db->join('variant','variant.variantid = production_details.pvarientid','left');
		$this->db->where('production_details.foodid',$id);
		$this->db->where('production_details.pvarientid',$vid);
        $this->db->group_by('production_details.pvarientid'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();    
        }
        return false;
	}  

	public function findById($id = null,$vid=null)
	{ 
		return $this->db->select("*")->from('production_details')
			->where('foodid',$id) 
			->where('pvarientid',$vid) 
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
		return $this->db->select("*")->from('currency')
			->where('currencyid',$id) 
			->get()
			->row();
	} 
	/*new change*/
	public function finditem($product_name)
		{ 
		$this->db->select('ingredients.*,SUM(purchase_details.quantity) as uquantity,SUM(purchase_details.totalprice) as utotalprice');
		$this->db->from('ingredients');
		$this->db->join('purchase_details','purchase_details.indredientid = ingredients.id','inner');
		$this->db->where('ingredients.is_active',1);
		$this->db->like('ingredients.ingredient_name', $product_name);
		$this->db->group_by('ingredients.id');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
		}
	
	public function foodvarientlist($id = null)
	{
	    $this->db->select('*');
        $this->db->from('variant');
		$this->db->where('menuid',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        	$data = $query->result();
            return $data;    
        }
        return false;
	}
	
	 public function findByvId($id = null)
	{
		$data = $this->db->select("*")
			->from('variant')
			->where('menuid',$id) 
			->get()
			->result();
		$list[''] = 'Select '.display('varient_name');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->variantid] = $value->variantName;
			return $list;
		} else {
			return false; 
		}
	}
	public function get_total_product($product_id){
		$this->db->select('SUM(quantity) as total_purchase');
		$this->db->from('purchase_details');
		$this->db->where('indredientid',$product_id);
		$total_purchase = $this->db->get()->row();
		
		$this->db->select('SUM(qty) as total_ingredient');
		$this->db->from('production_details');
		$this->db->where('ingredientid',$product_id);
		$used_ingredient = $this->db->get()->row();
		$available_quantity = ($total_purchase->total_purchase - $used_ingredient->total_ingredient);
		
		$data2 = array(
			'total_purchase'  => $available_quantity
			);
		

		return $data2;
		}
		#new metho for cal total
	public function totalcal($values)
	{
		$i=0;
		$data=array();
		foreach ($values as $value) {
			# code...
			$toalvalue=0;
			$totalvalucals = $this->iteminfo($value->foodid,$value->pvarientid);
			foreach ($totalvalucals as $totalvalucal) {
				# code...
				$toalvalue = $totalvalucal->uprice*$totalvalucal->qty+$toalvalue;
			}
			$values[$i]->totalcost = $toalvalue;
		$i++;
		}
		return $values;

	}
public function ingrediantlist()
	{
		 $data = $this->db->select("*")->from('ingredients')->where('is_active',1)->get()->result();
		 //echo $this->db->last_query();
		 return $data;

		
	}
//item Dropdown*/
	 /*work on older methods*/
 public function iteminfo($id,$vid=null){
	 	$this->db->select('production_details.*,ingredients.id,ingredients.ingredient_name,unit_of_measurement.uom_short_code');
		$this->db->from('production_details');
		$this->db->join('ingredients','production_details.ingredientid=ingredients.id','left');
		$this->db->join('unit_of_measurement','unit_of_measurement.id = ingredients.uom_id','inner');
		
		$this->db->where('foodid',$id);
		if(!empty($vid)){
		$this->db->where('pvarientid',$vid);
		}
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
				$results = $query->result();
					
				$i=0;
			foreach ($results as $result) {
			
				$this->db->select('SUM(purchase_details.totalprice)/SUM(purchase_details.quantity) as uprice');
				$this->db->from('purchase_details');
				$this->db->where('indredientid',$result->ingredientid);
				$value = $this->db->get()->row();
				$results[$i]->uprice=$value->uprice;
				$i++;
			}
			return $results;	
		}
		return false;
		
	 }
 public function item_dropdown()
	{
		$data = $this->db->select("*")
			->from('item_foods')
			->get()
			->result();

		$list[''] = 'Select '.display('item_name');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->ProductsID] = $value->ProductName;
			return $list;
		} else {
			return false; 
		}
	}
 //ingredient Dropdown
 public function ingrediant_dropdown()
	{
		$data = $this->db->select("*")
			->from('ingredients')
			->where('is_active',1) 
			->get()
			->result();

		$list[''] = 'Select '.display('item_name');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->id] = $value->ingredient_name;
			return $list;
		} else {
			return false; 
		}
	}
//item Dropdown
 public function supplier_dropdown()
	{
		$data = $this->db->select("*")
			->from('supplier')
			->get()
			->result();

		$list[''] = 'Select '.display('supplier_name');
		if (!empty($data)) {
			foreach($data as $value)
				$list[$value->supid] = $value->supName;
			return $list;
		} else {
			return false; 
		}
	}
public function suplierinfo($id){
	return $this->db->select("*")->from('supplier')
			->where('supid',$id) 
			->get()
			->row();
	
	}
public function countlist()
	{
		$this->db->select('COUNT(DISTINCT production_details.pvarientid) as total', FALSE);
		$this->db->from('production_details');
		$this->db->join('item_foods','item_foods.ProductsID = production_details.foodid','Inner');
		$query = $this->db->get()->row();
		return $query ? (int)$query->total : 0;
	}
#check stock
	public function checkingredientstock($foodid,$vid,$foodqty){
		$checksetitem=$this->db->select('ProductsID,isgroup')->from('item_foods')->where('ProductsID',$foodid)->where('isgroup',1)->get()->row();
		$isavailable=true;
		if(!empty($checksetitem)){
			$groupitemlist=$this->db->select('items,varientid,item_qty')->from('tbl_groupitems')->where('gitemid',$checksetitem->ProductsID)->get()->result();
			foreach($groupitemlist as $groupitem){
				$this->db->select('*');
				$this->db->from('production_details');
				$this->db->where('foodid',$groupitem->items);
				$this->db->where('pvarientid',$groupitem->varientid);
				$productiondetails = $this->db->get()->result();
				 if(empty($productiondetails)){
					 $isavailable=false;
					 return 'Please set Ingredients!!first!!!'.$groupitem->items;
					 break;
					 }
				 else{
					 foreach($productiondetails as $productiondetail){
							$r_stock = $productiondetail->qty*($foodqty*$groupitem->item_qty);
							/*add stock in ingredients*/
							$this->db->select('*');
							$this->db->from('ingredients');
							$this->db->where('id', $productiondetail->ingredientid);
							$this->db->where('stock_qty >=',$r_stock);
							$stockcheck = $this->db->get()->num_rows();
							
							if($stockcheck == 0){
								return 'Please check Ingredients!!Some Ingredients are not Available!!!'.$groupitem->items;
							}
							/*end add ingredients*/
						}
					 }
				}
			return 1;
		}else{
			$this->db->select('*');
			$this->db->from('production_details');
			$this->db->where('foodid',$foodid);
			$this->db->where('pvarientid',$vid);
			$productiondetails = $this->db->get()->result();
			}
		
		
		if(!empty($productiondetails)){
			
		   foreach($productiondetails as $productiondetail){
			$r_stock = $productiondetail->qty*$foodqty;
			/*add stock in ingredients*/
				$this->db->select('*');
				$this->db->from('ingredients');
				$this->db->where('id', $productiondetail->ingredientid);
				$this->db->where('stock_qty >=',$r_stock);
				$stockcheck = $this->db->get()->num_rows();
				
				if($stockcheck == 0){
					return 'Please check Ingredients!!Some Ingredients are not Available!!!';
				}


				/*end add ingredients*/
		}
	}
	else{
		return 'Please set Ingredients!!first!!!';
	}
		return 1;
	
	}
public function checkmeterials($foodid,$qty){
		$this->db->select('SUM(itemquantity) as producequantity');
        $this->db->from('production');
        $this->db->where('itemid',$foodid); 
		$query2 = $this->db->get();

		if($query2->num_rows() > 0) {
			$proqty1=$query2->row();
			$proqty=$proqty1->producequantity;
			}
		else{
			$proqty=0;
			}
		$this->db->select('foodid,ingredientid,qty');
        $this->db->from('production_details');
        $this->db->where('foodid',$foodid); 
        $query = $this->db->get();
	
        if ($query->num_rows() > 0) {
            $alingredient= $query->result(); 
			$isavailable='';
			foreach($alingredient as $single){
					$inqty=$single->qty;
					$ingredientid=$single->ingredientid;
					$nitqty=$inqty*$qty;
					$isavailable2=$this->checkingredient($nitqty,$ingredientid,$foodid,$proqty);
					$isavailable.=$isavailable2.',';
				}
				 if( strpos($isavailable, '0') !== false ) {
					 echo "0";
				 }
				 else{
					 echo 1;
					 }
        }
		
	}
public function checkingredient($nitqty,$ingredientid,$foodid,$proqty){
		$this->db->select('SUM(purchase_details.quantity) as totalquantity,ingredients.id,ingredients.ingredient_name');
		$this->db->from('purchase_details');
		$this->db->join('ingredients','purchase_details.indredientid=ingredients.id','left');
		$this->db->where('purchase_details.indredientid',$ingredientid);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			 $row=$query->row();
			 $purchaseqty=$row->totalquantity;
			 $foodwise=$this->db->select("production_details.foodid,production_details.ingredientid,production_details.qty,SUM(production.itemquantity*production_details.qty) as foodqty")->from('production_details')->join('production','production.itemid=production_details.foodid','Left')->where('production_details.ingredientid',$ingredientid)->group_by('production_details.foodid')->get()->result();
		      $lastqty=0;
			  foreach($foodwise as $gettotal){
				$lastqty=$lastqty+$gettotal->foodqty;
				}
			$restqty=$purchaseqty-$lastqty;
			 if($restqty>=$nitqty){
				return 1;
				}
			else{
				return 0;
				}
			}
		else{
			return 0;
		}
	}

	/**
	 * Get all food items with their recipe cost vs selling price.
	 */
	public function food_cost_list()
	{
		// Get all unique food+variant combos from production_details
		$items = $this->db->query("
			SELECT DISTINCT pd.foodid, pd.pvarientid,
				f.ProductName, v.variantName, v.price as selling_price
			FROM production_details pd
			JOIN item_foods f ON f.ProductsID = pd.foodid
			LEFT JOIN variant v ON v.variantid = pd.pvarientid
			ORDER BY f.ProductName, v.variantName
		")->result();

		foreach ($items as &$item) {
			// Get recipe ingredients with avg purchase price
			$recipe = $this->db->query("
				SELECT pd.ingredientid, pd.qty, i.ingredient_name, u.uom_short_code,
					COALESCE((SELECT SUM(pdet.totalprice)/SUM(pdet.quantity)
						FROM purchase_details pdet WHERE pdet.indredientid = pd.ingredientid), 0) as unit_price
				FROM production_details pd
				JOIN ingredients i ON i.id = pd.ingredientid
				LEFT JOIN unit_of_measurement u ON u.id = i.uom_id
				WHERE pd.foodid = ? AND pd.pvarientid = ?
			", [$item->foodid, $item->pvarientid])->result();

			$total_cost = 0;
			foreach ($recipe as $r) {
				$r->subtotal = (float) $r->qty * (float) $r->unit_price;
				$total_cost += $r->subtotal;
			}

			$item->recipe = $recipe;
			$item->total_cost = $total_cost;
			$item->food_cost_pct = ($item->selling_price > 0)
				? round(($total_cost / $item->selling_price) * 100, 1)
				: 0;
		}

		return $items;
	}

}
