<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spm extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_spm_data');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_spm')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('spm/indikator/index', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_urusan='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.INDIKATOR = "'.$_POST['search_field'].'")';
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL && $_POST['urusan'] != 'all' ) {
            $where_urusan = '(a.URUSAN_ID = "'.$_POST['urusan'].'")';
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
        $data['total_items'] = $this->m_spm_data->get_list_total($where, $where_urusan, $like)->row('count');
        $data['item_sasaran'] = $this->m_spm_data->get_list_sasaran($where, $where_urusan, $like, $limit, $offset);
        foreach($data['item_sasaran'] as $key =>$val){
            $indikator = $this->m_spm_data->get_list_data($val['ID']);
            if($indikator){
                $data['list_items'][$val['ID']] = $indikator;
            }
        }
        $this->load->view('spm/indikator/v_list', $data );
    }

}