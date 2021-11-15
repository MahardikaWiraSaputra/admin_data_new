<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Urusan extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_master_urusan');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_data_dasar')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('master/urusan/index', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.URUSAN = "'.$_POST['search_field'].'")';
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
        $data['total_items'] = $this->m_master_urusan->get_list_total($where, $like)->row('count');
        $data['list_items'] = $this->m_master_urusan->get_list_data($where, $like, $limit, $offset);
        $this->load->view('master/urusan/v_list', $data );
    }

    // tambah
    public function tambah(){
        $data['filter_skpd'] = $this->m_master_urusan->dropdown_skpd();
        $this->load->view('master/urusan/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_kode_urusan', 'Kode Urusan', 'trim|required');
        $this->form_validation->set_rules('f_nama_urusan', 'Nama Urusan', 'trim|required');
        if($this->form_validation->run()) {
            $kode_urusan = htmlspecialchars($this->input->post('f_kode_urusan'));
            $urusan = htmlspecialchars($this->input->post('f_nama_urusan'));
            $skpd = $this->input->post('f_skpd[]');
            $created = date('y-m-d h:i:s');
            $created_by = $this->ion_auth->user()->row()->id;
            $query = $this->m_master_urusan->tambah_urusan($kode_urusan,$urusan,$skpd,$created,$created_by);
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

    // detail edit
    public function detail($id){
        if ($id) {
            $data['detail'] = $this->m_master_urusan->detail_urusan($id);
            $this->load->view('master/urusan/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    // detail edit
    public function edit($id){
        if ($id) {
            $data['filter_skpd'] = $this->m_master_urusan->dropdown_skpd();
            $data['detail'] = $this->m_master_urusan->detail_urusan($id);
            $this->load->view('master/urusan/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }


    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_urusan_id', 'SKPD', 'trim|required|numeric');
        $this->form_validation->set_rules('f_kode_urusan', 'Kode Urusan', 'trim|required');
        $this->form_validation->set_rules('f_nama_urusan', 'Nama Urusan', 'trim|required');
        if($this->form_validation->run()) {
            $id = htmlspecialchars($this->input->post('f_urusan_id'));
            $kode_urusan = htmlspecialchars($this->input->post('f_kode_urusan'));
            $urusan = htmlspecialchars($this->input->post('f_nama_urusan'));
            $skpd = $this->input->post('f_skpd[]');
            $modified = date('y-m-d h:i:s');
            $modified_by = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_master_urusan->update_urusan($id,$kode_urusan,$urusan,$skpd,$modified,$modified_by);
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
            $query = $this->m_master_urusan->delete_urusan($id);
            if ($query) {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DIUPDATE';
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