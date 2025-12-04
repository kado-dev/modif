<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Poli extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		// $tbpasienrj = 'tbpasienrj_'.$bulan;
		$poli = $this->db->query("SELECT * from tbpelayanankesehatan where JenisPelayanan = 'Kunjungan Sakit'");
		foreach($poli->result() as $pl){
		$hasil['Response'][$pl->Pelayanan] = $this->db->query("SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `PoliPertama`='$pl->Pelayanan'")->row()->Jumlah;
		}
		$hasil['Pesan']['Status'] = 'Berhasil';
		$hasil['Pesan']['Kode'] = 200;

        $this->response($hasil, 200);
	}
}
?>