<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_satusehat.php";

	$nik = $_POST['nik'];
	$idpegawai = $_POST['idpegawai'];

	$stsehat_access_token = $_SESSION['stsehat_access_token'];
	$getDTPractitioner 	= get_Practitioner($stsehat_access_token,$nik);	
	$IdPractitioner		= $getDTPractitioner['IdPractitioner'];

	$str = "UPDATE `tbpegawai` SET `Nik`='$nik', `IdPractitioner`='$IdPractitioner' WHERE `IdPegawai` = '$idpegawai'";
	// UPDATE `tbpegawai` SET `Nik` = '$nik', `IdPractitioner` = '$IdPractitioner' WHERE `IdPegawai` = '$idpegawai'";
	mysqli_query($koneksi,$str);

	echo $IdPractitioner;
?>