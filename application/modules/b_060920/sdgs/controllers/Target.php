<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Target extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_sdgs_target');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_sdgs')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('sdgs/target/index', $data);
    }

    public function get_tujuan($id = false){
        $data['filter_tujuan'] = $this->m_sdgs_target->dropdown_tujuan($id);
        $this->load->view('sdgs/target/v_filter_tujuan', $data);
    }   

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_pilar='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.TARGET' => $_POST['search_field']);
        }

        if (isset($_POST['pilar']) && $_POST['pilar'] != NULL && $_POST['pilar'] != 'all' ) {
            $where_pilar = '(b.PILAR_ID = "'.$_POST['pilar'].'")';
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
        $data['total_items'] = $this->m_sdgs_target->get_list_total($where, $where_pilar, $like)->row('count');
        $data['list_items'] = $this->m_sdgs_target->get_list_data($where, $where_pilar, $like, $limit, $offset);
        $this->load->view('sdgs/target/v_list', $data );
    }

    public function tambah(){
        $data['list_pilar'] = $this->m_sdgs_target->dropdown_pilar();
        $this->load->view('sdgs/target/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan Pembangunan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_target', 'Target Pembangunan', 'trim|required');
        if($this->form_validation->run()) {
            $data['TUJUAN_ID'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['TARGET'] = htmlspecialchars($this->input->post('f_target'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;

            $query = $this->m_sdgs_target->tambah_target($data);
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
            $data['detail'] = $this->m_sdgs_target->detail($id);
            $data['sub_detail'] = $this->m_sdgs_target->get_target_by_id($id);
            $this->load->view('sdgs/target/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function edit($id){
        if ($id) {
            $data['list_pilar'] = $this->m_sdgs_target->dropdown_pilar();
            $data['detail'] = $this->m_sdgs_target->detail($id);
            $this->load->view('sdgs/target/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_id', 'ID Tujuan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan Pembangunan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_target', 'Target Pembangunan', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['TUJUAN_ID'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['TARGET'] = htmlspecialchars($this->input->post('f_target'));
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_sdgs_target->update_target($data);
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
            $query = $this->m_sdgs_target->delete_target($id);
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