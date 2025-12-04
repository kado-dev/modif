<?php
	// header('Content-Type: text/event-stream');
	// header('Cache-Control: no-cache');

	//session_start();
	include "../config/koneksi.php";
	//include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	//$puskesmas = $_COOKIE['namapuskesmas2'];
	
	//$dispu = date("Y-m-d G:i:s", $_GET['dispu']);
	$dispu =$_GET['dispu'];
	$lantai =$_GET['lantai'];
	$data_antrian = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from `tbantrian_view1` where KodePuskesmas = '$kodepuskesmas' AND Lantai = '$lantai' AND Waktu != '$dispu'"));
	
	// echo "data:".$data_antrian."\n\n";
	// flush();	

	echo $data_antrian;
?>