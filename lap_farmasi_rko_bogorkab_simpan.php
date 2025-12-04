<?php
	session_start();
	include "config/koneksi.php";
	$namapuskesmas = $_SESSION['namapuskesmas']; 
	$kodeobat = $_POST['kodebarang']; 
	$rencanapembelian = $_POST['rencanapembelian']; 
	$namaprogram = $_POST['namaprogram']; 
	$tahun = $_POST['tahun']; 
	$tbrko = "tbrko_puskesmas_".str_replace(' ', '', $namapuskesmas);
	// echo "Hasil : ".$tbrko;
	// die();
	
	foreach($kodeobat as $kdb){
		// if($kodeobat[$kdb] != 0){
			// insert ke tb gudang permintaan
			mysqli_query($koneksi, "DELETE FROM `$tbrko` WHERE `Tahun`='$tahun' AND `KodeBarang`='$kdb'");
			mysqli_query($koneksi,"INSERT INTO `$tbrko`(`KodeBarang`,`Tahun`,`RencanaPembelian`) VALUES ('$kdb','$tahun','$rencanapembelian[$kdb]')");
		// }
	}	
	header("location:index.php?page=lap_farmasi_rko_bogorkab&tahun=".$tahun."&namaprogram=".$namaprogram);
?>	