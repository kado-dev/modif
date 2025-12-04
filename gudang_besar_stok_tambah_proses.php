<?php
	$kodebarang = $_POST['kodebarang'];	
	$namabarang = $_POST['namabarang'];
	$id_generik = $_POST['kodebaranginn'];
	$produsen = $_POST['produsen'];
	$isikemasan = $_POST['isikemasan'];
	$kemasan = $_POST['kemasan'];
	$satuan = $_POST['satuan'];
	$kelastherapy = $_POST['kelastherapy'];
	$golonganfungsi = $_POST['golonganfungsi'];
	$namaprogram = $_POST['namaprogram'];	
	$jenisbarang = $_POST['jenisbarang'];
	$ruangan = $_POST['ruangan'];
	$rak = $_POST['rak'];
	$minimalstok = $_POST['minimalstok'];
	$hargabeli = $_POST['hargabeli'];
	$barcode = $_POST['barcode'];
	$nobatch = $_POST['nobatch'];
	$expire = date('Y-m-d', strtotime($_POST['expire']));
	$sumberanggaran = $_POST['sumberanggaran'];
	$tahunanggaran = $_POST['tahunanggaran'];	
	$namapegawaisimpan = $_SESSION['username'];
	
	// cek jika nama obat tidak ada dalam database lplpo
	$cek_nm_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` = '$namabarang'"));
	if($cek_nm_barang == 0){
		echo "<script>";
		echo "document.location.href='?page=gudang_besar_stok_tambah&stsvalidasi=Nama Barang tidak terdaftar di Database LPLPO...';";
		echo "</script>";
		die();
	}	

	// cek barcode sama
	// $cek_barcode = mysqli_num_rows(mysqli_query($koneksi,"SELECT `Barcode` FROM `tbgfkstok` WHERE `Barcode` = '$barcode'"));
	// if($cek_barcode > 0){
		// echo "<script>";
		// echo "alert('Barcode sudah pernah diinputkan');";
		// echo "document.location.href='index.php?page=gudang_besar_stok_tambah';";
		// echo "</script>";
		// die();
	// }
	
	// cek barang sama (kodebarang dan batch)
	$cek_barcode = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang`,`NoBatch` FROM `tbgfkstok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
	if($cek_barcode > 0){
		echo "<script>";
		echo "alert('Barang sudah pernah diinputkan dengan Batch yang sama...');";
		echo "document.location.href='index.php?page=gudang_besar_stok_tambah';";
		echo "</script>";
		die();
	}
	
	$str = "INSERT INTO `tbgfkstok`(`KodeBarang`,`NamaBarang`,`IsiKemasan`,`Kemasan`,`Satuan`,`KelasTherapy`,`GolonganFungsi`,`NamaProgram`,`JenisBarang`,
	`Ruangan`,`Rak`,`Stok`,`MinimalStok`, `HargaBeli`,`Barcode`,`NoBatch`, `Expire`, `SumberAnggaran`,`TahunAnggaran`,`Produsen`,`Keterangan`,`NamaPegawaiSimpan`)
	VALUES('$kodebarang','$namabarang','$isikemasan','$kemasan','$satuan','$kelastherapy',
	'$golonganfungsi','$namaprogram','$jenisbarang','$ruangan','$rak',0,'$minimalstok','$hargabeli','$barcode','$nobatch','$expire','$sumberanggaran',
	'$tahunanggaran','$produsen','Dinas','$namapegawaisimpan')";
	$query=mysqli_query($koneksi,$str);
	
	// echo $str;
	// die();

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_stok_tambah';";
		echo "</script>";
	} 	
?>