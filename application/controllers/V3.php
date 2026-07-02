<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class V3 extends MY_Controller
{

	protected $FILE_PATH;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('lsoft_setting');
		$this->load->model('Api_kitchen_model');

		$this->FILE_PATH = base_url('upload/');
	}

	public function index()
	{
		redirect('myurl');
	}

	public function sign_in()
	{
		// TO DO / Email or Phone only one required
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean|trim');
		$this->form_validation->set_rules('token', 'token', 'required|xss_clean|trim');

		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$data['email']      = $this->input->post('email', TRUE);
			$data['password']   = $this->input->post('password', TRUE);

			$IsReg = $this->Api_kitchen_model->checkEmailOrPhoneIsRegistered('user', $data);

			if (!$IsReg) {
				return $this->respondUserNotReg('Cet e-mail ou ce numéro de téléphone n\'a pas encore été enregistré.');
			}
			$result = $this->Api_kitchen_model->authenticate_user('user', $data);
			$updatetData['waiter_kitchenToken']    			= $this->input->post('token', TRUE);
			$this->Api_kitchen_model->update_date('user', $updatetData, 'id', $result->id);
			$webseting = $this->Api_kitchen_model->read('powerbytxt,currency,servicecharge', 'setting', array('id' => 2));
			$currencyinfo = $this->Api_kitchen_model->read('currencyname,curr_icon', 'currency', array('currencyid' => $webseting->currency));
			$kitcheninfo = $this->Api_kitchen_model->readall('kitchen_id', 'tbl_assign_kitchen', 'kitchen_id', array('userid' => $result->id));
			$allkitchenid = '';
			foreach ($kitcheninfo as $kitchenid) {
				$allkitchenid .= "'" . $kitchenid->kitchen_id . "',";
			}
			$allkitchenid = rtrim($allkitchenid, ',');

			if ($result != FALSE) {
				$str = substr($result->picture, 2);
				$result->{"UserPictureURL"} = base_url() . $str;
				$result->{"PowerBy"} = $webseting->powerbytxt;
				$result->{"currencycode"} = $currencyinfo->currencyname;
				$result->{"currencysign"} = $currencyinfo->curr_icon;
				$result->{"servicecharge"} = $webseting->servicecharge;
				$result->{"kitchenid"} = $allkitchenid;
				return $this->respondWithSuccess('Vous vous êtes connecté avec succès.', $result);
			} else {
				return $this->respondWithError('L\'e-mail et le mot de passe que vous avez saisis ne correspondent pas.', $result);
			}
		}
	}

	public function kitchenlist()
	{
		$this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');

		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$kitchenuserid = $this->input->post('id', TRUE);
 			$output = array();
			$kitcheninfo = $this->Api_kitchen_model->readallkitchen('tbl_kitchen.kitchenid,tbl_kitchen.kitchen_name,tbl_assign_kitchen.kitchen_id', 'tbl_assign_kitchen', 'tbl_assign_kitchen.kitchen_id', array('tbl_assign_kitchen.userid' => $kitchenuserid));
			$i = 0;
			foreach ($kitcheninfo as $kitchenid) {
				$output['kitchenlist'][$i]['kitchenid'] = $kitchenid->kitchenid;
				$output['kitchenlist'][$i]['kitchenname'] = $kitchenid->kitchen_name;
				$i++;
			}
			return $this->respondWithSuccess('Toutes les listes de cuisine.', $output);
		}
	}

	public function orderlist()
	{
		$this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
		$this->form_validation->set_rules('kitchenid', 'kitchenid', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$waiterid = $this->input->post('id', TRUE);
			$kitchenid = $this->input->post('kitchenid', TRUE);
			$orderlist = $this->Api_kitchen_model->orderlist($kitchenid);
			//print_r($orderlist);
			$output = $categoryIDs = array();
			$hasitem = '';
			if ($orderlist != FALSE) {
				$i = 0;
				foreach ($orderlist as $order) {
					$con = "order_menu.allfoodready IS NULL";
					$orderdetails = $this->db->select('order_menu.*,tbl_kitchen_order.*')->from('tbl_kitchen_order')->join('order_menu', 'tbl_kitchen_order.orderid=order_menu.order_id')->where('order_menu.order_id', $order->order_id)->where('tbl_kitchen_order.kitchenid', $kitchenid)->where($con)->group_by('order_menu.order_id')->group_by('order_menu.menu_id')->group_by('order_menu.varientid')->get()->result();
					// echo $this->db->last_query();			 

					if (!empty($orderdetails)) {
						$output['orderinfo'][$i]['order_id']        = $order->order_id;
						$output['orderinfo'][$i]['CustomerName']    = $order->customer_name;
						$output['orderinfo'][$i]['TableName']       = $order->tablename;
						$output['orderinfo'][$i]['OrderDate']       = $order->order_date;
						$output['orderinfo'][$i]['TotalAmount']     = $order->totalamount;
						$output['orderinfo'][$i]['notes']           = $order->customer_note;

						$k = 0;
						foreach ($orderdetails as $item) {
							//print_r($item);
							$iteminfo = $this->db->select('order_menu.*,item_foods.ProductsID,item_foods.ProductName,variant.variantid,variant.variantName,variant.price')->from('order_menu')->join('item_foods', 'item_foods.ProductsID=order_menu.menu_id', 'left')->join('variant', 'variant.variantid=order_menu.varientid', 'left')->where('order_menu.menu_id', $item->menu_id)->where('variant.variantid', $item->varientid)->where('order_menu.order_id', $order->order_id)->get()->row();
							// echo $this->db->last_query();
							//print_r($iteminfo);
							if (empty($iteminfo->allfoodready)) {
								$hasitem .= "1,";
								$output['orderinfo'][$i]['iteminfo'][$k]['order_id']       = $order->order_id;
								$output['orderinfo'][$i]['iteminfo'][$k]['ProductsID']     = $iteminfo->ProductsID;
								$output['orderinfo'][$i]['iteminfo'][$k]['ProductName']    = $iteminfo->ProductName;
								$output['orderinfo'][$i]['iteminfo'][$k]['Varientid']      = $iteminfo->varientid;
								$output['orderinfo'][$i]['iteminfo'][$k]['VarientName']      = $iteminfo->variantName;
								$output['orderinfo'][$i]['iteminfo'][$k]['Itemqty']        = $iteminfo->menuqty;
								$output['orderinfo'][$i]['iteminfo'][$k]['itemnote']        = $iteminfo->notes;
								$output['orderinfo'][$i]['iteminfo'][$k]['food_status']    = $iteminfo->food_status;
								if (!empty($item->add_on_id)) {
									$output['orderinfo'][$i]['iteminfo'][$k]['addons']        = 1;
									$addons = explode(",", $item->add_on_id);
									$addonsqty = explode(",", $item->addonsqty);
									$x = 0;
									foreach ($addons as $addonsid) {
										$adonsinfo = $this->Api_kitchen_model->read('*', 'add_ons', array('add_on_id' => $addonsid));
										$output['orderinfo'][$i]['iteminfo'][$k]['addonsinfo'][$x]['addonsName']     = $adonsinfo->add_on_name;
										$output['orderinfo'][$i]['iteminfo'][$k]['addonsinfo'][$x]['add_on_id']      = $adonsinfo->add_on_id;
										$output['orderinfo'][$i]['iteminfo'][$k]['addonsinfo'][$x]['add_on_qty']     = $addonsqty[$x];
										$x++;
									}
								} else {
									$output['orderinfo'][$i]['iteminfo'][$k]['addons']        = 0;
								}
								$k++;
							} else {
								$hasitem .= "0,";
								$output['orderinfo'][$i]['iteminfo'] = array();
							}
						}
						$i++;
					} else {
						$hasitem .= "0,";
						$output['orderinfo'][$i]['order_id']        = $order->order_id;
						$output['orderinfo'][$i]['CustomerName']    = $order->customer_name;
						$output['orderinfo'][$i]['TableName']       = $order->tablename;
						$output['orderinfo'][$i]['OrderDate']       = $order->order_date;
						$output['orderinfo'][$i]['TotalAmount']     = $order->totalamount;
						$output['orderinfo'][$i]['notes']           = $order->customer_note;
						$output['orderinfo'][$i]['iteminfo'] = array();
						$i++;
					}
				}

				if (strpos($hasitem, '1') !== false) {
					$output['hasitem'] = 1;
				} else {
					$output['hasitem'] = 0;
				}

				return $this->respondWithSuccess('Liste des commandes en attente.', $output);
			} else {
				return $this->respondWithError('Commande introuvable.!!!', $output);
			}
		}
	}
	public function completeorcancel()
	{
		$this->form_validation->set_rules('Orderid', 'Orderid', 'required|xss_clean|trim');
		$this->form_validation->set_rules('kitchenid', 'kitchenid', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$updatetData = array('order_status'     => 2);
			$this->db->where('order_id', $orderid);
			$this->db->update('customer_order', $updatetData);
			$this->_sync_order_status($orderid, 2);
			$orderid = $this->input->post('Orderid', TRUE);
			$kitchenid = $this->input->post('kitchenid', TRUE);
			$output = $categoryIDs = array();
			$customerorder = $this->Api_kitchen_model->read('*', 'customer_order', array('order_id' => $orderid));

			$customerinfo = $this->Api_kitchen_model->read('*', 'customer_info', array('customer_id' => $customerorder->customer_id));
			$tableinfo = $this->Api_kitchen_model->read('*', 'rest_table', array('tableid' => $customerorder->table_no));
			$typeinfo = $this->Api_kitchen_model->read('*', 'customer_type', array('customer_type_id' => $customerorder->cutomertype));

			$orderdetails = $this->db->select('order_menu.*,item_foods.ProductsID,item_foods.ProductName,variant.variantid,variant.variantName,variant.price')->from('order_menu')->join('customer_order', 'order_menu.order_id=customer_order.order_id', 'left')->join('item_foods', 'order_menu.menu_id=item_foods.ProductsID', 'left')->join('variant', 'order_menu.varientid=variant.variantid', 'left')->where('order_menu.order_id', $orderid)->where('item_foods.kitchenid', $kitchenid)->order_by('customer_order.order_id', 'desc')->get()->result();
			//
			$billinfo = $this->Api_kitchen_model->read('*', 'bill', array('order_id' => $orderid));

			if (!empty($orderdetails)) {
				$output['CustomerName'] = $customerinfo->customer_name;
				$output['CustomerPhone'] = $customerinfo->customer_phone;
				$output['CustomerEmail'] = $customerinfo->customer_email;
				$output['CustomerType'] = $typeinfo->customer_type;
				$output['TableName'] = $tableinfo->tablename;
				$i = 0;

				foreach ($orderdetails as $item) {
					$itemtotal = $item->menuqty * $item->price;
					$output['iteminfo'][$i]['ProductsID']     = $item->ProductsID;
					$output['iteminfo'][$i]['ProductName']    = $item->ProductName;
					$output['iteminfo'][$i]['price']    	   = $item->price;
					$output['iteminfo'][$i]['Varientname']    = $item->variantName;
					$output['iteminfo'][$i]['Varientid']      = $item->variantid;
					$output['iteminfo'][$i]['Itemqty']        = $item->menuqty;
					$output['iteminfo'][$i]['Itemtotal']      = number_format($itemtotal, 2);
					if (!empty($item->add_on_id)) {
						$output['iteminfo'][$i]['addons']        = 1;
						$addons = explode(",", $item->add_on_id);
						$addonsqty = explode(",", $item->addonsqty);
						$x = 0;
						foreach ($addons as $addonsid) {
							$adonsinfo = $this->Api_kitchen_model->read('*', 'add_ons', array('add_on_id' => $addonsid));
							$output['iteminfo'][$i]['addonsinfo'][$x]['addonsName']     = $adonsinfo->add_on_name;
							$output['iteminfo'][$i]['addonsinfo'][$x]['add_on_id']      = $adonsinfo->add_on_id;
							$output['iteminfo'][$i]['addonsinfo'][$x]['price']      	= $adonsinfo->price;
							$output['iteminfo'][$i]['addonsinfo'][$x]['add_on_qty']     = $addonsqty[$x];
							$x++;
						}
					} else {
						$output['iteminfo'][$i]['addons']        = 0;
					}

					$i++;
				}
				$output['Subtotal']              = $billinfo->total_amount;
				$output['discount']              = $billinfo->discount;
				$output['service_charge']        = $billinfo->service_charge;
				$output['VAT']        			  = $billinfo->VAT;
				$output['order_total']           = $billinfo->bill_amount;
				$output['orderdate']             = $billinfo->bill_date;

				return $this->respondWithSuccess('détails de la commande', $output);
			} else {
				return $this->respondWithError('Commande introuvable.!!!', $output);
			}
		}
	}
	public function foodisready()
	{
		$this->form_validation->set_rules('Orderid', 'Orderid', 'required|xss_clean|trim');
		$this->form_validation->set_rules('ProductsID', 'Products ID', 'required|xss_clean|trim');
		$this->form_validation->set_rules('variantid', 'Varient ID', 'required|xss_clean|trim');
		$this->form_validation->set_rules('isready', 'isready', 'required|xss_clean|trim');
		$this->form_validation->set_rules('kitchenid', 'kitchenid', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$ProductsID = $this->input->post('ProductsID', TRUE);
			$variantid = $this->input->post('variantid', TRUE);
			$fisready = $this->input->post('isready', TRUE);
			$kitchenid = $this->input->post('kitchenid', TRUE);

			$output = $categoryIDs = array();
			$output['isready']        = $fisready;
			$orderid = $this->input->post('Orderid', TRUE);
			$updatetData = array('order_status'     => 2);
			$this->db->where('order_id', $orderid);
			$this->db->update('customer_order', $updatetData);

			$updatetfood = array('food_status' => $this->input->post('isready', TRUE));
			$this->db->where('order_id', $orderid);
			$this->db->where('menu_id', $ProductsID);
			$this->db->where('varientid', $variantid);
			$this->db->update('order_menu', $updatetfood);


			$customerorder = $this->Api_kitchen_model->read('*', 'customer_order', array('order_id' => $orderid));

			$customerinfo = $this->Api_kitchen_model->read('*', 'customer_info', array('customer_id' => $customerorder->customer_id));
			$tableinfo = $this->Api_kitchen_model->read('*', 'rest_table', array('tableid' => $customerorder->table_no));
			$typeinfo = $this->Api_kitchen_model->read('*', 'customer_type', array('customer_type_id' => $customerorder->cutomertype));
			$isexit = $this->db->select('*')->from('tbl_orderprepare')->where('orderid', $orderid)->where('menuid', $ProductsID)->where('varient', $variantid)->get()->row();
			$orderdetails = $this->db->select('order_menu.*,item_foods.ProductsID,item_foods.ProductName,variant.variantid,variant.variantName,variant.price')->from('order_menu')->join('customer_order', 'order_menu.order_id=customer_order.order_id', 'left')->join('item_foods', 'order_menu.menu_id=item_foods.ProductsID', 'left')->join('variant', 'order_menu.varientid=variant.variantid', 'left')->where('order_menu.order_id', $orderid)->where('item_foods.kitchenid', $kitchenid)->order_by('customer_order.order_id', 'desc')->get()->result();
			//
			$billinfo = $this->Api_kitchen_model->read('*', 'bill', array('order_id' => $orderid));

			if (!empty($orderdetails)) {
				$i = 0;

				foreach ($orderdetails as $item) {
					if ($item->food_status == 1) {
						$ready = "La nourriture est prête";
						if (empty($isexit)) {
							$ready = array(
								'preparetime' => date('Y-m-d H:i:s'),
								'orderid'     => $orderid,
								'menuid'     => $ProductsID,
								'varient'     => $variantid
							);
							$this->db->insert('tbl_orderprepare', $ready);
						}
						/* Notification nourriture prête — serveur + client */
						$this->load->library('notification');
						$waiter_token = $this->notification->get_waiter_token($customerorder->waiter_id);
						$this->notification->food_ready($orderid, $item->ProductName, $customerorder->totalamount, $waiter_token, $customerinfo->customer_token);
					} else {
						$ready = "Food Is Cooking";
						/* Notification en cours de préparation — serveur + client */
						$this->load->library('notification');
						$waiter_token = $this->notification->get_waiter_token($customerorder->waiter_id);
						$this->notification->order_preparing($orderid, $item->ProductName, $customerorder->totalamount, $waiter_token, $customerinfo->customer_token);
					}
					if (!empty($item->add_on_id)) {

						$addons = explode(",", $item->add_on_id);
						$addonsqty = explode(",", $item->addonsqty);
						$x = 0;
						foreach ($addons as $addonsid) {
							$adonsinfo = $this->Api_kitchen_model->read('*', 'add_ons', array('add_on_id' => $addonsid));
							$x++;
						}
					} else {
					}

					$i++;
				}

				return $this->respondWithSuccess('détails de la commande', $output);
			} else {
				return $this->respondWithError('Commande introuvable.!!!', $output);
			}
		}
	}
	public function markasready()
	{
		$this->form_validation->set_rules('orderid', 'Order ID', 'required|xss_clean|trim');
		$this->form_validation->set_rules('foodid', 'Food ID', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$output = array();
			$order_id = $this->input->post('orderid', TRUE);
			$allfood = $this->input->post('foodid', TRUE);
			$vaids = $this->input->post('varientid', TRUE);
			$allfood_id = explode(",", $allfood);
			$m = 0;
			foreach ($allfood_id as $foodid) {
				$updatetready = array(
					'food_status'           => 1,
					'allfoodready'           => 1
				);
				$this->db->where('order_id', $order_id);
				$this->db->where('menu_id', $foodid);
				$this->db->update('order_menu', $updatetready);
				$isexit = $this->db->select('*')->from('tbl_orderprepare')->where('orderid', $order_id)->where('menuid', $foodid)->where('varient', $vaids)->get()->row();
				if (empty($isexit)) {
					$ready = array(
						'preparetime' => date('Y-m-d H:i:s'),
						'orderid'     => $orderid,
						'menuid'     => $menuid,
						'varient'     => $vaids[$m]
					);
					$this->db->insert('tbl_orderprepare', $ready);
					$m++;
				}
			}

			$updatetData = array('order_status'     => 3);
			$this->db->where('order_id', $order_id);
			$this->db->update('customer_order', $updatetData);
			$this->_sync_order_status($order_id, 3);

			return $this->respondWithSuccess('Tous les articles sont prêts pour cette commande de cuisine', $output);
		}
	}
	public function allonlineorder()
	{
		$this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
		$this->form_validation->set_rules('kitchenid', 'kitchenid', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$output = $categoryIDs = array();
			$waiterid = $this->input->post('id', TRUE);
			$kitchenid = $this->input->post('kitchenid', TRUE);
			$orderlist = $this->Api_kitchen_model->allincomminglist($kitchenid);
			if (!empty($orderlist)) {
				$i = 0;
				foreach ($orderlist as $order) {
					$kitchenorder = $this->Api_kitchen_model->allincommingkitchen($order->order_id, $kitchenid);
					if ($kitchenorder == 1) {
						$output['orderinfo'][$i]['orderid'] = $order->order_id;
						$output['orderinfo'][$i]['customer'] = $order->customer_name;
						$output['orderinfo'][$i]['amount'] = $order->totalamount;
						$i++;
					}
				}
				return $this->respondWithSuccess('Liste des commandes entrantes', $output);
			} else {
				return $this->respondWithError('Aucune commande entrante trouvée !!!', $output);
			}
		}
	}
	public function viewonlineorder()
	{
		$this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
		$this->form_validation->set_rules('kitchenid', 'kitchenid', 'required|xss_clean|trim');
		$this->form_validation->set_rules('order_id', 'Order ID', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$output = $categoryIDs = array();
			$waiterid = $this->input->post('id', TRUE);
			$kitchenid = $this->input->post('kitchenid', TRUE);
			$order_id = $this->input->post('order_id', TRUE);

			$orderlist = $this->Api_kitchen_model->viewincommingkitchen($order_id, $kitchenid);

			if (!empty($orderlist)) {
				$i = 0;
				foreach ($orderlist as $order) {
					$kitchenorder = $this->Api_kitchen_model->allincommingkitchenview($order->order_id, $kitchenid, $order->menu_id, $order->variantid);
					if ($kitchenorder == 1) {
						$output['foodinfo'][$i]['OrderID'] = $order->order_id;
						$output['foodinfo'][$i]['FoodID'] = $order->menu_id;
						$output['foodinfo'][$i]['FoodName'] = $order->ProductName;
						$output['foodinfo'][$i]['qty'] = $order->menuqty;
						$output['foodinfo'][$i]['varientid'] = $order->variantid;
						$output['foodinfo'][$i]['varientname'] = $order->variantName;
						if (!empty($order->add_on_id)) {
							$output['foodinfo'][$i]['addons'] = 1;
							$addons = explode(",", $order->add_on_id);
							$addonsqty = explode(",", $order->addonsqty);
							$x = 0;
							foreach ($addons as $addonsid) {
								$adonsinfo = $this->Api_kitchen_model->read('*', 'add_ons', array('add_on_id' => $addonsid));
								$output['foodinfo'][$i]['addonslist'][$x]['aodonsname'] = $adonsinfo->add_on_name;
								$output['foodinfo'][$i]['addonslist'][$x]['aodonsqty'] = $addonsqty[$x];
								$x++;
							}
						} else {
							$output['foodinfo'][$i]['addons'] = 0;
						}
						$i++;
					}
				}
				return $this->respondWithSuccess('Liste des commandes entrantes', $output);
			} else {
				return $this->respondWithError('Aucune commande trouvée !!!', $output);
			}
		}
	}
	public function acceptorder()
	{
		$this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
		$this->form_validation->set_rules('order_id', 'Order ID', 'required|xss_clean|trim');
		$this->form_validation->set_rules('kitchenid', 'kitchenid', 'required|xss_clean|trim');
		$this->form_validation->set_rules('foodid', 'Food ID', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$output = $categoryIDs = array();
			$kitchen = $this->input->post('id', TRUE);
			$orderid = $this->input->post('order_id', TRUE);
			$kitchenid = $this->input->post('kitchenid', TRUE);
			$varientid = $this->input->post('varientid', TRUE);
			$foodid = $this->input->post('foodid', TRUE);
			$orderinfo = $this->db->select('*')->from('customer_order')->where('order_id', $orderid)->get()->row();
			$where2 = "tbl_kitchen_order.kitchenid in($kitchenid)";
			$kitcheninfo = $this->Api_kitchen_model->allincommingkitchenview($orderid, $kitchenid, $foodid, $varientid);

			if ($orderinfo->order_status == 5) {
				return $this->respondWithError('Cette commande est annulée par l\'administrateur. Veuillez en essayer une autre !!!', $output);
			} else if ($kitcheninfo == 0) {
				return $this->respondWithError('Cette commande est déjà attribuée. Veuillez en essayer une autre !!!', $output);
			} else {
				$kitchenorder['kitchenid']   		    = $kitchenid;
				$kitchenorder['orderid']   	        = $orderid;
				$kitchenorder['itemid']   	            = $foodid;
				$kitchenorder['varient']   	        = $varientid;
				$this->Api_kitchen_model->insert_data('tbl_kitchen_order',  $kitchenorder);
				$itemaccepted = array(
					'accepttime' => date('Y-m-d H:i:s'),
					'orderid'     => $orderid,
					'menuid'     => $foodid,
					'varient'     => $varientid
				);
				$this->db->insert('tbl_itemaccepted', $itemaccepted);
				return $this->respondWithSuccess('Commande Attribuer à la cuisine', $output);
			}
		}
	}
	public function cancelorder()
	{
		$this->form_validation->set_rules('order_id', 'Order ID', 'required|xss_clean|trim');
		$this->form_validation->set_rules('cancelreason', 'Cancel Reason', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$output = array();
			$orderid = $this->input->post('order_id', TRUE);
			$itemId = $this->input->post('itemId', TRUE);
			$reason = $this->input->post('cancelreason', TRUE);

			$orderinfo = $this->db->select('*')->from('customer_order')->where('order_id', $orderid)->get()->row();

			$foodname = $this->db->select("ProductName")->from('item_foods')->where('ProductsID', $itemId)->get()->row();

			/*PUSH Notification For Customer*/
			$customerinfo = $this->db->select("*")->from('customer_info')->where('customer_id', $orderinfo->customer_id)->get()->row();
			$this->load->library('notification');
			$this->notification->order_rejected($orderid, $foodname->ProductName, $reason, $customerinfo->customer_token);
			/* Restore stock for cancelled item if stock was already deducted
			   and the item has NOT been cooked yet */
			if ($orderinfo->orderacceptreject == 1) {
				$possetting = $this->db->select('productionsetting')->from('tbl_posetting')->where('possettingid', 1)->get()->row();
				if ($possetting->productionsetting == 1) {
					$this->load->model('App_android_model');
					$olditm = $this->db->select('menuqty,varientid,food_status')->from('order_menu')->where('order_id', $orderid)->where('menu_id', $itemId)->get()->row();
					if ($olditm && (empty($olditm->food_status) || $olditm->food_status == 0)) {
						$cancelqty = !empty($olditm->menuqty) ? $olditm->menuqty : 1;
						$cancelvid = $olditm->varientid;
						$this->App_android_model->restore_product($itemId, $cancelvid, $cancelqty);
					}
				}
			}
			$this->db->where('order_id', $orderid)->where('menu_id', $itemId)->delete('order_menu');
			$afterorderinfo = $this->db->select("*")->from('order_menu')->where('order_id', $orderid)->get()->row();
			if (empty($afterorderinfo)) {
				$updatetData = array('anyreason' => "Tous les articles ne sont pas disponibles", 'order_status' => 5, 'nofification' => 1, 'orderacceptreject' => 0);
				$this->db->where('order_id', $orderid);
				$this->db->update('customer_order', $updatetData);
			}
			return $this->respondWithSuccess('Commande rejetée', $output);
		}
	}
	public function completeorder()
	{
		$this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
		$this->form_validation->set_rules('start', 'start', 'required|xss_clean|trim');
		$this->form_validation->set_rules('kitchenid', 'kitchenid', 'required|xss_clean|trim');
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			return $this->respondWithValidationError($errors);
		} else {
			$waiterid = $this->input->post('id', TRUE);
			$start = $this->input->post('start', TRUE);
			$kitchenid = $this->input->post('kitchenid', TRUE);
			if ($start == 0) {
				$orderlist = $this->Api_kitchen_model->allorderlist2($waiterid, $status = 4, $kitchenid, $limit = 20);
			} else {
				$orderlist = $this->Api_kitchen_model->allorderlist2($waiterid, $status = 4, $start, $kitchenid, $limit = 20);
			}
			$totalorder = $this->Api_kitchen_model->count_comorder2($waiterid, $status = 4, $kitchenid);
			$output = $categoryIDs = array();
			if ($orderlist != FALSE) {
				$output['totalorder']        = $totalorder;
				$i = 0;
				foreach ($orderlist as $order) {
					$output['orderinfo'][$i]['order_id']        = $order->order_id;
					$output['orderinfo'][$i]['CustomerName']    = $order->customer_name;
					$output['orderinfo'][$i]['TableName']       = $order->tablename;
					$output['orderinfo'][$i]['OrderDate']       = $order->order_date;
					$output['orderinfo'][$i]['TotalAmount']     = $order->totalamount;
					$i++;
				}

				return $this->respondWithSuccess('Liste complète de commandes.', $output);
			} else {
				return $this->respondWithError('Commande introuvable.!!!', $output);
			}
		}
	}

	// ── Sync helper ───────────────────────────────────────────────────────────

	/**
	 * Enqueue une mise à jour de statut cuisine vers le VPS.
	 */
	private function _sync_order_status(int $order_id, int $status): void {
		try {
			$order = $this->db->where('order_id', $order_id)->get('customer_order')->row_array();
			if (!$order) return;

			// Ne pas ré-envoyer les commandes originaires du VPS
			if (($order['sync_origin'] ?? 'local') === 'vps') return;

			$this->load->library('Sync_manager');
			$this->sync_manager->enqueue(
				'customer_order',
				$order_id,
				'update',
				array_merge($order, ['order_status' => $status, 'synced_at' => date('Y-m-d H:i:s')])
			);
		} catch (Throwable $e) {
			log_message('error', '[V3::_sync_order_status] ' . $e->getMessage());
		}
	}
}
