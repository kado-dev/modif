<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kota'];

// if($kota == "KABUPATEN BANDUNG"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$keyword= $_GET['keyword'];
	if($keyword != ''){
		$query = mysqli_query($koneksi,"SELECT * FROM `ref_pabrik` WHERE `nama_prod_obat` LIKE '%$keyword%'");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['nama_prod_obat'],
				'id' => $data['id'],
				'nama_prod_obat' => $data['nama_prod_obat']
			);	
		}
		echo json_encode($arr);
	}
// }else{
	// $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	// $segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

	// $keyword = $segments[3];
	// $query = mysqli_query($koneksi,"select * from `ref_pabrik` WHERE `nama_prod_obat` LIKE'%$keyword%'");
	// while($data = mysqli_fetch_assoc($query))
	// {
		// $arr['suggestions'][] = array(
			// 'value'	=> $data['nama_prod_obat'],
			// 'id' => $data['id'],
			// 'nama_prod_obat'	=> $data['nama_prod_obat']
		// );
	// }
	// echo json_encode($arr);
// }	
?>		
	