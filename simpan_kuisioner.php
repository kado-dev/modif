<?php
	date_default_timezone_set('Asia/Jakarta');
	error_reporting(0);
	session_start();
	include "config/koneksi.php";

	$pertanyaanno1 = "Apakah SIMPUS membantu anda dalam pengolahan data pelaporan Puskesmas?";
	$pertanyaanno2 = "Bagaimana pendapat anda mengenai kemudahan proses penginputan SIMPUS dalam pelayanan?";
	$pertanyaanno3 = "Bagaimana pendapat anda mengenai fitur menu Simpus saat ini?";
	$pertanyaanno4 = "Apakah menurut anda perlu ada penambahan menu di SIMPUS untuk pengembangan berikutnya, jika ada sebutkan menu apa yang harus ditambahkan ?";
	$pertanyaanno5 = "Berikan Kritik dan Saran Terhadap SIMPUS aplikasi Puskesmas Online :";

	$no1 = $_POST['no1'];
	$no2 = $_POST['no2'];
	$no3 = $_POST['no3'];
	$no4 = $_POST['no4'];
	if($no4 == 'Perlu'){
		$no4uraian = $_POST['no4uraian'];
	}else{
		$no4uraian = "";
	}
	
	$saran = $_POST['saran'];
	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$idpegawai = $_SESSION['idpegawai'];
	$waktu = date('Y-m-d G:i:s');

	$cek_table = mysqli_num_rows(mysqli_query($koneksi,"SHOW TABLES LIKE 'tbkuisioner'"));
	
	if($cek_table > 0){
		// echo "INSERT INTO `tbkuisioner`(`IdKuisioner`, `KodePuskesmas`, `IdPegawai`, `Pertanyaan`, `JawabanPilihan`, `JawabanUraian`, `Waktu`) VALUES 
			// (null,'$kodepuskesmas','$idpegawai','$pertanyaanno1','$no1','','$waktu')";
			// die();
		mysqli_query($koneksi,"INSERT INTO `tbkuisioner`(`IdKuisioner`, `KodePuskesmas`, `IdPegawai`, `Pertanyaan`, `JawabanPilihan`, `JawabanUraian`, `Waktu`) VALUES 
			(null,'$kodepuskesmas','$idpegawai','$pertanyaanno1','$no1','','$waktu')");
		mysqli_query($koneksi,"INSERT INTO `tbkuisioner`(`IdKuisioner`, `KodePuskesmas`, `IdPegawai`, `Pertanyaan`, `JawabanPilihan`, `JawabanUraian`, `Waktu`) VALUES 
			(null,'$kodepuskesmas','$idpegawai','$pertanyaanno2','$no2','','$waktu')");
		mysqli_query($koneksi,"INSERT INTO `tbkuisioner`(`IdKuisioner`, `KodePuskesmas`, `IdPegawai`, `Pertanyaan`, `JawabanPilihan`, `JawabanUraian`, `Waktu`) VALUES 
			(null,'$kodepuskesmas','$idpegawai','$pertanyaanno3','$no3','','$waktu')");

		mysqli_query($koneksi,"INSERT INTO `tbkuisioner`(`IdKuisioner`, `KodePuskesmas`, `IdPegawai`, `Pertanyaan`, `JawabanPilihan`, `JawabanUraian`, `Waktu`) VALUES 
			(null,'$kodepuskesmas','$idpegawai','$pertanyaanno4','$no4','$no4uraian','$waktu')");

		mysqli_query($koneksi,"INSERT INTO `tbkuisioner`(`IdKuisioner`, `KodePuskesmas`, `IdPegawai`, `Pertanyaan`, `JawabanPilihan`, `JawabanUraian`, `Waktu`) VALUES 
			(null,'$kodepuskesmas','$idpegawai','$pertanyaanno5','','$saran','$waktu')");

	}else{
		echo "table tidak ada";
	}
?>