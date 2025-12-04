<?php
session_start();
include "config/koneksi.php";
$kota = $_SESSION['kota'];

// if($kota == "KABUPATEN BANDUNG"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_lplpo` where `NamaBarang` LIKE'%$keyword%' ORDER BY `NamaBarang`");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['NamaBarang'],
				'namavaksin'	=> $data['NamaBarang'],
				'kodevaksin'	=> $data['KodeBarang']
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

	// $query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_lplpo` where `NamaBarang` LIKE'%$keyword%' ORDER BY `NamaBarang`");
	// while($data = mysqli_fetch_assoc($query))
	// {
		// $arr['suggestions'][] = array(
			// 'value'	=> $data['NamaBarang'],
			// 'namavaksin'	=> $data['NamaBarang'],
			// 'kodevaksin'	=> $data['KodeBarang']
		// );	
	// }
	// echo json_encode($arr);
// }

	

?>		
