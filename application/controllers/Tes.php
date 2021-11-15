<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes extends CI_Controller {

	public function index()
	{
		
		$query = $this->db->query("SELECT DISTINCT *
				FROM
				tx_indikator_ref AS a
				WHERE
				a.KET = 'baru'
				")->result_array();
		foreach ($query as $key => $value) {
			$cek = $this->db->query("SELECT
									a.ID AS INDIKATOR_ID,
									b.KODE_INDIKATOR,
									b.INDIKATOR,
									b.SATUAN,
									b.ID_URUSAN as URUSAN_ID,
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
									d.ID
									FROM
									tx_indikator_ref AS a
									INNER JOIN ub_indikator_ref_copy2 AS b ON a.KODE_INDIKATOR = b.KODE_INDIKATOR
									LEFT JOIN m_urusan_ub AS c ON b.ID_URUSAN = c.ID
									LEFT JOIN m_urusan AS d ON c.URUSAN = d.URUSAN
									WHERE
									a.KET = 'baru'
									AND a.KODE_INDIKATOR = '".$value['KODE_INDIKATOR']."'")->row_array();
			for ($i=2010; $i <2021 ; $i++) { 
				$tahun = $i.' '.$cek[$i];
				echo $cek['INDIKATOR'].'</br>'.$tahun;
				// URUSAN_ID,INDIKATOR_ID,TAHUN,DATA,SATUAN,KATEGORI,KET
				$data = array('URUSAN_ID'=>$cek['URUSAN_ID'],'INDIKATOR_ID'=>$cek['INDIKATOR_ID'],'TAHUN'=>$i,'DATA'=>$cek[$i],'SATUAN'=>$cek['SATUAN'],'KATEGORI'=>'capaian','KET'=>'baru');
				$this->db->insert('tx_data_dasar',$data);
			}
		}
	}

}

?>