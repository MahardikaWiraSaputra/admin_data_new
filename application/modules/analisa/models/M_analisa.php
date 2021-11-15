<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_analisa extends CI_Model{
    

    function get_list_total($where_urusan,$like){
        $this->db->select('COUNT(b.ID) as count');
        $this->db->from('v_data_dasar as a');
        $this->db->join('m_urusan as b','a.URUSAN_ID = b.ID');
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like){
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_urusan($where_urusan,$like,$limit,$offset) {
        $this->db->select('b.ID,b.URUSAN,a.INDIKATOR,a.ID_INDIKATOR,a.SATUAN');
        $this->db->from('v_data_dasar as a');
        $this->db->join('m_urusan as b','a.URUSAN_ID = b.ID');
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like){
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.INDIKATOR','ASC');
        return $this->db->get()->result_array();
    }

    function trend($id){
        $this->db->select('
            a.ID_INDIKATOR,
            a.INDIKATOR,
            a.SATUAN,
            a.`target2010`,a.`target2011`,a.`target2012`,a.`target2013`,a.`target2014`,a.`target2015`,a.`target2016`,a.`target2017`,a.`target2018`,a.`target2019`,a.`target2020`,a.`target2021`,
            a.`2010`,
            a.`2011`,
            a.`2012`,
            a.`2013`,
            a.`2014`,
            a.`2015`,
            a.`2016`,
            a.`2017`,
            a.`2018`,
            a.`2019`,
            a.`2020`,
            a.`2021`,b.ID,b.URUSAN
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('m_urusan as b','a.URUSAN_ID = b.ID');
        $this->db->where('a.ID_INDIKATOR', $id);
        return $this->db->get()->result_array();
    }

    function indikator(){
        $this->db->select('a.ID_INDIKATOR,
            a.INDIKATOR,
            a.SATUAN,
            a.`2010`,
            a.`2011`,
            a.`2012`,
            a.`2013`,
            a.`2014`,
            a.`2015`,
            a.`2016`,
            a.`2017`,
            a.`2018`,
            a.`2019`,
            a.`2020`,
            a.`2021`');
        $this->db->from('v_data_dasar as a');
        return $this->db->get()->result_array();
    }

    function rasio_indikatorx($id){
        $this->db->select('a.INDIKATOR_X,a.INDIKATOR_Y,b.INDIKATOR,b.ID,c.TAHUN');
        $this->db->from('rasio_indikator as a');
        $this->db->join('tx_indikator_ref AS b','a.INDIKATOR_Y = b.ID');
        $this->db->join('tx_data_dasar as c','b.ID = c.INDIKATOR_ID');
        $this->db->where('a.INDIKATOR_Xx',$id);
        return $this->db->get()->result_array();
    }

    function rasio_indikator($id){
        $this->db->select('b.ID,b.INDIKATOR,b.ID,a.TIPE');
        $this->db->from('rasio_indikator_fix as a');
        $this->db->join('tx_indikator_ref AS b','a.INDIKATOR_ID = b.ID');
        $this->db->where('a.ID_MASTER',$id);
        $this->db->where('a.TIPE','X');
        return $this->db->get()->row_array();
    }

    function exist_rasio($id){
        $this->db->select('a.ID,a.ID_MASTER,a.INDIKATOR_ID,a.TIPE');
        $this->db->from('rasio_indikator_fix AS a');
        $this->db->where('a.INDIKATOR_ID',$id);
        return $this->db->get()->row_array();
    }

    function val_indikator($id){
        $this->db->select('a.TAHUN,a.DATA,b.INDIKATOR,b.SATUAN');
        $this->db->from('tx_data_dasar as a');
        $this->db->join('tx_indikator_ref AS b','a.INDIKATOR_ID = b.ID');
        $this->db->where('a.INDIKATOR_ID',$id);
        return $this->db->get()->result_array();
    }

    function rasio_trial($id,$tahun){
        // SELECT
        // a.INDIKATOR_RASIO,
        // c.INDIKATOR,
        // b.TAHUN,
        // b.DATA
        // FROM
        // rasio_indikator_v1 AS a
        // INNER JOIN tx_data_dasar AS b ON a.INDIKATOR_RASIO = b.INDIKATOR_ID
        // INNER JOIN tx_indikator_ref AS c ON b.INDIKATOR_ID = c.ID
        // WHERE
        // a.INDIKATOR_MASTER = 4448

        $this->db->select('a.INDIKATOR_RASIO,c.INDIKATOR,b.TAHUN,b.DATA');
        $this->db->from('rasio_indikator_v1 AS a');
        $this->db->join('tx_data_dasar AS b','a.INDIKATOR_RASIO = b.INDIKATOR_ID');
        $this->db->join('tx_indikator_ref AS c','b.INDIKATOR_ID = c.ID');
        $this->db->where('a.INDIKATOR_RASIO',$id);
        $this->db->where('b.TAHUN',$tahun);
        return $this->db->get()->row_array();

        // $this->db->select('a.INDIKATOR_ID,c.INDIKATOR,c.*');
        // $this->db->from('rasio_indikator_sub_trial as a');
        // $this->db->join('rasio_indikator_trial as b','a.ID_RASIO_INDIKATOR = b.id');
        // $this->db->join('v_data_dasar as c','a.INDIKATOR_ID = c.ID_INDIKATOR');
        // $this->db->where('b.INDIKATOR_MASTErR',$id);
        // return $this->db->get()->result_array();
    }

    function rasio_master($id,$tahun){
        // SELECT
        // a.INDIKATOR_RASIO,
        // c.INDIKATOR,
        // b.TAHUN,
        // b.DATA
        // FROM
        // rasio_indikator_v1 AS a
        // INNER JOIN tx_data_dasar AS b ON a.INDIKATOR_RASIO = b.INDIKATOR_ID
        // INNER JOIN tx_indikator_ref AS c ON b.INDIKATOR_ID = c.ID
        // WHERE
        // a.INDIKATOR_MASTER = 4448

        $this->db->select('a.INDIKATOR_MASTER,c.INDIKATOR,b.TAHUN,b.DATA');
        $this->db->from('rasio_indikator_v1 AS a');
        $this->db->join('tx_data_dasar AS b','a.INDIKATOR_MASTER = b.INDIKATOR_ID');
        $this->db->join('tx_indikator_ref AS c','b.INDIKATOR_ID = c.ID');
        $this->db->where('a.INDIKATOR_MASTER',$id);
        $this->db->where('b.TAHUN',$tahun);
        return $this->db->get()->row_array();

        // $this->db->select('a.INDIKATOR_ID,c.INDIKATOR,c.*');
        // $this->db->from('rasio_indikator_sub_trial as a');
        // $this->db->join('rasio_indikator_trial as b','a.ID_RASIO_INDIKATOR = b.id');
        // $this->db->join('v_data_dasar as c','a.INDIKATOR_ID = c.ID_INDIKATOR');
        // $this->db->where('b.INDIKATOR_MASTErR',$id);
        // return $this->db->get()->result_array();
    }
}