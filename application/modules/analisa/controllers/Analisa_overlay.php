<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisa_overlay extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_analisa_overlay');

        if( ! $this->ion_auth->logged_in() )
            redirect('/login');

        if (!$this->ion_auth_acl->has_permission('analisa_overlay')) {
            redirect('/main/dashboard');
        }  
    }

    public function index(){
        $data = '';
        $this->load->view('analisa/analisa_overlay/index', $data);
    }

    public function modal($id)
    {
        if($id) {
            // $list_overlay = $this->m_analisa_overlay->list_indikator($id);
            // $indikator_y = $this->m_analisa_overlay->data_indikator_master($list_overlay->INDIKATOR_MASTER);
            // $indikator_x = $this->m_analisa_overlay->data_indikator_x($list_overlay->INDIKATOR_X);
            // $indikator_tambahan = $this->m_analisa_overlay->data_indikator_tambahan($list_overlay->INDIKATOR_TAMBAHAN);
            
            // foreach($indikator_y as $data){
            //     $data_y[] = array('label'=>$data['2018'],'x'=>$data['2018'],'showverticalline'=>'1');
            //     $data_label_y[] = array('y'=>$data['2018']);
            // }
            // $data['data_y'] = json_encode($data_y);
            // foreach($indikator_x as $data){
            //     $data_label_x[] = array('x'=>$data['2018']);
            // }
            // foreach($indikator_tambahan as $data){
            //     $data_tambahan[] = array('z'=>$data['2018'],'name'=>$data['NAMA_KEC']);
            // }
            // $tahun = date('Y');
            $tahun = '2019';
            $get_data = $this->m_analisa_overlay->get_data_y($id,$tahun);
            foreach($get_data as $data){
                $judul_analisa = $data['JUDUL'];
                
                $list_indikator = $this->m_analisa_overlay->indikator_overlay($id);
                    
                    $indikator_y = '';
                    $indikator_x = '';
                    $indikator_tambahan = '';

                    foreach($list_indikator as $result){
                        if($result['TIPE'] == 'Y'){
                            $indikator_y = $result['INDIKATOR'];
                        } elseif($result['TIPE'] == 'X') {
                            $indikator_x = $result['INDIKATOR'];
                        } elseif($result['TIPE'] =='TAMBAHAN'){
                            $indikator_tambahan = $result['INDIKATOR'];
                        }
                    }
                

                $data_y[] = array('label'=>$data[$tahun],'x'=>$data[$tahun],'showverticalline'=>'1');
            }

            $get_data_all = $this->m_analisa_overlay->get_data_kec($id,$tahun);
            foreach($get_data_all as $data){
                $cek_data = $this->m_analisa_overlay->get_data_by_kec($id,$data['NAMA_KEC'],$tahun);
                    $data_all[] = array('x'=>$cek_data['Y'],'y'=>$cek_data['X'],'z'=>$cek_data['Z'],'name'=>$cek_data['NAMA_KEC']);
            }
            // echo json_encode($data_all);
            
            // $a = $data_label_x[$data_label_y];
            // $all_data = $a[$data_tambahan];
            // echo json_encode($all_data);

            // $data['data_x'] = json_encode($data_x);
            $data['data_y'] = json_encode($data_y);
            $data['data_all'] = json_encode($data_all);
            $data['id'] = $id;
            $data['title'] = $judul_analisa;
            $data['indikator_y'] = $indikator_y;
            $data['indikator_x'] = $indikator_x;
            $data['indikator_tambahan'] = $indikator_tambahan;
        }
        $this->load->view('analisa/analisa_overlay/v_modal',$data);
    }

    function filter_overlay(){

        $tahun = $this->input->post('tahun');
        $analisa = $this->input->post('analisa');

        if($tahun){

            $get_data = $this->m_analisa_overlay->get_data_y($analisa,$tahun);
            foreach($get_data as $data){
                $judul_analisa = $data['JUDUL'];
                $data_y[] = array('label'=>$data[$tahun],'x'=>$data[$tahun],'showverticalline'=>'1');
            }

            $list_indikator = $this->m_analisa_overlay->indikator_overlay($analisa);
                    
                    $indikator_y = '';
                    $indikator_x = '';
                    $indikator_tambahan = '';

                    foreach($list_indikator as $result){
                        if($result['TIPE'] == 'Y'){
                            $indikator_y = $result['INDIKATOR'];
                        } elseif($result['TIPE'] == 'X') {
                            $indikator_x = $result['INDIKATOR'];
                        } elseif($result['TIPE'] =='TAMBAHAN'){
                            $indikator_tambahan = $result['INDIKATOR'];
                        }
                    }

            $get_data_all = $this->m_analisa_overlay->get_data_kec($analisa,$tahun);
            foreach($get_data_all as $data){
                $cek_data = $this->m_analisa_overlay->get_data_by_kec($analisa,$data['NAMA_KEC'],$tahun);
                    $data_all[] = array('x'=>$cek_data['Y'],'y'=>$cek_data['X'],'z'=>$cek_data['Z'],'name'=>$cek_data['NAMA_KEC']);
            }

            $data = array(
                'data_y'=>$data_y,
                'data_all'=>$data_all,
                'judul'=>$judul_analisa,
                'indikator_y' => $indikator_y,
                'indikator_x' => $indikator_x,
                'indikator_tambahan' => $indikator_tambahan
            );
            echo json_encode($data);
        }

    }

    public function rasio()
    {
        if(isset($_POST['indikator_master']) && $_POST['indikator_master'] != NULL) {
            $indikator_rasio = $this->m_analisa_overlay->rasio_trial($_POST['rasio_indikator'],$_POST['tahun_indikator']);
            $indikator_master = $this->m_analisa_overlay->rasio_master($_POST['indikator_master'],$_POST['tahun_indikator']);
            // $data = array('indikator_master'=>$indikator_master,'indikator_rasio'=>$indikator_rasio);
            // $data= array('rasio'=>getRatio($indikator_master['DATA'],$indikator_rasio['DATA']));
            $indikator_master_data = getRatio1($indikator_master['DATA'],$indikator_rasio['DATA']);
            $indikator_rasio_data = getRatio2($indikator_master['DATA'],$indikator_rasio['DATA']);

            $data_tahun = array('label'=>"". $_POST['tahun_indikator']. "",'value'=>"". $indikator_master_data. "");
            $tahun = array('label'=>"".$_POST['tahun_indikator']."");
            $target = array('value'=>"".$indikator_master_data."");
            $x = num_format($indikator_rasio_data);
            $y = $indikator_master_data;
            $title_y = $indikator_master['INDIKATOR'];
            $title_x = "Per ".num_format($indikator_rasio_data). " ".$indikator_rasio['INDIKATOR'];
            $title_rasio = "Rasio ".$indikator_master['INDIKATOR']." Per ".num_format($indikator_rasio['DATA'])." ".$indikator_rasio['INDIKATOR']." ".$_POST['tahun_indikator'];
            $data = array('data_tahun'=>$data_tahun,'tahun'=>$tahun,'target'=>$target,'x'=>$x,'y'=>$y,'title_y'=>$title_y,'title_x'=>$title_x,'title_rasio'=>$title_rasio);
            echo json_encode($data);
        }
    }

    public function listx(){
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

        $data['total_items'] = $this->m_analisa_overlay->get_list_total($where_urusan,$like)->row('count');
        $data['list_items'] = $this->m_analisa_overlay->get_list_urusan($where_urusan, $like, $limit, $offset);
        $this->load->view('analisa/analisa_overlay/v_list', $data );
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
        $data['total_items'] = $this->m_analisa_overlay->get_list_total($where, $like)->row('count');
        $data['list_items'] = $this->m_analisa_overlay->get_list_data($where, $like, $limit, $offset);

        foreach($data['list_items'] as $key =>$val){
            $indikator = $this->m_analisa_overlay->list_indikator($val['ID']);
            if($indikator){
                $data['list_indikator'][$val['ID']] = $indikator;
            }
        }

        $this->load->view('analisa/analisa_overlay/v_list', $data );
    }

}