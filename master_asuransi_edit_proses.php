<?php
include "config/koneksi.php";

	$kodeasuransi =  $_POST['kodeasuransi'];
	$asuransi = $_POST['asuransi'];
	$kota = $_POST['kota'];

	$str = "Update tbasuransi SET `KodeAsuransi`='$kodeasuransi',`Asuransi`='$asuransi',`Kota` = '$kota' where `KodeAsuransi`='$kodeasuransi'";
	$query=mysqli_query($koneksi,$str);
	
	//echo var_dump($str);
	//die();
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_asuransi';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_asuransi';";
		echo "</script>";
	} 	
?>