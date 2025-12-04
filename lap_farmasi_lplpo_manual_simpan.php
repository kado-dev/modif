<?php
	session_start();
	include "config/koneksi.php";
	//include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kodeobat = $_POST['kodebarang']; 
	$stokawal = $_POST['stokawal']; 
	$penerimaan = $_POST['penerimaan'];
	$pemakaian = $_POST['pemakaian'];
	$permintaan = $_POST['permintaan'];
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	$sumberanggaran = $_POST['sumberanggaran']; 
	$tblplpomanual_bandungkab = "tblplpomanual_bandungkab_".$kodepuskesmas;
	
	foreach($kodeobat as $kdb){
		// if($stokawal[$kdb] != 0){
			$persediaan = $stokawal[$kdb] + $penerimaan[$kdb];
			$sisastok = $persediaan - $pemakaian[$kdb];
			$stokoptimum = $sisastok * 1.6;
			
			if(strlen($bulan) == 1){
				$bulan = '0'.$bulan;
			}
			
			//insert ke tb gudang permintaan
			mysqli_query($koneksi, "DELETE FROM `$tblplpomanual_bandungkab` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kdb'");
			mysqli_query($koneksi,"INSERT INTO `$tblplpomanual_bandungkab`(`KodePuskesmas`,`KodeBarang`,`Bulan`,`Tahun`,`StokAwal`,`Penerimaan`,`Persediaan`,`Pemakaian`,`SisaAkhir`,`StokOptimum`,`Permintaan`,`Pemberian`,`Keterangan`)
			VALUES ('$kodepuskesmas','$kdb','$bulan','$tahun','$stokawal[$kdb]','$penerimaan[$kdb]','$persediaan','$pemakaian[$kdb]','$sisastok','$stokoptimum','$permintaan[$kdb]','0','0')");
			
		// }
	}	
	header("location:index.php?page=lap_farmasi_lplpo_manual&bulan=".$bulan."&tahun=".$tahun."&sumberanggaran=".$sumberanggaran);
?>	