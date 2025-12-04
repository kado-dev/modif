<?php
$id = $_GET['id'];

	$str = "DELETE FROM tbasuransi Where `KodeAsuransi` = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=master_asuransi';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=master_asuransi';";
		echo "</script>";
	} 	
?>