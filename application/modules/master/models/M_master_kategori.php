<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_master_kategori extends CI_Model{
   
    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('m_kategori AS a');

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
            a.KATEGORI
        ');
        $this->db->from('m_kategori AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }


    function tambah_kategori($data) {
        $query = $this->db->insert('m_kategori', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function detail_kategori($id){
        $this->db->select('
            a.ID,
            a.KATEGORI,
            a.CREATED_BY,
            a.CREATED,
            a.MODIFIED_BY,
            a.MODIFIED
        ');
        $this->db->from('m_kategori AS a');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row_array();
    }

    function update_kategori($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('m_kategori', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_kategori($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("m_kategori");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 
}