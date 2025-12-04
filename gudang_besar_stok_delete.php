<?php
	// tbgfkstok
	$id = $_GET['id'];
	$str = "DELETE FROM `tbgfkstok` WHERE `IdBarang`='$id'";
	$query=mysqli_query($koneksi,$str);
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_besar_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_besar_stok';";
		echo "</script>";
	} 	
?>