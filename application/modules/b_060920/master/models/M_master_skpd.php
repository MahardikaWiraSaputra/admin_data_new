<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_master_skpd extends CI_Model{
   
    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('m_skpd AS a');

        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('
            a.ID,
            a.KODE_SKPD,
            a.NAMA_SKPD,
            a.ALAMAT_SKPD,
            a.TELP,
            a.FAX,
            a.WEB,
            a.EMAIL,
            a.ORD
        ');
        $this->db->from('m_skpd AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.KODE_SKPD', 'ASC');
        return $this->db->get()->result_array();
    }


    function tambah_skpd($data) {
        $query = $this->db->insert('m_skpd', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function detail_skpd($id){
        $this->db->select('
            a.ID,
            a.KODE_SKPD,
            a.NAMA_SKPD,
            a.ALAMAT_SKPD,
            a.TELP,
            a.FAX,
            a.WEB,
            a.EMAIL,
            a.ORD
        ');
        $this->db->from('m_skpd AS a');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row_array();
    }

    function update_skpd($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('m_skpd', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_skpd($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("m_skpd");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 
}