<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$jsontherapy = get_data_therapy();	
	$data = json_decode($jsontherapy,true); 
	$list = $data['response']['list'];
	foreach($list as $ls){
		$kdObat = $ls['kdObat'];
		$nmObat = $ls['nmObat'];
		$sedia = $ls['sedia'];
				
		// jika ada yang baru, insert ket tbbpjs_obat
		$cek_obat_bpjs = mysqli_num_rows(mysqli_query($koneksi,"SELECT `kdObat` FROM `tbbpjs_obat` where `kdObat` = '$kdObat'"));
		if($cek_obat_bpjs == 0){
			$str1[]= "('$kdObat','$nmObat','$sedia')";
		}
	}
	if(isset($str1)){
		$str2 = implode(",",$str1);
		$str = "INSERT INTO `tbbpjs_obat`(`kdObat`, `nmObat`, `sedia`) VALUES ".$str2;
		$query = mysqli_query($koneksi,$str);
	}
	setcookie("alert","<div class='alert alert-success'>Data berhasil diupdate...</div>",time()+5);
	header('location:index.php?page=bpjs_obat');
?>