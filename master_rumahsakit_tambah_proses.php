<?php
	$namars =  strtoupper($_POST['namars']);
		
	$str = "INSERT INTO `ref_rumahsakit`(`NamaRs`)
	VALUES('$namars')";
	$query=mysqli_query($koneksi,$str);
		
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_rumahsakit';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_rumahsakit_tambah';";
		echo "</script>";
	} 	
?>