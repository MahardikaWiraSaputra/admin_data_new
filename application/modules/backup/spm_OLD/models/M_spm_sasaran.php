<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_spm_sasaran extends CI_Model{
    

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(a.ID) as count');
        $this->db->from('new_t_spm_sasaran AS a');
        $this->db->join('new_t_spm AS b','a.ID = b.SASARAN_ID','INNER');
        $this->db->join('new_t_data_dasar AS c','b.DATA_ID = c.ID','INNER');
        $this->db->join('new_t_indikator AS d','c.INDIKATOR_ID = d.ID','INNER');
        $this->db->join('new_t_urusan_skpd AS e','c.URUSAN_ID = e.URUSAN_ID','INNER');
        $this->db->join('new_m_urusan AS f','c.URUSAN_ID = f.ID','INNER');
        $this->db->join('new_m_skpd AS g','e.SKPD_ID = g.ID','INNER');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('a.ID, count'); 
        return $this->db->get();
    }

    function get_list_tujuan($where,$where_urusan,$like,$limit,$offset) {
        $this->db->select('a.ID, a.SASARAN');
        $this->db->from('new_t_spm_sasaran AS a');
        $this->db->join('new_t_spm AS b','a.ID = b.SASARAN_ID','INNER');
        $this->db->join('new_t_data_dasar AS c','b.DATA_ID = c.ID','INNER');
        $this->db->join('new_t_indikator AS d','c.INDIKATOR_ID = d.ID','INNER');
        $this->db->join('new_t_urusan_skpd AS e','c.URUSAN_ID = e.URUSAN_ID','INNER');
        $this->db->join('new_m_urusan AS f','c.URUSAN_ID = f.ID','INNER');
        $this->db->join('new_m_skpd AS g','e.SKPD_ID = g.ID','INNER');
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

   


}