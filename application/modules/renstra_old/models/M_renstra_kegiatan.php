<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_renstra_kegiatan extends CI_Model{

    function dropdown_program($id){
        $this->db->select('a.ID,a.PROGRAM');
        $this->db->from('tx_renstra_program AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        $this->db->join('tx_urusan_ref AS c','c.URUSAN_ID = b.ID','INNER');
        $this->db->join('m_skpd AS d','c.SKPD_ID = d.ID','INNER');
        if ($id !== 'all') {
            $this->db->where('c.SKPD_ID', $id);
        }
        $this->db->group_by('a.ID');
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Program';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PROGRAM'];
        }
        return $data;
    }

    function get_urusan_dropdown(){
        $this->db->select('a.ID, a.URUSAN, a.KODE_URUSAN');
        $this->db->from('m_urusan AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = '['.$row['KODE_URUSAN'].']'.' '.$row['URUSAN'];
        }       
        return $data;
    }
    
    function get_sasaran_dropdown(){
        $this->db->select('a.ID, a.SASARAN');
        $this->db->from('tx_renstra_sasaran AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['SASARAN'];
        }       
        return $data;
    }

    function get_program_dropdown(){
        $this->db->select('a.ID, a.PROGRAM');
        $this->db->from('tx_renstra_program AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PROGRAM'];
        }       
        return $data;
    }

    function get_kegiatan_dropdown(){
        $this->db->select('a.ID, a.KEGIATAN');
        $this->db->from('tx_renstra_kegiatan AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['KEGIATAN'];
        }       
        return $data;
    }

    function get_skpd_dropdown(){
        $this->db->select('a.ID, a.NAMA_SKPD');
        $this->db->from('m_skpd as a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['NAMA_SKPD'];
        }       
        return $data;
    }

    function get_list_total($param,$where_program,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_renstra_kegiatan AS a');
        $this->db->join('tx_renstra_program AS b', 'a.PROGRAM_ID = b.ID', 'INNER');
        $this->db->join('m_urusan AS c', 'b.URUSAN_ID = c.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS d', 'd.URUSAN_ID = c.ID', 'INNER');
        $this->db->join('m_skpd AS e', 'd.SKPD_ID = e.ID', 'INNER');
        if($param) {
            $this->db->where($param);
        }
        if($where_program) {
            $this->db->where($where_program);
        }        
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($param,$where_program,$like,$limit,$offset) {
        $this->db->select('a.ID,a.KEGIATAN');
        $this->db->from('tx_renstra_kegiatan AS a');
        $this->db->join('tx_renstra_program AS b', 'a.PROGRAM_ID = b.ID', 'INNER');
        $this->db->join('m_urusan AS c', 'b.URUSAN_ID = c.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS d', 'd.URUSAN_ID = c.ID', 'INNER');
        $this->db->join('m_skpd AS e', 'd.SKPD_ID = e.ID', 'INNER');
        if($param) {
            $this->db->where($param);
        }
        if($where_program) {
            $this->db->where($where_program);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'ASC');
        $this->db->group_by('a.ID');
        return $this->db->get()->result_array();
    }

    function detail($id){

        $this->db->select('
            a.KEGIATAN,
            a.ID,
            b.PROGRAM,
            c.URUSAN,
            e.INDIKATOR,
            b.ID AS PROGRAM_ID,
            c.ID AS URUSAN_ID,
            g.NAMA_SKPD,
            g.ID AS SKPD_ID
        ');
        $this->db->from('tx_renstra_kegiatan AS a');
        $this->db->join('tx_renstra_program AS b', 'a.PROGRAM_ID = b.ID', 'LEFT');
        $this->db->join('m_urusan AS c', 'b.URUSAN_ID = c.ID', 'LEFT');
        $this->db->join('tx_renstra_kegiatan_indikator AS d', 'd.KEGIATAN_ID = a.ID', 'LEFT');
        $this->db->join('v_data_dasar AS e', 'd.DATA_ID = e.ID_INDIKATOR', 'LEFT');
        $this->db->join('tx_urusan_ref AS f', 'f.URUSAN_ID = c.ID', 'LEFT');
        $this->db->join('m_skpd AS g', 'f.SKPD_ID = g.ID', 'LEFT');
        $this->db->where('a.ID', $id);
        $this->db->group_by('e.ID_INDIKATOR');
        return $this->db->get()->row();
    }

    function get_indikator_by_id($id){
        $this->db->select('
            a.ID,
            a.DATA_ID as INDIKATOR_ID,
            b.INDIKATOR,
            a.KEGIATAN_ID,
            c.KEGIATAN,
            b.SATUAN,
            b.`2010`,
            b.`2011`,
            b.`2012`,
            b.`2013`,
            b.`2014`,
            b.`2015`,
            b.`2016`,
            b.`2017`,
            b.`2018`,
            b.`2019`,
            b.`2020`,
            b.`2021`
        ');
        $this->db->from('tx_renstra_kegiatan_indikator AS a');
        $this->db->join('v_data_dasar AS b', 'a.DATA_ID = b.ID_INDIKATOR', 'INNER');
        $this->db->join('tx_renstra_kegiatan AS c', 'a.KEGIATAN_ID = c.ID', 'INNER');
        $this->db->where('a.KEGIATAN_ID', $id);
        $this->db->group_by('b.ID_INDIKATOR');
        return $this->db->get()->result_array();
    }

    function tambah_kegiatan($data) {
        $query = $this->db->insert('tx_renstra_kegiatan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_kegiatan($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_renstra_kegiatan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_kegiatan($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_renstra_kegiatan");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 

}