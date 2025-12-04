<?php
	$iddkh = $_POST['iddkh'];
	$katalog = $_POST['katalog'];
	$pabrikan = $_POST['pabrikan'];
	$keterangan = $_POST['keterangan'];
	$kodebarang = $_POST['kodebarang'];
	$namabarang = $_POST['namabarang'];
	$namabarangekatalog = $_POST['namabarangekatalog'];
	$sediaan = $_POST['sediaan'];
	$satuan = $_POST['satuan'];
	$minimalkadaluarsa = $_POST['bulankadaluarsa'];
	$kebutuhan = $_POST['kebutuhan'];
	$hargaekatalog = $_POST['hargaekatalog'];
	$totalhargaekatalog = $_POST['kebutuhan'] * $_POST['hargaekatalog'];
	$hargadpa = $_POST['hargadpa'];
	$totaldpa = $hargadpa * $kebutuhan;
	$totalefesiensi = $totaldpa - $totalhargaekatalog;
	$spesifikasi = $_POST['spesifikasi'];

	$str = "INSERT INTO `tbgudangpkmdkhdetail`(`IdDkh`,`KodeBarang`,`NamaBarang`,`Sediaan`,`NamaBarangEkatalog`,`Satuan`,`Pabrikan`,`MinimalKadaluarsa`,`Kebutuhan`,
	`HargaEkatalog`,`TotalHargaEkatalog`,`HargaDpa`,`TotalDpa`,`TotalEfesiensi`,`Katalog`,`Spesifikasi`)
	VALUES ('$iddkh','$kodebarang','$namabarang','$sediaan','$namabarangekatalog','$satuan','$pabrikan','$minimalkadaluarsa','$kebutuhan','$hargaekatalog',
	'$totalhargaekatalog','$hargadpa','$totaldpa','$totalefesiensi','$katalog','$spesifikasi')";
	$query=mysqli_query($koneksi,$str);	
	// echo $str;
	// die();
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=lap_farmasi_dkh_detail&iddkh=$iddkh';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=lap_farmasi_dkh_detail&iddkh=$iddkh';";
		echo "</script>";
	} 	
?>	