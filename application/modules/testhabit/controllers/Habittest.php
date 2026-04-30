<?php
/*
 * @System      : Software Addon Module
 * @developer   : Md.Mamun Khan Sabuj
 * @E-mail      : mamun.sabuj24@gmail.com
 * @datetime    : 10-10-2020
 * @version     : Version 1.0
 */
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
