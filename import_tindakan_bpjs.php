<?php
	session_start();	
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$kota = $_SESSION['kota'];
	$jsontindakan = get_data_tindakan();
	$pars = json_decode($jsontindakan,true); 
	$list = $pars['response']['list'];
	
	foreach($list as $ls){
		$kdtindakan = $ls['kdTindakan'];
		$nmTindakan = $ls['nmTindakan'];
		$maxtarif = $ls['maxTarif'];
		$withValue = $ls['withValue'];
		$str = "INSERT INTO `tbbpjs_tindakan`(`kdTindakan`,`nmTindakan`,`maxTarif`,`withValue`) 
		VALUES ('$kdtindakan','$nmTindakan','$maxTarif','$withValue')";
		// echo $str;
		// die();
		$cek_tindakan_bpjs = mysqli_num_rows(mysqli_query($koneksi,"SELECT `kdTindakan` FROM `tbbpjs_tindakan` WHERE `kdTindakan` = '$kdTindakan'"));
		if($cek_tindakan_bpjs == 0){
			mysqli_query($koneksi,$str);
		}
	}
	setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
	header('location:index.php?page=bpjs_tindakan');
?>