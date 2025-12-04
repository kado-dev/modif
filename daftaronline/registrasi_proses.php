<?php
include "../config/koneksi.php";
include "../config/helper_pasienrj.php";

$nik = $_POST['nik'];
$idpasien = $_POST['idpasien'];
$noindex = substr($_POST['noindex'],-5);
$nama = str_replace("'","",$_POST['nama']);
$jeniskelamin = $_POST['jk'];
$tanggallahir = $_POST['tgllhr'];
$asuransi = $_POST['asuransi'];
if($asuransi == 'BPJS'){
	$nokartu = $_POST['nokartu'];
}else{
	$nokartu = '';
}
$polipertama = $_POST['polipertama'];
$kodepuskesmas = $_POST['kodepuskesmas'];
$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
$tbpasienonline = "tbpasienonline_".$kodepuskesmas;	
$tanggal = date('Y-m-d',strtotime($_POST['tanggal']));

// tbpuskesmas
$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbpuskesmas WHERE `KodePuskesmas`='$kodepuskesmas'"));
$kota = $dtpuskesmas['Kota'];
$namapuskesmas = $dtpuskesmas['NamaPuskesmas'];

if($kota == "KOTA TARAKAN"){
	date_default_timezone_set('Asia/Ujung_Pandang');
}else{
	date_default_timezone_set('Asia/Jakarta');
}
$waktuantrian = date('Y-m-d')." ".date('G:i:s');

// buat validasi tanggal
$tgldaftarmax = date('Y-m-d',strtotime("+7 days"));
if(strtotime($tanggal) > strtotime($tgldaftarmax)){
	echo "<script>";
	echo "alert('Gagal simpan, tanggal melebihi batas');";
	echo "window.location='index.php?page=isi_form&key=$idpasien&kode=$kodepuskesmas';";
	echo "</script>";
	die();
}

$data2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT KuotaOnline, Jumlah FROM `tbantrian_pelayanan` WHERE KodePuskesmas = '$kodepuskesmas' AND Pelayanan = '".str_replace("POLI ", "", $polipertama)."'"));
$jumlahpasienonline = mysqli_num_rows(mysqli_query($koneksi,"SELECT IdPasienOnline FROM `$tbpasienonline` WHERE DATE(WaktuDaftar) = '$tanggal' AND PoliPertama = '$polipertama'"));
$jumlahantrianonline = mysqli_num_rows(mysqli_query($koneksi,"SELECT IdAntrian FROM `$tbantrian_pasien` WHERE DATE(WaktuAntrian) = '$tanggal' AND PoliPertama = '".str_replace("POLI ", "", $polipertama)."'"));
$sisakuota = $data2['KuotaOnline'] - $jumlahpasienonline; // jumlah kuota onlen dikurangi yang daftar onlen
$sisakuota_anjungan = $data2['Jumlah'] - $jumlahantrianonline;

// if($sisakuota <= 0 || $sisakuota_anjungan <= 0){
// ngebaca anjungan dulu, jika sudah habis maka dinotif

if($sisakuota_anjungan <= 0){
	echo "<script>";
	echo "alert('Kuota sudah habis, silahkan ganti tanggal kunjungan...');";
	echo "window.location='index.php?page=isi_form&id=$idpasien&key=$noindex&kode=$kodepuskesmas&simpus=$namapuskesmas';";
	echo "</script>";
	die();
}

if($sisakuota <= 0){
	echo "<script>";
	echo "alert('Kuota sudah habis, silahkan ganti tanggal kunjungan...');";
	echo "window.location='index.php?page=isi_form&id=$idpasien&key=$noindex&kode=$kodepuskesmas&simpus=$namapuskesmas';";
	echo "</script>";
	die();
}

