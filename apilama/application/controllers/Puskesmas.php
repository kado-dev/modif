<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
class Puskesmas extends REST_Controller {

	// GET
	public function index_get(){
		$tgl = $this->uri->segment(3);
		// $tbpasienrj = 'tbpasienrj_'.explode("-",$tgl)[1];
		$tbpasienrj = 'tbpasienrj';
		$list = $this->db->query("SELECT `TanggalRegistrasi`, SUBSTRING(NoRegistrasi, 1, 11) as KodePuskesmas,
		COUNT(`NoRegistrasi`) as jml FROM `$tbpasienrj` GROUP BY `TanggalRegistrasi`,`KodePuskesmas` 
		HAVING `TanggalRegistrasi` = '$tgl' order by jml DESC");
		
		if($list->num_rows() > 0){
			foreach($list->result() as $lst){
			$getnama = $this->db->query("SELECT NamaPuskesmas,Alamat,tbpuskesmas.Lat,tbpuskesmas.Long as Lng,Telepon from tbpuskesmas where KodePuskesmas = '$lst->KodePuskesmas'");
			if($getnama->num_rows() > 0){
				$nmpus = $getnama->row()->NamaPuskesmas;
				$Alamat = $getnama->row()->Alamat;
				$Long= $getnama->row()->Lng;
				$Lat= $getnama->row()->Lat;
				$Telepon= $getnama->row()->Telepon;

			}else{
				$nmpus = "";
			}
				$x['KodePuskesmas'] = $lst->KodePuskesmas;
				$x['NamaPuskesmas'] = $nmpus;
			    $x['Alamat'] = $Alamat;
			    $x['Long'] = $Long;
				$x['Lat'] = $Lat;
				$x['Telepon'] = $Telepon;
				
				$x['Jumlah'] = $lst->jml;
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