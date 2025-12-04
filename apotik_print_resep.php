<?php
error_reporting(0);
session_start();
include "config/koneksi.php";
include "config/helper_report.php";
include "config/helper_pasienrj.php";
date_default_timezone_set('Asia/Jakarta');
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);

// jangan dipindah keatas, nnti gak jalan waktunya
date_default_timezone_set('Asia/Jakarta');
$tgltime = date('Y-m-d G:i:s');

// tbresep
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
$status = $_GET['status'];
$jenis_pio = $_GET['jenis_pio'];
$jenis_telaah = $_GET['jenis_telaah'];
$norsp = $_GET['norsp'];
$noidx = $_GET['noidx'];
$pelayanan = $_GET['ply'];
$status_user = $_POST['status_user'];
$tenagafarmasi = $_GET['tenagafarmasi'];
$statusprint = $_GET['statusprint'];
$statusloket = $_GET['statusloket'];
$idpasienrj = $_GET['idprj'];

$kodepuskesmas = $_SESSION['kodepuskesmas'];
$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;



// update waktu farmasi akhir
mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `FarmasiAkhir`=NOW() WHERE `NoRegistrasi` = '$norsp'");
//buat kondisi cetak etiket
if($statusprint == 'Etiket'){
	include "apotik_print_etiket.php";
}elseif($statusprint == 'Etiket64'){
	include "apotik_print_etiket64.php";
}elseif($statusprint == 'Resep dan Etiket'){
	include "apotik_print_resep_etiket.php";
}elseif($statusprint == 'ResepA5'){
	include "apotik_print_resep_a5.php";
}else{	
	include "apotik_print_resep_thermal.php";
}	
?>
	