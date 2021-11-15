<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sasaran extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_rpjmd_sasaran');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_rpjmd_sasaran')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('rpjmd/sasaran/index', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_skpd='';
        $where_urusan='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.SASARAN = "'.$_POST['search_field'].'")';
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
        $data['total_items'] = $this->m_rpjmd_sasaran->get_list_total($where, $like)->row('count');
        $data['list_tujuan'] = $this->m_rpjmd_sasaran->get_list_tujuan($where, $like, $limit, $offset);

        foreach($data['list_tujuan'] as $key =>$val){
            $sasaran = $this->m_rpjmd_sasaran->get_list_data($val['ID']);
            if($sasaran){
                $data['list_items'][$val['ID']] = $sasaran;
            }
        }
        $this->load->view('rpjmd/sasaran/v_list', $data );
    }

    
    public function tambah(){
        $data['urusan_list'] = $this->m_rpjmd_sasaran->get_urusan_dropdown();
        $data['tujuan_list'] = $this->m_rpjmd_sasaran->get_tujuan_dropdown();
        $this->load->view('rpjmd/sasaran/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_urusan', 'Urusan Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_sasaran', 'Sasaran Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['URUSAN_ID'] = htmlspecialchars($this->input->post('f_urusan'));
            $data['TUJUAN_ID'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['SASARAN'] = htmlspecialchars($this->input->post('f_sasaran'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;

            $query = $this->m_rpjmd_sasaran->tambah_sasaran($data);
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
            $data['urusan_list'] = $this->m_rpjmd_sasaran->get_urusan_dropdown();
            $data['tujuan_list'] = $this->m_rpjmd_sasaran->get_tujuan_dropdown();
            $data['detail'] = $this->m_rpjmd_sasaran->detail($id);
            $data['sub_detail'] = $this->m_rpjmd_sasaran->get_program_by_id($id);
            $this->load->view('rpjmd/sasaran/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function edit($id){
        if ($id) {
            $data['urusan_list'] = $this->m_rpjmd_sasaran->get_urusan_dropdown();
            $data['tujuan_list'] = $this->m_rpjmd_sasaran->get_tujuan_dropdown();
            $data['detail'] = $this->m_rpjmd_sasaran->detail($id);
            $this->load->view('rpjmd/sasaran/v_edit', $data);
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
            
            $query = $this->m_rpjmd_sasaran->update_sasaran($data);
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
            $query = $this->m_rpjmd_sasaran->delete_sasaran($id);
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