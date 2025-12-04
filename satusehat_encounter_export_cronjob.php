<?php
session_start();
include "config/koneksi.php";
include "config/helper_satusehat.php";

$text = 'cronjob satusehat: '.date('Y-m-d H:i:s');
mysqli_query($koneksi, "INSERT INTO `testcronjob`(`id`, `keterangan`) VALUES (null,'$text')");

$qrysimpus = mysqli_query($koneksi, "SELECT * FROM tbpuskesmasdetail ORDER BY NamaPPK ASC");
while($dtsimpus = mysqli_fetch_assoc($qrysimpus)){

    $text = 'cronjob satusehat per: '.$dtsimpus['NamaPPK'];
    mysqli_query($koneksi, "INSERT INTO `testcronjob`(`id`, `keterangan`) VALUES (null,'$text')");

    $client_id 	= $dtsimpus['stsehat_clientid'];//k1guSPVWJOxyfGsEGDrWdA23kDnUNA10cUWGrubGLl9PwGb5';
	$client_secret = $dtsimpus['stsehat_clientsecret'];//'E07sT3BxBAjiKX05ChjhSUIUasPqJgstn4lJbAuGACwMc0Qsq0euvu9zkR7pADiy';

    $stsehat_access_token = '';
	$getaccss = login_api_satusehat($client_id, $client_secret);
    if($getaccss){
        $dtaccstoken = json_decode($getaccss,true);
        if($dtaccstoken['status'] == 'approved'){
            $stsehat_access_token = $dtaccstoken['access_token'];
        }
    }

    $text = 'cronjob satusehat per: '.$dtsimpus['namaPPK']." stsehat_access_token: ".$getaccss;
    mysqli_query($koneksi, "INSERT INTO `testcronjob`(`id`, `keterangan`) VALUES (null,'$text')");

    $tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $dtsimpus['NamaPPK']);

    if($stsehat_access_token != ''){

        // // --------------- satu sehat --------------- //
        // // get dok
        $idpegawai_dokter = $dtsimpus['idpegawai_dokter'];
        $getnikDokter = mysqli_query($koneksi, "SELECT `Nik` FROM `tbpegawai` WHERE IdPegawai = '$idpegawai_dokter'");

        // IdKunjunganSatuSehat = '' dikirim ulang
        $dtdokters = mysqli_fetch_assoc($getnikDokter);
        $nikdokter = $dtdokters['Nik'];

        $getDTPractitioner 	= get_Practitioner($stsehat_access_token, $nikdokter);
        $IdPractitioner		= $getDTPractitioner['IdPractitioner'];
        $ResourceType 		= $getDTPractitioner['ResourceType'];
        $NamePractitioner 	= $getDTPractitioner['NamePractitioner'];

        $str = "SELECT * FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '$tgl' AND IdKunjunganSatuSehat = ''";
        $query = mysqli_query($koneksi, $str);
        while($data = mysqli_fetch_assoc($query)){
            $idpasienrj = $data['IdPasienrj'];
            $nikpasien = $data['Nik'];
            $idkunjungansatusehat = $data['IdKunjunganSatuSehat'];
        // echo $idkunjungansatusehat;
        // die();
                    
            if($idkunjungansatusehat == ''){		
                $getDTpatient	= get_Patient($stsehat_access_token, $nikpasien);//get nik
                $IdPatient 		= $getDTpatient['IdPatient'];
                $ResourceType 	= $getDTpatient['ResourceType'];
                $NamePatient 	= $getDTpatient['NamePatient'];		

                $datetime = new DateTime();
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
                $getSidLo = mysqli_query($koneksi, "SELECT * FROM satusehat_location WHERE KodePelayanan = '27'");//27 kodeplayanan pendaftaran
                if(mysqli_num_rows($getSidLo) > 0){
                    $dtloks = mysqli_fetch_assoc($getSidLo);
                    $Satusehat_IdLocation = $dtloks['Satusehat_IdLocation'];
                    $Satusehat_NameLocation = $dtloks['NamaLokasi'].", ".$dtloks['description'];
                }

                $pstsehat['location'][0]['location']['reference'] = "Location/".$Satusehat_IdLocation;//penting
                $pstsehat['location'][0]['location']['display'] = $Satusehat_NameLocation;//penting
                $pstsehat['statusHistory'][0]['status'] = 'arrived';//penting
                $pstsehat['statusHistory'][0]['period']['start'] = $tanggal_start;//'2024-03-01T07:00:00+07:00';//penting
                $pstsehat['serviceProvider']['reference'] = 'Organization/'.$dtsimpus['stsehat_orgid'];//penting
                $pstsehat['identifier'][0]['system'] = 'http://sys-ids.kemkes.go.id/encounter/'.$dtsimpus['stsehat_orgid'];
                $pstsehat['identifier'][0]['value'] = $dtsimpus['stsehat_orgid'];//penting

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
                $query2 = mysqli_query($koneksi, $strupdatenokunjungan); 
                
            }
        }	

    }
}




?>