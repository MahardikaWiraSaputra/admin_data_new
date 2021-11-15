<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_master_users');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_data_dasar')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('master/users/index', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.username = "'.$_POST['search_field'].'")';
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
        $data['total_items'] = $this->m_master_users->get_list_total($where, $like)->row('count');
        $data['list_items'] = $this->m_master_users->get_list_data($where, $like, $limit, $offset);
        $this->load->view('master/users/v_list', $data );
    }

    // tambah
    public function tambah(){
        $data['filter_skpd'] = $this->m_master_users->dropdown_skpd();
        $data['list_groups'] = $this->m_master_users->list_groups();
        $this->load->view('master/users/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_username', 'Username', 'trim|required');
        $this->form_validation->set_rules('f_password', 'Password', 'trim|required');
        if($this->form_validation->run()) {
            $username = $this->input->post('f_username');
            $password = $this->input->post('f_password');
            $fullname = $this->input->post('f_fullname');
            $skpd = $this->input->post('f_skpd');
            $email = $this->input->post('f_email');
            $telp = $this->input->post('f_telp');
            $groups = $this->input->post('f_groups[]');
            $created = date('y-m-d h:i:s');
            $created_by = $this->ion_auth->user()->row()->id;
            $query = $this->m_master_users->tambah_users($username, $password, $fullname, $skpd, $email, $telp, $groups, $created, $created_by);
            // print_r($this->db->last_query());
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
            $data['detail'] = $this->m_master_users->detail_indikator($id);
            $this->load->view('master/users/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    // detail edit
    public function edit($id){
        if ($id) {
            $data['filter_skpd'] = $this->m_master_users->dropdown_skpd();
            $data['detail'] = $this->m_master_users->detail_users($id);
            $data['list_groups'] = $this->m_master_users->list_groups();
            $this->load->view('master/users/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }


    public function update() {
        $detail = $this->m_master_users->detail_users($this->input->post('f_users_id'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_users_id', 'ID User', 'trim|required|numeric');
        $this->form_validation->set_rules('f_username', 'Username', 'trim|required');
        if($this->form_validation->run()) {
            $id = $this->input->post('f_users_id');
            $username = $this->input->post('f_username');
            if (!empty($this->input->post('f_password'))) {
                $password = $this->input->post('f_password');
            }
            else{
                $password = $detail['password'];
            }
            $fullname = $this->input->post('f_fullname');
            $skpd = $this->input->post('f_skpd');
            $email = $this->input->post('f_email');
            $telp = $this->input->post('f_telp');
            $groups = $this->input->post('f_groups[]');
            $modified = date('y-m-d h:i:s');
            $modified_by = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_master_users->update_users($id, $username, $password, $fullname, $skpd, $email, $telp, $groups, $modified, $modified_by);
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
            $query = $this->m_master_users->delete_users($id);
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