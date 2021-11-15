<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_spm_data extends CI_Model{

   function filter_urusan(){
        $this->db->select('
            b.ID,
            b.KODE_URUSAN,
            b.URUSAN
        ');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('m_urusan AS b', 'a.URUSAN_ID = b.ID', 'INNER');
        $this->db->group_by('a.URUSAN_ID');
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Urusan';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['KODE_URUSAN'].' - '.$row['URUSAN'];
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
        foreach ($query as $row) {
            $data[$row['ID']] = $row['KODE_URUSAN'].' - '.$row['URUSAN'];
        }       
        return $data;
    }


    function form_sasaran($id){
        $this->db->select('a.ID, a.SASARAN');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->where('a.URUSAN_ID', $id);
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['SASARAN'];
        }       
        return $data;
    }

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('tx_spm AS b', 'a.ID = b.SASARAN_ID', 'LEFT');
        $this->db->join('v_data_dasar AS c', 'b.INDIKATOR_ID = c.ID_INDIKATOR', 'INNER');
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

    function get_list_sasaran($where,$where_urusan,$like,$limit,$offset) {
        $this->db->select('a.ID, a.SASARAN, a.URUSAN_ID, c.INDIKATOR');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('tx_spm AS b', 'a.ID = b.SASARAN_ID', 'LEFT');
        $this->db->join('v_data_dasar AS c', 'b.INDIKATOR_ID = c.ID_INDIKATOR', 'LEFT');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('a.ID');
        $this->db->order_by('a.ID','DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }


    function get_list_data($sasaran) {
        $this->db->select('
            a.URUSAN_ID,
            a.SASARAN,
            b.ID,
            c.INDIKATOR,
            c.`2010`,
            c.`2011`,
            c.`2012`,
            c.`2013`,
            c.`2014`,
            c.`2015`,
            c.`2016`,
            c.`2017`,
            c.`2018`,
            c.`2019`,
            c.`2020`,
            c.`2021`'
        );
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('tx_spm AS b', 'a.ID = b.SASARAN_ID', 'LEFT');
        $this->db->join('v_data_dasar AS c', 'b.INDIKATOR_ID = c.ID_INDIKATOR', 'INNER');
        $this->db->where('a.ID', $sasaran);
        $this->db->order_by('a.ID','DESC');
        return $this->db->get()->result_array();
    }

    function ceklist_indikator(){
        $this->db->select('
            a.INDIKATOR,
            a.ID_INDIKATOR
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_spm AS b', 'a.ID_INDIKATOR = b.INDIKATOR_ID', 'LEFT');
        $this->db->where('a.SPM', '1');
        $this->db->where('(b.ID IS NULL)');
        return $this->db->get()->result_array();
    }

    function insert_indikator($sasaran, $indikators){
        $this->db->trans_start();
        $data = array();
        foreach($indikators AS $key => $val){
             $data[] = array(
              'SASARAN_ID'   => $sasaran,
              'INDIKATOR_ID'   => $indikators[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 

        $this->db->insert_batch('tx_spm', $data); 
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
        $this->db->delete('tx_spm', array('ID' => $id));
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

