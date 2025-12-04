<?php
	$tanggalupdate = date(('Y-m-d'), strtotime($_POST['tanggalupdate']))." ".date('G:i:s');
	$judul = strtoupper($_POST['judul']);
	$deskripsi = strtoupper($_POST['deskripsi']);
	$kategori = $_POST['kategori'];
	$versi = $_POST['versi'];
	
	// tahap1, insert tbupdatesimpus
	$str = "INSERT INTO `tbupdatesimpus`(`TanggalUpdate`, `Judul`, `Deskripsi`, `Kategori`, `Versi`)
	VALUES ('$tanggalupdate','$judul','$deskripsi','$kategori','$versi')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=adm_update_simpus';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=adm_update_simpus';";
		echo "</script>";
	} 	
?>