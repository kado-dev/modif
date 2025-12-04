<?php
include "config/koneksi.php";
	$idbarang =  $_POST['idbarang'];
	$nofakturterima = $_POST['nofakturterima'];
	$kodebarang =  $_POST['kodebarang'];
	$kodebarangedit =  $_POST['kodebarangedit'];
	$nobatch = $_POST['nobatch'];
	$nobatchedit = $_POST['nobatchedit'];
	$namabarang = $_POST['namabarang'];
	$id_generik = $_POST['kodebaranginn'];
	$isikemasan = $_POST['isikemasan'];
	$kemasan = $_POST['kemasan'];
	$satuan = $_POST['satuan'];
	$golonganfungsi = $_POST['golonganfungsi'];
	$namaprogram = $_POST['namaprogram'];
	$jenisbarang = $_POST['jenisbarang'];
	$ruangan = $_POST['ruangan'];
	$rak = $_POST['rak'];
	$stok = $_POST['stok'];
	$minimalstok = $_POST['minimalstok'];
	$hargabeli = $_POST['hargabeli'];
	$barcode = $_POST['barcode'];
	$expire = date('Y-m-d', strtotime($_POST['expire']));
	$sumberanggaran = $_POST['sumberanggaran'];
	$tahunanggaran = $_POST['tahunanggaran'];	
	$namapegawaisimpan = $_SESSION['username'];
	$waktuupdate = date('Y-m-d G:i:s');
	
	// ref_obatprogram
	$dtprogram = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_obatprogram` WHERE `nama_program`='$namaprogram'"));
	$idprogram = $dtprogram['id_program'];
	
	// tahap 1 cek nama barang sesuai lplpo
	$ceklplpo = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `ref_obat_lplpo` WHERE `NamaBarang`='$namabarang'"));
	if($ceklplpo == 0){
		echo "<script>";
		echo "alert('Data gagal disimpan, nama barang tidak sesuai lplpo...');";
		echo "document.location.href='index.php?page=gudang_besar_stok_edit&kd=$kodebarang&batch=$nobatch';";
		echo "</script>";
		die();
	}	
	 
	// tahap 2 ketersediaan
	$str_lplpo = "UPDATE `ref_obat_lplpo` SET `NamaBarang`='$namabarang',`IsiKemasan`='$isikemasan',`Kemasan`='$kemasan',`Satuan`='$satuan',`GolonganFungsi`='$golonganfungsi',
	`NamaProgram`='$namaprogram',`JenisBarang`='$jenisbarang',`MinimalStok`='$minimalstok',`Barcode`='$barcode' WHERE `KodeBarang`='$kodebarang'";
	mysqli_query($koneksi,$str_lplpo);

	$str = "UPDATE `tbgfkstok` SET `KodeBarang`='$kodebarangedit',`NoBatch`='$nobatchedit',`NamaBarang`='$namabarang',`IsiKemasan`='$isikemasan',`Kemasan`='$kemasan',`Satuan`='$satuan',`GolonganFungsi`='$golonganfungsi',
	`IdProgram`='$idprogram',`NamaProgram`='$namaprogram',`JenisBarang`='$jenisbarang',`Ruangan`='$ruangan',`Rak`='$rak',`MinimalStok`='$minimalstok',`HargaBeli`='$hargabeli',`Barcode`='$barcode',
	`Expire`='$expire',`SumberAnggaran`='$sumberanggaran',`TahunAnggaran`='$tahunanggaran',`NamaPegawaiEdit`='$namapegawaisimpan' 
	WHERE `IdBarang`='$idbarang'";
	$query=mysqli_query($koneksi,$str);
	
	// tahap 3 penerimaan
	mysqli_query($koneksi, "UPDATE `tbgfkpenerimaandetail` 
	SET `KodeBarang`='$kodebarangedit',`NoBatch`='$nobatchedit',`Expire`='$expire',`Harga`='$hargabeli',`NamaProgram`='$namaprogram',`SumberAnggaran`='$sumberanggaran'
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NomorPembukuan`='$nofakturterima'");
	
	// tahap 4 distribusi
	mysqli_query($koneksi, "UPDATE `tbgfkpengeluarandetail` 
	SET `KodeBarang`='$kodebarangedit',`NoBatch`='$nobatchedit',`Harga`='$hargabeli',`NamaProgram`='$namaprogram',`SumberAnggaran`='$sumberanggaran'
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'");
	
	// tahap 5 kartustok
	mysqli_query($koneksi, "UPDATE `tbstokbulanandinas` 
	SET `KodeBarang`='$kodebarangedit',`NoBatch` = '$nobatchedit' 
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'");
		
	// tahap 6 stok awal master
	mysqli_query($koneksi, "UPDATE `tbstokawalmaster_gudang_besar` 
	SET `KodeBarang`='$kodebarangedit',`NoBatch` = '$nobatchedit',`HargaBeli`='$hargabeli',`TahunAnggaran`='$tahunanggaran',`WaktuUpdate`='$waktuupdate'
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'");
	
	// tahap 7 update harga di gudangpkmstok
	mysqli_query($koneksi, "UPDATE `tbgudangpkmstok`
	SET `KodeBarang`='$kodebarangedit',`NoBatch`='$nobatchedit',`Expire`='$expire',`HargaSatuan`='$hargabeli',`SumberAnggaran`='$sumberanggaran',
	`TahunAnggaran`='$tahunanggaran',`IdProgram`='$idprogram',`NamaProgram`='$namaprogram'
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'");
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_stok&key=$namabarang&jmltersedia=Keseluruhan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_stok_edit&id=$kodebarang';";
		echo "</script>";
	} 	
?>