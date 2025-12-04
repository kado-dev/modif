<?php
    session_start();
    error_reporting(1);
    include "config/koneksi.php";
    include "config/helper.php";
    include "config/helper_pasienrj.php";
    include "config/helper_report.php";
    include "config/helper_bpjs_v4.php";

    // jangan dipindah keatas, nnti gak jalan waktunya
    if($kota == "KOTA TARAKAN" OR $kota == "KABUPATEN KUTAI KARTANEGARA"){
        date_default_timezone_set('Asia/Ujung_Pandang');
    }else{
        date_default_timezone_set('Asia/Jakarta');
    }

    $idrj = $_POST['idrj']; 
    $getdtpasienrj = mysqli_query($koneksi,"SELECT * FROM $tbpasienrj WHERE IdPasienrj = '$idrj'");
    if(mysqli_num_rows($getdtpasienrj) == 0){
        alert_swal('gagal','Data registrasi pasien tidak ditemukan');
        echo "<script>";
        echo "document.location.href='index.php?page=poli_periksa_print&idrj=$idrj';";
        echo "</script>";
        die();
    }

    $gettbvitalsign = mysqli_query($koneksi,"SELECT * FROM $tbvitalsign WHERE IdPasienrj = '$idrj'");
    if(mysqli_num_rows($gettbvitalsign) == 0){
        alert_swal('gagal','Data vital sign tidak ditemukan');
        echo "<script>";
        echo "document.location.href='index.php?page=poli_periksa_print&idrj=$idrj';";
        echo "</script>";
        die();
    }

    

    $dtpasienrj = mysqli_fetch_assoc($getdtpasienrj);
    if($dtpasienrj['PoliPertama'] == 'POLI ANAK'){
        $tbpolis = 'tbpolianak';
    }else if($dtpasienrj['PoliPertama'] == 'POLI GIZI'){
        $tbpolis = 'tbpolianak';
    }else if($dtpasienrj['PoliPertama'] == 'POLI LANSIA'){
        $tbpolis = $tbpolilansia;
    }else if($dtpasienrj['PoliPertama'] == 'POLI UMUM'){
        $tbpolis = $tbpoliumum;
    }else if($dtpasienrj['PoliPertama'] == 'POLI TB'){
        $tbpolis = 'tbpolitb';
    }else if($dtpasienrj['PoliPertama'] == 'POLI TB DOTS'){
        $tbpolis = 'tbpolitbdots';
    }

    $getpasienpoli = mysqli_query($koneksi, "SELECT * FROM $tbpolis WHERE IdPasienrj = '$idrj'");
    if(mysqli_num_rows($getpasienpoli) == 0){
        alert_swal('gagal','Data poli pasien tidak ditemukan');
        echo "<script>";
        echo "document.location.href='index.php?page=poli_periksa_print&idrj=$idrj';";
        echo "</script>";
        die();
    }

    
    $dtpoli = mysqli_fetch_assoc($getpasienpoli);
    $dtvitalsign = mysqli_fetch_assoc($gettbvitalsign);
    $idpasienrj  = $dtpasienrj['IdPasienrj'];
    $nokunjunganbpjs = $dtpasienrj['NoKunjunganBpjs'];
    $nokartu = $dtpasienrj['nokartu'];
    $keluhan = 'kontrol sehat';//$dtpoli['Keluhan'];
    $tanggalregistrasi = date('d-m-Y',strtotime($dtpasienrj['TanggalRegistrasi']));

    $NoPemeriksaan = $dtpoli['NoPemeriksaan'];
    
    $kdSadar = $dtpoli['Kesadaran'];


   

    $sistole_p = (int)$dtvitalsign['Sistole'];
	$diastole_p = (int)$dtvitalsign['Diastole'];
	$beratbadan_p = (int)$dtvitalsign['BeratBadan'];
	$tinggibadan_p = (int)$dtvitalsign['TinggiBadan'];
	$resprate_p = (int)$dtvitalsign['RespiratoryRate'];
	$heartrate_p = (int)$dtvitalsign['HeartRate'];
	$lingkarperut_p = (int)$dtvitalsign['LingkarPerut'];
    $suhutubuh = (int)$dtvitalsign['SuhuTubuh'];
    $kdStatusPulang = 4;
    
    $tglPulang = date('d-m-Y');
    $getDokter = mysqli_query($koneksi,"SELECT * FROM `tbpegawaibpjs` WHERE nmDokter = '".$dtpoli['NamaPegawaiSimpan']."'");
    if(mysqli_num_rows($getDokter) == 0){
        alert_swal('gagal','Data dokter tidak ditemukan');
        echo "<script>";
        echo "document.location.href='index.php?page=poli_periksa_print&idrj=$idrj';";
        echo "</script>";
        die();
    }
    $dtdokter = mysqli_fetch_assoc($getDokter);
    $kdDokter = $dtdokter['kdDokter'];

    $gttbdiagnosa = mysqli_query($koneksi,"SELECT * FROM $tbdiagnosapasien WHERE IdPasienrj = '$idrj'");
    if(mysqli_num_rows($gttbdiagnosa) == 0){
        alert_swal('gagal','Data diagnosa tidak ditemukan');
        echo "<script>";
        echo "document.location.href='index.php?page=poli_periksa_print&idrj=$idrj';";
        echo "</script>";
        die();
    }

    $dtdiagnosa = mysqli_fetch_assoc($gttbdiagnosa);

    $kdDiag1 = $dtdiagnosa['KodeDiagnosa'];
    $kdDiag2 = null;
    $kdDiag3 = null;

    $tglEstRujuk = $_POST['tglrujuk'];
    $kdppk = $_POST['ppk'];
    $spesialis = $_POST['spesialis'];
    $kdsubspesialis_spesial = $_POST['sub-spesialis'];
    $kdsarana = '';
    $kdtacc = -1;
    $alasantacc = '< 3 Hari';

    $anamnesa = $dtpoli['Anamnesa'];
    $alergiMakan = $dtpoli['RiwayatAlergiMakanan'];
    $alergiUdara = $dtpoli['RiwayatAlergiUdara'];
    $alergiObat = $dtpoli['RiwayatAlergiObat'];
    $kdPrognosa = $dtpoli['Prognosis'];
    $terapiObat = $dtpoli['TerapiObat'];
    $terapiNonObat = $dtpoli['TerapiNonObat'];
    $bmhp = $dtpoli['Bmhp'];

    $tglrujuk = date('Y-m-d',strtotime($tglEstRujuk));
    mysqli_query($koneksi,"INSERT INTO `tbrujukanbpjs`(`IdTbrujukanBpjs`, `IdPasienrj`, `Spesialis`, `SubSpesialis`, `TglEstRujuk`, `PPK`) VALUES (null,'$idrj','$spesialis','$kdsubspesialis_spesial','$tglrujuk','$kdppk')");

    $hasil_simpan_bpjs = edit_pemeriksaan($nokunjunganbpjs,$nokartu,$keluhan,$kdSadar,$sistole_p,$diastole_p,$beratbadan_p,$tinggibadan_p,$resprate_p,$heartrate_p,$lingkarperut_p,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdsubspesialis_spesial,$kdsarana,$kdtacc,$alasantacc,$anamnesa,$alergiMakan,$alergiUdara,$alergiObat,$kdPrognosa,$terapiObat,$terapiNonObat,$bmhp,$suhutubuh);
	$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
    $no_kunjungan = $json_hasil_simpan_bpjs['response'][0]['message'];	
    $response = $json_hasil_simpan_bpjs['response'];	
    $code = $json_hasil_simpan_bpjs['metaData']['code'];		
    // echo $hasil_simpan_bpjs."<br/>";
    // echo "response : ".$response."<br/>";
    // echo "code : ".$code;
    // die();  

    // if($code == '428'){
    //     $getrujukan = get_rujukan_bpjs($nokunjunganbpjs);
    //     $json_rujukan = json_decode($getrujukan,True);
    //     $code = $json_rujukan['metaData']['code'];
    // }

    // untuk membaca pesan error jika nokunjungan bpjs kosong / null
    $keteranganbridging = "";
    if($code != '200'){
        foreach($json_hasil_simpan_bpjs['response'] as $jkeerror){
            $keterror[] = $jkeerror['field']." - ".$jkeerror['message'];
        }
        $keteranganbridging = implode(", ", $keterror);
    }

    $strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoKunjunganBpjs`= '$nokunjunganbpjs', `KeteranganBridging` = '$keteranganbridging' WHERE `IdPasienrj` = '$idpasienrj'";
    mysqli_query($koneksi,$strupdatenokunjungan);
    $strupdatenokunjungan_retensi = "UPDATE `$tbpasienrj_retensi` SET `NoKunjunganBpjs`= '$nokunjunganbpjs', `KeteranganBridging` = '$keteranganbridging' WHERE `IdPasienrj` = '$idpasienrj'";
    mysqli_query($koneksi,$strupdatenokunjungan_retensi);

    if($code == '200'){
        alert_swal('sukses','Data berhasil disimpan');
    }elseif($code == '428'){
        alert_swal('gagal','Print di Pcare! Data Rujukan sudah dilayani di RS');
    }elseif($code == '412'){
        alert_swal('gagal','Print di Pcare! Transaksi dikunci karena sudah ditagihkan atau data > 3 bulan atau sudah dilayani RS');
    }else{
        alert_swal('gagal','Precondition Failed! Data tidak sesuai');
    }
    
    echo "<script>";
    echo "document.location.href='index.php?page=poli_periksa_print&noreg=$NoPemeriksaan&idrj=$idpasienrj&pelayanan=';";
    echo "</script>";
?>