<?php
	$namabarang = $_POST['namabarang'];
	// cek nama obat fornas, jika ada tampil warning message
	$cek_nm_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_pornas` WHERE `NamaObat` = '$namabarang'"));
	if($cek_nm_barang > 1){
		echo "<script>";
		echo "document.location.href='?page=master_obat_fornas_tambah&stsvalidasi=Data gagal tersimpan, Nama Barang sudah pernah dientrikan...';";
		echo "</script>";
		die();
	}	
	
	$str = "INSERT INTO `ref_pornas`(`NamaObat`) VALUES('$namabarang')";
	$query=mysqli_query($koneksi,$str);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_obat_fornas_tambah'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_obat_fornas_tambah';";
		echo "</script>";
	} 	
?>