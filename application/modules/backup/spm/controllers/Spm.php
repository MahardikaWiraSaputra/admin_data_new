<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spm extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_spm_data');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_spm')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data['filter_urusan'] = $this->m_spm_data->filter_urusan();
        $this->load->view('spm/indikator/index', $data);
    }

    public function form_sasaran($id = false){
        $data['form_sasaran'] = $this->m_spm_data->form_sasaran($id);
        $this->load->view('spm/indikator/v_form_sasaran', $data);
    }   


    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_urusan='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = '(a.INDIKATOR = "'.$_POST['search_field'].'")';
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL && $_POST['urusan'] != 'all' ) {
            $where_urusan = '(a.URUSAN_ID = "'.$_POST['urusan'].'")';
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
        $data['total_items'] = $this->m_spm_data->get_list_total($where, $where_urusan, $like)->row('count');
        $data['item_sasaran'] = $this->m_spm_data->get_list_sasaran($where, $where_urusan, $like, $limit, $offset);
        foreach($data['item_sasaran'] as $key =>$val){
            $indikator = $this->m_spm_data->get_list_data($val['ID']);
            if($indikator){
                $data['list_items'][$val['ID']] = $indikator;
            }
        }
        $this->load->view('spm/indikator/v_list', $data );
    }


    public function tambah(){
        $data['ceklist'] = $this->m_spm_data->ceklist_indikator();
        $data['form_urusan'] = $this->m_spm_data->form_urusan();
        $this->load->view('spm/indikator/v_tambah', $data);
    }


    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_sasaran', 'Target Pembangunan', 'trim|required|numeric');
        if($this->form_validation->run()) {
            $sasaran = $this->input->post('f_sasaran');
            $indikators = $this->input->post('f_indikator[]');
            $query = $this->m_spm_data->insert_indikator($sasaran, $indikators);

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
            $query = $this->m_spm_data->delete_indikator($id);
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