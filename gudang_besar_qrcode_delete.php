<?php
	//$sts = 1;
	$id =  $_GET['id'];

	$str = "DELETE From `tbqrcode` where IdSiswa = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='index.php?page=gudang_besar_qrcode';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='index.php?page=gudang_besar_qrcode';";
		echo "</script>";
	} 	
?>