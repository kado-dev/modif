<?php
session_start();
include "config/koneksi.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$keyword= $_GET['keyword'];
if($keyword != ''){
	$query = mysqli_query($koneksi,"select * FROM `tbdiagnosabpjs` where Diagnosa LIKE'%$keyword%' OR KodeDiagnosa LIKE'%$keyword%' order by KodeDiagnosa");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'kode'	=> $data['KodeDiagnosa'],
			'diagnosa'	=> $data['Diagnosa'],
			'spesialis'	=> $data['NonSpesialis'],
			'value'	=> $data['KodeDiagnosa']." | ".$data['Diagnosa']
		);	
	}
	echo json_encode($arr);
}
?>		