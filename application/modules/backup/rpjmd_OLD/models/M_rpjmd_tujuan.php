<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_tujuan extends CI_Model{

    function get_misi_dropdown(){
        $this->db->select('a.ID, a.MISI');
        $this->db->from('tx_rpjmd_misi AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['MISI'];
        }       
        return $data;
    }

    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_rpjmd_tujuan AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_rpjmd_tujuan AS a');
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
            b.VISI_ID,
            c.VISI,
            a.MISI_ID,
            b.MISI,
            a.ID,
            a.TUJUAN
        ');
        $this->db->from('tx_rpjmd_tujuan AS a');
        $this->db->from('tx_rpjmd_misi AS b', 'a.MISI_ID = b.ID', 'INNER');
        $this->db->from('tx_rpjmd_visi AS c', 'b.VISI_ID = c.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_sasaran_by_id($id){
        $this->db->select('
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $this->db->where('a.TUJUAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function tambah_tujuan($data) {
        $query = $this->db->insert('tx_rpjmd_tujuan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_tujuan($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_rpjmd_tujuan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_tujuan($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_rpjmd_tujuan");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 

}