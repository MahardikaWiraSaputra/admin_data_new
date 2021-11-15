<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisa extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_analisa');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_analisa')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('analisa/analisa/index', $data);
    }

    public function modal($id)
    {
        if($id) {
            $trend = $this->m_analisa->trend($id);
            foreach($trend as $data){
                $indikator = $data['INDIKATOR'];
                $satuan = $data['SATUAN'];
                $urusan = $data['URUSAN'];
                for ($i=2011; $i < 2021; $i++) {
                    $data_tahun[] = array('label'=>"". $i. "",'value'=>"". $data[$i]. "");
                    $tahun[] = array('label'=>"".$i."");
                    $target[] = array('value'=>"".$data[$i]."");
                }
            }
            $data['list_indikator'] = $this->m_analisa->indikator();
            $data['data_tahun'] = json_encode($data_tahun);
            $data['data_tahun_rasio'] = json_encode($tahun);
            $data['data_target_rasio'] = json_encode($target);
            $data['indikator'] = array($indikator,$satuan,$urusan);
        }
        $this->load->view('analisa/analisa/v_modal',$data);
    }

    public function daftar(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where_urusan='';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL ) {
            $like = array('a.INDIKATOR' => $_POST['search_field']);
        }

        if($_POST['urusan'] == 'all') {
            $where_urusan = '';
        }

        if ($_POST['urusan'] != 'all') {
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

        $data['total_items'] = $this->m_analisa->get_list_total($where_urusan,$like)->row('count');
        $data['list_items'] = $this->m_analisa->get_list_urusan($where_urusan, $like, $limit, $offset);
        $this->load->view('analisa/analisa/v_list', $data );
    }

}