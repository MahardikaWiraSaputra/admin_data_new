<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_renstra_data extends CI_Model{

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(*) as count');
        $this->db->from('v_data_renstra AS a');

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

    function get_list_program($where,$where_urusan,$like,$limit,$offset) {
        $this->db->select('a.ID_PROGRAM, a.PROGRAM');
        $this->db->from('v_data_renstra AS a');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('a.ID_PROGRAM');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }


    function get_list_data($program) {
        $this->db->select('a.*');
        $this->db->from('v_data_renstra AS a');
        $this->db->where('a.ID_PROGRAM', $program);
        return $this->db->get()->result_array();
    }


    function get_urusan_by_id($id){
        $this->db->select('b.PROGRAM,a.KEGIATAN,b.URUSAN_ID');
        $this->db->from('tx_renstra_kegiatan AS a');
        $this->db->join('tx_renstra_program AS b','a.PROGRAM_ID = b.ID','INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function detail($id){

        $this->db->select('
            a.KEGIATAN,
            a.ID,
            b.PROGRAM,
            c.URUSAN,
            e.INDIKATOR,
            b.ID AS PROGRAM_ID,
            a.ID AS `PROGRAM_ID`,
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
        return $this->db->get()->row();
    }

    function ceklist_indikator($id,$like){
        $this->db->select('
            a.INDIKATOR,
            a.ID_INDIKATOR,
            a.URUSAN_ID');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_renstra_kegiatan_indikator AS b', 'a.ID_INDIKATOR = b.DATA_ID' , 'LEFT');
        $this->db->where('a.RENSTRA', '1');
        // $this->db->where('(b.KEGIATAN_ID IS NULL AND b.KEGIATAN_ID IS NULL)');
        $this->db->where('a.URUSAN_ID', $id);
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('a.INDIKATOR');
        return $this->db->get()->result_array();
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

    function insert_indikator($kegiatan_id, $indikators){
        $this->db->trans_start();
        $data = array();
        foreach($indikators AS $key => $val){
             $data[] = array(
              'KEGIATAN_ID'   => $kegiatan_id,
              'DATA_ID'   => $indikators[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 

        $this->db->insert_batch('tx_renstra_kegiatan_indikator', $data); 
        $query = $this->db->trans_complete();
        if ($query) {
            return true;
        }
        else {
            return false;
        }
        
    }

}