<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpjmd extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_rpjmd_data');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_rpjmd_indikator')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('rpjmd/indikator/index', $data);
    }

    public function daftar(){
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
            $where_urusan = '(a.ID_URUSAN = "'.$_POST['urusan'].'")';
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
        $data['total_items'] = $this->m_rpjmd_data->get_list_total($where, $where_urusan, $like)->row('count');
        $data['item_program'] = $this->m_rpjmd_data->get_list_program($where, $where_urusan, $like, $limit, $offset);
        foreach($data['item_program'] as $key =>$val){
            $indikator = $this->m_rpjmd_data->get_list_data($val['ID_PROGRAM']);
            if($indikator){
                $data['list_items'][$val['ID_PROGRAM']] = $indikator;
            }
        }
        $this->load->view('rpjmd/indikator/v_list', $data );
    }

    public function tambah($id){
        $urusan = $this->m_rpjmd_data->get_urusan_by_id($id);
        $data['detail'] = $this->m_rpjmd_data->detail($id);
        $data['ceklist'] = $this->m_rpjmd_data->ceklist_indikator($urusan->URUSAN_ID);
        $this->load->view('rpjmd/indikator/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_program', 'Urusan Pemda', 'trim|required');
        // $this->form_validation->set_rules('f_indikator', 'Sasaran Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $program = $this->input->post('f_program');
            $indikators = $this->input->post('f_indikator[]');
            $query = $this->m_rpjmd_data->insert_indikator($program, $indikators);

            if ($query) {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DISIMPAN';
            }
            else {
                $output['success'] = false;
                $output['message'] = 'DATA GAGAL DISIMPAN';
            }
        } 
        else {
            $output['success'] = false;
            $output['message'] = 'DATA GAGAL DISIMPAN';
        }
        echo json_encode($output);
    }
}