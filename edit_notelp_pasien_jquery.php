<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$notelp = $_POST['notelp'];
	$noindex = $_POST['noindex'];
	$str = "UPDATE `$tbkk` SET `Telepon` = '$notelp' WHERE `NoIndex` = '$noindex'";
	mysqli_query($koneksi,$str);
	//echo $str;
?>