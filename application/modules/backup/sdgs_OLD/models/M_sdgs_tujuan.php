<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sdgs_tujuan extends CI_Model{
    

    function get_list_total($where,$where_pilar,$like){
        $this->db->select('count(a.ID) as count');
        $this->db->from('tx_sdgs_tujuan AS a');
        $this->db->join('tx_sdgs_pilar AS b','a.PILAR_ID = b.ID','INNER');
        if($where) {
            $this->db->where($where);
        }
        if($where_pilar) {
            $this->db->where($where_pilar);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$where_pilar,$like,$limit,$offset) {
        $this->db->select('a.ID, a.TUJUAN, b.PILAR');
        $this->db->from('tx_sdgs_tujuan AS a');
        $this->db->join('tx_sdgs_pilar AS b','a.PILAR_ID = b.ID','INNER');
        if($where) {
            $this->db->where($where);
        }
        if($where_pilar) {
            $this->db->where($where_pilar);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

   


}