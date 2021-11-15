<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dropdown extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_dropdown');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');       
    }

    public function get_urusan($id = false){
        $data['filter_urusan'] = $this->m_dropdown->dropdown_urusan($id);
        $this->load->view('v_filter_urusan', $data);
    } 

    public function filter_tipe(){
        $tipe = $this->m_dropdown->dropdown_filter();
        return $tipe;
    } 



}