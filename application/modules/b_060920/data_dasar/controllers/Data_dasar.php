<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_dasar extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_data_dasar');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_data_dasar')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('data_dasar/data/index', $data);
    }

    public function get_urusan($id = false){
        $data['filter_urusan'] = $this->m_data_dasar->dropdown_urusan($id);
        $this->load->view('data_dasar/data/v_filter_urusan', $data);
    }    

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_skpd='';
        $where_urusan = '';
        $where_tipe = '';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['search_field']);
        }

        if (isset($_POST['skpd']) && $_POST['skpd'] != NULL && $_POST['skpd'] != 'all') {
            $where_skpd = '(a.SKPD_ID = "'.$_POST['skpd'].'")';
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL && $_POST['urusan'] != 'all') {
            $where_urusan = '(a.URUSAN_ID = "'.$_POST['urusan'].'")';
        }

        if (isset($_POST['tipe']) && $_POST['tipe'] != NULL && $_POST['tipe'] != 'all') {
            $where_urusan = '(a.TIPE_DATA = "'.$_POST['tipe'].'")';
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
        $data['total_items'] = $this->m_data_dasar->get_list_total($where, $where_skpd, $where_urusan, $where_tipe, $like)->row('count');
        $data['list_items'] = $this->m_data_dasar->get_list_data($where, $where_skpd, $where_urusan, $where_tipe, $like, $limit, $offset);
        $this->load->view('data_dasar/data/v_list', $data );
    }

}