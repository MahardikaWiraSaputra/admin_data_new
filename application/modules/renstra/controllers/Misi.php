<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Misi extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_renstra_misi');
        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_renstra_misi')) {
            redirect('/main/dashboard');
        }        
    }

    public function index(){
        if (!$this->ion_auth->in_group(array(1,2)))
        {
            $id = $this->ion_auth->user()->row()->id;
            $data['filter_skpd'] = $this->m_renstra_misi->filter_skpd($id);
        }
        else
        {
            $data['filter_skpd'] = $this->m_renstra_misi->filter_skpd();
        }
        $this->load->view('renstra/misi/index', $data);
    }


    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = '';

        if($_POST['skpd'] == 'all') {
            $where = '';
        }

        if ($_POST['skpd'] != 'all') {
            $where = '(b.SKPD_ID = "'.$_POST['skpd'].'")';
        }

        // if (isset($_POST['skpd']) && $_POST['skpd'] != NULL) {
        //     $like = '(b.SKPD_ID = "'.$_POST['skpd'].'")';
        // }

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

        $data['total_items'] = $this->m_renstra_misi->get_list_total($where)->row('count');
        $data['list_items'] = $this->m_renstra_misi->get_list_data($where, $limit, $offset);
        $this->load->view('renstra/misi/v_list', $data );
    }


    public function tambah(){
        $data['visi_list'] = $this->m_renstra_misi->get_visi_dropdown();
        $this->load->view('renstra/misi/v_tambah', $data);
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

            $query = $this->m_renstra_misi->tambah_misi($data);
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
            $data['visi_list'] = $this->m_renstra_misi->get_visi_dropdown();
            $data['detail'] = $this->m_renstra_misi->detail($id);
            $data['sub_detail'] = $this->m_renstra_misi->get_tujuan_by_id($id);
            $data['sub_skpd'] = $this->m_renstra_misi->get_skpd_by_id($id);
            $data['ceklist'] = $this->m_renstra_misi->get_skpd_dropdown();
            $this->load->view('renstra/misi/v_detail', $data);
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
            
            $query = $this->m_renstra_misi->update_misi($data);
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
            $query = $this->m_renstra_misi->delete_misi($id);
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

    public function simpan_misi_indikator() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_misi', 'MISI SKPD', 'trim|required');
        // $this->form_validation->set_rules('f_indikator', 'Sasaran Pemda', 'trim|required');
        if($this->form_validation->run()) {
            $misi = $this->input->post('f_misi');
            $skpd = $this->input->post('f_skpd[]');
            $query = $this->m_renstra_misi->insert_skpd_misi($misi, $skpd);

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

}