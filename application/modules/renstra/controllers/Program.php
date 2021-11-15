<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_renstra_program');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_renstra_program')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        if (!$this->ion_auth->in_group(array(1,2)))
        {
            $id = $this->ion_auth->user()->row()->id;
            $data['filter_skpd'] = $this->m_renstra_program->filter_skpd($id);
            $data['filter_urusan'] = $this->m_renstra_program->filter_urusan($id);
        }
        else
        {
            $data['filter_skpd'] = $this->m_renstra_program->filter_skpd();
            $data['filter_urusan'] = $this->m_renstra_program->filter_urusan();
        }
        $this->load->view('renstra/program/index', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $param = '';
        $where_urusan='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.PROGRAM' => $_POST['search_field']);
        }

        if($_POST['skpd'] == 'all') {
            $param = '';
        }

        if ($_POST['skpd'] != 'all') {
            $param = '(c.SKPD_ID = "'.$_POST['skpd'].'")';
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL &&  $_POST['urusan'] != 'all') {
            $where_urusan = '(c.URUSAN_ID = "'.$_POST['urusan'].'")';
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
        $data['total_items'] = $this->m_renstra_program->get_list_total($param, $where_urusan, $like)->row('count');
        $data['list_program'] = $this->m_renstra_program->get_list_data($param, $where_urusan, $like, $limit, $offset);

        foreach($data['list_program'] as $key =>$val){
            $indikator = $this->m_renstra_program->get_list_indikator($val['ID'],$like);
            if($indikator){
                $data['list_items'][$val['ID']] = $indikator;
            }
        }

        $this->load->view('renstra/program/v_list', $data );
    }

    public function list_indikator($id){
        $data['list_indikator'] = $this->m_renstra_program->get_indikator_by_id($id);
        $this->load->view('renstra/sasaran/v_indikator_list', $data);
    }

    public function tambah(){
        if (!$this->ion_auth->in_group(array(1,2)))
        {
            $id = $this->ion_auth->user()->row()->id;
            $data['filter_skpd'] = $this->m_renstra_program->filter_skpd($id);
            $data['filter_urusan'] = $this->m_renstra_program->filter_urusan($id);
        }
        else
        {
            $data['filter_skpd'] = $this->m_renstra_program->filter_skpd();
            $data['filter_urusan'] = $this->m_renstra_program->filter_urusan();
        }
        $data['sasaran_list'] = $this->m_renstra_program->get_sasaran_dropdown();
        $this->load->view('renstra/program/v_tambah', $data);
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

            $query = $this->m_renstra_program->tambah_program($data);
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
            $data['sasaran_list'] = $this->m_renstra_program->get_sasaran_dropdown();
            $data['detail'] = $this->m_renstra_program->detail($id);
            if (!$this->ion_auth->in_group(array(1,2)))
            {
                $id = $this->ion_auth->user()->row()->id;
                $data['filter_skpd'] = $this->m_renstra_program->filter_skpd($id);
                $data['filter_urusan'] = $this->m_renstra_program->filter_urusan($id);
            }
            else
            {
                $data['filter_skpd'] = $this->m_renstra_program->filter_skpd();
                $data['filter_urusan'] = $this->m_renstra_program->filter_urusan();
            }
                $this->load->view('renstra/program/v_detail', $data);
            }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_urusan', 'Urusan Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_sasaran', 'Sasaran Pemda', 'trim|required');
        $this->form_validation->set_rules('f_program', 'Sasaran Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['URUSAN_ID'] = htmlspecialchars($this->input->post('f_urusan'));
            $data['SASARAN_ID'] = htmlspecialchars($this->input->post('f_sasaran'));
            $data['PROGRAM'] = htmlspecialchars($this->input->post('f_program'));
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_renstra_program->update_program($data);
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
            $query = $this->m_renstra_program->delete_program($id);
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

    public function ceklist_indikator(){
        $where_urusan = $_POST['urusan_id'];
        $like = array();
        if (isset($_POST['cari_indikator']) && $_POST['cari_indikator'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['cari_indikator']);
        }
        $data['list_items'] = $this->m_renstra_program->ceklist_indikator($where_urusan,$like);
        $this->load->view('renstra/program/v_indikator_ceklist', $data);
    }

    public function tambah_indikator($id){
        $urusan = $this->m_renstra_program->get_urusan_by_id($id);
        $data['sasaran_list'] = $this->m_renstra_program->get_sasaran_dropdown();
        $data['detail'] = $this->m_renstra_program->detail($id);
        if (!$this->ion_auth->in_group(array(1,2)))
        {
            $id = $this->ion_auth->user()->row()->id;
            $data['filter_skpd'] = $this->m_renstra_program->filter_skpd($id);
            $data['filter_urusan'] = $this->m_renstra_program->filter_urusan($id);
        }
        else
        {
            $data['filter_skpd'] = $this->m_renstra_program->filter_skpd();
        }
            $data['filter_urusan'] = $this->m_renstra_program->filter_urusan();
        $this->load->view('renstra/program/v_tambah_indikator', $data);
    }

    public function simpan_indikator() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_program', 'Urusan Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $program = htmlspecialchars($this->input->post('f_program'));
            $indikators = $this->input->post('f_indikator[]');
            $query = $this->m_renstra_program->insert_indikator($program, $indikators);

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

    public function edit($id){
        if ($id) {
            $data['urusan_list'] = $this->m_renstra_program->get_urusan_dropdown();
            $data['sasaran_list'] = $this->m_renstra_program->get_sasaran_dropdown();
            $data['detail'] = $this->m_renstra_program->detail($id);
            $data['sub_detail'] = $this->m_renstra_program->get_indikator_by_id($id);
            if (!$this->ion_auth->in_group(array(1,2)))
            {
                $id = $this->ion_auth->user()->row()->id;
                $data['filter_skpd'] = $this->m_renstra_program->filter_skpd($id);
                $data['filter_urusan'] = $this->m_renstra_program->filter_urusan($id);
            }
            else
            {
                $data['filter_skpd'] = $this->m_renstra_program->filter_skpd();
                $data['filter_urusan'] = $this->m_renstra_program->filter_urusan();
            }
            $this->load->view('renstra/program/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function remove_indikator($id){
        if($id) {         
            $query = $this->m_renstra_program->remove_indikator($id);
            if ($query) {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DIHAPUS';
            }
            else {
                $output['success'] = false;
                $output['message'] = 'DATA GAGAL DIHAPUS';
            }
        } 
        else {
            $output['success'] = false;
            $output['message'] = 'DATA GAGAL DIHAPUS';
        }
        echo json_encode($output);
    }

}