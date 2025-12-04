<?php
session_start();
include "config/koneksi.php";
$kota = $_SESSION['kota'];

if($kota == "KABUPATEN BANDUNG"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ref_aset` WHERE `NamaBarang` LIKE'%$keyword%' ORDER BY `NamaBarang`");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['NamaBarang'],
				'namabarang' => $data['NamaBarang'],
				'idbarang' => $data['IdBarang'],
				'satuan' => $data['Satuan'],
				'kelompok' => $data['Kelompok']
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

	$query = mysqli_query($koneksi,"SELECT * FROM `ref_aset` WHERE `NamaBarang` LIKE'%$keyword%' ORDER BY `NamaBarang`");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=> $data['NamaBarang'],
			'namabarang' => $data['NamaBarang'],
			'idbarang' => $data['IdBarang'],
			'satuan' => $data['Satuan']
		);	
	}
	echo json_encode($arr);
}
?>		
