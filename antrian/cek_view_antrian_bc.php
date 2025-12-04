<?php
	//session_start();
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	
	$dispu = $_GET['dispu'];
	
	$data_antrian = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from tbantrian_view where KodePuskesmas = '$kodepuskesmas' AND Waktu != '$dispu'"));
	echo $data_antrian;
?>