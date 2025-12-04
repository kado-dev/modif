<?php
session_start();
include "config/koneksi.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbapotikstok = "tbapotikstok_".str_replace(' ', '', strtoupper($namapuskesmas));
$keyword = $_GET['keyword'];
if($keyword != ''){
	$query = mysqli_query($koneksi, "SELECT KodeBarang, NoBatch, KodeBarangBpjs, NamaBarang, Stok FROM `$tbapotikstok` WHERE `NamaBarang` LIKE '%$keyword%' and `Stok` > '0' and `StatusBarang` = 'LOKET OBAT'");
	while($data=mysqli_fetch_assoc($query)){
		$arr['suggestions'][] = array(
			'kodeobatlokal'	=> $data['KodeBarang'],
			'nobatch'	=> $data['NoBatch'],
			'kodeobatbpjs'	=> $data['KodeBarangBpjs'],
			'namaobatbpjs'	=> $data['NamaBarang'],
			'sediaobatbpjs'	=> $data['Stok'],
			'value'	=> $data['KodeBarang']." | ".$data['NamaBarang']." | Stok : ".$data['Stok']
		);
	}
	echo json_encode($arr);
}
?>