<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$nik = $_POST['nik'];
	$idpasien = $_POST['idpasien'];
	$str = "UPDATE $tbpasien SET `Nik` = '$nik' WHERE `IdPasien` = '$idpasien'";
	mysqli_query($koneksi,$str);
?>