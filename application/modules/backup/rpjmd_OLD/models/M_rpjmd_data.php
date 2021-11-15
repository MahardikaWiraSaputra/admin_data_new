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
        $this->db->from('tx_rpjmd_sasaran AS b', 'a.SASARAN_ID = b.ID', 'INNER');
        $this->db->from('tx_rpjmd_tujuan AS c', 'b.TUJUAN_ID = c.ID', 'INNER');
        $this->db->from('tx_rpjmd_misi AS d', 'c.MISI_ID = d.ID', 'INNER');
        $this->db->from('tx_rpjmd_visi AS e', 'd.VISI_ID = e.ID', 'INNER');
        $this->db->from('m_urusan AS f', 'a.URUSAN_ID = f.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }


}