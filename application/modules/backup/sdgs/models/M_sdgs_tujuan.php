<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sdgs_tujuan extends CI_Model{
    
   function dropdown_pilar(){
        $this->db->select('
            a.ID,
            a.PILAR,
            a.KET'
        );
        $this->db->from('tx_sdgs_pilar AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PILAR'];
        }       
        return $data;
    }

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
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    function tambah_tujuan($data) {
        $query = $this->db->insert('tx_sdgs_tujuan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function detail($id){
        $this->db->select('
            a.ID,
            a.PILAR_ID,
            a.TUJUAN,
            a.CREATED,
            a.CREATED_BY,
            a.MODIFIED,
            a.MODIFIED_BY
        ');
        $this->db->from('tx_sdgs_tujuan AS a');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_target_by_id($id){
        $this->db->select('
            a.ID,
            a.TARGET
        ');
        $this->db->from('tx_sdgs_target AS a');
        $this->db->where('a.TUJUAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function update_tujuan($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_sdgs_tujuan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_tujuan($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_sdgs_tujuan");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}