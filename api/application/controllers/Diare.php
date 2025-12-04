<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Diare extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
		
		$hasil['Response']['KasusBaru'] = $this->db->query("SELECT COUNT(`KodeDiagnosa`) as Jml 
		FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND (`KodeDiagnosa` = 'A03.0' OR `KodeDiagnosa` = 'A06.0' OR `KodeDiagnosa` = 'A09') AND `Kasus`='Baru'")->row()->Jml;
		$hasil['Response']['KasusLama'] = $this->db->query("SELECT COUNT(`KodeDiagnosa`) as Jml 
		FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND (`KodeDiagnosa` = 'A03.0' OR `KodeDiagnosa` = 'A06.0' OR `KodeDiagnosa` = 'A09') AND `Kasus`='Lama'")->row()->Jml;
		$hasil['Pesan']['Status'] = 'Berhasil';
		$hasil['Pesan']['Kode'] = 200;
		$this->response($hasil, 200);
	}
}
?>