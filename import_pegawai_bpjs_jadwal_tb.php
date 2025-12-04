<?php
	session_start();	
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";	
	include "config/helper_bpjs_antrean_v2.php";
	$tglsekarang = date('Y-m-d');

	$data_medis = get_data_dokter_antrean_fktp('033',$tglsekarang );
	$dmedis = json_decode($data_medis,True);
	$list = $dmedis['response'];
	// echo "hasil : ".get_data_dokter_antrean_fktp();
	// die();

	if($list != ''){
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$str2 = "DELETE FROM tbpegawaibpjsjadwal Where `kdpuskesmas` = '$kodepuskesmas' AND `kodepoli`='033'";
		mysqli_query($koneksi,$str2);
	
		foreach($list as $ls){
			$kdpuskesmas = $_SESSION['kodepuskesmas'];
			$namadokter = mysqli_real_escape_string($koneksi, $ls['namadokter']);
			$kddokter = $ls['kodedokter'];
			$jampraktek = $ls['jampraktek'];
			$kapasitas = $ls['kapasitas'];
			
			$str = "INSERT INTO `tbpegawaibpjsjadwal`(`kdpuskesmas`,`kodepoli`,`namadokter`,`kodedokter`,`jampraktek`,`kapasitas`) VALUES ('$kdpuskesmas','033','$namadokter','$kddokter','$jampraktek','$kapasitas')";
			mysqli_query($koneksi,$str);
			// echo $str;
			// die();
			
		}
		setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate</div>",time()+5);
		header('location:index.php?page=bpjs_dokter_jadwal');
	}else{
		setcookie("alert","<div class='alert alert-danger'>Data data gagal di update</div>",time()+5);
		header('location:index.php?page=bpjs_dokter_jadwal');
	}
?>