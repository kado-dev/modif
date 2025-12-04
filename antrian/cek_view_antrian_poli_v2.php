<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
	//session_start();
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	$waktu = $_GET['time'];
	$kodepel = $_GET['kodepel'];

	$data_antrian = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbantrian_pelayanan where KodePuskesmas = '$kodepuskesmas' AND KodePelayanan = '$kodepel' AND Waktu != '$waktu'"));

	echo "data:".$data_antrian."\n\n";

	flush();	
?>