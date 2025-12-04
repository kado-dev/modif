<?php
    session_start();
    error_reporting(1);
    include "config/koneksi.php";
    include "config/helper.php";
    include "config/helper_pasienrj.php";
    include "config/helper_report.php";

    // jangan dipindah keatas, nnti gak jalan waktunya
    if($kota == "KOTA TARAKAN" OR $kota == "KABUPATEN KUTAI KARTANEGARA"){
        date_default_timezone_set('Asia/Ujung_Pandang');
    }else{
        date_default_timezone_set('Asia/Jakarta');
    }


        $tglEstRujuk = $_POST['tglrujuk'];
        $kdppk = $_POST['ppk'];
        $kdsubspesialis_spesial = $_POST['kategori-kondisi-sub'];
        $kdsarana = '';
        $kdtacc = 1;
        $alasantacc = '< 3 Hari';

        $hasil_simpan_bpjs = edit_pemeriksaan($nokunjunganbpjs,$nokartu,$keluhan,$kdSadar,$sistole_p,$diastole_p,$beratbadan_p,$tinggibadan_p,$resprate_p,$heartrate_p,$lingkarperut_p,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdsubspesialis_spesial,$kdsarana,$kdtacc,$alasantacc,$anamnesa,$alergiMakan,$alergiUdara,$alergiObat,$kdPrognosa,$terapiObat,$terapiNonObat,$bmhp,$suhutubuh);
		// echo $hasil_simpan_bpjs;
		// die();
		$json_hasil_simpan_bpjs = json_decode($hasil_simpan_bpjs,True);
		$no_kunjungan = $json_hasil_simpan_bpjs['response'][0]['message'];	
		$code = $json_hasil_simpan_bpjs['metaData']['code'];		
		
		$keteranganbridging = "";
		if($code != '200'){
			foreach($json_hasil_simpan_bpjs['response'] as $jkeerror){
				$keterror[] = $jkeerror['field']." - ".$jkeerror['message'];
			}
			$keteranganbridging = implode(", ", $keterror);
		}
		
		// untuk membaca pesan error jika nokunjungan bpjs kosong / null
		$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoKunjunganBpjs`= '$nokunjunganbpjs', `KeteranganBridging` = '$keteranganbridging' WHERE `IdPasienrj` = '$idpasienrj'";
		mysqli_query($koneksi,$strupdatenokunjungan);
		$strupdatenokunjungan_retensi = "UPDATE `$tbpasienrj_retensi` SET `NoKunjunganBpjs`= '$nokunjunganbpjs', `KeteranganBridging` = '$keteranganbridging' WHERE `IdPasienrj` = '$idpasienrj'";
		mysqli_query($koneksi,$strupdatenokunjungan_retensi);
?>