<?php
session_start();
include "config/koneksi.php";
// include "config/helper_bpjs.php";
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

$keyword = $segments[3];

		$query = mysqli_query($koneksi,"select * from `tbdiagnosabpjs` where (Diagnosa LIKE'%$keyword%' OR KodeDiagnosa LIKE'%$keyword%') AND `NonSpesialis`='true' order by KodeDiagnosa");
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
?>		