<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_tujuan extends CI_Model{

    function get_misi_dropdown(){
        $this->db->select('a.ID, a.MISI');
        $this->db->from('tx_rpjmd_misi AS a');
        $query = $this->db->get()->result_array();
        if($query){
           foreach ($query as $row) {
             $data[$row['ID']] = $row['MISI'];
           } 
        } else {
            $data = '';
        }
              
        return $data;
    }

    function list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_rpjmd_tujuan AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function list_data($where,$like,$limit,$offset) {
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_rpjmd_tujuan AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function list_indikator($id) {
        $this->db->select('a.ID, a.TUJUAN_ID, b.TUJUAN, c.ID_INDIKATOR, c.INDIKATOR, c.SATUAN, c.`2010`, c.`2011`, c.`2012`, c.`2013`, c.`2014`, c.`2015`, c.`2016`, c.`2017`, c.`2018`, c.`2019`, c.`2020`, c.`2021`,c.`target2010`,c.`target2011`,c.`target2012`,c.`target2013`,c.`target2014`,c.`target2015`,c.`target2016`,c.`target2017`,c.`target2018`,c.`target2019`,c.`target2020`,c.`target2021`');
        $this->db->from('tx_rpjmd_tujuan_indikator AS a');
        $this->db->join('tx_rpjmd_tujuan AS b','a.TUJUAN_ID = b.ID', 'LEFT');
        $this->db->join('v_data_dasar AS c','a.INDIKATOR_ID = c.ID_INDIKATOR', 'LEFT');
        $this->db->where('a.TUJUAN_ID', $id);
        $this->db->order_by('a.ID', 'DESC');
        $query = $this->db->get(); 
        return $query->result_array();
    }

    function detail($id){
        $this->db->select('b.VISI_ID, c.VISI, a.MISI_ID, b.MISI, a.ID, a.TUJUAN');
        $this->db->from('tx_rpjmd_tujuan AS a');
        $this->db->from('tx_rpjmd_misi AS b', 'a.MISI_ID = b.ID', 'INNER');
        $this->db->from('tx_rpjmd_visi AS c', 'b.VISI_ID = c.ID', 'INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_sasaran_by_id($id){
        $this->db->select('
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $this->db->where('a.TUJUAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function get_indikator_by_id($id){
        $this->db->select('a.ID, a.TUJUAN_ID, a.INDIKATOR_ID, b.TUJUAN, c.INDIKATOR, c.SATUAN, c.`2010`, c.`2011`, c.`2012`, c.`2013`, c.`2014`, c.`2015`, c.`2016`, c.`2017`, c.`2018`, c.`2019`, c.`2020`, c.`2021`');
        $this->db->from('tx_rpjmd_tujuan_indikator AS a');
        $this->db->join('tx_rpjmd_tujuan AS b', 'a.TUJUAN_ID = b.ID', 'LEFT');
        $this->db->join('v_data_dasar AS c', 'a.INDIKATOR_ID = c.ID_INDIKATOR', 'INNER');
        $this->db->where('a.TUJUAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function ceklist_indikator($like){
        $this->db->select('a.INDIKATOR, a.ID_INDIKATOR');
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

    function insert_indikator($tujuan, $indikators){
        $this->db->trans_begin();
        $data = array();
        foreach($indikators AS $key => $val){
            $data[] = array(
                'TUJUAN_ID'   => $tujuan,
                'INDIKATOR_ID'   => $indikators[$key],
                'CREATED'   => date('Y-m-d H:i:s'),
                'CREATED_BY'   => $this->ion_auth->user()->row()->id,
            );
        } 
        $this->db->insert_batch('tx_rpjmd_tujuan_indikator', $data);
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
        $this->db->where("INDIKATOR_ID", $id);
        $query = $this->db->delete("tx_rpjmd_tujuan_indikator");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 

    function tambah_tujuan($data) {
        $query = $this->db->insert('tx_rpjmd_tujuan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_tujuan($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_rpjmd_tujuan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_tujuan($id){
        $this->db->trans_begin();
        $this->db->delete('tx_rpjmd_tujuan', array('ID' => $id));
        $this->db->delete('tx_rpjmd_tujuan_indikator', array('TUJUAN_ID' => $id));
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