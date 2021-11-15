<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Elemen extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->auth->cek_auth();
        $this->load->model('m_data_dasar_elemen');
    }

    public function index(){
        echo 'hayooo....';
    }

    public function tambah($id) {
        $data['indikator'] = $this->m_data_dasar_elemen->get_indikator($id)->row();
        $this->load->view('data_dasar/elemen/v_tambah', $data);
    }

    public function simpan() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('indikator_id', 'Indikator', 'trim|required|numeric');
        $this->form_validation->set_rules('elemen', 'Elemen', 'trim|required');
        if($this->form_validation->run()) {
            $data['INDIKATOR_ID'] = htmlspecialchars($this->input->post('indikator_id'));
            $data['ELEMEN'] = htmlspecialchars($this->input->post('elemen'));
            $data['CREATED'] = date('Y-m-d H:i:s');
            $data['CREATED_BY'] = $this->session->userdata('userid');

            $query = $this->m_data_dasar_elemen->tambah_elemen($data);
            if ($query) {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DISIMPAN';
            }
            else {
                $output['success'] = false;
                $output['message'] = 'DATA GAGAL DISIMPAN 2';
            }
        } 
        else {
            $output['success'] = false;
            $output['message'] = 'DATA GAGAL DISIMPAN 1';
        }
        echo json_encode($output);
    }

}