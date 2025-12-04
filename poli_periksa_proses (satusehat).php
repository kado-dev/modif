<?php
error_reporting(1);
session_start();
include "config/koneksi.php";
include "config/helper.php";
include "config/helper_pasienrj.php";
include "config/helper_report.php";
include "config/helper_satusehat.php";

$kota = $_SESSION['kota'];

// jangan dipindah keatas, nnti gak jalan waktunya
if($kota == "KOTA TARAKAN" OR $kota == "KABUPATEN KUTAI KARTANEGARA"){
	date_default_timezone_set('Asia/Ujung_Pandang');
}else{
	date_default_timezone_set('Asia/Jakarta');
}

$jamperiksa = date('G:i:s');
$sts_resep = $_POST['sts_resep'];
$opsiresep = $_POST['opsiresep'];
$ket_resep_luar = '';
if($opsiresep == 'resep luar'){
	$ket_resep_luar = $_POST['ket_resep_luar'];
}

$carabayar = $_POST['asuransi'];
$pelayanan = $_POST['pelayanan'];
$nopemeriksaan = $_POST['nopemeriksaan'];
$idpasien = $_POST['idpasien'];
$idpasienrj = $_POST['idpasienrj'];
$nocm = $_POST['nocm'];
$noindex = $_POST['noindex'];
$noregistrasi = $_POST['noregistrasi'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$stsehat_orgid = $_SESSION['stsehat_orgid'];

$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
	
// tbpasienrj
$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
$tbpasienrj_retensi = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas)."_RETENSI";
$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));

// update waktu periksa selesai
mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `PemeriksaanAkhir`=NOW() WHERE `NoRegistrasi` = '$noregistrasi'");

$tanggal_registrasi = $datapasienrj['TanggalRegistrasi']; // ngikutin tanggal registrasi agar sesuai kunjungan
$tanggal_bpjs = date('d-m-Y', strtotime($datapasienrj['TanggalRegistrasi'])); // ngikutin tanggal registrasi agar sesuai kunjungan
$tanggal_time = date('Y-m-d', strtotime($tanggal_registrasi))." ".date('G:i:s');
$namapasien = $datapasienrj['NamaPasien'];
$kelaminpasien = $datapasienrj['JenisKelamin'];
$umurtahunpasien = $datapasienrj['UmurTahun'];
$umurbulanpasien = $datapasienrj['UmurBulan'];
$umurharipasien = $datapasienrj['UmurHari'];
$jeniskunjungan = $datapasienrj['JenisKunjungan'];
$normpasien = $datapasienrj['NoRM'];
$asalpasien = $datapasienrj['AsalPasien'];
$statuspasien = $datapasienrj['StatusPasien'];
$asuransi = $datapasienrj['Asuransi'];
$statuskunjungan = $datapasienrj['StatusKunjungan'];
$waktukunjungan = $datapasienrj['WaktuKunjungan'];
$kodeprovider = $datapasienrj['kdprovider'];
$nokartu = $datapasienrj['nokartu'];
$kodepoli = $datapasienrj['kdpoli'];

// tbkk
$datakk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
$alamatpasien = $datakk['Alamat'];
$kelurahanpasien = $datakk['Kelurahan'];
$kotapasien = $datakk['Kota'];

// pemeriksaan (subjective)
$anamnesa = strtoupper($_POST['anamnesa']);
$anjuran = strtoupper($_POST['anjuran']);
$pemeriksaanhasillab =  strtoupper($_POST['pemeriksaanpenunjanglab']);
if(isset($_POST['faktoresikolain'])){
	$faktorresikolainnya = implode(",",$_POST['faktoresikolain']);
}else{
	$faktorresikolainnya = '';
}

$nikpasien = '';
$getnik = mysqli_query($koneksi, "SELECT `Nik` FROM $tbpasien WHERE IdPasien = '$idpasien'");
if(mysqli_num_rows($getnik) > 0){
	$dtpasienss = mysqli_fetch_assoc($getnik);
	$nikpasien = $dtpasienss['Nik'];
}

// if($kodepuskesmas == 'P3202280201' OR $kodepuskesmas == 'P3202180201' OR $kodepuskesmas == 'P3202230101' OR $kodepuskesmas == 'P3202160201'){
// get dok
// $idpegawai_dokter = $_SESSION['idpegawai_dokter'];
// $getnikDokter = mysqli_query($koneksi, "SELECT `Nik` FROM `tbpegawai` WHERE IdPegawai = '$idpegawai_dokter'");
// if(mysqli_num_rows($getnikDokter) > 0){
// 	$dtdokters = mysqli_fetch_assoc($getnikDokter);
// 	$nikdokter = $dtdokters['Nik'];
// }

//---------------------------- SATU SEHAT -------------------------------//
// $stsehat_access_token = $_SESSION['stsehat_access_token'];
// $getDTpatient	= get_Patient($stsehat_access_token,$nikpasien);//get nik
// $IdPatient 		= $getDTpatient['IdPatient'];
// $ResourceType 	= $getDTpatient['ResourceType'];
// $NamePatient 	= $getDTpatient['NamePatient'];

// $getDTPractitioner 	= get_Practitioner($stsehat_access_token,$nikdokter);
// $IdPractitioner		= $getDTPractitioner['IdPractitioner'];
// $ResourceType 		= $getDTPractitioner['ResourceType'];
// $NamePractitioner 	= $getDTPractitioner['NamePractitioner'];

// $tglregistrasi = date('Y-m-d', strtotime($tanggal_registrasi));
// $IdKunjunganSatuSehat = $datapasienrj['IdKunjunganSatuSehat'];

//  $pstsehat_condition['resourceType'] = 'Condition';
//  $pstsehat_condition['clinicalStatus']['coding'][0]['system'] = 'http://terminology.hl7.org/CodeSystem/condition-clinical';
//  $pstsehat_condition['clinicalStatus']['coding'][0]['code'] = 'active';
//  $pstsehat_condition['clinicalStatus']['coding'][0]['display'] = 'Active';
//  $pstsehat_condition['category'][0]['coding'][0]['system'] = 'http://terminology.hl7.org/CodeSystem/condition-category';
//  $pstsehat_condition['category'][0]['coding'][0]['code'] = 'encounter-diagnosis';
//  $pstsehat_condition['category'][0]['coding'][0]['display'] = 'Encounter Diagnosis';
//  $pstsehat_condition['code']['coding'][0]['system'] = 'http://terminology.kemkes.go.id/CodeSystem/clinical-term';
//  $pstsehat_condition['code']['coding'][0]['code'] = 'MN000001';
//  $pstsehat_condition['code']['coding'][0]['display'] = 'Stabil';
//  $pstsehat_condition['subject']['reference'] = 'Patient/'.$IdPatient;
//  $pstsehat_condition['subject']['display'] = $NamePatient;
//  $pstsehat_condition['encounter']['reference'] = 'Encounter/'.$IdKunjunganSatuSehat;
//  $pstsehat_condition['encounter']['display'] = 'Kunjungan '.$NamePatient.' di tanggal, '.tgl_lengkap($tglregistrasi);

//  $data_json_cond	= json_encode($pstsehat_condition,true);
//  $post_cond			= simpan_satusehat($stsehat_access_token,'Condition',$data_json_cond);
//  $dtaparse 			= json_decode($post_cond,true);
//  $id_cond_satusehat	= $dtaparse['id'];

 // echo  $data_json_cond."<br/>";
 // echo  "------- <br/>";
 // echo  $post_cond."<br/>";
 // echo  $id_cond_satusehat."<br/>";
 // echo  "----------------------------- <br/>";
//  $pstsehat_observation['resourceType'] = 'Observation';
//  $pstsehat_observation['status'] = 'final';
//  $pstsehat_observation['category'][0]['coding'][0]['system'] = 'http://terminology.hl7.org/CodeSystem/observation-category';
//  $pstsehat_observation['category'][0]['coding'][0]['code'] = 'vital-signs';
//  $pstsehat_observation['category'][0]['coding'][0]['display'] = 'Vital Signs';
//  $pstsehat_observation['code']['coding'][0]['system'] = 'http://loinc.org';
//  $pstsehat_observation['code']['coding'][0]['code'] = '8867-4';
//  $pstsehat_observation['code']['coding'][0]['display'] = 'Heart Rate';
//  $pstsehat_observation['subject']['reference'] = 'Patient/'.$IdPatient;
//  $pstsehat_observation['performer'][0]['reference'] = 'Practitioner/'.$IdPractitioner;
//  $pstsehat_observation['encounter']['reference'] = 'Encounter/'.$IdKunjunganSatuSehat;
//  $pstsehat_observation['encounter']['display'] = 'Pemeriksaan fisik '.$NamePatient.' di tanggal, '.tgl_lengkap($tglregistrasi);
//  $pstsehat_observation['effectiveDateTime'] = date('c', strtotime($tglregistrasi));
//  $pstsehat_observation['valueQuantity']['value'] = 80;
//  $pstsehat_observation['valueQuantity']['unit'] = 'beats/minute';
//  $pstsehat_observation['valueQuantity']['system'] = 'http://unitsofmeasure.org';
//  $pstsehat_observation['valueQuantity']['code'] = '/min';

//  $data_json_obs		= json_encode($pstsehat_observation,true);
//  $post_obser		= simpan_satusehat($stsehat_access_token,'Observation',$data_json_obs);
//  $dtaparse 			= json_decode($post_obser,true);
//  $id_obs_satusehat	= $dtaparse['id'];

 // echo  $data_json_obs."<br/>";
 // echo  "------- <br/>";
 // echo  $post_obser."<br/>";
 // echo  $id_obs_satusehat."<br/>";
 // die();

//  $pstsehat_procedure['resourceType'] = 'Procedure';
//  $pstsehat_procedure['status'] = 'completed';
//  $pstsehat_procedure['category']['coding'][0]['system'] = 'http://snomed.info/sct';
//  $pstsehat_procedure['category']['coding'][0]['code'] = '103693007';
//  $pstsehat_procedure['category']['coding'][0]['display'] = 'Diagnostic procedure';
//  $pstsehat_procedure['category']['text'] = 'Prosedur Diagnosa';
//  //tindakan
//  $pstsehat_procedure['code']['coding'][0]['system'] = 'http://hl7.org/fhir/sid/icd-9-cm';
//  $pstsehat_procedure['code']['coding'][0]['code'] = '87.44';
//  $pstsehat_procedure['code']['coding'][0]['display'] = 'Routine chest x-ray, so described';
//  $pstsehat_procedure['subject']['reference'] = 'Patient/'.$IdPatient;
//  $pstsehat_procedure['subject']['display'] = $NamePatient;
//  $pstsehat_procedure['encounter']['reference'] = 'Encounter/'.$IdKunjunganSatuSehat;
//  $pstsehat_procedure['performedPeriod']['start'] = date('c', strtotime($tglregistrasi));
//  $pstsehat_procedure['performedPeriod']['end'] = date('c', strtotime($tglregistrasi));
//  $pstsehat_procedure['performer'][0]['actor']['reference'] = 'Practitioner/'.$IdPractitioner;
//  $pstsehat_procedure['performer'][0]['actor']['display'] = $NamePractitioner;
//  //alasan tindakan
//  $pstsehat_procedure['reasonCode'][0]['coding'][0]['system'] = 'http://hl7.org/fhir/sid/icd-10';
//  $pstsehat_procedure['reasonCode'][0]['coding'][0]['code'] = 'A15.0';
//  $pstsehat_procedure['reasonCode'][0]['coding'][0]['display'] = 'Tuberculosis of lung, confirmed by sputum microscopy with or without culture';
//  //lokasi anatomi dari pemberian tindakan, bisa lebih dari satu
//  $pstsehat_procedure['bodySite'][0]['coding'][0]['system'] = 'http://snomed.info/sct';
//  $pstsehat_procedure['bodySite'][0]['coding'][0]['code'] = '27033000';
//  $pstsehat_procedure['bodySite'][0]['coding'][0]['display'] = 'Lower abdomen structure';
//  // $pstsehat_procedure['bodySite'][0]['coding'][1]['system'] = 'http://snomed.info/sct';
//  // $pstsehat_procedure['bodySite'][0]['coding'][1]['code'] = '35039007';
//  // $pstsehat_procedure['bodySite'][0]['coding'][1]['display'] = 'Uterine structure';
//  $pstsehat_procedure['note'][0]['text'] = 'Tindakan persalinan caesar emergensi';
  
//  $data_json_proce	= json_encode($pstsehat_procedure,true);
//  $post_proce		= simpan_satusehat($stsehat_access_token,'Procedure',$data_json_proce);
//  $dtaparse 			= json_decode($post_proce,true);
//  $id_pro_satusehat	= $dtaparse['id'];

 // echo  $data_json_proce."<br/>";
 // echo  "------- <br/>";
 // echo  $post_proce."<br/>";
 // echo  $id_pro_satusehat."<br/>";
 // die();

// $kdobatlokal = $_POST['kodeobatlokal'];
// foreach($kdobatlokal as $kdbrg){
// 	// panggil ref obat lplpo
// 	$getobatmaster = mysqli_query($koneksi, "SELECT * FROM `ref_obat_lplpo` WHERE `KodeBarang` = '$kdbrg'");	
// 	if(mysqli_num_rows($getobatmaster) > 0){
// 		$dtmasterobat = mysqli_fetch_assoc($getobatmaster);

// 		$dtobatpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang` = '$kdbrg'"));
// 		$idMedication_satusehat	= $dtobatpuskesmas['idMedication_satusehat'];
// 		if($idMedication_satusehat == '' OR $idMedication_satusehat == '0'){

