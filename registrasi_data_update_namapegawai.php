<?php
	include "config/koneksi.php";
	$kodepuskesmas =  $_SESSION['kodepuskesmas'];
	$namapegawai =  $_SESSION['username'];
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
	$id  = $_GET['noreg'];

	// tahap1
	$str1 = "UPDATE `$tbpasienperpegawai` SET `Pendaftaran`='$namapegawai' WHERE `NoRegistrasi`='$id'";
	$query = mysqli_query($koneksi,$str1);	
	
	// tahap2
	$str2 = "UPDATE `$tbpasienrj` SET `NamaPegawaiSimpan`='$namapegawai' WHERE `NoRegistrasi`='$id'";
	mysqli_query($koneksi,$str2);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diupdate...');";
		echo "document.location.href='index.php?page=registrasi_data';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate...');";
		echo "document.location.href='index.php?page=registrasi_data';";
		echo "</script>";
	} 	
?>