<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_spm_sasaran extends CI_Model{

   function filter_urusan(){
        $this->db->select('b.ID, b.KODE_URUSAN, b.URUSAN');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('m_urusan AS b', 'a.URUSAN_ID = b.ID', 'INNER');
        $this->db->group_by('a.URUSAN_ID');
        $query = $this->db->get();
        $data['all'] = 'Semua Urusan';
            if ($query->num_rows() > 1) {
               foreach ($query->result_array() as $row) {
                $data[$row['ID']] = $row['KODE_URUSAN'].' - '.$row['URUSAN'];
            }   
        }
        return $data;
    }

   function form_urusan(){
        $this->db->select('
            a.ID,
            a.KODE_URUSAN,
            a.URUSAN
        ');
        $this->db->from('m_urusan AS a');
        $query = $this->db->get()->result_array();
        if($query){
           foreach ($query as $row) {
             $data[$row['ID']] = $row['KODE_URUSAN'].' - '.$row['URUSAN'];
           } 
        } else {
             $data = '';
        }
        return $data;
    }

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(a.ID) as count');
        $this->db->from('tx_spm_sasaran AS a');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$where_urusan,$like,$limit,$offset) {
        $this->db->select('
            a.ID,
            a.URUSAN_ID,
            a.SASARAN,
            b.URUSAN
        ');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('m_urusan AS b', 'a.URUSAN_ID = b.ID', 'INNER');

        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    function tambah_sasaran($data) {
        $query = $this->db->insert('tx_spm_sasaran', $data);
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
            a.SASARAN,
            a.URUSAN_ID,
            b.URUSAN
        ');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }


    function update_sasaran($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_spm_sasaran', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_sasaran($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_spm_sasaran");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}