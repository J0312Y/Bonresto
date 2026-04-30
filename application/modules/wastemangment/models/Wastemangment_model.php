<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Wastemangment_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }

    /*new change*/
    public function finditem($product_name)
    {
        $this->db->select('ingredients.*,SUM(purchase_details.quantity) as uquantity,SUM(purchase_details.totalprice) as utotalprice');
        $this->db->from('ingredients');
        $this->db->join('purchase_details', 'purchase_details.indredientid = ingredients.id', 'inner');
        $this->db->where('ingredients.is_active', 1);
        $this->db->like('ingredients.ingredient_name', $product_name);
        $this->db->group_by('ingredients.id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    /*new change*/
    public function findfood($product_name)
    {
        $this->db->select('production_details.foodid,item_foods.*,variant.variantid,variant.variantName,variant.price');
        $this->db->from('production_details');
        $this->db->join('item_foods', 'item_foods.ProductsID = production_details.foodid', 'Left');
        $this->db->join('variant', 'variant.variantid=production_details.pvarientid', 'left');
        $this->db->group_by('production_details.pvarientid');
        $this->db->like('item_foods.ProductName', $product_name);
        $query = $this->db->get();

//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $this->totalcal($query->result());

            return $data;
        }

        return false;
    }

    public function totalcal($values)
    {
        $i = 0;

        foreach ($values as $value) {
            $toalvalue     = 0;
            $totalvalucals = $this->iteminfo($value->foodid, $value->variantid);

            if ($totalvalucals) {
                foreach ($totalvalucals as $totalvalucal) {
                    $toalvalue = $totalvalucal->uprice * $totalvalucal->qty + $toalvalue;
                }
            }

            $values[$i]->totalcost = $toalvalue;
            $i++;
        }

        return $values;
    }

    public function iteminfo($id, $vid)
    {
        $this->db->select('production_details.*,ingredients.id,ingredients.ingredient_name,unit_of_measurement.uom_short_code');
        $this->db->from('production_details');
        $this->db->join('ingredients', 'production_details.ingredientid=ingredients.id', 'left');
        $this->db->join('unit_of_measurement', 'unit_of_measurement.id = ingredients.uom_id', 'inner');
        //$this->db->join('purchase_details','purchase_details.indredientid = ingredients.id','left');

        $this->db->where('foodid', $id);
        $this->db->where('pvarientid', $vid);
        $query = $this->db->get();

//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $results = $query->result();
            $i       = 0;
            foreach ($results as $result) {
                $this->db->select('SUM(purchase_details.totalprice)/SUM(purchase_details.quantity) as uprice');
                $this->db->from('purchase_details');
                $this->db->where('indredientid', $result->ingredientid);
                $value               = $this->db->get()->row();
                $results[$i]->uprice = $value->uprice;
                $i++;
            }

            return $results;
        }

        return false;

    }

    public function insertpackgeinformation()
    {
        $saveid   = $this->session->userdata('id');
        $p_id     = $this->input->post('product_id');
        $itemid   = $this->input->post('orderid');
        $quantity = $this->input->post('product_quantity');
        $price    = $this->input->post('price');
        $note     = $this->input->post('note');
        $newdate  = date('Y-m-d');

        // Check if this order already has a waste entry
        $this->db->select('order_id');
        $this->db->from('packaging_food_waste');
        $this->db->where('order_id', $itemid);
        $already = $this->db->get()->num_rows();
        if ($already > 0) {
            return false;
        }

        // Check the order exists (any date, not just today)
        $this->db->select('order_id');
        $this->db->from('customer_order');
        $this->db->where('order_id', $itemid);
        $ordercount = $this->db->get()->num_rows();
        if ($ordercount != 1) {
            return false;
        }

        if (empty($p_id)) {
            return false;
        }

        $this->db->trans_start();
        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = (float) $quantity[$i];
            $product_id       = $p_id[$i];
            $pr_lost          = $price[$i];
            $not_e            = $note[$i];

            if ($product_quantity <= 0) {
                continue;
            }

            $data1 = [
                'order_id'      => $itemid,
                'ingradient_id' => $product_id,
                'qnty'          => $product_quantity,
                'l_price'       => $pr_lost,
                'note'          => $not_e,
                'createdby'     => $saveid,
                'created_at'    => $newdate,
            ];

            $this->db->insert('packaging_food_waste', $data1);

            $this->db->set('stock_qty', 'stock_qty-' . $product_quantity, false);
            $this->db->where('id', $product_id);
            $this->db->update('ingredients');
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function showpackagingfoodwaste($start_date, $end_date)
    {
        $this->db->select('*,ingredients.ingredient_name');
        $this->db->from('packaging_food_waste');
        $this->db->join('ingredients', 'packaging_food_waste.ingradient_id = ingredients.id');
        $this->db->where('date(packaging_food_waste.created_at) >=', $start_date);
        $this->db->where('date(packaging_food_waste.created_at) <=', $end_date);
        $query = $this->db->get()->result();
        return $query;
    }

    public function read_user()
    {
        $user_list = $this->db->select("
				user.*,
				CONCAT_WS(' ', firstname, lastname) AS fullname
			")
            ->from('user')
            ->order_by('id', 'desc')
            ->get()
            ->result();
        $list[''] = 'Select User';

        if (!empty($user_list)) {

            foreach ($user_list as $value) {
                $list[$value->id] = $value->fullname;
            }

        }

        return $list;
    }

    public function insertingrdinformation()
    {
        $saveid        = $this->session->userdata('id');
        $p_id          = $this->input->post('product_id');
        $itemid        = $this->input->post('user');
        $quantity      = $this->input->post('product_quantity');
        $quantitystock = $this->input->post('product_stock');
        $price         = $this->input->post('price');
        $note          = $this->input->post('note');
        $newdate       = date('Y-m-d H:i:s');

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantitystock[$i] - $quantity[$i];
            $product_id       = $p_id[$i];
            $pr_lost          = $price[$i];
            $not_e            = $note[$i];

            $data1 = [
                'check_by'      => $itemid,
                'ingradient_id' => $product_id,
                'qnty'          => $product_quantity,
                'l_price'       => $pr_lost,
                'note'          => $not_e,
                'createdby'     => $saveid,
                'created_at'    => $newdate,
            ];

            /*add stock in ingredients*/
            $this->db->set('stock_qty', 'stock_qty-' . $product_quantity, false);
            $this->db->where('id', $product_id);
            $this->db->update('ingredients');
            /*end add ingredients*/
            $this->db->insert('ingradient_food_waste', $data1);
        }

        return true;

    }

    public function insertfoodinformation()
    {
        $saveid   = $this->session->userdata('id');
        $p_id     = $this->input->post('product_id');
        $itemid   = $this->input->post('user');
        $quantity = $this->input->post('product_quantity');

        $price   = $this->input->post('price');
        $note    = $this->input->post('note');
        $newdate = date('Y-m-d H:i:s');

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $pro_varient      = explode('-', $p_id[$i]);
            $product_id       = $pro_varient[0];
            $varient_id       = $pro_varient[1];
            $pr_lost          = $price[$i];
            $not_e            = $note[$i];

            $data1 = [
                'check_by'   => $itemid,
                'itms_id'    => $product_id,
                'wvarientid' => $varient_id,
                'qnty'       => $product_quantity,
                'l_price'    => $pr_lost,
                'note'       => $not_e,
                'createdby'  => $saveid,
                'created_at' => $newdate,
            ];

            $this->db->insert('items_food_waste', $data1);
        }

        return true;

    }

    public function showingrdinfoodwaste($start_date, $end_date)
    {
        $this->db->select('*,ingredients.ingredient_name,
				CONCAT_WS(" ", user.firstname, user.lastname) AS fullname');
        $this->db->from('ingradient_food_waste');
        $this->db->join('ingredients', 'ingradient_food_waste.ingradient_id = ingredients.id');
        $this->db->join('user', 'ingradient_food_waste.check_by = user.id');
        $this->db->where('date(ingradient_food_waste.created_at) >=', $start_date);
        $this->db->where('date(ingradient_food_waste.created_at) <=', $end_date);
        $this->db->order_by('ingradient_food_waste.id', 'DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function showitemsfoodwaste($start_date, $end_date)
    {
        $this->db->select('*,item_foods.ProductName,variant.variantName,
				CONCAT_WS(" ", user.firstname, user.lastname) AS fullname');
        $this->db->from('items_food_waste');
        $this->db->join('item_foods', 'items_food_waste.itms_id = item_foods.ProductsID');
        $this->db->join('variant', 'variant.variantid = items_food_waste.wvarientid');
        $this->db->join('user', 'items_food_waste.check_by = user.id');
        $this->db->where('date(items_food_waste.created_at) >=', $start_date);
        $this->db->where('date(items_food_waste.created_at) <=', $end_date);
        $this->db->order_by('items_food_waste.id', 'DESC');
        $query = $this->db->get()->result();

        return $query;
    }

}
