<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_sasaran extends CI_Model{
    
    function get_urusan_dropdown(){
        $this->db->select('a.ID, a.URUSAN, a.KODE_URUSAN');
        $this->db->from('m_urusan AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = '['.$row['KODE_URUSAN'].']'.' '.$row['URUSAN'];
        }       
        return $data;
    }
    
    function get_tujuan_dropdown(){
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_rpjmd_tujuan AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['TUJUAN'];
        }       
        return $data;
    }

    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $this->db->join('tx_rpjmd_tujuan AS b','a.TUJUAN_ID = b.ID', 'INNER');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_tujuan($where,$like,$limit,$offset) {
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

    function get_list_data($tujuan) {
        $this->db->select('
            a.TUJUAN_ID,
            b.TUJUAN,
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $this->db->join('tx_rpjmd_tujuan AS b','a.TUJUAN_ID = b.ID', 'INNER');
        $this->db->where('b.ID', $tujuan);
        return $this->db->get()->result_array();
    }

    function detail($id){
        $this->db->select('
            a.URUSAN_ID,
            e.KODE_URUSAN,
            e.URUSAN,
            a.TUJUAN_ID,
            b.TUJUAN,
            b.MISI_ID,
            c.MISI,
            c.VISI_ID,
            d.VISI,
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $this->db->from('tx_rpjmd_tujuan AS b', 'a.TUJUAN_ID = b.ID', 'INNER');
        $this->db->from('tx_rpjmd_misi AS c', 'b.MISI_ID = c.ID', 'INNER');
        $this->db->from('tx_rpjmd_visi AS d', 'c.VISI_ID = d.ID', 'INNER');
        $this->db->from('m_urusan AS e', 'a.URUSAN_ID = e.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_program_by_id($id){
        $this->db->select('
            a.ID,
            a.PROGRAM
        ');
        $this->db->from('tx_rpjmd_program AS a');
        $this->db->where('a.SASARAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function tambah_sasaran($data) {
        $query = $this->db->insert('tx_rpjmd_sasaran', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_sasaran($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_rpjmd_sasaran', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_sasaran($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_rpjmd_sasaran");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 
}