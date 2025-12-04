<?php
session_start();
include "config/koneksi.php";
$kelurahan = $_POST['kelurahan'];

$query = mysqli_query($koneksi,"SELECT `KodePuskesmas` FROM `tbkelurahan` WHERE `Kelurahan` = '$kelurahan'");
if(mysqli_num_rows($query) > '0'){
	$data = mysqli_fetch_assoc($query);	
	if($_SESSION['kodepuskesmas'] == $data['KodePuskesmas']){
		$status = 'Dalam';
	}else{
		$status = 'Luar';
	}
}else{
	$status = 'Luar';
}
echo $status;
?>