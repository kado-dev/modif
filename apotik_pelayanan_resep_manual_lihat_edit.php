<?php
session_start();
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$sts = $_POST['sts'];
	$idresepdetail = $_POST['idresepdetail'];
	$jumlah = $_POST['jumlah'];
	$jumlahlama = $_POST['jumlahlama'];
	$batch = $_POST['batch'];
	$kodebarang = $_POST['kodebarang'];
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);

	if($sts == 'jml'){

		$t = mysqli_query($koneksi,"UPDATE `$tbresepdetail` SET `jumlahobat` = '$jumlah' WHERE `IdResepDetail` = '$idresepdetail'");

		$stokdb = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM tbapotikstok WHERE KodeBarang = '$kodebarang' AND NoBatch = '$batch' AND KodePuskesmas = '$kodepuskesmas'"));

		$stk = ($stokdb['Stok'] + $jumlahlama) - $jumlah;			
		$str_obat_update = "UPDATE `tbapotikstok` SET `Stok`= '$stk' WHERE KodeBarang = '$kodebarang' AND NoBatch = '$batch' AND KodePuskesmas = '$kodepuskesmas'";
		mysqli_query($koneksi,$str_obat_update);
		echo $t;

	}else if($sts == 'signa'){
		$signa1 = $_POST['signa1'];
		$signa2 = $_POST['signa2'];
		mysqli_query($koneksi,"UPDATE `$tbresepdetail` SET `signa1` = '$signa1', `signa2` = '$signa2' WHERE `IdResepDetail` = '$idresepdetail'");

	}else if($sts == 'anjuran'){
		$anjuran = $_POST['anjuran'];
		mysqli_query($koneksi,"UPDATE `$tbresepdetail` SET `AnjuranResep` = '$anjuran' WHERE `IdResepDetail` = '$idresepdetail'");

	}
?>