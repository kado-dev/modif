<?php
session_start();
include "config/koneksi.php";
include "config/helper.php";
$noreg = $_GET['noreg'];
$pel = $_GET['pel'];
$str = "DELETE FROM `tbtindakanpasien` WHERE `NoRegistrasi` = '$noreg'";

	
$query = mysqli_query($koneksi,$str);
if($query ){
	mysqli_query($koneksi,"DELETE FROM `tbtindakanpasiendetail` WHERE `NoRegistrasi` = '$noreg'");
}

echo "<script>";
	echo "alert('Data berhasil dihapus...');";
	echo "document.location.href='index.php?page=poli_periksa_edit&no=".$noreg."&pelayanan=".$pel."';";
	echo "</script>";
?>