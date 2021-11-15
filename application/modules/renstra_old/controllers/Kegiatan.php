<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_renstra_kegiatan');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_renstra_kegiatan')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('renstra/kegiatan/index', $data);
    }

    public function get_program($id = false){
        $data['filter_program'] = $this->m_renstra_kegiatan->dropdown_program($id);
        $this->load->view('renstra/kegiatan/v_filter_program', $data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $param = '';
        $where_program='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.KEGIATAN' => $_POST['search_field']);
        }

        if($_POST['skpd'] == 'all') {
            $param = '';
        }

        if ($_POST['skpd'] != 'all') {
            $param = '(d.SKPD_ID = "'.$_POST['skpd'].'")';
        }

        if(isset($_POST['program']) && $_POST['program'] == 'all') {
            $where_program = '';
        }

        if (isset($_POST['program']) && $_POST['program'] != 'all') {
            $where_program = '(a.PROGRAM_ID = "'.$_POST['program'].'")';
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
        $data['total_items'] = $this->m_renstra_kegiatan->get_list_total($where, $where_program, $like)->row('count');
        $data['list_items'] = $this->m_renstra_kegiatan->get_list_data($param, $where_program, $like, $limit, $offset);

        $this->load->view('renstra/kegiatan/v_list', $data );
    }

    
    public function tambah(){
        $data['program_list'] = $this->m_renstra_kegiatan->get_program_dropdown();
        $this->load->view('renstra/kegiatan/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('program', 'Program SKPD', 'trim|required|numeric');
        $this->form_validation->set_rules('f_kegiatan', 'kegiatan Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['KEGIATAN'] = htmlspecialchars($this->input->post('f_kegiatan'));
            $data['PROGRAM_ID'] = htmlspecialchars($this->input->post('program'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;

            $query = $this->m_renstra_kegiatan->tambah_kegiatan($data);
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
            $data['program_list'] = $this->m_renstra_kegiatan->get_program_dropdown();
            $data['kegiatan_list'] = $this->m_renstra_kegiatan->get_kegiatan_dropdown();
            $data['detail'] = $this->m_renstra_kegiatan->detail($id);
            $data['sub_detail'] = $this->m_renstra_kegiatan->get_indikator_by_id($id);
            $data['skpd_list'] = $this->m_renstra_kegiatan->get_skpd_dropdown();
            $this->load->view('renstra/kegiatan/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_kegiatan', 'kegiatan Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['KEGIATAN'] = htmlspecialchars($this->input->post('f_kegiatan'));
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_renstra_kegiatan->update_kegiatan($data);
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
            $query = $this->m_renstra_kegiatan->delete_kegiatan($id);
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

    public function edit($id){
        if ($id) {
            $data['program_list'] = $this->m_renstra_kegiatan->get_program_dropdown();
            $data['kegiatan_list'] = $this->m_renstra_kegiatan->get_kegiatan_dropdown();
            $data['detail'] = $this->m_renstra_kegiatan->detail($id);
            $data['sub_detail'] = $this->m_renstra_kegiatan->get_indikator_by_id($id);
            $data['skpd_list'] = $this->m_renstra_kegiatan->get_skpd_dropdown();
            $this->load->view('renstra/kegiatan/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

}