<?php
	date_default_timezone_set('Asia/Jakarta');
	$id = $_GET['id'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tbpasienonline = "tbpasienonline_".$kodepuskesmas;
	$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;

	$query=mysqli_query($koneksi,"DELETE FROM $tbpasienonline WHERE IdPasienOnline = '$id'");
	if($query){	
		mysqli_query($koneksi,"DELETE FROM $tbantrian_pasien WHERE IdPasienOnline = '$id'");
		echo "<script>";
		echo "alert('Data berhasil dibatalkan...');";
		echo "document.location.href='index.php?page=registrasi_online';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dibatalkan...');";
		echo "document.location.href='index.php?page=registrasi_online';";
		echo "</script>";
	}
?>