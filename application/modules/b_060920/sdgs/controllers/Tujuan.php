<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tujuan extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_sdgs_tujuan');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_sdgs_tujuan')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('sdgs/tujuan/index', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_pilar='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.TUJUAN' => $_POST['search_field']);
        }

        if (isset($_POST['pilar']) && $_POST['pilar'] != NULL && $_POST['pilar'] != 'all' ) {
            $where_pilar = '(a.PILAR_ID = "'.$_POST['pilar'].'")';
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
        $data['total_items'] = $this->m_sdgs_tujuan->get_list_total($where, $where_pilar, $like)->row('count');
        $data['list_items'] = $this->m_sdgs_tujuan->get_list_data($where, $where_pilar, $like, $limit, $offset);
        $this->load->view('sdgs/tujuan/v_list', $data );
    }

    public function tambah(){
        $data['list_pilar'] = $this->m_sdgs_tujuan->dropdown_pilar();
        $this->load->view('sdgs/tujuan/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_pilar', 'Pilar Pembangunan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan', 'trim|required');
        if($this->form_validation->run()) {
            $data['PILAR_ID'] = htmlspecialchars($this->input->post('f_pilar'));
            $data['TUJUAN'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;

            $query = $this->m_sdgs_tujuan->tambah_tujuan($data);
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
            $data['detail'] = $this->m_sdgs_tujuan->detail($id);
            $data['sub_detail'] = $this->m_sdgs_tujuan->get_target_by_id($id);
            $this->load->view('sdgs/tujuan/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function edit($id){
        if ($id) {
            $data['list_pilar'] = $this->m_sdgs_tujuan->dropdown_pilar();
            $data['detail'] = $this->m_sdgs_tujuan->detail($id);
            $this->load->view('sdgs/tujuan/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_id', 'ID Tujuan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_pilar', 'Pilar Pembangunan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['PILAR_ID'] = htmlspecialchars($this->input->post('f_pilar'));
            $data['TUJUAN'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_sdgs_tujuan->update_tujuan($data);
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
            $query = $this->m_sdgs_tujuan->delete_tujuan($id);
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