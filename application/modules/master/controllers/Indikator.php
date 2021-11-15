<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indikator extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->auth->cek_auth();
        $this->load->model('m_data_dasar_indikator');
    }

    public function index(){
        $data['get_urusan'] = $this->m_data_dasar_indikator->dropdown_urusan();
        $this->load->view('data_dasar/indikator/index', $data);
    }

    public function get_bidang($id = false){
        $data['get_bidang'] = $this->m_data_dasar_indikator->dropdown_bidang($id);
        $this->load->view('data_dasar/indikator/v_filter_bidang', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_or='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.INDIKATOR = "'.$_POST['search_field'].'")';
        }

        if (isset($_POST['bidang']) && $_POST['bidang'] != NULL) {
            $where_or = '(a.BIDANG_ID = "'.$_POST['bidang'].'")';
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
        $data['id_bidang'] = $this->input->post('bidang');
        $data['items'] = $this->m_data_dasar_indikator->get_list_data($where, $where_or, $like, $limit, $offset)->result();
        $data['total_items'] = $this->m_data_dasar_indikator->get_list_total($where, $where_or, $like)->row('count');
        $data['items_indikator'] = $this->m_data_dasar_indikator->get_list_indikator($where, $where_or, $like, $limit, $offset);
        foreach($data['items_indikator'] as $key =>$val){
            $elemen = $this->m_data_dasar_indikator->get_list_elemen($val['ID']);
            if($elemen){
                $data['items_elemen'][$val['ID']] = $elemen;
            }
        }

        $this->load->view('data_dasar/indikator/v_list', $data );
    }

    public function tambah($id) {
        $data['bidang_urusan'] = $this->m_data_dasar_indikator->get_bidang_urusan($id)->row();
        $this->load->view('data_dasar/indikator/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bidang_id', 'Bidang', 'trim|required|numeric');
        $this->form_validation->set_rules('indikator', 'Indikator', 'trim|required');
        if($this->form_validation->run()) {
            $data['BIDANG_ID'] = htmlspecialchars($this->input->post('bidang_id'));
            $data['INDIKATOR'] = htmlspecialchars($this->input->post('indikator'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->session->userdata('userid');

            $query = $this->m_data_dasar_indikator->tambah_indikator($data);
            if ($query) {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DISIMPAN';
            }
            else {
                $output['success'] = false;
                $output['message'] = 'DATA GAGAL DISIMPAN 2';
            }
        } 
        else {
            $output['success'] = false;
            $output['message'] = 'DATA GAGAL DISIMPAN 1';
        }
        echo json_encode($output);
    }




}