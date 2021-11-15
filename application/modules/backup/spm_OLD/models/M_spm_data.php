<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_spm_data extends CI_Model{

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('tx_spm AS b', 'a.ID = b.SASARAN_ID', 'LEFT');
        $this->db->join('v_data_dasar AS c', 'b.INDIKATOR_ID = c.ID_INDIKATOR', 'INNER');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_sasaran($where,$where_urusan,$like,$limit,$offset) {
        $this->db->select('a.ID, a.SASARAN, a.URUSAN_ID, c.INDIKATOR');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('tx_spm AS b', 'a.ID = b.SASARAN_ID', 'LEFT');
        $this->db->join('v_data_dasar AS c', 'b.INDIKATOR_ID = c.ID_INDIKATOR', 'LEFT');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('a.ID');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }


    function get_list_data($sasaran) {
        $this->db->select('a.ID,
            a.URUSAN_ID,
            a.SASARAN,
            c.INDIKATOR,
            c.`2010`,
            c.`2011`,
            c.`2012`,
            c.`2013`,
            c.`2014`,
            c.`2015`,
            c.`2016`,
            c.`2017`,
            c.`2018`,
            c.`2019`,
            c.`2020`,
            c.`2021`'
        );
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('tx_spm AS b', 'a.ID = b.SASARAN_ID', 'LEFT');
        $this->db->join('v_data_dasar AS c', 'b.INDIKATOR_ID = c.ID_INDIKATOR', 'INNER');
        $this->db->where('a.ID', $sasaran);
        return $this->db->get()->result_array();
    }


}

