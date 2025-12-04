<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$data = get_data_provider();
	$dmedis = json_decode($data,True);
	$list = $dmedis['response']['list'];
	foreach($list as $ls){
		$kdProvider = $ls['kdProvider'];
		$nmProvider = $ls['nmProvider'];			
		$str = "INSERT INTO `tbbpjs_provider`(`kdProvider`,`nmProvider`) VALUES ('$kdProvider','$nmProvider')";
		// cek dulu
		$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbbpjs_provider` WHERE `kdProvider` = '$kdProvider'"));
		if($cek == 0){
			mysqli_query($koneksi,$str);
		}
	}
	setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
	header('location:index.php?page=bpjs_provider');
?>