<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_dasar extends CI_Model{

    function filter_skpd($id = false)
    {
        $this->db->select('c.ID AS ID_SKPD, c.NAMA_SKPD');
        $this->db->from('users AS a');
        $this->db->join('users_detail AS b', 'b.id_user = a.id', 'INNER');
        $this->db->join('m_skpd AS c', 'b.kd_skpd = c.KODE_SKPD', 'INNER');
        if ($id != false) 
        {
            $this->db->where('a.id', $id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row):
                $data[$row['ID_SKPD']] = $row['NAMA_SKPD'];
            endforeach;
        } else {
            $query = $this->db->get();
            $data['all'] = 'Semua Satuan Kerja';
            foreach ($query->result_array() as $row):
                $data[$row['ID_SKPD']] = $row['NAMA_SKPD'];
            endforeach;
        }
        return $data;
    }

    function filter_urusan($id = false)
    {
        $this->db->select('b.ID, b.URUSAN, b.KODE_URUSAN');
        $this->db->from('tx_urusan_ref AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        if ($id !== 'all') {
            $this->db->where('a.SKPD_ID', $id);
        }
        $query = $this->db->get()->result_array();
        $data['all'] = 'Semua Urusan';
        foreach ($query as $row):
            $data[$row['ID']] = $row['KODE_URUSAN'].' - '.$row['URUSAN'];
        endforeach;
        return $data;
    }

    function filter_kategori()
    {
        $this->db->select('a.ID, a.KATEGORI');
        $this->db->from('m_kategori AS a');
        $query = $this->db->get();
        $data['all'] = 'Semua Kategori';
        foreach ($query->result_array() as $row):
            $data[$row['KATEGORI']] = $row['KATEGORI'];
        endforeach;
        return $data;
    }

    function get_list_total($where,$where_skpd,$where_urusan,$where_kategori,$where_pelaporan,$like)
    {
        $this->db->select('count(*) as count');
        $this->db->from('v_data_dasar AS a');

        if($where)
        {
            $this->db->where($where);
        }
        if($where_skpd)
        {
            $this->db->where($where_skpd);
        }
        if($where_urusan)
        {
            $this->db->where($where_urusan);
        }
        if($where_kategori)
        {
            $this->db->like($where_kategori);
        }
        if($where_pelaporan)
        {
            $this->db->where($where_pelaporan);
        }
        if($like)
        {
            $this->db->like($like);
        }
        $query =  $this->db->get();
        return $query->row('count');
    }

    function get_list_data($where,$where_skpd,$where_urusan,$where_kategori,$where_pelaporan,$like,$limit,$offset)
    {
        $this->db->select('a.ID_INDIKATOR, a.URUSAN_ID, a.SKPD_ID, a.INDIKATOR, a.SATUAN, a.KATEGORI, a.RPJMD, a.SPM, a.SDGS, a.RENSTRA, a.KLHS, a.CREATED, a.CREATED_BY, a.MODIFIED, a.MODIFIED_BY, a.`2010`, a.`2011`, a.`2012`, a.`2013`, a.`2014`, a.`2015`, a.`2016`, a.`2017`, a.`2018`, a.`2019`, a.`2020`, a.`2021`,a.SATUAN');
        $this->db->from('v_data_dasar AS a');
       if($where)
        {
            $this->db->where($where);
        }
        if($where_skpd)
        {
            $this->db->where($where_skpd);
        }
        if($where_urusan)
        {
            $this->db->where($where_urusan);
        }
        if($where_kategori)
        {
            $this->db->like($where_kategori);
        }
        if($where_pelaporan)
        {
            $this->db->where($where_pelaporan);
        }
        if($like)
        {
            $this->db->like($like);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.ID_INDIKATOR','DESC');
        $query =  $this->db->get();
        return $query->result_array();
    }

    // function tambah_value($data) {
    //     $query = $this->db->insert('t_dt_dasar_value', $data);
    //     if ($query)
    //     {
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // }

}