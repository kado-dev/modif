<?php
	$kodebarang = $_POST['kodebarang'];
	$namabarang = strtoupper($_POST['namabarang']);
	$satuan = $_POST['satuan'];
	
	// ref_obat_lplpo
	$str1 = "UPDATE `ref_obat_lplpo` SET `Satuan`='$satuan' WHERE `KodeBarang`='$kodebarang'";
	$query = mysqli_query($koneksi,$str1);
	
	// tbgfkstok
	$str2 = "UPDATE `tbgfkstok` SET `Satuan`='$satuan' WHERE `KodeBarang`='$kodebarang'";
	mysqli_query($koneksi,$str2);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=master_obat_indikator';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=master_obat_indikator';";
		echo "</script>";
	} 	
?>