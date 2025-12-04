<?php
session_start();
include "config/koneksi.php";
$bulan = date("m");
$tahun = date("Y");
$status = $_GET['status'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];

//delete tbstokbulananapotik
$delete_obat = mysqli_query($koneksi,"DELETE from `tbstokbulananapotik` where `Bulan` = '$bulan' AND `Tahun` = '$tahun' AND `KodePuskesmas` = '$kodepuskesmas'");

$str = ("SELECT * FROM `tbapotikstok` Where KodePuskesmas = '$kodepuskesmas'");
$query = (mysqli_query($koneksi,$str));

while($data = mysqli_fetch_assoc($query)){
	//insert tbstokbulananapotik
	$str_obat = "INSERT INTO `tbstokbulananapotik`(`Bulan`,`Tahun`,`KodePuskesmas`,`KodeBarang`,`Stok`)
	values  ('$bulan','$tahun','$kodepuskesmas','$data[KodeBarang]','$data[Stok]')";
	$data_obat = mysqli_query($koneksi,$str_obat);
}

	if($data_obat){
		echo "<script>";
		echo "alert('Data berhasil dieksport');";
		echo "document.location.href='index.php?page=apotik_stok&status=$status';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dieksport');";
		echo "document.location.href='index.php?page=apotik_stok&status=$status';";
		echo "</script>";
	}
?>