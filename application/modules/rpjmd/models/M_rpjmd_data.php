<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_data extends CI_Model{

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(*) as count');
        $this->db->from('v_data_rpjmd AS a');

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
        $this->db->from('v_data_rpjmd AS a');
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
        $this->db->from('v_data_rpjmd AS a');
        $this->db->where('a.ID_PROGRAM', $program);
        return $this->db->get()->result_array();
    }

    function detail($id){
        $this->db->select('
            c.KEGIATAN,
            c.ID AS KEGIATAN_ID,
            b.PROGRAM,
            b.ID,
            f.NAMA_SKPD,
            f.ID AS SKPD_ID,
            e.URUSAN,
            e.ID AS URUSAN_ID
        ');
        $this->db->from('tx_rpjmd_program_kegiatan AS a');
        $this->db->join('tx_rpjmd_program AS b', 'a.PROGRAM_ID = b.ID', 'INNER');
        $this->db->join('tx_rpjmd_kegiatan_copy1 AS c', 'a.KEGIATAN_ID = c.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS d', 'b.URUSAN_ID = d.URUSAN_ID', 'INNER');
        $this->db->join('m_urusan AS e', 'd.URUSAN_ID = e.ID', 'INNER');
        $this->db->join('m_skpd AS f', 'd.SKPD_ID = f.ID', 'INNER');
        $this->db->where('a.KEGIATAN_ID', $id);
        $this->db->group_by('C.KEGIATAN');
        return $this->db->get()->row();
    }
    function detailx($id){
        $this->db->select('
            a.ID,
            a.PROGRAM,
            a.SASARAN_ID,
            b.SASARAN,
            b.TUJUAN_ID,
            c.TUJUAN,
            c.MISI_ID,
            d.MISI,
            d.VISI_ID,
            e.VISI,
            a.URUSAN_ID,
            f.URUSAN
        ');
        $this->db->from('tx_rpjmd_program AS a');
        $this->db->join('tx_rpjmd_sasaran AS b', 'a.SASARAN_ID = b.ID', 'INNER');
        $this->db->join('tx_rpjmd_tujuan AS c', 'b.TUJUAN_ID = c.ID', 'INNER');
        $this->db->join('tx_rpjmd_misi AS d', 'c.MISI_ID = d.ID', 'INNER');
        $this->db->join('tx_rpjmd_visi AS e', 'd.VISI_ID = e.ID', 'INNER');
        $this->db->join('m_urusan AS fv', 'a.URUSAN_ID = f.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function ceklist_indikator($like,$id){
        $this->db->select('
            a.INDIKATOR,
            a.ID_INDIKATOR,
            a.URUSAN_ID
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_rpjmd_kegiatan_indikator AS b', 'a.ID_INDIKATOR = b.DATA_ID', 'LEFT');
        $this->db->where('a.RPJMD', '1');
        $this->db->where('(b.KEGIATAN_ID IS NULL AND b.DATA_ID IS NULL)');
        $this->db->where('a.URUSAN_ID', $id);
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get()->result_array();
    }

    function get_urusan_by_id($id){
        $this->db->select('b.URUSAN_ID,a.ID,a.PROGRAM_ID,a.KEGIATAN_ID');
        $this->db->from('tx_rpjmd_program_kegiatan AS a');
        $this->db->join('tx_rpjmd_program AS b','a.PROGRAM_ID = b.ID');
        $this->db->where('a.KEGIATAN_ID', $id);
        return $this->db->get()->row();
    }

    function insert_indikatorX($program, $indikators){
        $this->db->trans_start();
        $data = array();
        foreach($indikators AS $key => $val){
             $data[] = array(
              'PROGRAM_ID'   => $program,
              'INDIKATOR_ID'   => $indikators[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 
        $this->db->insert_batch('tx_rpjmd', $data); 
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function insert_indikator($program,$kegiatan, $indikators){
        $this->db->trans_start();
        $data = array();
        foreach($indikators AS $key => $val){
             $data[] = array(
              'DATA_ID'   => $indikators[$key],
              'KEGIATAN_ID'=>$kegiatan,
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 
        $this->db->insert_batch('tx_rpjmd_kegiatan_indikator', $data); 
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } 
        else {
            $this->db->trans_commit();
            return TRUE;
        }
    }


}