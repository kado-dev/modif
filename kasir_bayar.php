<?php
	include "config/helper_pasienrj.php";
	$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
	$noregistrasi = $_GET['noreg'];
	$tgltindakan = $_GET['tgl'];
	$str = "UPDATE `$tbtindakanpasien` SET `Statusbayar`= 'LUNAS' WHERE `NoRegistrasi` = '$noregistrasi'";
	$query = mysqli_query($koneksi,$str);
	
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil diproses');";
		echo "document.location.href='index.php?page=dashboard_puskesmas_kasir&tglreg3=$tgltindakan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diproses');";
		echo "document.location.href='index.php?page=dashboard_puskesmas_kasir&tglreg3=$tgltindakan';";
		echo "</script>";
	} 	
?>