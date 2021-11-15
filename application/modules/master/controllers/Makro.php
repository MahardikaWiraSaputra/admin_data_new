<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Makro extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->auth->cek_auth();
        $this->load->model('m_data_makro');
    }

    public function index(){
        $data['filter_skpd'] = $this->m_data_makro->dropdown_skpd();
        $data['get_periode'] = $this->m_data_makro->get_periode();
        $this->load->view('data_dasar/makro/index', $data);
    }

    public function get_urusan($id = false){
        $data['filter_urusan'] = $this->m_data_makro->dropdown_urusan($id);
        $this->load->view('data_dasar/makro/v_filter_urusan', $data);
    }    

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_skpd='';
        $where_urusan='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.INDIKATOR = "'.$_POST['search_field'].'")';
        }

        if (isset($_POST['skpd']) && $_POST['skpd'] != NULL) {
            $where_skpd = '(a.SKPD_ID = "'.$_POST['skpd'].'")';
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL) {
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
        $data['total_items'] = $this->m_data_makro->get_list_total($where, $where_skpd, $where_urusan, $like)->row('count');
        $data['items_indikator'] = $this->m_data_makro->get_list_data($where, $where_skpd, $where_urusan, $like, $limit, $offset);
        $data['id_skpd'] = $this->input->post('skpd');

        foreach($data['items_indikator'] as $key =>$val){
            $elemen = $this->m_data_makro->get_list_elemen($val['URUSAN_ID']);
            if($elemen){
                $data['items_elemen'][$val['URUSAN_ID']] = $elemen;
            }
        }

        $this->load->view('data_dasar/makro/v_list', $data );
    }

    public function tambah($id, $tahun) {
        $data['get_detail'] = $this->m_data_makro->detail_data($id)->row();
        $data['tahun'] = $tahun;
        $this->load->view('data_dasar/makro/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('elemen_id', 'Elemen', 'trim|required|numeric');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('data_value', 'Data Value', 'trim|required');
        if($this->form_validation->run()) {
            $data['ELEMEN_ID'] = htmlspecialchars($this->input->post('elemen_id'));
            $data['TAHUN'] = htmlspecialchars($this->input->post('tahun'));
            $data['DATA'] = htmlspecialchars($this->input->post('data_value'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->session->userdata('userid');

            $query = $this->m_data_makro->tambah_value($data);
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