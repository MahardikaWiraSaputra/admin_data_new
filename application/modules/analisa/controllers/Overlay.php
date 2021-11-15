<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Overlay extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_overlay');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');
        if (!$this->ion_auth_acl->has_permission('kelola_data_analisa_overlay')) { //perlu disesuaikan
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('analisa/overlay/index', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.KATEGORI' => $_POST['search_field']);
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
        $data['total_items'] = $this->m_overlay->get_list_total($where, $like)->row('count');
        $data['list_items'] = $this->m_overlay->get_list_data($where, $like, $limit, $offset);

        foreach($data['list_items'] as $key =>$val){
            $indikator = $this->m_overlay->list_indikator($val['ID']);
            if($indikator){
                $data['list_indikator'][$val['ID']] = $indikator;
            }
        }

        $this->load->view('analisa/overlay/v_list', $data );
    }

    // tambah
    public function tambah(){
        $data['list_indikator'] = $this->m_overlay->get_list_indikator();
        $this->load->view('analisa/overlay/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('indikator_y', 'Indikator Y', 'trim|required');
        $this->form_validation->set_rules('indikator_x', 'Indikator X', 'trim|required');
        if($this->form_validation->run()) {
            $data['INDIKATOR_MASTER'] = htmlspecialchars($this->input->post('indikator_y'));
            $data['INDIKATOR_X'] = htmlspecialchars($this->input->post('indikator_x'));
            $data['INDIKATOR_TAMBAHAN'] = htmlspecialchars($this->input->post('indikator_tambahan'));
            $data['JUDUL'] = htmlspecialchars($this->input->post('judul'));
            $query = $this->m_overlay->tambah_indikator($data);
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
            $data['detail'] = $this->m_overlay->detail_kategori($id);
            $this->load->view('analisa/overlay/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    // detail edit
    public function edit($id){
        if ($id) {
            $data['list_indikator'] = $this->m_overlay->get_list_indikator();
            $data['detail'] = $this->m_overlay->detail_overlay($id);
            $this->load->view('analisa/overlay/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }


    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('indikator_y', 'Indikator Y', 'trim|required');
        $this->form_validation->set_rules('indikator_x', 'Indikator X', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['INDIKATOR_MASTER'] = htmlspecialchars($this->input->post('indikator_y'));
            $data['INDIKATOR_X'] = htmlspecialchars($this->input->post('indikator_x'));
            $data['INDIKATOR_TAMBAHAN'] = htmlspecialchars($this->input->post('indikator_tambahan'));
            $data['JUDUL'] = htmlspecialchars($this->input->post('judul'));
            
            $query = $this->m_overlay->update_overlay($data);
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
            $query = $this->m_overlay->delete_overlay($id);
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