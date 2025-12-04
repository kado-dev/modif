<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
	//session_start();
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	$waktu = $_GET['time'];

	$data_antrian = mysqli_query($koneksi,"SELECT * from tbantrian_pelayanan where KodePuskesmas = '$kodepuskesmas'");
	while($dt = mysqli_fetch_assoc($data_antrian)){
		$key = str_replace(" ", "_", $dt['Pelayanan']);
		$data[$key] = $dt['Display']."|".$dt['Waktu'];
	}

	// $data['PoliMtbs'] = $data_antrian['PoliMtbs']."|".$data_antrian['Waktu'];
	// $data['PoliGigi'] = $data_antrian['PoliGigi']."|".$data_antrian['Waktu'];
	// $data['PoliLansia'] = $data_antrian['PoliLansia']."|".$data_antrian['Waktu'];
	// $data['PoliUmum'] = $data_antrian['PoliUmum']."|".$data_antrian['Waktu'];
	// $data['PoliKia'] = $data_antrian['PoliKia']."|".$data_antrian['Waktu'];
	// $data['PoliImunisasi'] = $data_antrian['PoliImunisasi']."|".$data_antrian['Waktu'];
	
	echo "data:".json_encode($data)."\n\n";

	flush();	
?>