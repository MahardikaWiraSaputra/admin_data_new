<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_misi extends CI_Model{

    function get_visi_dropdown(){
        $this->db->select('a.ID, a.VISI');
        $this->db->from('tx_rpjmd_visi AS a');
        $query = $this->db->get()->result_array();
        if($query){
            foreach ($query as $row) {
                $data[$row['ID']] = $row['VISI'];
            }
        } else {
            $data = '';
        }
        return $data;
    }

    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_rpjmd_misi AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('a.ID, a.MISI');
        $this->db->from('tx_rpjmd_misi AS a');
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
            b.VISI,
            a.ID,
            a.MISI,
            a.VISI_ID
        ');
        $this->db->from('tx_rpjmd_misi AS a');
        $this->db->from('tx_rpjmd_visi AS b', 'a.VISI_ID = b.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_tujuan_by_id($id){
        $this->db->select('
            a.ID,
            a.TUJUAN
        ');
        $this->db->from('tx_rpjmd_tujuan AS a');
        $this->db->where('a.MISI_ID', $id);
        return $this->db->get()->result_array();
    }

    function tambah_misi($data) {
        $query = $this->db->insert('tx_rpjmd_misi', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_misi($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_rpjmd_misi', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_misi($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_rpjmd_misi");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 

}