<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rpjmd_kegiatan extends CI_Model{

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

    function filter_program()
    {
        $this->db->select('a.ID,a.PROGRAM');
        $this->db->from('tx_rpjmd_program AS a');
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Program';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['PROGRAM'];
        }
        return $data;
    }

    function dropdown_programX($id = false){
        $this->db->select('a.ID,a.PROGRAM');
        $this->db->from('tx_rpjmd_program AS a');
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

    function dropdown_program($id = false){
        $this->db->select('a.ID,a.PROGRAM');
        $this->db->from('tx_rpjmd_program AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        if ($id !== 'all') {
            $this->db->where('a.URUSAN_ID', $id);
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
        $this->db->from('tx_rpjmd_program AS a');
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
        $this->db->from('tx_rpjmd_program_kegiatan AS a');
        $this->db->join('tx_rpjmd_program AS b', 'a.PROGRAM_ID = b.ID', 'INNER');
        $this->db->join('tx_rpjmd_kegiatan_copy1 AS c', 'a.KEGIATAN_ID = c.ID', 'INNER');
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
        $this->db->select('c.ID,b.PROGRAM,c.KEGIATAN,e.NAMA_SKPD,f.URUSAN');
        $this->db->from('tx_rpjmd_program_kegiatan AS a');
        $this->db->join('tx_rpjmd_program AS b', 'a.PROGRAM_ID = b.ID', 'INNER');
        $this->db->join('tx_rpjmd_kegiatan_copy1 AS c', 'a.KEGIATAN_ID = c.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS d', 'd.URUSAN_ID = d.URUSAN_ID', 'INNER');
        $this->db->join('m_skpd AS e', 'd.SKPD_ID = e.ID', 'INNER');
        $this->db->join('m_urusan AS f','d.URUSAN_ID = f.ID','INNER');

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
        $this->db->group_by('c.KEGIATAN');
        return $this->db->get()->result_array();
    }

    function get_list_indikator($param,$like) {
        $this->db->select('c.KEGIATAN,a.ID as param_del,
                            b.INDIKATOR,
                            b.ID_INDIKATOR,
                            b.URUSAN_ID,
                            b.SKPD_ID,
                            b.KODE_INDIKATOR,
                            b.SATUAN,
                            b.KATEGORI,
                            b.RPJMD,
                            b.SPM,
                            b.SDGS,
                            b.RENSTRA,
                            b.KLHS,
                            b.LKJIP,
                            b.LKPJ,
                            b.LPPD,
                            b.TIDAK_TERISI,
                            b.CREATED,
                            b.CREATED_BY,
                            b.MODIFIED,
                            b.MODIFIED_BY,
                            b.target2010,
                            b.target2011,
                            b.target2012,
                            b.target2013,
                            b.target2014,
                            b.target2015,
                            b.target2016,
                            b.target2017,
                            b.target2018,
                            b.target2019,
                            b.target2020,
                            b.target2021,
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
                            b.`2021`');
        $this->db->from('tx_rpjmd_kegiatan_indikator AS a');
        $this->db->join('v_data_dasar AS b', 'a.DATA_ID = b.ID_INDIKATOR', 'INNER');
        $this->db->join('tx_rpjmd_kegiatan_copy1 AS c', 'a.KEGIATAN_ID = c.ID', 'INNER');
        if($param) {
            $this->db->where('c.ID',$param);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    function detail($id){
        $this->db->select('
            c.KEGIATAN,
            c.ID,
            b.PROGRAM,
            b.ID AS PROGRAM_ID,
            f.NAMA_SKPD,
            f.ID AS SKPD_ID,
            e.URUSAN,
            e.ID AS URUSAN_ID,
            h.NEW_INDIKATOR AS `AS INDIKATOR`
        ');
        $this->db->from('tx_rpjmd_program_kegiatan AS a');
        $this->db->join('tx_rpjmd_program AS b', 'a.PROGRAM_ID = b.ID', 'INNER');
        $this->db->join('tx_rpjmd_kegiatan_copy1 AS c', 'a.KEGIATAN_ID = c.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS d', 'b.URUSAN_ID = d.URUSAN_ID', 'INNER');
        $this->db->join('m_urusan AS e', 'd.URUSAN_ID = e.ID', 'INNER');
        $this->db->join('m_skpd AS f', 'd.SKPD_ID = f.ID', 'INNER');
        $this->db->join('tx_rpjmd_kegiatan_indikator AS g', 'g.KEGIATAN_ID = c.ID', 'LEFT');
        $this->db->join('tx_indikator_ref AS h', 'g.DATA_ID = h.ID', 'LEFT');
        $this->db->where('c.ID', $id);
        $this->db->group_by('C.KEGIATAN');
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
        $this->db->from('tx_rpjmd_kegiatan_indikator AS a');
        $this->db->join('v_data_dasar AS b', 'a.DATA_ID = b.ID_INDIKATOR', 'INNER');
        $this->db->join('tx_rpjmd_kegiatan_copy1 AS c', 'a.KEGIATAN_ID = c.ID', 'INNER');
        $this->db->where('a.KEGIATAN_ID', $id);
        $this->db->group_by('b.ID_INDIKATOR');
        return $this->db->get()->result_array();
    }

    function tambah_kegiatan($data) {
        $query = $this->db->insert('tx_rpjmd_kegiatan_copy1', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function tambah_program_kegiatan($data_program) {
        $query = $this->db->insert('tx_rpjmd_program_kegiatan', $data_program);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_kegiatan($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_rpjmd_kegiatan_copy1', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }
    function update_program_kegiatan($data) {
        $this->db->where('KEGIATAN_ID', $data['KEGIATAN_ID']);
        $query = $this->db->update('tx_rpjmd_program_kegiatan', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_kegiatan($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_rpjmd_kegiatan_copy1");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function remove_indikator($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_rpjmd_kegiatan_indikator");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}