<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Kematian extends REST_Controller {

	// GET
	public function index_get(){
		$bulan = $this->uri->segment(3);
		$tahun = $this->uri->segment(4);
		$kdpuskesmas = $this->uri->segment(5);
        if ($bulan == '' or $tahun == '' or $kdpuskesmas == '') {
            
			$hasil['Pesan']['Status'] = 'Parameter tidak lengkap';
			$hasil['Pesan']['Kode'] = 204;
			
        } else {
			$hasil['Response']['Jml_Hidup_L'] =$this->db->query("SELECT * FROM `tbpolibersalinriwayat` WHERE MONTH(TanggalPersalinan) = '$bulan' AND YEAR(TanggalPersalinan) = '$tahun' AND SUBSTRING(NoPemeriksaan,1,11) ='$kdpuskesmas' AND KeadaanLahir = 'H' AND JenisKelamin = 'L'")->num_rows();
			$hasil['Response']['Jml_Hidup_P'] =$this->db->query("SELECT * FROM `tbpolibersalinriwayat` WHERE MONTH(TanggalPersalinan) = '$bulan' AND YEAR(TanggalPersalinan) = '$tahun' AND SUBSTRING(NoPemeriksaan,1,11) ='$kdpuskesmas' AND KeadaanLahir = 'H' AND JenisKelamin = 'P'")->num_rows();
			$hasil['Response']['Jml_Meninggal_L'] =$this->db->query("SELECT * FROM `tbpolibersalinriwayat` WHERE MONTH(TanggalPersalinan) = '$bulan' AND YEAR(TanggalPersalinan) = '$tahun' AND SUBSTRING(NoPemeriksaan,1,11) ='$kdpuskesmas' AND KeadaanLahir = 'M' AND JenisKelamin = 'L'")->num_rows();
			$hasil['Response']['Jml_Meninggal_P'] =$this->db->query("SELECT * FROM `tbpolibersalinriwayat` WHERE MONTH(TanggalPersalinan) = '$bulan' AND YEAR(TanggalPersalinan) = '$tahun' AND SUBSTRING(NoPemeriksaan,1,11) ='$kdpuskesmas' AND KeadaanLahir = 'M' AND JenisKelamin = 'P'")->num_rows();
			$hasil['Pesan']['Status'] = 'Berhasil';
			$hasil['Pesan']['Kode'] = 200;		
		}
        $this->response($hasil, 200);
	}
}
?>