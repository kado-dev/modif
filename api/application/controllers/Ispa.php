<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Ispa extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
		
		$hasil['Response']['KasusBaru'] = $this->db->query("SELECT COUNT(`KodeDiagnosa`) as Jml 
		FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND (`KodeDiagnosa` = 'J18.0' OR `KodeDiagnosa` = 'J18.9' OR `KodeDiagnosa` = 'J00' OR `KodeDiagnosa` = 'J06.9') AND `Kasus`='Baru'")->row()->Jml;
		$hasil['Response']['KasusLama'] = $this->db->query("SELECT COUNT(`KodeDiagnosa`) as Jml 
		FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND (`KodeDiagnosa` = 'J18.0' OR `KodeDiagnosa` = 'J18.9' OR `KodeDiagnosa` = 'J00' OR `KodeDiagnosa` = 'J06.9') AND `Kasus`='Lama'")->row()->Jml;
		$hasil['Pesan']['Status'] = 'Berhasil';
		$hasil['Pesan']['Kode'] = 200;
		$this->response($hasil, 200);
	}
}
?>