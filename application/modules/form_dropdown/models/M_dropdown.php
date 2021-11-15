<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dropdown extends CI_Model{
   
    function dropdown_urusan($id){
        $this->db->select('b.ID, b.URUSAN');
        $this->db->from('tx_urusan_ref AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        if ($id !== 'all') {
            $this->db->where('a.SKPD_ID', $id);
        }
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['URUSAN'];
        }       
        return $data;
    }

    public function dropdown_tipe(){
        $this->db->select('a.ID, a.TIPE');
        $this->db->from('m_tipe_data AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['TIPE']] = $row['TIPE'];
        }       
        return $data;
    }

}