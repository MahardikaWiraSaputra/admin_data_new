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
        $this->db->join('tx_rpjmd_sasaran AS b', 'a.SASARAN_ID = b.ID', 'INNER');
        $this->db->join('tx_rpjmd_tujuan AS c', 'b.TUJUAN_ID = c.ID', 'INNER');
        $this->db->join('tx_rpjmd_misi AS d', 'c.MISI_ID = d.ID', 'INNER');
        $this->db->join('tx_rpjmd_visi AS e', 'd.VISI_ID = e.ID', 'INNER');
        $this->db->join('m_urusan AS f', 'a.URUSAN_ID = f.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function ceklist_indikator($id){
        $this->db->select('
            a.INDIKATOR,
            a.ID_INDIKATOR,
            a.URUSAN_ID
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_rpjmd AS b', 'a.ID_INDIKATOR = b.INDIKATOR_ID', 'LEFT');
        $this->db->where('a.RPJMD', '1');
        $this->db->where('(b.PROGRAM_ID IS NULL AND b.INDIKATOR_ID IS NULL)');
        $this->db->where('a.URUSAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function get_urusan_by_id($id){
        $this->db->select('a.URUSAN_ID');
        $this->db->from('tx_rpjmd_program AS a');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function insert_indikator($program, $indikators){
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
        $query = $this->db->trans_complete();
        if ($query) {
            return true;
        }
        else {
            return false;
        }
        
    }


}