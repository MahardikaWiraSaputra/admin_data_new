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
        $data['filter_pilar'] = $this->m_sdgs_data->filter_pilar();
        $this->load->view('sdgs/indikator/index', $data);
    }

    public function filter_tujuan($id){
        $data['filter_tujuan'] = $this->m_sdgs_data->filter_tujuan($id);
        $this->load->view('sdgs/indikator/v_filter_tujuan', $data);
    }

    public function filter_target($id){
        $data['filter_target'] = $this->m_sdgs_data->filter_target($id);
        $this->load->view('sdgs/indikator/v_filter_target', $data);
    }    

    public function form_tujuan($id = false){
        $data['form_tujuan'] = $this->m_sdgs_data->form_tujuan($id);
        $this->load->view('sdgs/indikator/v_form_tujuan', $data);
    }    

    public function form_target($id = false){
        $data['form_target'] = $this->m_sdgs_data->form_target($id);
        $this->load->view('sdgs/indikator/v_form_target', $data);
    }    

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_pilar='';
        $where_tujuan='';
        $where_target='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('e.INDIKATOR' => $_POST['search_field']);
        }

        if (isset($_POST['pilar']) && $_POST['pilar'] != NULL && $_POST['pilar'] != 'all' ) {
            $where_pilar = '(c.PILAR_ID = "'.$_POST['pilar'].'")';
        }

        if (isset($_POST['tujuan']) && $_POST['tujuan'] != NULL && $_POST['tujuan'] != 'all' ) {
            $where_pilar = '(b.TUJUAN_ID = "'.$_POST['tujuan'].'")';
        }

        if (isset($_POST['target']) && $_POST['target'] != NULL && $_POST['target'] != 'all' ) {
            $where_target = '(a.TARGET_ID = "'.$_POST['target'].'")';
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
        $data['total_items'] = $this->m_sdgs_data->get_list_total($where, $where_pilar, $where_tujuan, $where_target, $like)->row('count');
        $data['list_items'] = $this->m_sdgs_data->get_list_data($where, $where_pilar, $where_tujuan, $where_target, $like, $limit, $offset);

        $this->load->view('sdgs/indikator/v_list', $data );
    }

    public function tambah(){
        $data['form_pilar'] = $this->m_sdgs_data->form_pilar();
        $this->load->view('sdgs/indikator/v_tambah', $data);
    }


    public function ceklist_indikator(){
        $like = array();
        if (isset($_POST['cari_indikator']) && $_POST['cari_indikator'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['cari_indikator']);
        }
        $data['list_items'] = $this->m_sdgs_data->ceklist_indikator($like);
        $this->load->view('sdgs/indikator/v_indikator_ceklist', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_target', 'Target Pembangunan', 'trim|required|numeric');
        if($this->form_validation->run()) {
            $target = $this->input->post('f_target');
            $indikators = $this->input->post('f_indikator[]');
            $query = $this->m_sdgs_data->insert_indikator($target, $indikators);

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

    public function delete($id){
        if($id) {         
            $query = $this->m_sdgs_data->delete_indikator($id);
            if ($query) {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DIHAPUS';
            }
            else {
                $output['success'] = false;
                $output['message'] = 'DATA GAGAL DIHAPUS';
            }
        } else {
            $output['success'] = false;
            $output['message'] = 'DATA GAGAL DIHAPUS';
        }
        echo json_encode($output);
    }  

}