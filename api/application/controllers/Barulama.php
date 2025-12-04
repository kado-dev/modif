<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Barulama extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		// $tbpasienrj = 'tbpasienrj_'.$bulan;
		
		$hasil['Response']['KunjunganBaru'] = $this->db->query("SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND StatusKunjungan='Baru'")->row()->Jumlah;
		$hasil['Response']['KunjunganLama'] = $this->db->query("SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND StatusKunjungan='Lama'")->row()->Jumlah;
		// if($list->num_rows() > 0){
		$hasil['Pesan']['Status'] = 'Berhasil';
		$hasil['Pesan']['Kode'] = 200;
		// }else{
			// $hasil['Pesan']['Status'] = 'Tidak ada data';
			// $hasil['Pesan']['Kode'] = 204;
		// }	
        $this->response($hasil, 200);
	}
}
?>