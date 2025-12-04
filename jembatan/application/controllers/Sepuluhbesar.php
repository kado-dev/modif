<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Sepuluhbesar extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
		
		$list = $this->db->query("SELECT `TanggalDiagnosa`, `KodeDiagnosa`, COUNT(`KodeDiagnosa`) as Jumlah 
		FROM `$tbdiagnosapasien` 
		WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND `KodeDiagnosa` <> 'Z00.0'
		GROUP BY KodeDiagnosa 
		ORDER BY Jumlah DESC 
		limit 0,10");
		if($list->num_rows() > 0){
			foreach($list->result() as $lst){
				$getnama = $this->db->query("SELECT Diagnosa from tbdiagnosabpjs where KodeDiagnosa = '$lst->KodeDiagnosa'")->row();
				$x['KodeDiagnosa'] = $lst->KodeDiagnosa;
				$x['NamaDiagnosa'] = $getnama->Diagnosa;
				$x['Jumlah'] = $lst->Jumlah;
				$y[] = $x;
			}
			$hasil['Count'] = $list->num_rows();
			$hasil['List'] = $y;
			$hasil['Pesan']['Status'] = 'Berhasil';
			$hasil['Pesan']['Kode'] = 200;
		}else{
			$hasil['Pesan']['Status'] = 'Tidak ada data';
			$hasil['Pesan']['Kode'] = 204;
		}
		$res['Response'] = $hasil;
        $this->response($res, 200);
	}
}
?>