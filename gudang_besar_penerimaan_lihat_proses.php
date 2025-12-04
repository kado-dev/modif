<?php		
$nomorpembukuan = $_POST['nomorpembukuan'];
$kodebarang = $_POST['kodebarang'];	
$kodeelog = $_POST['kodeelog'];	
$idindikator = $_POST['idindikator'];	
$idketersediaan = $_POST['idketersediaan'];	
$namabarang = $_POST['namabarang'];
$namatambahan = $_POST['namatambahan'];	
$produsen = $_POST['produsen'];
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
$jenisbarang = $_POST['jenisbarang']; // generik dan non generik
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
$statusanggaran = $_POST['statusanggaran'];	
$namapegawaisimpan = $_SESSION['username'];
$jumlah = $_POST['jumlah'];			
$subtotal = $hargabeli * $jumlah;
if($subtotal == ''){
	$subtotal = 0;
}else{
	$subtotal = $hargabeli * $jumlah;
}
$totallama = $_POST['totallama'];
$grandtotal = $subtotal + $totallama;

// Tahap 1, cek batch sama
	$cek_batch_sama = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang' AND NoBatch ='$nobatch'"));
	if($cek_batch_sama > 0){
		$nobatch = $nobatch.substr($nomorpembukuan, -4);
	}

// Tahap 2, cek id program
	$dtprogram = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_obatprogram` WHERE `nama_program`='$namaprogram'"));
	$idprogram = $dtprogram['id_program'];	

// Tahap 3, cek jika nama obat tidak ada dalam database lplpo
	$cek_nm_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` like '%$namabarang%'"));
	if($cek_nm_barang == 0){
		echo "<script>";
		echo "alert('Data gagal disimpan, Nama Barang tidak terdaftar di Database LPLPO...');";
		echo "document.location.href='index.php?page=gudang_besar_penerimaan_lihat&id=$nomorpembukuan';";
		echo "</script>";
		die();
	}	

// Tahap 4, cek barang sama (kodebarang dan batch), jika ditemukan maka akan menambahkan jumlah barangnya
	$cekbatch = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang`,`NoBatch`,`NoFakturTerima` FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nomorpembukuan'"));
	if($cekbatch > 0){
		// tambah stok gudang besar
		$stok_gb = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
		$stok_gb_tambah = $stok_gb['Stok'] + $jumlah;
		$str_gfkstok = "UPDATE `tbgfkstok` SET `Stok`= '$stok_gb_tambah' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
		mysqli_query($koneksi, $str_gfkstok);
	}else{
		// insert tbgfkstok
		$str = "INSERT INTO `tbgfkstok`(`KodeBarang`,`id_indikator`,`NamaBarang`,`NamaTambahan`,`IsiKemasan`,`Kemasan`,`Satuan`,`GolonganFungsi`,`IdProgram`,`NamaProgram`,`JenisBarang`,
		`Stok`,`MinimalStok`,`HargaBeli`,`Barcode`,`NoBatch`,`Expire`,`SumberAnggaran`,`TahunAnggaran`,`StatusAnggaran`,`Produsen`,`Keterangan`,`NoFakturTerima`,`NamaPegawaiSimpan`)
		VALUES('$kodebarang','$idindikator','$namabarang','$namatambahan','$isikemasan','$kemasan','$satuan','$golonganfungsi','$idprogram','$namaprogram','$jenisbarang',$jumlah,
		'$minimalstok','$hargabeli','$barcode','$nobatch','$expire','$sumberanggaran','$tahunanggaran','$statusanggaran','$produsen','Dinas','$nomorpembukuan ','$namapegawaisimpan')";
		mysqli_query($koneksi, $str);
	}	
// Tahap 5, tbgfkpenerimaandetail
	$strpenerimaan = "INSERT INTO `tbgfkpenerimaandetail`(`NomorPembukuan`,`KodeBarang`,`NoBatch`,`Expire`,`Harga`,`Jumlah`,`SubTotal`,`NamaProgram`,`NamaTambahan`,`SumberAnggaran`)
	VALUES ('$nomorpembukuan','$kodebarang','$nobatch','$expire','$hargabeli','$jumlah','$subtotal','$namaprogram','$namatambahan','$sumberanggaran')";
	$query = mysqli_query($koneksi,$strpenerimaan);
	
// Tahap 6, update grand total tbgfkpenerimaan
	mysqli_query($koneksi,"UPDATE `tbgfkpenerimaan` SET `GrandTotal`='$grandtotal' WHERE `NomorPembukuan`='$nomorpembukuan'");	

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=gudang_besar_penerimaan_lihat&id=$nomorpembukuan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=gudang_besar_penerimaan_lihat&id=$nomorpembukuan';";
	echo "</script>";
} 
?>