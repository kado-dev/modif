<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kota'];

// jangan dirubah karena bogor gak support klo pake yg pertama
if($kota == "KABUPATEN BANDUNG"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);	

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ref_pbf` WHERE `SuplierName` LIKE '%$keyword%'");		
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['SuplierName']." | ".$data['alamat'],
				'idpbf' => $data['id_pbf'],
				'pbf'	=> $data['SuplierName']
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

	$query = mysqli_query($koneksi,"SELECT * FROM `ref_pbf` WHERE `SuplierName` LIKE '%$keyword%'");		
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'value'	=> $data['SuplierName']." | ".$data['alamat'],
			'idpbf' => $data['id_pbf'],
			'pbf'	=> $data['SuplierName']
		);	
	}
	echo json_encode($arr);
}	
?>		