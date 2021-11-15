<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function template_view($data = NULL)
	{
		$this->load->view('dashboard',$data);
	}
	public function template_main($data = NULL)
	{
		$this->load->view('main/dashboard',$data);
	}

	public function template_admin($data = NULL)
	{
		$this->load->view('admin/dashboard',$data);
	}

}

