<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kota'];

// if($kota == "KABUPATEN BANDUNG"){
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_jkn` WHERE (`KodeObatJkn` LIKE'%$keyword%' OR `NamaObatJkn` LIKE'%$keyword%') ORDER BY `NamaObatJkn`");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['NamaObatJkn'],
				'namabarang' => $data['NamaObatJkn'],
				'kodebarang' => $data['KodeObatJkn']
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

	// $query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_jkn` WHERE `NamaObatJkn` LIKE'%$keyword%' ORDER BY `NamaObatJkn`");
	// while($data = mysqli_fetch_assoc($query))
	// {
		// $arr['suggestions'][] = array(
			// 'value'	=> $data['NamaObatJkn'],
			// 'namabarang' => $data['NamaObatJkn'],
			// 'kodebarang' => $data['KodeObatJkn']
		// );	
	// }
	// echo json_encode($arr);
// }
?>		
