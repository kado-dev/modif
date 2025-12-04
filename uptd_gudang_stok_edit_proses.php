<?php
	include "config/koneksi.php";

	$kodebarang =  $_POST['kodebarang'];
	$barcode = $_POST['barcode'];
	$namabarang = $_POST['namabarang'];
	$kemasan = $_POST['kemasan'];
	$isikemasan = $_POST['isikemasan'];
	$satuan = $_POST['satuan'];
	$kelastherapy = $_POST['kelastherapy'];
	$golonganfungsi = $_POST['golonganfungsi'];
	$jenisbarang = $_POST['jenisbarang'];
	$ruangan = $_POST['ruangan'];
	$rak = $_POST['rak'];
	$stok = $_POST['stok'];
	$minimalstok = $_POST['minimalstok'];
	$hargabeli = $_POST['hargabeli'];
	$nobatch = $_POST['nobatch'];
	//tanggal explode
	$expire = $_POST['expire'];
	$expire1=explode("-",$expire);
	$tglexpire=$expire1[2]."-".$expire1[1]."-".$expire1[0];
	$sumberanggaran = $_POST['sumberanggaran'];
	$tahunanggaran = $_POST['tahunanggaran'];
	$kodesupplier = $_POST['kodeprodusen'];
	$namapegawaisimpan = $_SESSION['username'];
	
	$str = "UPDATE tbgudanguptdstok SET `NoBatch`='$nobatch',`Expire`='$tglexpire',`Stok`='$stok' WHERE `KodeBarang` = '$kodebarang'";
	$query=mysqli_query($koneksi,$str);

	$str_gfkstok = "UPDATE `tbgfkstok` SET `Barcode`='$barcode',`NamaBarang`='$namabarang',`Kemasan`='$kemasan',
	`IsiKemasan`='$isikemasan',`Satuan`='$satuan',`KelasTherapy`='$kelastherapy',`GolonganFungsi`='$golonganfungsi',`JenisBarang`='$jenisbarang',
	`Ruangan`='$ruangan',`Rak`='$rak',`Stok`='$stok',`MinimalStok`='$minimalstok',`HargaBeli`='$hargabeli',`NoBatch`='$nobatch',`Expire`='$tglexpire',
	`SumberAnggaran`='$sumberanggaran',`TahunAnggaran`='$tahunanggaran',`KodeSupplier`='$kodesupplier',`Keterangan`='Dinas',
	`NamaPegawaiSimpan`='$namapegawaisimpan' WHERE `KodeBarang`='$kodebarang'";
	$query=mysqli_query($koneksi,$str_gfkstok);		
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=uptd_gudang_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=uptd_gudang_stok_edit&id=$kodebarang';";
		echo "</script>";
	} 	
?>