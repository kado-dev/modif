<?php
	$nocm = $_GET['nocm'];
	$status = $_GET['status'];
	
	$strupdatenokunjungan = "UPDATE `tbpinjambuku` SET `StatusBuku`= '$status' WHERE `NoCM` = '$nocm'";
	mysqli_query($koneksi,$strupdatenokunjungan);
	echo "<script>";
	echo "alert('Data berhasil diproses');";
	echo "document.location.href='index.php?page=rekam_medis_data';";
	echo "</script>";
?>