<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_dasar_indikator extends CI_Model{
   
    function dropdown_urusan($id){
        $this->db->select('b.ID, b.URUSAN');
        $this->db->from('tx_urusan_ref AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        if ($id !== 'all') {
            $this->db->where('a.SKPD_ID', $id);
        }
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Urusan';
        foreach ($query as $row) {
            $data[$row['ID']] = $row['URUSAN'];
        }       
        return $data;
    }

    function get_list_total($where,$where_skpd,$where_urusan,$where_tipe,$like){
        $this->db->select('count(*) as count');
        $this->db->from('tx_indikator_ref AS a');

        if($where) {
            $this->db->where($where);
        }
        if($where_skpd) {
            $this->db->where($where_skpd);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($where_tipe) {
            $this->db->where($where_tipe);
        }
        if($like) {
            $this->db->like($like);
        }
        return $this->db->get();
    }

    function get_list_data($where,$where_skpd,$where_urusan,$where_tipe,$like,$limit,$offset) {
        $this->db->select('a.ID,
            a.URUSAN_ID,
            a.SKPD_ID,
            a.INDIKATOR,
            a.SATUAN,
            a.TIPE_DATA,
            a.RPJMD,
            a.SPM,
            a.SDGS,
            a.RENSTRA,
            a.KLHS,
            a.CREATED,
            a.CREATED_BY,
            a.MODIFIED,
            a.MODIFIED_BY,
            b.NAMA_SKPD
        ');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID','LEFT');
        if($where) {
            $this->db->where($where);
        }
        if($where_skpd) {
            $this->db->where($where_skpd);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($where_tipe) {
            $this->db->where($where_tipe);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID', 'DESC');
        return $this->db->get()->result_array();
    }

    // function tambah_indikator($data) {
    //     $query = $this->db->insert('tx_indikator_ref', $data);
    //     if ($query) {
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // }

    function tambah_indikator($skpd_id,$urusan_id,$indikator,$satuan,$tipe_data,$tahun,$capaian,$rpjmd,$renstra,$sdgs,$spm,$created,$created_by) {
        $this->db->trans_start();
        $data  = array(
            'SKPD_ID' => $skpd_id,
            'URUSAN_ID' => $urusan_id,
            'INDIKATOR' => $indikator,
            'SATUAN' => $satuan,
            'TIPE_DATA' => $tipe_data,
            'RPJMD' => $rpjmd,
            'RENSTRA' => $renstra,
            'SDGS' => $sdgs,
            'SPM' => $spm,
            'CREATED' => $created,
            'CREATED_BY' => $created_by    
        );
        $this->db->insert('tx_indikator_ref', $data);
        
        $indikator_id = $this->db->insert_id();
        $result = array();
        foreach($capaian as $key => $val) { 
            if($val === '') { 
                unset($capaian[$key]);
            } 
            else {
                $result[] = array(
                    'INDIKATOR_ID'   => $indikator_id,
                    'TAHUN'   => $tahun[$key],
                    'DATA'   => $capaian[$key],
                    'CREATED' => $created,
                    'CREATED_BY' => $created_by    
                );
            }
        } 
        $this->db->insert_batch('tx_data_dasar', $result);
        $query = $this->db->trans_complete();

        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function detail_indikator($id){
        $this->db->select('a.ID,
            a.URUSAN_ID,
            a.SKPD_ID,
            a.INDIKATOR,
            a.SATUAN,
            a.TIPE_DATA,
            a.RPJMD,
            a.SPM,
            a.SDGS,
            a.RENSTRA,
            a.KLHS,
            a.CREATED,
            a.CREATED_BY,
            a.MODIFIED,
            a.MODIFIED_BY,
            b.NAMA_SKPD,
            c.URUSAN,
            d.`2010`,
            d.`2011`,
            d.`2012`,
            d.`2013`,
            d.`2014`,
            d.`2015`,
            d.`2016`,
            d.`2017`,
            d.`2018`,
            d.`2019`,
            d.`2020`,
            d.`2021`
        ');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID','LEFT');
        $this->db->join('m_urusan AS c','a.URUSAN_ID = c.ID','LEFT');
        $this->db->join('v_data_dasar AS d','a.ID = d.ID_INDIKATOR','INNER');
        $this->db->where('a.ID', $id);
        return $this->db->get()->row_array();
    }

    function update_kodefikasi($data) {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_indikator_ref', $data);
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function update_indikator($id,$skpd_id,$urusan_id,$indikator,$satuan,$tipe_data,$tahun,$capaian,$rpjmd,$renstra,$sdgs,$spm,$modified,$modified_by) {
        $this->db->trans_start();
        $data  = array(
            'SKPD_ID' => $skpd_id,
            'URUSAN_ID' => $urusan_id,
            'INDIKATOR' => $indikator,
            'SATUAN' => $satuan,
            'TIPE_DATA' => $tipe_data,
            'RPJMD' => $rpjmd,
            'RENSTRA' => $renstra,
            'SDGS' => $sdgs,
            'SPM' => $spm,
            'MODIFIED' => $modified,
            'MODIFIED_BY' => $modified_by    
        );
        $this->db->where('ID',$id);
        $this->db->update('tx_indikator_ref',$data);

        $this->db->delete('tx_data_dasar', array('INDIKATOR_ID' => $id));

        $result = array();
        foreach($capaian as $key => $val) { 
            if($val === '') { 
                unset($capaian[$key]);
            } 
            else {
                $result[] = array(
                    'INDIKATOR_ID'   => $id,
                    'TAHUN'   => $tahun[$key],
                    'DATA'   => $capaian[$key],
                    'CREATED' => $modified,
                    'CREATED_BY' => $modified_by    
                );
            }
        } 
        $this->db->insert_batch('tx_data_dasar', $result);
        $query = $this->db->trans_complete();

        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    function delete_indikator($id){  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_indikator_ref");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    } 
}