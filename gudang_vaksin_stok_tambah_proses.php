<?php
	$kodebarang = $_POST['kodebarang'];	
	$namabarang = $_POST['namabarang'];
	$id_generik = $_POST['kodebaranginn'];
	$produsen = $_POST['produsen'];
	$isikemasan = $_POST['isikemasan'];
	$kemasan = $_POST['kemasan'];
	$satuan = $_POST['satuan'];
	$kelastherapy = $_POST['kelastherapy'];
	$namaprogram = $_POST['namaprogram'];
	$minimalstok = $_POST['minimalstok'];
	$hargabeli = $_POST['hargabeli'];
	$barcode = $_POST['barcode'];
	$nobatch = $_POST['nobatch'];
	$expire = date('Y-m-d', strtotime($_POST['expire']));
	$sumberanggaran = $_POST['sumberanggaran'];
	$tahunanggaran = $_POST['tahunanggaran'];	
	$namapegawaisimpan = $_SESSION['username'];
	
	// tahap1, cek jika nama obat tidak ada dalam database lplpo
	$cek_nm_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` = '$namabarang'"));
	if($cek_nm_barang == 0){
		echo "<script>";
		echo "document.location.href='?page=gudang_besar_stok_tambah&stsvalidasi=Nama Barang tidak terdaftar di Database LPLPO...';";
		echo "</script>";
		die();
	}	

	// tahap2, cek barcode sama
	$cek_barcode = mysqli_num_rows(mysqli_query($koneksi,"SELECT `Barcode` FROM `tbgfk_vaksin_stok` WHERE `Barcode` = '$barcode'"));
	if($cek_barcode > 0){
		echo "<script>";
		echo "alert('Barcode sudah pernah diinputkan');";
		echo "document.location.href='index.php?page=gudang_besar_stok_tambah';";
		echo "</script>";
		die();
	}
	
	// tahap3, insert ke database
	$str = "INSERT INTO `tbgfk_vaksin_stok`(`KodeBarang`,`NamaBarang`,`IsiKemasan`,`Kemasan`,`Satuan`,`KelasTherapy`,`NamaProgram`,`Stok`,`MinimalStok`, `HargaBeli`,`Barcode`,`NoBatch`, `Expire`, `SumberAnggaran`,`TahunAnggaran`,`Produsen`,`Keterangan`,`NamaPegawaiSimpan`)
	VALUES('$kodebarang','$namabarang','$isikemasan','$kemasan','$satuan','$kelastherapy','$namaprogram','0','$minimalstok','$hargabeli','$barcode','$nobatch','$expire','$sumberanggaran','$tahunanggaran','$produsen','Dinas','$namapegawaisimpan')";
	$query=mysqli_query($koneksi,$str);
	
	// echo $str;
	// die();

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_vaksin_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_vaksin_stok_tambah';";
		echo "</script>";
	} 	
?>