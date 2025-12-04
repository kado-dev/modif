<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Trackingkunjungan extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		// $tbpasienrj = 'tbpasienrj_'.$bulan;
      	$tbpasienrj = 'tbpasienrj_LINGGAR';
		$hasil['hasil']['kunjungan_hari'] = $this->db->query("SELECT count(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE TanggalRegistrasi=curdate()")->row()->Jumlah;
		$hasil['hasil']['kunjungan_bulan'] = $this->db->query("SELECT count(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'")->row()->Jumlah;
		$hasil['hasil']['kunjungan_tahun'] = $this->db->query("SELECT count(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun'")->row()->Jumlah;
		$hasil['pesan']['status'] = 'Berhasil';
		$hasil['pesan']['kode'] = 200;
        $this->response($hasil, 200);
	}
}
?>