// 			$pstsehat_medic['resourceType'] = 'Medication';
// 			$pstsehat_medic['meta']['profile'][0] = 'https://fhir.kemkes.go.id/r4/StructureDefinition/Medication';
// 			$pstsehat_medic['identifier'][0]['system'] = 'http://sys-ids.kemkes.go.id/medication/'.$stsehat_orgid;
// 			$pstsehat_medic['identifier'][0]['use'] = 'official';
// 			$pstsehat_medic['identifier'][0]['value'] = $kdbrg;//Berisi ID lokal obat yang disimpan di sistem internal masing-masing organisasi.
// 			//Berisi data kode obat yang digunakan akan menggunakan kode obat yang tersedia pada KFA
// 			$pstsehat_medic['code']['coding'][0]['system'] = 'http://sys-ids.kemkes.go.id/kfa';
// 			$pstsehat_medic['code']['coding'][0]['code'] = $dtmasterobat['IdKfa'];
// 			$pstsehat_medic['code']['coding'][0]['display'] = $dtmasterobat['namekfa'];
// 			$pstsehat_medic['status'] = 'active';
// 			$pstsehat_medic['manufacturer']['reference'] = 'Organization/'.$stsehat_orgid;
// 			//Berisi data yang menjelaskan bentuk dari sediaan obat
// 			$pstsehat_medic['form']['coding'][0]['system'] = 'http://terminology.kemkes.go.id/CodeSystem/medication-form';
// 			$pstsehat_medic['form']['coding'][0]['code'] = $dtmasterobat['dosiscodekfa'];
// 			$pstsehat_medic['form']['coding'][0]['display'] = $dtmasterobat['dosisnamekfa'];

// 			$pstsehat_medic['ingredient'][0]['itemCodeableConcept']['coding'][0]['system'] = 'http://sys-ids.kemkes.go.id/kfa';
// 			$pstsehat_medic['ingredient'][0]['itemCodeableConcept']['coding'][0]['code'] = $dtmasterobat['IdKfa'];
// 			$pstsehat_medic['ingredient'][0]['itemCodeableConcept']['coding'][0]['display'] = $dtmasterobat['namekfa'];
// 			$pstsehat_medic['ingredient'][0]['isActive'] = true;
// 			$pstsehat_medic['ingredient'][0]['strength']['numerator']['value'] = 150;
// 			$pstsehat_medic['ingredient'][0]['strength']['numerator']['system'] = "http://unitsofmeasure.org";
// 			$pstsehat_medic['ingredient'][0]['strength']['numerator']['code'] = "mg";
// 			$pstsehat_medic['ingredient'][0]['strength']['denominator']['value'] = 1;
// 			$pstsehat_medic['ingredient'][0]['strength']['denominator']['system'] = "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm";
// 			$pstsehat_medic['ingredient'][0]['strength']['denominator']['code'] = "TAB";

// 			$pstsehat_medic['extension'][0]['url'] = 'https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType';
// 			$pstsehat_medic['extension'][0]['valueCodeableConcept']['coding'][0]['system'] = 'http://terminology.kemkes.go.id/CodeSystem/medication-type';
// 			$pstsehat_medic['extension'][0]['valueCodeableConcept']['coding'][0]['code'] = 'NC';
// 			$pstsehat_medic['extension'][0]['valueCodeableConcept']['coding'][0]['display'] = 'Non-compound';

// 			$data_json_medic	= json_encode($pstsehat_medic,true);
// 			$post_medic			= simpan_satusehat($stsehat_access_token,'Medication',$data_json_medic);
// 			$dtaparse 			= json_decode($post_medic,true);
// 			$id_medic_satusehat	= $dtaparse['id'];		

// 			// echo  $data_json_medic."<br/>";
// 			// echo  "------- <br/>";
// 			// echo  $post_medic."<br/>";
// 			// echo  "------- <br/>";
// 			// die();

// 			//update tbapotikstok_puskesmas
// 			// echo "UPDATE `$tbapotikstok` SET idMedication_satusehat = '$id_medic_satusehat' WHERE `KodeBarang` = '$kdbrg'";
// 			// die();
// 			mysqli_query($koneksi, "UPDATE `$tbapotikstok` SET idMedication_satusehat = '$id_medic_satusehat' WHERE `KodeBarang` = '$kdbrg'");
	
// 		}else{
// 			$id_medic_satusehat	= $idMedication_satusehat;
// 		}

// 		//  echo  "id_medic_satusehat: ".$id_medic_satusehat."<br/>";
// 		//  echo  "------- <br/>";
// 		//  echo  "------- <br/>";
// 		//  die();

// 		$pstsehat_medicrequest['resourceType'] = 'MedicationRequest';
// 		$pstsehat_medicrequest['identifier'][0]['system'] = 'http://sys-ids.kemkes.go.id/prescription/'.$stsehat_orgid;
// 		$pstsehat_medicrequest['identifier'][0]['use'] = 'official';
// 		$pstsehat_medicrequest['identifier'][0]['value'] = $kdbrg;//Berisi ID lokal obat yang disimpan di sistem internal masing-masing organisasi.
// 		$pstsehat_medicrequest['identifier'][0]['system'] = 'http://sys-ids.kemkes.go.id/prescription-item/'.$stsehat_orgid;
// 		$pstsehat_medicrequest['identifier'][0]['use'] = 'official';
// 		$pstsehat_medicrequest['identifier'][0]['value'] = '123456788-1';
// 		$pstsehat_medicrequest['status'] = 'completed';
// 		$pstsehat_medicrequest['intent'] = 'order';
// 		$pstsehat_medicrequest['category'][0]['coding'][0]['system'] = 'http://terminology.hl7.org/CodeSystem/medicationrequest-category';
// 		$pstsehat_medicrequest['category'][0]['coding'][0]['code'] = 'outpatient';
// 		$pstsehat_medicrequest['category'][0]['coding'][0]['display'] = 'Outpatient';
// 		$pstsehat_medicrequest['priority'] = 'routine';
// 		$pstsehat_medicrequest['medicationReference']['reference'] = 'Medication/'.$id_medic_satusehat;
// 		$pstsehat_medicrequest['medicationReference']['display'] = $dtmasterobat['namekfa'];
// 		$pstsehat_medicrequest['subject']['reference'] = 'Patient/'.$IdPatient;
// 		$pstsehat_medicrequest['subject']['display'] = $NamePatient;
		
// 		$pstsehat_medicrequest['encounter']['reference'] = 'Encounter/'.$IdKunjunganSatuSehat;
// 		$pstsehat_medicrequest['authoredOn'] = date('c', strtotime($tglregistrasi));

// 		$pstsehat_medicrequest['requester']['reference'] = 'Practitioner/'.$IdPractitioner;
//  		$pstsehat_medicrequest['requester']['display'] = $NamePractitioner;

//  		$pstsehat_medicrequest['dispenseRequest']['dispenseInterval']['value'] = 1;
//  		$pstsehat_medicrequest['dispenseRequest']['dispenseInterval']['unit'] = "days";
//  		$pstsehat_medicrequest['dispenseRequest']['dispenseInterval']['system'] = "http://unitsofmeasure.org";
//  		$pstsehat_medicrequest['dispenseRequest']['dispenseInterval']['code'] = "d";
// 		$pstsehat_medicrequest['dispenseRequest']['performer']['reference'] = 'Organization/'.$stsehat_orgid;
		 
	
// 		$data_json_medicrequest	= json_encode($pstsehat_medicrequest,true);
// 		$post_medicrequest		= simpan_satusehat($stsehat_access_token,'MedicationRequest',$data_json_medicrequest);
// 		$dtaparse 			= json_decode($post_medicrequest,true);
// 		$id_medicrequest_satusehat	= $dtaparse['id'];
	
// 		// echo  $data_json_medicrequest."<br/>";
// 		// echo  "------- <br/>";
// 		// echo  $post_medicrequest."<br/>";
// 		// echo  "id_medicrequest_satusehat: ".$id_medicrequest_satusehat."<br/>";
// 		// die();

// 	}

// }

//---------------------------- SATU SEHAT -------------------------------//
// }

$riwayatpenyakitsekarang = strtoupper($_POST['riwayatpenyakitsekarang']);
$riwayatpenyakitdulu = strtoupper($_POST['riwayatpenyakitdulu']);
$riwayatpenyakitkeluarga = strtoupper($_POST['riwayatpenyakitkeluarga']);
$riwayatalergimakanan = strtoupper($_POST['riwayatalergimakanan']);
$riwayatalergiobat = strtoupper($_POST['riwayatalergiobat']);

// pemeriksaan fisik (objective)
$disabilitas = $_POST['disabilitas'];
$kesadaran = $_POST['kesadaran'];
$kepala = $_POST['kepala'];
$mata = $_POST['mata'];
$hidung = $_POST['hidung'];
$telinga = $_POST['telinga'];
$mulut = $_POST['mulut'];
$leher = $_POST['leher'];
$dada = $_POST['dada'];
$punggung = $_POST['punggung'];
$cp = $_POST['cp'];
$perut = $_POST['perut'];
$hl = $_POST['hl'];
$kelamin = $_POST['kelamin'];
$exatas = $_POST['exatas'];
$exbawah = $_POST['exbawah'];
$lokalis = $_POST['lokalis'];
$effloresensi = $_POST['effloresensi'];
$diagnosa = $_POST['namadiagnosabpjs'];
$jsondiagnosa =  json_encode($diagnosa);
$therapy = $_POST['namaobatbpjs'];
$jsontherapy =  json_encode($therapy);
$keadaanumum = $_POST['keadaanumum'];
$statusgizi = $_POST['statusgizi'];
$pemeriksaanpenunjangobj = $_POST['pemeriksaanpenunjangobj'];

// rencana pengelolaan (planning)
$rencanapengelolaan = $_POST['rencanapengelolaan'];
$prognosis = $_POST['prognosis'];
$informasieso = $_POST['informasieso'];
$edukasi = $_POST['edukasi'];

// poli bersalin
$usiakehamilan = $_POST['usiakehamilan'];
$penolongpersalinan = $_POST['penolongpersalinan'];
$keadaanlahir = $_POST['keadaanlahir'];
$caralahir = $_POST['caralahir'];
$jeniskelaminbayi = $_POST['jeniskelaminbayi'];
$bb_bayi = $_POST['bb_bayi'];
$pb_bayi = $_POST['pb_bayi'];
$plasenta = $_POST['plasenta'];
$nifas = $_POST['nifas'];
$keterangan_rwt = $_POST['keterangan_rwt'];

// poli kia
$sts_pemeriksaan_kia = $_POST['sts_pemeriksaan_kia'];
$anjuran_kia = $_POST['anjuran_kia'];
$beratbadan_kia = $_POST['beratbadan_kia'];
$tinggibadan_kia = $_POST['tinggibadan_kia'];
$tekanandarah_kia = $_POST['tekanandarah_kia'];
$lila_kia = $_POST['lila_kia'];
$tt_kia = $_POST['tt_kia'];
$fe_kia = $_POST['fe_kia'];
$kunjungan_kehamilan = $_POST['kunjungan_kehamilan'];
$deteksi_resiko = $_POST['deteksi_resiko'];
$faktorresiko_kia = $_POST['faktorresiko_kia'];
$faktorresikodesc_kia = $_POST['faktorresikodesc_kia'];
$komplikasi_kia = $_POST['komplikasi_kia'];
$rujuk_komplikasi = $_POST['rujuk_komplikasi'];
$gravida = $_POST['gravida'];
$partus = $_POST['partus'];
$abortus = $_POST['abortus'];
$hpht_kia = $_POST['hpht_kia'];
$p4k = $_POST['p4k'];
$usiakehamilan_kia = $_POST['usiakehamilan_kia'];
$trimester_kia = $_POST['trimester_kia'];
$tfu_kia = $_POST['tfu_kia'];
$statusgizi_kia = $_POST['statusgizi_kia'];
$reflekspatella_kia = $_POST['reflekspatella_kia'];
$riwayatsc_kia = $_POST['riwayatsc_kia'];
$djj_kia = $_POST['djj_kia'];
$djj_kia_ganda = $_POST['djj_kia_ganda'];
$kepalathd_kia = $_POST['kepalathd_kia'];
$tbj_kia = $_POST['tbj_kia'];
$jumlahjanin_kia = $_POST['jumlahjanin_kia'];
$presentasi_kia = $_POST['presentasi_kia'];
$injeksitt_kia = $_POST['injeksitt_kia'];
$buku_kia = $_POST['buku_kia'];
$fetab_kia = $_POST['fetab_kia'];
$k1hb_kia = $_POST['k1hb_kia'];
$proturine_kia = $_POST['proturine_kia'];
$guladarah_kia = $_POST['guladarah_kia'];
$k4hb_kia = $_POST['k4hb_kia'];
$sifilis_kia = $_POST['sifilis_kia'];
$hbsag_kia = $_POST['hbsag_kia'];
$goldarah_kia = $_POST['goldarah_kia'];
$hiv_kia = $_POST['hiv_kia'];
$pptest_kia = $_POST['pptest_kia'];
$malaria_kia = $_POST['malaria_kia'];
$asamurat_kia = $_POST['asamurat_kia'];
$gds_kia = $_POST['gds_kia'];
$nokohort_kia = $_POST['nokohort_kia'];
$noresti_kia = $_POST['noresti_kia'];

// diare
$tandabahaya_diare = $_POST['tandabahaya_diare'];
$lamadiare_diare = $_POST['lamadiare_diare'];
$klasifikasi_diare = $_POST['klasifikasi_diare'];
$rujuk_diare = $_POST['rujuk_diare'];
$nakes = $_POST['nakes'];
$diareoralit = $_POST['diareoralit'];
$diareinfus = $_POST['diareinfus'];
$diarezinc = $_POST['diarezinc'];
$diarezincsyr = $_POST['diarezincsyr'];
$diareantibiotik = $_POST['diareantibiotik'];
$obatlain_diare = $_POST['obatlain_diare'];
$keterangan_diare = $_POST['keterangan_diare'];

// ispa
$klasifikasi_ispa = $_POST['klasifikasi_ispa'];
$tindaklanjut_ispa = $_POST['tindaklanjut_ispa'];
$antibiotik_ispa = $_POST['antibiotik_ispa'];
$kondisikunjulang_ispa = $_POST['kondisi_kunjungang_ulang_ispa'];
$ketmeninggal_ispa = $_POST['keteranganmeninggal_ispa'];
$ispa_ispa = $_POST['Ispalebih5thn_ispa'];

// campak
$vaksincampak_campak = $_POST['vaksincampak_campak'];
$tgltimbuldemam_campak = tgl_format($_POST['tgltimbuldemam_campak']);
$tgltimbulrash_campak = tgl_format($_POST['tgltimbulrash_campak']);
$tglspesimendarah_campak = tgl_format($_POST['tglspesimendarah_campak']);
$tglspesimenurin_campak = tgl_format($_POST['tglspesimenurin_campak']);
$hasilspesimendarah_campak = $_POST['hasilspesimendarah_campak'];
$hasilspesimenurin_campak = $_POST['hasilspesimenurin_campak'];
$vitamina_campak = $_POST['vitamina_campak'];
$keadaan_campak = $_POST['keadaan_campak'];
$klasifikasifinal_campak = $_POST['klasifikasifinal_campak'];

