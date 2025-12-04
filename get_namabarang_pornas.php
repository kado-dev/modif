<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kota'];

// if($kota == "KABUPATEN BANDUNG"){
	session_start();
	include "config/koneksi.php";	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ref_pornas` WHERE `NamaObat` LIKE'%$keyword%' ORDER BY `NamaObat`");
		while($data = mysqli_fetch_assoc($query))
		{

			$arr['suggestions'][] = array(
				'value'	=> $data['NamaObat'],
				'namaobat'	=> $data['NamaObat']
			);	
		}
		echo json_encode($arr);
	}
// }else{	
	// session_start();
	// include "config/koneksi.php";
	// $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	// $segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
	// $keyword = $segments[3];
	// $query = mysqli_query($koneksi,"SELECT * FROM `ref_pornas` WHERE `NamaObat` LIKE'%$keyword%' ORDER BY `NamaObat`");
	// while($data = mysqli_fetch_assoc($query))
	// {

		// $arr['suggestions'][] = array(
			// 'value'	=> $data['NamaObat'],
			// 'namaobat'	=> $data['NamaObat']
		// );	
	// }
	// echo json_encode($arr);
// }	

?>		