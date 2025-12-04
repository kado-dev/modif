<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Wabah extends REST_Controller {

	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		$kelurahan = $this->uri->segment(5);
		$puskesmas = $this->uri->segment(6);
		$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
		$tbpasienrj = 'tbpasienrj_'.$bulan;
		
		$list = $this->db->query("SELECT `KodeDiagnosa`,`NamaDiagnosa` FROM `tbdiagnosaw2`");
		if($list->num_rows() > 0 and $bulan != '' and $tahun != ''){
			foreach($list->result() as $lst){
				$x['KodeDiagnosa'] = $lst->KodeDiagnosa;
				$x['NamaDiagnosa'] = $lst->NamaDiagnosa;
				if($kelurahan == ''){
					$x['Jumlah'] = $this->db->query("SELECT COUNT(NoRegistrasi) AS Jml FROM $tbdiagnosapasien
					WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa = '$lst->KodeDiagnosa'")->row()->Jml;
				}else{
					$x['Jumlah'] = $this->db->query("SELECT COUNT(a.NoRegistrasi) AS Jml FROM $tbdiagnosapasien a
					JOIN $tbpasienrj b ON a.NoRegistrasi = b.NoRegistrasi
					JOIN tbkk c ON c.NoIndex = b.NoIndex
					WHERE YEAR(a.TanggalDiagnosa) = '$tahun' AND a.KodeDiagnosa = '$lst->KodeDiagnosa' AND c.Kelurahan = '$kelurahan'")->row()->Jml;
				}
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