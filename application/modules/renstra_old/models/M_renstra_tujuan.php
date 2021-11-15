<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_renstra_tujuan extends CI_Model{

    function get_misi_dropdown(){
        $this->db->select('a.ID, a.MISI');
        $this->db->from('tx_rpjmd_misi AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['MISI'];
        }       
        return $data;
    }

    function get_tujuan_rpjmd_dropdown(){
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
        $this->db->from('tx_renstra_tujuan AS a');
        $this->db->join('tx_renstra_tujuan_skpd as b','b.TUJUAN_ID = a.ID');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('a.TUJUAN');
        return $this->db->get();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_renstra_tujuan AS a');
        $this->db->join('tx_renstra_tujuan_skpd as b','b.TUJUAN_ID = a.ID','LEFT');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('a.TUJUAN');
        $this->db->order_by('a.TUJUAN','ASC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    function detail($id){
        $this->db->select('
            b.VISI_ID,
            c.VISI,
            a.MISI_RPJMD_ID,
            a.TUJUAN_RPJMD_ID,
            b.MISI,
            a.ID,
            a.TUJUAN
        ');
        $this->db->from('tx_renstra_tujuan AS a');
        $this->db->from('tx_rpjmd_misi AS b', 'a.MISI_RPJMD_ID = b.ID', 'INNER');
        $this->db->from('tx_rpjmd_visi AS c', 'b.VISI_ID = c.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_sasaran_by_id($id){
        $this->db->select('
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_renstra_sasaran AS a');
        $this->db->where('a.TUJUAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function tambah_tujuan($data) {
        $query = $this->db->insert('tx_renstra_tujuan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_tujuan($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_renstra_tujuan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_tujuan($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_renstra_tujuan");
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
        $this->db->join('tx_renstra_tujuan_skpd AS b','a.ID = b.SKPD_ID','LEFT');
        $this->db->join('tx_renstra_tujuan AS c','b.TUJUAN_ID = c.ID','LEFT');
        $this->db->where('c.TUJUAN IS NULL');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_skpd_by_id($id){
        $this->db->select('
            b.NAMA_SKPD
        ');
        $this->db->from('tx_renstra_tujuan_skpd AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID');
        $this->db->where('a.TUJUAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function insert_skpd_tujuan($tujuan, $skpd){
        $this->db->trans_start();
        $data = array();
        foreach($skpd AS $key => $val){
             $data[] = array(
              'TUJUAN_ID'   => $tujuan,
              'SKPD_ID'   => $skpd[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 

        $this->db->insert_batch('tx_renstra_tujuan_skpd', $data); 
        $query = $this->db->trans_complete();
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}