<?php
session_start();
include "config/koneksi.php";
$status = $_GET['status'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$query = (mysqli_query($koneksi,"SELECT * FROM `tbgudangpkmstok` Where KodePuskesmas = '$kodepuskesmas'"));
while($data = mysqli_fetch_assoc($query)){
	$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbapotikstok` Where KodePuskesmas = '$kodepuskesmas' AND KodeBarang = '$data[KodeBarang]'"));
	if($cek == 0){
		$html[]="('$kodepuskesmas','$data[KodeBarang]','$data[Stok]','LOKET OBAT')";
	}
}
	$val = implode(",",$html);
	$str = "REPLACE INTO `tbapotikstok`(`KodePuskesmas`, `KodeBarang`, `Stok`, `StatusBarang`) values ".$val.";";
	
	$q = mysqli_query($koneksi,$str);
	if($q){
		echo "<script>";
		echo "alert('Data berhasil diimport');";
		echo "document.location.href='index.php?page=apotik_stok&status=$status';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diimport');";
		echo "document.location.href='index.php?page=apotik_stok&status=$status';";
		echo "</script>";
	}
?>