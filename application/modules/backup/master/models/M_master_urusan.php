<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_master_urusan extends CI_Model{
   
    function dropdown_skpd(){
        $this->db->select('a.ID, a.KODE_SKPD, a.NAMA_SKPD');
        $this->db->from('m_skpd AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['KODE_SKPD'].' - '.$row['NAMA_SKPD'];
        }       
        return $data;
    }

    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('m_urusan AS a');

        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('
            a.ID,
            a.URUSAN,
            a.KODE_URUSAN,
            a.TIPE_URUSAN,
            GROUP_CONCAT(c.NAMA_SKPD) AS SKPD_PENGAMPU
        ');
        $this->db->from('m_urusan AS a');
        $this->db->join('tx_urusan_ref AS b','a.ID = b.URUSAN_ID','LEFT');
        $this->db->join('m_skpd AS c','b.SKPD_ID = c.ID','LEFT');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->group_by('a.ID');
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    function tambah_urusan($kode_urusan,$urusan,$skpd,$created,$created_by) {
        $this->db->trans_start();
        $data  = array(
            'KODE_URUSAN' => $kode_urusan,
            'URUSAN' => $urusan,
            'CREATED' => $created,
            'CREATED_BY' => $created_by
        );
        $this->db->insert('m_urusan', $data);
        
        $urusan_id = $this->db->insert_id();
        $result = array();
        foreach($skpd as $key => $val) { 
            $result[] = array(
                'URUSAN_ID'   => $urusan_id,
                'SKPD_ID'   => $skpd[$key]
            );
        } 
        $this->db->insert_batch('tx_urusan_ref', $result);
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

    function detail_urusan($id){
        $this->db->select('
            a.ID,
            a.URUSAN,
            a.KODE_URUSAN,
            a.TIPE_URUSAN,
            GROUP_CONCAT(b.SKPD_ID) AS SKPD_PENGAMPU
        ');
        $this->db->from('m_urusan AS a');
        $this->db->join('tx_urusan_ref AS b','a.ID = b.URUSAN_ID','LEFT');
        $this->db->join('m_skpd AS c','b.SKPD_ID = c.ID','LEFT');
        $this->db->where('a.ID', $id);
        $this->db->group_by('a.ID');
        return $this->db->get()->row_array();
    }

    function update_urusan($id,$kode_urusan,$urusan,$skpd,$modified,$modified_by) {
        $this->db->trans_start();
        $data  = array(
            'KODE_URUSAN' => $kode_urusan,
            'URUSAN' => $urusan,
            'MODIFIED' => $modified,
            'MODIFIED_BY' => $modified_by
        );
        $this->db->where('ID',$id);
        $this->db->update('m_urusan',$data);

        $this->db->delete('tx_urusan_ref', array('URUSAN_ID' => $id));
        
        $result = array();
        foreach($skpd as $key => $val) { 
            $result[] = array(
                'URUSAN_ID'   => $id,
                'SKPD_ID'   => $skpd[$key]
            );
        } 
        $this->db->insert_batch('tx_urusan_ref', $result);
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

    function delete_urusan($id){  
        $this->db->trans_start();
        $this->db->delete('m_urusan', array('ID' => $id));
        $this->db->delete('tx_urusan_ref', array('URUSAN_ID' => $id));
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