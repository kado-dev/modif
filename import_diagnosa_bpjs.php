<?php
	session_start();	
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$jsondiagnnosa = get_data_diagnosa_master();
	$pars = json_decode($jsondiagnnosa,true); 
	$list = $pars['response']['list'];
	// echo get_data_diagnosa_master();
	// die();
	foreach($list as $ls){
		$kdDiag = $ls['kdDiag'];
		$nmDiag = $ls['nmDiag'];
		$nonSpesialis = $ls['nonSpesialis'];
		$str = "INSERT INTO `tbbpjs_diagnosa`(`kdDiag`,`nmDiag`,`nonSpesialis`) VALUES ('$kdDiag','$nmDiag','$nonSpesialis')";
		// cek dulu
		$cek_diagnosa_bpjs = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbbpjs_diagnosa` WHERE kdDiag = '$kdDiag'"));
		if($cek_diagnosa_bpjs == 0){
			mysqli_query($koneksi,$str);
		}
	}
	setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
	header('location:index.php?page=bpjs_diagnosa');
	
?>