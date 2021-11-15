<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_kewilayahan extends CI_Model{

   function filter_urusan(){
        $this->db->select('b.ID, b.KODE_URUSAN, b.URUSAN');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->join('m_urusan AS b', 'a.URUSAN_ID = b.ID', 'INNER');
        $this->db->group_by('a.URUSAN_ID');
        $query = $this->db->get();
        $data['all'] = 'Semua Urusan';
            if ($query->num_rows() > 0) {
               foreach ($query->result_array() as $row) {
                $data[$row['ID']] = $row['KODE_URUSAN'].' - '.$row['URUSAN'];
            }   
        }
        return $data;
    }

    function filter_sasaran($id){
        $this->db->select('a.ID, a.SASARAN');
        $this->db->from('tx_spm_sasaran AS a');
        if ($id !== 'all') {
            $this->db->where('a.URUSAN_ID', $id);
        }
        $query = $this->db->get();
        $data['all'] = 'Semua Sasaran';
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['ID']] = $row['SASARAN'];
            }
        }
        return $data;
    }

   function form_indikator()
   {
        $this->db->select('a.ID, a.INDIKATOR');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->like('a.KATEGORI','Kewilayahan');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $data[] = 'Pilih Indikator';
            foreach ($query->result_array() as $row) {
                $data[$row['ID']] = $row['INDIKATOR'];
            }
        }
        else 
        {
            $data[] = 'Tidak ada Indikator';
        }
        return $data;
    }

    function drop_kecamatan()
    {
        $this->db->select('a.NO_KEC, a.NAMA_KEC');
        $this->db->from('m_kecamatan AS a');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $data[] = 'Pilih Kecamatan';
            foreach ($query->result_array() as $row) {
                $data[$row['NO_KEC']] = $row['NAMA_KEC'];
            }
        }
        else 
        {
            $data[] = 'Tidak ada Kecamatan';
        }
        return $data;
    }

    function drop_kecamatan_edit()
    {
        $this->db->select('a.NO_KEC, a.NAMA_KEC');
        $this->db->from('m_kecamatan AS a');
        $query = $this->db->get();
        return $query->result_array();
    }

    function filter_desa($id = false)
    {
        $this->db->select('a.ID,a.NO_DESA, a.NAMA_DESA, a.KEC_KODE');
        $this->db->from('m_desa AS a');
        if ($id !== 'all') {
            $this->db->where('a.KEC_KODE', $id);
        }
        $query = $this->db->get()->result_array();
        // $data['all'] = 'Semua Desa';
        // foreach ($query as $row):
        //     $data[$row['ID']] = $row['NO_DESA'].' - '.$row['NAMA_DESA'];
        // endforeach;
        // return $data;
        return $query;
    }

    function filter_desa_detail($id = false)
    {
        $this->db->select('a.ID_INDIKATOR, a.URUSAN_ID, a.DESA, a.SKPD_ID, a.INDIKATOR, a.SATUAN, a.NAMA_KEC,a.CREATED, a.CREATED_BY, a.MODIFIED, a.MODIFIED_BY, a.KECAMATAN, a.`2010`, a.`2011`, a.`2012`, a.`2013`, a.`2014`, a.`2015`, a.`2016`, a.`2017`, a.`2018`, a.`2019`, a.`2020`, a.`2021`');
        $this->db->from('v_data_wilayah_desa AS a');
        $this->db->where('a.ID_INDIKATOR', $id);
        $this->db->order_by('a.DESA', 'DESC');
        $query = $this->db->get();
        // print_r($this->db->last_query());
        return $query->result_array();
    }

    function list_kecamatan()
    {
        $this->db->select('a.NO_KEC, a.NAMA_KEC');
        $this->db->from('m_kecamatan AS a');
        $query = $this->db->get();
        return $query->result_array();
    }

    function list_kecamatan_detail($id)
    {
        // $this->db->select('a.NO_KEC, a.NAMA_KEC,b.*');
        // $this->db->from('m_kecamatan AS a');
        // $this->db->join('tx_data_kewilayahan as b','a.NO_KEC = b.KECAMATAN');
        // $this->db->where('b.INDIKATOR_ID',$id);
        // $query = $this->db->get();
        // return $query->result_array();

        $this->db->select('a.ID_INDIKATOR, a.URUSAN_ID, a.SKPD_ID, a.INDIKATOR, a.SATUAN, a.NO_KEC, a.NAMA_KEC,a.CREATED, a.CREATED_BY, a.MODIFIED, a.MODIFIED_BY, a.KECAMATAN, a.`2010`, a.`2011`, a.`2012`, a.`2013`, a.`2014`, a.`2015`, a.`2016`, a.`2017`, a.`2018`, a.`2019`, a.`2020`, a.`2021`');
        $this->db->from('v_data_wilayah AS a');
        $this->db->where('a.ID_INDIKATOR', $id);
        $this->db->order_by('a.NO_KEC', 'DESC');
        $query = $this->db->get();
        // print_r($this->db->last_query());
        return $query->result_array();
    }

    function cek_indikator($id)
    {
        $this->db->select('a.*');
        $this->db->from('tx_data_kewilayahan as a');
        $this->db->where('a.INDIKATOR_ID',$id);
        return $this->db->get()->row_array();
    }

    function form_sasaran($id){
        $this->db->select('a.ID, a.SASARAN');
        $this->db->from('tx_spm_sasaran AS a');
        $this->db->where('a.URUSAN_ID', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 1) {
            foreach ($query->result_array() as $row) {
                $data[$row['ID']] = $row['SASARAN'];
            }
        }
        else {
            $data['all'] = 'Semua Sasaran';
        }
        return $data;
    }

    function get_list_total($where,$where_urusan,$like){
        $this->db->select('count(*) as count');
        $this->db->from('v_data_dasar AS a');
        $this->db->like('a.KATEGORI', 'Kewilayahan');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $query = $this->db->get();
        return $query;
    }

    function get_list_data($where,$where_urusan,$like,$limit,$offset) {
        $this->db->select('a.ID_INDIKATOR, a.INDIKATOR');
        $this->db->from('v_data_wilayah AS a');
        if($where) {
            $this->db->where($where);
        }
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like) {
            $this->db->like($like);
        }
        $this->db->group_by('a.ID_INDIKATOR');
        $this->db->order_by('a.ID_INDIKATOR','DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_list_indikator($id) {
        $this->db->select('a.ID_INDIKATOR, a.URUSAN_ID, a.SKPD_ID, a.NAMA_KEC, a.INDIKATOR, a.SATUAN, a.CREATED, a.CREATED_BY, a.MODIFIED, a.MODIFIED_BY, a.KECAMATAN, a.`2010`, a.`2011`, a.`2012`, a.`2013`, a.`2014`, a.`2015`, a.`2016`, a.`2017`, a.`2018`, a.`2019`, a.`2020`, a.`2021`');
        $this->db->from('v_data_wilayah AS a');
        $this->db->where('a.ID_INDIKATOR', $id);
        $this->db->order_by('a.NO_KEC', 'DESC');
        $query = $this->db->get();
        // print_r($this->db->last_query());
        return $query->result_array();
    }

    function ceklist_indikator(){
        $this->db->select('
            a.INDIKATOR,
            a.ID_INDIKATOR
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('tx_spm AS b', 'a.ID_INDIKATOR = b.INDIKATOR_ID', 'LEFT');
        $this->db->where('a.SPM', '1');
        $this->db->where('(b.ID IS NULL)');
        return $this->db->get()->result_array();
    }

    function detail_indikator($id)
    {
        $this->db->select('a.*');
        $this->db->from('tx_data_kewilayahan as a');
        $this->db->where('a.INDIKATOR_ID',$id);
        return $this->db->get()->row_array();
    }

    function insert_indikator($indikator,$tipe, $kecamatan,$desa, $tahun, $capaian)
    {
        $this->db->trans_begin();
        $data = array();
        foreach($desa AS $key => $val){
            $data[] = array(
                'INDIKATOR_ID'   => $indikator,
                'KECAMATAN'   => $kecamatan,
                'DESA'=> $desa[$key],
                'TIPE' =>$tipe,
                'TAHUN'   => $tahun[$key],
                'DATA'   => $capaian[$key],
                'CREATED'   => date('Y-m-d H:i:s'),
                'CREATED_BY'   => $this->ion_auth->user()->row()->id,
            );
        } 

        $this->db->insert_batch('tx_data_kewilayahan', $data); 
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

    function insert_indikator_kecamatan($indikator,$tipe, $kecamatan, $tahun, $capaian)
    {
        $this->db->trans_begin();
        $data = array();
        foreach($kecamatan AS $key => $val){
            $data[] = array(
                'INDIKATOR_ID'   => $indikator,
                'KECAMATAN'   => $kecamatan[$key],
                'TIPE' =>$tipe,
                'TAHUN'   => $tahun[$key],
                'DATA'   => $capaian[$key],
                'CREATED'   => date('Y-m-d H:i:s'),
                'CREATED_BY'   => $this->ion_auth->user()->row()->id,
            );
        } 

        $this->db->insert_batch('tx_data_kewilayahan', $data); 
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

    function update_indikator_kecamatan($indikator,$tipe, $kecamatan, $tahun, $capaian)
    {
        $this->db->trans_begin();
        $this->db->delete('tx_data_kewilayahan', array('INDIKATOR_ID' => $indikator));
        
        $data = array();
        foreach($kecamatan AS $key => $val){
            $data[] = array(
                'INDIKATOR_ID'   => $indikator,
                'KECAMATAN'   => $kecamatan[$key],
                'TIPE' =>$tipe,
                'TAHUN'   => $tahun[$key],
                'DATA'   => $capaian[$key],
                'CREATED'   => date('Y-m-d H:i:s'),
                'CREATED_BY'   => $this->ion_auth->user()->row()->id,
            );
        } 

        $this->db->insert_batch('tx_data_kewilayahan', $data); 
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

    function update_indikator_desa($indikator,$tipe, $kecamatan, $desa, $tahun, $capaian)
    {
        $this->db->trans_begin();
        $this->db->delete('tx_data_kewilayahan', array('INDIKATOR_ID' => $indikator,'KECAMATAN'=>$kecamatan,'TIPE'=>$tipe));
        
        $data = array();
        foreach($desa AS $key => $val){
            $data[] = array(
                'INDIKATOR_ID'   => $indikator,
                'KECAMATAN'   => $kecamatan,
                'DESA'=> $desa[$key],
                'TIPE' =>$tipe,
                'TAHUN'   => $tahun[$key],
                'DATA'   => $capaian[$key],
                'CREATED'   => date('Y-m-d H:i:s'),
                'CREATED_BY'   => $this->ion_auth->user()->row()->id,
            );
        } 

        $this->db->insert_batch('tx_data_kewilayahan', $data); 
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

    function update_indikator($id,$skpd_id,$urusan_id,$indikator,$satuan,$kategori,$tahun,$capaian,$rpjmd,$renstra,$sdgs,$spm,$modified,$modified_by) {
        $this->db->trans_begin();
        $data  = array(
            'SKPD_ID' => $skpd_id,
            'URUSAN_ID' => $urusan_id,
            'INDIKATOR' => $indikator,
            'SATUAN' => $satuan,
            'KATEGORI' => $kategori,
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
        foreach($capaian as $key => $val)
        { 
            if($val === '')
            { 
                unset($capaian[$key]);
            } 
            else
            {
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

        if ($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function delete_indikator($id){
        $this->db->trans_begin();
        $this->db->delete('tx_data_kewilayahan', array('INDIKATOR_ID' => $id));
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

