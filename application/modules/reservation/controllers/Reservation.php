<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends MX_Controller {
    
    public function __construct()
    {
        parent::__construct();
		$this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
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

    // Only physically occupy the table if the reservation is active RIGHT NOW:
    // status=2 (booked) AND today is the reservation day AND current time is within the window.
    $reserve_from = date('H:i:s', strtotime($this->input->post('bookfromtime', true)));
    $reserve_to   = date('H:i:s', strtotime($this->input->post('bookendtime',  true)));
    $now_time     = date('H:i:s');

    $is_active_now = ($status == 2)
        && ($newdate === date('Y-m-d'))
        && ($now_time >= $reserve_from)
        && ($now_time <= $reserve_to);

    $bookstatus = $is_active_now ? 1 : 0; // rest_table: 1=occupied, 0=free

    $data['intinfo'] = "";
    $udata = array('status' => $bookstatus);

    if ($this->form_validation->run()) {

        // Block if no valid table selected
        if ((int)$tableid < 1) {
            $this->session->set_flashdata('exception', 'Please select a valid table.');
            redirect('reservation/reservation/index');
            return;
        }

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

            // Detect what changed before update
            $old = $data['reserveinfo'];
            $changes = [];
            if ($old->reserveday !== $newdate) {
                $changes[] = 'Date : ' . date('d/m/Y', strtotime($old->reserveday)) . ' → ' . date('d/m/Y', strtotime($newdate));
            }
            if ($old->formtime !== $this->input->post('bookfromtime', true)) {
                $changes[] = 'Heure de début : ' . $old->formtime . ' → ' . $this->input->post('bookfromtime', true);
            }
            if ($old->totime !== $this->input->post('bookendtime', true)) {
                $changes[] = 'Heure de fin : ' . $old->totime . ' → ' . $this->input->post('bookendtime', true);
            }
            if ($old->tableid != $this->input->post('tableid', true)) {
                $oldTable = $this->db->select('tablename')->from('rest_table')->where('tableid', $old->tableid)->get()->row();
                $newTable = $this->db->select('tablename')->from('rest_table')->where('tableid', $this->input->post('tableid', true))->get()->row();
                $changes[] = 'Table : ' . ($oldTable ? $oldTable->tablename : $old->tableid) . ' → ' . ($newTable ? $newTable->tablename : $this->input->post('tableid', true));
            }
            if ($old->person_capicity != $this->input->post('tablicapacity', true)) {
                $changes[] = 'Nombre de personnes : ' . $old->person_capicity . ' → ' . $this->input->post('tablicapacity', true);
            }

            if ($this->reservation_model->update($postData)) {

                // ------------------------- EMAIL -------------------------
                $this->load->helper('common_helper');

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

                if (!empty($changes)) {
                    // Modification email
                    $htmlContent = ReservationModifiedEmail($id, $changes);
                    $this->email->from($send_email->sender, 'Reservation Info');
                    $this->email->to($this->input->post('email', true));
                    $this->email->cc($send_email->sender);
                    $this->email->subject("Modification de votre réservation");
                    $this->email->message($htmlContent);
                    $this->email->send();
                } elseif ($this->input->post('status') == 2) {
                    // Confirmation email (no changes, just status update)
                    $htmlContent = ReservationConfirmedEmail($id, $this->input->post('mobile', true));
                    $this->email->from($send_email->sender, 'Reservation Info');
                    $this->email->to($this->input->post('email', true));
                    $this->email->cc($send_email->sender);
                    $this->email->subject("Booking Confirmation");
                    $this->email->message($htmlContent);
                    $this->email->send();

                    // ---------------- PUSH NOTIFICATION ----------------
                    $this->load->library('notification');
                    $this->notification->reservation_confirmed($customerinfo->customer_name, $reservationinfo->tablename, $customerinfo->customer_token);

                    // ---------------- AGENT WHATSAPP ----------------
                    // Le client qui a reserve depuis WhatsApp n'a ni e-mail
                    // renseigne, ni application installee : l'e-mail et la
                    // notification push ci-dessus ne l'atteignent pas. Sans ce
                    // rappel, sa table etait confirmee et il n'en savait rien.
                    //
                    // Appel « au mieux » : un agent injoignable ne doit pas
                    // empecher le personnel de confirmer une table.
                    $this->load->library('agentapi/agent_rappel');
                    $this->agent_rappel->notifier('reservation_confirmee', [
                        'reference' => (int) $id,
                        'telephone' => $customerinfo->customer_phone ?? '',
                        'date'      => $data['reserveinfo']->reserveday ?? '',
                        'heure'     => substr((string) ($data['reserveinfo']->formtime ?? ''), 0, 5),
                        'couverts'  => (int) ($data['reserveinfo']->person_capicity ?? 0),
                    ]);
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
		$data['tablelist']   = $this->reservation_model->table_dropdown();
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
        $data['booking_url'] = base_url('book');
        echo Modules::run('template/layout', $data);
	  }

  public function booking_qr()
  {
      $this->permission->method('reservation','read')->redirect();

      $url = base_url('book');

      try {
          $writer = new \Endroid\QrCode\Writer\PngWriter();
          $qrCode = \Endroid\QrCode\QrCode::create($url)
              ->setSize(220)
              ->setMargin(10);

          $result = $writer->write($qrCode);

          header('Content-Type: ' . $result->getMimeType());
          header('Cache-Control: public, max-age=86400');
          echo $result->getString();
      } catch (\Exception $e) {
          show_404();
      }
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

	// ── Arrival system API ──────────────────────────────────────────

	/**
	 * GET /reservation/reservation/today_reservations
	 * Returns today's confirmed reservations with pre-orders as JSON.
	 */
	public function today_reservations()
	{
		$reservations = $this->reservation_model->get_today_reservations();
		header('Content-Type: application/json');
		echo json_encode($reservations);
	}

	/**
	 * POST /reservation/reservation/confirm_arrival/{id}
	 * Converts pre-order to real kitchen order and marks customer as arrived.
	 */
	public function confirm_arrival($reserveid)
	{
		$reserveid = (int)$reserveid;
		$reservation = $this->reservation_model->get_reservation_with_preorder($reserveid);

		if (!$reservation || $reservation->status != 2 || $reservation->arrival_status != 0) {
			header('Content-Type: application/json');
			http_response_code(400);
			echo json_encode(['error' => 'Réservation invalide ou déjà traitée.']);
			return;
		}

		$order_id = null;

		// Convert pre-order to real order if items exist
		if (!empty($reservation->preorder_items)) {
			$this->load->model('ordermanage/order_model');
			$order_id = $this->order_model->create_order_from_preorder(
				$reserveid,
				$reservation->cid,
				$reservation->tableid,
				$reservation->preorder_items
			);
		}

		// Mark arrived
		$this->reservation_model->mark_arrived($reserveid, $order_id);

		// Set table as occupied
		$this->db->where('tableid', $reservation->tableid)
			->update('rest_table', ['status' => 1]);

		// Send notification to staff
		$this->load->library('notification');
		$customer_name = $reservation->customer ? $reservation->customer->customer_name : 'Client';
		$table_name = $reservation->table ? $reservation->table->tablename : 'Table ' . $reservation->tableid;
		$this->notification->reservation_arrived($customer_name, $table_name, $order_id);

		header('Content-Type: application/json');
		echo json_encode([
			'success'  => true,
			'order_id' => $order_id,
			'message'  => $order_id
				? 'Client arrivé — commande #' . $order_id . ' envoyée en cuisine.'
				: 'Client arrivé — aucune pré-commande à convertir.',
		]);
	}

	/**
	 * POST /reservation/reservation/mark_noshow/{id}
	 */
	public function mark_noshow($reserveid)
	{
		$reserveid = (int)$reserveid;
		$reservation = $this->reservation_model->findById($reserveid);

		if (!$reservation || $reservation->arrival_status != 0) {
			header('Content-Type: application/json');
			http_response_code(400);
			echo json_encode(['error' => 'Réservation invalide.']);
			return;
		}

		$this->reservation_model->mark_noshow($reserveid);

		// Free the table
		$this->db->where('tableid', $reservation->tableid)
			->update('rest_table', ['status' => 0]);

		header('Content-Type: application/json');
		echo json_encode(['success' => true, 'message' => 'Réservation marquée comme no-show.']);
	}

	/**
	 * GET /reservation/reservation/qr_checkin_alerts
	 * Returns reservations flagged by QR scan (for POS polling).
	 */
	public function qr_checkin_alerts()
	{
		$alerts = $this->db
			->select('r.reserveid, r.formtime, r.person_capicity,
			          c.customer_name, t.tablename')
			->from('tblreservation r')
			->join('customer_info c', 'c.customer_id = r.cid', 'left')
			->join('rest_table t', 't.tableid = r.tableid', 'left')
			->where('r.reserveday', date('Y-m-d'))
			->where('r.status', 2)
			->where('r.arrival_status', 0)
			->where('r.qr_checkin_pending', 1)
			->get()->result();

		header('Content-Type: application/json');
		echo json_encode($alerts ?: []);
	}

	/**
	 * POST /reservation/reservation/dismiss_qr_alert/{id}
	 */
	public function dismiss_qr_alert($reserveid)
	{
		$this->db->where('reserveid', (int)$reserveid)
			->update('tblreservation', ['qr_checkin_pending' => 0]);

		header('Content-Type: application/json');
		echo json_encode(['success' => true]);
	}

	public function check_table_exists($tableid)
	{
		if ((int)$tableid < 1) {
			$this->form_validation->set_message('check_table_exists', 'Please select a valid table.');
			return false;
		}
		$exists = $this->db->where('tableid', (int)$tableid)->count_all_results('rest_table');
		if (!$exists) {
			$this->form_validation->set_message('check_table_exists', 'The selected table does not exist.');
			return false;
		}
		return true;
	}
}
