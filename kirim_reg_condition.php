<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
    include "config/helper_satusehat.php";
	$tgl = $_GET['tgl'];
	$tglakhir = $_GET['tglakhir'];
    $idpasienrj = $_GET['idrj'];
	$nikpasien = $_GET['nikps'];
	$pelayanan = $_GET['pelayanan'];
	$namapkm = $_GET['namapkm'];

    if($_GET['page']=='poli'){
        $page = $_GET['page']."&pelayanan=".$pelayanan;
    }else{
        $page = "satusehat_condition_export";
    }

    // tbpasienrj
    $dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `IdKunjunganSatuSehat`,`PoliPertama` FROM $tbpasienrj WHERE `IdPasienrj`='$idpasienrj'"));
    $idkunjungansatusehat = $dtpasienrj['IdKunjunganSatuSehat'];
    // echo "tes".$idkunjungansatusehat;
    // die();

    if($idkunjungansatusehat != ''){
        $idkunjungansatusehat = $dtpasienrj['IdKunjunganSatuSehat'];
    }else{
        // get dok
        $idpegawai_dokter = $_SESSION['idpegawai_dokter'];
	    $getnikDokter = mysqli_query($koneksi, "SELECT `Nik` FROM `tbpegawai` WHERE IdPegawai = '$idpegawai_dokter'");

        $dtdokters = mysqli_fetch_assoc($getnikDokter);
		$nikdokter = $dtdokters['Nik'];
		
		// --------------- satu sehat --------------- //
		$stsehat_access_token = $_SESSION['stsehat_access_token'];

		$getDTpatient	= get_Patient($stsehat_access_token,$nikpasien);//get nik
		$IdPatient 		= $getDTpatient['IdPatient'];
		$ResourceType 	= $getDTpatient['ResourceType'];
		$NamePatient 	= $getDTpatient['NamePatient'];
        // echo "nik".$stsehat_access_token;
        // echo "nik".$nikpasien;
        // echo "idps".$IdPatient;
        // die();

		$getDTPractitioner 	= get_Practitioner($stsehat_access_token,$nikdokter);
		$IdPractitioner		= $getDTPractitioner['IdPractitioner'];
		$ResourceType 		= $getDTPractitioner['ResourceType'];
		$NamePractitioner 	= $getDTPractitioner['NamePractitioner'];

		$datetime = new DateTime($tgl_format);
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
		$idkunjungansatusehat	= $dtaparse['id'];

		// echo $data_json."<br/>";
		// echo $idkunjungansatusehat."<br/>";
		// echo $NamePractitioner."<br/>";
		// echo $NamePatient."<br/>";
		// echo $post_encounter."<br/>";
		// die();

        if($idkunjungansatusehat != ''){
            $idkunjungansatusehat = $idkunjungansatusehat;
        }else{
            $idkunjungansatusehat = 'Nik Invalid';
        }
    }
    $strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `IdKunjunganSatuSehat`= '$idkunjungansatusehat' WHERE `IdPasienrj` = '$idpasienrj'";
    echo $strupdatenokunjungan;
    die();
    mysqli_query($koneksi, $strupdatenokunjungan);

    $tglregistrasi = date('Y-m-d', strtotime($data['TanggalRegistrasi']));
    $PoliPertama = $dtpasienrj['PoliPertama'];   

	// get dok
	$idpegawai_dokter = $_SESSION['idpegawai_dokter'];
	$getnikDokter = mysqli_query($koneksi, "SELECT `Nik` FROM `tbpegawai` WHERE IdPegawai = '$idpegawai_dokter'");
	
	if(mysqli_num_rows($getnikDokter) > 0){
		$dtdokters = mysqli_fetch_assoc($getnikDokter);
		$nikdokter = $dtdokters['Nik'];

        // create token  satusehat
        $client_id 	= $_SESSION['stsehat_clientid'];
        $client_secret = $_SESSION['stsehat_clientsecret'];
        $getaccss = login_api_satusehat($client_id, $client_secret);
        if($getaccss){
            $dtaccstoken = json_decode($getaccss,true);
            if($dtaccstoken['status'] == 'approved'){
                $_SESSION['stsehat_access_token'] = $dtaccstoken['access_token'];
                $_SESSION['stsehat_application_name'] = $dtaccstoken['application_name'];
                $_SESSION['stsehat_expires_in'] = $dtaccstoken['expires_in'];
                $_SESSION['stsehat_refresh_count'] = $dtaccstoken['refresh_count'];
            }
        }
        // echo "token : ".$_SESSION['stsehat_access_token'];
        // echo "getaccss : ".$getaccss;
        // die();
		
		// --------------- satu sehat --------------- //
		$stsehat_access_token = $_SESSION['stsehat_access_token'];
		$getDTpatient	= get_Patient($stsehat_access_token,$nikpasien);//get nik
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

            //  echo  $dtdiagnosa['KodeDiagnosa'];
            // echo  $data_json_cond."<br/>";
            // echo  "------- <br/>";
            // echo  $post_cond."<br/>";
            // echo  "idcondition : ".$id_cond_satusehat."<br/>";
            // echo  "----------------------------- <br/>";

        }else{
            $getdiagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj`='$idpasienrj'");	
            if(mysqli_num_rows($getdiagnosa) > 0){
                $arrdgs = 0;
                while ($dtdiagnosa = mysqli_fetch_assoc($getdiagnosa)){	
                    // tbdiagnosabpjs
                    $dtdiagnosa_nama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbdiagnosabpjs WHERE `KodeDiagnosa`='$dtdiagnosa[KodeDiagnosa]'"));
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
                    if($id_cond_satusehat){
                        $stsupdate[] = 1;
                    }
                }
            }
        }
        // die();       
       
		if($id_cond_satusehat){
			$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `IdConditionSatuSehat`= '$id_cond_satusehat' WHERE `IdPasienrj` = '$idpasienrj'";
			mysqli_query($koneksi, $strupdatenokunjungan);
			alert_notify('sukses','Data berhasil terbridging...');
		}else{
			alert_notify('gagal','Data gagal terbridging...');
		}

        echo "<script>";
        if($hal != ''){
            echo "document.location.href='index.php?page=$page&namapuskesmas=$namapkm&tgl=".$tgl."&tglakhir=".$tglakhir."&h=".$hal.";'";
        }else{
            echo "document.location.href='index.php?page=$page&namapuskesmas=$namapkm&tgl=$tgl&tglakhir=$tglakhir'";
        }  
        echo "</script>";

	}else{
        alert_notify('gagal','Data gagal terbridging...');
        echo "<script>";
        if($hal != ''){
            echo "document.location.href='index.php?page=$page&namapuskesmas=$namapkm&tgl=".$tgl."&tglakhir=".$tglakhir."&h=".$hal.";'";
        }else{
            echo "document.location.href='index.php?page=$page&namapuskesmas=$namapkm&tgl=$tgl&tglakhir=$tglakhir'";
        }    
        echo "</script>";
    }
?>