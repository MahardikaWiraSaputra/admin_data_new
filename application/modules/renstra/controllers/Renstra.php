<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Renstra extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_renstra_data');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_renstra_indikator')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('renstra/indikator/index', $data);
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
        $data['total_items'] = $this->m_renstra_data->get_list_total($where, $where_urusan, $like)->row('count');
        $data['item_program'] = $this->m_renstra_data->get_list_program($where, $where_urusan, $like, $limit, $offset);
        foreach($data['item_program'] as $key =>$val){
            $indikator = $this->m_renstra_data->get_list_data($val['ID_PROGRAM']);
            if($indikator){
                $data['list_items'][$val['ID_PROGRAM']] = $indikator;
            }
        }
        $this->load->view('renstra/indikator/v_list', $data );
    }

    public function ceklist_indikator(){
        $where_urusan = $_POST['urusan_id'];
        $like = array();
        if (isset($_POST['cari_indikator']) && $_POST['cari_indikator'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['cari_indikator']);
        }
        $data['list_items'] = $this->m_renstra_data->ceklist_indikator($where_urusan,$like);
        $this->load->view('renstra/indikator/v_indikator_ceklist', $data);
    }

    public function tambah($id){
        // $data['sasaran_list'] = $this->m_renstra_program->get_sasaran_dropdown();
        $data['program_list'] = $this->m_renstra_data->get_program_dropdown();
        $data['kegiatan_list'] = $this->m_renstra_data->get_kegiatan_dropdown();
        $data['skpd_list'] = $this->m_renstra_data->get_skpd_dropdown();
        $urusan = $this->m_renstra_data->get_urusan_by_id($id);
        $data['detail'] = $this->m_renstra_data->detail($id);
        $this->load->view('renstra/indikator/v_tambah', $data);
    }

    public function simpan_indikator() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_kegiatan_id', 'Urusan Pemda', 'trim|required');
        // $this->form_validation->set_rules('f_indikator', 'Sasaran Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $kegiatan = $this->input->post('f_kegiatan_id');
            $indikators = $this->input->post('f_indikator[]');
            $query = $this->m_renstra_data->insert_indikator($kegiatan, $indikators);

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