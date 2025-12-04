<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namaposyandu = $_POST['namaposyandu'];
	$alamatposyandu = $_POST['alamatposyandu'];
	$idposyandu = $_POST['idposyandu'];
	$stssimpan = $_POST['stssimpan'];

	if($stssimpan == 'edit'){
		$str = "UPDATE `ref_posyandu` SET `KodePuskesmas`='$kodepuskesmas', `NamaPosyandu`='$namaposyandu', `AlamatPosyandu`='$alamatposyandu' WHERE `IdPosyandu`='$idposyandu'";
	}else{	
		$str = "INSERT INTO `ref_posyandu`(`KodePuskesmas`,`NamaPosyandu`,`AlamatPosyandu`) VALUES('$kodepuskesmas','$namaposyandu','$alamatposyandu')";
	}
	$query = mysqli_query($koneksi, $str);
	
	if($query){	
		alert_swal('sukses','Data berhasil disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=master_posyandu'";
		echo "</script>";
	}else{
		alert_swal('gagal','Data gagal disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=master_posyandu';";
		echo "</script>";
	} 	
?>