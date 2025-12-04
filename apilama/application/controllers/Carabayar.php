<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Carabayar extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		// $tbpasienrj = 'tbpasienrj_'.$bulan;
		
		$carabayar = $this->db->query("SELECT * FROM tbasuransi");
		foreach($carabayar->result() as $cr){
			$hasil['Response'][$cr->Asuransi] = $this->db->query("SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `Asuransi`='$cr->Asuransi'")->row()->Jumlah;
		}
		$hasil['Pesan']['Status'] = 'Berhasil';
		$hasil['Pesan']['Kode'] = 200;

        $this->response($hasil, 200);
	}
}
?>