$tbpasienonline = "tbpasienonline_".$kodepuskesmas;
$getdatasetting = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbantrian_setting` WHERE KodePuskesmas = '$kodepuskesmas'"));	

//get data lngkp
$poliaja = str_replace("POLI ", "", $polipertama);

if($tanggal == date('Y-m-d')){
	if(strtotime($getdatasetting['WaktuPelayananTutup']) > time()){
		$stswktdaftar = 'hari ini';
		$tgldaftar = date('Y-m-d');
	}else{
		echo "<script>";
		echo "alert('Pelayanan hari ini sudah tutup, silahkan pilih tanggal kunjungan...');";
		echo "window.location='index.php?page=isi_form&key=$idpasien&kode=$kodepuskesmas';";
		echo "</script>";
		die();
	}	
}else{
	$tgldaftar = date('Y-m-d',strtotime($tanggal));
	$waktudaftar = date('Y-m-d G:i:s',strtotime($tanggal));
	$stswktdaftar = 'lain hari';
}

// cek user sudah terdaftar/belum
$cekuserdaftar = mysqli_query($koneksi, "SELECT IdPasienOnline FROM `$tbpasienonline` WHERE DATE(WaktuDaftar) = '$tgldaftar' AND IdPasien = '$idpasien'");
if(mysqli_num_rows($cekuserdaftar) > 0){//sudah terdaftar ditanggal itu
	$dpo = mysqli_fetch_assoc($cekuserdaftar);
	$IdPasienOnline = $dpo['IdPasienOnline'];
	echo "<script>";
	echo "alert('Gagal simpan, ditanggal yang sama pasien sudah terdaftar...');";
	echo "window.location='index.php?page=etiket&id=$IdPasienOnline&kode=$kodepuskesmas';";
	echo "</script>";
	die();
}	

// tahap 1
// $getdatasetting['WaktuPelayanan'];
if($stswktdaftar == 'hari ini'){
	$waktudaftar = date('Y-m-d G:i:s');
	$data_antrian = mysqli_query($koneksi, "SELECT MAX(NomorAntrian) as No FROM `$tbantrian_pasien` WHERE DATE(WaktuAntrian) = CURDATE()");
	if(mysqli_num_rows($data_antrian) == 0){
		$noantrian = 1;
	}else{
		$dta = mysqli_fetch_assoc($data_antrian);
		$noantrian = $dta['No'] + 1;
	}

	$data_antrian_poli = mysqli_query($koneksi, "SELECT MAX(NomorAntrianPoli) as No FROM `$tbantrian_pasien` WHERE PoliPertama = '$poliaja' AND DATE(WaktuAntrian) = CURDATE()");
	if(mysqli_num_rows($data_antrian_poli) == 0){
		$noantrianpoli = 1;
	}else{
		$dta2 = mysqli_fetch_assoc($data_antrian_poli);
		$noantrianpoli = $dta2['No'] + 1;
	}

	if(strtotime('07:30') > time()){//kurang jam 7.30
		$perkiraanmenit = $noantrianpoli * 2;
		$dttime = date('Y-m-d')." 07:30:00";
	}else{
		// hitung jumlah yg belum dilayani jam sekarang
		// cari yg belum
		$jmlsudah = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE PoliPertama = '$polipertama' AND `TanggalRegistrasi` = CURDATE() AND StatusAntrianPoli = 'Y'"));
		$jmlbelum = $noantrianpoli - $jmlsudah;
		if($jmlbelum == 0){
			$jmlbelum = 1;
		}

		$perkiraanmenit = $jmlbelum * 2;
		$dttime = date('Y-m-d H:i:s');
	}
}else{
	// daftar untuk besok
	$jam = date('G:i:s');
	$waktudaftar = $tanggal." ".$jam;
	// echo "SELECT MAX(NomorAntrian) as No FROM `$tbantrian_pasien` WHERE DATE(WaktuAntrian) = '$tgldaftar'";
	// die();
	$data_antrian = mysqli_query($koneksi, "SELECT MAX(NomorAntrian) as No FROM `$tbantrian_pasien` WHERE DATE(WaktuAntrian) = '$tgldaftar'");
	if(mysqli_num_rows($data_antrian) == 0){
		$noantrian = 1;
	}else{
		$dta = mysqli_fetch_assoc($data_antrian);
		$noantrian = $dta['No'] + 1;
	}
	
	$data_antrian_poli = mysqli_query($koneksi, "SELECT MAX(NomorAntrianPoli) as No FROM `$tbantrian_pasien` WHERE PoliPertama = '$poliaja' AND DATE(WaktuAntrian) = '$tgldaftar'");
	if(mysqli_num_rows($data_antrian_poli) == 0){
		$noantrianpoli = 1;
	}else{
		$dta2 = mysqli_fetch_assoc($data_antrian_poli);
		$noantrianpoli = $dta2['No'] + 1;
	}

	$perkiraanmenit = $noantrianpoli * 2;
	$dttime = $tgldaftar." 07:30:00";
}

$time = new DateTime($dttime);
$time->add(new DateInterval('PT' . $perkiraanmenit . 'M'));
$perkiraanwaktu = $time->format('Y-m-d H:i:s');
// echo $perkiraanwaktu;
// die();

// tbpasienonline
$strpasienonline = "INSERT INTO `$tbpasienonline`(`WaktuDaftar`, `IdPasien`, `Nik`, `NamaPasien`, `JenisKelamin`, `TanggalLahir`, `NoAsuransi`, `PoliPertama`, `Asuransi`, `keluhan`, `KodePuskesmas`, `NomorAntrian`, `NomorAntrianPoli`,`StatusDaftar`,`Approve`) VALUES 
('$waktudaftar','$idpasien','$nik','$nama','$jeniskelamin','$tanggallahir','$nokartu','$polipertama','$asuransi','-','$kodepuskesmas','$noantrian','$noantrianpoli','ISAP','N')";
$query = mysqli_query($koneksi, $strpasienonline);
$iddaftar = mysqli_insert_id($koneksi);

// tbantrian_pasien
$strantrianonline = "INSERT INTO `$tbantrian_pasien`(`IdPasienOnline`,`WaktuAntrian`,`KodePuskesmas`, `NomorAntrian`, `NomorAntrianPoli`, `PoliPertama`, `Klaster`, `StatusAntrian`, `EstimasiWaktu`, `StatusDaftar`) VALUES ('$iddaftar','$waktudaftar','$kodepuskesmas','$noantrian','$noantrianpoli','$poliaja','-','Selesai','$perkiraanwaktu','ISAP')";
$insert1 = mysqli_query($koneksi, $strantrianonline);
		
if($query){
	echo "<script>";
	echo "window.location='index.php?page=etiket&id=$iddaftar&kode=$kodepuskesmas&simpus=$namapuskesmas';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data Gagal di Simpan...');";
	echo "window.location='index.php?page=dashboard';";
	echo "</script>";
}
?>