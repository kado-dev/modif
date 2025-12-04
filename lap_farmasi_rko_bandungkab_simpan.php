<?php
	session_start();
	include "config/koneksi.php";
	//include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kodeobat = $_POST['kodebarang']; 
	$stokawal = $_POST['stokawal']; 
	$pemakaianrata = $_POST['pemakaianrata'];
	$rencanapengadaan = $_POST['rencanapengadaan'];
	$realisasipengadaan = $_POST['realisasipengadaan'];
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	$sumberanggaran = $_POST['sumberanggaran']; 
	
	foreach($kodeobat as $kdb){
		// if($stokawal[$kdb] != 0){
			//insert ke tb gudang permintaan
			mysqli_query($koneksi, "DELETE FROM `tbrkobandungkab` WHERE `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kdb'");
			mysqli_query($koneksi,"INSERT INTO `tbrkobandungkab`(`KodePuskesmas`,`Tahun`,`KodeBarang`,`StokAwal`,`PemakaianRata`,`RencanaPengadaan`,`RealisasiPengadaan`,`SumberAnggaran`)
			VALUES ('$kodepuskesmas','$tahun','$kdb','$stokawal[$kdb]','$pemakaianrata[$kdb]','$rencanapengadaan[$kdb]','$realisasipengadaan[$kdb]','$sumberanggaran')");
		// }
	}	
	header("location:index.php?page=lap_farmasi_rko_bandungkab&tahun=".$tahun."&sumberanggaran=".$sumberanggaran);
?>	