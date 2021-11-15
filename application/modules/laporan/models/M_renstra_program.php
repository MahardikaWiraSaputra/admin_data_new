<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_renstra_program extends CI_Model{

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
        foreach ($query as $row) {
            $data[$row['ID']] = '['.$row['KODE_URUSAN'].']'.' '.$row['URUSAN'];
        }       
        return $data;
    }
    
    function get_sasaran_dropdown(){
        $this->db->select('a.ID, a.SASARAN');
        $this->db->from('tx_renstra_sasaran AS a');
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

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_renstra_program AS a');
        $this->db->join('m_urusan AS b', 'a.URUSAN_ID = b.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS c', 'c.URUSAN_ID = b.ID', 'INNER');
        $this->db->join('m_skpd AS d', 'c.SKPD_ID = d.ID', 'INNER');
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

    function get_list_data($param,$where_urusan,$like,$limit,$offset) {
        $this->db->select('a.PROGRAM,a.ID,a.URUSAN_ID,a.KODE_BIDANG,a.KODE_PROGRAM');
        $this->db->from('tx_renstra_program AS a');
        $this->db->join('m_urusan AS b', 'a.URUSAN_ID = b.ID', 'INNER');
        $this->db->join('tx_urusan_ref AS c', 'c.URUSAN_ID = b.ID', 'INNER');
        $this->db->join('m_skpd AS d', 'c.SKPD_ID = d.ID', 'INNER');
        if($param) {
            $this->db->where($param);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'DESC');
        $this->db->group_by('a.ID');
        return $this->db->get()->result_array();
    }

    function get_list_indikator($param,$like) {
        $this->db->select('a.PROGRAM,b.ID as param_del,c.KODE_INDIKATOR,c.ID_INDIKATOR, c.INDIKATOR, c.SATUAN, c.`2010`, c.`2011`, c.`2012`, c.`2013`, c.`2014`, c.`2015`, c.`2016`, c.`2017`, c.`2018`, c.`2019`, c.`2020`, c.`2021`,c.`target2010`,c.`target2011`,c.`target2012`,c.`target2013`,c.`target2014`,c.`target2015`,c.`target2016`,c.`target2017`,c.`target2018`,c.`target2019`,c.`target2020`,c.`target2021`');
        $this->db->from('tx_renstra_program AS a');
        $this->db->join('tx_renstra_x AS b', 'b.PROGRAM_ID = a.ID', 'INNER');
        $this->db->join('v_data_dasar as c', 'b.INDIKATOR_ID = c.ID_INDIKATOR', 'INNER');
        if($param) {
            $this->db->where('a.ID',$param);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    function get_list_kegiatan($id){
        $this->db->select('*');
        $this->db->from('tx_renstra_kegiatan as a');
        $this->db->where('a.PROGRAM_ID',$id);
        return $this->db->get()->result_array();
    }

    function get_list_kegiatan_indikator($id){
        $this->db->select('b.ID_INDIKATOR,b.URUSAN_ID,b.SKPD_ID,b.KODE_INDIKATOR,b.INDIKATOR,b.SATUAN,b.KATEGORI,b.RPJMD,b.SPM,b.SDGS,b.RENSTRA,b.KLHS,b.LKJIP,b.LKPJ,b.LPPD,b.TIDAK_TERISI,b.CREATED,b.CREATED_BY,b.MODIFIED,b.MODIFIED_BY,b.target2010,b.target2011,b.target2012,b.target2014,b.target2015,b.target2016,b.target2017,b.target2018,b.target2019,b.target2020,b.target2021,b.`2010`,b.`2011`,b.`2012`,b.`2013`,b.`2014`,b.`2015`,b.`2016`,b.`2017`,b.`2018`,b.`2019`,b.`2020`,b.`2021`');
        $this->db->from('tx_renstra_kegiatan_indikator AS a');
        $this->db->join('v_data_dasar AS b','a.DATA_ID = b.ID_INDIKATOR');
        $this->db->where('a.KEGIATAN_ID',$id);
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
            c.MISI_RPJMD_ID,
            d.MISI,
            d.VISI_ID,
            e.VISI,
            a.URUSAN_ID,
            f.URUSAN,
            g.SKPD_ID
        ');
        $this->db->from('tx_renstra_program AS a');
        $this->db->join('tx_renstra_sasaran AS b', 'a.SASARAN_ID = b.ID', 'LEFT');
        $this->db->join('tx_renstra_tujuan AS c', 'b.TUJUAN_ID = c.ID', 'LEFT');
        $this->db->join('tx_rpjmd_misi AS d', 'c.MISI_RPJMD_ID = d.ID', 'LEFT');
        $this->db->join('tx_rpjmd_visi AS e', 'd.VISI_ID = e.ID', 'LEFT');
        $this->db->join('m_urusan AS f', 'a.URUSAN_ID = f.ID', 'LEFT');
        $this->db->join('tx_urusan_ref as g','g.URUSAN_ID = f.ID','LEFT');
        $this->db->join('m_skpd as h','g.SKPD_ID = h.id','LEFT');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function get_indikator_by_id($id){
        $this->db->select('
            a.ID as param_del,
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
        $this->db->from('tx_renstra_x AS a');
        $this->db->join('v_data_dasar AS b', 'a.DATA_ID = b.ID_INDIKATOR', 'INNER');
        $this->db->join('tx_renstra_program AS c', 'a.PROGRAM_ID = c.ID', 'INNER');
        $this->db->where('a.PROGRAM_ID', $id);
        return $this->db->get()->result_array();
    }

    function tambah_program($data) {
        $query = $this->db->insert('tx_renstra_program', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_program($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_renstra_program', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_program($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_renstra_program");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function ceklist_indikator($id,$like){
        $this->db->select('
            a.INDIKATOR,
            a.ID_INDIKATOR,
            a.URUSAN_ID
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_renstra_x AS b', 'a.ID_INDIKATOR = b.DATA_ID', 'LEFT');
        $this->db->where('(b.PROGRAM_ID IS NULL AND b.INDIKATOR_ID IS NULL)');
        $this->db->where('a.RENSTRA', '1');
        $this->db->where('a.URUSAN_ID', $id);
        if($like){
            $this->db->like($like);
        }
        $this->db->group_by('a.INDIKATOR');
        return $this->db->get()->result_array();
    }

    function get_urusan_by_id($id){
        $this->db->select('a.URUSAN_ID');
        $this->db->from('tx_renstra_program AS a');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row();
    }

    function insert_indikator($program, $indikators){
        $this->db->trans_start();
        $data = array();
        foreach($indikators AS $key => $val){
             $data[] = array(
              'PROGRAM_ID'   => $program,
              'INDIKATOR_ID'   => $indikators[$key],
              'DATA_ID'   => $indikators[$key],
              'CREATED'   => date('Y-m-d H:i:s'),
              'CREATED_BY'   => $this->ion_auth->user()->row()->id,
             );
        } 

        $this->db->insert_batch('tx_renstra_x', $data); 
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
        $query = $this->db->delete("tx_renstra_x");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

}