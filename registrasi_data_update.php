<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_bpjs.php";	
	$noregistrasi = $_GET['noreg'];
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	
	$str = "UPDATE `$tbpasienrj` SET `StatusPelayanan` = 'Antri' WHERE NoRegistrasi = '$noregistrasi'";

	$query = mysqli_query($koneksi,$str);
	if($query){
		echo "<script>";
		echo "alert('Data berhasil diupdate');";
		echo "document.location.href='index.php?page=registrasi_data';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate');";
		echo "document.location.href='index.php?page=registrasi_data';";
		echo "</script>";
	} 	
?>