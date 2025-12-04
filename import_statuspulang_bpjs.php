<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$data = get_data_statuspulang();
	$dmedis = json_decode($data,True);
	$list = $dmedis['response']['list'];
	// echo $data;
	// die();
	foreach($list as $ls){
		$kdStatusPulang = $ls['kdStatusPulang'];
		$nmStatusPulang = $ls['nmStatusPulang'];				
		$str = "INSERT INTO `tbbpjs_statuspulang`(`kdStatusPulang`,`nmStatusPulang`) VALUES ('$kdStatusPulang','$nmStatusPulang')";
		// cek dulu
		$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbbpjs_statuspulang` WHERE `kdStatusPulang` = '$kdStatusPulang'"));
		if($cek == 0){
			mysqli_query($koneksi,$str);
		}
	}
	setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
	header('location:index.php?page=bpjs_statuspulang');
?>