<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sdgs_target extends CI_Model{
    
   function dropdown_pilar(){
        $this->db->select('
            a.ID,
            a.PILAR,
            a.KET'
        );
        $this->db->from('tx_sdgs_pilar AS a');
        $query = $this->db->get()->result_array();
        if($query){
         foreach ($query as $row) {
            $data[$row['ID']] = $row['PILAR'];
         }
        } else {
            $data = '';   
        }
               
        return $data;
    }

    function dropdown_tujuan($id){
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_sdgs_tujuan AS a');
        $this->db->where('a.PILAR_ID', $id);
        $query = $this->db->get()->result_array();
        if($query){
         foreach ($query as $row) {
            $data[$row['ID']] = $row['TUJUAN'];
         }
        } else {
            $data = '';   
        }
               
        return $data;
    }

    function get_list_total($where,$where_pilar,$like){
        $this->db->select('count(a.ID) as count');
        $this->db->from('tx_sdgs_target AS a');
        $this->db->join('tx_sdgs_tujuan AS b','a.TUJUAN_ID = b.ID','INNER');
        $this->db->join('tx_sdgs_pilar AS c','b.PILAR_ID = c.ID','INNER');
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
        $this->db->select('
            a.ID,
            a.TARGET,
            a.TUJUAN_ID,
            b.TUJUAN,
            b.PILAR_ID,
            c.PILAR
        ');
        $this->db->from('tx_sdgs_target AS a');
        $this->db->join('tx_sdgs_tujuan AS b','a.TUJUAN_ID = b.ID','INNER');
        $this->db->join('tx_sdgs_pilar AS c','b.PILAR_ID = c.ID','INNER');
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

    function tambah_target($data) {
        $query = $this->db->insert('tx_sdgs_target', $data);
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
            a.TARGET,
            a.TUJUAN_ID,
            b.TUJUAN,
            b.PILAR_ID,
            c.PILAR
        ');
        $this->db->from('tx_sdgs_target AS a');
        $this->db->join('tx_sdgs_tujuan AS b','a.TUJUAN_ID = b.ID','INNER');
        $this->db->join('tx_sdgs_pilar AS c','b.PILAR_ID = c.ID','INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_indikator_by_id($id){
        $this->db->select('
            a.ID,
            a.TARGET
        ');
        $this->db->from('tx_sdgs_target AS a');
        $this->db->where('a.TUJUAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function update_target($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_sdgs_target', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_target($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_sdgs_target");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}