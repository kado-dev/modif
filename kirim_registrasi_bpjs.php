<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";	
    include "config/helper_bpjs_v4.php";
    
    $hal = $_GET['hal'];
    $tgl = $_GET['tgl'];
    $idpasienrj = $_GET['idrj'];
    $query = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idpasienrj'");
	$data = mysqli_fetch_assoc($query);
    $tanggalregistrasi = date('d-m-Y',strtotime($data['TanggalRegistrasi']));
    //$kdprovider = $data['kdprovider'];
    $nokartu = $data['nokartu'];
    $kdpoli = $data['kdpoli'];

    $data_bpjs = get_data_peserta_bpjs($data['nokartu']);
    $dbpjs = json_decode($data_bpjs,true);
    $ketaktif = $dbpjs['response']['ketAktif'];
    $kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];

    $keluhan = null;
    $kunjungan = true;
    $sistole = 0;
    $diastole = 0;
    $beratbadan = 55;
    $tinggibadan = 150;
    $resprate = 20;
    $lingkarPerut = 80;
    $heartrate = 70;
    $rujukbalik = 0;
    $kdtkp = '10';

    $data_bpjs = get_data_peserta_bpjs($nokartu);
    $dbpjs = json_decode($data_bpjs,true);
    $ketaktif = $dbpjs['response']['ketAktif'];
    $kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];

    $hasil_simpan_bpjs = simpan_pasien_rj($tanggalregistrasi,$kdprovider,$nokartu,$kdpoli,$keluhan,$kunjungan,$sistole,$diastole,$beratbadan,$tinggibadan,$resprate,$lingkarPerut,$heartrate,$rujukbalik,$kdtkp);	
    $json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);

    $nourut = '';
    if($json_hasil_simpan_bpjs['response'] != null){
        $metacode = $json_hasil_simpan_bpjs['metaData']['code'];
        $metamessage = $json_hasil_simpan_bpjs['metaData']['message'];	
        if($metacode == '200' OR $metacode == '201'){
            $nourut = $json_hasil_simpan_bpjs['response']['message'];
            alert_notify('sukses','Data berhasil terbridging...');
        }else{
            alert_notify('gagal','Data gagal terbridging...');
        }
    }
    $strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoUrutBpjs`= '$nourut', `ResBpjs`= '$hasil_simpan_bpjs' WHERE `IdPasienrj` = '$idpasienrj'";
    mysqli_query($koneksi,$strupdatenokunjungan);

    echo "<script>";
    if($hal != ''){
        echo "document.location.href='index.php?page=registrasi_data&tgl=".$tgl."&h=".$hal.";'";
    }else{
        echo "document.location.href='index.php?page=registrasi_data&tgl=$tgl.'";
    }    
    echo "</script>";
?>