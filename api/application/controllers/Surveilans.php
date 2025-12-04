<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Surveilans extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
		
		$list = $this->db->query("SELECT `KodeDiagnosa`,`NamaDiagnosa` FROM `tbdiagnosasurveilans`");
		if($list->num_rows() > 0){
			foreach($list->result() as $lst){
				$x['KodeDiagnosa'] = $lst->KodeDiagnosa;
				$x['NamaDiagnosa'] = $lst->NamaDiagnosa;
				$x['Jumlah'] = $this->db->query("SELECT COUNT(NoRegistrasi) AS Jml FROM $tbdiagnosapasien
				WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$lst->KodeDiagnosa%'")->row()->Jml;
				$y[] = $x;
			}
			
			$hasil['Response'] = $y;
			$hasil['Pesan']['Status'] = 'Berhasil';
			$hasil['Pesan']['Kode'] = 200;
		}else{
			$hasil['Pesan']['Status'] = 'Tidak ada data';
			$hasil['Pesan']['Kode'] = 204;
		}	

        $this->response($hasil, 200);
	}
}
?>