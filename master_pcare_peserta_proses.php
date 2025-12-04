<?php
	include "config/koneksi.php";
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$jumlah01 = $_POST['jumlah01'];
	$jumlah02 = $_POST['jumlah02'];
	$jumlah03 = $_POST['jumlah03'];
	$jumlah04 = $_POST['jumlah04'];
	$jumlah05 = $_POST['jumlah05'];
	$jumlah06 = $_POST['jumlah06'];
	$jumlah07 = $_POST['jumlah07'];
	$jumlah08 = $_POST['jumlah08'];
	$jumlah09 = $_POST['jumlah09'];
	$jumlah10 = $_POST['jumlah10'];
	$jumlah11 = $_POST['jumlah11'];
	$jumlah12 = $_POST['jumlah12'];
	
	$str = "UPDATE `tbpuskesmasdetail` SET `JumlahPeserta_01`='$jumlah01', `JumlahPeserta_02`='$jumlah02', `JumlahPeserta_03`='$jumlah03',
	`JumlahPeserta_04`='$jumlah04', `JumlahPeserta_05`='$jumlah05', `JumlahPeserta_06`='$jumlah06', `JumlahPeserta_07`='$jumlah07', `JumlahPeserta_08`='$jumlah08',
	`JumlahPeserta_09`='$jumlah09', `JumlahPeserta_10`='$jumlah10', `JumlahPeserta_11`='$jumlah11', `JumlahPeserta_12`='$jumlah12' WHERE `KodePuskesmas`='$kodepuskesmas'";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_pcare_peserta';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_pcare_peserta';";
		echo "</script>";
	} 	
?>