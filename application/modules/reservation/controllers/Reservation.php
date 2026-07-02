<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends MX_Controller {
    
    public function __construct()
    {
        parent::__construct();
		$this->db->query('SET SESSION sql_mode = ""');
		$this->load->model(array(
			'reservation_model',
			'logs_model'
		));	
    }
 
    public function index($id = null)
    {
        
		$this->permission->method('reservation','read')->redirect();
        $data['title']    = display('reservation'); 
        #-------------------------------#       
        #
        #pagination starts
        #
        $config["base_url"] = base_url('reservation/reservation/index');
        $config["total_rows"]  = $this->reservation_model->count_reservation();
        $config["per_page"]    = 25;
        $config["uri_segment"] = 4;
        $config["last_link"] = "Last"; 
        $config["first_link"] = "First"; 
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';  
        $config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["reserve"] = $this->reservation_model->read_reservation($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
		$data['pagenum']=$page;
		if(!empty($id)) {
		$data['title'] = display('update');
		$data['intinfo']   = $this->reservation_model->findById($id);
	   }
	   $data['tablelist']     = $this->reservation_model->table_dropdown();
	   $data['customerlist']   = $this->reservation_model->customer_dropdown();
        #
        #pagination ends
        #   
        $data['module'] = "reservation";
        $data['page']   = "reservationlist";   
        echo Modules::run('template/layout', $data); 
    }
	
	public function tablebooking(){
		$this->permission->method('reservation','read')->redirect();
		$data['title'] = display('take_reservation');
		$data["tableinfo"] = $this->reservation_model->read_gettable();
	   $data['module'] = "reservation";
	   $data['page']   = "bookingatable";   
	   echo Modules::run('template/layout', $data);
		}
	public function reservationform(){
		$this->permission->method('reservation','update')->redirect();
		$data['title'] = display('update');
		$id=$this->input->post('id');
		$startdate= $this->input->post('sltime');
		$endate=date( "H:i:s", strtotime($startdate)+(60*30));
		$data['tableno']=$this->input->post('id');
		$data['newdate']=$this->input->post('sdate',true);
		$data['gettime']=$this->input->post('sltime',true);
		$data['endtime']=$endate;
		$data['nopeople']=$this->input->post('people',true);
		$data['formdtable']=$this->reservation_model->checktable($id);
	    $data['customerlist']   = $this->reservation_model->customer_dropdown();
        $data['module'] = "reservation";  
        $data['page']   = "reservationfrm";
		$this->load->view('reservation/reservationfrm', $data);
		}
public function create($id = null)
{
    $this->permission->method('reservation','create')->redirect();
    $data['title'] = display('take_reservation');

    // Validation
    $this->form_validation->set_rules('customer_name',"Customer Name",'required');
    $this->form_validation->set_rules('tableid',"Table No"  ,'required');
    $this->form_validation->set_rules('tablicapacity', "No. of Person" ,'required');
    $this->form_validation->set_rules('bookfromtime', display('s_time')  ,'required');
    $this->form_validation->set_rules('bookendtime', display('e_time')  ,'required');
    $this->form_validation->set_rules('bookdate', display('date')  ,'required');
    $this->form_validation->set_rules('status', display('status')  ,'required');

    $id = $this->input->post('reserveid');

    // ------ DATE FORMAT ------
    $bookdate = str_replace('/','-',$this->input->post('bookdate',true));
    $newdate = date('Y-m-d', strtotime($bookdate));

    // ------ 🔒 CHECK UNAVAILABLE DATE ------
    $unavailable = $this->db->select('*')
        ->from('reservationofday')
        ->where('DATE(offdaydate)', $newdate)
        ->where('is_active', 1)
        ->get()
        ->row();

    if ($unavailable) {
        $this->session->set_flashdata('exception', 'Impossible de réserver : cette date est indisponible.');
        redirect('reservation/reservation/index');
        exit;
    }
    // ------ END CHECK ------

    $tableid = $this->input->post('tableid');
    $status  = $this->input->post('status');

    $bookstatus = ($status == 1 ? 0 : 1);

    $data['intinfo'] = "";
    $udata = array('status' => $bookstatus);

    if ($this->form_validation->run()) {

        // ---------------------------------------------------------
        // 🔹 INSERT (create)
        // ---------------------------------------------------------
        if (empty($this->input->post('reserveid'))) {
            $this->permission->method('reservation','create')->redirect();

            $logData = array(
                'action_page' => "Reservation List",
                'action_done' => "Insert Data",
                'remarks' => "New Reservation Created",
                'user_name' => $this->session->userdata('fullname'),
                'entry_date' => date('Y-m-d H:i:s'),
            );

            $customerData = array(
                'customer_name' => $this->input->post('customer_name',true),
                'customer_email' => $this->input->post('email',true),
                'customer_address' => "t",
                'customer_phone' => $this->input->post('mobile',true),
                'favorite_delivery_address' => "t",
                'is_active' => 1,
            );

            $mobile = $this->input->post('mobile',true);
            $rerturnid = $this->reservation_model->insertcustomer($customerData,$mobile);

            $data['units'] = (Object) $postData = array(
                'reserveid' => $this->input->post('reserveid'),
                'cid' => $rerturnid,
                'tableid' => $this->input->post('tableid',true),
                'person_capicity' => $this->input->post('tablicapacity',true),
                'formtime' => $this->input->post('bookfromtime',true),
                'totime' => $this->input->post('bookendtime',true),
                'reserveday' => $newdate,
                'status' => $this->input->post('status',true),
            );

            if ($this->reservation_model->create($postData)) {

                $insert_id = $this->db->insert_id();
                $this->logs_model->log_recorded($logData);

                $this->db->where('tableid',$tableid);
                $this->db->update('rest_table',$udata);

                // EMAIL
                $send_email = $this->reservation_model->read('*', 'email_config', array('email_config_id' => 1));

                $config = array(
                    'protocol'  => $send_email->protocol,
                    'smtp_host' => $send_email->smtp_host,
                    'smtp_port' => $send_email->smtp_port,
                    'smtp_user' => $send_email->sender,
                    'smtp_pass' => $send_email->smtp_password,
                    'mailtype'  => $send_email->mailtype,
                    'charset'   => 'utf-8'
                );

                $this->load->library('email');
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->set_mailtype("html");

                $htmlContent = ReservationEmail($insert_id,$mobile);
                $this->email->from($send_email->sender, 'Reservation Info');
                $this->email->to($this->input->post('email',true));
                $this->email->cc($send_email->sender);
                $this->email->subject("Booking Information");
                $this->email->message($htmlContent);
                $this->email->send();

                $this->session->set_flashdata('message', display('save_successfully'));
                redirect('reservation/reservation/index');
            }

            $this->session->set_flashdata('exception', display('please_try_again'));
            redirect("reservation/reservation/index");

        } 

        // ---------------------------------------------------------
        // 🔹 UPDATE (edit)
        // ---------------------------------------------------------
        else {
            $this->permission->method('reservation','update')->redirect();

            $logData = array(
                'action_page' => "Reservation List",
                'action_done' => "Update Data",
                'remarks' => "Reservation Updated",
                'user_name' => $this->session->userdata('fullname'),
                'entry_date' => date('Y-m-d H:i:s'),
            );

            if (!empty($id)) {
                $data['reserveinfo'] = $this->reservation_model->findById($id);
            }

            $data['units'] = (Object) $postData = array(
                'reserveid' => $this->input->post('reserveid'),
                'cid' => $data['reserveinfo']->cid,
                'tableid' => $this->input->post('tableid',true),
                'person_capicity' => $this->input->post('tablicapacity',true),
                'formtime' => $this->input->post('bookfromtime',true),
                'totime' => $this->input->post('bookendtime',true),
                'reserveday' => $newdate,
                'status' => $this->input->post('status',true),
            );

            $userdata = array(
                'customer_name' => $this->input->post('customer_name',true),
                'customer_email' => $this->input->post('email',true),
                'customer_phone' => $this->input->post('mobile',true),
            );

            $customerinfo = $this->db->select("*")->from('customer_info')->where('customer_id',$data['reserveinfo']->cid)->get()->row();
            $reservationinfo = $this->db->select("*")->from('tblreservation')->where('cid',$data['reserveinfo']->cid)->get()->row();

            if ($this->reservation_model->update($postData)) {

                // ------------------------- EMAIL + PUSH -------------------------
                $this->load->helper('common_helper');
                
                if ($this->input->post('status') == 2) { // 2 = Confirmer/Booked

                    $send_email = $this->reservation_model->read('*', 'email_config', array('email_config_id' => 1));

                    $config = array(
                        'protocol'  => $send_email->protocol,
                        'smtp_host' => $send_email->smtp_host,
                        'smtp_port' => $send_email->smtp_port,
                        'smtp_user' => $send_email->sender,
                        'smtp_pass' => $send_email->smtp_password,
                        'mailtype'  => $send_email->mailtype,
                        'charset'   => 'utf-8'
                    );

                    $this->load->library('email');
                    $this->email->initialize($config);
                    $this->email->set_newline("\r\n");
                    $this->email->set_mailtype("html");

                    //Utilisation de la fonction de confirmation
                    $htmlContent = ReservationConfirmedEmail($id,$this->input->post('mobile',true)); 
                    
                    $this->email->from($send_email->sender, 'Reservation Info');
                    $this->email->to($this->input->post('email',true));
                    $this->email->cc($send_email->sender);
                    $this->email->subject("Booking Confirmation"); // Subject plus clair pour la confirmation
                    $this->email->message($htmlContent);
                    $this->email->send();

                    // ---------------- PUSH NOTIFICATION ----------------
                    $this->load->library('notification');
                    $this->notification->reservation_confirmed($customerinfo->customer_name, $reservationinfo->tablename, $customerinfo->customer_token);
                }
                // -----------------------------------------------------

                $this->logs_model->log_recorded($logData);

                $this->db->where('tableid',$tableid);
                $this->db->update('rest_table',$udata);
                $this->db->where('customer_id',$data['reserveinfo']->cid);
                $this->db->update('customer_info',$userdata);

                $this->session->set_flashdata('message', display('update_successfully'));
            }
            else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }

            redirect("reservation/reservation/index");
        }

    }
    else {
        // -------- VIEW PART --------
        if(!empty($id)) {
            $data['title'] = display('update');
            $data['intinfo'] = $this->reservation_model->findById($id);
            $data['customerinfo'] = $this->reservation_model->findByCusId($data['intinfo']->cid);
            $data['tableinfo'] = $this->reservation_model->findBytableId($data['intinfo']->tableid);
        }

        $data['module'] = "reservation";
        $data['page'] = "reservationlist";   
        echo Modules::run('template/layout', $data); 
    }
}

   public function updateintfrm($id){
		$this->permission->method('reservation','update')->redirect();
		$data['title'] = display('update');
		$data['intinfo']   = $this->reservation_model->findById($id);
		$data['customerinfo']   = $this->reservation_model->findByCusId($data['intinfo']->cid);
		$data['tableinfo']   = $this->reservation_model->findBytableId($data['intinfo']->tableid);
		$updatetData = array('notif' =>1);
		$this->db->where('reserveid',$id);
		$this->db->update('tblreservation',$updatetData);
        $data['module'] = "reservation";  
        $data['page']   = "reservationedit";
		$this->load->view('reservation/reservationedit', $data);   
       
	   }
 
    public function delete($category = null)
    {
        $this->permission->module('reservation','delete')->redirect();
		$logData = array(
	   'action_page'         => "reservation List",
	   'action_done'     	 => "Delete Data", 
	   'remarks'             => "reservation Deleted",
	   'user_name'           => $this->session->userdata('fullname'),
	   'entry_date'          => date('Y-m-d H:i:s'),
	  );
		// Get reservation's table ID before deleting so we can free the table
		$reservation = $this->db->select('tableid')->from('tblreservation')->where('reserveid', $category)->get()->row();

		if ($this->reservation_model->delete($category)) {
			// Free the table when reservation is deleted
			if (!empty($reservation->tableid)) {
				$this->db->where('tableid', $reservation->tableid)->update('rest_table', ['status' => 0]);
			}
			#Store data to log table.
			 $this->logs_model->log_recorded($logData);
			#set success message
			$this->session->set_flashdata('message',display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception',display('please_try_again'));
		}
		redirect('reservation/reservation/index');
    }
	
	public function checkavailablity(){
		$this->permission->method('reservation','read')->redirect();
		$numofpeople=$this->input->post('people',true);
		$bookdate = str_replace('/','-',$this->input->post('getdate'));
		$newdate = date('Y-m-d' , strtotime($bookdate));
			$gettable=$this->reservation_model->checkavailtable();
			$data['tableinfo']=$this->reservation_model->checkfree($gettable,$numofpeople);
			$data['newdate']= $newdate;
			$data['gettime']=$this->input->post('time',true);
			$data['nopeople']=$numofpeople;
			$data['module'] = "reservation";  
			$data['page']   = "checkavail";
			$this->load->view('reservation/checkavail', $data);
		}
 public function chart(){
	        $data['category']=$this->reservation_model->getproduct();
			$data['quantity']=$this->reservation_model->getquantity();
		    $data['module'] = "reservation";  
			$data['page']   = "chart";
			echo Modules::run('template/layout', $data); 
		}
public function notification(){
			$notify=$this->db->select("*")->from('tblreservation')->where('notif',0)->get()->num_rows();
			
			$data = array(
				'unseen_reservation'  => $notify
			);
		echo json_encode($data);
		}
//restaurant Unavailable Section
	public function unavailablelist($id=null)
    {
        
		$this->permission->method('reservation','read')->redirect();
        $data['title']    = display('reservation_on_off'); 
		$data["reservationoffdays"] = $this->reservation_model->alloffdays();
        $data['module'] = "reservation";
        $data['page']   = "unavailablelist";   
        echo Modules::run('template/layout', $data); 
    }
	public function unavailablecreate($id = null)
    {
	   $this->permission->method('reservation','create')->redirect();
	   $data['title'] = display('add_unavailablity');
	  #-------------------------------#
		$this->form_validation->set_rules('unavaildate',display('unavaildate')  ,'required');
		$this->form_validation->set_rules('fromtime',"From Date"  ,'required');
		$this->form_validation->set_rules('totime',"To Date"  ,'required');
		$this->form_validation->set_rules('status', display('status')  ,'required');
	    $avtime=$this->input->post('fromtime',true)."-".$this->input->post('totime',true);
	  
	  $data['intinfo']="";
	  $data['available']   = (Object) $postData = [
	   'offdayid'          	  => $this->input->post('offdayid'),
	   'offdaydate' 	      => $this->input->post('unavaildate',true),
	   'availtime' 	 	      => $avtime,
	   'is_active' 	 	      => $this->input->post('status',true),
	  ];
	  if ($this->form_validation->run()) { 
	   if (empty($this->input->post('offdayid'))) {
		$this->permission->method('reservation','create')->redirect();
		
	 $logData = [
	   'action_page'         => "Reservation unavailablity",
	   'action_done'     	 => "Insert Data", 
	   'remarks'             => "New Reservation unavailablity Created",
	   'user_name'           => $this->session->userdata('fullname'),
	   'entry_date'          => date('Y-m-d H:i:s'),
	  ];
		if ($this->reservation_model->unavailablecreate($postData)) { 
		 $this->logs_model->log_recorded($logData);
		 $this->session->set_flashdata('message', display('save_successfully'));
		 redirect('reservation/reservation/unavailablelist');
		} else {
		 $this->session->set_flashdata('exception',  display('please_try_again'));
		}
		redirect("reservation/reservation/unavailablelist"); 
	
	   } else {
		$this->permission->method('reservation','update')->redirect();
	  $logData = array(
			   'action_page'         => "Reservation unavailablity",
			   'action_done'     	 => "Update Data", 
			   'remarks'             => "Reservation unavailablity Updated",
			   'user_name'           => $this->session->userdata('fullname'),
			   'entry_date'          => date('Y-m-d H:i:s'),
			 );

		if ($this->reservation_model->updateunavail($postData)) { 
		 $this->logs_model->log_recorded($logData);
		 $this->session->set_flashdata('message', display('update_successfully'));
		} else {
		$this->session->set_flashdata('exception',  display('please_try_again'));
		}
		redirect("reservation/reservation/unavailablelist");  
	   }
	  } else { 
	   if(!empty($id)) {
		$data['title'] = display('edit_unavailablity');
		$data['intinfo']   = $this->reservation_model->findByIdunavail($id);
	   }
	   $data['module'] = "reservation";
	   $data['page']   = "unavailablelist";   
	   echo Modules::run('template/layout', $data); 
	   }   
 
    }
   public function updateunavailfrm($id){
		$this->permission->method('reservation','update')->redirect();
		$data['title'] = display('edit_unavailablity');
		$data['intinfo']   = $this->reservation_model->findByIdunavail($id);
        $data['module'] = "edit_unavailablity";  
        $data['page']   = "unavailabledit";
		$this->load->view('reservation/unavailabledit', $data);   
      
	   }
 
    public function deleteunavailable($category = null)
    {
        $this->permission->module('reservation','delete')->redirect();
			$logData = array(
			   'action_page'         => "Reservation unavailablity",
			   'action_done'     	 => "Delete Data", 
			   'remarks'             => "Reservation unavailablity Deleted",
			   'user_name'           => $this->session->userdata('fullname'),
			   'entry_date'          => date('Y-m-d H:i:s'),
			  );
		if ($this->reservation_model->deleteunavailable($category)) {
			#Store data to log table.
			 $this->logs_model->log_recorded($logData);
			#set success message
			$this->session->set_flashdata('message',display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception',display('please_try_again'));
		}
		redirect('reservation/reservation/unavailablelist');
    }
  public function setting(){
	    $this->permission->method('reservation','read')->redirect();
        $data['title']    = display('reservasetting'); 
		$data["setting"] = $this->reservation_model->read('*', 'setting', array('id' => 2));
        $data['module'] = "reservation";
        $data['page']   = "reservationsetting";   
        echo Modules::run('template/layout', $data); 
	  }
  public function settingsave(){
	  	$this->permission->method('reservation','update')->redirect();
	    $data['title'] = display('reservasetting');
		#-------------------------------#
		$this->form_validation->set_rules('opentime',display('opening_time'),'required|max_length[50]');
		$this->form_validation->set_rules('closetime', display('closeTime') ,'required|max_length[255]');
		$this->form_validation->set_rules('maxperson',display('max_reserveperson'),'required|max_length[100]');
		

		$data['setting'] = (object)$postData = array(
		    'id'	  			  => $this->input->post('id',TRUE),
			'reservation_open'	  => $this->input->post('opentime',TRUE),
			'reservation_close'	  => $this->input->post('closetime',TRUE),
			'maxreserveperson'	  => $this->input->post('maxperson',TRUE)
		); 
		#-------------------------------#
		if ($this->form_validation->run() === true) {
				if ($this->reservation_model->updatesetting($postData)) {
					#set success message
					$this->session->set_flashdata('message',display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				} 
			redirect('reservation/reservation/setting');
		} else { 
			$data["setting"] = $this->reservation_model->read('*', 'setting', array('id' => 2));
			$data['module'] = "reservation";  
			$data['page']   = "reservationsetting";  
			echo Modules::run('template/layout', $data); 
		}  
	  }
}
