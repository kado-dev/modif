<?php
$id = $_GET['id'];

	$str = "DELETE FROM `tbgudanguptdstok` Where `KodeBarang` = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	//jangan  diaktifkan karena ketika puskesmas ngedelete digudang dinas hilang
	// $str_gfkstok = "DELETE FROM `tbgfkstok` Where `KodeBarang` = '$id'";
	// $query_gfkstok=mysqli_query($koneksi,$str_gfkstok);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=uptd_gudang_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=uptd_gudang_stok';";
		echo "</script>";
	} 	
?>