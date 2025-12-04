<?php
	$nama_supplier =  strtoupper($_POST['nama_supplier']);
	$alamat =  $_POST['alamat'];
		
	$str = "INSERT INTO `ref_pabrik`(`nama_prod_obat`,`alamat`)
	VALUES('$nama_supplier','$alamat')";
	$query=mysqli_query($koneksi,$str);
		
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_supplier';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_supplier_tambah';";
		echo "</script>";
	} 	
?>