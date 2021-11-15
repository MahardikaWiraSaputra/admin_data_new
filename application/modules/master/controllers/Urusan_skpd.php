<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Urusan_skpd extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_urusan_skpd');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');
    }

    public function index(){
        $data = '';
        $this->load->view('master/urusan_skpd/index', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.NAMA_SKPD = "'.$_POST['search_field'].'")';
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
        $data['total_items'] = $this->m_urusan_skpd->get_skpd_total($where, $like)->row('count');
        $data['list_items'] = $this->m_urusan_skpd->get_list_skpd($where, $like, $limit, $offset);
        $this->load->view('master/urusan_skpd/v_list', $data );
    }

    public function tambah($id, $tahun) {
        $data['get_detail'] = $this->m_urusan_skpd->detail_data($id)->row();
        $data['tahun'] = $tahun;
        $this->load->view('data_dasar/data/v_tambah', $data);
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

            $query = $this->m_urusan_skpd->tambah_value($data);
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