<?php
session_start();
error_reporting(1);
include "config/koneksi.php";
include "config/helper.php";
include "config/helper_pasienrj.php";
include "config/helper_report.php";

$stsretensi= $_POST['stsretensi'];
$idpasien= $_POST['idpasien'];
$key= $_POST['key'];
$tahun= $_POST['tahun'];
$lamakunjungan= $_POST['lamakunjungan'];
$halaman= $_POST['halaman'];

//$idpasiengrup = implode(',', $stsretensi);
//$str = "UPDATE `$tbpasien` SET StatusRetensi = 'Y' WHERE IdPasien IN ($idpasiengrup)";

foreach($idpasien as $id){
	$stsr = ($stsretensi[$id] == 'Y' ) ? 'Y' : 'N'; 
	$str = "UPDATE `$tbpasien` SET StatusRetensi = '$stsr' WHERE IdPasien = '$id'";
	$query = mysqli_query($koneksi,$str);
}


if($query){	
	alert_swal('sukses','Data berhasil disimpan');
	echo "<script>";
	echo "document.location.href='index.php?page=rekam_medis_pasien&key=$key&tahun=$tahun&lamakunjungan=$lamakunjungan&h=$halaman';";
	echo "</script>";
}else{
	echo $str;
	die();
	alert_swal('gagal','Data gagal disimpan');
	echo "<script>";
	echo "document.location.href='index.php?page=rekam_medis_pasien&key=$key&tahun=$tahun&lamakunjungan=$lamakunjungan&h=$halaman';";
	echo "</script>";
} 
?>