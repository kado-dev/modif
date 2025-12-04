<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$idspmindikator =  $_POST['idspmindikator'];
	$jumd =  $_POST['jumd'];
	$jums =  $_POST['jums'];
	$bulan =  $_POST['bulan'];
	$tahun =  $_POST['tahun'];
	//$cakupan = $_POST['cakupan'];

	foreach($idspmindikator as $id){
		$cakupan =  ($jumd[$id] / $jums[$id] ) * 100;
		$str_val[] = "('$kodepuskesmas','$id','$jumd[$id]','$jums[$id]','$cakupan','$bulan','$tahun')";
	}
	
	mysqli_query($koneksi, "DELETE FROM `tbspmindikator_laporan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `bulan`='$bulan' AND `tahun`='$tahun'");
	$str = "INSERT INTO `tbspmindikator_laporan`(`KodePuskesmas`, `idspmindikator`, `jumlah_d`, `jumlah_s`, `cakupan`, `bulan`, `tahun`) VALUES ".implode(",", $str_val);
	$query = mysqli_query($koneksi,$str);
	// echo $str;
	// die();
		
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=lap_spm_indikator';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=lap_spm_indikator_input';";
		echo "</script>";
	} 	
?>