<?php
	session_start();
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$pinsessionpegawai = $_SESSION['pinsessionpegawai'];
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	$noreg = $_POST['noreg'];
	$pin = $_POST['pin'];
	$str = "UPDATE `$tbpasienperpegawai` SET `TtePin` = '$pin' WHERE `NoRegistrasi` = '$noreg'";
	// echo $str;
	// die();

	if(md5($pin) != $pinsessionpegawai){
		echo "gagal, pin tidak valid";
		die();
	}

	$query = mysqli_query($koneksi, $str);
	if($query){
		echo 'sukses';
	}else{
		echo 'gagal';
	}
?>
