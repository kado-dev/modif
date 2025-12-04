<?php
	session_start();
	include "config/koneksi.php";
	$kodeunik = $_POST['kodeunik'];
	$kodebarang = $_POST['kodebarang']; 
	$nobatch = $_POST['nobatch']; 
	$stoksistem_gudangbesar = $_POST['stoksistem_gudangbesar']; 
	$stokfisik_gudangbesar = $_POST['stokfisik_gudangbesar']; 
	$stoksistem_gudangpelayanan = $_POST['stoksistem_gudangpelayanan'];
	$stokfisik_gudangpelayanan = $_POST['stokfisik_gudangpelayanan'];
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	$halaman = $_POST['halaman'];
	
	foreach($kodeunik as $kdb){
		$selisih_gudangbesar = $stoksistem_gudangbesar[$kdb] - $stokfisik_gudangbesar[$kdb];
		$selisih_gudangpelayanan = $stoksistem_gudangpelayanan[$kdb] - $stokfisik_gudangpelayanan[$kdb];
		
		if(strlen($bulan) == 1){
			$bulan = '0'.$bulan;
		}
		// echo $stoksistem_gudangbesar[$kdb]."<br/>";
		// echo $stokfisik_gudangbesar[$kdb]."<br/>";
		// echo $stoksistem_gudangpelayanan[$kdb]."<br/>";
		// echo $stokfisik_gudangpelayanan[$kdb]."<br/><br/>";
		
		mysqli_query($koneksi,"UPDATE `tbstokbulanandinas_bandungkab` SET `StokGudangBesar_Fisik`='$stokfisik_gudangbesar[$kdb]',`SelisihGudangBesar`='$selisih_gudangbesar',`StokGudangPelayanan_Fisik`='$stokfisik_gudangpelayanan[$kdb]',`SelisihGudangPelayanan`='$selisih_gudangpelayanan' WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang[$kdb]' AND `NoBatch`='$nobatch[$kdb]'");
		
	}	
	// die();
	header("location:index.php?page=gudang_besar_opnam_bandungkab_lihat&bl=".$bulan."&th=".$tahun."&h=".$halaman);
?>	