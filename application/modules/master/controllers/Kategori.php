<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_master_kategori');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_data_dasar')) { //perlu disesuaikan
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('master/kategori/index', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.KATEGORI' => $_POST['search_field']);
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
        $data['total_items'] = $this->m_master_kategori->get_list_total($where, $like)->row('count');
        $data['list_items'] = $this->m_master_kategori->get_list_data($where, $like, $limit, $offset);
        $this->load->view('master/kategori/v_list', $data );
    }

    // tambah
    public function tambah(){
        $data = '';
        $this->load->view('master/kategori/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_kategori', 'Kategori', 'trim|required');
        if($this->form_validation->run()) {
            $data['KATEGORI'] = htmlspecialchars($this->input->post('f_kategori'));
            $data['CREATED'] = date('y-m-d h:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;
            $query = $this->m_master_kategori->tambah_kategori($data);
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
            $data['detail'] = $this->m_master_kategori->detail_kategori($id);
            $this->load->view('master/kategori/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    // detail edit
    public function edit($id){
        if ($id) {
            $data['detail'] = $this->m_master_kategori->detail_kategori($id);
            $this->load->view('master/kategori/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }


    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_kategori_id', 'ID Kategori', 'trim|required|numeric');
        $this->form_validation->set_rules('f_kategori', 'Kategori', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_kategori_id'));
            $data['KATEGORI'] = htmlspecialchars($this->input->post('f_kategori'));
            $data['MODIFIED'] = date('y-m-d h:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_master_kategori->update_kategori($data);
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
            $query = $this->m_master_kategori->delete_kategori($id);
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