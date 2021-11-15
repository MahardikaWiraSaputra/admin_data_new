<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_dasar_indikator extends CI_Model{
   
    function dropdown_urusan($id){
        $this->db->select('b.ID, b.URUSAN');
        $this->db->from('tx_urusan_ref AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        if ($id !== 'all') {
            $this->db->where('a.SKPD_ID', $id);
        }
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Urusan';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['URUSAN'];
        }       
        return $data;
    }

    function get_list_total($where,$where_skpd,$where_urusan,$where_tipe,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_indikator_ref AS a');

        if($where) {
            $this->db->where($where);
        }
        if($where_skpd) {
            $this->db->where($where_skpd);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($where_tipe) {
            $this->db->where($where_tipe);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$where_skpd,$where_urusan,$where_tipe,$like,$limit,$offset) {
        $this->db->select('a.ID,
            a.URUSAN_ID,
            a.SKPD_ID,
            a.INDIKATOR,
            a.SATUAN,
            a.TIPE_DATA,
            a.RPJMD,
            a.SPM,
            a.SDGS,
            a.RENSTRA,
            a.KLHS,
            a.CREATED,
            a.CREATED_BY,
            a.MODIFIED,
            a.MODIFIED_BY,
            b.NAMA_SKPD
        ');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID','LEFT');
        if($where) {
            $this->db->where($where);
        }
        if($where_skpd) {
            $this->db->where($where_skpd);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($where_tipe) {
            $this->db->where($where_tipe);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    function tambah_indikator($data) {
        $query = $this->db->insert('tx_indikator_ref', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function detail_indikator($id){
        $this->db->select('a.ID,
            a.URUSAN_ID,
            a.SKPD_ID,
            a.INDIKATOR,
            a.SATUAN,
            a.TIPE_DATA,
            a.RPJMD,
            a.SPM,
            a.SDGS,
            a.RENSTRA,
            a.KLHS,
            a.CREATED,
            a.CREATED_BY,
            a.MODIFIED,
            a.MODIFIED_BY,
            b.NAMA_SKPD,
            c.URUSAN
        ');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID','LEFT');
        $this->db->join('m_urusan AS c','a.URUSAN_ID = c.ID','LEFT');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function update_indikator($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_indikator_ref', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_indikator($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_indikator_ref");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 
}