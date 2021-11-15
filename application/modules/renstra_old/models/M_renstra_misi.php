<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_renstra_misi extends CI_Model{

    function get_visi_dropdown(){
        $this->db->select('a.ID, a.VISI');
        $this->db->from('tx_rpjmd_visi AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['VISI'];
        }       
        return $data;
    }

    function get_list_total($where){
        $this->db->select('count(*) as count');
        $this->db->from('tx_rpjmd_misi as a');
        $this->db->join('tx_renstra_misi_skpd AS b','b.MISI_RPJMD_ID = a.ID','LEFT');
        if($where) {
            $this->db->where($where);
        }
        $this->db->group_by('a.MISI');
        return $this->db->get();
    }

    function get_list_data($where,$limit,$offset) {
        $this->db->select('a.ID, a.MISI');
        $this->db->from('tx_rpjmd_misi as a');
        $this->db->join('tx_renstra_misi_skpd AS b','b.MISI_RPJMD_ID = a.ID','LEFT');
        if($where) {
            $this->db->where($where);
        }
        $this->db->group_by('a.MISI');
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
        $this->db->from('tx_renstra_tujuan AS a');
        $this->db->where('a.MISI_RPJMD_ID', $id);
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

    function get_skpd_dropdown(){
        $this->db->select('a.ID, a.NAMA_SKPD');
        $this->db->from('m_skpd AS a');
        $this->db->join('tx_renstra_misi_skpd AS b','a.ID = b.SKPD_ID','LEFT');
        $this->db->join('tx_rpjmd_misi AS c','b.MISI_RPJMD_ID = c.ID','LEFT');
        $this->db->where('c.MISI IS NULL');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_skpd_by_id($id){
        $this->db->select('
            b.NAMA_SKPD
        ');
        $this->db->from('tx_renstra_misi_skpd AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID');
        $this->db->where('a.MISI_RPJMD_ID', $id);
        return $this->db->get()->result_array();
    }

    function insert_skpd_misi($misi, $skpd){
        $this->db->trans_start();
        $data = array();
        foreach($skpd AS $key => $val){
             $data[] = array(
              'MISI_RPJMD_ID'   => $misi,
              'SKPD_ID'   => $skpd[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 

        $this->db->insert_batch('tx_renstra_misi_skpd', $data); 
        $query = $this->db->trans_complete();
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}