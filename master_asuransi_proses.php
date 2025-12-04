<?php
	$asuransi = strtoupper($_POST['asuransi']);
	$kota = $_SESSION['kota'];
	
	$str = "INSERT INTO `tbasuransi`(`Asuransi`, `Kota`) VALUES ('$asuransi','$kota')";
	$query=mysqli_query($koneksi,$str);
		
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_asuransi';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_asuransi';";
		echo "</script>";
	} 	
?>