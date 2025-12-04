<?php
session_start();
include "config/koneksi.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$keyword= $_GET['keyword'];
if($keyword != ''){
	$query = mysqli_query($koneksi,"SELECT * FROM `tbdiagnosakeperawatan` WHERE `NamaDiagnosa` LIKE'%$keyword%' OR KodeDiagnosa LIKE'%$keyword%' ORDER BY NamaDiagnosa");
	while($data = mysqli_fetch_assoc($query))
	{
		$arr['suggestions'][] = array(
			'kodeaskep'	=> $data['KodeDiagnosa'],
			'diagnosaaskep'	=> strtoupper($data['NamaDiagnosa']),
			'value'	=> $data['NamaDiagnosa']
		);	
	}
	echo json_encode($arr);
}
?>		