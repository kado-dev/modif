<?php
	date_default_timezone_set('Asia/Jakarta');
	error_reporting(0);
	//session_start();
	include "../config/koneksi.php";
	$nocm = $_POST['nocm'];
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$pekerjaan = $_POST['pekerjaan'];
	$pendidikan = $_POST['pendidikan'];
	$saran = $_POST['saran'];
	$umur = $_POST['umur'];
	$jk = $_POST['jk'];
	$pelayanan = $_POST['pelayanan'];
	
	$no1 = $_POST['no1'];
	$no2 = $_POST['no2'];
	$no3 = $_POST['no3'];
	$no4 = $_POST['no4'];
	$no5 = $_POST['no5'];
	$no6 = $_POST['no6'];
	$no7 = $_POST['no7'];
	$no8 = $_POST['no8'];
	$no9 = $_POST['no9'];
	
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$waktu = date('Y-m-d G:i:s');
	$tbantrian_kuisioner = "tbantrian_kuisioner_".$kodepuskesmas;

	$cek_table = mysqli_num_rows(mysqli_query($koneksi,"SHOW TABLES LIKE '$tbantrian_kuisioner'"));
	
	if($cek_table > 0){

		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no1','$no1','$saran', '$pelayanan')");
		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no2','$no2','$saran', '$pelayanan')");
		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no3','$no3','$saran', '$pelayanan')");
		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no4','$no4','$saran', '$pelayanan')");
		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no5','$no5','$saran', '$pelayanan')");
		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no6','$no6','$saran', '$pelayanan')");
		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no7','$no7','$saran', '$pelayanan')");
		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no8','$no8','$saran', '$pelayanan')");
		mysqli_query($koneksi,"INSERT INTO `$tbantrian_kuisioner`(`nocm`,`nama`,`jeniskelamin`,`umur`,`alamat`,`pekerjaan`,`pendidikan`,`KodePuskesmas`, `waktu`, `pertanyaan`, `jawaban`, `saran`, `pelayanan`) VALUES ('$nocm','$nama','$jk','$umur','$alamat','$pekerjaan','$pendidikan','$kodepuskesmas','$waktu','no9','$no9','$saran', '$pelayanan')");

	}else{
		echo "table tidak ada";
	}
?>