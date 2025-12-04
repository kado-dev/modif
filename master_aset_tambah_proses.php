<?php
	$namabarang = strtoupper($_POST['namabarang']);
	$satuan = $_POST['satuan'];	
	
	// insert
	$str = "INSERT INTO `ref_aset`(`NamaBarang`,`Satuan`)VALUES('$namabarang','$satuan')";
	$query=mysqli_query($koneksi,$str);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=master_aset'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=master_aset_tambah';";
		echo "</script>";
	} 	
?>