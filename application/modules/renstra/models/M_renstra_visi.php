<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_renstra_visi extends CI_Model{

    function get_skpd_dropdown(){
        $this->db->select('a.ID, a.NAMA_SKPD');
        $this->db->from('m_skpd AS a');
        $this->db->join('tx_renstra_visi_skpd AS b','a.ID = b.SKPD_ID','LEFT');
        $this->db->join('tx_rpjmd_visi AS c','b.VISI_RPJMD_ID = c.ID','LEFT');
        $this->db->where('c.VISI IS NULL');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_visi_dropdown(){
        $this->db->select('a.ID, a.VISI');
        $this->db->from('tx_rpjmd_visi AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['VISI'];
        }       
        return $data;
    }
    
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

    function tambah_visi_skpd($data) {
        $query = $this->db->insert('tx_renstra_visi_skpd', $data);
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

    function insert_skpd_visi($visi, $skpd){
        $this->db->trans_start();
        $data = array();
        foreach($skpd AS $key => $val){
             $data[] = array(
              'VISI_RPJMD_ID'   => $visi,
              'SKPD_ID'   => $skpd[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 

        $this->db->insert_batch('tx_renstra_visi_skpd', $data); 
        $query = $this->db->trans_complete();
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function get_skpd_by_id($id){
        $this->db->select('
            b.NAMA_SKPD
        ');
        $this->db->from('tx_renstra_visi_skpd AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID');
        $this->db->where('a.VISI_RPJMD_ID', $id);
        return $this->db->get()->result_array();
    }

}