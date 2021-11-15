<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skpd extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_master_skpd');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_data_dasar')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('master/skpd/index', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.NAMA_SKPD = "'.$_POST['search_field'].'")';
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
        $data['total_items'] = $this->m_master_skpd->get_list_total($where, $like)->row('count');
        $data['list_items'] = $this->m_master_skpd->get_list_data($where, $like, $limit, $offset);
        $this->load->view('master/skpd/v_list', $data );
    }

    // tambah
    public function tambah(){
        $data = '';
        $this->load->view('master/skpd/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_kode_skpd', 'Kode SKPD', 'trim|required');
        $this->form_validation->set_rules('f_nama_skpd', 'Nama SKPD', 'trim|required');
        if($this->form_validation->run()) {
            $data['KODE_SKPD'] = htmlspecialchars($this->input->post('f_kode_skpd'));
            $data['NAMA_SKPD'] = htmlspecialchars($this->input->post('f_nama_skpd'));
            $data['ALAMAT_SKPD'] = htmlspecialchars($this->input->post('f_alamat_skpd'));
            $data['TELP'] = htmlspecialchars($this->input->post('f_telp_skpd'));
            $data['FAX'] = htmlspecialchars($this->input->post('f_fax_skpd'));
            $data['WEB'] = htmlspecialchars($this->input->post('f_web_skpd'));
            $data['EMAIL'] = htmlspecialchars($this->input->post('f_email_skpd'));
            $query = $this->m_master_skpd->tambah_skpd($data);
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
            $data['detail'] = $this->m_master_skpd->detail_indikator($id);
            $this->load->view('master/skpd/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    // detail edit
    public function edit($id){
        if ($id) {
            $data['detail'] = $this->m_master_skpd->detail_skpd($id);
            $this->load->view('master/skpd/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }


    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_skpd_id', 'SKPD', 'trim|required|numeric');
        $this->form_validation->set_rules('f_kode_skpd', 'Kode SKPD', 'trim|required');
        $this->form_validation->set_rules('f_nama_skpd', 'Nama SKPD', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_skpd_id'));
            $data['KODE_SKPD'] = htmlspecialchars($this->input->post('f_kode_skpd'));
            $data['NAMA_SKPD'] = htmlspecialchars($this->input->post('f_nama_skpd'));
            $data['ALAMAT_SKPD'] = htmlspecialchars($this->input->post('f_alamat_skpd'));
            $data['TELP'] = htmlspecialchars($this->input->post('f_telp_skpd'));
            $data['FAX'] = htmlspecialchars($this->input->post('f_fax_skpd'));
            $data['WEB'] = htmlspecialchars($this->input->post('f_web_skpd'));
            $data['EMAIL'] = htmlspecialchars($this->input->post('f_email_skpd'));
            
            $query = $this->m_master_skpd->update_skpd($data);
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
            $query = $this->m_master_skpd->delete_skpd($id);
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