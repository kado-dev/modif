<?php
	$kd = $_POST['kodebarang'];
	$batch = $_POST['nobatch'];	
	$nofakturterima = $_POST['nofkterima'];	
	$stok = $_POST['sisastok'];	
	$namaprogram = $_POST['namaprogram'];
	
	// stok
	$str1 = "UPDATE `tbgfkstok` SET `Stok`='$stok' WHERE `KodeBarang`='$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofakturterima'";
	$query=mysqli_query($koneksi, $str1);
	
	// program
	$str2 = "UPDATE `tbgfkstok` SET `NamaProgram`='$namaprogram' WHERE `KodeBarang`='$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofakturterima'";
	mysqli_query($koneksi,$str2);
	$str3 = "UPDATE `tbgfkpengeluarandetail` SET `NamaProgram`='$namaprogram' WHERE `KodeBarang`='$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofakturterima'";
	mysqli_query($koneksi,$str3);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diupdate...');";
		echo "document.location.href='index.php?page=gudang_besar_stok_detail&kd=$kd&batch=$batch';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate...');";
		echo "document.location.href='index.php?page=gudang_besar_stok_detail&kd=$kd&batch=$batch';";
		echo "</script>";
	} 	
?>