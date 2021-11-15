<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sasaran extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_renstra_sasaran');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_renstra_sasaran')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        if (!$this->ion_auth->in_group(array(1,2)))
        {
            $id = $this->ion_auth->user()->row()->id;
            $data['filter_skpd'] = $this->m_renstra_sasaran->filter_skpd($id);
        }
        else
        {
            $data['filter_skpd'] = $this->m_renstra_sasaran->filter_skpd();
        }
        $this->load->view('renstra/sasaran/index', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $where = '';
        $like = array();
        $param = '';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.SASARAN' => $_POST['search_field']);
        }

        if($_POST['skpd'] == 'all') {
            $where = '';
            $param = '';
        }

        if ($_POST['skpd'] != 'all') {
            $where = '(a.SKPD_ID = "'.$_POST['skpd'].'")';
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

        $data['total_items'] = $this->m_renstra_sasaran->get_list_total($where,$like)->row('count');
        $data['list_sasaran'] = $this->m_renstra_sasaran->get_list_sasaran($where,$like,$limit, $offset);

        foreach($data['list_sasaran'] as $key =>$val){
            $indikator = $this->m_renstra_sasaran->get_list_indikator($val['ID'],$like);
            if($indikator){
                $data['list_items'][$val['ID']] = $indikator;
            }
        }
        $this->load->view('renstra/sasaran/v_list', $data );
    }

    public function list_indikator($id){
        $data['list_indikator'] = $this->m_renstra_sasaran->get_indikator_by_id_sasaran($id);
        $this->load->view('renstra/sasaran/v_indikator_list', $data);
    }
    
    public function tambah(){
        if (!$this->ion_auth->in_group(array(1,2)))
        {
            $id = $this->ion_auth->user()->row()->id;
            $data['filter_skpd'] = $this->m_renstra_sasaran->filter_skpd($id);
            $data['filter_urusan'] = $this->m_renstra_sasaran->filter_urusan($id);
        }
        else
        {
            $data['filter_skpd'] = $this->m_renstra_sasaran->filter_skpd();
            $data['filter_urusan'] = $this->m_renstra_sasaran->filter_urusan();
        }
        $data['urusan_list'] = $this->m_renstra_sasaran->get_urusan_dropdown();
        $data['tujuan_list'] = $this->m_renstra_sasaran->get_tujuan_dropdown();
        $data['tujuan_rpjmd'] = $this->m_renstra_sasaran->get_tujuan_rpjmd_dropdown();
        $data['skpd_list'] = $this->m_renstra_sasaran->get_skpd_list_dropdown();
        $data['rpjmd_sasaran'] = $this->m_renstra_sasaran->get_sasaran_rpjmd_dropdown();
        $this->load->view('renstra/sasaran/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_skpd', 'SKPD', 'trim|required|numeric');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan SKPD', 'trim|required|numeric');
        $this->form_validation->set_rules('f_sasaran', 'Sasaran SKPD', 'trim|required');
        $this->form_validation->set_rules('f_sasaran_pemda', 'Sasaran PEMDA', 'trim|required');
        $this->form_validation->set_rules('f_urusan', 'URUSAN SKPD', 'trim|required');
        if($this->form_validation->run()) {
            $data['SASARAN'] = htmlspecialchars($this->input->post('f_sasaran'));
            $data['TUJUAN_ID'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['SASARAN_RPJMD_ID'] = htmlspecialchars($this->input->post('f_sasaran_pemda'));
            $data['SKPD_ID'] = htmlspecialchars($this->input->post('f_skpd'));
            $data['URUSAN_ID'] = htmlspecialchars($this->input->post('f_urusan'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->ion_auth->user()->row()->id;

            $query = $this->m_renstra_sasaran->tambah_sasaran($data);
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
            $data['skpd_list'] = $this->m_renstra_sasaran->get_skpd_list_dropdown();
            $data['tujuan_list'] = $this->m_renstra_sasaran->get_tujuan_dropdown();
            $data['detail'] = $this->m_renstra_sasaran->detail($id);
            $data['sub_detail'] = $this->m_renstra_sasaran->get_program_by_id($id);
            $data['sub_skpd'] = $this->m_renstra_sasaran->get_skpd_by_id($id);
            $data['ceklist'] = $this->m_renstra_sasaran->get_skpd_dropdown();
            $data['rpjmd_sasaran'] = $this->m_renstra_sasaran->get_sasaran_rpjmd_dropdown();
            if (!$this->ion_auth->in_group(array(1,2)))
            {
                $id = $this->ion_auth->user()->row()->id;
                $data['filter_skpd'] = $this->m_renstra_sasaran->filter_skpd($id);
                $data['filter_urusan'] = $this->m_renstra_sasaran->filter_urusan($id);
            }
            else
            {
                $data['filter_skpd'] = $this->m_renstra_sasaran->filter_skpd();
                $data['filter_urusan'] = $this->m_renstra_sasaran->filter_urusan();
            }
            $this->load->view('renstra/sasaran/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function ceklist_indikator(){
        $where_urusan = $_POST['urusan_id'];
        $like = array();
        if (isset($_POST['cari_indikator']) && $_POST['cari_indikator'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['cari_indikator']);
        }
        $data['list_items'] = $this->m_renstra_sasaran->ceklist_indikator($where_urusan,$like);
        $this->load->view('renstra/sasaran/v_indikator_ceklist', $data);
    }

    public function tambah_indikator($id){
        $urusan = $this->m_renstra_sasaran->get_urusan_by_id($id);
        $data['skpd_list'] = $this->m_renstra_sasaran->get_skpd_list_dropdown();
        $data['tujuan_list'] = $this->m_renstra_sasaran->get_tujuan_dropdown();
        $data['detail'] = $this->m_renstra_sasaran->detail($urusan->ID);
        $data['sub_detail'] = $this->m_renstra_sasaran->get_program_by_id($urusan->ID);
        $data['sub_detail_indikator'] = $this->m_renstra_sasaran->get_indikator_by_id_sasaran($urusan->ID);
        $data['sub_skpd'] = $this->m_renstra_sasaran->get_skpd_by_id($urusan->ID);
        $data['rpjmd_sasaran'] = $this->m_renstra_sasaran->get_sasaran_rpjmd_dropdown();
        $this->load->view('renstra/sasaran/v_tambah_indikator', $data);
    }

    public function tambah_skpd_terkait($id){
        if ($id) {
            $data['skpd_list'] = $this->m_renstra_sasaran->get_skpd_list_dropdown();
            $data['tujuan_list'] = $this->m_renstra_sasaran->get_tujuan_dropdown();
            $data['detail'] = $this->m_renstra_sasaran->detail($id);
            $data['sub_detail'] = $this->m_renstra_sasaran->get_program_by_id($id);
            $data['sub_detail_indikator'] = $this->m_renstra_sasaran->get_indikator_by_id_sasaran($id);
            $data['sub_skpd'] = $this->m_renstra_sasaran->get_skpd_by_id($id);
            $data['ceklist'] = $this->m_renstra_sasaran->get_skpd_dropdown();
            $data['rpjmd_sasaran'] = $this->m_renstra_sasaran->get_sasaran_rpjmd_dropdown();
            $this->load->view('renstra/sasaran/v_tambah_skpd_terkait', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_sasaran_pemda', 'Sasaran PEMDA', 'trim|required');
        $this->form_validation->set_rules('f_tujuan', 'Tujuan Pemda', 'trim|required|numeric');
        $this->form_validation->set_rules('f_sasaran', 'Sasaran Pemda', 'trim|required');
        $this->form_validation->set_rules('f_urusan', 'Urusan Pemda', 'trim|required|numeric');
        if($this->form_validation->run()) {
            $data['ID'] = htmlspecialchars($this->input->post('f_id'));
            $data['SASARAN'] = htmlspecialchars($this->input->post('f_sasaran'));
            $data['TUJUAN_ID'] = htmlspecialchars($this->input->post('f_tujuan'));
            $data['SASARAN_RPJMD_ID'] = htmlspecialchars($this->input->post('f_sasaran_pemda'));
            $data['SKPD_ID'] = htmlspecialchars($this->input->post('f_skpd'));
            $data['URUSAN_ID'] = htmlspecialchars($this->input->post('f_urusan'));
            $data['MODIFIED'] = date('Y-m-d H:i:s');
            $data['MODIFIED_BY'] = $this->ion_auth->user()->row()->id;
            
            $query = $this->m_renstra_sasaran->update_sasaran($data);
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
            $query = $this->m_renstra_sasaran->delete_sasaran($id);
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

    public function simpan_sasaran_indikator() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_sasaran', 'SASARAN SKPD', 'trim|required');
        if($this->form_validation->run()) {
            $sasaran = $this->input->post('f_sasaran');
            $indikator = $this->input->post('f_indikator[]');
            $query = $this->m_renstra_sasaran->insert_indikator_sasaran($sasaran, $indikator);

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

    public function simpan_sasaran_skpd() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_sasaran', 'SASARAN SKPD', 'trim|required');
        $this->form_validation->set_rules('f_skpd', 'SKPD', 'trim|required');
        if($this->form_validation->run()) {
            $sasaran = $this->input->post('f_sasaran');
            $skpd = $this->input->post('f_skpd');
            $query = $this->m_renstra_sasaran->insert_skpd_sasaran($sasaran, $skpd);

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
            $data['skpd_list'] = $this->m_renstra_sasaran->get_skpd_list_dropdown();
            $data['tujuan_list'] = $this->m_renstra_sasaran->get_tujuan_dropdown();
            $data['detail'] = $this->m_renstra_sasaran->detail($id);
            $data['sub_detail'] = $this->m_renstra_sasaran->get_program_by_id($id);
            $data['sub_detail_indikator'] = $this->m_renstra_sasaran->get_indikator_by_id_sasaran($id);
            $data['sub_skpd'] = $this->m_renstra_sasaran->get_skpd_by_id($id);
            $data['ceklist'] = $this->m_renstra_sasaran->get_skpd_dropdown();
            $data['rpjmd_sasaran'] = $this->m_renstra_sasaran->get_sasaran_rpjmd_dropdown();
            if (!$this->ion_auth->in_group(array(1,2)))
            {
                $id = $this->ion_auth->user()->row()->id;
                $data['filter_skpd'] = $this->m_renstra_sasaran->filter_skpd($id);
                $data['filter_urusan'] = $this->m_renstra_sasaran->filter_urusan($id);
            }
            else
            {
                $data['filter_skpd'] = $this->m_renstra_sasaran->filter_skpd();
                $data['filter_urusan'] = $this->m_renstra_sasaran->filter_urusan();
            }
            $this->load->view('renstra/sasaran/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }

    public function remove_indikator($id){
        if($id) {         
            $query = $this->m_renstra_sasaran->remove_indikator($id);
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

}