<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_visi extends CI_Model{
    
    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_rpjmd_visi AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('a.ID, a.VISI');
        $this->db->from('tx_rpjmd_visi AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    function detail($id){
        $this->db->select('
            a.ID,
            a.VISI
        ');
        $this->db->from('tx_rpjmd_visi AS a');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_misi_by_id($id){
        $this->db->select('
            a.ID,
            a.MISI
        ');
        $this->db->from('tx_rpjmd_misi AS a');
        $this->db->where('a.VISI_ID', $id);
        return $this->db->get()->result_array();
    }

    function tambah_visi($data) {
        $query = $this->db->insert('tx_rpjmd_visi', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_visi($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_rpjmd_visi', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_visi($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_rpjmd_visi");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 

}