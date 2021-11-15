<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kewilayahan extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_data_kewilayahan');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('data_kewilayahan')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data['filter_urusan'] = $this->m_data_kewilayahan->filter_urusan();
        $this->load->view('kewilayahan/indikator/index', $data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 2;
        $like = array();
        $where = array();
        $where_urusan='';
        $where_sasaran='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['search_field']);
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL && $_POST['urusan'] != 'all' ) {
            $where_urusan = '(a.URUSAN_ID = "'.$_POST['urusan'].'")';
        }
        if (isset($_POST['sasaran']) && $_POST['sasaran'] != NULL && $_POST['sasaran'] != 'all' ) {
            $where_sasaran = '(b.SASARAN_ID = "'.$_POST['sasaran'].'")';
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
        $data['total_items'] = $this->m_data_kewilayahan->get_list_total($where, $where_urusan, $like)->row('count');
        $data['list_items'] = $this->m_data_kewilayahan->get_list_data($where, $where_urusan, $like, $limit, $offset);
        foreach($data['list_items'] as $key =>$val){
            $indikator = $this->m_data_kewilayahan->get_list_indikator($val['ID_INDIKATOR']);
            if($indikator){
                $data['list_indikator'][$val['ID_INDIKATOR']] = $indikator;
            }
        }

        $this->load->view('kewilayahan/indikator/v_list', $data );
    }

    public function tambah(){
        $data['form_indikator'] = $this->m_data_kewilayahan->form_indikator();
        $data['tipe_wilayah'] = array('Pilih','kecamatan','desa');
        $data['list_kecamatan'] = $this->m_data_kewilayahan->list_kecamatan();
        $data['drop_kecamatan'] = $this->m_data_kewilayahan->drop_kecamatan();
        $this->load->view('kewilayahan/indikator/v_tambah', $data);
    }

    public function filter_desa($id = false)
    {
        $data['filter_desa'] = $this->m_data_kewilayahan->filter_desa($id);
        $this->load->view('kewilayahan/indikator/v_filter_desa', $data);
    }

    public function filter_desa_detail($id = false)
    {
        $data['filter_desa'] = $this->m_data_kewilayahan->filter_desa_detail($id);
        $this->load->view('kewilayahan/indikator/v_filter_desa_edit', $data);
    }

    public function ceklist_indikator(){
        $like = array();
        if (isset($_POST['cari_indikator']) && $_POST['cari_indikator'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['cari_indikator']);
        }
        $data['list_items'] = $this->m_data_kewilayahan->ceklist_indikator($like);
        $this->load->view('kewilayahan/indikator/v_indikator_ceklist', $data);
    }

    public function edit($id)
    {
        if ($id)
        {
            $cek = $this->m_data_kewilayahan->cek_indikator($id);
            $data['detail'] = $this->m_data_kewilayahan->detail_indikator($id);
            $data['form_indikator'] = $this->m_data_kewilayahan->form_indikator();
            $data['tipe_wilayah'] = array('Pilih','kecamatan','desa');
            if($cek['TIPE'] == '1'){
                $data['list_kecamatan_edit'] = $this->m_data_kewilayahan->list_kecamatan_detail($id);
            } else {
                $data['list_kecamatan_edit'] = $this->m_data_kewilayahan->list_kecamatan_detail($id);
            }
            $data['drop_kecamatan'] = $this->m_data_kewilayahan->drop_kecamatan_edit();
            $this->load->view('kewilayahan/indikator/v_edit', $data);
        }
        else
        {
            echo 'id tidka boleh kosong';
        }
    }

    public function simpan_indikator_desa() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_indikator', 'Indikator', 'trim|required|numeric');
        if($this->form_validation->run()) {
            $tipe = $this->input->post('f_tipe_wilayah');
            $indikator = $this->input->post('f_indikator');
            $kecamatan = $this->input->post('f_nama_kecamatan');
            $desa = $this->input->post('f_desa[]');
            $tahun = $this->input->post('f_tahun[]');
            $capaian = $this->input->post('f_capaian_desa[]');
            $query = $this->m_data_kewilayahan->insert_indikator($indikator,$tipe, $kecamatan,$desa, $tahun, $capaian);

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
    

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_indikator', 'Indikator', 'trim|required|numeric');
        if($this->form_validation->run()) {
            $tipe = $this->input->post('f_tipe_wilayah');
            $indikator = $this->input->post('f_indikator');
            $kecamatan = $this->input->post('f_kecamatan');
            $tahun = $this->input->post('f_tahun[]');
            $capaian = $this->input->post('f_capaian[]');
            $query = $this->m_data_kewilayahan->insert_indikator_kecamatan($indikator,$tipe, $kecamatan, $tahun, $capaian);

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

    public function update_indikator_kecamatan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_indikator', 'Indikator', 'trim|required|numeric');
        if($this->form_validation->run()) {
            $tipe = $this->input->post('f_tipe_wilayah');
            $indikator = $this->input->post('f_indikator');
            $kecamatan = $this->input->post('f_kecamatan');
            $tahun = $this->input->post('f_tahun_kecamatan[]');
            $capaian = $this->input->post('f_capaian[]');
            $query = $this->m_data_kewilayahan->update_indikator_kecamatan($indikator,$tipe, $kecamatan, $tahun, $capaian);

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

    public function update_indikator_desa() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_indikator', 'Indikator', 'trim|required|numeric');
        if($this->form_validation->run()) {
            $tipe = $this->input->post('f_tipe_wilayah');
            $indikator = $this->input->post('f_indikator');
            $kecamatan = $this->input->post('f_nama_kecamatan');
            $desa = $this->input->post('f_desa');
            $tahun = $this->input->post('f_tahun[]');
            $capaian = $this->input->post('f_capaian_desa[]');
            $query = $this->m_data_kewilayahan->update_indikator_desa($indikator,$tipe, $kecamatan,$desa, $tahun, $capaian);

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
            $query = $this->m_data_kewilayahan->delete_indikator($id);
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