<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$namapsn = $_POST['namapsn'];
	$idpasien = $_POST['idpasien'];

	$str = "UPDATE $tbpasien SET NamaPasien = '$namapsn' where IdPasien = '$idpasien'";
	
	mysqli_query($koneksi,$str);
?>