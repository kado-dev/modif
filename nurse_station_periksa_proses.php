<?php
session_start();
error_reporting(1);
include "config/koneksi.php";
include "config/helper.php";
include "config/helper_pasienrj.php";
include "config/helper_report.php";
$kota = $_SESSION['kota'];

// jangan dipindah keatas, nnti gak jalan waktunya
if($kota == "KOTA TARAKAN" OR $kota == "KABUPATEN KUTAI KARTANEGARA"){
	date_default_timezone_set('Asia/Ujung_Pandang');
}else{
	date_default_timezone_set('Asia/Jakarta');
}

$jamperiksa = date('G:i:s');
$pelayanan = $_POST['pelayanan'];
$nopemeriksaan = $_POST['nopemeriksaan'];
$idpasien = $_POST['idpasien'];
$idpasienrj = $_POST['idpasienrj'];
$nocm = $_POST['nocm'];
$noindex = $_POST['noindex'];
$noregistrasi = $_POST['noregistrasi'];
$keluhan = strtoupper($_POST['keluhan']);
$anamnesa = strtoupper($_POST['anamnesa']);
$kodediagnosaaskep = $_POST['kodediagnosaaskep'];
$anjuran = strtoupper($_POST['anjuran']);
$pemeriksaanhasillab =  strtoupper($_POST['pemeriksaanpenunjanglab']);
$riwayatpenyakitsekarang = strtoupper($_POST['riwayatpenyakitsekarang']);
$riwayatpenyakitdulu = strtoupper($_POST['riwayatpenyakitdulu']);
$riwayatpenyakitkeluarga = strtoupper($_POST['riwayatpenyakitkeluarga']);
$riwayatalergimakanan = strtoupper($_POST['riwayatalergimakanan']);
$riwayatalergiudara = strtoupper($_POST['riwayatalergiudara']);
$riwayatalergiobat = strtoupper($_POST['riwayatalergiobat']);
$prognosa = strtoupper($_POST['prognosa']);
$rujukinternal =  $_POST['poliinternal'];
$rujuklanjut = $_POST['polilanjut'];
$kesadaran = $_POST['kesadaran'];
$namapegawai = $_SESSION['username'];
$tenagamedisbpjs = mysqli_real_escape_string($koneksi, $_POST['tenagamedisbpjs']); //nama tenaga medis bpjs
$tenagamedis2 = mysqli_real_escape_string($koneksi, $_POST['tenagamedis2']);
$tenagamedis3 = mysqli_real_escape_string($koneksi, $_POST['tenagamedis3']);
$tenagalab = mysqli_real_escape_string($koneksi, $_POST['tenagalab']);

// tbpasienrj
$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));

// update waktu periksa selesai
mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `PemeriksaanAkhir`=NOW() WHERE `NoRegistrasi` = '$noregistrasi'");

$tanggal_registrasi = $datapasienrj['TanggalRegistrasi']; // ngikutin tanggal registrasi agar sesuai kunjungan
$tanggal_time = date('Y-m-d', strtotime($tanggal_registrasi))." ".date('G:i:s');
$namapasien = $datapasienrj['NamaPasien'];
$kelaminpasien = $datapasienrj['JenisKelamin'];
$umurtahunpasien = $datapasienrj['UmurTahun'];
$statuspelayanan = $datapasienrj['StatusPelayanan'];

if($_POST['statuspulang'] == 0){//'Sembuh'
	$statuspulang = 0;
}else if($_POST['statuspulang'] == 1){//'Meninggal'
	$statuspulang = 1;
}else if($_POST['statuspulang'] == 2){//'Pulang Paksa'
	$statuspulang = 2;
}else if($_POST['statuspulang'] == 3){//'Berobat Jalan'
	$statuspulang = 3;
}else if($_POST['statuspulang'] == 4){//'Rujuk Lanjut'
	$statuspulang = 4;
}else if($_POST['statuspulang'] == 5){//'Rujuk Internal'
	$statuspulang = 5;
}else{
	$statuspulang = 9;//'Lain-lain'
}

if($keluhan == null){
	echo "gagal, Keluhan harus diisi";
	die();
}

if($anamnesa == null){
	echo "gagal, Anamnesa harus diisi";
	die();
}

if($kodediagnosaaskep == null){
	echo "gagal, Diagnosa askep harus diisi";
	die();
}

if($_POST['sistole'] == null){
	echo "gagal, sistole belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..";
	die();
}

if($_POST['diastole'] == null){
	echo "gagal, Diastole belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..";
	die();
}

if($_POST['suhutubuh'] == null){
	echo "gagal, Suhu Tubuh belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..";
	die();
}
if($_POST['tinggibadan'] == null){
	echo "gagal, Tinggi Badan belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..";
	die();
}
if($_POST['beratbadan'] == null){
	echo "gagal, Berat Badan belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..";
	die();
}

