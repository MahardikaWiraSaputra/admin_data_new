<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_analisa extends CI_Model{
    

    function get_list_total($where_urusan){
        $this->db->select('COUNT(b.ID) as count');
        $this->db->from('v_data_dasar as a');
        $this->db->join('m_urusan as b','a.URUSAN_ID = b.ID');
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        return $this->db->get();
    }

    function get_list_urusan($where_urusan,$limit,$offset) {
        $this->db->select('b.ID,b.URUSAN,a.INDIKATOR,a.ID_INDIKATOR,a.SATUAN');
        $this->db->from('v_data_dasar as a');
        $this->db->join('m_urusan as b','a.URUSAN_ID = b.ID');
        if($where_urusan) {
            $this->db->where($where_urusan);
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
}