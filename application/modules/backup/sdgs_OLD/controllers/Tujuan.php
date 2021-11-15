<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tujuan extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_sdgs_tujuan');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_sdgs_tujuan')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('sdgs/tujuan/index', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_pilar='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.TUJUAN = "'.$_POST['search_field'].'")';
        }

        if (isset($_POST['pilar']) && $_POST['pilar'] != NULL && $_POST['pilar'] != 'all' ) {
            $where_pilar = '(a.PILAR_ID = "'.$_POST['pilar'].'")';
        }

        if (isset($_POST['page']) && $_POST['page'] != NULL) {
            $page = $_POST['page'];
            $pageof = $_POST['page']-1;
            $offset = $pageof * $limit;
        }

        if (isset($_POST['limit']) && $_POST['limit'] != NULL) {
            $limit = $_POST['limit'];
        }

        $data['page'] = $page;
        $data['limit'] = $limit;

        $where = array_merge($where);
        $data['total_items'] = $this->m_sdgs_tujuan->get_list_total($where, $where_pilar, $like)->row('count');
        $data['list_items'] = $this->m_sdgs_tujuan->get_list_data($where, $where_pilar, $like, $limit, $offset);
        $this->load->view('sdgs/tujuan/v_list', $data );
    }

}