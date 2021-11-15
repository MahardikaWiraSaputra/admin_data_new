<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_dasar_indikator extends CI_Model{

    function filter_skpd($id = false)
    {
        $this->db->select('c.ID AS ID_SKPD, c.NAMA_SKPD');
        $this->db->from('users AS a');
        $this->db->join('users_detail AS b', 'b.id_user = a.id', 'INNER');
        $this->db->join('m_skpd AS c', 'b.kd_skpd = c.KODE_SKPD', 'INNER');
        if ($id) 
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
   
    function filter_urusan($id)
    {
        $this->db->select('b.ID, b.URUSAN');
        $this->db->from('tx_urusan_ref AS a');
        $this->db->join('m_urusan AS b','a.URUSAN_ID = b.ID','INNER');
        if ($id !== 'all') {
            $this->db->where('a.SKPD_ID', $id);
            $query = $this->db->get()->result_array();
            foreach ($query as $row):
                $data[$row['ID']] = $row['URUSAN'];
            endforeach;
        } else {
            $query = $this->db->get()->result_array();
            $data['all'] = 'Semua Urusan';
            foreach ($query as $row):
                $data[$row['ID']] = $row['URUSAN'];
            endforeach;
        }
        return $data;
    }

    function filter_kategori()
    {
        $this->db->select('a.ID, a.KATEGORI');
        $this->db->from('m_kategori AS a');
        $query = $this->db->get();
        $data['all'] = 'Semua Kategori';
        $data['-'] = 'Belum Dikategorikan';
        foreach ($query->result_array() as $row):
            $data[$row['KATEGORI']] = $row['KATEGORI'];
        endforeach;
        return $data;
    }

    
    // function filter_kategori()
    // {
    //     $this->db->select('a.ID, a.KATEGORI');
    //     $this->db->from('m_kategori AS a');
    //     $query = $this->db->get();
    //     if ($query->num_rows() > 1) {
    //         foreach ($query->result_array() as $row) {
    //             $data[$row['KATEGORI']] = $row['KATEGORI'];
    //         }       
    //         return $data;
    //     }
    //     else {
    //         return false;
    //     }
    // }

    function get_list_total($where,$where_skpd,$where_urusan,$where_kategori,$where_pelaporan,$like)
    {
        $this->db->select('count(*) as count');
        $this->db->from('tx_indikator_ref AS a');
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
        $query = $this->db->get();
        return $query->row('count');
    }

    function get_list_data($where,$where_skpd,$where_urusan,$where_kategori,$where_pelaporan,$like,$limit,$offset) 
    {
        $this->db->select('a.ID, a.URUSAN_ID, a.SKPD_ID, a.INDIKATOR, a.SATUAN, a.KATEGORI, a.RPJMD, a.SPM, a.SDGS, a.RENSTRA, a.KLHS, a.LKJIP, a.LKPJ, a.LPPD, a.TIDAK_TERISI, a.CREATED, a.CREATED_BY, a.MODIFIED, a.MODIFIED_BY, b.NAMA_SKPD, d.`2010`, d.`2011`, d.`2012`, d.`2013`, d.`2014`, d.`2015`, d.`2016`, d.`2017`, d.`2018`, d.`2019`, d.`2020`, d.`2021`,d.`target2010`, d.`target2011`, d.`target2012`, d.`target2013`, d.`target2014`, d.`target2015`, d.`target2016`, d.`target2017`, d.`target2018`, d.`target2019`, d.`target2020`, d.`target2021`');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID','LEFT');
        $this->db->join('v_data_dasar AS d','a.ID = d.ID_INDIKATOR','INNER');
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
        $this->db->order_by('a.ID', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_data($where_skpd, $where_urusan, $where_kategori, $where_pelaporan)
    {
        $this->db->select('a.ID_INDIKATOR,a.URUSAN_ID,a.SKPD_ID,a.KODE_INDIKATOR,a.INDIKATOR,a.SATUAN,a.KATEGORI,
            a.RPJMD,a.SPM,a.SDGS,a.RENSTRA,a.KLHS,a.LKJIP,a.LKPJ,a.LPPD,a.TIDAK_TERISI,a.`2010`,a.`2011`,a.`2012`,a.`2013`,a.`2014`,a.`2015`,a.`2016`,a.`2017`,a.`2018`,a.`2019`,a.`2020`,a.`2021`,b.NAMA_SKPD,c.URUSAN');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID','LEFT');
        $this->db->join('m_urusan AS c','a.URUSAN_ID = c.ID','INNER');

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

        $this->db->order_by('a.KODE_INDIKATOR', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_skpd($id)
    {
        $this->db->select('NAMA_SKPD');
        $this->db->from('m_skpd as a');
        $this->db->where('ID',$id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function tambah_indikator($skpd_id,$urusan_id,$indikator,$satuan,$kategori,$tahun,$capaian,$target,$is_capaian,$is_target,$rpjmd,$renstra,$sdgs,$spm,$tidak_terisi,$lkjip,$lkpj,$lppd,$created,$created_by)
    {
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
            'TIDAK_TERISI'=>$tidak_terisi,
            'LKJIP'=>$lkjip,
            'LKPJ'=>$lkpj,
            'LPPD'=>$lppd,
            'CREATED' => $created,
            'CREATED_BY' => $created_by    
        );
        $this->db->insert('tx_indikator_ref', $data);
        
        $indikator_id = $this->db->insert_id();
        if($is_capaian == 'ya'){
            $result_capaian = array();
            foreach($capaian as $key => $val)
            { 
                if($val === '')
                {
                    unset($capaian[$key]);
                } 
                else
                {
                    $result_capaian[] = array(
                        'INDIKATOR_ID'   => $indikator_id,
                        'TAHUN'   => $tahun[$key],
                        'DATA'   => $capaian[$key],
                        'KATEGORI'=>'capaian',
                        'CREATED' => $created,
                        'CREATED_BY' => $created_by    
                    );
                }
            }
            $this->db->insert_batch('tx_data_dasar', $result_capaian);
        }
    
        if($is_target == 'ya') {
            $result_target = array();
            foreach($target as $key => $val)
            { 
                if($val === '')
                {
                    unset($target[$key]);
                } 
                else
                {
                    $result_target[] = array(
                        'INDIKATOR_ID'   => $indikator_id,
                        'TAHUN'   => $tahun[$key],
                        'DATA'   => $target[$key],
                        'KATEGORI'=>'target',
                        'CREATED' => $created,
                        'CREATED_BY' => $created_by    
                    );
                }
            } 
            $this->db->insert_batch('tx_data_dasar', $result_target);
        }
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

    function detail_indikator($id)
    {
        $this->db->select('a.ID, a.URUSAN_ID, a.SKPD_ID, a.INDIKATOR, a.SATUAN, a.KATEGORI, a.RPJMD, a.SPM, a.SDGS, a.RENSTRA, a.KLHS, a.LKJIP, a.LKPJ, a.LPPD, a.TIDAK_TERISI, a.CREATED, a.CREATED_BY, a.MODIFIED, a.MODIFIED_BY, b.NAMA_SKPD, c.URUSAN, d.`2010`, d.`2011`, d.`2012`, d.`2013`, d.`2014`, d.`2015`, d.`2016`, d.`2017`, d.`2018`, d.`2019`, d.`2020`, d.`2021`,d.`target2010`, d.`target2011`, d.`target2012`, d.`target2013`, d.`target2014`, d.`target2015`, d.`target2016`, d.`target2017`, d.`target2018`, d.`target2019`, d.`target2020`, d.`target2021`');
        $this->db->from('tx_indikator_ref AS a');
        $this->db->join('m_skpd AS b','a.SKPD_ID = b.ID','LEFT');
        $this->db->join('m_urusan AS c','a.URUSAN_ID = c.ID','LEFT');
        $this->db->join('v_data_dasar AS d','a.ID = d.ID_INDIKATOR','INNER');
        $this->db->where('a.ID', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update_kodefikasi($data)
    {
        $this->db->where('ID', $data['ID']);
        $query = $this->db->update('tx_indikator_ref', $data);
        if ($query)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    function update_indikator($id,$skpd_id,$urusan_id,$indikator,$satuan,$kategori,$tahun,$capaian,$target,$tahun_target,$is_capaian,$is_target,$rpjmd,$renstra,$sdgs,$spm,$tidak_terisi,$lkjip,$lkpj,$lppd,$modified,$modified_by) {
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
            'TIDAK_TERISI' => $tidak_terisi,
            'LKJIP'=>$lkjip,
            'LKPJ'=>$lkpj,
            'LPPD'=>$lppd,
            'MODIFIED' => $modified,
            'MODIFIED_BY' => $modified_by    
        );
        $this->db->where('ID',$id);
        $this->db->update('tx_indikator_ref',$data);

        $this->db->delete('tx_data_dasar', array('INDIKATOR_ID' => $id));

        if($is_capaian == 'ya'){
            $result = array();
            foreach($capaian as $key => $val){ 
                if($val === ''){ 
                    unset($capaian[$key]);
                } else {
                    $result[] = array(
                        'INDIKATOR_ID'   => $id,
                        'TAHUN'   => $tahun[$key],
                        'DATA'   => $capaian[$key],
                        'KATEGORI'=> 'capaian',
                        'CREATED' => $modified,
                        'CREATED_BY' => $modified_by    
                    );
                }
            } 
                if(!empty($capaian)){
                    $this->db->insert_batch('tx_data_dasar', $result);
                }
        }

        if($is_target == 'ya') {
                $result_target = array();
                foreach($target as $key => $val){ 
                    if($val === ''){ 
                        unset($target[$key]);
                    } else {
                        $result_target[] = array(
                            'INDIKATOR_ID'   => $id,
                            'TAHUN'   => $tahun_target[$key],
                            'DATA'   => $target[$key],
                            'KATEGORI'=> 'target',
                            'CREATED' => $modified,
                            'CREATED_BY' => $modified_by    
                        );
                    }
                }
                if(!empty($target)){
                    $this->db->insert_batch('tx_data_dasar', $result_target);
                }
            
        } 
        
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

    function delete_indikator($id)
    {  
        $this->db->where("ID", $id);
        $query = $this->db->delete("tx_indikator_ref");
        if ($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    } 
}