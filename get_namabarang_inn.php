<?php
session_start();
include "config/koneksi.php";
$kode_puskesmas = $_SESSION['kodepuskesmas'];	
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];

		$query = mysqli_query($koneksi,"select * from `ref_obatgenerik` where `generik_object` LIKE'%$keyword%' order by `generik_object`");

		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=> $data['generik_object'],
				'kodebaranginn'	=> $data['id']
			);	
		}
		echo json_encode($arr);
?>		