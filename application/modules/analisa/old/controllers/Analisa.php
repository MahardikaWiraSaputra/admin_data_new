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
            $query = $this->db->query("SELECT
                    a.INDIKATOR,
                    b.TAHUN,
                    b.`DATA`
                    FROM
                    tx_indikator_ref AS a
                    INNER JOIN tx_data_dasar AS b ON b.INDIKATOR_ID = a.ID
                    WHERE
                    a.ID IN ('440','380','118')
                    ")->result();
            foreach($query as $data){
                $res[] = $data->
            }
        }
        $this->load->view('analisa/analisa/v_modal',$data);
    }

    public function list(){
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where_urusan='';

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

        $data['total_items'] = $this->m_analisa->get_list_total($where_urusan)->row('count');
        $data['list_items'] = $this->m_analisa->get_list_urusan($where_urusan, $limit, $offset);
        $this->load->view('analisa/analisa/v_list', $data );
    }

}