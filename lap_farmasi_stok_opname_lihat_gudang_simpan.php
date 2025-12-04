<?php
	session_start();
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$nofaktur = $_POST['nofaktur']; 
	$idbarang = $_POST['idbarang']; 
	$kodeobat = $_POST['kodebarang']; 
	$namabarang = $_POST['namabarang']; 
	 
	$nobatch = $_POST['nobatch']; 
	$expire = $_POST['expire']; 
	$hargasatuan = $_POST['hargasatuan']; 
	$idprogram = $_POST['idprogram']; 
	$namaprogram = $_POST['namaprogram']; 
	$gudangobat_sistem = $_POST['gudangobat_sistem']; 
	$gudangobat_fisik = $_POST['gudangobat_fisik']; 
	$depotobat_sistem = $_POST['depotobat_sistem']; 
	$depotobat_fisik = $_POST['depotobat_fisik']; 
	$depotigd_sistem  = $_POST['depotigd_sistem']; 
	$depotigd_fisik = $_POST['depotigd_fisik']; 
	$depotranap_sistem  = $_POST['depotranap_sistem']; 
	$depotranap_fisik = $_POST['depotranap_fisik']; 
	$depotponed_sistem  = $_POST['depotponed_sistem']; 
	$depotponed_fisik = $_POST['depotponed_fisik']; 
	$depotpustu_sistem  = $_POST['depotpustu_sistem']; 
	$depotpustu_fisik = $_POST['depotpustu_fisik']; 
	$depotpusling_sistem  = $_POST['depotpusling_sistem']; 
	$depotpusling_fisik = $_POST['depotpusling_fisik']; 
	$depotpoli_sistem  = $_POST['depotpoli_sistem']; 
	$depotpoli_fisik = $_POST['depotpoli_fisik']; 
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	
	foreach($idbarang as $kdb){			
		// Gudang obat
		// mysqli_query($koneksi, "DELETE FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]'");
		// $str = "INSERT INTO `tbstokopnam_puskesmas_detail_fisik`(`Bulan`,`Tahun`,`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`NoBatch`,`Expire`,`HargaSatuan`,`IdProgram`,
		// `NamaProgram`,`StokGudang_Sistem`,`StokGudang_Fisik`,`StokDepot_Sistem`,`StokDepot_Fisik`,`StokIgd_Sistem`,`StokIgd_Fisik`,`StokRanap_Sistem`,`StokRanap_Fisik`,
		// `StokPoned_Sistem`,`StokPoned_Fisik`,`StokPustu_Sistem`,`StokPustu_Fisik`,`StokPusling_Sistem`,`StokPusling_Fisik`,`StokPoli_Sistem`,`StokPoli_Fisik`) 
		// VALUES ('$bulan','$tahun','$kodepuskesmas','$kodeobat[$kdb]','$namabarang[$kdb]','$nobatch[$kdb]','$expire[$kdb]','$hargasatuan[$kdb]','$idprogram[$kdb]',
		// '$namaprogram[$kdb]','$gudangobat_sistem[$kdb]','$gudangobat_fisik[$kdb]','$depotobat_sistem[$kdb]','$depotobat_fisik[$kdb]','$depotigd_sistem[$kdb]',
		// '$depotigd_fisik[$kdb]','$depotranap_sistem[$kdb]','$depotranap_fisik[$kdb]','$depotponed_sistem[$kdb]','$depotponed_fisik[$kdb]','$depotpustu_sistem[$kdb]',
		// '$depotpustu_fisik[$kdb]','$depotpusling_sistem[$kdb]','$depotpusling_fisik[$kdb]','$depotpoli_sistem[$kdb]','$depotpoli_fisik[$kdb]')";
		// echo $str;
		// die();
		
		$str = "UPDATE `tbstokopnam_puskesmas_detail_fisik` SET `StokGudang_Fisik`='$gudangobat_fisik[$kdb]' WHERE `IdStokBulan`='$idbarang[$kdb]'";
		$query = mysqli_query($koneksi,$str);
	
		// update stok, jangan dulu diaktifkan karena merubah stok di gudang obat puskesmas dan depot
		// mysqli_query($koneksi, "UPDATE `tbgudangpkmstok` SET `Stok`='$gudangobat_fisik[$kdb]' WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]'");
		// mysqli_query($koneksi, "UPDATE `tbapotikstok` SET `Stok`='$depotobat_fisik[$kdb]' WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]' AND `StatusBarang`='LOKET OBAT'");
		// mysqli_query($koneksi, "UPDATE `tbapotikstok` SET `Stok`='$depotigd_fisik[$kdb]' WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]' AND `StatusBarang`='IGD'");
		// mysqli_query($koneksi, "UPDATE `tbapotikstok` SET `Stok`='$depotranap_fisik[$kdb]' WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]' AND `StatusBarang`='RAWAT INAP'");
		// mysqli_query($koneksi, "UPDATE `tbapotikstok` SET `Stok`='$depotponed_fisik[$kdb]' WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]' AND `StatusBarang`='PONED'");
		// mysqli_query($koneksi, "UPDATE `tbapotikstok` SET `Stok`='$depotpustu_fisik[$kdb]' WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]' AND `StatusBarang`='PUSTU'");
		// mysqli_query($koneksi, "UPDATE `tbapotikstok` SET `Stok`='$depotpusling_fisik[$kdb]' WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]' AND `StatusBarang`='PUSLING'");
		// mysqli_query($koneksi, "UPDATE `tbapotikstok` SET `Stok`='$depotpoli_fisik[$kdb]' WHERE `KodeBarang`='$kodeobat[$kdb]' AND `NoBatch`='$nobatch[$kdb]' AND `StatusBarang`='POLI'");
	}	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diupdate...');";
		// header("location:index.php?page=lap_farmasi_stok_opname_lihat_gudang&nf=".$nofaktur."&bl=".$bulan."&th=".$tahun);
		echo "document.location.href='index.php?page=lap_farmasi_stok_opname_lihat_gudang&nf=$nofaktur&bl=$bulan&th=$tahun';";
		echo "</script>";	
	}	
?>	