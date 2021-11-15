<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    const MAX_COOKIE_LIFETIME = 63072000;
    const MAX_PASSWORD_SIZE_BYTES = 4096;

    function __construct(){
        parent::__construct();
        $this->load->model('model_users');
        $this->hash_method = $this->config->item('hash_method', 'ion_auth');

        if (!$this->ion_auth->logged_in()) {
            redirect('/login');
        }

        if (!$this->ion_auth_acl->has_permission('data_users'))
        {
            redirect('/main/dashboard');
        } 
    }

    public function index()
    {
        $data = '';
        $this->load->view('users/index', $data);
    }

    public function list(){
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

        $data['total_items'] = $this->model_users->list_total($status,$like);
        $data['list_items'] = $this->model_users->list_data($status,$like,$limit,$offset);
        $this->load->view('users/v_list', $data );
    }

    public function tambah(){
        $data['list_groups'] = $this->model_users->list_groups();
        $this->load->view('users/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'USERNAME', 'trim|required');
        $this->form_validation->set_rules('full_name', 'FULL_NAME', 'trim|required');
        $this->form_validation->set_rules('password', 'PASSWORD', 'trim|required');
        if($this->form_validation->run()) {
            $data['username'] = $this->input->post('username');
            $data['full_name'] = $this->input->post('full_name');
            $data['email'] = $this->input->post('email');
            $data['password'] = $this->hash_password($this->input->post('password'));
            $data['active'] = $this->input->post('status');
            $data['groups'] = $this->input->post('groups[]');
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->session->userdata('id');
            $query = $this->model_users->tambah($data);

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
            $data['list_groups'] = $this->model_users->list_groups();
            $data['detail'] = $this->model_users->detail($id);
            $this->load->view('users/v_edit', $data);
        }
        else {
            echo 'id tidak boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('username', 'USERNAME', 'trim|required');
        $this->form_validation->set_rules('full_name', 'FULL_NAME', 'trim|required');
        if($this->form_validation->run()) {
            $data['id'] = $this->input->post('id');
            $data['username'] = $this->input->post('username');
            $data['full_name'] = $this->input->post('full_name');
            $data['email'] = $this->input->post('email');
            $data['active'] = $this->input->post('status');
            $data['groups'] = $this->input->post('groups[]');
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->session->userdata('id');
            if ($this->input->post('password')) {
                $data['password'] = $this->hash_password($this->input->post('password'));
            }
            $query = $this->model_users->update($data);
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
            $query = $this->model_users->delete($id);
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

    public function pswd() {
        $pass = $this->hash_password('12345678');
        // $pass = $this->bcrypt->hash('12345678');
        // echo $pass;
        var_dump($pass);
    }


    public function hash_password($password, $identity = NULL) {
        if (empty($password) || strpos($password, "\0") !== FALSE || strlen($password) > self::MAX_PASSWORD_SIZE_BYTES) {
            return FALSE;
        }
        $algo = $this->_get_hash_algo();
        $params = $this->_get_hash_parameters($identity);
        if ($algo !== FALSE && $params !== FALSE) {
            return password_hash($password, $algo, $params);
        }
        return FALSE;
    }

    protected function _get_hash_algo() {
        $algo = FALSE;
        switch ($this->hash_method) {
            case 'bcrypt':
                $algo = PASSWORD_BCRYPT;
                break;

            case 'argon2':
                $algo = PASSWORD_ARGON2I;
                break;
            default:
        }
        return $algo;
    }

    protected function _get_hash_parameters($identity = NULL) {
        $is_admin = FALSE;
        if ($identity) {
            $user_id = $this->get_user_id_from_identity($identity);
            if ($user_id && $this->in_group($this->config->item('admin_group', 'ion_auth'), $user_id))
            {
                $is_admin = TRUE;
            }
        }
        $params = FALSE;
        switch ($this->hash_method) {
            case 'bcrypt':
                $params = [
                    'cost' => $is_admin ? $this->config->item('bcrypt_admin_cost', 'ion_auth') : $this->config->item('bcrypt_default_cost', 'ion_auth')
                ];
                break;
            case 'argon2':
                $params = $is_admin ? $this->config->item('argon2_admin_params', 'ion_auth') : $this->config->item('argon2_default_params', 'ion_auth');
                break;
            default:
        }
        return $params;
    }
}