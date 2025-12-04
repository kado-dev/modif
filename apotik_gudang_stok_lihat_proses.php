<?php
	$idbarang =  $_POST['idbarang'];
	$kodebarang =  $_POST['kodebarang'];
	$namabarang = $_POST['namabarang'];
	$satuan = $_POST['satuan'];
	$hargasatuan = $_POST['hargabeli'];
	$nobatch = $_POST['nobatch'];
	// tanggal explode
	$expire = $_POST['expire'];
	$expire1=explode("-",$expire);
	$tglexpire=$expire1[2]."-".$expire1[1]."-".$expire1[0];
	$sumberanggaran = $_POST['sumberanggaran'];
	$tahunanggaran = $_POST['tahunanggaran'];
	$supplier = $_POST['supplier'];
	
	// tbgfkstok
	$str = "UPDATE `tbgudangpkmstok` SET `NoBatch`='$nobatch',`HargaSatuan`='$hargasatuan',`Expire`='$tglexpire',`SumberAnggaran`='$sumberanggaran',`TahunAnggaran`='$tahunanggaran' WHERE `IdBarangGdgPkm`='$idbarang'";
	$query = mysqli_query($koneksi,$str);	
	
	// tbapotikstok
	$str2 = "UPDATE `tbapotikstok` SET `NoBatch`='$nobatch',`HargaSatuan`='$hargasatuan',`Expire`='$tglexpire',`SumberAnggaran`='$sumberanggaran',`TahunAnggaran`='$tahunanggaran' WHERE `IdBarangGdgPkm`='$idbarang'";
	$query = mysqli_query($koneksi,$str2);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diedit...');";
		echo "document.location.href='index.php?page=apotik_gudang_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diedit...');";
		echo "document.location.href='index.php?page=apotik_gudang_stok_lihat&id=$idbarang';";
		echo "</script>";
	} 	
?>