// pelayanan
if($pelayanan == 'POLI ANAK'){
	$polis = 'tbpolianak';
}else if($pelayanan == 'POLI BERSALIN'){
	$polis = 'tbpolibersalin';
}else if($pelayanan == 'POLI GIGI'){
	$polis = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'POLI GIZI'){
	$polis = 'tbpoligizi';
}else if($pelayanan == 'POLI HIV'){
	$polis = 'tbpolihiv';	
}else if($pelayanan == 'POLI IMUNISASI'){
	$polis = 'tbpoliimunisasi';
}else if($pelayanan == 'POLI ISOLASI'){
	$polis = 'tbpoliisolasi';	
}else if($pelayanan == 'POLI KB'){
	$polis = 'tbpolikb';
}else if($pelayanan == 'POLI KIA'){
	$polis = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'POLI KIR'){
	$polis = 'tbpolikir';
}else if($pelayanan == 'POLI LANSIA'){
	$polis = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'POLI MTBS'){
	$polis = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'POLI PANDU PTM'){
	$polis = 'tbpolipanduptm';
}else if($pelayanan == 'POLI PDP'){
	$polis = 'tbpolipdp';
}else if($pelayanan == 'POLI PROLANIS'){
	$polis = 'tbpoliprolanis';
}else if($pelayanan == 'POLI INFEKSIUS'){
	$polis = 'tbpoliinfeksius';
}else if($pelayanan == 'POLI SCREENING'){
	$polis = 'tbpoliscreening';		
}else if($pelayanan == 'POLI SKD'){
	$polis = 'tbpoliskd';
}else if($pelayanan == 'POLI TB DOTS' OR $pelayanan == 'POLI TB'){
	if($kota == 'KOTA TARAKAN'){
		$polis = 'tbpolitb';
	}else{
		$polis = 'tbpolitbdots';
	}
}else if($pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){
	$polis = 'tbpolitindakan';
}else if($pelayanan == 'POLI UMUM'){
	$polis = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'RAWAT INAP'){
	$polis = 'tbpolirawatinap';
}else if($pelayanan == 'POLI LABORATORIUM'){
	$polis = 'tbpolilaboratorium';
}else if($pelayanan == 'NURSING CENTER'){
	$polis = 'tbpolinursingcenter';	
}	

// tahap 1, vital sign
$sistole = $_POST['sistole'];
$diastole = $_POST['diastole'];
$suhutubuh = $_POST['suhutubuh'];
$tinggibadan = $_POST['tinggibadan'];
$beratbadan = $_POST['beratbadan'];
$heartrate = $_POST['heartrate'];
$resprate = $_POST['resprate'];
$lingkarperut = $_POST['lingkarperut'];
$imt_pasien = $_POST['imt'];

$cekvs = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdVitalSign` FROM $tbvitalsign WHERE `IdPasienrj`='$idpasienrj'"));
if($cekvs > 0){	
	$str_vs = "UPDATE `$tbvitalsign` 
	SET  `Keluhan`='$keluhan', `Anamnesa`='$anamnesa', `Sistole`='$sistole', `Diastole`='$diastole', `SuhuTubuh`='$suhutubuh', 
	`TinggiBadan`='$tinggibadan', `BeratBadan`='$beratbadan', `HeartRate`='$heartrate', `RespiratoryRate`='$resprate', 
	`LingkarPerut`='$lingkarperut', `IMT`='$imt_pasien' 
	WHERE `IdPasienrj`='$idpasienrj'";
}else{
	$str_vs = "INSERT INTO `$tbvitalsign`(`IdPasien`, `IdPasienrj`, `Keluhan`, `Anamnesa`, `Sistole`, `Diastole`, 
	`SuhuTubuh`, `TinggiBadan`, `BeratBadan`, `HeartRate`, `RespiratoryRate`, `LingkarPerut`, `IMT`) 
	VALUES ('$idpasien','$idpasienrj','$keluhan','$anamnesa','$sistole','$diastole',
	'$suhutubuh','$tinggibadan','$beratbadan','$heartrate','$resprate','$lingkarperut','$imt_pasien')";
}
// echo $str_vs;
// die();
$query = mysqli_query($koneksi, $str_vs);

// tahap 2, update statuspelayanan
mysqli_query($koneksi, "UPDATE `$tbpasienrj` SET `StatusPelayanan` = 'Proses', `StatusPulang` = '$statuspulang' WHERE `IdPasienrj` = '$idpasienrj'");	
	
// tahap 3, insert tbdiagnosa askep
$tindakanaskep = strtoupper($_POST['tindakanaskep']);
mysqli_query($koneksi, "DELETE FROM $tbdiagnosaaskep WHERE `NoRegistrasi`='$nopemeriksaan' AND `NoCM`='$nocm'");
if($kodediagnosaaskep != null){
	$no = -1;	
	foreach($kodediagnosaaskep as $kodeaskep){
	$no = $no + 1;
		$str_diagnosa_askep = "INSERT INTO `$tbdiagnosaaskep`(`TanggalDiagnosa`,`NoRegistrasi`,`NoCM`,`NamaPasien`,`JenisKelamin`,`Anamnesa`,`KodeDiagnosa`,`TindakanKeperawatan`,`NamaPerawat1`,`NamaPerawat2`) VALUES 
		('$tanggal_registrasi','$nopemeriksaan','$nocm','$namapasien','$kelaminpasien','$anamnesa','$kodediagnosaaskep[$no]','$tindakanaskep','$tenagamedis2','$tenagamedis3')";
		mysqli_query($koneksi,$str_diagnosa_askep);
	}
}	

// tahap 4, update tbpasienperpegawai
$cek_perpegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi` = '$nopemeriksaan'"));
if($cek_perpegawai == ''){
	$str_pgw = "INSERT INTO `$tbpasienperpegawai`(`TanggalRegistrasi`,`NoRegistrasi`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`)
	VALUES ('$tanggal_registrasi','$nopemeriksaan','$tenagamedisbpjs','$tenagamedis2','$tenagamedis3')";
}else{
	$str_pgw = "UPDATE `$tbpasienperpegawai` SET `NamaPegawai1` = '$tenagamedisbpjs', `NamaPegawai2` = '$tenagamedis2',
	`NamaPegawai3` = '$tenagamedis3',`Lab`='$tenagalab'
	WHERE `NoRegistrasi` = '$nopemeriksaan'";
}
mysqli_query($koneksi,$str_pgw);	

if($query){	
	echo 'sukses';
}else{
	echo 'gagal';
} 
?>