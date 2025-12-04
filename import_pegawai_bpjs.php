<?php
	session_start();	
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";	
	include "config/helper_bpjs_v4.php";

	//if($_SESSION['koneksi_bpjs']== 'Stabil'){
		$data_medis = get_data_tenagamedis();
		$dmedis = json_decode($data_medis,True);
		$list = $dmedis['response']['list'];
		// echo "hasil : ".get_data_tenagamedis();
		// die();

		if($list != ''){
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$str2 = "DELETE FROM tbpegawaibpjs Where `kdpuskesmas` = '$kodepuskesmas'";
		mysqli_query($koneksi,$str2);
		
			foreach($list as $ls){
				$kddokter = $ls['kdDokter'];
				$namadokter = mysqli_real_escape_string($koneksi, $ls['nmDokter']);
				$kdpuskesmas = $_SESSION['kodepuskesmas'];
				
				$str = "INSERT INTO `tbpegawaibpjs`(`kdDokter`,`nmDokter`,`kdpuskesmas`) VALUES ('$kddokter','$namadokter','$kdpuskesmas')";
			
				// cek dulu
				$cek_pegawai_bpjs = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from `tbpegawaibpjs` where kdDokter = '$kddokter' AND `kdpuskesmas` = '$kdpuskesmas'"));
				if($cek_pegawai_bpjs == 0){ // jika kode pegawai belum ada ditabel database puskesmasonline, maka simpan
					mysqli_query($koneksi,$str);
				}
			}
			setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate</div>",time()+5);
			header('location:index.php?page=bpjs_dokter');
		}else{
			setcookie("alert","<div class='alert alert-danger'>Data data gagal di update</div>",time()+5);
			header('location:index.php?page=bpjs_dokter');
		}
	// }else{
	// 	setcookie("alert","<div class='alert alert-danger'>Gangguan koneksi ke server bpjs</div>",time()+5);
	// 	header('location:index.php?page=master_pegawai_bpjs');
	// }
?>