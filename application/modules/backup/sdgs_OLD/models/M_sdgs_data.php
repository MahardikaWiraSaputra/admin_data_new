<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sdgs_data extends CI_Model{

    function dropdown_tujuan($id){
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_sdgs_tujuan AS a');
        if ($id !== 'all') {
            $this->db->where('a.PILAR_ID', $id);
        }
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Tujuan';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['TUJUAN'];
        }   

        return $data;
    }

    function get_list_total($where,$where_pilar,$where_tujuan,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_sdgs_pilar AS a');
        $this->db->join('tx_sdgs_tujuan AS b','a.ID = b.PILAR_ID', 'INNER');
        $this->db->join('tx_sdgs_target AS c','b.ID = c.TUJUAN_ID', 'INNER');
        $this->db->join('tx_sdgs AS d','c.ID = d.TARGET_ID', 'INNER');
        $this->db->join('v_data_dasar AS e','d.INDIKATOR_ID = e.ID_INDIKATOR', 'INNER');
        if($where) {
            $this->db->where($where);
        }
        if($where_pilar) {
            $this->db->where($where_pilar);
        }
        if($where_tujuan) {
            $this->db->where($where_tujuan);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_target($where,$where_pilar,$where_tujuan,$like,$limit,$offset) {
        $this->db->select('c.TARGET, d.TARGET_ID');
        $this->db->from('tx_sdgs_pilar AS a');
        $this->db->join('tx_sdgs_tujuan AS b','a.ID = b.PILAR_ID', 'INNER');
        $this->db->join('tx_sdgs_target AS c','b.ID = c.TUJUAN_ID', 'INNER');
        $this->db->join('tx_sdgs AS d','c.ID = d.TARGET_ID', 'INNER');
        $this->db->join('v_data_dasar AS e','d.INDIKATOR_ID = e.ID_INDIKATOR', 'INNER');
        if($where) {
            $this->db->where($where);
        }
        if($where_pilar) {
            $this->db->where($where_pilar);
        }
        if($where_tujuan) {
            $this->db->where($where_tujuan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('c.TUJUAN_ID');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }


    function get_list_data($target) {
        $this->db->select('
            a.PILAR,
            b.PILAR_ID,
            b.TUJUAN,
            c.TUJUAN_ID,
            c.TARGET,
            d.TARGET_ID,
            e.URUSAN_ID,
            e.SKPD_ID,
            e.SATUAN,
            e.INDIKATOR,
            e.`2010`,
            e.`2011`,
            e.`2012`,
            e.`2013`,
            e.`2014`,
            e.`2015`,
            e.`2016`,
            e.`2017`,
            e.`2018`,
            e.`2019`,
            e.`2020`,
            e.`2021`
        ');
        $this->db->from('tx_sdgs_pilar AS a');
        $this->db->join('tx_sdgs_tujuan AS b','a.ID = b.PILAR_ID', 'INNER');
        $this->db->join('tx_sdgs_target AS c','b.ID = c.TUJUAN_ID', 'INNER');
        $this->db->join('tx_sdgs AS d','c.ID = d.TARGET_ID', 'INNER');
        $this->db->join('v_data_dasar AS e','d.INDIKATOR_ID = e.ID_INDIKATOR', 'INNER');
        $this->db->where('d.TARGET_ID', $target);
        return $this->db->get()->result_array();
    }


}