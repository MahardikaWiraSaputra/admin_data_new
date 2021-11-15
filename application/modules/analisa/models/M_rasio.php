<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rasio extends CI_Model{
   
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

    function list_indikator($id)
    {
        $this->db->select('a.JUDUL,c.INDIKATOR,b.INDIKATOR_ID,b.TIPE');
        $this->db->from('rasio_master AS a');
        $this->db->join('rasio_indikator_fix AS b','b.ID_MASTER = a.ID');
        $this->db->join('tx_indikator_ref AS c','b.INDIKATOR_ID = c.ID');
        $this->db->where('a.ID',$id);
        return $this->db->get()->result_array();
    }

    function get_list_indikator()
    {
        $this->db->select('a.*');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->order_by('a.INDIKATOR', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_list_data($where,$like,$limit,$offset) {
        $this->db->select('
            a.*
        ');
        $this->db->from('rasio_master AS a');
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


    function tambah_indikator($data) {

        $query = $this->db->insert('rasio_master', array('JUDUL'=>$data['JUDUL'],'PER'=>$data['PER']));
        $insert_id = $this->db->insert_id();

        $data_indikator_y = array('ID_MASTER'=>$insert_id,'INDIKATOR_ID'=>$data['INDIKATOR_Y'],'TIPE'=>'Y');
        $data_indikator_x = array('ID_MASTER'=>$insert_id,'INDIKATOR_ID'=>$data['INDIKATOR_X'],'TIPE'=>'X');

        $query_y = $this->db->insert('rasio_indikator_fix',$data_indikator_y);
        $query_x = $this->db->insert('rasio_indikator_fix',$data_indikator_x);

        if ($query && $query_x) {
            return true;
        }
        else {
            return false;
        }
    }

    function detail_rasio($id){
        $this->db->select("b.ID,
        b.JUDUL,
        b.Per,
        MAX( CASE WHEN `a`.`TIPE` = 'Y' THEN `a`.`INDIKATOR_ID` END ) AS `INDIKATOR_Y`,
        MAX( CASE WHEN `a`.`TIPE` = 'X' THEN `a`.`INDIKATOR_ID` END ) AS `INDIKATOR_X`
        ");
        $this->db->from('rasio_indikator_fix AS a');
        $this->db->join('rasio_master AS b','a.ID_MASTER = b.ID');
        $this->db->where('b.ID', $id);
        return $this->db->get()->row_array();
    }

    function update_rasio($data) {

        if($data['JUDUL']){
            $this->db->where('ID', $data['ID']);
            $data_update = $this->db->update('rasio_master', array('JUDUL' => $data['JUDUL'],'Per'=>$data['PER']));
        }

        if($data['INDIKATOR_Y']){
            $this->db->where('ID_MASTER', $data['ID']);
            $this->db->where('TIPE','Y');
            $data_update = $this->db->update('rasio_indikator_fix', array('INDIKATOR_ID' => $data['INDIKATOR_Y']));
        }

        if($data['INDIKATOR_X']) {
            $this->db->where('ID_MASTER', $data['ID']);
            $this->db->where('TIPE','X');
            $data_update = $this->db->update('rasio_indikator_fix', array('INDIKATOR_ID' => $data['INDIKATOR_X']));
        }

        if ($data_update) {
            return true;
        }
        else {
            return false;
        }

    }

    function delete_rasio($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("rasio_master");

        if ($query) {
            $this->db->where("ID_MASTER", $id);
            $query = $this->db->delete("rasio_indikator_fix");
            return true;
        }
        else {
            return false;
        }
    } 
}