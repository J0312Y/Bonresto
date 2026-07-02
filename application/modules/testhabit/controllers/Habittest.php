<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Habittest extends MX_Controller
{
	public $version='';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
			'logs_model'
        ));
		$this->version=1;
        //$this->auth->check_admin_auth();
    }

    public function index()
    {
        
    }
	
	

}
