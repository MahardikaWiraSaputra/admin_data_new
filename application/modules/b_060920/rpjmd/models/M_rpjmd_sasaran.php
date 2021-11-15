<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_sasaran extends CI_Model{
    
    function get_urusan_dropdown(){
        $this->db->select('a.ID, a.URUSAN, a.KODE_URUSAN');
        $this->db->from('m_urusan AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = '['.$row['KODE_URUSAN'].']'.' '.$row['URUSAN'];
        }       
        return $data;
    }
    
    function get_tujuan_dropdown(){
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_rpjmd_tujuan AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['TUJUAN'];
        }       
        return $data;
    }

    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $this->db->join('tx_rpjmd_tujuan AS b','a.TUJUAN_ID = b.ID', 'INNER');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_tujuan() {
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_rpjmd_tujuan AS a');
        return $this->db->get()->result_array();
    }

    function get_list_data($tujuan, $like,$limit,$offset) {
        $this->db->select('
            a.TUJUAN_ID,
            b.TUJUAN,
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $this->db->join('tx_rpjmd_tujuan AS b','a.TUJUAN_ID = b.ID', 'INNER');
        $this->db->where('b.ID', $tujuan);
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    function detail($id){
        $this->db->select('
            a.URUSAN_ID,
            e.KODE_URUSAN,
            e.URUSAN,
            a.TUJUAN_ID,
            b.TUJUAN,
            b.MISI_ID,
            c.MISI,
            c.VISI_ID,
            d.VISI,
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $this->db->from('tx_rpjmd_tujuan AS b', 'a.TUJUAN_ID = b.ID', 'INNER');
        $this->db->from('tx_rpjmd_misi AS c', 'b.MISI_ID = c.ID', 'INNER');
        $this->db->from('tx_rpjmd_visi AS d', 'c.VISI_ID = d.ID', 'INNER');
        $this->db->from('m_urusan AS e', 'a.URUSAN_ID = e.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_program_by_id($id){
        $this->db->select('
            a.ID,
            a.PROGRAM
        ');
        $this->db->from('tx_rpjmd_program AS a');
        $this->db->where('a.SASARAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function get_indikator_by_id($id){
        $this->db->select('
            a.ID,
            a.SASARAN_ID,
            a.INDIKATOR_ID,
            b.SASARAN,
            c.INDIKATOR,
            c.SATUAN,
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
            c.`2021`
        ');
        $this->db->from('tx_rpjmd_sasaran_indikator AS a');
        $this->db->join('tx_rpjmd_sasaran AS b', 'a.SASARAN_ID = b.ID', 'LEFT');
        $this->db->join('v_data_dasar AS c', 'a.INDIKATOR_ID = c.ID_INDIKATOR', 'INNER');
        $this->db->where('a.SASARAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function ceklist_indikator($like){
        $this->db->select('
            a.INDIKATOR,
            a.ID_INDIKATOR
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_rpjmd_sasaran_indikator AS b', 'a.ID_INDIKATOR = b.INDIKATOR_ID', 'LEFT');
        $this->db->join('tx_rpjmd_tujuan_indikator AS c', 'a.ID_INDIKATOR = c.INDIKATOR_ID', 'LEFT');
        $this->db->join('tx_rpjmd AS d', 'a.ID_INDIKATOR = d.INDIKATOR_ID', 'LEFT');
        $this->db->where('a.RPJMD', '1');
        $this->db->where('(b.SASARAN_ID IS NULL AND b.INDIKATOR_ID IS NULL)');
        $this->db->where('(c.TUJUAN_ID IS NULL AND c.INDIKATOR_ID IS NULL)');
        $this->db->where('(d.PROGRAM_ID IS NULL AND d.INDIKATOR_ID IS NULL)');
        // $this->db->where('a.URUSAN_ID', $id);
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get()->result_array();
    }

    function remove_indikator($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_rpjmd_sasaran_indikator");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
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
        $this->db->insert_batch('tx_rpjmd_sasaran_indikator', $data);
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


    function tambah_sasaran($data) {
        $query = $this->db->insert('tx_rpjmd_sasaran', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_sasaran($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_rpjmd_sasaran', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_sasaran($id){
        $this->db->trans_start();
        $this->db->delete('tx_rpjmd_sasaran', array('ID' => $id));
        $this->db->delete('tx_rpjmd_sasaran_indikator', array('SASARAN_ID' => $id));
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