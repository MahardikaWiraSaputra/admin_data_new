<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indikator extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_data_dasar_indikator');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_data_dasar')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        $data = '';
        $this->load->view('data_dasar/indikator/index', $data);
    }

    public function get_urusan($id = false){
        $data['filter_urusan'] = $this->m_data_dasar_indikator->dropdown_urusan($id);
        $this->load->view('data_dasar/indikator/v_filter_urusan', $data);
    }    

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_skpd='';
        $where_urusan = '';
        $where_tipe = '';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL) {
            $like = array('a.INDIKATOR' => $_POST['search_field']);
        }

        if (isset($_POST['skpd']) && $_POST['skpd'] != NULL && $_POST['skpd'] != 'all') {
            $where_skpd = '(a.SKPD_ID = "'.$_POST['skpd'].'")';
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL && $_POST['urusan'] != 'all') {
            $where_urusan = '(a.URUSAN_ID = "'.$_POST['urusan'].'")';
        }

        if (isset($_POST['tipe']) && $_POST['tipe'] != NULL && $_POST['tipe'] != 'all') {
            $where_urusan = '(a.TIPE_DATA = "'.$_POST['tipe'].'")';
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
        $data['total_items'] = $this->m_data_dasar_indikator->get_list_total($where, $where_skpd, $where_urusan, $where_tipe, $like)->row('count');
        $data['list_items'] = $this->m_data_dasar_indikator->get_list_data($where, $where_skpd, $where_urusan, $where_tipe, $like, $limit, $offset);
        $this->load->view('data_dasar/indikator/v_list', $data );
    }

    // tambah
    public function tambah(){
        $data = '';
        $this->load->view('data_dasar/indikator/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_skpd', 'SKPD', 'trim|required|numeric');
        $this->form_validation->set_rules('f_urusan', 'Urusan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_indikator', 'Indikator', 'trim|required');
        $this->form_validation->set_rules('f_kategori', 'Kategori', 'trim|required');
        if($this->form_validation->run()) {
            $skpd_id = htmlspecialchars($this->input->post('f_skpd'));
            $urusan_id = htmlspecialchars($this->input->post('f_urusan'));
            $indikator = htmlspecialchars($this->input->post('f_indikator'));
            $satuan = htmlspecialchars($this->input->post('f_satuan'));
            $tipe_data = htmlspecialchars($this->input->post('f_kategori'));
            $capaian = $this->input->post('f_capaian[]');
            $tahun = $this->input->post('f_tahun[]');
            $rpjmd = htmlspecialchars($this->input->post('is_rpjmd'));
            $renstra = htmlspecialchars($this->input->post('is_renstra'));
            $sdgs = htmlspecialchars($this->input->post('is_sdgs'));
            $spm = htmlspecialchars($this->input->post('is_spm'));
            $created = date('y-m-d h:i:s');
            $created_by = $this->ion_auth->user()->row()->id;
            $query = $this->m_data_dasar_indikator->tambah_indikator($skpd_id,$urusan_id,$indikator,$satuan,$tipe_data,$tahun,$capaian,$rpjmd,$renstra,$sdgs,$spm,$created,$created_by);


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
            $data['detail'] = $this->m_data_dasar_indikator->detail_indikator($id);
            $this->load->view('data_dasar/indikator/v_detail', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }

    }

    // detail edit
    public function edit($id){
        if ($id) {
            $data['detail'] = $this->m_data_dasar_indikator->detail_indikator($id);
            $this->load->view('data_dasar/indikator/v_edit', $data);
        }
        else {
            echo 'id tidka boleh kosong';
        }
    }


    public function update() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_skpd', 'SKPD', 'trim|required|numeric');
        $this->form_validation->set_rules('f_urusan', 'Urusan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_indikator', 'Indikator', 'trim|required');
        $this->form_validation->set_rules('f_kategori', 'Kategori', 'trim|required');
        if($this->form_validation->run()) {
            $detail = $this->m_data_dasar_indikator->detail_indikator($this->input->post('f_id'));
            $id = htmlspecialchars($this->input->post('f_id'));
            $skpd_id = htmlspecialchars($this->input->post('f_skpd'));
            if ($this->input->post('f_urusan') != '0') {
               $urusan_id = htmlspecialchars($this->input->post('f_urusan'));
            }
            else {
                $urusan_id = $detail['URUSAN_ID'];
            }
            $indikator = htmlspecialchars($this->input->post('f_indikator'));
            $satuan = htmlspecialchars($this->input->post('f_satuan'));
            $tipe_data = htmlspecialchars($this->input->post('f_kategori'));
            $capaian = $this->input->post('f_capaian[]');
            $tahun = $this->input->post('f_tahun[]');
            $rpjmd = htmlspecialchars($this->input->post('is_rpjmd'));
            $renstra = htmlspecialchars($this->input->post('is_renstra'));
            $sdgs = htmlspecialchars($this->input->post('is_sdgs'));
            $spm = htmlspecialchars($this->input->post('is_spm'));
            $modified = date('y-m-d h:i:s');
            $modified_by = $this->ion_auth->user()->row()->id;
            
            // $query = $this->m_data_dasar_indikator->update_indikator($data);
            $query = $this->m_data_dasar_indikator->update_indikator($id,$skpd_id,$urusan_id,$indikator,$satuan,$tipe_data,$tahun,$capaian,$rpjmd,$renstra,$sdgs,$spm,$modified,$modified_by);
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


    public function update_status($id, $tipe, $value){
        if($id) {
            $data['ID'] = $id; 
            if ($tipe == 'rpjmd') {
                $data['RPJMD'] = $value;
            }
            elseif ($tipe == 'sdgs') {
                $data['SDGS'] = $value;
            }
            elseif ($tipe == 'spm') {
                $data['SPM'] = $value;
            }
            elseif ($tipe == 'renstra') {
                $data['RENSTRA'] = $value;
            }
            $query = $this->m_data_dasar_indikator->update_kodefikasi($data);
            if ($query) {
                $output['success'] = true;
                $output['message'] = 'KODEFIKASI BERHASIL DIUPDATE';
            }
            else {
                $output['success'] = false;
                $output['message'] = 'KODEFIKASI GAGAL DIUPDATE';
            }
        } else {
            $output['success'] = false;
            $output['message'] = 'KODEFIKASI GAGAL DIUPDATE';
        }
        echo json_encode($output);
    }

    public function delete($id){
        if($id) {         
            $query = $this->m_data_dasar_indikator->delete_indikator($id);
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