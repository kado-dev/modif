<?php
session_start();
$kdpuskesmas = $_SESSION['kodepuskesmas'];
include "config/koneksi.php";
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];
//echo $keyword;
		$query = mysqli_query($koneksi,"select * from `tbpegawai` where NamaPegawai LIKE'%$keyword%' AND KodePuskesmas = '$kdpuskesmas'");
		while($data = mysqli_fetch_assoc($query))
		{
			$arr['suggestions'][] = array(
				'value'	=>$data['NamaPegawai']
			);	
		}
		echo json_encode($arr);
?>		