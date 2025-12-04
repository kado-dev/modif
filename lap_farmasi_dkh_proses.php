<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kegiatan = $_POST['kegiatan'];
	$pekerjaan = $_POST['pekerjaan'];
	$kodekegiatan = $_POST['kodekegiatan'];
	$koderekening = $_POST['koderekening'];
	$pagudana = $_POST['pagudana'];
	$tahunanggaran = $_POST['tahunanggaran'];
	$paket = $_POST['paket'];
	$statuskatalog = $_POST['statuskatalog'];
	$tanggalentry = date('Y-m-d H:i:s');
	
	$str = "INSERT INTO `tbgudangpkmdkh`(`KodePuskesmas`,`Kegiatan`,`Pekerjaan`,`KodeKegiatan`,`KodeRekening`,`PaguDana`,`TahunAnggaran`,`PaketDkh`,`StatusKatalog`,`TanggalEntry`)
	VALUES ('$kodepuskesmas','$kegiatan','$pekerjaan','$kodekegiatan','$koderekening','$pagudana','$tahunanggaran','$paket','$statuskatalog','$tanggalentry')";
	$query=mysqli_query($koneksi,$str);	
	// echo $str;
	// die();
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=lap_farmasi_dkh';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=lap_farmasi_dkh';";
		echo "</script>";
	} 	
?>