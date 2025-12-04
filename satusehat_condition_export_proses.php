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
// $getDTPractitioner 	= get_Practitioner($stsehat_access_token, $nikdokter);
// $IdPractitioner		= $getDTPractitioner['IdPractitioner'];
// $ResourceType 		= $getDTPractitioner['ResourceType'];
// $NamePractitioner 	= $getDTPractitioner['NamePractitioner'];

$tgl = $_GET['tgl'];
$tglakhir = $_GET['tglakhir'];
if($tgl == ''){
    $tgl = date('Y-m-d');
}

// data yang ditampilkan jika nik tidak sama dengan kosong dan encounter tidak sama dengan kosong (10-11-2024)
$namapuskesmas = $_GET['namapuskesmas'];
$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);

$tgl_awal =  date('Y-m-d', strtotime($tgl));
$tgl_akhir =  date('Y-m-d', strtotime($tglakhir));
$str = "SELECT * FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) BETWEEN '$tgl_awal' AND '$tgl_akhir' AND (IdConditionSatuSehat = '' OR IdConditionSatuSehat IS NULL) AND (`IdKunjunganSatuSehat`!='')";
// echo $str;
// die();
$query = mysqli_query($koneksi, $str);

$stsupdate = array();
while($data = mysqli_fetch_assoc($query)){
    $idpasienrj = $data['IdPasienrj'];
    $nikpasien = $data['Nik'];
    $idkunjungansatusehat = $data['IdKunjunganSatuSehat'];
    $tglregistrasi = date('Y-m-d', strtotime($data['TanggalRegistrasi']));
	$PoliPertama = $data['PoliPertama'];
		
	$getDTpatient	= get_Patient($stsehat_access_token, $nikpasien);
	$IdPatient 		= $getDTpatient['IdPatient'];
	$ResourceType 	= $getDTpatient['ResourceType'];
	$NamePatient 	= $getDTpatient['NamePatient'];		

	$datetime = new DateTime($tglregistrasi);
	$tanggal_start = $datetime->format(DateTime::ATOM);

    if($PoliPertama == 'KONSELING' || $PoliPertama == 'HOME-VISIT' || $PoliPertama == 'PENYULUHAN'){
        $pstsehat_condition['resourceType'] = 'Condition';
        $pstsehat_condition['clinicalStatus']['coding'][0]['system'] = 'http://terminology.hl7.org/CodeSystem/condition-clinical';
        $pstsehat_condition['clinicalStatus']['coding'][0]['code'] = 'active';
        $pstsehat_condition['clinicalStatus']['coding'][0]['display'] = 'Active';
        $pstsehat_condition['category'][0]['coding'][0]['system'] = 'http://terminology.hl7.org/CodeSystem/condition-category';
        $pstsehat_condition['category'][0]['coding'][0]['code'] = 'encounter-diagnosis';
        $pstsehat_condition['category'][0]['coding'][0]['display'] = 'Encounter Diagnosis';
        $pstsehat_condition['code']['coding'][0]['system'] = 'http://hl7.org/fhir/sid/icd-10';
        $pstsehat_condition['code']['coding'][0]['code'] = 'Z71.9';
        $pstsehat_condition['code']['coding'][0]['display'] = 'Counselling, unspecified';
        $pstsehat_condition['subject']['reference'] = 'Patient/'.$IdPatient;
        $pstsehat_condition['subject']['display'] = $NamePatient;
        $pstsehat_condition['encounter']['reference'] = 'Encounter/'.$idkunjungansatusehat;
        $pstsehat_condition['encounter']['display'] = 'Kunjungan '.$NamePatient.' di tanggal, '.tgl_lengkap($tglregistrasi);

        $data_json_cond	= json_encode($pstsehat_condition,true);
        $post_cond			= simpan_satusehat($stsehat_access_token,'Condition',$data_json_cond);
        $dtaparse 			= json_decode($post_cond,true);
        $id_cond_satusehat	= $dtaparse['id'];

        //echo  $dtdiagnosa['KodeDiagnosa'];
        // echo  $data_json_cond."<br/>";
        // echo  "------- <br/>";
        // echo  $post_cond."<br/>";
        // echo  "idcondition : ".$id_cond_satusehat."<br/>";
        // echo  "----------------------------- <br/>";

        $strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `IdConditionSatuSehat`= '$id_cond_satusehat' WHERE `IdPasienrj` = '$idpasienrj'";
        // echo $strupdatenokunjungan;
        mysqli_query($koneksi, $strupdatenokunjungan); 

        if($id_cond_satusehat){
            $stsupdate[] = 1;
        }

    }else{
        $getdiagnosa = mysqli_query($koneksi, "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `IdPasienrj`='$idpasienrj' GROUP BY IdPasienrj");	// sementara digroup by agar diagnosa terkirim tidak duplikasi
        if(mysqli_num_rows($getdiagnosa) > 0){
            $arrdgs = 0;
            while ($dtdiagnosa = mysqli_fetch_assoc($getdiagnosa)){	
                // tbdiagnosabpjs
                $dtdiagnosa_nama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Diagnosa` FROM tbdiagnosabpjs WHERE `KodeDiagnosa`='$dtdiagnosa[KodeDiagnosa]'"));
                $pstsehat_condition['resourceType'] = 'Condition';
                $pstsehat_condition['clinicalStatus']['coding'][$arrdgs]['system'] = 'http://terminology.hl7.org/CodeSystem/condition-clinical';
                $pstsehat_condition['clinicalStatus']['coding'][$arrdgs]['code'] = 'active';
                $pstsehat_condition['clinicalStatus']['coding'][$arrdgs]['display'] = 'Active';
                $pstsehat_condition['category'][$arrdgs]['coding'][0]['system'] = 'http://terminology.hl7.org/CodeSystem/condition-category';
                $pstsehat_condition['category'][$arrdgs]['coding'][0]['code'] = 'encounter-diagnosis';
                $pstsehat_condition['category'][$arrdgs]['coding'][0]['display'] = 'Encounter Diagnosis';
                $pstsehat_condition['code']['coding'][$arrdgs]['system'] = 'http://hl7.org/fhir/sid/icd-10';
                $pstsehat_condition['code']['coding'][$arrdgs]['code'] = $dtdiagnosa['KodeDiagnosa'];
                $pstsehat_condition['code']['coding'][$arrdgs]['display'] = $dtdiagnosa_nama['Diagnosa'];
                $pstsehat_condition['subject']['reference'] = 'Patient/'.$IdPatient;
                $pstsehat_condition['subject']['display'] = $NamePatient;
                $pstsehat_condition['encounter']['reference'] = 'Encounter/'.$idkunjungansatusehat;
                $pstsehat_condition['encounter']['display'] = 'Kunjungan '.$NamePatient.' di tanggal, '.tgl_lengkap($tglregistrasi);

                $data_json_cond	= json_encode($pstsehat_condition,true);
                $post_cond			= simpan_satusehat($stsehat_access_token,'Condition',$data_json_cond);
                $dtaparse 			= json_decode($post_cond,true);
                $id_cond_satusehat	= $dtaparse['id'];

                // echo  $dtdiagnosa['KodeDiagnosa'];
                // echo  $data_json_cond."<br/>";
                // echo  "------- <br/>";
                // echo  $post_cond."<br/>";
                // echo  "idcondition : ".$id_cond_satusehat."<br/>";
                // echo  "----------------------------- <br/>";

                $arrdgs++;
              
                $strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `IdConditionSatuSehat`= '$id_cond_satusehat' WHERE `IdPasienrj` = '$idpasienrj'";
                mysqli_query($koneksi, $strupdatenokunjungan); 

                if($id_cond_satusehat){
                    $stsupdate[] = 1;
                }
            }
        }
    }
}
// die();

if(count($stsupdate) > 0){
    alert_notify('sukses','Data berhasil terbridging...');
	echo "<script>";
    echo "document.location.href='index.php?page=satusehat_condition_export&namapuskesmas=$namapuskesmas&tgl=".$_GET['tgl']."&tglakhir=".$_GET['tglakhir']."'";
	echo "</script>";
}else{
    alert_notify('sukses','Jika data belum berhasil silahkan ulangi kembali...');
	echo "<script>";
    echo "document.location.href='index.php?page=satusehat_condition_export&namapuskesmas=$namapuskesmas&tgl=".$_GET['tgl']."&tglakhir=".$_GET['tglakhir']."'";
	echo "</script>";
}	



?>