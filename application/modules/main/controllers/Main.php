<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_main');
        if (!$this->ion_auth->logged_in()) {
            redirect('/login');
        }
    }

    public function index(){
        $data['page'] = 'main/index';
        $this->load->view('backend/layout', $data);
    }

    public function dashboard(){
        $user = $this->ion_auth->user()->row();
        $where = '';
        $where_urusan = '';
        $where_skpd = '';

        if($user->username != 'superadmin'){
            $where = '(a.SKPD_ID = "' . $user->skpd_id . '")';
            $where_urusan = '(c.ID = "' . $user->skpd_id . '")';
            $where_skpd = '(b.SKPD_ID = "'. $user->skpd_id .'")';
        }

        $data['total_indikator'] = $this->model_main->total_indikator($where);
        $data['total_urusan'] = $this->model_main->total_urusan($where_urusan);
        $get_keterisian = $this->model_main->total_terisi($where_skpd);
        if($get_keterisian){
            $data['total_terisi'] = $get_keterisian/$data['total_indikator']['total']*100;
        }else {
            $data['total_terisi'] = 0;
        }
        
        $this->load->view('main/dashboard',$data);
    }

    public function periode(){
        $periode = $this->input->post('periode');
        $this->session->unset_userdata('periode');
        $new_session = $this->session->set_userdata('periode', $periode);
        
        if ($new_session) {
            $result['success'] = true;
        }
        else {
            $result['success'] = false;
        }
    }

}