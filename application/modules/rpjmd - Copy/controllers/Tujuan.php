<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tujuan extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_rpjmd_tujuan');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_rpjmd_tujuan')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('rpjmd/tujuan/index', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 10;
        $like = array();
        $where = array();

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.TUJUAN' => $_POST['search_field']);
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
        $data['total_items'] = $this->m_rpjmd_tujuan->list_total($where,$like)->row('count');
        $data['list_items'] = $this->m_rpjmd_tujuan->list_data($where, $like, $limit, $offset);
        foreach($data['list_items'] as $key =>$val){
            $indikator = $this->m_rpjmd_tujuan->list_indikator($val['ID']);
            if($indikator){
                $data['list_indikator'][$val['ID']] = $indikator;
            }
        }
        $this->load->view('rpjmd/tujuan/v_list', $data );
    }

    public function tambah(){
        $data['misi_list'] = $this->m_rpjmd_tujuan->get_misi_dropdown();
        $this->load->view('rpjmd/tujuan/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_misi', 'Misi Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['MISI_ID'] = htmlspecialchars($this->input->post('f_misi'));
            $data['TUJUAN'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;

            $query = $this->m_rpjmd_tujuan->tambah_tujuan($data);
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
            $data['misi_list'] = $this->m_rpjmd_tujuan->get_misi_dropdown();
            $data['detail'] = $this->m_rpjmd_tujuan->detail($id);
            $data['list_sasaran'] = $this->m_rpjmd_tujuan->get_sasaran_by_id($id);
            $this->load->view('rpjmd/tujuan/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function list_indikator($id){
        $data['list_indikator'] = $this->m_rpjmd_tujuan->get_indikator_by_id($id);
        $this->load->view('rpjmd/tujuan/v_indikator_list', $data);
    }

    public function indikator($id){
        $data['detail'] = $this->m_rpjmd_tujuan->detail($id);
        $this->load->view('rpjmd/tujuan/v_indikator_tambah', $data);
    }

    public function ceklist_indikator(){
        $like = array();
        if (isset($_POST['cari_indikator']) && $_POST['cari_indikator'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['cari_indikator']);
        }
        $data['list_items'] = $this->m_rpjmd_tujuan->ceklist_indikator($like);
        $this->load->view('rpjmd/tujuan/v_indikator_ceklist', $data);
    }

    public function simpan_indikator() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan', 'trim|required|numeric');
        if($this->form_validation->run()) {
            $tujuan = $this->input->post('f_tujuan');
            $indikators = $this->input->post('f_indikator[]');
            $query = $this->m_rpjmd_tujuan->insert_indikator($tujuan, $indikators);

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

    public function remove_indikator($id){
        if($id) {         
            $query = $this->m_rpjmd_tujuan->remove_indikator($id);
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

    public function edit($id){
        if ($id) {
            $data['misi_list'] = $this->m_rpjmd_tujuan->get_misi_dropdown();
            $data['detail'] = $this->m_rpjmd_tujuan->detail($id);
            $this->load->view('rpjmd/tujuan/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_misi', 'Visi Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_tujuan', 'Misi Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['MISI_ID'] = htmlspecialchars($this->input->post('f_misi'));
            $data['TUJUAN'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_rpjmd_tujuan->update_tujuan($data);
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
            $query = $this->m_rpjmd_tujuan->delete_tujuan($id);
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