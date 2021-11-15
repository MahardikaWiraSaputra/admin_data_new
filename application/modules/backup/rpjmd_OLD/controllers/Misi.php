<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Misi extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_rpjmd_misi');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_rpjmd_misi')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('rpjmd/misi/index', $data);
    }


    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.MISI = "'.$_POST['search_field'].'")';
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
        $data['total_items'] = $this->m_rpjmd_misi->get_list_total($where, $like)->row('count');
        $data['list_items'] = $this->m_rpjmd_misi->get_list_data($where, $like, $limit, $offset);
        $this->load->view('rpjmd/misi/v_list', $data );
    }


    public function tambah(){
        $data['visi_list'] = $this->m_rpjmd_misi->get_visi_dropdown();
        $this->load->view('rpjmd/misi/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_visi', 'Visi Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_misi', 'Misi Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['VISI_ID'] = htmlspecialchars($this->input->post('f_visi'));
            $data['MISI'] = htmlspecialchars($this->input->post('f_misi'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;

            $query = $this->m_rpjmd_misi->tambah_misi($data);
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
            $data['visi_list'] = $this->m_rpjmd_misi->get_visi_dropdown();
            $data['detail'] = $this->m_rpjmd_misi->detail($id);
            $data['sub_detail'] = $this->m_rpjmd_misi->get_tujuan_by_id($id);
            $this->load->view('rpjmd/misi/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_visi', 'Visi Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_misi', 'Misi Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['VISI_ID'] = htmlspecialchars($this->input->post('f_visi'));
            $data['MISI'] = htmlspecialchars($this->input->post('f_misi'));
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_rpjmd_misi->update_misi($data);
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
            $query = $this->m_rpjmd_misi->delete_misi($id);
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