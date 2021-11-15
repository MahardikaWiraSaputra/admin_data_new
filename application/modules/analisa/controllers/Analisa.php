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
                for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= date("Y",strtotime("-1 year")); $i++) {
                    $list_tahun[] = $i;
                    $data_tahun[] = array('label'=>"". $i. "",'value'=>"". $data[$i]. "");
                    $tahun[] = array('label'=>"".$i."");
                    $target[] = array('value'=>"".$data['target'.$i]."");
                    
                    $realisasi_tabel[] = $data[$i];

                    $realisasi[] = array('value'=>"".$data[$i]."");
                    $data_trend[] = array('tahun'=>$i,'nilai'=>$data[$i]);
                    $tahun_trend[] = (int)($i);
                    $nilai_trend[] = (int)($data[$i]);

                    if($data['target'.$i]){
                        $capaian[] = array('value'=>"".rupiah($data[$i]/$data['target'.$i]*100)."");
                        $capaian_tabel[]  = rupiah($data[$i]/$data['target'.$i]*100);
                        $target_tabel[] = $data['target'.$i];
                    } else {
                        $capaian[] = array('value'=>"".'0'."");
                        $target_tabel[] = null;
                        $capaian_tabel[] = null;
                    }

                }
            }
            // $x = [
            //     2000,
            //     2001,
            //     2002,
            //     2003,
            //     2004,
            //     2005,
            //     2006,
            //     2007,
            //     2008,
            //     2009
            // ];

            // $y = [
            //     45,
            //     48,
            //     51,
            //     51,
            //     52,
            //     54,
            //     61,
            //     67,
            //     69,
            //     70
            // ];
            $x = [
                2016,
                2017,
                2018,
                2019
            ];

            $y = [
                92.11,
                93.01,
                89.2,
                91.13
            ];
            // var_dump($data_trend);
            $prediksi = new Regresi($tahun_trend,$nilai_trend);
            $prediksi_1 = new Regresi($x,$y);
            // $tes = array('tahun'=>"'".date('Y')."'",'nilai'=>num_format($prediksi->forecast(date('Y'))));
            // var_dump($prediksi_1->forecast(2021));
            // var_dump($prediksi->forecast(2021));
            $tes = array('tahun'=>date('Y'),'nilai'=>num_format($prediksi->forecast(date('Y'))));
            $data_trend[4] = $tes; 
            // print_r($data_trend);
            // array_push($data_trend, array('tahun'=>"'".date('Y')."'",'nilai'=>num_format($prediksi->forecast(date('Y')))));
            $data['forecast'] = num_format($prediksi->forecast(date('Y')));
            // $data['forecast'] = $prediksi;
            $data['list_indikator'] = $this->m_analisa->indikator();
            $data['trend'] = $data_trend;
            $data['data_tahun'] = json_encode($data_tahun);
            $data['data_tahun_rasio'] = json_encode($tahun);
            $data['data_target_rasio'] = json_encode($target);
            $data['data_realisasi'] = json_encode($realisasi);

            $data['data_capaian'] = json_encode($capaian);

            $data['indikator'] = array($indikator,$satuan,$urusan);
            $data['target_tabel'] = $target_tabel;
            $data['realisasi_tabel'] = $realisasi_tabel;
            $data['capaian_tabel'] = $capaian_tabel;

            // $data['indikator_rasio'] = $this->m_analisa->rasio_indikator($id);
            $cek_rasio = $this->m_analisa->exist_rasio($id);
            if($cek_rasio){
                $data['indikator_rasio'] = $this->m_analisa->rasio_indikator($cek_rasio['ID_MASTER']);
            } else {
                $data['indikator_rasio'] = array('ID'=>null,'INDIKATOR'=>null);
            }
            $data['indikator_id'] = $id;
        }
        $this->load->view('analisa/analisa/v_modal',$data);
    }

    public function rasio()
    {
        // if(isset($_POST['indikator_master']) && $_POST['indikator_master'] != NULL && $_POST['rasio_indikator'] != '') {
            $indikator_rasio = $this->m_analisa->rasio_trial($_POST['rasio_indikator'],$_POST['tahun_indikator']);
            $indikator_master = $this->m_analisa->rasio_master($_POST['indikator_master'],$_POST['tahun_indikator']);
            // $data = array('indikator_master'=>$indikator_master,'indikator_rasio'=>$indikator_rasio);
            // $data= array('rasio'=>getRatio($indikator_master['DATA'],$indikator_rasio['DATA']));
            $indikator_master_data = rasio($indikator_master['DATA'],$indikator_rasio['DATA'],100000);
            $indikator_rasio_data = rasio($indikator_master['DATA'],$indikator_rasio['DATA'],100000);

            $data_tahun = array('label'=>"". $_POST['tahun_indikator']. "",'value'=>"". rupiah($indikator_master_data). "");
            $tahun = array('label'=>"".$_POST['tahun_indikator']."");
            $target = array('value'=>"".rupiah($indikator_master_data)."");
            $x = rupiah($indikator_rasio_data);
            $y = rupiah($indikator_master_data);
            $title_y = $indikator_master['INDIKATOR'];
            $title_x = "Per ".rupiah(100000). " ".$indikator_rasio['INDIKATOR'];
            $title_rasio = "Rasio ".$indikator_master['INDIKATOR']." Per ".rupiah(100000)." ".$indikator_rasio['INDIKATOR']." ".$_POST['tahun_indikator'];
            $data = array('data_tahun'=>$data_tahun,'tahun'=>$tahun,'target'=>$target,'x'=>$x,'y'=>$y,'title_y'=>$title_y,'title_x'=>$title_x,'title_rasio'=>$title_rasio);
            echo json_encode($data);
        // }
        // echo json_encode(array('data'=>'belum dapat dirasiokan'));
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