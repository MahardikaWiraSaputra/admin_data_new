<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_portal');

        // if( ! $this->ion_auth->logged_in() )
        //     redirect('/login');

        // if (!$this->ion_auth_acl->has_permission('kelola_analisa')) {
        //     redirect('/main/dashboard');
        // }  
    }

    // public function index(){
    //     $data = 'a';
    //     return $data;
    // }

    public function skpd(){
        $this->db->select('a.ID, a.NAMA_SKPD');
        $this->db->from('m_skpd AS a');
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua SKPD';
        foreach ($query as $row):
            $data[$row['ID']] = $row['NAMA_SKPD'];
        endforeach;
        return $data;
    }

}