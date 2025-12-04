<?php		
$nomorpembukuan = $_POST['nomorpembukuan'];
$kodebarang = $_POST['kodebarang'];	
$namabarang = $_POST['namabarang'];
$id_generik = $_POST['kodebaranginn'];
$produsen = "DINAS KESEHATAN PROVINSI";
$isikemasan = $_POST['isikemasan'];
if($isikemasan == ''){
	$isikemasan = 0;
}else{
	$isikemasan = $_POST['isikemasan'];
}
$kemasan = $_POST['kemasan'];
$satuan = $_POST['satuan'];
$golonganfungsi = $_POST['golonganfungsi'];
$namaprogram = $_POST['namaprogram'];	
$jenisbarang = "VAKSIN";
$ruangan = $_POST['ruangan'];
$rak = $_POST['rak'];
$minimalstok = $_POST['minimalstok'];
if($minimalstok == ''){
	$minimalstok = 0;
}else{
	$minimalstok = $_POST['minimalstok'];
}
$hargabeli = $_POST['hargabeli'];
$barcode = $_POST['barcode'];
$nobatch = $_POST['nobatch'];
$expire = date('Y-m-d', strtotime($_POST['expire']));
$sumberanggaran = $_POST['sumberanggaran'];
$tahunanggaran = $_POST['tahunanggaran'];	
$namapegawaisimpan = $_SESSION['username'];
$jumlah = $_POST['jumlah'];	
$tglpenerimaan = $_POST['tglpenerimaan'];		
$subtotal = $hargabeli * $jumlah;
if($subtotal == ''){
	$subtotal = 0;
}else{
	$subtotal = $hargabeli * $jumlah;
}
$totallama = $_POST['totallama'];
$grandtotal = $subtotal + $totallama;
$id = $_POST['id'];	

// Tahap 1, cek batch sama
	$cek_batch_sama = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang` = '$kodebarang' AND NoBatch ='$nobatch'"));
	if($cek_batch_sama > 0){
		$nobatch = $nobatch.substr($nomorpembukuan, -4);
	}

// Tahap 2, cek jika nama obat tidak ada dalam database vaksin
	$cek1 = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` = '$namabarang'"));
	if($cek1 == 0){
		echo "<script>";
		echo "document.location.href='?page=gudang_vaksin_penerimaan_lihat&stsvalidasi=Data gagal disimpan, Nama Barang tidak terdaftar di Database LPLPO...';";
		echo "</script>";
		die();
	}	
	
// Tahap 3, cek barang sama dalam satu faktur
	$cek2 = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `tbgfk_vaksin_penerimaandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$nomorpembukuan'"));
	if($cek2 > 0){
		echo "<script>";
		echo "document.location.href='?page=gudang_vaksin_penerimaan_lihat&id=$nomorpembukuan&stsvalidasi=Data gagal disimpan, Nama Barang sudah diinputkan pada faktur ini...';";
		echo "</script>";
		die();
	}	

// Tahap 4, cek barang sama (kodebarang dan batch), jika ditemukan maka akan menambahkan jumlah barangnya
	$cekbatch = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang`,`Stok`,`NoFakturTerima` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nomorpembukuan'"));
	if($cekbatch > 0){
		// tambah stok gudang vaksin
		$stokbaru = $cekbatch['Stok'] + $jumlah;
		$str_gfkstok = "UPDATE `tbgfk_vaksin_stok` SET `Stok`= '$stokbaru' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
		$query = mysqli_query($koneksi, $str_gfkstok);
	}else{
		// insert tbgfk_vaksin_stok
		$str = "INSERT INTO `tbgfk_vaksin_stok`(`KodeBarang`,`NamaBarang`,`IsiKemasan`,`Kemasan`,`Satuan`,`GolonganFungsi`,`NamaProgram`,`JenisBarang`,
		`Ruangan`,`Rak`,`Stok`,`MinimalStok`, `HargaBeli`,`Barcode`,`NoBatch`,`Expire`,`SumberAnggaran`,`TahunAnggaran`,`Produsen`,`Keterangan`,`NoFakturTerima`,`NamaPegawaiSimpan`)
		VALUES('$kodebarang','$namabarang','$isikemasan','$kemasan','$satuan','$golonganfungsi','$namaprogram','$jenisbarang','$ruangan','$rak','$jumlah',
		'$minimalstok','$hargabeli','$barcode','$nobatch','$expire','$sumberanggaran','$tahunanggaran','$produsen','Dinas','$nomorpembukuan ','$namapegawaisimpan')";
		$query = mysqli_query($koneksi,$str);	
	}	

// tbgfk_vaksin_penerimaandetail
	$strpenerimaan = "INSERT INTO `tbgfk_vaksin_penerimaandetail`(`NomorPembukuan`,`IdProdusen`,`KodeBarang`,`NoBatch`,`Expire`,`Harga`,`Jumlah`,`SubTotal`)
	VALUES ('$nomorpembukuan','0','$kodebarang','$nobatch','$expire','$hargabeli','$jumlah','$subtotal')";
	mysqli_query($koneksi,$strpenerimaan);
	
// update grand total tbgfk_vaksin_penerimaan
	mysqli_query($koneksi,"UPDATE `tbgfk_vaksin_penerimaan` SET `GrandTotal`='$grandtotal' WHERE `NomorPembukuan`='$nomorpembukuan'");	

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_vaksin_penerimaan_lihat&id=$nomorpembukuan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_vaksin_penerimaan_lihat&id=$nomorpembukuan';";
	echo "</script>";
} 
?>