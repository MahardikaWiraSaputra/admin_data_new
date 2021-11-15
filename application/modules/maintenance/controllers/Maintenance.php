<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->auth->cek_auth();
        // $this->load->model('model_apps');
    }

    public function index(){
        $data = '';
        $this->load->view('maintenance/index', $data);
    }


}