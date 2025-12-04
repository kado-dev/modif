<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	
	// variabel
	$tangalpelaksanaan = date("Y-m-d", strtotime($_POST['tangalpelaksanaan']))." ".date('G:i:s');
	$jeniskelompok = $_POST['jeniskelompok'];
	$clubprolanis = $_POST['clubprolanis'];
	$clubprolanisnama = $_POST['clubprolanisnama'];
	$jeniskegiatan = $_POST['jeniskegiatan'];
	$materi = $_POST['materi'];
	$pembicara = $_POST['pembicara'];
	$lokasi = $_POST['lokasi'];
	$biayahonorinternal = str_replace(",","",$_POST['biayahonorinternal']);
	$biayahonoreksternal = str_replace(",","",$_POST['biayahonoreksternal']);
	$biayalainlain = str_replace(",","",$_POST['biayalainlain']);
	$totalbiaya = str_replace(",","",$_POST['totalbiaya']);
	$keterangan = $_POST['keterangan'];
		
	// tahap 1, insert tbbpjs_kegiatan_kelompok
	$str = "INSERT INTO `tbbpjs_kegiatan_kelompok`(`TanggalPelaksanaan`, `JenisKelompok`, `ClubProlanis`, `ClubProlanisNama`, `JenisKegiatan`, `Materi`, `Pembicara`, `Lokasi`, `BiayaHonorInternal`, `BiayaHonorEksternal`, `BiayaLainLain`, `TotalBiaya`, `Keterangan`) 
	VALUES ('$tangalpelaksanaan','$jeniskelompok','$clubprolanis','$clubprolanisnama','$jeniskegiatan','$materi','$pembicara','$lokasi','$biayahonorinternal','$biayahonoreksternal','$biayalainlain','$totalbiaya','$keterangan')";
	// echo $str;
	// die();
	$query = mysqli_query($koneksi,$str);
	$idkegiatan = mysqli_insert_id($koneksi);

	
	$add_kegiatanbpjs = add_kegiatan_kelompok($clubprolanis,$_POST['tangalpelaksanaan'],$jeniskegiatan,$jeniskelompok,$materi,$pembicara,$lokasi,$keterangan,$totalbiaya);
	$dtke = json_decode($add_kegiatanbpjs,True);
	$eduid = $dtke['response']['message'];

	mysqli_query($koneksi,"UPDATE tbbpjs_kegiatan_kelompok SET eduId = '$eduid' where IdKegiatan = '$idkegiatan'");

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=bpjs_kegiatan_kelompok';";
		echo "</script>";
	}else{
		// echo $strpasien();
		// die();
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=bpjs_kegiatan_kelompok';";
		echo "</script>";
	} 	
?>