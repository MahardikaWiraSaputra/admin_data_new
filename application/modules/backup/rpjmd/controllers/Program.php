<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_rpjmd_program');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_rpjmd_program')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('rpjmd/program/index', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_urusan='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.PROGRAM = "'.$_POST['search_field'].'")';
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL &&  $_POST['urusan'] != 'all') {
            $where_urusan = '(b.URUSAN_ID = "'.$_POST['urusan'].'")';
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
        $data['total_items'] = $this->m_rpjmd_program->get_list_total($where, $where_urusan, $like)->row('count');
        $data['list_items'] = $this->m_rpjmd_program->get_list_data($where, $where_urusan, $like, $limit, $offset);

        $this->load->view('rpjmd/program/v_list', $data );
    }

    
    public function tambah(){
        $data['urusan_list'] = $this->m_rpjmd_program->get_urusan_dropdown();
        $data['sasaran_list'] = $this->m_rpjmd_program->get_sasaran_dropdown();
        $this->load->view('rpjmd/program/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_urusan', 'Urusan Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_sasaran', 'Sasaran Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_program', 'Program Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['URUSAN_ID'] = htmlspecialchars($this->input->post('f_urusan'));
            $data['SASARAN_ID'] = htmlspecialchars($this->input->post('f_sasaran'));
            $data['PROGRAM'] = htmlspecialchars($this->input->post('f_program'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;

            $query = $this->m_rpjmd_program->tambah_program($data);
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

    public function detail($id){
        if ($id) {
            $data['urusan_list'] = $this->m_rpjmd_program->get_urusan_dropdown();
            $data['sasaran_list'] = $this->m_rpjmd_program->get_sasaran_dropdown();
            $data['detail'] = $this->m_rpjmd_program->detail($id);
            $data['sub_detail'] = $this->m_rpjmd_program->get_indikator_by_id($id);
            $this->load->view('rpjmd/program/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function edit($id){
        if ($id) {
            $data['urusan_list'] = $this->m_rpjmd_program->get_urusan_dropdown();
            $data['sasaran_list'] = $this->m_rpjmd_program->get_sasaran_dropdown();
            $data['detail'] = $this->m_rpjmd_program->detail($id);
            $this->load->view('rpjmd/program/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_urusan', 'Urusan Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_sasaran', 'Sasaran Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['URUSAN_ID'] = htmlspecialchars($this->input->post('f_urusan'));
            $data['TUJUAN_ID'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['SASARAN'] = htmlspecialchars($this->input->post('f_sasaran'));
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_rpjmd_program->update_sasaran($data);
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
            $query = $this->m_rpjmd_program->delete_sasaran($id);
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