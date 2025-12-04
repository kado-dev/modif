<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$data = get_data_poli();
	$dmedis = json_decode($data,True);
	// echo $data;
	// die();
	$list = $dmedis['response']['list'];
	foreach($list as $ls){
		$kdPoli = $ls['kdPoli'];
		$nmPoli = $ls['nmPoli'];				
		$poliSakit = $ls['poliSakit'];				
		$str = "INSERT INTO `tbbpjs_poli`(`kdPoli`,`nmPoli`,`poliSakit`) VALUES ('$kdPoli','$nmPoli','$poliSakit')";
		// cek dulu
		$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbbpjs_poli` WHERE `kdPoli` = '$kdPoli'"));
		if($cek == 0){
			mysqli_query($koneksi,$str);
		}
	}
	setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
	header('location:index.php?page=bpjs_poli');
?>