<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_overlay extends CI_Model{
   
    function get_list_total($where,$like){
        $this->db->select('count(*) as count');
        $this->db->from('m_kategori AS a');

        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_indikator()
    {
        $this->db->select('a.*');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->where('a.KATEGORI','Kewilayahan');
        $this->db->order_by('a.INDIKATOR', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('
            a.*
        ');
        $this->db->from('overlay_indikator_master AS a');
        if($where) {
            $this->db->where($where);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    function list_indikator($id){
        $this->db->select('a.INDIKATOR_ID,b.JUDUL,c.INDIKATOR,a.TIPE');
        $this->db->from('overlay_indikator_copy1 as a');
        $this->db->join('overlay_indikator_master AS b','b.ID = a.ID_MASTER');
        $this->db->join('tx_indikator_ref AS c','a.INDIKATOR_ID = c.ID');
        $this->db->where('a.ID_MASTER',$id);
        return $this->db->get()->result_array();
    }

    function tambah_indikator($data) {

        $query = $this->db->insert('overlay_indikator_master', array('JUDUL'=>$data['JUDUL']));
        $insert_id = $this->db->insert_id();
        $data_indikator_y = array('ID_MASTER'=>$insert_id,'INDIKATOR_ID'=>$data['INDIKATOR_MASTER'],'TIPE'=>'Y');
        $data_indikator_x = array('ID_MASTER'=>$insert_id,'INDIKATOR_ID'=>$data['INDIKATOR_X'],'TIPE'=>'X');
        $data_indikator_tambahan = array('ID_MASTER'=>$insert_id,'INDIKATOR_ID'=>$data['INDIKATOR_TAMBAHAN'],'TIPE'=>'TAMBAHAN');

        $query_y = $this->db->insert('overlay_indikator_copy1',$data_indikator_y);
        $query_x = $this->db->insert('overlay_indikator_copy1',$data_indikator_x);
        $query_t = $this->db->insert('overlay_indikator_copy1',$data_indikator_tambahan);

        if ($query && $query_x && $query_t) {
            return true;
        }
        else {
            return false;
        }
    }

    function detail_overlay($id){
        $this->db->select("b.ID,
        b.JUDUL,
        MAX( CASE WHEN `a`.`TIPE` = 'Y' THEN `a`.`INDIKATOR_ID` END ) AS `INDIKATOR_Y`,
        MAX( CASE WHEN `a`.`TIPE` = 'X' THEN `a`.`INDIKATOR_ID` END ) AS `INDIKATOR_X`,
        MAX( CASE WHEN `a`.`TIPE` = 'TAMBAHAN' THEN `a`.`INDIKATOR_ID` END ) AS `INDIKATOR_TAMBAHAN`");
        $this->db->from('overlay_indikator_copy1 AS a');
        $this->db->join('overlay_indikator_master AS b','a.ID_MASTER = b.ID');
        $this->db->where('b.ID', $id);
        return $this->db->get()->row_array();
    }

    function update_overlay($data) {

        if($data['JUDUL']){
            $this->db->where('ID', $data['ID']);
            $data_update = $this->db->update('overlay_indikator_master', array('JUDUL' => $data['JUDUL']));
        }

        if($data['INDIKATOR_MASTER']){
            $this->db->where('ID_MASTER', $data['ID']);
            $this->db->where('TIPE','Y');
            $data_update = $this->db->update('overlay_indikator_copy1', array('INDIKATOR_ID' => $data['INDIKATOR_MASTER']));
        }

        if($data['INDIKATOR_X']) {
            $this->db->where('ID_MASTER', $data['ID']);
            $this->db->where('TIPE','X');
            $data_update = $this->db->update('overlay_indikator_copy1', array('INDIKATOR_ID' => $data['INDIKATOR_X']));
        }

        if($data['INDIKATOR_TAMBAHAN']){
            $this->db->where('ID_MASTER', $data['ID']);
            $this->db->where('TIPE','TAMBAHAN');
            $data_update = $this->db->update('overlay_indikator_copy1', array('INDIKATOR_ID' => $data['INDIKATOR_TAMBAHAN']));
        }
        
        if ($data_update) {
            return true;
        }
        else {
            return false;
        }
        
    }

    function delete_overlay($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("overlay_indikator_master");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 
}