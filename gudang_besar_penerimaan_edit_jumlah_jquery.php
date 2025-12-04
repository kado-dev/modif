<?php
	include "config/koneksi.php";
	$kode = $_POST['kode'];
	$batch = $_POST['batch'];
	$nofaktur = $_POST['nofaktur'];
	$idpenerimaan = $_POST['idbarang'];
	$id_distribusi = $_POST['id_distribusi'];
	$kolom = $_POST['type'];
	$value = $_POST['value'];
		
	// tahap1, tbgfkpenerimaandetail
	$str1 = "UPDATE `tbgfkpenerimaandetail` SET $kolom = '$value' WHERE `IdPenerimaan`='$idpenerimaan'";
	mysqli_query($koneksi, $str1);
	
	// tahap2, tbgfkstok
	$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfkpenerimaandetail` WHERE `IdPenerimaan`='$idpenerimaan'"));
	$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Jumlah`) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kode' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofaktur'"));
	$stok = $penerimaan['Jumlah'] - $pengeluaran['Jumlah'];
	
	$str_detail1 = "UPDATE `tbgfkstok` SET `Stok` = '$stok' WHERE `KodeBarang` = '$kode' and `NoBatch` = '$batch' and `NoFakturTerima` = '$nofaktur'";
	mysqli_query($koneksi, $str_detail1);
	
	echo "Data berhasil di edit...";
?>