<?php
	$id = $_GET['id'];
	$str = "DELETE FROM `ref_rumahsakit` WHERE `IdRs` = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=master_rumahsakit';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=master_rumahsakit';";
		echo "</script>";
	} 	
?>