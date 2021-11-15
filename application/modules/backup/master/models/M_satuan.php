<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_urusan_skpd extends CI_Model{
    
    function get_skpd_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('new_m_skpd AS a');

        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_skpd($where,$like,$limit,$offset) {
        $this->db->select('a.ID,
                            a.KODE_SKPD,
                            a.NAMA_SKPD,
                            a.ALAMAT_SKPD,
                            a.TELP,
                            a.FAX,
                            a.WEB,
                            a.EMAIL,
                            a.ORD,
                            COUNT(b.URUSAN_ID) AS JML_URUSAN');
        $this->db->from('new_m_skpd AS a');
        $this->db->join('new_t_urusan_skpd AS b', 'a.ID = b.SKPD_ID', 'LEFT');
        $this->db->group_by('a.ID');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }


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