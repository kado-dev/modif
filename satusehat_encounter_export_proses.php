<?php
session_start();
include "config/koneksi.php";
include "config/helper.php";
include "config/helper_pasienrj.php";
include "config/helper_satusehat.php";

// --------------- satu sehat --------------- //
// get dok
$idpegawai_dokter = $_SESSION['idpegawai_dokter'];
$getnikDokter = mysqli_query($koneksi, "SELECT `Nik` FROM `tbpegawai` WHERE IdPegawai = '$idpegawai_dokter'");
$dtdokters = mysqli_fetch_assoc($getnikDokter);
$nikdokter = $dtdokters['Nik'];

$stsehat_access_token = $_SESSION['stsehat_access_token'];
$getDTPractitioner 	= get_Practitioner($stsehat_access_token, $nikdokter);
$IdPractitioner		= $getDTPractitioner['IdPractitioner'];
$ResourceType 		= $getDTPractitioner['ResourceType'];
$NamePractitioner 	= $getDTPractitioner['NamePractitioner'];

$tgl = $_GET['tgl'];
if($tgl == ''){
    $tgl = date('Y-m-d');
}

$tglq =  date('Y-m-d', strtotime($tgl));
$str = "SELECT * FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '$tglq' AND (IdKunjunganSatuSehat = '' OR IdKunjunganSatuSehat IS NULL) AND (`Nik`!='0' AND `Nik`!='9999999999999999' AND length(Nik) = 16)";
// echo $str;
$query = mysqli_query($koneksi, $str);

$stsupdate = array();
while($data = mysqli_fetch_assoc($query)){
    $idpasienrj = $data['IdPasienrj'];
    $nikpasien = $data['Nik'];
    $idkunjungansatusehat = $data['IdKunjunganSatuSehat'];
	// $tglregistrasi = $data['TanggalRegistrasi'];
	$tglregistrasi = date('Y-m-d', strtotime($data['TanggalRegistrasi']));
			
	$getDTpatient	= get_Patient($stsehat_access_token, $nikpasien);//get nik
	$IdPatient 		= $getDTpatient['IdPatient'];
	$ResourceType 	= $getDTpatient['ResourceType'];
	$NamePatient 	= $getDTpatient['NamePatient'];		

	$datetime = new DateTime($tglregistrasi);
	$tanggal_start = $datetime->format(DateTime::ATOM);

	$pstsehat['resourceType'] = 'Encounter';
	$pstsehat['status'] = 'arrived';//penting
	$pstsehat['class']['system'] = 'http://terminology.hl7.org/CodeSystem/v3-ActCode';
	$pstsehat['class']['code'] = 'AMB';
	$pstsehat['class']['display'] = 'ambulatory';//menunjukan rawat jalan
	$pstsehat['subject']['reference'] = 'Patient/'.$IdPatient;//penting ihs number
	$pstsehat['subject']['display'] = $NamePatient;//penting
	$pstsehat['participant'][0]['type'][0]['coding'][0]['system'] = "http://terminology.hl7.org/CodeSystem/v3-ParticipationType";
	$pstsehat['participant'][0]['type'][0]['coding'][0]['code'] = 'ATND';
	$pstsehat['participant'][0]['type'][0]['coding'][0]['display'] = 'attender';
	$pstsehat['participant'][0]['individual']['reference']= 'Practitioner/'.$IdPractitioner;//dokter kode
	$pstsehat['participant'][0]['individual']['display']= $NamePractitioner;
	$pstsehat['period']['start'] = $tanggal_start;//'2024-03-01T07:00:00+07:00';//penting, karna baru pendaftaran diisi start saja

	$Satusehat_IdLocation = '';
	$Satusehat_NameLocation = '';
	$getSidLo = mysqli_query($koneksi, "SELECT * FROM satusehat_location WHERE KodePelayanan = '27' AND `KodePuskesmas`='$kodepuskesmas'");//27 kodeplayanan pendaftaran
	if(mysqli_num_rows($getSidLo) > 0){
		$dtloks = mysqli_fetch_assoc($getSidLo);
		$Satusehat_IdLocation = $dtloks['Satusehat_IdLocation'];
		$Satusehat_NameLocation = $dtloks['NamaLokasi'].", ".$dtloks['description'];
	}

	$pstsehat['location'][0]['location']['reference'] = "Location/".$Satusehat_IdLocation;//penting
	$pstsehat['location'][0]['location']['display'] = $Satusehat_NameLocation;//penting
	$pstsehat['statusHistory'][0]['status'] = 'arrived';//penting
	$pstsehat['statusHistory'][0]['period']['start'] = $tanggal_start;//'2024-03-01T07:00:00+07:00';//penting
	$pstsehat['serviceProvider']['reference'] = 'Organization/'.$_SESSION['stsehat_orgid'];//penting
	$pstsehat['identifier'][0]['system'] = 'http://sys-ids.kemkes.go.id/encounter/'.$_SESSION['stsehat_orgid'];
	$pstsehat['identifier'][0]['value'] = $_SESSION['stsehat_orgid'];//penting

	$data_json 		= json_encode($pstsehat,true);
	$post_encounter	= simpan_satusehat($stsehat_access_token,'Encounter',$data_json);
	$dtaparse 		= json_decode($post_encounter,true);
	$id_kunjungan_satusehat	= $dtaparse['id'];

	// echo $data_json."<br/>";
	// echo $id_kunjungan_satusehat."<br/>";
	// echo $NamePractitioner."<br/>";
	// echo $NamePatient."<br/>";
	// echo $post_encounter."<br/>";
	// die();
	
	$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `IdKunjunganSatuSehat`= '$id_kunjungan_satusehat' WHERE `IdPasienrj` = '$idpasienrj'";
	mysqli_query($koneksi, $strupdatenokunjungan); 

	if($id_kunjungan_satusehat){
		$stsupdate[] = 1;
	}
}


if(count($stsupdate) > 0){
    alert_notify('sukses','Data berhasil terbridging...');
	echo "<script>";
    echo "document.location.href='index.php?page=satusehat_encounter_export&tgl=".$_GET['tgl']."'";
	echo "</script>";
}else{
	alert_notify('sukses','Jika data belum berhasil silahkan ulangi kembali...');
	echo "<script>";
    echo "document.location.href='index.php?page=satusehat_encounter_export&tgl=".$_GET['tgl']."'";
	echo "</script>";
}	



?>