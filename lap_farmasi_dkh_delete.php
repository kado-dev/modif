<?php
	$id = $_GET['iddkh'];

	$str = "DELETE FROM tbgudangpkmdkh WHERE `IdDkh` = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=lap_farmasi_dkh';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=lap_farmasi_dkh';";
		echo "</script>";
	} 	
?>