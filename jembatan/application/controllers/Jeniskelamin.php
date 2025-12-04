<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Jeniskelamin extends REST_Controller {

	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		$tbpasienrj = 'tbpasienrj_'.$bulan;
		
		$hasil['Response']['Lakilaki'] = $this->db->query("SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND JenisKelamin='L'")->row()->Jumlah;
		$hasil['Response']['Perempuan'] = $this->db->query("SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND JenisKelamin='P'")->row()->Jumlah;
		$hasil['Pesan']['Status'] = 'Berhasil';
		$hasil['Pesan']['Kode'] = 200;
        $this->response($hasil, 200);
	}
}
?>