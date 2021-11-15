<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_permissions extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_group_permissions');

        if (!$this->ion_auth->logged_in()) {
            redirect('/login');
        }

        if (!$this->ion_auth_acl->has_permission('data_group_permissions'))
        {
            redirect('/main/dashboard');
        } 
    }

    public function index()
    {
        $data = '';
        $this->load->view('group_permissions/index', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $status = '';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL)
        {
            $like = $_POST['search_field'];
        }

        if (isset($_POST['status']) && $_POST['status'] != NULL && $_POST['status'] != 'all')
        {
            $status = $_POST['status'];
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

        $data['list_group'] = $this->model_group_permissions->list_group();
        $data['total_items'] = $this->model_group_permissions->list_total($status,$like);
        $data['list_items'] = $this->model_group_permissions->list_data($status,$like,$limit,$offset);
        $this->load->view('group_permissions/v_list', $data );
    }

    public function tambah(){
        $data['list_group'] = $this->model_group_permissions->list_group();
        $this->load->view('group_permissions/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perm_key', 'Permission Key', 'trim|required');
        $this->form_validation->set_rules('perm_name', 'Permission Name', 'trim|required');
        if($this->form_validation->run()) {
            $data['perm_key'] = $this->input->post('perm_key');
            $data['perm_name'] = $this->input->post('perm_name');
            $data['groups'] = $this->input->post('groups[]');
            $data['value'] = $this->input->post('value[]');
            $data['created_at'] = date('Y-m-d H:i:s');
            $query = $this->model_group_permissions->tambah($data);

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
            $data['list_group'] = $this->model_group_permissions->list_group();
            $data['detail'] = $this->model_group_permissions->detail($id);
            $this->load->view('group_permissions/v_edit', $data);
        }
        else {
            echo 'id tidak boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perm_id', 'ID', 'trim|required');
        $this->form_validation->set_rules('perm_key', 'Permission Key', 'trim|required');
        $this->form_validation->set_rules('perm_name', 'Permission Name', 'trim|required');
        if($this->form_validation->run()) {
            $data['perm_id'] = $this->input->post('perm_id');
            $data['perm_key'] = $this->input->post('perm_key');
            $data['perm_name'] = $this->input->post('perm_name');
            $data['groups'] = $this->input->post('groups[]');
            $data['value'] = $this->input->post('value[]');
            $data['created_at'] = date('Y-m-d H:i:s');
            // print_r($data)
            $query = $this->model_group_permissions->update($data);
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
            $query = $this->model_group_permissions->delete($id);
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

    public function generate_api() {
        $userid = $this->input->post('userid');
        if ($userid !== null) {
            $result['api_key'] = sha1($userid);
            $result['messages'] = 'valid';
        }
        else {
            $result['messages'] = 'invalid';
        }

        echo json_encode($result);
    }    


}