<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Retribusipuskesmas extends REST_Controller {

	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		// $tbpasienrj = 'tbpasienrj_'.$bulan;
		
		$hasil['Response']['Harian'] = $this->db->query("SELECT SUM(TotalTarif)AS Jumlah FROM `tbpasienrj` WHERE TanggalRegistrasi=curdate()")->row()->Jumlah;
		$hasil['Response']['Bulanan'] = $this->db->query("SELECT SUM(TotalTarif)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'")->row()->Jumlah;
		$hasil['Response']['Tahunan'] = $this->db->query("SELECT SUM(TotalTarif)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun'")->row()->Jumlah;
		$hasil['Pesan']['Status'] = 'Berhasil';
		$hasil['Pesan']['Kode'] = 200;
        $this->response($hasil, 200);
	}
}
?>