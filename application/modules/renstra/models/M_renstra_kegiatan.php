<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_renstra_kegiatan extends CI_Model{

    function filter_skpd($id = false)
    {
        $this->db->select('c.ID AS ID_SKPD, c.NAMA_SKPD');
        $this->db->from('users AS a');
        $this->db->join('users_detail AS b', 'b.id_user = a.id', 'INNER');
        $this->db->join('m_skpd AS c', 'b.kd_skpd = c.KODE_SKPD', 'INNER');
        if ($id) 
        {
            $this->db->where('a.id', $id);
        }
        $query = $this->db->get();
        if(!$id){
           $data['all'] = 'Semua Satuan Kerja'; 
        }
        
        foreach ($query->result_array() as $row):
            $data[$row['ID_SKPD']] = $row['NAMA_SKPD'];
        endforeach;
        return $data;
    }

    function filter_urusan($id = false)
    {
        $this->db->select('c.NAMA_SKPD,e.URUSAN,e.ID,e.KODE_URUSAN');
        $this->db->from('users AS a');
        $this->db->join('users_detail AS b','b.id_user = a.id','INNER');
        $this->db->join('m_skpd AS c','b.kd_skpd = c.KODE_SKPD','INNER');
        $this->db->join('tx_urusan_ref AS d','d.SKPD_ID = c.ID','INNER');
        $this->db->join('m_urusan AS e','d.URUSAN_ID = e.ID','INNER');
        if ($id) {
            $this->db->where('a.ID', $id);
        }
        $query = $this->db->get()->result_array();
        if(!$id){
           $data['all'] = 'Semua Urusan';
        }
        foreach ($query as $row):
            $data[$row['ID']] = $row['KODE_URUSAN'].' - '.$row['URUSAN'];
        endforeach;
        return $data;
    }

    function filter_program($id = false)
    {
        $this->db->select('a.ID,a.PROGRAM');
        $this->db->from('tx_renstra_program AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        $this->db->join('tx_urusan_ref AS c','c.URUSAN_ID = b.ID','INNER');
        $this->db->join('m_skpd AS d','c.SKPD_ID = d.ID','INNER');
        $this->db->join('users_detail AS e','e.kd_skpd = d.KODE_SKPD');
        $this->db->join('users AS f','e.id_user = f.id');
        if ($id !== 'all') {
            $this->db->where('f.ID', $id);
        }
        $this->db->group_by('a.ID');
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Program';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PROGRAM'];
        }
        return $data;
    }

    function dropdown_program($id = false){
        $this->db->select('a.ID,a.PROGRAM');
        $this->db->from('tx_renstra_program AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        $this->db->join('tx_urusan_ref AS c','c.URUSAN_ID = b.ID','INNER');
        $this->db->join('m_skpd AS d','c.SKPD_ID = d.ID','INNER');
        if ($id !== 'all') {
            $this->db->where('c.SKPD_ID', $id);
        }
        $this->db->group_by('a.ID');
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Program';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PROGRAM'];
        }
        return $data;
    }

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
        $this->db->from('tx_renstra_sasaran AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['SASARAN'];
        }       
        return $data;
    }

    function get_program_dropdown(){
        $this->db->select('a.ID, a.PROGRAM');
        $this->db->from('tx_renstra_program AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PROGRAM'];
        }       
        return $data;
    }

    function get_kegiatan_dropdown(){
        $this->db->select('a.ID, a.KEGIATAN');
        $this->db->from('tx_renstra_kegiatan AS a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['KEGIATAN'];
        }       
        return $data;
    }

    function get_skpd_dropdown(){
        $this->db->select('a.ID, a.NAMA_SKPD');
        $this->db->from('m_skpd as a');
        $query = $this->db->get()->result_array();
        foreach ($query as $row) {
            $data[$row['ID']] = $row['NAMA_SKPD'];
        }       
        return $data;
    }

    function get_list_total($param,$where_program,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_renstra_kegiatan AS a');
        $this->db->join('tx_renstra_program AS b', 'a.PROGRAM_ID = b.ID', 'INNER');
        $this->db->join('m_urusan AS c', 'b.URUSAN_ID = c.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS d', 'd.URUSAN_ID = c.ID', 'INNER');
        $this->db->join('m_skpd AS e', 'd.SKPD_ID = e.ID', 'INNER');
        if($param) {
            $this->db->where($param);
        }
        if($where_program) {
            $this->db->where($where_program);
        }        
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($param,$where_program,$like,$limit,$offset) {
        $this->db->select('a.ID,a.KEGIATAN,b.URUSAN_ID,a.KODE_KEGIATAN,b.KODE_BIDANG,b.KODE_PROGRAM');
        $this->db->from('tx_renstra_kegiatan AS a');
        $this->db->join('tx_renstra_program AS b', 'a.PROGRAM_ID = b.ID', 'INNER');
        $this->db->join('m_urusan AS c', 'b.URUSAN_ID = c.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS d', 'd.URUSAN_ID = c.ID', 'INNER');
        $this->db->join('m_skpd AS e', 'd.SKPD_ID = e.ID', 'INNER');
        if($param) {
            $this->db->where($param);
        }
        if($where_program) {
            $this->db->where($where_program);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'ASC');
        $this->db->group_by('a.ID');
        return $this->db->get()->result_array();
    }

    function get_list_indikator($param,$like) {
        $this->db->select('c.KODE_INDIKATOR,a.KEGIATAN,b.ID as param_del,a.ID,c.ID_INDIKATOR, c.INDIKATOR, c.SATUAN, c.`2010`, c.`2011`, c.`2012`, c.`2013`, c.`2014`, c.`2015`, c.`2016`, c.`2017`, c.`2018`, c.`2019`, c.`2020`, c.`2021`,c.`target2010`,c.`target2011`,c.`target2012`,c.`target2013`,c.`target2014`,c.`target2015`,c.`target2016`,c.`target2017`,c.`target2018`,c.`target2019`,c.`target2020`,c.`target2021`');
        $this->db->from('tx_renstra_kegiatan AS a');
        $this->db->join('tx_renstra_kegiatan_indikator AS b', 'b.KEGIATAN_ID = a.ID', 'INNER');
        $this->db->join('v_data_dasar as c', 'b.DATA_ID = c.ID_INDIKATOR', 'INNER');
        if($param) {
            $this->db->where('a.ID',$param);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    function detail($id){

        $this->db->select('
            a.KEGIATAN,
            a.ID,
            b.PROGRAM,
            c.URUSAN,
            e.INDIKATOR,
            b.ID AS PROGRAM_ID,
            c.ID AS URUSAN_ID,
            g.NAMA_SKPD,
            g.ID AS SKPD_ID
        ');
        $this->db->from('tx_renstra_kegiatan AS a');
        $this->db->join('tx_renstra_program AS b', 'a.PROGRAM_ID = b.ID', 'LEFT');
        $this->db->join('m_urusan AS c', 'b.URUSAN_ID = c.ID', 'LEFT');
        $this->db->join('tx_renstra_kegiatan_indikator AS d', 'd.KEGIATAN_ID = a.ID', 'LEFT');
        $this->db->join('v_data_dasar AS e', 'd.DATA_ID = e.ID_INDIKATOR', 'LEFT');
        $this->db->join('tx_urusan_ref AS f', 'f.URUSAN_ID = c.ID', 'LEFT');
        $this->db->join('m_skpd AS g', 'f.SKPD_ID = g.ID', 'LEFT');
        $this->db->where('a.ID', $id);
        $this->db->group_by('e.ID_INDIKATOR');
        return $this->db->get()->row();
    }

    function get_indikator_by_id($id){
        $this->db->select('
            a.ID as param_del,
            a.DATA_ID as INDIKATOR_ID,
            b.INDIKATOR,
            a.KEGIATAN_ID,
            c.KEGIATAN,
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
        $this->db->from('tx_renstra_kegiatan_indikator AS a');
        $this->db->join('v_data_dasar AS b', 'a.DATA_ID = b.ID_INDIKATOR', 'INNER');
        $this->db->join('tx_renstra_kegiatan AS c', 'a.KEGIATAN_ID = c.ID', 'INNER');
        $this->db->where('a.KEGIATAN_ID', $id);
        $this->db->group_by('b.ID_INDIKATOR');
        return $this->db->get()->result_array();
    }

    function tambah_kegiatan($data) {
        $query = $this->db->insert('tx_renstra_kegiatan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_kegiatan($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_renstra_kegiatan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_kegiatan($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_renstra_kegiatan");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function remove_indikator($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_renstra_kegiatan_indikator");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}