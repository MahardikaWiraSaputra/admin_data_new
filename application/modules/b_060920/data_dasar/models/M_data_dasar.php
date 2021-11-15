<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_dasar extends CI_Model{
    
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
        $this->db->from('v_data_dasar AS a');

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
        $this->db->select('a.ID_INDIKATOR,
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
            a.`2010`,
            a.`2011`,
            a.`2012`,
            a.`2013`,
            a.`2014`,
            a.`2015`,
            a.`2016`,
            a.`2017`,
            a.`2018`,
            a.`2019`,
            a.`2020`,
            a.`2021`
        ');
        $this->db->from('v_data_dasar AS a');
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
        $this->db->order_by('a.ID_INDIKATOR','DESC');
        return $this->db->get()->result_array();
    }

    // function get_list_elemen($urusan) {
    //     $this->db->select('a.ID_INDIKATOR, a.INDIKATOR, a.ID_URUSAN, a.URUSAN, a.ID_SKPD, a.NAMA_SKPD, a.SATUAN, a.`2010`, a.`2011`, a.`2012`, a.`2013`, a.`2014`, a.`2015`, a.`2016`, a.`2017`, a.`2018`, a.`2019`, a.`2020`, a.`2021`');
    //     $this->db->from('v_data_dasar AS a');
    //     $this->db->where('a.ID_URUSAN', $urusan);
    //     return $this->db->get()->result_array();
    // }

    function tambah_value($data) {
        $query = $this->db->insert('t_dt_dasar_value', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}