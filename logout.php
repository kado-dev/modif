<?php
include "config/koneksi.php";
	session_start();	
	
	//update login status
	$id = $_SESSION['idpegawai'];
	$ut = mysqli_query($koneksi,"UPDATE tbpegawai SET StatusLogin = '0' where IdPegawai='$id'");
	
	if($ut){
	unset($_SESSION['idpegawai']);
	unset($_SESSION['id_user']);
	unset($_SESSION['nama_petugas']);
	unset($_SESSION['username']);
	unset($_SESSION['email']);
	unset($_SESSION['jabatan']);
	unset($_SESSION['pinsessionpegawai']);
	unset($_SESSION['sipsession']);
	unset($_SESSION['status']);
	unset($_SESSION['otoritas']);
	unset($_SESSION['kodepuskesmas']);
	unset($_SESSION['namapuskesmas']);
	unset($_SESSION['kelurahan']);
	unset($_SESSION['kecamatan']);
	unset($_SESSION['kota']);
	unset($_SESSION['profinsi']);
	unset($_SESSION['alamat']);
	unset($_SESSION['telepon']);
	unset($_SESSION['fax']);
	unset($_SESSION['tarifadministrasi']);
	unset($_SESSION['namaapoteker']);
	unset($_SESSION['nosipa']);
	unset($_SESSION['kodeyankes']);
	unset($_SESSION['bridgingpcare']);
	unset($_SESSION['bridgingantrol']);
	unset($_SESSION['bridgingicare']);
	unset($_SESSION['bridgingsatusehat']);
	unset($_SESSION['kodeppk']);
	unset($_SESSION['koneksi_bpjs']);
	unset($_SESSION['lantai']);
	unset($_SESSION['loket']);//untuk loket diantrian
	
	echo "<script>";
	echo "window.location='indexawal.php';";
	echo "</script>";
	}	
?>