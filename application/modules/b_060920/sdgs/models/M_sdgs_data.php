<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sdgs_data extends CI_Model{

   function form_pilar(){
        $this->db->select('a.ID, a.PILAR, a.KET');
        $this->db->from('tx_sdgs_pilar AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PILAR'];
        }       
        return $data;
    }

    function form_tujuan($id){
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_sdgs_tujuan AS a');
        $this->db->where('a.PILAR_ID', $id);
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['TUJUAN'];
        }       
        return $data;
    }

    function form_target($id){
        $this->db->select('a.ID, a.TARGET');
        $this->db->from('tx_sdgs_target AS a');
        $this->db->where('a.TUJUAN_ID', $id);
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['TARGET'];
        }       
        return $data;
    }


    function filter_pilar(){
        $this->db->select('a.ID, a.PILAR');
        $this->db->from('tx_sdgs_pilar AS a');
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Pilar';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PILAR'];
        }   
        return $data;
    }

    function filter_tujuan($id){
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

    function filter_target($id){
        $this->db->select('a.ID, a.TARGET');
        $this->db->from('tx_sdgs_target AS a');
        if ($id !== 'all') {
            $this->db->where('a.TUJUAN_ID', $id);
        }
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Target';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['TARGET'];
        }   
        return $data;
    }

    function get_list_total($where,$where_pilar,$where_tujuan,$where_target,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_sdgs AS a');
        $this->db->join('tx_sdgs_target AS b','a.TARGET_ID = b.ID', 'INNER');
        $this->db->join('tx_sdgs_tujuan AS c','b.TUJUAN_ID = c.ID', 'INNER');
        $this->db->join('tx_sdgs_pilar AS d','c.PILAR_ID = d.ID', 'INNER');
        $this->db->join('v_data_dasar AS e','a.INDIKATOR_ID = e.ID_INDIKATOR', 'INNER');
        $this->db->where('e.SDGS', '1');
        if($where) {
            $this->db->where($where);
        }
        if($where_pilar) {
            $this->db->where($where_pilar);
        }
        if($where_tujuan) {
            $this->db->where($where_tujuan);
        }
        if($where_target) {
            $this->db->where($where_target);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$where_pilar,$where_tujuan,$where_target,$like,$limit,$offset) {
        $this->db->select('a.ID, a.INDIKATOR_ID, e.INDIKATOR, a.TARGET_ID, b.TARGET, b.TUJUAN_ID, c.TUJUAN, c.PILAR_ID, d.PILAR, `e`.`SATUAN`, `e`.`2010`, `e`.`2011`, `e`.`2012`, `e`.`2013`, `e`.`2014`, `e`.`2015`, `e`.`2016`, `e`.`2017`, `e`.`2018`, `e`.`2019`, `e`.`2020`, `e`.`2021`');
        $this->db->from('tx_sdgs AS a');
        $this->db->join('tx_sdgs_target AS b','a.TARGET_ID = b.ID', 'INNER');
        $this->db->join('tx_sdgs_tujuan AS c','b.TUJUAN_ID = c.ID', 'INNER');
        $this->db->join('tx_sdgs_pilar AS d','c.PILAR_ID = d.ID', 'INNER');
        $this->db->join('v_data_dasar AS e','a.INDIKATOR_ID = e.ID_INDIKATOR', 'INNER');
        $this->db->where('e.SDGS', '1');
        if($where) {
            $this->db->where($where);
        }
        if($where_pilar) {
            $this->db->where($where_pilar);
        }
        if($where_tujuan) {
            $this->db->where($where_tujuan);
        }
        if($where_target) {
            $this->db->where($where_target);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    function ceklist_indikator(){
        $this->db->select('a.INDIKATOR, a.ID_INDIKATOR');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_sdgs AS b', 'a.ID_INDIKATOR = b.INDIKATOR_ID', 'LEFT');
        $this->db->where('a.SDGS', '1');
        $this->db->where('(b.ID IS NULL)');
        return $this->db->get()->result_array();
    }

    function insert_indikator($target, $indikators){
        $this->db->trans_start();
        $data = array();
        foreach($indikators AS $key => $val){
            $data[] = array(
                'TARGET_ID'   => $target,
                'INDIKATOR_ID'   => $indikators[$key],
                'CREATED'   => date('Y-m-d H:i:s'),
                'CREATED_BY'   => $this->ion_auth->user()->row()->id,
            );
        } 

        $this->db->insert_batch('tx_sdgs', $data); 
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

    function delete_indikator($id){
        $this->db->trans_start();
        $this->db->delete('tx_sdgs', array('ID' => $id));
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