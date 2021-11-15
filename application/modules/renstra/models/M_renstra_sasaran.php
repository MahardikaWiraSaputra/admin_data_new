<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_renstra_sasaran extends CI_Model{

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
    
    function get_urusan_dropdown(){
        $this->db->select('a.ID, a.URUSAN, a.KODE_URUSAN');
        $this->db->from('m_urusan AS a');
        $query = $this->db->get()->result_array();
        if($query){
           foreach ($query as $row) {
            $data[$row['ID']] = '['.$row['KODE_URUSAN'].']'.' '.$row['URUSAN'];
           }
        } else {
            $data = '';
        }
               
        return $data;
    }

    function get_skpd_list_dropdown(){
        $this->db->select('a.ID, a.NAMA_SKPD,a.KODE_SKPD');
        $this->db->from('m_skpd AS a');
        $query = $this->db->get()->result_array();
        if($query){
          foreach ($query as $row) {
            $data[$row['ID']] = '['.$row['KODE_SKPD'].']'.' '.$row['NAMA_SKPD'];
          }
        } else {
            $data = '';  
        }
        return $data;
    }
    
    function get_tujuan_dropdown(){
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_renstra_tujuan AS a');
        $query = $this->db->get()->result_array();
        if($query){
         foreach ($query as $row) {
            $data[$row['ID']] = $row['TUJUAN'];
         }
        } else {
            $data = '';   
        }
               
        return $data;
    }

    function get_sasaran_rpjmd_dropdown(){
        $this->db->select('a.ID, a.SASARAN');
        $this->db->from('tx_rpjmd_sasaran AS a');
        $query = $this->db->get()->result_array();
        if($query){
          foreach ($query as $row) {
            $data[$row['ID']] = $row['SASARAN'];
          }
        } else {
            $data = '';  
        }
        return $data;
    }

    function get_tujuan_rpjmd_dropdown(){
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_rpjmd_tujuan AS a');
        $query = $this->db->get()->result_array();
        if($query){
          foreach ($query as $row) {
            $data[$row['ID']] = $row['TUJUAN'];
          }
        } else {
            $data = '';  
        }
        return $data;
    }

    function get_list_total($param,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_renstra_sasaran AS a');
        // $this->db->join('tx_renstra_tujuan AS b','a.TUJUAN_ID = b.ID', 'INNER');
        // $this->db->join('tx_renstra_tujuan_skpd as c','c.TUJUAN_ID = b.ID','LEFT');
        if($param) {
            $this->db->where($param);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_tujuan($where,$limit,$offset) {
        $this->db->select('a.ID, a.TUJUAN');
        $this->db->from('tx_renstra_tujuan AS a');
        $this->db->join('tx_renstra_tujuan_skpd as b','b.TUJUAN_ID = a.ID','LEFT');
        if($where) {
            $this->db->where($where);
        }
        $this->db->group_by('a.TUJUAN');
        $this->db->order_by('a.TUJUAN','ASC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    function get_list_sasaran($where,$like,$limit,$offset) {
        $this->db->select('a.ID, a.SASARAN,a.URUSAN_ID');
        $this->db->from('tx_renstra_sasaran AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    function get_list_data($tujuan,$like) {
        $this->db->select('
            a.TUJUAN_ID,
            b.TUJUAN,
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_renstra_sasaran AS a');
        $this->db->join('tx_renstra_tujuan AS b','a.TUJUAN_ID = b.ID', 'INNER');
        if($tujuan){
            $this->db->where('b.ID', $tujuan);
        }
        if($like){
            $this->db->like($like);
        }
        
        return $this->db->get()->result_array();
    }

    function get_list_indikator($urusan,$like){
        $this->db->select('a.ID,b.ID as param_del,a.SASARAN, c.ID_INDIKATOR, c.INDIKATOR, c.SATUAN, c.`2010`, c.`2011`, c.`2012`, c.`2013`, c.`2014`, c.`2015`, c.`2016`, c.`2017`, c.`2018`, c.`2019`, c.`2020`, c.`2021`,c.`target2010`,c.`target2011`,c.`target2012`,c.`target2013`,c.`target2014`,c.`target2015`,c.`target2016`,c.`target2017`,c.`target2018`,c.`target2019`,c.`target2020`,c.`target2021`');
        $this->db->from('tx_renstra_sasaran AS a');
        $this->db->join('tx_renstra_sasaran_indikator AS b','b.SASARAN_ID = a.ID');
        $this->db->join('v_data_dasar as c','b.INDIKATOR_ID = c.ID_INDIKATOR');
        if($urusan){
            $this->db->where('a.ID',$urusan);
        }
        if($like){
            $this->db->like($like);
        }
        return $this->db->get()->result_array();
    }

    function detail($id){
        $this->db->select('
            a.URUSAN_ID,
            e.URUSAN,
            a.SASARAN_RPJMD_ID,
            a.SKPD_ID,
            e.KODE_URUSAN,
            e.URUSAN,
            a.TUJUAN_ID,
            b.TUJUAN_RPJMD_ID,
            b.TUJUAN,
            b.MISI_RPJMD_ID,
            c.MISI,
            c.VISI_ID,
            d.VISI,
            a.ID,
            a.SASARAN
        ');
        $this->db->from('tx_renstra_sasaran AS a');
        $this->db->join('tx_renstra_tujuan AS b', 'a.TUJUAN_ID = b.ID', 'LEFT');
        $this->db->join('tx_rpjmd_misi AS c', 'b.MISI_RPJMD_ID = c.ID', 'LEFT');
        $this->db->join('tx_rpjmd_visi AS d', 'c.VISI_ID = d.ID', 'LEFT');
        $this->db->join('m_urusan AS e', 'a.URUSAN_ID = e.ID', 'LEFT');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_program_by_id($id){
        $this->db->select('
            a.ID,
            a.PROGRAM
        ');
        $this->db->from('tx_renstra_program AS a');
        $this->db->where('a.SASARAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function get_urusan_by_id($id){
        $this->db->select('a.URUSAN_ID,a.ID');
        $this->db->from('tx_renstra_sasaran AS a');
        $this->db->where('a.URUSAN_ID', $id);
        return $this->db->get()->row();
    }

    function tambah_sasaran($data) {
        $query = $this->db->insert('tx_renstra_sasaran', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_sasaran($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_renstra_sasaran', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_sasaran($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_renstra_sasaran");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function get_skpd_dropdown(){
        $this->db->select('a.ID, a.NAMA_SKPD');
        $this->db->from('m_skpd AS a');
        $this->db->join('tx_renstra_sasaran_skpd AS b','a.ID = b.SKPD_ID','LEFT');
        $this->db->join('tx_renstra_sasaran AS c','b.SASARAN_ID = c.ID','LEFT');
        $this->db->where('c.SASARAN IS NULL');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_skpd_by_id($id){
        $this->db->select('
            b.NAMA_SKPD
        ');
        $this->db->from('tx_renstra_sasaran_skpd AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID');
        $this->db->where('a.SASARAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function get_indikator_by_id_sasaran($id){
        $this->db->select('
            a.ID as param_del,
            a.INDIKATOR_ID,
            b.INDIKATOR,
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
        $this->db->from('tx_renstra_sasaran_indikator AS a');
        $this->db->join('v_data_dasar AS b', 'a.INDIKATOR_ID = b.ID_INDIKATOR', 'LEFT');
        $this->db->where('a.SASARAN_ID', $id);
        return $this->db->get()->result_array();
    }

    function ceklist_indikator($id,$like){
        $this->db->select('
            a.INDIKATOR,
            a.ID_INDIKATOR,
            a.URUSAN_ID
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_renstra_sasaran_indikator AS b', 'a.ID_INDIKATOR = b.INDIKATOR_ID', 'LEFT');
        $this->db->where('a.RENSTRA', '1');
        $this->db->where('(b.SASARAN_ID IS NULL AND b.INDIKATOR_ID IS NULL)');
        $this->db->where('a.URUSAN_ID', $id);
        if($like){
            $this->db->like($like);
        }
        $this->db->group_by('a.INDIKATOR');
        return $this->db->get()->result_array();
    }

    function insert_indikator_sasaran($sasaran, $indikator){
        $this->db->trans_start();
        $data = array();
        foreach($indikator AS $key => $val){
             $data[] = array(
              'SASARAN_ID'   => $sasaran,
              'INDIKATOR_ID'   => $indikator[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 

        $this->db->insert_batch('tx_renstra_sasaran_indikator', $data); 
        $query = $this->db->trans_complete();
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function insert_skpd_sasaran($sasaran, $skpd){
        $this->db->trans_start();
        $data = array();
        foreach($skpd AS $key => $val){
             $data[] = array(
              'SASARAN_ID'   => $sasaran,
              'SKPD_ID'   => $skpd[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 

        $this->db->insert_batch('tx_renstra_sasaran_skpd', $data); 
        $query = $this->db->trans_complete();
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function remove_indikator($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_renstra_sasaran_indikator");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }
}