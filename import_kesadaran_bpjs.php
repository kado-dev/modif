<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$data = get_data_kesadaran();
	$dmedis = json_decode($data,True);
	$list = $dmedis['response']['list'];
	foreach($list as $ls){
		$kdSadar = $ls['kdSadar'];
		$nmSadar = $ls['nmSadar'];				
		$str = "INSERT INTO `tbbpjs_kesadaran`(`kdSadar`,`nmSadar`) VALUES ('$kdSadar','$nmSadar')";
		// cek dulu
		$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbbpjs_kesadaran` WHERE `kdSadar` = '$kdSadar'"));
		if($cek == 0){
			mysqli_query($koneksi,$str);
		}
	}
	setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
	header('location:index.php?page=bpjs_kesadaran');
?>