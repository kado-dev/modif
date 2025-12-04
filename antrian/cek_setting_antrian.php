<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
	//session_start();
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	
	$waktu = $_GET['waktu'];
	
	$data_set_antrian = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbantrian_setting where KodePuskesmas = '$kodepuskesmas' AND Waktu != '$waktu'"));
	//echo $data_antrian;
	
	echo "data:".$data_set_antrian."\n\n";

	flush();	
?>