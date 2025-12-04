<?php
session_start();
include "config/koneksi.php";
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[2];
		$query = mysqli_query($koneksi,"select * from `ref_kabupaten` where `CKabDescr` LIKE '%$keyword%'");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['CKabDescr'],
				'kodekota'	=> $data['CKabID'],
				'kota'	=> $data['CKabDescr']
			);	
		}
		echo json_encode($arr);
?>		