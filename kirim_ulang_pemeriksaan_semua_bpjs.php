<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";	
    include "config/helper_bpjs_v4.php";    

    $hal = $_GET['hal'];
    $bulan = ($_GET['bulan'] == '') ? date('m') : $_GET['bulan'];
    $tahun = ($_GET['tahun'] == '') ? date('Y') : $_GET['tahun'];

    
    $str = "SELECT * FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND `Asuransi` like '%BPJS%' AND `StatusPasien` <> '2' AND `StatusPelayanan`='Sudah' AND `StatusPulang`='3' AND (LENGTH(`NoKunjunganBpjs`) != 19)";
    			
    // echo $str;
    // die();
    
    $query = mysqli_query($koneksi,$str);
    while($datapasienrj = mysqli_fetch_assoc($query)){

        $idpasienrj = $datapasienrj['IdPasienrj'];
        

        $polipertama = $datapasienrj['PoliPertama'];
        $noasuransi = $datapasienrj['nokartu'];
        $tanggalregistrasi = $datapasienrj['TanggalRegistrasi'];

        if($polipertama == 'POLI GIGI'){
            $tbpelayanan = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
        }elseif($polipertama == 'POLI KIA'){
            $tbpelayanan = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
        }elseif($polipertama == 'POLI LANSIA'){
            $tbpelayanan = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
        }elseif($polipertama == 'POLI MTBS'){
            $tbpelayanan = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
        }elseif($polipertama == 'POLI UMUM'){
            $tbpelayanan = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
        }elseif($polipertama == 'POLI UGD'){
            $tbpelayanan = "tbpolitindakan";
        }else{
            $tbpelayanan = "tb".strtolower(str_replace(' ','', $pel));
        }

        //var_dump($datapasienrj);
        
        $nokartu = $datapasienrj['nokartu'];
        $tanggal_bpjs = date('d-m-Y', strtotime($datapasienrj['TanggalRegistrasi']));
        $kdpoli = $datapasienrj['kdpoli'];

        $strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
        $dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
        $sistole_p = (int)$dtvs['Sistole'];
        $diastole_p = (int)$dtvs['Diastole'];
        $suhutubuh = $dtvs['SuhuTubuh'];
        $tinggibadan_p = (int)$dtvs['TinggiBadan'];
        $beratbadan_p = (int)$dtvs['BeratBadan'];
        $heartrate_p = (int)$dtvs['HeartRate'];
        $resprate_p = (int)$dtvs['RespiratoryRate'];
        $lingkarperut_p = (int)$dtvs['LingkarPerut'];


        // echo "SELECT * FROM `$tbpelayanan` WHERE `IdPasienrj`='$idpasienrj'";    
        $dtpel = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpelayanan` WHERE `IdPasienrj`='$idpasienrj'"));
        $anamnesa = $dtpel['Anamnesa'];
        $keluhan = $dtpel['Keluhan'];
        if(empty($keluhan)){$keluhan = $anamnesa;}
        $kdSadar = $dtpel['Kesadaran'];
        $NamaPegawaiSimpan = $dtpel['NamaPegawaiSimpan'];
        
        $kdDokter = 0;
        $getPegawaiBpjs = mysqli_query($koneksi, "SELECT * FROM `tbpegawaibpjs` WHERE `nmDokter`='$NamaPegawaiSimpan'");
        if(mysqli_num_rows($getPegawaiBpjs) > 0){
            $dtdok = mysqli_fetch_assoc($getPegawaiBpjs);
            $kdDokter = $dtdok['kdDokter'];
        }

        $kdStatusPulang = $datapasienrj['StatusPulang'];
        $tglPulang = date('d-m-Y', strtotime($datapasienrj['TanggalRegistrasi']));

        $getDiagnosaRj = mysqli_query($koneksi, "SELECT * FROM $tbdiagnosapasien WHERE `IdPasienrj`='$idpasienrj'");
        if(mysqli_num_rows($getDiagnosaRj) > 0){
            while($dtDiagnosaRj = mysqli_fetch_assoc($getDiagnosaRj)){
                $kodediag[] = $dtDiagnosaRj['KodeDiagnosa'];
            }
        }

        $kdDiag1 = $kodediag[0];
        $kdDiag2 = $kodediag[1];
        $kdDiag3 = $kodediag[2];
        
        $tglEstRujuk = date('d-m-Y', strtotime($datapasienrj['TanggalRegistrasi']));
        $kdppk = $datapasienrj['kdprovider'];
        $kdsubspesialis_spesial = null;    
        $kdsarana = null;
        $kdtacc = -1; // Tanpa TACC
        $alasantacc = null;

    
        $alergiMakan = $dtpel['RiwayatAlergiMakanan'];
        $alergiUdara = $dtpel['RiwayatAlergiUdara'];
        $alergiObat = $dtpel['RiwayatAlergiObat'];
        $kdPrognosa= $dtpel['Prognosis'];
        $terapiObat= $dtpel['TerapiObat'];
        $terapiNonObat= $dtpel['TerapiNonObat'];
        $bmhp = $dtpel['Bmhp'];
        
        // simpan pemeriksaan
        $hasil_simpan_bpjs = simpan_pemeriksaan_spesialis($nokartu,$tanggal_bpjs,$kdpoli,$keluhan,$kdSadar,$sistole_p,$diastole_p,$beratbadan_p,$tinggibadan_p,$resprate_p,$heartrate_p,$lingkarperut_p,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdsubspesialis_spesial,$kdsarana,$kdtacc,$alasantacc,$anamnesa,$alergiMakan,$alergiUdara,$alergiObat,$kdPrognosa,$terapiObat,$terapiNonObat,$bmhp,$suhutubuh);
        // echo $hasil_simpan_bpjs;

        $json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
        $no_kunjungan = $json_hasil_simpan_bpjs['response'][0]['message'];	
        $code = $json_hasil_simpan_bpjs['metaData']['code'];

        if($code == '200' OR $code == '201'){
            alert_notify('sukses','Data berhasil terbridging...');
        }else{
            alert_notify('gagal','Data gagal terbridging...');
        }

        if(strtolower($no_kunjungan) == 'peserta sudah di-entri di poli yang sama pada hari yang sama.'){
            //coba get dari riwayat by nokartu
            $getriwayat = get_data_riwayat($nokartu);
            $json_riwayat = json_decode($getriwayat,True);
    
            //echo $getriwayat."<br/><br/>";
            
    
            $tglKunjungan = $json_riwayat['response']['list'][0]['tglKunjungan'];
            // echo $tglKunjungan."<br/>";
            // echo $tanggal_bpjs."<br/>";
            if($tglKunjungan == $tanggal_bpjs){
                $no_kunjungan = $json_riwayat['response']['list'][0]['noKunjungan'];
    
                alert_notify('sukses','Data berhasil terbridging sebelumnya...');
            }      
            //echo $no_kunjungan."<br/>";
        }

        // echo $hasil_simpan_bpjs;
        // echo $code;
        // die();

        // update nomorkunjungan bpjs
        $strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoKunjunganBpjs`= '$no_kunjungan' WHERE `IdPasienrj` = '$idpasienrj'";
        mysqli_query($koneksi, $strupdatenokunjungan);

        // insert log api
        $hasil_simpan_bpjs1 = mysqli_real_escape_string($koneksi, $hasil_simpan_bpjs);
        $hasil_simpan_bpjs = strtoupper($hasil_simpan_bpjs1);  
        mysqli_query($koneksi, "UPDATE `tblogs_api` SET `LogPcarePemeriksaan` = '$hasil_simpan_bpjs' WHERE `IdPasienrj` = '$idpasienrj' AND `Puskesmas`='$namapuskesmas'");
        // mysqli_query($koneksi,"INSERT INTO `tblogs_api`(`IdPasienrj`, `NomorPeserta`, `TanggalDaftar`, `LogPcarePemeriksaan`,`Puskesmas`) VALUES ('$idpasienrj','$noasuransi','$tanggalregistrasi','$hasil_simpan_bpjs','$namapuskesmas')");
        
}

    echo "<script>";
    echo "document.location.href='index.php?page=".$hal."&bulan=".$bulan."&tahun=".$tahun."'";
    echo "</script>";
?>