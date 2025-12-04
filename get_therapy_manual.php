<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kota'];

if($kota == "KABUPATEN BANDUNG"){
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include "config/koneksi.php";

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi, "SELECT KodePuskesmas, KodeBarang, NoBatch, KodeBarangBpjs, NamaBarang, Stok FROM `tbapotikstok` WHERE `NamaBarang` LIKE'%$keyword%' and `KodePuskesmas` = '$KodePuskesmas' and `Stok` > '0' and `StatusBarang` = 'LOKET OBAT'");
		// var_dump(mysqli_fetch_assoc($query));
		// die();
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
}else{
	session_start();
	include "config/koneksi.php";
	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
	
	$keyword = $segments[4];
	$poli = str_replace("-"," ",$segments[3]);
	//echo $keyword;

	// join dengan tbgfkstok, untuk mengambil sumberanggaran
	if ($poli == 'POLI LANSIA'){
		if($kota == "KABUPATEN BULUNGAN"){
			$str = "SELECT KodePuskesmas, KodeBarang, NoBatch, NamaBarang, Stok 
			FROM `tbapotikstok` WHERE `NamaBarang` Like'%$keyword%' and `KodePuskesmas` = '$kodepuskesmas' and `Stok` > '0' and
			`StatusBarang` = '$poli'";
		}else{
			$str = "SELECT KodePuskesmas, KodeBarang, NoBatch, NamaBarang, Stok 
			FROM `tbapotikstok` WHERE `NamaBarang` Like'%$keyword%' and `KodePuskesmas` = '$kodepuskesmas' and `Stok` > '0' and 
			`StatusBarang` = 'LOKET OBAT'";
		}	
	}else{
		$str = "SELECT KodePuskesmas, KodeBarang, NoBatch, NamaBarang, Stok 
		FROM `tbapotikstok` WHERE `NamaBarang` Like'%$keyword%' and `KodePuskesmas` = '$kodepuskesmas' and `Stok` > '0' and 
		`StatusBarang` = 'LOKET OBAT'";
	}		
		
	$query = mysqli_query($koneksi,$str);
	while($data=mysqli_fetch_assoc($query)){
		$arr['suggestions'][] = array(
			'kodeobatlokal'	=> $data['KodeBarang'],
			'nobatch'	=> $data['NoBatch'],
			'kodeobatbpjs'	=> $data['KodeBarangBpjs'],
			'namaobatbpjs'	=> $data['NamaBarang'],
			'sediaobatbpjs'	=> $data['Stok'],
			'value'	=> $data['NamaBarang']." | Batch : ".$data['NoBatch']." | Stok : ".$data['Stok']
		);
	}
	echo json_encode($arr);
}		
?>		