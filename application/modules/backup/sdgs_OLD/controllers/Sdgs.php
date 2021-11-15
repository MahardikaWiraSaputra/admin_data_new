<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sdgs extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_sdgs_data');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_sdgs')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('sdgs/indikator/index', $data);
    }

    public function get_tujuan($id = false){
        $data['filter_tujuan'] = $this->m_sdgs_data->dropdown_tujuan($id);
        $this->load->view('sdgs/indikator/v_filter_tujuan', $data);
    }    

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_pilar='';
        $where_tujuan='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.INDIKATOR = "'.$_POST['search_field'].'")';
        }

        if (isset($_POST['pilar']) && $_POST['pilar'] != NULL && $_POST['pilar'] != 'all' ) {
            $where_pilar = '(b.PILAR_ID = "'.$_POST['pilar'].'")';
        }

        if (isset($_POST['tujuan']) && $_POST['tujuan'] != NULL && $_POST['tujuan'] != 'all' ) {
            $where_pilar = '(c.TUJUAN_ID = "'.$_POST['tujuan'].'")';
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
        $data['total_items'] = $this->m_sdgs_data->get_list_total($where, $where_pilar, $where_tujuan, $like)->row('count');
        $data['item_target'] = $this->m_sdgs_data->get_list_target($where, $where_pilar, $where_tujuan, $like, $limit, $offset);
        foreach($data['item_target'] as $key =>$val){
            $indikator = $this->m_sdgs_data->get_list_data($val['TARGET_ID']);
            if($indikator){
                $data['list_items'][$val['TARGET_ID']] = $indikator;
            }
        }
        $this->load->view('sdgs/indikator/v_list', $data );
    }

}