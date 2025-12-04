<?php
session_start();
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kodepuskesmas'];

if($kota == "KABUPATEN BANDUNG"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include "config/koneksi.php";

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmstok` WHERE (`NamaBarang` LIKE '%$keyword%' OR `KodeBarang` LIKE '%$keyword%' OR `NoBatch` LIKE '%$keyword%') AND KodePuskesmas='$kodepuskesmas'");
		while($data = mysqli_fetch_assoc($query)){	
			$arr['suggestions'][] = array(
				'value'	=> $data['KodeBarang']." | ".$data['NamaBarang'],
				'namabarang'	=> $data['NamaBarang'],
				'kodebarang' => $data['KodeBarang'],
				'satuan' => $data['Satuan'],
				'stok' => $get_stok['Stok'],
				'hargabeli' => $data['HargaBeli'],
				'expire' => $data['Expire'],
				'nobatch' => $data['NoBatch']
			);	
		}
		echo json_encode($arr);
	}	
}else{
	session_start();
	include "config/koneksi.php";
	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
	
	$keyword = $segments[3];
	$query = mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmstok` WHERE (`NamaBarang` LIKE '%$keyword%' OR `KodeBarang` LIKE '%$keyword%' OR `NoBatch` LIKE '%$keyword%') AND `KodePuskesmas`='$kodepuskesmas' ORDER by NamaBarang");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=> $data['KodeBarang']." | ".$data['NamaBarang']." | ".$data['SumberAnggaran'],
			'namabarang'	=> $data['NamaBarang'],
			'kodebarang' => $data['KodeBarang'],
			'nobatch' => $data['NoBatch'],
			'stok' => $data['Stok'],
			'expire' => $data['Expire']			
		);	
	}
	echo json_encode($arr);
}	
?>		