// ptm
$ptm_darah = $_POST['ptm_darah'];
$ptm_merokok = $_POST['ptm_merokok'];
$ptm_fisik = $_POST['ptm_fisik'];
$ptm_makan_sayur = $_POST['ptm_makan_sayur'];
$ptm_alkohol = $_POST['ptm_alkohol'];

if($_POST['ket_form_diagnosa'] == 'diare'){
	$strdiagnosapasien = "INSERT INTO `tbdiagnosadiare`(`TanggalRegistrasi`,`NoRegistrasi`,`NamaPasien`,`Kelamin`,`UmurTahun`,`UmurBulan`,`Kelurahan`,`BeratBadan`,`SuhuBadan`,
	`Kunjungan`,`TandaBahaya`,`LamaDiare`,`Klasifikasi`,`Rujuk`,`Oralit`,`Infus`,`Zinc`,`ZincSyr`,`Antibiotik`,`ObatLain`,`Keterangan`,`Nakes`)
	VALUES('$tanggal_registrasi','$noregistrasi','$namapasien','$kelaminpasien','$umurtahunpasien','$umurbulanpasien','$kelurahanpasien','$beratbadan','$suhutubuh',
	'$statuskunjungan','$tandabahaya_diare','$lamadiare_diare','$klasifikasi_diare','$rujuk_diare','$diareoralit','$diareinfus','$diarezinc','$diarezincsyr','$diareantibiotik',
	'$obatlain_diare','$keterangan_diare','$nakes')";
}else if($_POST['ket_form_diagnosa'] == 'ispa'){
	$strdiagnosapasien = "INSERT INTO `tbdiagnosaispa`(`TanggalRegistrasi`,`NoIndex`,`NoRegistrasi`,`NamaPasien`,`UmurTahun`,`Alamat`,`Kelurahan`,`Kota`,
	`Kunjungan`, `Kelamin`, `FrekuensiNafas`,`Klasifikasi`,`TindakLanjut`,`AntiBiotik`,`KondisiKujunganUlang`,`KeteranganMeninggal`,`Ispa5tahun`)
	VALUES('$tanggal_registrasi','$noindex','$noregistrasi','$namapasien','$umurtahunpasien','$alamatpasien','$kelurahanpasien','$kotapasien',
	'$statuskunjungan','$kelaminpasien','$resprate','$klasifikasi_ispa','$tindaklanjut_ispa','$antibiotik_ispa','$kondisikunjulang_ispa',
	'$ketmeninggal_ispa','$ispa_ispa')";
}else if($_POST['ket_form_diagnosa'] == 'campak'){
	$strdiagnosapasien = "INSERT INTO `tbdiagnosacampak`(`TanggalRegistrasi`,`NoRegistrasi`, `NamaPasien`, `NamaOrangTua`,`Kelamin`, `VaksinCampak`,`TanggalTimbulDemam`,`TanggalTimbulRash`,`TanggalSpesimenDarah`,`TanggalSpesimenUrin`,`HasilSpesimenDarah`,`HasilSpesimenUrin`,`VitaminA`,`KeadaanAkhir`,`KlasifikasiDetail`) VALUES
	('$tanggal_registrasi','$noregistrasi','$namapasien','-','$kelaminpasien','$vaksincampak_campak','$tgltimbuldemam_campak','$tgltimbulrash_campak','$tglspesimendarah_campak','$tglspesimenurin_campak','$hasilspesimendarah_campak','$hasilspesimenurin_campak','$vitamina_campak','$keadaan_campak','$klasifikasifinal_campak')";
}else if($_POST['ket_form_diagnosa'] == 'ptm'){
	$strdiagnosapasien = "INSERT INTO `tbdiagnosaptm`(`TanggalRegistrasi`,`NoRegistrasi`, `NamaPasien`, `UmurTahun`,`Alamat`, `Kelamin`,`Darah`,`Merokok`,`AktifitasFisik`,`KuranMakanSayur`,`KonsumsiAlkohol`,`BB`,`TB`,`LingkarPerut`,`Sistole`,`Diastole`) VALUES
	('$tanggal_registrasi','$noregistrasi','$namapasien','$umurtahunpasien','$alamatpasien','$kelaminpasien','$ptm_darah','$ptm_merokok','$ptm_fisik','$ptm_makan_sayur','$ptm_alkohol','$beratbadan','$tinggibadan','$lingkarperut','$sistole','$diastole')";
}	
//echo $strdiagnosapasien;
// die();

// disabilitas
if($disabilitas != ''){
	$str_disabilitas = "INSERT INTO `tbpasiendisabilitas` (`TanggalPeriksa`,`NoRegistrasi`,`NoIndex`,`NoCM`,`KelompokDisabilitas`)
	VALUES ('$tanggal_registrasi','$noregistrasi','$noindex','$nocm','$disabilitas')";
	mysqli_query($koneksi, $str_disabilitas);
}

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

$rujukinternal =  $_POST['poliinternal'];
$rujukinternal2 =  $_POST['poliinternal2'];
$rujukinternal3 =  $_POST['poliinternal3'];
$rujukinternal4 =  $_POST['poliinternal4'];
$rujukinternal5 =  $_POST['poliinternal5'];
$rujuklanjut = $_POST['polilanjut'];//manggil get_rujuk_lanjut-->kdProvider
$namapegawai = $_SESSION['username'];
$tenagamedis1 = mysqli_real_escape_string($koneksi, $_POST['tenagamedis1']);
$tenagamedisbpjs = mysqli_real_escape_string($koneksi, $_POST['tenagamedisbpjs']); //nama tenaga medis bpjs
$tenagamedis2 = mysqli_real_escape_string($koneksi, $_POST['tenagamedis2']);
$tenagamedis3 = mysqli_real_escape_string($koneksi, $_POST['tenagamedis3']);
$tenagalab = mysqli_real_escape_string($koneksi, $_POST['tenagalab']);
$tgl = date('Y-m-d');	
$umurtahun = $_POST['umurtahun'];
$umurbulan = $_POST['umurbulan'];
// $asuransi = $_POST['asuransi']; // diganti baris 59
$nip = $_SESSION['username'];

// bridging bpjs
$nokartu = $_POST['nokartubpjs'];
$kdpoli = $_POST['poli_bpjs'];
$keluhan = $_POST['anamnesa'];
$kdSadar =$_POST['kesadaran'];
if($_POST['namaobatbpjs'] != null){
	$terapi= implode(',',$_POST['namaobatbpjs']);
}else{
	$terapi= "-";
}
$kdProviderRujukLanjut= $_POST['polilanjut'];
$kdStatusPulang=$_POST['statuspulang'];
$tglPulang = date('d-m-Y', strtotime($datapasienrj['TanggalRegistrasi']));
$kdDokter=$_POST['tenagamedis1'];
$kddiagnosabpjs = $_POST['kodediagnosabpjs'];
$kelompok = $_POST['kelompokdiagnosa'];
$kdtacc = $_POST['kodetacc'];
$alasantacc = $_POST['alasantacc'];
$kondisi_rujukan = $_POST['kondisi'];
$kdppk = $datapasienrj['kdprovider'];

$kdsubspesialis_spesial = $_POST['sub-spesialis'];
$spesialis = $_POST['spesialis'];
$kdsarana = $_POST['sarana'];
if($kdsarana == 0){
	$kdsarana = null;
}
if($kdtacc == null){
	$kdtacc = -1; // Tanpa TACC
	$alasantacc = null;
}

$kdkhusus = $_POST['kategori-kondisi'];
$kdsubspesialis_khusus = $_POST['kategori-kondisi'];
$catatan = $_POST['catatan-kondisi'];
	
// proses urut diagnosa
$primaryKelompok = array_search(1,$kelompok);
$sekunderKelompok = array_search(2,$kelompok);
$komplikasiKelompok = array_search(5,$kelompok);
$kdDiag1=$kddiagnosabpjs[0];
$kdDiag2=$kddiagnosabpjs[1];
$kdDiag3=$kddiagnosabpjs[2];
$kdPoliRujukLanjut=$_POST['polilanjut2'];

// vital sign
$sistole = $_POST['sistole'];
$diastole = $_POST['diastole'];
$suhutubuh = $_POST['suhutubuh'];
$tinggibadan = $_POST['tinggibadan'];
$beratbadan = $_POST['beratbadan'];
$heartrate = $_POST['heartrate'];
$resprate = $_POST['resprate'];
$lingkarperut = $_POST['lingkarperut'];
$imt_pasien = $_POST['imt'];

$str_vs = "INSERT INTO `$tbvitalsign`(`IdPasien`, `IdPasienrj`, `Sistole`, `Diastole`, `SuhuTubuh`, `TinggiBadan`, 
`BeratBadan`, `HeartRate`, `RespiratoryRate`, `LingkarPerut`, `IMT`) 
VALUES ('$idpasien','$idpasienrj','$sistole','$diastole','$suhutubuh','$tinggibadan',
'$beratbadan','$heartrate','$resprate','$lingkarperut','$imt_pasien')";
mysqli_query($koneksi, $str_vs);

