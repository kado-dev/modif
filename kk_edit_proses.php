<?php
	session_start();
	include "config/koneksi.php";
	$tanggaledit = date('Y-m-d');
	$noindex = $_POST['noindex'];
	$norm1 = $_POST['norm'];
	$norm = $kodepuskesmas.$norm1;
	$namakk1 = mysqli_real_escape_string($koneksi, $_POST['namakk']);
	$namakk = strtoupper($namakk1);
	$daerah = $_POST['daerah'];
	$wilayah = $_POST['wilayah'];
	$alamat = strtoupper($_POST['alamat']);
	$rt = $_POST['rt'];
	$rw = $_POST['rw'];
	$no = $_POST['no'];
	$provinsi = $_POST['provinsi'];
	$kodepos = $_POST['kodepos'];
	$kota = $_POST['kota'];
	$kecamatan = $_POST['kecamatan'];
	$kelurahan = $_POST['kelurahan'];
	$telepon = $_POST['telepon'];

	// domisili
	$alamat_domisili = strtoupper($_POST['alamat_domisili']);
	$rt_domisili = $_POST['rt_domisili'];
	$rw_domisili = $_POST['rw_domisili'];
	$no_domisili = $_POST['no_domisili'];
	$provinsi_domisili = $_POST['provinsi_domisili'];
	$kodepos_domisili = $_POST['kodepos_domisili'];
	$kota_domisili = $_POST['kota_domisili'];
	$kecamatan_domisili = $_POST['kecamatan_domisili'];
	$kelurahan_domisili = $_POST['kelurahan_domisili'];

	$namapegawaiedit = $_SESSION['username'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);

	$str = "UPDATE `$tbkk` SET `NoRM`='$norm',`NamaKK`='$namakk',`Daerah`='$daerah',`Wilayah`='$wilayah',
	`Alamat`='$alamat',`RT`='$rt',`RW`='$rw',`No`='$no',`Provinsi`='$provinsi',`KodePos`='$kodepos',`Kota`='$kota',`Kecamatan`='$kecamatan',`Kelurahan`='$kelurahan',
	`Alamat_domisili`='$alamat_domisili',`RT_domisili`='$rt_domisili',`RW_domisili`='$rw_domisili',`No_domisili`='$no_domisili',`Provinsi_domisili`='$provinsi_domisili',`Kota_domisili`='$kota_domisili',`Kecamatan_domisili`='$kecamatan_domisili',`Kelurahan_domisili`='$kelurahan_domisili',`KodePos_domisili`='$kodepos_domisili',
	`Telepon`='$telepon',`NamaPegawaiEdit`='$namapegawaiedit',`TanggalEdit`='$tanggaledit' WHERE `NoIndex`='$noindex'";
	// echo $str;
	// die();
	$query = mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=kk_detail&id=$noindex';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=kk_edit&id=$noindex';";
		echo "</script>";
	} 	
?>