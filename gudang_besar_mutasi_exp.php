<?php
session_start();
include "config/koneksi.php";
	$str = "SELECT * FROM `tbgfkstok` where Expire <= curdate()";

	$query = mysqli_query($koneksi,$str);
	while($data = mysqli_fetch_assoc($query)){
		$query_insert[] = "('$data[KodeBarang]','$data[Stok]','Expire')"; 
	}

	$str_insert = "INSERT INTO `tbgfkstok_karantina`(`KodeBarang`, `Jumlah`, `Keterangan`) VALUES ".implode(",",$query_insert).";";	
	$insert = mysqli_query($koneksi,$str_insert);
	if($insert){
		mysqli_query($koneksi,"DELETE from tbgfkstok where Expire <= curdate()");
	}
	header('location:index.php?page=gudang_besar_stok');
?>