if($pelayanan == 'POLI UMUM'){
	mysqli_query($koneksi, "DELETE FROM $tbpoliumum WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");	
	$str = "INSERT INTO `$tbpoliumum`(`IdPasienrj`,`TanggalPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`KeadaanUmum`,`StatusGizi`,`PemeriksaanPenunjang`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RiwayatPenyakitSekarang`,`RiwayatPenyakitDulu`,`RiwayatPenyakitKeluarga`,`FaktorResikoLainnya`,`RiwayatAlergiMakanan`,`RiwayatAlergiObat`,
	`RencanaPengelolaan`,`Prognosis`,`InformasiEso`,`Edukasi`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$idpasienrj','$tanggal_time','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$keadaanumum','$statusgizi','$pemeriksaanpenunjangobj','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
	'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$riwayatpenyakitsekarang','$riwayatpenyakitdulu','$riwayatpenyakitkeluarga','$faktorresikolainnya',
	'$riwayatalergimakanan','$riwayatalergiobat','$rencanapengelolaan','$prognosis','$informasieso','$edukasi','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
		
	// update polirujukan dan tbpasienrj
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if($pelayanan == 'POLI ANAK'){
	mysqli_query($koneksi, "DELETE FROM `tbpolianak` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpolianak`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan',
	'$heartrate','$resprate','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut','$leher','$dada',
	'$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);	
		
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if($pelayanan == 'POLI BERSALIN'){
	mysqli_query($koneksi, "DELETE FROM `tbpolibersalin` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpolibersalin`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`, `Anamnesa`,
	`Anjuran`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`DetakNadi`,`RR`,`LingkarPerut`,
	`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,`HL`,`Kelamin`,`ExAtas`,`ExBawah`,
	`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$anamnesa','$anjuran',
	'$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan','$heartrate','$resprate','$lingkarperut',
	'$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut','$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas',
	'$exbawah','$lokalis','$effloresensi','$jsontherapy','$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut',
	'$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	// insert tbpolibersalin
	if($usiakehamilan != '' OR $penolongpersalinan != ''){
		$str_rwtbersalin ="INSERT INTO `tbpolibersalinriwayat`(`TanggalPersalinan`,`JamPersalinan`,`NoPemeriksaan`, `NoIndex`, `NoCM`,
		`NamaPasien`, `UsiaKehamilan`, `PenolongPersalinan`, `KeadaanLahir`, `CaraLahir`, `JenisKelamin`, `BeratBadan`,
		`PanjangBadan`, `PlasentaLahir`, `Nifas`, `Keterangan`)
		VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
		'$usiakehamilan','$penolongpersalinan','$keadaanlahir','$caralahir','$jeniskelaminbayi','$bb_bayi','$pb_bayi',
		'$plasenta','$nifas','$keterangan_rwt')";
		mysqli_query($koneksi,$str_rwtbersalin);
	}
	
	//update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if($pelayanan == 'POLI GIGI'){	
	$rencanaterapi = $_POST['rencanaterapi'];
	$informedconsent = $_POST['ic'];
	$tindakangigi = $_POST['tindakangigi'];
	$tekanandarah = $_POST['tekanandarah'];
	$tindaklanjut1 = $_POST['tindaklanjut1'];
	$tindaklanjut2 = $_POST['tindaklanjut2'];
	$kunjunganulang = $_POST['anjurankunj'];
	$tindaklanjutRujuk = $_POST['jikarujuk'];
	$kunjungangigi = $_POST['kunjungangigi'];
	$terimarujukan = $_POST['terimarujukan'];
	$palpasi = $_POST['palpasi'];
	$suhukulit = $_POST['suhukulit'];
	$bibirgigi = $_POST['bibirgigi'];
	$kelenjarlinfe = $_POST['kelenjarlinfe'];
	$tmj = $_POST['tmj'];
	$trismus = $_POST['trismus'];
	$kettambahanekstra = $_POST['kettambahanekstra'];
	$kariesgigi = $_POST['kariesgigi'];
	$sondase = $_POST['sondase'];
	$perkusi = $_POST['perkusi'];
	$tekananintraoral = $_POST['tekananintraoral'];
	$goyangintraoral = $_POST['goyangintraoral'];
	$warnagusi = $_POST['warnagusi'];
	$konstensi = $_POST['konstensi'];
	$bengkakgigi = $_POST['bengkakgigi'];
	$kettambahanintra = $_POST['kettambahanintra'];
	
	mysqli_query($koneksi, "DELETE FROM `$tbpoligigi` WHERE `IdPasienrj`='$idpasienrj'");
	$str = "INSERT INTO `$tbpoligigi`(`IdPasienrj`,`TanggalPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Kesadaran`,`RencanaTerapi`,`InformedConsent`,`Tindakan`,`Palpasi`,`SuhuKulit`,`Bibir`,`KelenjarLinfe`,
	`Tmj`,`Trismus`,`KeteranganTambahanEkstra`,`KariesGigi`,`Sondase`,`Perkusi`,`Tekanan`,`Goyang`,`WarnaGusi`,`Konstensi`,
	`Bengkak`,`KeteranganTambahanIntra`,`TindakLanjut1`,`TindakLanjut2`,`KunjunganUlang`,`StatusKunjungan`,`TindakLanjutRujuk`,
	`KunjunganGigi`,`TerimaRujukan`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RiwayatPenyakitSekarang`,`RiwayatPenyakitDulu`,`RiwayatPenyakitKeluarga`,`FaktorResikoLainnya`,`RiwayatAlergiMakanan`,`RiwayatAlergiObat`,
	`RencanaPengelolaan`,`Prognosis`,`InformasiEso`,`Edukasi`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$idpasienrj','$tanggal_time','$nopemeriksaan','$noindex','$nocm',
	'$namapasien','$kelaminpasien','$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$kesadaran','$rencanaterapi','$informedconsent','$tindakangigi',
	'$palpasi','$suhukulit','$bibirgigi','$kelenjarlinfe','$tmj','$trismus','$kettambahanekstra',
	'$kariesgigi','$sondase','$perkusi','$tekananintraoral','$goyangintraoral','$warnagusi','$konstensi','$bengkakgigi','$kettambahanintra',
	'$tindaklanjut1','$tindaklanjut2','$kunjunganulang','$statuskunjungan','$tindaklanjutRujuk','$kunjungangigi','$terimarujukan','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$riwayatpenyakitsekarang','$riwayatpenyakitdulu','$riwayatpenyakitkeluarga','$faktorresikolainnya',
	'$riwayatalergimakanan','$riwayatalergiobat','$rencanapengelolaan','$prognosis','$informasieso','$edukasi','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);

	// simpan simbol odontogram
	$nogigi_odontogram = $_POST['nogigi_odontogram'];
	$nogigi_odontogram_keterangan = $_POST['nogigi_odontogram_keterangan'];
	foreach($nogigi_odontogram as $nogigi => $val_odon){
		$ng_keterangan = $nogigi_odontogram_keterangan[$nogigi];
		mysqli_query($koneksi, "INSERT INTO `tbpoligigi_odontogram`(`IdPasien`, `NoGigi`, `IdOdontogram`, `Keterangan`) VALUES ('$idpasien','$nogigi','$val_odon','$ng_keterangan')");
	}
	
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if($pelayanan == 'POLI GIZI'){	
	$tanggalpenimbangan = date('Y-m-d', strtotime($_POST['tanggalpenimbangan']));
	$lingkarkepala = $_POST['lingkarkepala'];
	$bblahir = $_POST['bblahir'];
	$bbi = $_POST['bbi'];
	$pblahir = $_POST['pblahir'];
	$imt = $_POST['imt'];
	$ntob = $_POST['ntob'];
	$bbu = $_POST['bbu'];
	$tbu = $_POST['tbu'];
	$imtu = $_POST['imtu'];
	$bbtb = $_POST['bbtb'];
	$bgm = $_POST['bgm'];
	$statusgizi = $_POST['statusgizi'];
	$tindakangizi = $_POST['tindakangizi'];
	$asi = $_POST['asi'];
	$imd = $_POST['imd'];
	$lilalika = $_POST['lilalika'];
	$usiakehamilan = $_POST['usiakehamilan'];
	$labhb = $_POST['labhb'];
	$riwayatgizi = $_POST['riwayatgizi'];
	$diagnosagizi = $_POST['diagnosagizi'];
	$terapidiet = $_POST['terapidiet'];
	$makanpagi = $_POST['makanpagi'];
	$makansiang = $_POST['makansiang'];
	$makanmalam = $_POST['makanmalam'];
	$seringngemil = $_POST['seringngemil'];
	$jikangemil = $_POST['jikangemil'];
	$alergimakanan = $_POST['alergimakanan'];
	$makananpokok = $_POST['makananpokok'];
	$laukhewani = $_POST['laukhewani'];
	$lauknabati = $_POST['lauknabati'];
	$sayur = $_POST['sayur'];
	$buah = $_POST['buah'];
	$minuman = $_POST['minuman'];
	$energi = $_POST['energi'];
	$protein = $_POST['protein'];
	$lemak = $_POST['lemak'];
	$karbohidrat = $_POST['karbohidrat'];
	$makanpagirecall = $_POST['makanpagirecall'];
	$snackpagirecall = $_POST['snackpagirecall'];
	$makansiangrecall = $_POST['makansiangrecall'];
	$snacksorerecall = $_POST['snacksorerecall'];
	$makansoremalamrecall = $_POST['makansoremalamrecall'];
	$snackmalamrecall = $_POST['snackmalamrecall'];
	$energirecall = $_POST['energirecall'];
	$proteinrecall = $_POST['proteinrecall'];
	$lemakrecall = $_POST['lemakrecall'];
	$karbohidratrecall = $_POST['karbohidratrecall'];
	
	mysqli_query($koneksi, "DELETE FROM `tbpoligizi` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpoligizi`(`TanggalPeriksa`,`JamPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`Anamnesa`,`Anjuran`,
	`PemeriksaanHasilLab`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`LingkarKepala`,`DetakNadi`,`RR`,`Kesadaran`,
	`TanggalPenimbangan`,`BeratBadanLahir`,`BBI`,`PanjangBadanLahir`,`Imt`,`Ntob`,`Bbu`,`Tbu`,`Imtu`,`Bbtb`,`Bgm`,`StatusGizi`,`TindakanGizi`,`Asi`,`Imd`,
	`LilaLika`,`UsiaKehamilan`,`LabHb`,`RiwayatGizi`,`DiagnosaGizi`,`TerapiDiet`,`MakanPagi`,`MakanSiang`,`MakanMalam`,`SeringNgemil`,`BerapaKali`,`AlergiMakanan`,
	`MakananPokok`,`LaukHewani`,`LaukNabati`,`Sayuran`,`Buahan`,`Munuman`,`Energi`,`Protein`,`Lemak`,`Karbohidrat`,
	`MakanPagiRecall`,`SnackPagiRecall`,`MakanSiangRecall`,`SnackSoreRecall`,`MakanSoreRecall`,`SnackMalamRecall`,`EnergiRecall`,`ProteinRecall`,`LemakRecall`,`KarbohidratRecall`,
	`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$anamnesa','$anjuran',
	'$pemeriksaanhasillab','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan','$lingkarkepala','$heartrate','$resprate','$kesadaran',
	'$tanggalpenimbangan','$bblahir','$bbi','$pblahir','$imt','$ntob','$bbu','$tbu','$imtu','$bbtb','$bgm','$statusgizi','$tindakangizi','$asi','$imd',
	'$lilalika','$usiakehamilan','$labhb','$riwayatgizi','$diagnosagizi','$terapidiet','$makanpagi','$makansiang','$makanmalam','$seringngemil','$jikangemil','$alergimakanan',
	'$makananpokok','$laukhewani','$lauknabati','$sayur','$buah','$minuman','$energi','$protein','$lemak','$karbohidrat',
	'$makanpagirecall','$snackpagirecall','$makansiangrecall','$snacksorerecall','$makansoremalamrecall','$snackmalamrecall','$energirecall','$proteinrecall','$lemakrecall','$karbohidratrecall',
	'$jsontherapy','$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	//update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if($pelayanan == 'POLI IMUNISASI'){	
	$alergi_imunisasi = $_POST['alergi_imunisasi'];
	$riwayat_imunisasi = implode(",",$_POST['riwayat_imunisasi']);
	$jenis_imunisasi = implode(",",$_POST['jenis_imunisasi']);
	$kipi = implode(",",$_POST['kipi']);
	$kipilainnya = $_POST['kipilainnya'];
	$tgl_imun_selanjutnya = $_POST['tgl_imun_selanjutnya'];
	$adsimunisasi = $_POST['adsimunisasi'];
	$ads_005 = $_POST['ads_005'];
	$ads_05 = $_POST['ads_05'];
	$ads_5 = $_POST['ads_5'];
	
	mysqli_query($koneksi, "DELETE FROM `tbpoliimunisasi` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");	
	$str = "INSERT INTO `tbpoliimunisasi`(`TanggalPeriksa`,`JamPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
	`Anamnesa`,`AlergiImunisasi`,`Anjuran`,`PemeriksaanHasilLab`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`DetakNadi`, 
	`RR`,`RiwayatImunisasi`,`ImunisasiSekarang`,`Kipi`,`KipiLainnya`,`TglImunSelanjutnya`,`Ads005`,`Ads05`,`Ads5`,
	`Terapi`,`Diagnosa`,`Kesadaran`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$kelaminpasien',
	'$anamnesa','$alergi_imunisasi','$anjuran','$pemeriksaanhasillab','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan','$heartrate',
	'$resprate','$riwayat_imunisasi','$jenis_imunisasi','$kipi','$kipilainnya','$tgl_imun_selanjutnya','$ads_005','$ads_05','$ads_5',
	'$jsontherapy','$jsondiagnosa','$kesadaran','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
	
	//update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);

}else if($pelayanan == 'POLI ISOLASI'){		
	mysqli_query($koneksi, "DELETE FROM `tbpoliisolasi` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");	
	$str = "INSERT INTO `tbpoliisolasi`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan',
	'$tinggibadan','$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
	'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
		
	// update polirujukan dan tbpasienrj
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
	
}else if($pelayanan == 'POLI HIV'){
	mysqli_query($koneksi, "DELETE FROM `tbpolihiv` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");	
	$str = "INSERT INTO `tbpolihiv`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan',
	'$tinggibadan','$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
	'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
		
	//update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if($pelayanan == 'POLI KB'){
	// status kb
	$tgl_haid = $_POST['tgl_haid_terakhir'];
	$tgl = explode("-",$tgl_haid);
	$tgl_haid_terakhir = $tgl[2]."-".$tgl[1]."-".$tgl[0];
	$anak_hidup = $_POST['anak_hidup'];
	$umur_terkecil = $_POST['umur_terkecil'];
	$status_kb = $_POST['status_kb'];
	$kb_terakhir = $_POST['kb_terakhir'];
	$hamil_diduga = $_POST['hamil_diduga'];
	$menyusui = $_POST['menyusui'];
	$metode_alkon = $_POST['metode_alkon'];
	$gravida = $_POST['gravida'];
	$partus = $_POST['partus'];
	$abortus = $_POST['abortus'];
	$ganti_cara = $_POST['ganti_cara'];
	$aseptor_baru = $_POST['aseptor_baru'];
	$aseptor_aktif = $_POST['aseptor_aktif'];
	$efek_samping_kb = $_POST['efek_samping_kb'];
	$komplikasi_kb = $_POST['komplikasi_kb'];
	$kegagalan_kb = $_POST['kegagalan_kb'];
	$riwayat_penyakit_kb = implode(",",$_POST['riwayat_penyakit_kb']);
	$pemeriksaan_dalam = implode(",",$_POST['pemeriksaan_dalam']);
	$pemeriksaan_tambahan = implode(",",$_POST['pemeriksaan_tambahan']);
	$alkon_boleh = implode(",",$_POST['alkon_boleh']);
	
	mysqli_query($koneksi, "DELETE FROM `tbpolikb` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpolikb`(`TanggalPeriksa`,`JamPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,
	`TanggalHaidTerakhir`,`AnakHidup`,`UmurTerkcil`,`StatusKB`,`CaraKBTerakhir`,`Hamil`,`Menyusui`,`AlKonDipilih`,
	`Gravida`,`Partus`,`Abortus`,`GantiCara`,`AseptorBaru`,`AseptorAktif`,`EfekSampingKB`,`KomplikasiKB`,`KegagalanKB`,
	`RiwayatPenyakit`,`PemeriksaanDalam`,`PemeriksaanTambahan`,`AlkonBolehDigunakan`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$tgl_haid_terakhir',
	'$anak_hidup','$umur_terkecil','$status_kb','$kb_terakhir','$hamil_diduga','$menyusui','$metode_alkon','$gravida','$partus',
	'$abortus','$ganti_cara','$aseptor_baru','$aseptor_aktif','$efek_samping_kb','$komplikasi_kb','$kegagalan_kb','$riwayat_penyakit_kb',
	'$pemeriksaan_dalam','$pemeriksaan_tambahan','$alkon_boleh','$jsontherapy','$jsondiagnosa','$nopemeriksaan','$statuspulang',
	'$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
		
	// kunj.ulang
	$tgl_haid_akhir = $_POST['tgl_haid_akhir'];
	$kegagalan_kb = strtoupper($_POST['kegagalan_kb']);
	$komplikasi_berat = strtoupper($_POST['komplikasi_berat']);
	$ic = $_POST['ic'];
	$ganticara = $_POST['ganticara'];
	$tgl_ganti = $_POST['tgl_ganti'];
	$pencabutan = $_POST['pencabutan'];
	$tgl_cabut = $_POST['tgl_cabut'];
	$tgl_kembali = $_POST['tgl_kembali'];
	
	mysqli_query($koneksi, "DELETE FROM `tbpolikb_kunjunganulang` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str= "INSERT INTO `tbpolikb_kunjunganulang`(`TanggalPemeriksaan`,`NoPemeriksaan`,`Anamnesa`,`Anjuran`,`PemeriksaanPenunjang`,
	`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`DetakNadi`,`RR`,`Kesadaran`,`TanggalHaidTerakhir`,`Kegagalan`,
	`KomplikasiBerat`,`InformedConsent`,`GantiCara`,`TanggalGanti`,`PencabutanKontrasepsi`,`TanggalPencabutan`,`TanggalKembali`,
	`StatusPulang`,`NamaPegawaiSimpan`)
	VALUES ('$tanggal_registrasi','$nopemeriksaan','$anamnesa','$anjuran','$pemeriksaanpenunjang','$sistole',
	'$diastole','$suhutubuh','$beratbadan','$tinggibadan','$heartrate','$resprate','$kesadaran',
	'$tgl_haid_akhir','$kegagalan_kb','$komplikasi_berat','$ic','$ganticara','$tgl_ganti','$pencabutan','$tgl_cabut',
	'$tgl_kembali','$statuspulang','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
	
	//update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
		
}else if($pelayanan == 'POLI KIA'){
	mysqli_query($koneksi, "DELETE FROM `$tbpolikia` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `$tbpolikia`(`TanggalPeriksa`,`JamPeriksa`,`NoPemeriksaan`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoKohort`,`NoResti`,`NamaPasien`,
	`StatusPemeriksaanKia`,`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`DetakNadi`,`RR`,`Kesadaran`,
	`UsiaKehamilan`,`Trimester`,`Tfu`,`Lila`,`StatusGizi`,`RefleksPatella`,`RiwayatSc`,`TT`,`FE`,`GolonganDarah`,`KunjunganKehamilan`,`DeteksiResiko`,`FaktorResiko`,
	`FaktorResikoDesc`,`KomplikasiDitanganiIbuHamil`,`JikaRujuk`,`Gravida`,`Partus`,`Abortus`,`Hpht`,`Djj`,`DjjGanda`,`KepThd`,`Tbj`,`JumlahJanin`,`Presentasi`,`P4K`,`InjeksiTT`,
	`CatatBukuKia`,`FeTab`,`K1Hb`,`PPTest`,`ProteinUrin`,`GulaDarah`,`GulaDarahSewaktu`,`K4Hb`,`Sifilis`,`Malaria`,`AsamUrat`,`Hbsag`,`Hiv`,`Terapi`,`Diagnosa`,`NoResep`,
	`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`)
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noregistrasi','$noindex','$nocm','$nokohort_kia','$noresti_kia','$namapasien','$sts_pemeriksaan_kia','$anamnesa',
	'$anjuran','$pemeriksaanhasillab','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan','$heartrate','$resprate','$kesadaran','$usiakehamilan_kia',
	'$trimester_kia','$tfu_kia','$lila_kia','$statusgizi_kia','$reflekspatella_kia','$riwayatsc_kia','$tt_kia','$fe_kia','$goldarah_kia','$kunjungan_kehamilan',
	'$deteksi_resiko','$faktorresiko_kia','$faktorresikodesc_kia','$komplikasi_kia','$rujuk_komplikasi','$gravida','$partus','$abortus','$hpht_kia','$djj_kia','$djj_kia_ganda','$kepalathd_kia','$tbj_kia',
	'$jumlahjanin_kia','$presentasi_kia','$p4k','$injeksitt_kia','$buku_kia','$fetab_kia','$k1hb_kia','$pptest_kia','$proturine_kia','$guladarah_kia','$gds_kia',
	'$k4hb_kia','$sifilis_kia','$malaria_kia','$asamurat_kia','$hbsag_kia','$hiv_kia','$jsontherapy','$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal',
	'$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if($pelayanan == 'POLI LANSIA'){	
	$kms = $_POST['kms'];
	$kemandirian = $_POST['kemandirian'];
	$emosional = $_POST['emosional'];
	$statusimt = $_POST['statusimt'];
	$tekanandarahlansia = $_POST['tekanandarahlansia'];
	$faktorresiko = $_POST['faktorresiko'];
	if(isset($_POST['riwayat_penyakit'])){
		$riwayatpenyakit = implode(",",$_POST['riwayat_penyakit']);
	}else{
		$riwayatpenyakit = '';
	}
	
	$kelainan = $_POST['kelainan'];
	$pengobatan = $_POST['pengobatan'];
	$konseling = $_POST['konseling'];
	$penyuluhan = $_POST['penyuluhan'];
	$pemberdayaan = $_POST['pemberdayaan'];
	$panti = $_POST['panti'];
	$kunjrumah = $_POST['kunjrumah'];
	// P3G
	$skrining = $_POST['skrining'];
	$adl = $_POST['adl'];
	$resikojatuh = $_POST['resikojatuh'];
	$gds = $_POST['gds'];
	$mme = $_POST['mme'];
	$mna = $_POST['mna'];
	// Hasil Laboratorium
	$gdp_lab = $_POST['gdp_lab'];
	$gds_lab = $_POST['gds_lab'];
	$koles_lab = $_POST['koles_lab'];
	$au_lab = $_POST['au_lab'];
	$hb_lab = $_POST['hb_lab'];
	$prot_lab = $_POST['prot_lab'];
	
	mysqli_query($koneksi, "DELETE FROM `$tbpolilansia` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `$tbpolilansia`(`TanggalPeriksa`,`JamPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
	`UmurTahun`,`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`MempunyaiKms`,`Kemandirian`,`GangguanEmosional`,`StatusImt`,
	`StatusTekananDarah`,`FaktorResiko`,`RiwayatPenyakit`,`Kelainan`, `Pengobatan`,`Konseling`,`Penyuluhan`,`Pemberdayaan`,`Panti`,
	`KunjunganRumah`,`Skrining`,`Adl`,`ResikoJatuh`,`Gds`,`Mme`,`Mna`,`GdpLab`,`GdsLab`,`KolesLab`,`AuLab`,`HbLab`,`ProtLab`,`Terapi`,`Diagnosa`,
	`NoResep`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_time','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$kelaminpasien',
	'$umurtahunpasien','$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan',
	'$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut','$leher','$dada',
	'$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$kms','$kemandirian','$emosional',
	'$statusimt','$tekanandarahlansia','$faktorresiko','$riwayatpenyakit','$kelainan','$pengobatan','$konseling','$penyuluhan',
	'$pemberdayaan','$panti','$kunjrumah','$skrining','$adl','$resikojatuh','$gds','$mme','$mna','$gdp_lab','$gds_lab','$koles_lab','$au_lab',
	'$hb_lab','$prot_lab','$jsontherapy','$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	//update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
		
}else if($pelayanan == 'POLI MTBS'){	
	$kunjungan_mtbs = $_POST['kunjungan_mtbs'];
	$prk_umum_mtbs =  implode(",",$_POST['prk_umum_mtbs']);
	$kls_umum_mtbs = $_POST['kls_umum_mtbs'];
	$tind_umum_mtbs =  strtoupper($_POST['tind_umum_mtbs']);
	// pneu
	$prk_pneu_mtbs = implode(",",$_POST['prk_pneu_mtbs']);
	$bl_pneu_mtbs = $_POST['bl_pneu_mtbs'];
	$nc_pneu_mtbs = $_POST['nc_pneu_mtbs'];
	$kls_pneu_mtbs = $_POST['kls_pneu_mtbs'];
	$tind_pneu_mtbs = implode(",",$_POST['tind_pneu_mtbs']);
	// diare
	$prk_diare_mtbs = implode(",",$_POST['prk_diare_mtbs']);
	$bl_diare_mtbs = $_POST['bl_diare_mtbs'];
	$ku_diare_mtbs = implode(",",$_POST['ku_diare_mtbs']);
	$bam_diare_mtbs = implode(",",$_POST['bam_diare_mtbs']);
	$ckp_diare_mtbs = implode(",",$_POST['ckp_diare_mtbs']);
	$kls_diare_mtbs = $_POST['kls_diare_mtbs'];
	$tind_diare_mtbs = implode(",",$_POST['tind_diare_mtbs']);
	// demam/malaria
	$prk_malaria_mtbs = implode(",",$_POST['prk_malaria_mtbs']);
	$dr_malaria_mtbs = $_POST['dr_malaria_mtbs'];
	$bl_malaria_mtbs = $_POST['bl_malaria_mtbs'];
	$tc_malaria_mtbs = $_POST['tc_malaria_mtbs'];
	$kls_malaria_mtbs = $_POST['kls_malaria_mtbs'];
	$tind_malaria_mtbs = implode(",",$_POST['tind_malaria_mtbs']);
	// campak
	$prk_campak_mtbs = implode(",",$_POST['prk_campak_mtbs']);
	$kls_campak_mtbs = $_POST['kls_campak_mtbs'];
	$tind_campak_mtbs = implode(",",$_POST['tind_campak_mtbs']);
	// dbd
	$prk_dbd_mtbs = implode(",",$_POST['prk_dbd_mtbs']);
	$kls_dbd_mtbs = $_POST['kls_dbd_mtbs'];
	$tind_dbd_mtbs = implode(",",$_POST['tind_dbd_mtbs']);
	// telinga
	$prk_telinga_mtbs = implode(",",$_POST['prk_telinga_mtbs']);
	$bl_telinga_mtbs = $_POST['bl_telinga_mtbs'];
	$kls_telinga_mtbs = $_POST['kls_telinga_mtbs'];
	$tind_telinga_mtbs = implode(",",$_POST['tind_telinga_mtbs']);
	// gizi
	$prk_gizi_mtbs = implode(",",$_POST['prk_gizi_mtbs']);
	$bb_mtbs = $_POST['bb_mtbs'];
	$bb_jelaskan_mtbs = $_POST['bb_jelaskan_mtbs'];
	$lila_mtbs = $_POST['lila_mtbs'];
	$lila_jelaskan_mtbs = $_POST['lila_jelaskan_mtbs'];
	$bahaya_umum_mtbs = $_POST['bahaya_umum_mtbs'];
	$klasifikasi_berat_mtbs = $_POST['klasifikasi_berat_mtbs'];
	$asi_mtbs = $_POST['asi_mtbs'];
	$gizi_klasifikasi_mtbs = $_POST['gizi_klasifikasi_mtbs'];
	$gizi_tindakan_mtbs = $_POST['gizi_tindakan_mtbs'];
	// anemia
	$anemia_mtbs = $_POST['anemia_mtbs'];
	$anemia_klasifikasi_mtbs = $_POST['anemia_klasifikasi_mtbs'];
	$anemia_tindakan_mtbs = implode(",",$_POST['tind_anemia_mtbs']);	
	// HIV
	$prk_hiv_mtbs = implode(",",$_POST['prk_hiv_mtbs']);	
	$hiv_klasifikasi_mtbs = $_POST['hiv_klasifikasi_mtbs'];
	$tind_hiv_mtbs = implode(",",$_POST['tind_hiv_mtbs']);	
	// imunisasi
	$prk_imunisasi_sekarang_mtbs = implode(",",$_POST['prk_imunisasi_sekarang_mtbs']);
	$prk_imunisasi_sudah_mtbs = implode(",",$_POST['prk_imunisasi_sudah_mtbs']);
	$imunisasi_klasifikasi_mtbs = $_POST['imunisasi_klasifikasi_mtbs'];
	$imunisasi_tindakan_mtbs = $_POST['imunisasi_tindakan_mtbs'];
	// VitA
	$prk_vita_mtbs = implode(",",$_POST['prk_vita_mtbs']);
	$keluhanlain_mtbs = $_POST['keluhanlain_mtbs'];
	// Ibu menyusui / pemberian makanan
	$makan_mtbs_1 = $_POST['makan_mtbs_1'];
	$makan_mtbs_2 = $_POST['makan_mtbs_2'];
	$makan_mtbs_3 = $_POST['makan_mtbs_3'];
	$makan_mtbs_4 = $_POST['makan_mtbs_4'];
	$makan_mtbs_5 = $_POST['makan_mtbs_5'];
	$makan_mtbs_6 = $_POST['makan_mtbs_6'];
	$makan_mtbs_7 = $_POST['makan_mtbs_7'];
	$makan_mtbs_8 = $_POST['makan_mtbs_8'];
	$makan_mtbs_9 = $_POST['makan_mtbs_9'];
	$makan_mtbs_10 = $_POST['makan_mtbs_10'];
	$makan_mtbs_11 = $_POST['makan_mtbs_11'];
	$makan_mtbs_12 = $_POST['makan_mtbs_12'];
	// Rujukan dan Kunjungan Ulang
	$tempat_rujuk = $_POST['tempat_rujuk'];	
	$tanggalkunjulang1 = $_POST['tanggalkunjulang'];
	$tgl = explode("-",$tanggalkunjulang1);
	$tanggalkunjulang=$tgl[2]."-".$tgl[1]."-".$tgl[0];	
	$rujuk_klasifikasi_mtbs = $_POST['rujukan_klasifikasi_mtbs'];
	
	mysqli_query($koneksi, "DELETE FROM `$tbpolimtbs` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `$tbpolimtbs`(`TanggalPeriksa`,`JamPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,`UmurTahun`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`DetakNadi`,`RR`,
	`Kunjungan`, `PemeriksaanUmum`, `KlasifikasiUmum`, `TindakanUmum`, 
	`PemeriksaanPneumonia`,`HariPneumonia`,`NapasPneumonia`,`KlasifikasiPneumonia`,`TindakanPneumonia`,
	`PemeriksaanDiare`,`HariDiare`,`KeadaanUmum`,`BeriAnakMinum`,`CubitPerut`,`KlasifikasiDiare`,`TindakanDiare`,
	`PemeriksaanDemam`,`DeteksiResiko`,`HariDemam`,`TandaCampak`,`KlasifikasiDemam`,`TindakanDemam`,
	`PemeriksaanCampak`,`KlasifikasiCampak`,`TindakanCampak`,
	`PemeriksaanDBD`,`KlasifikasiDBD`,`TindakanDBD`,
	`PemeriksaanTelinga`,`HariTelinga`,`KlasifikasiTelinga`,`TindakanTelinga`,
	`PemeriksaanGizi`,`BBGizi`,`BBGiziJelaskan`,`LilaGizi`,`LilaGiziJelaskan`,`TandaBahayaGizi`,`KlasifikasiBeratGizi`,`MasalahAsiGizi`,`KlasifikasiGizi`,`TindakanGizi`,
	`PemeriksaanAnemia`,`KlasifikasiAnemia`,`TindakanAnemia`,
	`PemeriksaanHiv`,`KlasifikasiHiv`,`TindakanHiv`,
	`ImunisasiDiberikan`,`ImunisasiDibutuhkan`,`KlasifikasiImunisasi`,`TindakanImunisasi`,
	`PemeriksaanVitA`,`MasalahVitA`,
	`IbuMenyusui`,`BerapaKaliMenyusu`,`AnakMenyusuMalam`,`AnakDapatMakananLain`,`MakananApa`,`BerapaKaliMakan`,
	`AlatDigunakan`,`BerapaBanyakMakan`,`AnakDapatMakanSendiri`,`SiapaMemberiMakan`,`PerubahanMakan`,`BagaimanaMakan`,
	`TempatRujuk`,`TanggalKunjunganUlang`,`KlasifikasiRujuk`,
	`Diagnosa`,`NoResep`,`Kesadaran`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$kelaminpasien','$umurtahunpasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$sistole','$diastole','$suhutubuh','$beratbadan',
	'$tinggibadan','$heartrate','$resprate','$kunjungan_mtbs',
	'$prk_umum_mtbs','$kls_umum_mtbs','$tind_umum_mtbs',
	'$prk_pneu_mtbs','$bl_pneu_mtbs','$nc_pneu_mtbs','$kls_pneu_mtbs','$tind_pneu_mtbs',
	'$prk_diare_mtbs','$bl_diare_mtbs','$ku_diare_mtbs','$bam_diare_mtbs','$ckp_diare_mtbs','$kls_diare_mtbs','$tind_diare_mtbs',
	'$prk_malaria_mtbs','$dr_malaria_mtbs','$bl_malaria_mtbs','$tc_malaria_mtbs','$kls_malaria_mtbs','$tind_malaria_mtbs',
	'$prk_campak_mtbs','$kls_campak_mtbs','$tind_campak_mtbs',
	'$prk_dbd_mtbs','$kls_dbd_mtbs','$tind_dbd_mtbs',
	'$prk_telinga_mtbs','$bl_telinga_mtbs','$kls_telinga_mtbs','$tind_telinga_mtbs',
	'$prk_gizi_mtbs','$bb_mtbs','$bb_jelaskan_mtbs','$lila_mtbs','$lila_jelaskan_mtbs','$bahaya_umum_mtbs','$klasifikasi_berat_mtbs','$asi_mtbs','$gizi_klasifikasi_mtbs','$gizi_tindakan_mtbs',
	'$anemia_mtbs','$anemia_klasifikasi_mtbs','$anemia_tindakan_mtbs',
	'$prk_hiv_mtbs','$hiv_klasifikasi_mtbs','$tind_hiv_mtbs',
	'$prk_imunisasi_sekarang_mtbs','$prk_imunisasi_sudah_mtbs','$imunisasi_klasifikasi_mtbs','$imunisasi_tindakan_mtbs',
	'$prk_vita_mtbs','$keluhanlain_mtbs',
	'$makan_mtbs_1','$makan_mtbs_2','$makan_mtbs_3','$makan_mtbs_4','$makan_mtbs_5','$makan_mtbs_6',
	'$makan_mtbs_7','$makan_mtbs_8','$makan_mtbs_9','$makan_mtbs_10','$makan_mtbs_11','$makan_mtbs_12',
	'$tempat_rujuk','$tanggalkunjulang','$rujuk_klasifikasi_mtbs',
	'$jsondiagnosa','$nopemeriksaan','$Kesadaran','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
	// echo $str ;
	// die();
	
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if($pelayanan == 'POLI PANDU PTM'){
	$riwayatptmkeluarga = $_POST['riwayatptmkeluarga'];
	$riwayatptmpribadi = $_POST['riwayatptmpribadi'];
	$matalokasi = $_POST['matalokasi'];
	$matakatarak = $_POST['matakatarak'];
	$matarefraksi = $_POST['matarefraksi'];
	$telingalokasi = $_POST['telingalokasi'];
	$telingatuli = $_POST['telingatuli'];
	$telingacongek = $_POST['telingacongek'];
	$telingaserumen = $_POST['telingaserumen'];
	$ptmiva = $_POST['ptmiva'];
	$ptmsadanis = $_POST['ptmsadanis'];
	
	mysqli_fetch_assoc(mysqli_query($koneksi, "DELETE FROM `tbpolipanduptm` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'"));
	$str = "INSERT INTO `tbpolipanduptm`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,
	`RiwayatPtmKeluarga`,`RiwayatPtmPribadi`,`MataLokasi`,`MataKatarak`,`MataRefraksi`,`TelingaLokasi`,`TelingaTuli`,`TelingaCongek`,`TelingaSerumen`,`Iva`,`Sadanis`,
	`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan',
	'$tinggibadan','$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
	'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi',
	'$riwayatptmkeluarga','$riwayatptmpribadi','$matalokasi','$matakatarak','$matarefraksi','$telingalokasi','$telingatuli','$telingacongek',
	'$telingaserumen','$ptmiva','$ptmsadanis','$jsontherapy','$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
		
	// update polirujukan dan tbpasienrj
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");

}elseif($pelayanan == 'POLI PDP'){
	mysqli_query($koneksi, "DELETE FROM `tbpolipdp` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");	
	$str = "INSERT INTO `tbpolipdp`(`TanggalPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`KeadaanUmum`,`StatusGizi`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RiwayatPenyakitSekarang`,`RiwayatPenyakitDulu`,`RiwayatPenyakitKeluarga`,`FaktorResikoLainnya`,`RiwayatAlergiMakanan`,`RiwayatAlergiObat`,
	`RencanaPengelolaan`,`Prognosis`,`InformasiEso`,`Edukasi`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_time','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$keadaanumum','$statusgizi','$pemeriksaanpenunjangobj','$sistole','$diastole','$suhutubuh','$beratbadan',
	'$tinggibadan','$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
	'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$riwayatpenyakitsekarang','$riwayatpenyakitdulu','$riwayatpenyakitkeluarga','$faktorresikolainnya',
	'$riwayatalergimakanan','$riwayatalergiobat','$rencanapengelolaan','$prognosis','$informasieso','$edukasi','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
		
	// update polirujukan dan tbpasienrj
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if($pelayanan == 'POLI PROLANIS'){	
	// Hasil Laboratorium
	$gdp_lab = $_POST['gdp_lab'];
	$gds_lab = $_POST['gds_lab'];
	$koles_lab = $_POST['koles_lab'];
	$au_lab = $_POST['au_lab'];
	$hb_lab = $_POST['hb_lab'];
	$prot_lab = $_POST['prot_lab'];
	
	mysqli_query($koneksi, "DELETE FROM `tbpoliprolanis` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpoliprolanis`(`TanggalPeriksa`,`JamPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
	`UmurTahun`,`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`GdpLab`,`GdsLab`,`KolesLab`,`AuLab`,`HbLab`,`ProtLab`,`Terapi`,`Diagnosa`,
	`NoResep`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_time','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$kelaminpasien',
	'$umurtahunpasien','$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan',
	'$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut','$leher','$dada',
	'$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$gdp_lab','$gds_lab','$koles_lab','$au_lab',
	'$hb_lab','$prot_lab','$jsontherapy','$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	//update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
		
}else if($pelayanan == 'POLI SKD'){
	$ataspermintaan = $_POST['ataspermintaan'];
	$dengansurat = $_POST['dengansurat'];
	$tujuankir = $_POST['tujuankir'];
	$tujuankirlainnya = $_POST['tujuankirlainnya'];
	$pemeriksaanlab_skd = $_POST['pemeriksaanlab_skd'];
	$sistole_skd = $_POST['sistole_skd'];
	$diastole_skd = $_POST['diastole_skd'];
	$suhutubuh_skd = $_POST['suhutubuh_skd'];
	$tinggibadan_skd = $_POST['tinggibadan_skd'];
	$beratbadan_skd = $_POST['beratbadan_skd'];
	$heartrate_skd = $_POST['heartrate_skd'];
	$resprate_skd = $_POST['resprate_skd'];
	$jantung_skd = $_POST['jantung_skd'];
	$lympa_skd = $_POST['lympa_skd'];
	$hati_skd = $_POST['hati_skd'];
	$paru_skd = $_POST['paru_skd'];
	$saraf_skd = $_POST['saraf_skd'];
	$kejiwaan_skd = $_POST['kejiwaan_skd'];
	$visusmata_od_skd = $_POST['visusmata_od_skd'];
	$visusmata_os_skd = $_POST['visusmata_os_skd'];
	$statuskesehatan = $_POST['statuskesehatan'];
	$nomorsurat_skd = $_POST['nomorsurat_skd'];
	$namadokter_skd = $_POST['namadokter_skd'];
	$keterangan_skd = $_POST['keterangan_skd'];
	$pemeriksaanlain_skd = implode(",",$_POST['pemeriksaanlain_skd']);

	mysqli_query($koneksi, "DELETE FROM `tbpoliskd` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpoliskd`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`,`NoSurat`,`NamaPasien`,
	`AtasPermintaan`,`DenganSurat`,`TujuanKir`,`TujuanKirLainnya`,`PemeriksaanLab`,`PemeriksaanLainnya`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,
	`TinggiBadan`,`DetakNadi`,`RR`,`Jantung`,`Lympa`,`Hati`,`Paru`,`Saraf`,`Kejiwaan`,`VisusMataOD`,`VisusMataOS`,`StatusKesehatan`,`Kesadaran`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaDokter`,`KeteranganTambahan`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$nomorsurat_skd','$namapasien',
	'$ataspermintaan','$dengansurat','$tujuankir','$tujuankirlainnya','$pemeriksaanlab_skd','$pemeriksaanlain_skd','$sistole_skd','$diastole_skd',
	'$suhutubuh_skd','$beratbadan_skd','$tinggibadan_skd','$heartrate_skd','$resprate_skd','$jantung_skd','$lympa_skd','$hati_skd','$paru_skd','$saraf_skd',
	'$kejiwaan_skd','$visusmata_od_skd','$visusmata_os_skd','$statuskesehatan','$kesadaran','$statuspulang','$rujukinternal','$rujuklanjut','$namadokter_skd',
	'$keterangan_skd','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
		
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if ($pelayanan == 'POLI TB DOTS' OR $pelayanan == 'POLI TB'){
	if($kota == "KABUPATEN BANDUNG"){
		$politb = "POLI TB DOTS";
	}else{
		$politb = "POLI TB";
	}
	
	$asalrujukan = $_POST['asalrujukan'];
	$riwayatpengobatan = $_POST['riwayatpengobatan'];
	$didugatb = $_POST['didugatb'];
	$totalskoring = $_POST['totalskoring'];
	$tgl_dahak = $_POST['tgl_dahak'];
	$tgl_mikroskopis = $_POST['tgl_mikroskopis'];
	$hasil_a = $_POST['hasil_a'];
	$hasil_b = $_POST['hasil_b'];
	$hasil_c = $_POST['hasil_c'];
	$tgl_biakan = $_POST['tgl_biakan'];
	$hasil_biakan = $_POST['hasil_biakan'];
	$tgl_kepekaan = $_POST['tgl_kepekaan'];
	$hasil_kepekaan_h = $_POST['hasil_kepekaan_h'];
	$hasil_kepekaan_r = $_POST['hasil_kepekaan_r'];
	$hasil_kepekaan_z = $_POST['hasil_kepekaan_z'];
	$hasil_kepekaan_e = $_POST['hasil_kepekaan_e'];
	$hasil_kepekaan_s = $_POST['hasil_kepekaan_s'];
	$hasil_kepekaan_km = $_POST['hasil_kepekaan_km'];
	$hasil_kepekaan_amk = $_POST['hasil_kepekaan_amk'];
	$hasil_kepekaan_ofx = $_POST['hasil_kepekaan_ofx'];
	$tgl_xpert = $_POST['tgl_xpert'];
	$hasil_xpert = $_POST['hasil_xpert'];
	$tgl_lpa = $_POST['tgl_lpa'];
	$hasil_lpa = $_POST['hasil_lpa'];
	$noreg_tb04 = $_POST['noreg_tb04'];
	$hasil_toraks = $_POST['hasil_toraks'];
	$kriteria_mdr = $_POST['kriteria_mdr'];
	$status_hiv = $_POST['status_hiv'];
	$rujukan_tb = $_POST['rujukan_tb'];
	$tgl_pengobatan_tb = $_POST['tgl_pengobatan_tb'];
	
	if($kota == 'KOTA TARAKAN'){
		$tbpolitb = 'tbpolitb';
	}else{
		$tbpolitb = 'tbpolitbdots';
	}

	mysqli_query($koneksi, "DELETE FROM `$tbpolitb` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `$tbpolitb`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`, `Anamnesa`,
	`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`DetakNadi`,`RR`,`Kesadaran`,
	`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,`HL`,`Kelamin`,`ExAtas`,`ExBawah`,
	`Lokalis`,`Effloresensi`,`AsalRujukan`,`RiwayatPengobatan`,`DidugaTB`,`TotalSkoring`,`TglDahak`,`TglMikoskopis`,`HasilA`,
	`HasilB`,`HasilC`,`TglBiakan`,`HasilBiakan`,`TglKepekaan`,`HasilH`,`HasilR`,`HasilZ`,`HasilE`,`HasilS`,`HasilKm`,`HasilAmk`,
	`HasilOfx`,`TglXpert`,`HasilXpert`,`TglLpa`,`HasilLpa`,`NoRegTB04`,`HasilToraks`,`KriteriaMdr`,`StatusHIV`,`RujukanTB`,
	`TglPengobatanTB`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$anamnesa',
	'$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan','$heartrate',
	'$resprate','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut','$leher','$dada','$punggung','$cp','$perut',
	'$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$asalrujukan','$riwayatpengobatan','$didugatb',
	'$totalskoring','$tgl_dahak','$tgl_mikroskopis','$hasil_a','$hasil_b','$hasil_c','$tgl_biakan','$hasil_biakan',
	'$tgl_kepekaan','$hasil_kepekaan_h','$hasil_kepekaan_r','$hasil_kepekaan_z','$hasil_kepekaan_e','$hasil_kepekaan_s',
	'$hasil_kepekaan_km','$hasil_kepekaan_amk','$hasil_kepekaan_ofx','$tgl_xpert','$hasil_xpert','$tgl_lpa','$hasil_lpa',
	'$noreg_tb04','$hasil_toraks','$kriteria_mdr','$status_hiv','$rujukan_tb','$tgl_pengobatan_tb','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	//update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if ($pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){
	// kecelakaan
	$kcl_jam_kecelakaan = $_POST['kcl_jam_kecelakaan'];
	$kcl_jam_berobat = $_POST['kcl_jam_berobat'];
	$kcl_jeniskendaraan = $_POST['kcl_jeniskendaraan'];
	$kcl_nomorpolisi = $_POST['kcl_nomorpolisi'];
	$kcl_lokasikejadian = $_POST['kcl_lokasikejadian'];
	
	mysqli_query($koneksi, "DELETE FROM `tbpolitindakan` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpolitindakan`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`, `Anamnesa`,
	`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`DetakNadi`,`RR`,
	`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,
	`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`StatusLokalis`,`Effloresensi`,
	`JamKecelakaan`,`JamBerobat`,`JenisKendaraanTerlibat`,`NomorPolisi`,`LokasiKejadian`,`RiwayatPenyakit`,`Terapi`,`Diagnosa`,`NoResep`,
	`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$anamnesa','$anjuran',
	'$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan','$heartrate','$resprate',
	'$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata',
	'$hidung','$telinga','$mulut','$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi',
	'$kcl_jam_kecelakaan','$kcl_jam_berobat','$kcl_jeniskendaraan','$kcl_nomorpolisi','$kcl_lokasikejadian','$riwayatpenyakit','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
	
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}else if ($pelayanan == 'POLI LABORATORIUM'){
	$lab_catin_hiv = $_POST['lab_catin_hiv'];
	$lab_catin_hbsag = $_POST['lab_catin_hbsag'];
	$lab_catin_ppt = $_POST['lab_catin_ppt'];	
	$idtindakan = $_POST['idtindakan'];
	$jenistindakan= $_POST['jenistindakan'];
	$kelompoktindakan= $_POST['kelompoktindakan'];
	$hasilkdtindakan= $_POST['hasilkdtindakan'];
	$arrykdtindakan = explode(",",$idtindakan);
	foreach($arrykdtindakan as $kd){
		$hasilkdtindakan2 = $hasilkdtindakan[$kd];
		$jenistindakan2 = $jenistindakan[$kd];
		$kelompoktindakan2 = $kelompoktindakan[$kd];
		// ini untuk apa?
		$cekinsertbtindakandetail = mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbtindakanpasien` WHERE NoRegistrasi = '$nopemeriksaan' AND `IdTindakan` = '$kd'"));
		if($cekinsertbtindakandetail == 0){
			$getkategoritindakan = 	mysqli_query($koneksi,"SELECT `JenisTindakan`,`KelompokTindakan` FROM `tbtindakan` WHERE `IdTindakan`='$kd'");
			if(mysqli_num_rows($getkategoritindakan) > 0){
				$dttindakan = mysqli_fetch_assoc($getkategoritindakan);
				$jenistindakan = $dttindakan['JenisTindakan'];
				$kelompoktindakan = $dttindakan['KelompokTindakan'];
			}else{
				$jenistindakan = '-';
				$kelompoktindakan = '-';
			}
			$str2 = "INSERT INTO `$tbtindakanpasien`(`TanggalTindakan`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin`,`PoliAsal`,`IdTindakan`,`KelompokTindakan`,`JenisTindakan`,`Keterangan`,`StatusBayar`,`NamaPegawaiSimpan`) 
				VALUES ('$tanggal_time','$noregistrasi','$noindex','$nocm','$namapasien','$umurtahunpasien','$umurbulanpasien','$umurharipasien','$kelaminpasien','$pelayanan','$kd','$kelompoktindakan','$jenistindakan','$hasilkdtindakan2','BELUM','$tenagamedisbpjs')";
		}else{
			$str2 = "UPDATE `$tbtindakanpasien` SET `Keterangan`='$hasilkdtindakan2' WHERE `NoRegistrasi` = '$nopemeriksaan' AND `IdTindakan` = '$kd'";
		}
		mysqli_query($koneksi,$str2);
		$hasilkdtindakan_ar[] = $hasilkdtindakan2;
		$jenistindakan_ar[] = $jenistindakan2;
		$kelompoktindakan_ar[] = $kelompoktindakan2;
	}
	$hasiltindakan = implode(",",$hasilkdtindakan_ar);
	$jenistindakan = implode(",",$jenistindakan_ar);
	$kelompoktindakan = implode(",",$kelompoktindakan_ar);
	
	// delete
	mysqli_query($koneksi, "DELETE FROM `tbpolilaboratorium` WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpolilaboratorium`(`TanggalPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`IdTindakan`,`JenisTindakan`,`KelompokTindakan`,`Hasil`,`NilaiRujukan`,`Catin_Hiv`,`Catin_Hbsag`,`Catin_Ppt`,`Kesadaran`,`StatusPulang`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$nopemeriksaan','$noindex','$nocm','$namapasien','$idtindakan','$jenistindakan','$kelompoktindakan','$hasiltindakan','0','$lab_catin_hiv','$lab_catin_hbsag','$lab_catin_ppt','$kesadaran','$statuspulang','$namapegawai')";
	$query=mysqli_query($koneksi,$str);
	
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
}elseif($pelayanan == 'NURSING CENTER'){
	mysqli_query($koneksi, "DELETE FROM `tbpolinursingcenter` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpolinursingcenter`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan',
	'$tinggibadan','$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
	'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
		
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);
	
}elseif($pelayanan == 'POLI INFEKSIUS'){
	mysqli_query($koneksi, "DELETE FROM `tbpoliinfeksius` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpoliinfeksius`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan',
	'$tinggibadan','$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
	'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
		
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);	
	
}elseif($pelayanan == 'POLI SCREENING'){	
	mysqli_query($koneksi, "DELETE FROM `tbpoliscreening` WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str = "INSERT INTO `tbpoliscreening`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
	`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
	`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
	`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
	`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
	'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan',
	'$tinggibadan','$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
	'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
	'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	$query=mysqli_query($koneksi,$str);
		
	// update polirujukan
	$strpolirujukan = "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'";
	mysqli_query($koneksi,$strpolirujukan);	
}	

	// update tbpasienrj
	// if($statuspulang == 5){
	// 	mysqli_query($koneksi, "UPDATE `$tbpasienrj` SET `StatusPelayanan` = 'Rujuk', `StatusPulang` = '$statuspulang' WHERE `IdPasienrj` = '$idpasienrj'");	
	// 	mysqli_query($koneksi, "UPDATE `$tbpasienrj_retensi` SET `StatusPelayanan` = 'Rujuk', `StatusPulang` = '$statuspulang' WHERE `IdPasienrj` = '$idpasienrj'");	
	// }else{
	// 	mysqli_query($koneksi, "UPDATE `$tbpasienrj` SET `StatusPelayanan` = 'Sudah', `StatusPulang` = '$statuspulang', `IdConditionSatuSehat` = '$id_cond_satusehat', `IdObservationSatuSehat` = '$id_obs_satusehat', `IdProcedureSatuSehat` = '$id_pro_satusehat', `IdMedicationSatuSehat` = '$id_medic_satusehat', `IdMedicationRequestSatuSehat` = '$id_medicrequest_satusehat' WHERE `IdPasienrj` = '$idpasienrj'");	
	// 	mysqli_query($koneksi, "UPDATE `$tbpasienrj_retensi` SET `StatusPelayanan` = 'Sudah', `StatusPulang` = '$statuspulang', `IdConditionSatuSehat` = '$id_cond_satusehat', `IdObservationSatuSehat` = '$id_obs_satusehat', `IdProcedureSatuSehat` = '$id_pro_satusehat', `IdMedicationSatuSehat` = '$id_medic_satusehat' WHERE `IdPasienrj` = '$idpasienrj'");	
	// }

	if($statuspulang == 5){
		mysqli_query($koneksi, "UPDATE `$tbpasienrj` SET `StatusPelayanan` = 'Rujuk', `StatusPulang` = '$statuspulang' WHERE `IdPasienrj` = '$idpasienrj'");	
		mysqli_query($koneksi, "UPDATE `$tbpasienrj_retensi` SET `StatusPelayanan` = 'Rujuk', `StatusPulang` = '$statuspulang' WHERE `IdPasienrj` = '$idpasienrj'");	
	}else{
		mysqli_query($koneksi, "UPDATE `$tbpasienrj` SET `StatusPelayanan` = 'Sudah', `StatusPulang` = '$statuspulang' WHERE `IdPasienrj` = '$idpasienrj'");	
		mysqli_query($koneksi, "UPDATE `$tbpasienrj_retensi` SET `StatusPelayanan` = 'Sudah', `StatusPulang` = '$statuspulang' WHERE `IdPasienrj` = '$idpasienrj'");	
	}
	
	// mencari kode diagnosa primary
	$indexprimary = array_search("1",$kelompok);
	$kddiagnosaprimary = $kddiagnosabpjs[$indexprimary];
		
	// jika pasien di rujuk internal
	if($statuspulang == 5){
		$str_rujuklanjut = "INSERT INTO `tbrujukinternal`(`TanggalRujukan`,`NoRujukan`, `PoliRujukan`, `PoliRujukan2`, `PoliRujukan3`, `PoliRujukan4`, `PoliRujukan5`,`StatusPemeriksaan`) VALUES ('$tgl','$noregistrasi','$rujukinternal','$rujukinternal2','$rujukinternal3','$rujukinternal4','$rujukinternal5','Rujuk');";
		mysqli_query($koneksi,$str_rujuklanjut);

		// ketika di rujuk internal ke poli lab
		if($rujukinternal == 'POLI LABORATORIUM' || $rujukinternal2 == 'POLI LABORATORIUM' || $rujukinternal3 == 'POLI LABORATORIUM' || $rujukinternal4 == 'POLI LABORATORIUM' || $rujukinternal5 == 'POLI LABORATORIUM'){
			$tindakanlabs = $_POST['tindakanlabs'];
			foreach($tindakanlabs as $kd){
				$sekinsertbtindakandetail = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$nopemeriksaan' AND `IdTindakan`='$kd'"));
				if($sekinsertbtindakandetail == 0){
					$getkategoritindakan = mysqli_query($koneksi, "SELECT `KelompokTindakan`,`Tarif` FROM `tbtindakan` WHERE `IdTindakan`='$kd'");
					if(mysqli_num_rows($getkategoritindakan) > 0){
						$dttindakan = mysqli_fetch_assoc($getkategoritindakan);
						// $jenistindakan = $dttindakan['Tindakan'];
						$kelompoktindakan = $dttindakan['KelompokTindakan'];
						$tariftindakan = $dttindakan['Tarif'];
					}else{
						// $jenistindakan = '0';
						$kelompoktindakan = '0';
						$tariftindakan = '0';
					}
					$strtindakanps = "INSERT INTO `$tbtindakanpasien`(`IdPasienrj`,`TanggalTindakan`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`PoliAsal`,`CaraBayar`,`IdTindakan`,`Tarif`,`KategoriTindakan`,`Keterangan`,`StatusBayar`,`NamaPegawaiSimpan`)
					VALUES('$idpasienrj','$tanggal_time','$noregistrasi','$noindex','$nocm','$namapasien','$pelayanan','$carabayar','$kd','$tariftindakan','$kelompoktindakan','-','BELUM','$tenagamedisbpjs')";
					// echo $strtindakanps;
					// die();
					mysqli_query($koneksi, $strtindakanps);
				}
				
			}
		}
		
	}else if($statuspulang == 4){
		// untuk nama rs dan polinya sudah menggunakan versi 3
		if($spesialis == ""){
			$kdpolis = $kdkhusus;
		}else{
			$kdpolis = $spesialis;
		}		
		$nmpolis = $_POST['namapolis'];
		$namars = $_POST['namars'];
		
		$str_rujuk_lg = "INSERT INTO `tbrujukluargedung`(`TanggalRujukan`,`NoRegistrasi`,`IdRumahSakit`,`RumahSakit`,`IdPoli`,`Poli`,`KodeDiagnosa`) 
		VALUES ('$tanggal_registrasi','$noregistrasi','$kdppk','$namars','$kdpolis','$nmpolis','$kdDiag1')";
		mysqli_query($koneksi,$str_rujuk_lg);
	}
	
	// insert tbdiagnosa pasien 
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	$tbdiagnosapasien_bulan = 'tbdiagnosapasien_'.substr($nopemeriksaan,14,2);
	$kasusdiagnosa = $_POST['kasusdiagnosabpjs'];
	if($kddiagnosabpjs != null){
		$no = -1;	
		foreach($kasusdiagnosa as $kasus){
		$no = $no + 1;
			$str_kasus_diagnosa = "INSERT INTO `$tbdiagnosapasien`(`IdPasienrj`,`TanggalDiagnosa`,`NoIndex`,`NoCM`,`NoRegistrasi`,`KodeDiagnosa`,`Kasus`,`Asuransi`,`Kelompok`,`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin`) VALUES 
			('$idpasienrj','$tanggal_registrasi','$noindex','$nocm','$noregistrasi','$kddiagnosabpjs[$no]','$kasus','$asuransi','$kelompok[$no]','$umurtahunpasien','$umurbulanpasien','$umurharipasien','$kelaminpasien')";
			mysqli_query($koneksi, $str_kasus_diagnosa);

			$str_diagnosa_bulan = "INSERT INTO `$tbdiagnosapasien_bulan`(`IdPasienrj`,`TanggalDiagnosa`,`NoIndex`,`NoCM`,`NoRegistrasi`,`KodeDiagnosa`,`Kasus`,`Asuransi`,`Kelompok`,`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin`) VALUES 
			('$idpasienrj','$tanggal_registrasi','$noindex','$nocm','$noregistrasi','$kddiagnosabpjs[$no]','$kasus','$asuransi','$kelompok[$no]','$umurtahunpasien','$umurbulanpasien','$umurharipasien','$kelaminpasien')";
			mysqli_query($koneksi, $str_diagnosa_bulan);
		}
	}	
	
	// insert tbdiagnosa askep
	$kodediagnosaaskep = $_POST['kodediagnosaaskep'];
	$tbdiagnosaaskep = 'tbdiagnosaaskep_'.str_replace(' ', '', $namapuskesmas);
	$tindakanaskep = strtoupper($_POST['tindakanaskep']);
	if($kodediagnosaaskep != null){
		$no = -1;	
		foreach($kodediagnosaaskep as $kodeaskep){
		$no = $no + 1;
			$str_diagnosa_askep = "INSERT INTO `$tbdiagnosaaskep`(`TanggalDiagnosa`,`NoRegistrasi`,`NoCM`,`NamaPasien`,`JenisKelamin`,`Anamnesa`,`KodeDiagnosa`,`TindakanKeperawatan`,`NamaPerawat1`,`NamaPerawat2`) VALUES 
			('$tanggal_registrasi','$nopemeriksaan','$nocm','$namapasien','$kelaminpasien','$anamnesa','$kodediagnosaaskep[$no]','$tindakanaskep','$tenagamedis2','$tenagamedis3')";
			mysqli_query($koneksi,$str_diagnosa_askep);
		}
	}
 		
	// insert tindakan
	$no = -1;
	$idtindakanbpjs = $_POST['idtindakanbpjs'];
	$tariftindakanbpjs = $_POST['tariftindakanbpjs'];
	$keteranganbpjs = $_POST['keteranganbpjs'];
	foreach($idtindakanbpjs as $kdtindakan){
		$no = $no + 1;		
		// tbtindakan
		$getkategoritindakan = 	mysqli_query($koneksi,"SELECT `KelompokTindakan`,`Tarif` FROM `tbtindakan` WHERE IdTindakan = '$idtindakanbpjs[$no]'");
		if(mysqli_num_rows($getkategoritindakan) > 0){
			$dttindakan = mysqli_fetch_assoc($getkategoritindakan);
			$kattindakan = $dttindakan['KelompokTindakan'];
			$tariftindakan = $dttindakan['Tarif'];
			$total_tariftindakan = $total_tariftindakan + $tariftindakan;
		}else{
			$kattindakan = '-';
			$tariftindakan = 0;
			$total_tariftindakan = 0;
		}
		
		$str_tindakanpasiendetail = "INSERT INTO `$tbtindakanpasien`(`IdPasienrj`,`TanggalTindakan`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`PoliAsal`,`CaraBayar`,`IdTindakan`,`Tarif`,`KategoriTindakan`,`Keterangan`,`StatusBayar`,`NamaPegawaiSimpan`) 
		VALUES ('$idpasienrj','$tanggal_time','$nopemeriksaan','$noindex','$nocm','$namapasien','$pelayanan','$asuransi','$idtindakanbpjs[$no]','$tariftindakanbpjs[$no]','$kattindakan','$keteranganbpjs[$no]','BELUM','$tenagamedisbpjs')";
		// echo $str_tindakanpasiendetail;
		// die();
		mysqli_query($koneksi,$str_tindakanpasiendetail);
	}
	
	// update tariftindakan
	$tarifkarcis = $datapasienrj['TarifKarcis'];
	$tarifkir = $datapasienrj['TarifKir'];
	$totaltarif = $tarifkarcis + $tarifkir + $total_tariftindakan;
	$update_tarif = "UPDATE `$tbpasienrj` SET `TarifTindakan`='$total_tariftindakan', `TotalTarif`='$totaltarif' WHERE `NoRegistrasi` = '$nopemeriksaan'";
	mysqli_query($koneksi, $update_tarif);
	$update_tarif_retensi = "UPDATE `$tbpasienrj_retensi` SET `TarifTindakan`='$total_tariftindakan', `TotalTarif`='$totaltarif' WHERE `NoRegistrasi` = '$nopemeriksaan'";
	mysqli_query($koneksi, $update_tarif_retensi);
	
	// update tbpasienperpegawai
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	if ($pelayanan == 'POLI LABORATORIUM'){
		$str_pgw = "UPDATE `$tbpasienperpegawai` SET `Lab`='$tenagalab' WHERE `NoRegistrasi` = '$nopemeriksaan'";
	}else{
		// cek data dulu
		$cek_perpegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi` = '$nopemeriksaan'"));
		if($cek_perpegawai == ''){
			$str_pgw = "INSERT INTO `$tbpasienperpegawai`(`TanggalRegistrasi`,`NoRegistrasi`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`)
			VALUES ('$tanggal_registrasi','$nopemeriksaan','$tenagamedisbpjs','$tenagamedis2','$tenagamedis3')";
		}else{
			$str_pgw = "UPDATE `$tbpasienperpegawai` SET `NamaPegawai1` = '$tenagamedisbpjs', `NamaPegawai2` = '$tenagamedis2',
			`NamaPegawai3` = '$tenagamedis3',`Lab`='$tenagalab'
			WHERE `NoRegistrasi` = '$nopemeriksaan'";
		}
	}
	mysqli_query($koneksi,$str_pgw);	
	
	// insert ke tabel periksa server BPJS
	if(substr($asuransi,0,4) == 'BPJS'){
		// if($kodepuskesmas == 'P3202280201'){
			include "config/helper_bpjs_v4.php";		
			if($statuspulang == 4){
				$tglEstRujuk = date('d-m-Y', strtotime($_POST['tglfaskes']));
			}else{
				$tglEstRujuk = date('d-m-Y', strtotime($datapasienrj['TanggalRegistrasi']));
			}
			
			// vitalsign, integer
			$sistole_p = (int)$_POST['sistole'];
			$diastole_p = (int)$_POST['diastole'];
			$beratbadan_p = (int)$_POST['beratbadan'];
			$tinggibadan_p = (int)$_POST['tinggibadan'];
			$resprate_p = (int)$_POST['resprate'];
			$heartrate_p = (int)$_POST['heartrate'];
			$lingkarperut_p = (int)$_POST['lingkarperut'];
			
			if($kondisi_rujukan == 'kondisi khusus'){
				$hasil_simpan_bpjs = simpan_pemeriksaan_khusus($nokartu,$tanggal_bpjs,$kdpoli,$keluhan,$kdSadar,$sistole_p,$diastole_p,$beratbadan_p,$tinggibadan_p,$resprate_p,$heartrate_p,
				$lingkarperut_p,$terapi,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdkhusus,$kdsubspesialis_khusus,$catatan,$kdtacc,$alasantacc);
			}else{
				$hasil_simpan_bpjs = simpan_pemeriksaan_spesialis($nokartu,$tanggal_bpjs,$kdpoli,$keluhan,$kdSadar,$sistole_p,$diastole_p,$beratbadan_p,$tinggibadan_p,$resprate_p,$heartrate_p,
				$lingkarperut_p,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdsubspesialis_spesial,$kdsarana,$kdtacc,$alasantacc);
			
				$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
				$no_kunjungan = $json_hasil_simpan_bpjs['response'][0]['message'];
				$code = $json_hasil_simpan_bpjs['metaData']['code'];
			}			
					
			$keteranganbridging = "";
			if($code != '200'){
				foreach($json_hasil_simpan_bpjs['response'] as $jkeerror){
					$keterror[] = $jkeerror['field']." - ".$jkeerror['message'];
				}
				$keteranganbridging = implode(", ", $keterror);
			}

			// update tbpasienrj
			$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoKunjunganBpjs`= '$no_kunjungan', `KeteranganBridging` = '$keteranganbridging', `StatusBuku` = 'i', `JamKembaliRM`='$tanggal_time' WHERE `IdPasienrj` = '$idpasienrj'";
			mysqli_query($koneksi, $strupdatenokunjungan);
			$strupdatenokunjungan_retensi = "UPDATE `$tbpasienrj_retensi` SET `NoKunjunganBpjs`= '$no_kunjungan', `KeteranganBridging` = '$keteranganbridging', `StatusBuku` = 'i', `JamKembaliRM`='$tanggal_time' WHERE `IdPasienrj` = '$idpasienrj'";
			mysqli_query($koneksi, $strupdatenokunjungan_retensi);
		// }
	}	

	// update tbpasienrj, untuk pasien umum
	$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `StatusBuku` = 'i', `JamKembaliRM`='$tanggal_time' WHERE `IdPasienrj` = '$idpasienrj'";
	mysqli_query($koneksi, $strupdatenokunjungan);
	$strupdatenokunjungan_retensi = "UPDATE `$tbpasienrj_retensi` SET `StatusBuku` = 'i', `JamKembaliRM`='$tanggal_time' WHERE `IdPasienrj` = '$idpasienrj'";
	mysqli_query($koneksi, $strupdatenokunjungan_retensi);

	// insert tbresep
	// jangan diaktifkan, karena klo tidak ada menambahkan data obat maka insert data tidak akan jalan. 
	// Kebutuhannya untuk merubah status resep (diberikan, konseling, resep luar)
	
	if($_POST['kodeobatlokal'] != ''){
		$nomorantrian = $_POST['noantrianresep'];
		$str_resep = "INSERT INTO `$tbresep`(`TanggalResep`, `NoResep`, `NoIndex`, `NoCM`, `IdPasienrj`, `NamaPasien`, `UmurTahun`, `UmurBulan`, `StatusBayar`, `Pelayanan`, `NamaPegawai`, `Status`, `StatusLoket`, `Diagnosa`,`NomorAntrian`,`OpsiResep`,`KetResepLuar`) VALUES
		('$tanggal_time','$nopemeriksaan','$noindex','$nocm','$idpasienrj','$namapasien','$umurtahun','$umurbulan','$asuransi','$pelayanan','$tenagamedisbpjs','Belum','LOKET OBAT','$kddiagnosaprimary','$nomorantrian','$opsiresep','$ket_resep_luar')";
		$query2 = mysqli_query($koneksi, $str_resep);		
	}
	
	$kdobatsk = 0;
	$jumlahbpjs=$_POST['jumlahbpjs'];
	$nobatch = $_POST['nobatch'];
	$kdobatbpjs = $_POST['kodeobatbpjs'];	
	$kdobatlokal = $_POST['kodeobatlokal'];
	$racikan= $_POST['status_racikan_bpjs'];
	$dosisbpjs1 = $_POST['dosisbpjs1'];
	$dosisbpjs2 = $_POST['dosisbpjs2'];
	$namaobatbpjs = $_POST['namaobatbpjs'];
	$namaobatnonbpjs = $_POST['namaobatnonbpjs'];
	$anjuranterapi = $_POST['anjuranterapi'];
	$ket_racikan = $_POST['ket_racikan'];
	
	if($kdobatbpjs != null){	
		$i = -1;	
		foreach($kdobatbpjs as $kdt){
			$i= $i + 1;
			
			if($racikan[$i] == 'true'){
				$kdracikan= 'R.01';
				//$jmlpermintaan = $jumlahbpjs[$i] / 500;
			}else{
				$kdracikan= null;
				//$jmlpermintaan = 0;
			}
			$jmlpermintaan = $jumlahbpjs[$i];

			if($kdt == ''){
				$namaobatbpjs= false;
				$namaobatnondpho= $namaobatnonbpjs[$i];
			}else{
				$namaobatbpjs= true;
				$namaobatnondpho= $namaobatbpjs[$i];
			}			
			
			// matikan dl sementara (27 oktober 2023)
			// if($no_kunjungan != null){
			// 	$simpan_terapi_bpjs = simpan_terapi_bpjs($kdobatsk,$no_kunjungan,$racikan[$i],$kdracikan,$namaobatbpjs,$kdt,$dosisbpjs1[$i],$dosisbpjs2[$i],$jumlahbpjs[$i],$jmlpermintaan,$namaobatnondpho);	
			// 	$json_hasil_simpan_obat_bpjs = json_decode($simpan_terapi_bpjs,True);
			// 	$kdobatsk2 = $json_hasil_simpan_obat_bpjs['response'][0]['message'];
			// }else{
			// 	$kdobatsk2 = "0";
			// }
			
			$str_resep_detail = "INSERT INTO `$tbresepdetail`(`TanggalResep`,`NoResep`,`IdPasienrj`,`racikan`,`kdRacikan`,`obatDPHO`,`KodeBarang`,`NoBatch`,`signa1`,`signa2`,`jumlahobat`,`jmlPermintaan`,`nmObatNonDPHO`,`KdObatSk`,`Pelayanan`,`AnjuranResep`,`KeteranganRacikan`,`Depot`) VALUES
			('$tanggal_time','$nopemeriksaan','$idpasienrj ','$racikan[$i]','$kdracikan','$namaobatbpjs','$kdobatlokal[$i]','$nobatch[$i]','$dosisbpjs1[$i]','$dosisbpjs2[$i]','$jumlahbpjs[$i]','$jmlpermintaan','$namaobatnondpho','$kdobatsk2','$pelayanan','$anjuranterapi[$i]','$ket_racikan[$i]','LOKET OBAT')";
			mysqli_query($koneksi, $str_resep_detail);			

			$get_stok_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"Select Stok FROM `$tbapotikstok` WHERE `KodeBarang`='$kdobatlokal[$i]' AND `NoBatch`='$nobatch[$i]' AND `StatusBarang`='LOKET OBAT'"));
			$stok_baru = $get_stok_lama['Stok'] - $jumlahbpjs[$i];			
			
			$str_obat_update = "UPDATE `$tbapotikstok` SET `Stok`='$stok_baru' WHERE KodeBarang = '$kdobatlokal[$i]' AND `NoBatch`='$nobatch[$i]' AND `StatusBarang`='LOKET OBAT'";
			mysqli_query($koneksi,$str_obat_update);
		}
	}	
	
	// tindakan 
	$tanggaltindakan = date('Y-m-d G:i:s', strtotime($tanggal_registrasi));
	$kdtindakan = $_POST['kodetindakanbpjs'];
	if($kdtindakan != null){
		$kdtindakan2 = implode($kdtindakan,"','");
		$sumtarif = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(Tarif)as total FROM tbtindakan WHERE IdTindakan IN('$kdtindakan2')"));
		$grandtotalbiaya = $sumtarif['total'];
		$kategoritindakan = '';
		
		$biaya =  $_POST['tariftindakanbpjs'];

		$y = -1;	
		$tanggaltindakan_time = $tanggaltindakan." ".date('G:i:s');
		foreach($kdtindakan as $kdtin){
			$y= $y + 1;
			mysqli_query($koneksi,"INSERT INTO `$tbtindakanpasien`(`TanggalTindakan`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`PoliAsal`,`CaraBayar`,`IdTindakan`,`Tarif`,`KategoriTindakan`,`Keterangan`,`NamaPegawaiSimpan`) 
			VALUES ('$tanggaltindakan_time','$noregistrasi','$noindex','$nocm','$namapasien','$pelayanan','$asuransi','$kdtin','$biaya[$y]','$kategoritindakan','$keterangan[$y]','$namapegawai')");
			
		}
	}
	
	$kdtindakansk = 0;
	// $biaya =  $_POST['tariftindakanbpjs'];
	$keterangan =  $_POST['keteranganbpjs'];
	$hasil = 0;
	
// insert ke tabel obat server BPJS
	if($query){	
		if ($strdiagnosapasien != ""){
			$cek_q = mysqli_query($koneksi,$strdiagnosapasien);
			if($cek_q){
			}else{
				// echo $strdiagnosapasien;	klo gagal simpan diagnosa ispa, diare...dll
				// die();
			}
		}

		alert_swal('sukses','Data berhasil disimpan');
		echo "<script>";
		if($pelayanan == 'POLI SKD'){
			echo "document.location.href='index.php?page=poli_skd_blangko&id=$nopemeriksaan&nocm=$nocm&noindex=$noindex';";
		}else{
			if($statuspulang == 4){
				echo "document.location.href='index.php?page=poli&pelayanan=$pelayanan&nama=$namapasien&status=Sudah';";
			}elseif($sts_resep == null){
				$status2 = $_POST['status2'];
				$tptgl = $_POST['tptgl'];
				echo "document.location.href='index.php?page=poli_periksa_print&idrj=$idpasienrj&noreg=$nopemeriksaan&pelayanan=$pelayanan';";
			}elseif($sts_resep == 'bulan'){
				echo "document.location.href='index.php?page=poli_antri_bulan';";
			}else{
				echo "document.location.href='index.php?page=$sts_resep';";
			}
		}
		echo "</script>";
	}else{
		// echo $str;
		// die();
		alert_swal('gagal','Data gagal disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=poli_periksa&id=$idpasienrj&pelayanan=$pelayanan&status=Antri&tptgl=$tanggal_registrasi';";
		echo "</script>";
	} 
?>