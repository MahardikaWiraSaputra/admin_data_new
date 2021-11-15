<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_analisa_overlay extends CI_Model{

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
    

    function get_list_totalx($where_urusan,$like){
        $this->db->select('COUNT(b.ID) as count');
        $this->db->from('v_data_wilayah as a');
        $this->db->join('m_urusan as b','a.URUSAN_ID = b.ID');
        $this->db->group_by('INDIKATOR');
        if($where_urusan) {
            $this->db->where($where_urusan);
        }
        if($like){
            $this->db->like($like);
        }
        return $this->db->get();
    }


    function get_list_urusan($where,$like,$limit,$offset) {
        $this->db->select('
            a.*
        ');
        $this->db->from('overlay_indikator AS a');
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

    function list_indikatorx($id){
        $this->db->select('a.*');
        $this->db->from('overlay_indikator as a');
        $this->db->where('a.ID',$id);
        return $this->db->get()->row();
    }

    function data_indikator_master($id){
        $this->db->select('a.JUDUL,
        b.INDIKATOR,
        b.NAMA_KEC,
        b.`2019`,
        b.SATUAN');
        $this->db->from('overlay_indikator as a');
        $this->db->join('v_data_wilayah as b','a.INDIKATOR_MASTER = b.ID_INDIKATOR');
        $this->db->where('b.ID_INDIKATOR',$id);
        return $this->db->get()->result_array();
    }

    function data_indikator_x($id){
        $this->db->select('a.JUDUL,
        b.INDIKATOR,
        b.NAMA_KEC,
        b.`2019`,
        b.SATUAN');
        $this->db->from('overlay_indikator as a');
        $this->db->join('v_data_wilayah as b','a.INDIKATOR_X = b.ID_INDIKATOR');
        $this->db->where('b.ID_INDIKATOR',$id);
        return $this->db->get()->result_array();
    }

    function data_indikator_tambahan($id){
        $this->db->select('a.JUDUL,
        b.INDIKATOR,
        b.NAMA_KEC,
        b.`2019`,
        b.SATUAN');
        $this->db->from('overlay_indikator as a');
        $this->db->join('v_data_wilayah as b','a.INDIKATOR_TAMBAHAN = b.ID_INDIKATOR');
        $this->db->where('b.ID_INDIKATOR',$id);
        return $this->db->get()->result_array();
    }

    function get_data_y($id,$tahun){
        if($tahun){
            $this->db->select("b.JUDUL,
            a.INDIKATOR_ID,
            a.TIPE,
            c.INDIKATOR,
            c.NAMA_KEC,
            c.`".$tahun."`");
        }
        $this->db->from("overlay_indikator_copy1 as a");
        $this->db->join("overlay_indikator_master as b","a.ID_MASTER = b.ID");
        $this->db->join("v_data_wilayah as c","a.INDIKATOR_ID = c.ID_INDIKATOR");
        $this->db->where("a.ID_MASTER",$id);

        if($tahun){
            $this->db->where("c.`".$tahun."` != ''");
        }
        
        $this->db->where("a.TIPE",'Y');
        return $this->db->get()->result_array();

    }

    function get_data($id){
        $this->db->select("b.JUDUL,
        a.INDIKATOR_ID,
        a.TIPE,
        c.INDIKATOR,
        c.NAMA_KEC,
        c.`2019`,
        MAX( CASE WHEN `a`.`TIPE` = 'Y' THEN `c`.`2019` END ) AS `Y`,
        MAX( CASE WHEN `a`.`TIPE` = 'X' THEN `c`.`2019` END ) AS `X`,
        MAX( CASE WHEN `a`.`TIPE` = 'TAMBAHAN' THEN `c`.`2019` END ) AS `Z`");
        $this->db->from("overlay_indikator_copy1 as a");
        $this->db->join("overlay_indikator_master as b","a.ID_MASTER = b.ID");
        $this->db->join("v_data_wilayah as c","a.INDIKATOR_ID = c.ID_INDIKATOR");
        $this->db->where("a.ID_MASTER",$id);
        $this->db->where("c.`2019` != ''");
        return $this->db->get()->result_array();
    }

    function get_data_kec($id,$tahun){
        $this->db->select("c.NAMA_KEC");
        $this->db->from("overlay_indikator_copy1 as a");
        $this->db->join("overlay_indikator_master as b","a.ID_MASTER = b.ID");
        $this->db->join("v_data_wilayah as c","a.INDIKATOR_ID = c.ID_INDIKATOR");
        $this->db->where("a.ID_MASTER",$id);
        if($tahun){
            $this->db->where("c.`".$tahun."` != ''");    
        }
        $this->db->group_by('c.NAMA_KEC');
        return $this->db->get()->result_array();
    }

    function get_data_by_kec($id,$kec,$tahun){
        if($tahun){
            $this->db->select("b.JUDUL,
            a.INDIKATOR_ID,
            a.TIPE,
            c.INDIKATOR,
            c.NAMA_KEC,
            c.`".$tahun."`,
            MAX( CASE WHEN `a`.`TIPE` = 'Y' THEN `c`.`".$tahun."` END ) AS `Y`,
            MAX( CASE WHEN `a`.`TIPE` = 'X' THEN `c`.`".$tahun."` END ) AS `X`,
            MAX( CASE WHEN `a`.`TIPE` = 'TAMBAHAN' THEN `c`.`".$tahun."` END ) AS `Z`");
        }
        $this->db->from("overlay_indikator_copy1 as a");
        $this->db->join("overlay_indikator_master as b","a.ID_MASTER = b.ID");
        $this->db->join("v_data_wilayah as c","a.INDIKATOR_ID = c.ID_INDIKATOR");
        $this->db->where("a.ID_MASTER",$id);

        if($tahun){
            $this->db->where("c.`".$tahun."` != ''");
        }

        $this->db->where('c.NAMA_KEC',$kec);
        return $this->db->get()->row_array();
    }

    function indikator_overlay($id){
        $this->db->select('a.INDIKATOR_ID,
        a.TIPE,
        b.INDIKATOR');
        $this->db->from('overlay_indikator_copy1 as a');
        $this->db->join('tx_indikator_ref as b','a.INDIKATOR_ID = b.ID');
        $this->db->where('a.ID_MASTER',$id);
        return $this->db->get()->result_array();
    }

    function trend($id){
        $this->db->select('
            a.ID_INDIKATOR,
            a.INDIKATOR,
            a.SATUAN,
            a.`2010`,
            a.`2011`,
            a.`2012`,
            a.`2013`,
            a.`2014`,
            a.`2015`,
            a.`2016`,
            a.`2017`,
            a.`2018`,
            a.`2019`,
            a.`2020`,
            a.`2021`,b.ID,b.URUSAN
        ');
        $this->db->from('v_data_dasar AS a');
        $this->db->join('m_urusan as b','a.URUSAN_ID = b.ID');
        $this->db->where('a.ID_INDIKATOR', $id);
        return $this->db->get()->result_array();
    }

    function indikator(){
        $this->db->select('a.ID_INDIKATOR,
            a.INDIKATOR,
            a.SATUAN,
            a.`2010`,
            a.`2011`,
            a.`2012`,
            a.`2013`,
            a.`2014`,
            a.`2015`,
            a.`2016`,
            a.`2017`,
            a.`2018`,
            a.`2019`,
            a.`2020`,
            a.`2021`');
        $this->db->from('v_data_dasar as a');
        return $this->db->get()->result_array();
    }

    function rasio_indikator($id){
        $this->db->select('a.INDIKATOR_X,a.INDIKATOR_Y,b.INDIKATOR,b.ID,c.TAHUN,');
        $this->db->from('rasio_indikator as a');
        $this->db->join('tx_indikator_ref AS b','a.INDIKATOR_Y = b.ID');
        $this->db->join('tx_data_dasar as c','b.ID = c.INDIKATOR_ID');
        $this->db->where('a.INDIKATOR_X',$id);
        return $this->db->get()->result_array();
    }

    function val_indikator($id){
        $this->db->select('a.TAHUN,a.DATA,b.INDIKATOR,b.SATUAN');
        $this->db->from('tx_data_dasar as a');
        $this->db->join('tx_indikator_ref AS b','a.INDIKATOR_ID = b.ID');
        $this->db->where('a.INDIKATOR_ID',$id);
        return $this->db->get()->result_array();
    }

    function rasio_trial($id,$tahun){
        // SELECT
        // a.INDIKATOR_RASIO,
        // c.INDIKATOR,
        // b.TAHUN,
        // b.DATA
        // FROM
        // rasio_indikator_v1 AS a
        // INNER JOIN tx_data_dasar AS b ON a.INDIKATOR_RASIO = b.INDIKATOR_ID
        // INNER JOIN tx_indikator_ref AS c ON b.INDIKATOR_ID = c.ID
        // WHERE
        // a.INDIKATOR_MASTER = 4448

        $this->db->select('a.INDIKATOR_RASIO,c.INDIKATOR,b.TAHUN,b.DATA');
        $this->db->from('rasio_indikator_v1 AS a');
        $this->db->join('tx_data_dasar AS b','a.INDIKATOR_RASIO = b.INDIKATOR_ID');
        $this->db->join('tx_indikator_ref AS c','b.INDIKATOR_ID = c.ID');
        $this->db->where('a.INDIKATOR_RASIO',$id);
        $this->db->where('b.TAHUN',$tahun);
        return $this->db->get()->row_array();

        // $this->db->select('a.INDIKATOR_ID,c.INDIKATOR,c.*');
        // $this->db->from('rasio_indikator_sub_trial as a');
        // $this->db->join('rasio_indikator_trial as b','a.ID_RASIO_INDIKATOR = b.id');
        // $this->db->join('v_data_dasar as c','a.INDIKATOR_ID = c.ID_INDIKATOR');
        // $this->db->where('b.INDIKATOR_MASTErR',$id);
        // return $this->db->get()->result_array();
    }

    function rasio_master($id,$tahun){
        // SELECT
        // a.INDIKATOR_RASIO,
        // c.INDIKATOR,
        // b.TAHUN,
        // b.DATA
        // FROM
        // rasio_indikator_v1 AS a
        // INNER JOIN tx_data_dasar AS b ON a.INDIKATOR_RASIO = b.INDIKATOR_ID
        // INNER JOIN tx_indikator_ref AS c ON b.INDIKATOR_ID = c.ID
        // WHERE
        // a.INDIKATOR_MASTER = 4448

        $this->db->select('a.INDIKATOR_MASTER,c.INDIKATOR,b.TAHUN,b.DATA');
        $this->db->from('rasio_indikator_v1 AS a');
        $this->db->join('tx_data_dasar AS b','a.INDIKATOR_MASTER = b.INDIKATOR_ID');
        $this->db->join('tx_indikator_ref AS c','b.INDIKATOR_ID = c.ID');
        $this->db->where('a.INDIKATOR_MASTER',$id);
        $this->db->where('b.TAHUN',$tahun);
        return $this->db->get()->row_array();

        // $this->db->select('a.INDIKATOR_ID,c.INDIKATOR,c.*');
        // $this->db->from('rasio_indikator_sub_trial as a');
        // $this->db->join('rasio_indikator_trial as b','a.ID_RASIO_INDIKATOR = b.id');
        // $this->db->join('v_data_dasar as c','a.INDIKATOR_ID = c.ID_INDIKATOR');
        // $this->db->where('b.INDIKATOR_MASTErR',$id);
        // return $this->db->get()->result_array();
    }
}