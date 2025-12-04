<?php		
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$idpengadaan = $_POST['idpengadaan'];	
$nofaktur = $_POST['nofaktur'];	
$idbarang = $_POST['idaset'];
$namabarang = $_POST['namabarang'];
$satuan = $_POST['satuan'];
$jumlah = $_POST['jumlah'];
$hargasatuan = $_POST['hargasatuan'];	
$tahunanggaran = $_POST['tahunanggaran'];	
$sumberanggaran = $_POST['sumberanggaran'];	
$kelompok = $_POST['kelompok'];	

// tahap1, cek barang sama dalam 1 faktur
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoFaktur` FROM `tbasetpengadaandetail` WHERE `IdBarang` = '$idbarang' AND `NoFaktur` = '$nofaktur'"));
if($cekobat > 0){
	echo "<script>";
	echo "document.location.href='index.php?page=aset_pengadaan_lihat&id=$idpengadaan&sts=2';";
	echo "</script>";
	die();
}

// tahap2, cek kode barang jika tidak ada insert
$cekbarang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbasetstok` WHERE `IdAset` = '$idbarang' AND KodePuskesmas = '$kodepuskesmas'"));
if ($cekbarang == 0){
	$str1 = "INSERT INTO `tbasetstok`(`KodePuskesmas`,`IdAset`,`NamaBarang`,`Satuan`,`HargaSatuan`,`SumberAnggaran`,`TahunAnggaran`,`Stok`,`Kelompok`)
	VALUES ('$kodepuskesmas','$idbarang','$namabarang','$satuan','$hargasatuan','$sumberanggaran','$tahunanggaran','$jumlah','$kelompok')";
	mysqli_query($koneksi,$str1);
}else{
	$stok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `tbasetstok` WHERE `IdAset` = '$idbarang' AND KodePuskesmas = '$kodepuskesmas'"));
	$stoktambah = $stok['Stok'] + $jumlah;
	$strstok = "UPDATE `tbasetstok` SET `Stok`='$stoktambah' WHERE `IdAset`='$idbarang' AND KodePuskesmas = '$kodepuskesmas'";
	mysqli_query($koneksi,$strstok);
}

// tahap3, insert tbasetpengadaandetail
$str = "INSERT INTO `tbasetpengadaandetail`(`NoFaktur`,`KodePuskesmas`,`IdBarang`,`Jumlah`,`HargaBeli`)
		VALUES ('$nofaktur','$kodepuskesmas','$idbarang','$jumlah','$hargasatuan')";
$query = mysqli_query($koneksi,$str);
	
if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=aset_pengadaan_lihat&id=$idpengadaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=aset_pengadaan_lihat&id=$idpengadaan';";
	echo "</script>";
} 
?>