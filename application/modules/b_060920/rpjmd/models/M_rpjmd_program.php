<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_program extends CI_Model{
    
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
        $this->db->from('tx_rpjmd_sasaran AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['SASARAN'];
        }       
        return $data;
    }

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_rpjmd_program AS a');
        $this->db->join('tx_rpjmd_sasaran AS b','a.SASARAN_ID = b.ID', 'INNER');
        $this->db->join('m_urusan AS c', 'b.URUSAN_ID = c.ID', 'INNER');
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

    function get_list_data($where,$where_urusan,$like,$limit,$offset) {
        $this->db->select('a.ID, a.PROGRAM, b.URUSAN_ID, c.URUSAN');
        $this->db->from('tx_rpjmd_program AS a');
        $this->db->join('tx_rpjmd_sasaran AS b','a.SASARAN_ID = b.ID', 'INNER');
        $this->db->join('m_urusan AS c', 'b.URUSAN_ID = c.ID', 'INNER');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'DESC');
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

    function get_indikator_by_id($id){
        $this->db->select('
            a.ID,
            a.INDIKATOR_ID,
            b.INDIKATOR,
            a.PROGRAM_ID,
            c.PROGRAM,
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
        $this->db->from('tx_rpjmd AS a');
        $this->db->join('v_data_dasar AS b', 'a.INDIKATOR_ID = b.ID_INDIKATOR', 'LEFT');
        $this->db->join('tx_rpjmd_program AS c', 'a.PROGRAM_ID = c.ID', 'LEFT');
        $this->db->where('a.PROGRAM_ID', $id);
        return $this->db->get()->result_array();
    }

    function get_urusan_by_id($id){
        $this->db->select('a.URUSAN_ID');
        $this->db->from('tx_rpjmd_program AS a');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function ceklist_indikator($like, $id){
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
        $this->db->where('a.URUSAN_ID', $id);
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get()->result_array();
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

    function remove_indikator($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_rpjmd");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function tambah_program($data) {
        $query = $this->db->insert('tx_rpjmd_program', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_program($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_rpjmd_program', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_sasaran($id){
        $this->db->trans_start();
        $this->db->delete('tx_rpjmd_program', array('ID' => $id));
        $this->db->delete('tx_rpjmd', array('PROGRAM_ID' => $id));
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