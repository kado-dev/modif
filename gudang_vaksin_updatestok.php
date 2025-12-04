<?php
	$id = $_POST['id'];
	$kd = $_POST['kodebarang'];
	$batch = $_POST['nobatch'];	
	$nofakturterima = $_POST['nofakturterima'];	
	$stok = $_POST['sisastok'];	
	$namaprogram = $_POST['namaprogram'];
	
	// stok
	$str1 = "UPDATE `tbgfk_vaksin_stok` SET `Stok`='$stok' WHERE `KodeBarang`='$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofakturterima'";
	$query=mysqli_query($koneksi,$str1);
	
	// program
	$str2 = "UPDATE `tbgfk_vaksin_stok` SET `NamaProgram`='$namaprogram' WHERE `KodeBarang`='$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofakturterima'";
	mysqli_query($koneksi,$str2);
	$str3 = "UPDATE `tbgfk_vaksin_pengeluarandetail` SET `NamaProgram`='$namaprogram' WHERE `KodeBarang`='$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofakturterima'";
	mysqli_query($koneksi,$str3);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diupdate...');";
		echo "document.location.href='index.php?page=gudang_vaksin_stok_detail&id=$kd&batch=$batch';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate...');";
		echo "document.location.href='index.php?page=gudang_vaksin_stok_detail&id=$kd&batch=$batch';";
		echo "</script>";
	} 	
?>