<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$kodeppk = $_SESSION['kodeppk'];
	$nobpjs = $_POST['nobpjs'];
	$nocm = $_POST['nocm'];
	
	// tbpasien
	$str = "UPDATE $tbpasien SET `Asuransi` = 'BPJS PBI', `StatusAsuransi` = 'PESERTA', `NoAsuransi` = '$nobpjs', `kdprovider` = '$kodeppk' WHERE `NoCM` = '$nocm'";
	mysqli_query($koneksi,$str);
	echo $kodeppk;
?>