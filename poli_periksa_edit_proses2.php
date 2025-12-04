<?php
session_start();
error_reporting(0);
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

$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$jamperiksa = date('G:i:s');

$opsiresep = $_POST['opsiterapi'];
$ket_resep_luar = $_POST['ket_resep_luar'];
// if($opsiresep == 'resep luar'){
// 	$ket_resep_luar = $_POST['ket_resep_luar'];
// }

$idpasienrj = $_POST['idpasienrj'];
$pelayanan = $_POST['pelayanan'];
$nopemeriksaan = $_POST['nopemeriksaan'];
$nocm = $_POST['nocm'];
$noindex = $_POST['noindex'];
$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
$tbpasienrj_retensi = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas)."_RETENSI";
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);

// tbpasienrj
$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));
$tanggal_registrasi = $datapasienrj['TanggalRegistrasi'];//ngikutin tanggal registrasi agar sesuai kunjungan
$tanggal_bpjs = date('d-m-Y', strtotime($datapasienrj['TanggalRegistrasi']));//ngikutin tanggal registrasi agar sesuai kunjungan
$tanggal_time = date('Y-m-d', strtotime($tanggal_registrasi))." ".date('G:i:s');
$namapasien = $datapasienrj['NamaPasien'];
$idpasien = $datapasienrj['IdPasien'];

// buat manggil pasienrj berdsar bulan
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
$kdprovider = $_POST['kdprovider'];
$nokartu = $datapasienrj['nokartu'];
$kodepoli = $datapasienrj['kdpoli'];
$nourutbpjs = $datapasienrj['NoUrutBpjs'];
$nokunjungan = $datapasienrj['NoKunjunganBpjs'];

// tbkk
$datakk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
$alamatpasien = $datakk['Alamat'];
$kelurahanpasien = $datakk['Kelurahan'];
$kotapasien = $datakk['Kota'];

// poliumum
$anamnesa = strtoupper($_POST['anamnesa']);
$anjuran =  strtoupper($_POST['anjuran']);
$pemeriksaanhasillab =  strtoupper($_POST['pemeriksaanpenunjanglab']);
if(isset($_POST['faktoresikolain'])){
	$faktorresikolainnya = implode(",",$_POST['faktoresikolain']);
}else{
	$faktorresikolainnya = '';
}
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
$therapy = $_POST['therapy'];
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

// pokb
// polikb kunj.ulang
$tgl_haid_akhir = $_POST['tgl_haid_akhir'];
$tgl_haid_akhir1 = explode("-",$tgl_haid_akhir);
$tgl_ha = $tgl_haid_akhir1[2]."-".$tgl_haid_akhir1[1]."-".$tgl_haid_akhir1[0];
$kegagalan_kb = strtoupper($_POST['kegagalan_kb']);
$komplikasi_berat = strtoupper($_POST['komplikasi_berat']);
$ic = $_POST['ic'];
$ganticara = $_POST['ganticara'];
$tgl_ganti = $_POST['tgl_ganti'];
$tgl_ganti1 = explode("-",$tgl_ganti);
$tgl_ga = $tgl_ganti1[2]."-".$tgl_ganti1[1]."-".$tgl_ganti1[0];
$pencabutan = $_POST['pencabutan'];
$tgl_cabut = $_POST['tgl_cabut'];
$tgl_cabut1 = explode("-",$tgl_cabut);
$tgl_cb = $tgl_cabut1[2]."-".$tgl_cabut1[1]."-".$tgl_cabut1[0];
$tgl_kembali = $_POST['tgl_kembali'];
$tgl_kembali1 = explode("-",$tgl_kembali);
$tgl_kbl = $tgl_kembali1[2]."-".$tgl_kembali1[1]."-".$tgl_kembali1[0];

// poli kia
$sts_pemeriksaan_kia = $_POST['sts_pemeriksaan_kia'];
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
$hpht_kia = date('Y-m-d', strtotime($_POST['hpht_kia']));
$p4k = $_POST['p4k'];
$usiakehamilan_kia = $_POST['usiakehamilan_kia'];
$trimester_kia = $_POST['trimester_kia'];
$tfu_kia = $_POST['tfu_kia'];
$statusgizi_kia = $_POST['statusgizi_kia'];
$reflekspatella_kia = $_POST['reflekspatella_kia'];
$riwayatsc_kia = $_POST['riwayatsc_kia'];
$djj_kia = $_POST['djj_kia'];
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
$frekuensinafas_ispa = $_POST['frekuensinafas_ispa'];
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
	$cek_diare = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosadiare` WHERE `NoRegistrasi` = '$nopemeriksaan'"));
	if($cek_diare == 0){
		$strdiagnosapasien = "INSERT INTO `tbdiagnosadiare`(`TanggalRegistrasi`,`NoRegistrasi`,`NamaPasien`,`Kelamin`,`UmurTahun`,`UmurBulan`,`Kelurahan`,`BeratBadan`,`SuhuBadan`,
		`Kunjungan`,`TandaBahaya`,`LamaDiare`,`Klasifikasi`,`Rujuk`,`Oralit`,`Infus`,`Zinc`,`ZincSyr`,`Antibiotik`,`ObatLain`,`Keterangan`,`Nakes`)
		VALUES('$tanggal_registrasi','$nopemeriksaan','$namapasien','$kelaminpasien','$umurtahunpasien','$umurbulanpasien','$kelurahanpasien','$beratbadan','$suhutubuh',
		'$statuskunjungan','$tandabahaya_diare','$lamadiare_diare','$klasifikasi_diare','$rujuk_diare','$diareoralit','$diareinfus','$diarezinc','$diarezincsyr','$diareantibiotik',
		'$obatlain_diare','$keterangan_diare','$nakes')";
	}else{
		$strdiagnosapasien = "UPDATE `tbdiagnosadiare` SET `Kelurahan`='$kelurahanpasien',`BeratBadan`='$beratbadan',`SuhuBadan`='$suhutubuh',
		`Kunjungan`='$statuskunjungan',`TandaBahaya`='$tandabahaya_diare',`LamaDiare`='$lamadiare_diare',`Klasifikasi`='$klasifikasi_diare',`Rujuk`='$rujuk_diare',
		`Oralit`='$diareoralit',`Infus`='$diareinfus',`Zinc`='$diarezinc',`ZincSyr`='$diarezincsyr',`Antibiotik`='$diareantibiotik',`ObatLain`='$obatlain_diare',`Keterangan`='$keterangan_diare',`Nakes`='$nakes'
		WHERE `NoRegistrasi`='$nopemeriksaan'";
	}
}else if($_POST['ket_form_diagnosa'] == 'ispa'){
	$cek_ispa = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosaispa` WHERE `NoRegistrasi` = '$nopemeriksaan'"));
	if($cek_ispa == 0){
		$strdiagnosapasien = "INSERT INTO `tbdiagnosaispa`(`TanggalRegistrasi`,`NoIndex`,`NoRegistrasi`, `NamaPasien`, `UmurTahun`, `Alamat`, `Kelurahan`,`Kota`,
		`Kunjungan`, `Kelamin`, `FrekuensiNafas`,`Klasifikasi`,`TindakLanjut`,`AntiBiotik`,`KondisiKujunganUlang`,`KeteranganMeninggal`,`Ispa5tahun`)
		VALUES('$tanggal_registrasi','$noindex','$nopemeriksaan','$namapasien','$umurtahunpasien','$alamatpasien','$kelurahanpasien','$kotapasien',
		'$statuskunjungan','$kelaminpasien','$frekuensinafas_ispa','$klasifikasi_ispa','$tindaklanjut_ispa','$antibiotik_ispa','$kondisikunjulang_ispa',
		'$ketmeninggal_ispa','$ispa_ispa')";
	}else{
		$strdiagnosapasien = "UPDATE tbdiagnosaispa SET FrekuensiNafas = '$frekuensinafas_ispa',
		Klasifikasi = '$klasifikasi_ispa', TindakLanjut = '$tindaklanjut_ispa',
		AntiBiotik = '$antibiotik_ispa', KondisiKujunganUlang = '$kondisikunjulang_ispa',
		KeteranganMeninggal = '$ketmeninggal_ispa', Ispa5tahun = '$ispa_ispa' WHERE NoRegistrasi = '$nopemeriksaan'";
	}
}else if($_POST['ket_form_diagnosa'] == 'campak'){
	$strdiagnosapasien = "INSERT INTO `tbdiagnosacampak`(`TanggalRegistrasi`,`NoRegistrasi`, `NamaPasien`, `NamaOrangTua`,`Kelamin`, `VaksinCampak`,`TanggalTimbulDemam`,`TanggalTimbulRash`,`TanggalSpesimenDarah`,`TanggalSpesimenUrin`,`HasilSpesimenDarah`,`HasilSpesimenUrin`,`VitaminA`,`KeadaanAkhir`,`KlasifikasiDetail`) VALUES
	('$tanggal_registrasi','$nopemeriksaan','$namapasien','-','$kelaminpasien','$vaksincampak_campak','$tgltimbuldemam_campak','$tgltimbulrash_campak','$tglspesimendarah_campak','$tglspesimenurin_campak','$hasilspesimendarah_campak','$hasilspesimenurin_campak','$vitamina_campak','$keadaan_campak','$klasifikasifinal_campak')";
}else if($_POST['ket_form_diagnosa'] == 'ptm'){
	$strdiagnosapasien = "UPDATE `tbdiagnosaptm` SET `Darah` = '$ptm_darah',`Merokok` = '$ptm_merokok' ,`AktifitasFisik`='$ptm_fisik',`KuranMakanSayur`='$ptm_makan_sayur',`KonsumsiAlkohol` = '$ptm_alkohol' where `NoRegistrasi`='$nopemeriksaan'";
}	

// echo $strdiagnosapasien;
// die();

if($disabilitas != ''){
	$str_disabilitas = "UPDATE `tbpasiendisabilitas` SET `KelompokDisabilitas`='$disabilitas' WHERE `NoRegistrasi`='$nopemeriksaan'";
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
$rujuklanjut = $_POST['polilanjut'];
$namapegawai = $_SESSION['username'];
$tenagamedis1 = mysqli_real_escape_string($koneksi, $_POST['tenagamedis1']);
$tenagamedisbpjs = mysqli_real_escape_string($koneksi, $_POST['tenagamedisbpjs']); //nama tenaga medis bpjs
$tenagamedis2 = mysqli_real_escape_string($koneksi, $_POST['tenagamedis2']);
$tenagamedis3 = mysqli_real_escape_string($koneksi, $_POST['tenagamedis3']);
$tenagafarmasi = mysqli_real_escape_string($koneksi, $_POST['tenagafarmasi']);
$tenagalab = mysqli_real_escape_string($koneksi, $_POST['tenagalab']);
$tgl = date('Y-m-d');	
$umurtahun = $_POST['umurtahun'];
$umurbulan = $_POST['umurbulan'];
// $asuransi = $_POST['asuransi']; // diganti baris 54
$nip = $_SESSION['username'];

//jika pasien di rujuk internal
if($statuspulang == 5){
	$jam = date("G:i:s");
	$tanggalsimpan = date("Y-m-d");
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	$str_registrasi_lagi = "INSERT INTO `$tbpasienrj`(`TanggalRegistrasi`,`NoRegistrasi`, `NoIndex`, `NoCM`, `NamaPasien`, `JenisKelamin`, `UmurTahun`, `UmurBulan`, `UmurHari`, `JenisKunjungan`, `AsalPasien`, `StatusPasien`, `PoliPertama`, `Asuransi`, `StatusKunjungan`, `WaktuKunjungan`, `Tarif`, `StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`, `kdprovider`, `nokartu`, `kdpoli`) 
	VALUES ('$tanggal_registrasi','$nopemeriksaan','$noindex','$nocm','$namapasien','$kelaminpasien','$umurtahunpasien', '$umurbulanpasien', '$umurharipasien', '$jeniskunjungan', '$asalpasien', '$statuspasien', '$rujukinternal','$asuransi','$statuskunjungan','$waktukunjungan','0','Antri','Rujuk Internal','$namapegawai','$kdprovider','$nokartu','$kodepoli')";
	mysqli_query($koneksi,$str_registrasi_lagi);
	
	$str_registrasi_lagi_2 = "INSERT INTO `tbpasienrj`(`TanggalRegistrasi`, `NoRegistrasi`, `NoIndex`, `NoCM`, `NamaPasien`, `WaktuKunjungan`,`StatusBuku`) 
	VALUES ('$tanggal_registrasi','$nopemeriksaan','$noindex','$nocm','$namapasien','$waktukunjungan','c')";
	mysqli_query($koneksi,$str_registrasi_lagi_2);	

	//edit tbrujukinternal
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `PoliRujukan` = '$rujukinternal',`PoliRujukan2` = '$rujukinternal2',`PoliRujukan3` = '$rujukinternal3',`PoliRujukan4` = '$rujukinternal4',`PoliRujukan5` = '$rujukinternal5' WHERE `NoRujukan` = '$nopemeriksaan'");		
}

// Bridging bpjs
$nokartu = $_POST['nokartubpjs'];
$kdpoli= $_POST['poli_bpjs'];
$keluhan= $_POST['anamnesa'];
$kdSadar=$_POST['kesadaran'];

if($_POST['therapy'] != null){
	$terapi= implode(',',$_POST['therapy']);//$_POST['catatanterapi']; 
}

$kdProviderRujukLanjut= $_POST['polilanjut'];
$kdStatusPulang=$_POST['statuspulang'];
$tglPulang = date('d-m-Y', strtotime($datapasienrj['TanggalRegistrasi']));
$kdDokter=$_POST['tenagamedis1'];
$kddiagnosabpjs = $_POST['kodediagnosabpjs'];
$kelompok = $_POST['kelompokdiagnosa'];
$kdtacc = -1; //1$_POST['kodetacc']
$alasantacc = null;//$_POST['alasantacc'];
$kondisi_rujukan = $_POST['kondisi'];

// $tglEstRujuk = tgl_format($datapasienrj['TanggalRegistrasi']);
$tglEstRujuk = tgl_format2($_POST['tglfaskes']);
$kdppk = $datapasienrj['kdprovider'];
$kdsubspesialis_spesial = $_POST['sub-spesialis'];
$kdsarana = $_POST['sarana'];
if($kdsarana == 0){
	$kdsarana = null;
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
$kdPoliRujukInternal=$_POST['poliinternal'];
$kdPoliRujukLanjut=$_POST['polilanjut2'];

// vital sign
$sistole = $_POST['sistole'];
$diastole = $_POST['diastole'];
$suhutubuh = $_POST['suhutubuh'];
$beratbadan = $_POST['beratbadan'];
$tinggibadan = $_POST['tinggibadan'];
$resprate = $_POST['resprate'];
$heartrate = $_POST['heartrate'];
$lingkarperut = $_POST['lingkarperut'];
$imt_pasien = $_POST['imt'];

// cek jika kosong, insert
if($pelayanan != 'POLI LABORATORIUM'){
	$cekvs = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdVitalSign` FROM $tbvitalsign WHERE `IdPasienrj`='$datapasienrj[IdPasienrj]'"));
	if($cekvs > 0){	
		$str_vs = "UPDATE `$tbvitalsign` SET `Sistole`='$sistole', `Diastole`='$diastole', `SuhuTubuh`='$suhutubuh', `TinggiBadan`='$tinggibadan', 
		`BeratBadan`='$beratbadan', `HeartRate`='$heartrate', `RespiratoryRate`='$resprate', `LingkarPerut`='$lingkarperut', `IMT`='$imt_pasien' WHERE `IdPasienrj`='$idpasienrj'";
	}else{
		$str_vs = "INSERT INTO `$tbvitalsign`(`IdPasien`, `IdPasienrj`, `Sistole`, `Diastole`, `SuhuTubuh`, `TinggiBadan`, 
		`BeratBadan`, `HeartRate`, `RespiratoryRate`, `LingkarPerut`, `IMT`) 
		VALUES ('$idpasien','$idpasienrj','$sistole','$diastole','$suhutubuh','$tinggibadan',
		'$beratbadan','$heartrate','$resprate','$lingkarperut','$imt_pasien')";
	}
	mysqli_query($koneksi, $str_vs);
}


if($pelayanan == 'POLI UMUM'){
	$cekumum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `$tbpoliumum` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cekumum['NoPemeriksaan'] != ""){
		$str = "UPDATE `$tbpoliumum` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`KeadaanUmum`='$keadaanumum',`StatusGizi`='$statusgizi',`PemeriksaanPenunjang`='$pemeriksaanpenunjangobj',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
		`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
		`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',
		`StatusPulang`='$statuspulang',`RiwayatPenyakitSekarang`='$riwayatpenyakitsekarang',`RiwayatPenyakitDulu`='$riwayatpenyakitdulu',
		`RiwayatPenyakitKeluarga`='$riwayatpenyakitkeluarga',`FaktorResikoLainnya`='$faktorresikolainnya',`RiwayatAlergiMakanan`='$riwayatalergimakanan',`RiwayatAlergiObat`='$riwayatalergiobat',
		`RencanaPengelolaan`='$rencanapengelolaan',`Prognosis`='$prognosis',`InformasiEso`='$informasieso',`Edukasi`='$edukasi',
		`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' 
		WHERE `NoPemeriksaan` = '$nopemeriksaan'  AND `NoCM`='$nocm'";
	}else{
		$str = "INSERT INTO `$tbpoliumum`(`IdPasienrj`, `TanggalPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
		`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`KeadaanUmum`,`StatusGizi`,`PemeriksaanPenunjang`,
		`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
		`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
		`RiwayatPenyakitSekarang`,`RiwayatPenyakitDulu`,`RiwayatPenyakitKeluarga`,`FaktorResikoLainnya`,`RiwayatAlergiMakanan`,`RiwayatAlergiObat`,
		`RencanaPengelolaan`,`Prognosis`,`InformasiEso`,`Edukasi`,
		`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`)
		VALUES ('$idpasienrj','$tanggal_time','$nopemeriksaan','$noindex','$nocm','$namapasien',
		'$anamnesa','$anjuran','$pemeriksaanhasillab','$keadaanumum','$statusgizi','$pemeriksaanpenunjangobj',
		'$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
		'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
		'$jsondiagnosa','$nopemeriksaan','$statuspulang','$riwayatpenyakitsekarang','$riwayatpenyakitdulu','$riwayatpenyakitkeluarga','$faktorresikolainnya',
		'$riwayatalergimakanan','$riwayatalergiobat','$rencanapengelolaan','$prognosis','$informasieso','$edukasi','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	}
	$query = mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if($pelayanan == 'POLI ANAK'){
	$cekanak = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpolianak` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cekanak['NoPemeriksaan'] != ""){
		$str = "UPDATE `tbpolianak` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanPenunjang`='$pemeriksaanpenunjang',
		`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',
		`Telinga`='$telinga',`Mulut`='$mulut',`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',
		`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',
		`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',
		`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan'  AND `NoCM`='$nocm'";
	}else{
		$str = "INSERT INTO `tbpolianak`(`IdPasienrj`,`TanggalPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
		`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,
		`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,
		`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
		VALUES ('$idpasienrj','$tanggal_time','$nopemeriksaan','$noindex','$nocm','$namapasien',
		'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut','$leher','$dada',
		'$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
		'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	}
	// echo $str;
	// die();
	$query = mysqli_query($koneksi, $str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if($pelayanan == 'POLI BERSALIN'){
	$str = "UPDATE `tbpolibersalin` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanPenunjang`='$pemeriksaanpenunjang',
	`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
	`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',
	`ExAtas`='$exatas',`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`Terapi`='$terapi',
	`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',
	`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	$query=mysqli_query($koneksi,$str);
	
	// insert tbpolibersalin
	if($usiakehamilan != '' OR $penolongpersalinan != ''){
		$str_rwtbersalin ="UPDATE `tbpolibersalinriwayat` SET `UsiaKehamilan`='$usiakehamilan',`PenolongPersalinan`='$penolongpersalinan',
		`KeadaanLahir`='$keadaanlahir', `CaraLahir`='$caralahir', `JenisKelamin`='$jeniskelaminbayi', `BeratBadan`='$bb_bayi',
		`PanjangBadan`='$pb_bayi', `PlasentaLahir`='$plasenta', `Nifas`='$nifas', `Keterangan`='$keterangan_rwt' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
		mysqli_query($koneksi,$str_rwtbersalin);
	}
	
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if($pelayanan == 'POLI GIGI'){	
	// poli gigi
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

	$cekgigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpoligigi` WHERE `IdPasienrj`='$idpasienrj'"));
	if($cekgigi['IdPasienrj'] != ""){
		$str = "UPDATE `$tbpoligigi` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`Kesadaran`='$kesadaran',`RencanaTerapi`='$rencanaterapi',`InformedConsent`='$informedconsent',
		`Tindakan`='$tindakangigi',`Palpasi`='$palpasi',`SuhuKulit`='$suhukulit',`Bibir`='$bibirgigi',`KelenjarLinfe`='$kelenjarlinfe',
		`Tmj`='$tmj',`Trismus`='$trismus',`KeteranganTambahanEkstra`='$kettambahanekstra',`KariesGigi`='$kariesgigi',`Sondase`='$sondase',
		`Perkusi`='$perkusi',`Tekanan`='$tekananintraoral',`Goyang`='$goyangintraoral',`WarnaGusi`='$warnagusi',`Konstensi`='$konstensi',
		`Bengkak`='$bengkakgigi',`KeteranganTambahanIntra`='$kettambahanintra',`TindakLanjut1`='$tindaklanjut1',`TindakLanjut2`='$tindaklanjut2',
		`KunjunganUlang`='$kunjunganulang',`StatusKunjungan`='$statuskunjungan',`TindakLanjutRujuk`='$tindaklanjutRujuk',`KunjunganGigi`='$kunjungangigi',
		`TerimaRujukan`='$terimarujukan',`Terapi`='$jsontherapy',`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',
		`RiwayatPenyakitSekarang`='$riwayatpenyakitsekarang',`RiwayatPenyakitDulu`='$riwayatpenyakitdulu',
		`RiwayatPenyakitKeluarga`='$riwayatpenyakitkeluarga',`FaktorResikoLainnya`='$faktorresikolainnya',`RiwayatAlergiMakanan`='$riwayatalergimakanan',`RiwayatAlergiObat`='$riwayatalergiobat',
		`RencanaPengelolaan`='$rencanapengelolaan',`Prognosis`='$prognosis',`InformasiEso`='$informasieso',`Edukasi`='$edukasi',
		`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',
		`TanggalEdit`='$tgl' WHERE `IdPasienrj` = '$idpasienrj'";
		// echo $str;
		// die();
		$query = mysqli_query($koneksi, $str);
	}else{	
		mysqli_query($koneksi, "DELETE FROM `$tbpoligigi` WHERE `IdPasienrj`='$idpasienrj'");
		$str = "INSERT INTO `$tbpoligigi`(`IdPasienrj`,`TanggalPeriksa`,`NoPemeriksaan`,`NoIndex`, 
		`NoCM`,`NamaPasien`,`JenisKelamin`,`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,
		`Kesadaran`,`RencanaTerapi`,`InformedConsent`,`Tindakan`,
		`Palpasi`,`SuhuKulit`,`Bibir`,`KelenjarLinfe`,`Tmj`,`Trismus`,`KeteranganTambahanEkstra`,
		`KariesGigi`,`Sondase`,`Perkusi`,`Tekanan`,`Goyang`,`WarnaGusi`,`Konstensi`,`Bengkak`,`KeteranganTambahanIntra`,
		`TindakLanjut1`,`TindakLanjut2`,`KunjunganUlang`,`StatusKunjungan`,`TindakLanjutRujuk`,`KunjunganGigi`,`TerimaRujukan`,
		`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
		`RiwayatPenyakitSekarang`,`RiwayatPenyakitDulu`,`RiwayatPenyakitKeluarga`,`FaktorResikoLainnya`,`RiwayatAlergiMakanan`,`RiwayatAlergiObat`,
		`RencanaPengelolaan`,`Prognosis`,`InformasiEso`,`Edukasi`,
		`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
		VALUES ('$idpasienrj','$tanggal_time','$nopemeriksaan','$noindex','$nocm',
		'$namapasien','$kelaminpasien','$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang',
		'$kesadaran','$rencanaterapi','$informedconsent','$tindakangigi',
		'$palpasi','$suhukulit','$bibirgigi','$kelenjarlinfe','$tmj','$trismus','$kettambahanekstra',
		'$kariesgigi','$sondase','$perkusi','$tekananintraoral','$goyangintraoral','$warnagusi','$konstensi','$bengkakgigi','$kettambahanintra',
		'$tindaklanjut1','$tindaklanjut2','$kunjunganulang','$statuskunjungan','$tindaklanjutRujuk','$kunjungangigi','$terimarujukan','$jsontherapy',
		'$jsondiagnosa','$nopemeriksaan','$statuspulang','$riwayatpenyakitsekarang','$riwayatpenyakitdulu','$riwayatpenyakitkeluarga','$faktorresikolainnya',
		'$riwayatalergimakanan','$riwayatalergiobat','$rencanapengelolaan','$prognosis','$informasieso','$edukasi','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
		// echo $str;
		// die();
		$query = mysqli_query($koneksi, $str);	
	}		
	
	// simpan simbol odontogram
	$nogigi_odontogram = $_POST['nogigi_odontogram'];
	$nogigi_odontogram_keterangan = $_POST['nogigi_odontogram_keterangan'];
	foreach($nogigi_odontogram as $nogigi => $val_odon){
		$ng_keterangan = $nogigi_odontogram_keterangan[$nogigi];
		$ceksimbol = mysqli_query($koneksi,"SELECT * FROM tbpoligigi_odontogram WHERE IdPasien = '$idpasien' AND NoGigi = '$nogigi'");
		if(mysqli_num_rows($ceksimbol) == 0){
			mysqli_query($koneksi, "INSERT INTO `tbpoligigi_odontogram`(`IdPasien`, `NoGigi`, `IdOdontogram`, `Keterangan`) VALUES ('$idpasien','$nogigi','$val_odon','$ng_keterangan')");
		}else{//update
			$IdTbPoligigiOdontogram = mysqli_fetch_assoc($ceksimbol)['IdTbPoligigiOdontogram'];
			mysqli_query($koneksi, "UPDATE `tbpoligigi_odontogram` SET `NoGigi`='$nogigi',`Keterangan`='$ng_keterangan',`IdOdontogram`='$val_odon' WHERE `IdTbPoligigiOdontogram`='$IdTbPoligigiOdontogram'");
		}
	}
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
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
	
	$cekgizi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpoligizi` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cekgizi['NoPemeriksaan'] != ""){
		$str = "UPDATE `tbpoligizi` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',
		`DetakNadi`='$heartrate',`RR`='$resprate',`Kesadaran`='$kesadaran',
		`TanggalPenimbangan`='$tanggalpenimbangan',`BeratBadanLahir`='$bblahir',`BBI`='$bbi',`PanjangBadanLahir`='$pblahir',`Imt`='$imt',`Ntob`='$ntob',
		`Bbu`='$bbu',`Tbu`='$tbu',`Imtu`='$imtu',`Bbtb`='$bbtb',`Bgm`='$bgm',`StatusGizi`='$statusgizi',`TindakanGizi`='$tindakangizi',`Asi`='$asi',
		`Imd`='$imd',`LilaLika`='$lilalika',`UsiaKehamilan`='$usiakehamilan',`LabHb`='$labhb',`RiwayatGizi`='$riwayatgizi',`DiagnosaGizi`='$diagnosagizi',`TerapiDiet`='$terapidiet',
		`MakanPagi`='$makanpagi',`MakanSiang`='$makansiang',`MakanMalam`='$makanmalam',`SeringNgemil`='$seringngemil',`BerapaKali`='$jikangemil',`AlergiMakanan`='$alergimakanan',
		`MakananPokok`='$makananpokok',`LaukHewani`='$laukhewani',`LaukNabati`='$lauknabati',`Sayuran`='$sayur',`Buahan`='$buah',
		`Munuman`='$minuman',`Energi`='$energi',`Protein`='$protein',`Lemak`='$lemak',`Karbohidrat`='$karbohidrat',
		`MakanPagiRecall`='$makanpagirecall',`SnackPagiRecall`='$snackpagirecall',`MakanSiangRecall`='$makansiangrecall',`SnackSoreRecall`='$snacksorerecall',
		`MakanSoreRecall`='$makansoremalamrecall',`SnackMalamRecall`='$snackmalamrecall',`EnergiRecall`='$energirecall',
		`ProteinRecall`='$proteinrecall',`LemakRecall`='$lemakrecall',`KarbohidratRecall`='$karbohidratrecall',
		`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',
		`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{	
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
	}	
	// echo $str;
	// die();
	
	$query = mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");

}else if($pelayanan == 'POLI IMUNISASI'){	
	$alergi_imunisasi = $_POST['alergi_imunisasi'];
	$riwayat_imunisasi = implode(",",$_POST['riwayat_imunisasi']);
	$jenis_imunisasi = implode(",",$_POST['jenis_imunisasi']);
	$kipi = implode(",",$_POST['kipi']);
	$kipilainnya = $_POST['kipilainnya'];
	$tgl_imun_selanjutnya = $_POST['tgl_imun_selanjutnya'];
	$ads_005 = $_POST['ads_005'];
	$ads_05 = $_POST['ads_05'];
	$ads_5 = $_POST['ads_5'];
	
	$cekimunisasi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpoliimunisasi` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cekimunisasi['NoPemeriksaan'] != ""){
		$str = "UPDATE `tbpoliimunisasi` SET `JenisKelamin`='$kelaminpasien', `Anamnesa`='$anamnesa',`AlergiImunisasi`='$alergi_imunisasi',`Anjuran`='$anjuran',
		`PemeriksaanHasilLab`='$pemeriksaanhasillab',`Sistole`='$sistole',`Diastole`='$diastole',
		`SuhuTubuh`='$suhutubuh',`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`ImunisasiSekarang`='$jenis_imunisasi',
		`TglImunSelanjutnya`='$tgl_imun_selanjutnya',`Ads005`='$ads_005',`Ads05`='$ads_05',`Ads5`='$ads_5',`Terapi`='$terapi',`Kesadaran`='$kesadaran',`StatusPulang`='$statuspulang',
		`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',
		`TanggalEdit`='$tgl' WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'";
		// echo $str;
		// die();
	}else{
		$str = "INSERT INTO `tbpoliimunisasi`(`TanggalPeriksa`,`JamPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
		`Anamnesa`,`AlergiImunisasi`,`Anjuran`,`PemeriksaanHasilLab`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,`DetakNadi`, 
		`RR`,`RiwayatImunisasi`,`ImunisasiSekarang`,`Kipi`,`KipiLainnya`,`TglImunSelanjutnya`,`Ads005`,`Ads05`,`Ads5`,
		`Terapi`,`Diagnosa`,`Kesadaran`,`StatusPulang`,`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
		VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien','$kelaminpasien',
		'$anamnesa','$alergi_imunisasi','$anjuran','$pemeriksaanhasillab','$sistole','$diastole','$suhutubuh','$beratbadan','$tinggibadan','$heartrate',
		'$resprate','$riwayat_imunisasi','$jenis_imunisasi','$kipi','$kipilainnya','$tgl_imun_selanjutnya','$ads_005','$ads_05','$ads_5',
		'$jsontherapy','$jsondiagnosa','$kesadaran','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	}
	
	$query = mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");

}else if($pelayanan == 'POLI ISOLASI'){	
	$cekisolasi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpoliisolasi` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cekisolasi['NoPemeriksaan'] != ""){
		$str = "UPDATE `tbpoliisolasi` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`PemeriksaanPenunjang`='$pemeriksaanpenunjang',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
		`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',
		`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
		`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
		`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',
		`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',
		`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{
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
	}
	
	$query = mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");	

}else if($pelayanan == 'POLI KB'){	
	$str_cek_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpolikb` WHERE NoCM = '$nocm'"));
	if ($str_cek_kb['NoPemeriksaan'] != "") {
		$str = "UPDATE `tbpolikb` SET `TanggalHaidTerakhir`='$tgl_haid_terakhir',`AnakHidup`='$anak_hidup',`UmurTerkcil`='$umur_terkecil',`StatusKB`='$status_kb',
		`CaraKBTerakhir`='$kb_terakhir',`Hamil`='$hamil_diduga',`Menyusui`='$menyusui',`AlKonDipilih`='$metode_alkon',`Gravida`='$gravida',`Partus`='$partus',`Abortus`='$abortus',
		`GantiCara`='$ganti_cara',`AseptorBaru`='$aseptor_baru',`AseptorAktif`='$aseptor_aktif',`EfekSampingKB`='$efek_samping_kb',`KomplikasiKB`='$komplikasi_kb',
		`KegagalanKB`='$kegagalan_kb',`RiwayatPenyakit`='$riwayat_penyakit_kb',`PemeriksaanDalam`='$pemeriksaan_dalam',`PemeriksaanTambahan`='$pemeriksaan_tambahan',
		`AlkonBolehDigunakan`='$alkon_boleh',`Terapi`='$jsontherapy',`Diagnosa`='$jsondiagnosa',`NoResep`='$nopemeriksaan',`StatusPulang`='$statuspulang',
		`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{
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
	}	
	
	$query = mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
	// kunj.ulang
	$str2 = "UPDATE `tbpolikb_kunjunganulang` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanPenunjang`='$pemeriksaanpenunjang',
	`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',
	`DetakNadi`='$heartrate',`RR`='$resprate',`Kesadaran`='$kesadaran',`TanggalHaidTerakhir`='$tgl_ha',
	`Kegagalan`='$kegagalan_kb',`KomplikasiBerat`='$komplikasi_berat',`InformedConsent`='$ic',`GantiCara`='$ganticara',
	`TanggalGanti`='$tgl_ga',`PencabutanKontrasepsi`='$pencabutan',`TanggalPencabutan`='$tgl_cb',
	`TanggalKembali`='$tgl_kbl',`StatusPulang`='$statuspulang',`NamaPegawaiSimpan`='$tenagamedisbpjs' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	mysqli_query($koneksi, $str2);
	
	
}else if($pelayanan == 'POLI KIA'){	
	$str = "UPDATE `$tbpolikia` SET `NoKohort`='$nokohort_kia',`NoResti`='$noresti_kia',`StatusPemeriksaanKia`='$sts_pemeriksaan_kia',`Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
	`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',
	`Kesadaran`='$kesadaran',`UsiaKehamilan`='$usiakehamilan_kia',`Trimester`='$trimester_kia',`Tfu`='$tfu_kia',`Lila`='$lila_kia',`StatusGizi`='$statusgizi_kia',
	`RefleksPatella`='$reflekspatella_kia',`RiwayatSc`='$riwayatsc_kia',`TT`='$tt_kia',`FE`='$fe_kia',`GolonganDarah`='$goldarah_kia',
	`KunjunganKehamilan`='$kunjungan_kehamilan',`DeteksiResiko`='$deteksi_resiko',`FaktorResiko`='$faktorresiko_kia',`FaktorResikoDesc`='$faktorresikodesc_kia',
	`KomplikasiDitanganiIbuHamil`='$komplikasi_kia',`JikaRujuk`='$rujuk_komplikasi',`Gravida`='$gravida',`Partus`='$partus',`Abortus`='$abortus',`Hpht`='$hpht_kia',
	`Djj`='$djj_kia',`KepThd`='$kepalathd_kia',`Tbj`='$tbj_kia',`JumlahJanin`='$jumlahjanin_kia',`Presentasi`='$presentasi_kia',`P4K`='$p4k',`InjeksiTT`='$injeksitt_kia',
	`CatatBukuKia`='$buku_kia',`FeTab`='$fetab_kia',`K1Hb`='$k1hb_kia',`PPTest`='$pptest_kia',`ProteinUrin`='$proturine_kia',`GulaDarah`='$guladarah_kia',
	`GulaDarahSewaktu`='$gds_kia',`K4Hb`='$k4hb_kia',`Sifilis`='$sifilis_kia',`Malaria`='$malaria_kia',`AsamUrat`='$asamurat_kia',`Hbsag`='$hbsag_kia',`Hiv`='$hiv_kia',
	`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',
	`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	
	$query=mysqli_query($koneksi,$str);	
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if($pelayanan == 'POLI LANSIA'){
	$kms = $_POST['kms'];
	$kemandirian = $_POST['kemandirian'];
	$emosional = $_POST['emosional'];
	$statusimt = $_POST['statusimt'];
	$tekanandarahlansia = $_POST['tekanandarahlansia'];
	$faktorresiko = $_POST['faktorresiko'];
	$riwayatpenyakit = implode(",",$_POST['riwayat_penyakit']);
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
	
	$ceklansia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `$tbpolilansia` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($ceklansia['NoPemeriksaan'] != ""){
		$str ="UPDATE `$tbpolilansia` SET `JenisKelamin`='$kelaminpasien',`UmurTahun`='$umurtahunpasien',`Anamnesa`='$anamnesa',
		`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',`PemeriksaanPenunjang`='$pemeriksaanpenunjang',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
		`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',
		`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
		`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
		`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`MempunyaiKms`='$kms',`Kemandirian`='$kemandirian',
		`GangguanEmosional`='$emosional',`StatusImt`='$statusimt',`StatusTekananDarah`='$tekanandarahlansia',`FaktorResiko`='$faktorresiko',
		`RiwayatPenyakit`='$riwayatpenyakit',`Kelainan`='$kelainan',`Pengobatan`='$pengobatan',`Konseling`='$konseling',`Penyuluhan`='$penyuluhan',
		`Pemberdayaan`='$pemberdayaan',`Panti`='$panti',`KunjunganRumah`='$kunjrumah',`Skrining`='$skrining',`Adl`='$adl',`ResikoJatuh`='$resikojatuh',`Gds`='$gds',
		`Mme`='$mme',`Mna`='$mna',`GdpLab`='$gdp_lab',`GdsLab`='$gds_lab ',`KolesLab`='$koles_lab',`AuLab`='$au_lab',`HbLab`='$hb_lab',
		`ProtLab`='$prot_lab',`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',
		`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl'
		WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{
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
	}
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
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
	$tanggalkunjulang = $tgl[2]."-".$tgl[1]."-".$tgl[0];	
	$rujuk_klasifikasi_mtbs = $_POST['rujukan_klasifikasi_mtbs'];
	
	
	$cekpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoPemeriksaan) As Jml FROM `$tbpolimtbs` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if ($cekpasien['Jml'] > 0){
		$str = "UPDATE `$tbpolimtbs` SET `JenisKelamin`='$kelaminpasien',`UmurTahun`='$umurtahunpasien',`Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',
		`DetakNadi`='$heartrate',`RR`='$resprate',
		`Kunjungan`='$kunjungan_mtbs',`PemeriksaanUmum`='$prk_umum_mtbs',`KlasifikasiUmum`='$kls_umum_mtbs',`TindakanUmum`='$tind_umum_mtbs',`PemeriksaanPneumonia`='$prk_pneu_mtbs',
		`HariPneumonia`='$bl_pneu_mtbs',`NapasPneumonia`='$nc_pneu_mtbs',`KlasifikasiPneumonia`='$kls_pneu_mtbs',`TindakanPneumonia`='$tind_pneu_mtbs',`PemeriksaanDiare`='$prk_diare_mtbs',
		`HariDiare`='$bl_diare_mtbs',`KeadaanUmum`='$ku_diare_mtbs',`BeriAnakMinum`='$bam_diare_mtbs',`CubitPerut`='$ckp_diare_mtbs',`KlasifikasiDiare`='$kls_diare_mtbs',`TindakanDiare`='$tind_diare_mtbs',
		`PemeriksaanDemam`='$prk_malaria_mtbs',`DeteksiResiko`='$dr_malaria_mtbs',`HariDemam`='$bl_malaria_mtbs',`TandaCampak`='$tc_malaria_mtbs',`KlasifikasiDemam`='$kls_malaria_mtbs',`TindakanDemam`='$tind_malaria_mtbs',
		`PemeriksaanCampak`='$prk_campak_mtbs',`KlasifikasiCampak`='$kls_campak_mtbs',`TindakanCampak`='$tind_campak_mtbs',
		`PemeriksaanDBD`='$prk_dbd_mtbs',`KlasifikasiDBD`='$kls_dbd_mtbs',`TindakanDBD`='$tind_dbd_mtbs',
		`PemeriksaanTelinga`='$prk_telinga_mtbs',`HariTelinga`='$bl_telinga_mtbs',`KlasifikasiTelinga`='$kls_telinga_mtbs',`TindakanTelinga`='$tind_telinga_mtbs',
		`PemeriksaanGizi`='$prk_gizi_mtbs',`BBGizi`='$bb_mtbs',`BBGiziJelaskan`='$bb_jelaskan_mtbs',`LilaGizi`='$lila_mtbs',`LilaGiziJelaskan`='$lila_jelaskan_mtbs',`TandaBahayaGizi`='$bahaya_umum_mtbs',`KlasifikasiBeratGizi`='$klasifikasi_berat_mtbs',`MasalahAsiGizi`='$asi_mtbs',`KlasifikasiGizi`='$gizi_klasifikasi_mtbs',`TindakanGizi`='$gizi_tindakan_mtbs',
		`PemeriksaanAnemia`='$anemia_mtbs',`KlasifikasiAnemia`='$anemia_klasifikasi_mtbs',`TindakanAnemia`='$anemia_tindakan_mtbs',
		`PemeriksaanHiv`='$prk_hiv_mtbs',`KlasifikasiHiv`='$hiv_klasifikasi_mtbs',`TindakanHiv`='$tind_hiv_mtbs',
		`ImunisasiDiberikan`='$prk_imunisasi_sekarang_mtbs',`ImunisasiDibutuhkan`='$prk_imunisasi_sudah_mtbs',`KlasifikasiImunisasi`='$imunisasi_klasifikasi_mtbs',`TindakanImunisasi`='$imunisasi_tindakan_mtbs',
		`PemeriksaanVitA`='$prk_vita_mtbs',`MasalahVitA`='$keluhanlain_mtbs',
		`IbuMenyusui`='$makan_mtbs_1',`BerapaKaliMenyusu`='$makan_mtbs_2',`AnakMenyusuMalam`='$makan_mtbs_3',`AnakDapatMakananLain`='$makan_mtbs_4',
		`MakananApa`='$makan_mtbs_5',`BerapaKaliMakan`='$makan_mtbs_6',`AlatDigunakan`='$makan_mtbs_7',`BerapaBanyakMakan`='$makan_mtbs_8',
		`AnakDapatMakanSendiri`='$makan_mtbs_9',`SiapaMemberiMakan`='$makan_mtbs_10',`PerubahanMakan`='$makan_mtbs_11',`BagaimanaMakan`='$makan_mtbs_12',
		`TempatRujuk`='$tempat_rujuk',`TanggalKunjunganUlang`='$tanggalkunjulang',`KlasifikasiRujuk`='$rujuk_klasifikasi_mtbs',
		`Kesadaran`='$kesadaran' WHERE NoPemeriksaan = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{
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
	}		
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");

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
	
	$cekptm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpolipanduptm` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cekptm['NoPemeriksaan'] != ""){
		$str = "UPDATE `tbpolipanduptm` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`PemeriksaanPenunjang`='$pemeriksaanpenunjang',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
		`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',
		`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
		`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
		`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',
		`RiwayatPtmKeluarga`='$riwayatptmkeluarga',`RiwayatPtmPribadi`='$riwayatptmpribadi',`MataLokasi`='$matalokasi',`MataKatarak`='$matakatarak',
		`MataRefraksi`='$matarefraksi',`TelingaLokasi`='$telingalokasi',`TelingaTuli`='$telingatuli',`TelingaCongek`='$telingacongek',
		`TelingaSerumen`='$telingaserumen',`Iva`='$ptmiva',`Sadanis`='$ptmsadanis',
		`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',
		`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',
		`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{
		$str = "INSERT INTO `tbpolipanduptm`(`TanggalPeriksa`, `JamPeriksa`, `NoPemeriksaan`, `NoIndex`, `NoCM`, `NamaPasien`,
		`Anamnesa`,`Anjuran`,`PemeriksaanHasilLab`,`PemeriksaanPenunjang`,`Sistole`,`Diastole`,`SuhuTubuh`,`BeratBadan`,`TinggiBadan`,
		`DetakNadi`,`RR`,`LingkarPerut`,`Imt`,`Kesadaran`,`Kepala`,`Mata`,`Hidung`,`Telinga`,`Mulut`,`Leher`,`Dada`,`Punggung`,`CP`,`Perut`,
		`HL`,`Kelamin`,`ExAtas`,`ExBawah`,`Lokalis`,`Effloresensi`,`Terapi`,`Diagnosa`,`NoResep`,`StatusPulang`,
		`RujukInternal`,`RujukLanjut`,`NamaPegawaiSimpan`) 
		VALUES ('$tanggal_registrasi','$jamperiksa','$nopemeriksaan','$noindex','$nocm','$namapasien',
		'$anamnesa','$anjuran','$pemeriksaanhasillab','$pemeriksaanpenunjang','$sistole','$diastole','$suhutubuh','$beratbadan',
		'$tinggibadan','$heartrate','$resprate','$lingkarperut','$imt_pasien','$kesadaran','$kepala','$mata','$hidung','$telinga','$mulut',
		'$leher','$dada','$punggung','$cp','$perut','$hl','$kelamin','$exatas','$exbawah','$lokalis','$effloresensi','$jsontherapy',
		'$jsondiagnosa','$nopemeriksaan','$statuspulang','$rujukinternal','$rujuklanjut','$tenagamedisbpjs')";
	}
	
	$query=mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");

}else if($pelayanan == 'POLI PDP'){
	$cekumum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpolipdp` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cekumum['NoPemeriksaan'] != ""){
		$str = "UPDATE `tbpolipdp` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`KeadaanUmum`='$keadaanumum',`StatusGizi`='$statusgizi',`PemeriksaanPenunjang`='$pemeriksaanpenunjangobj',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
		`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',
		`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
		`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
		`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',
		`StatusPulang`='$statuspulang',`RiwayatPenyakitSekarang`='$riwayatpenyakitsekarang',`RiwayatPenyakitDulu`='$riwayatpenyakitdulu',
		`RiwayatPenyakitKeluarga`='$riwayatpenyakitkeluarga',`FaktorResikoLainnya`='$faktorresikolainnya',`RiwayatAlergiMakanan`='$riwayatalergimakanan',`RiwayatAlergiObat`='$riwayatalergiobat',
		`RencanaPengelolaan`='$rencanapengelolaan',`Prognosis`='$prognosis',`InformasiEso`='$informasieso',`Edukasi`='$edukasi',
		`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' 
		WHERE `NoPemeriksaan` = '$nopemeriksaan'  AND `NoCM`='$nocm'";
	}else{
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
	}
	$query = mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");

}else if($pelayanan == 'POLI PROLANIS'){
	// Hasil Laboratorium
	$gdp_lab = $_POST['gdp_lab'];
	$gds_lab = $_POST['gds_lab'];
	$koles_lab = $_POST['koles_lab'];
	$au_lab = $_POST['au_lab'];
	$hb_lab = $_POST['hb_lab'];
	$prot_lab = $_POST['prot_lab'];	
	
	$ceklansia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpoliprolanis` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($ceklansia['NoPemeriksaan'] != ""){
		$str ="UPDATE `tbpoliprolanis` SET `JenisKelamin`='$kelaminpasien',`UmurTahun`='$umurtahunpasien',`Anamnesa`='$anamnesa',
		`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',`PemeriksaanPenunjang`='$pemeriksaanpenunjang',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
		`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',
		`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
		`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
		`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`GdpLab`='$gdp_lab',`GdsLab`='$gds_lab ',`KolesLab`='$koles_lab',`AuLab`='$au_lab',`HbLab`='$hb_lab',
		`ProtLab`='$prot_lab',`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',
		`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl'
		WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{
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
	}
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	

}else if($pelayanan == 'POLI SKD'){
	$ataspermintaan = $_POST['ataspermintaan'];
	$dengansurat = $_POST['dengansurat'];
	$tujuankir = $_POST['tujuankir'];
	$tujuankirlainnya = $_POST['tujuankirlainnya'];
	$pemeriksaanlab_skd = $_POST['pemeriksaanlab_skd'];
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
	
	$pemeriksaanlain_skd =  implode(",",$_POST['pemeriksaanlain_skd']);
	$str = "UPDATE `tbpoliskd` SET `NoSurat`='$nomorsurat_skd',`AtasPermintaan`='$ataspermintaan',`DenganSurat`='$dengansurat',`TujuanKir`='$tujuankir',`TujuanKirLainnya`='$tujuankirlainnya',
	`PemeriksaanLab`='$pemeriksaanlab_skd',`PemeriksaanLainnya`='$pemeriksaanlain_skd',`sistole`='$sistole',`diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
	`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`Jantung`='$jantung_skd',`Lympa`='$lympa_skd',
	`Hati`='$hati_skd',`Paru`='$paru_skd',`Saraf`='$saraf_skd',`Kejiwaan`='$kejiwaan_skd',`VisusMataOD`='$visusmata_od_skd',`VisusMataOS`='$visusmata_os_skd',
	`StatusKesehatan`='$statuskesehatan',`Kesadaran`='$kesadaran',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',
	`NamaDokter`='$namadokter_skd',`KeteranganTambahan`='$keterangan_skd',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' WHERE `NoPemeriksaan`='$nopemeriksaan' AND `NoCM`='$nocm'";
	
	$query=mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if ($pelayanan == 'POLI TB DOTS' OR $pelayanan == 'POLI TB'){
	if($kota == "KABUPATEN BANDUNG" OR $kota == "KABUPATEN SUKABUMI"){
		$politb = "POLI TB DOTS";
	}else{
		$politb = "POLI TB";
	}
	$asalrujukan = $_POST['asalrujukan'];
	$riwayatpengobatan = $_POST['riwayatpengobatan'];
	$didugatb = $_POST['didugatb'];
	$totalskoring = $_POST['totalskoring'];
	$tgl_dahak = date('Y-m-d',strtotime($_POST['tgl_dahak']));
	$tgl_mikroskopis = date('Y-m-d',strtotime($_POST['tgl_mikroskopis']));
	$hasil_a = $_POST['hasil_a'];
	$hasil_b = $_POST['hasil_b'];
	$hasil_c = $_POST['hasil_c'];
	$tgl_biakan = date('Y-m-d',strtotime($_POST['tgl_biakan']));
	$hasil_biakan = $_POST['hasil_biakan'];
	$tgl_kepekaan = date('Y-m-d',strtotime($_POST['tgl_kepekaan']));
	$hasil_kepekaan_h = $_POST['hasil_kepekaan_h'];
	$hasil_kepekaan_r = $_POST['hasil_kepekaan_r'];
	$hasil_kepekaan_z = $_POST['hasil_kepekaan_z'];
	$hasil_kepekaan_e = $_POST['hasil_kepekaan_e'];
	$hasil_kepekaan_s = $_POST['hasil_kepekaan_s'];
	$hasil_kepekaan_km = $_POST['hasil_kepekaan_km'];
	$hasil_kepekaan_amk = $_POST['hasil_kepekaan_amk'];
	$hasil_kepekaan_ofx = $_POST['hasil_kepekaan_ofx'];
	$tgl_xpert = date('Y-m-d',strtotime($_POST['tgl_xpert']));
	$hasil_xpert = $_POST['hasil_xpert'];
	$tgl_lpa = date('Y-m-d',strtotime($_POST['tgl_lpa']));
	$hasil_lpa = $_POST['hasil_lpa'];
	$noreg_tb04 = $_POST['noreg_tb04'];
	$hasil_toraks = $_POST['hasil_toraks'];
	$kriteria_mdr = $_POST['kriteria_mdr'];
	$status_hiv = $_POST['status_hiv'];
	$rujukan_tb = $_POST['rujukan_tb'];
	$tgl_pengobatan_tb = date('Y-m-d',strtotime($_POST['tgl_pengobatan_tb']));

	if($kota == 'KOTA TARAKAN'){
		$tbpolitb = 'tbpolitb';
	}else{
		$tbpolitb = 'tbpolitbdots';
	}
	
	$cektb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `$tbpolitb` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cektb['NoPemeriksaan'] != ""){
		$str = "UPDATE `$tbpolitb` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',
		`DetakNadi`='$heartrate',`RR`='$resprate',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',
		`Telinga`='$telinga',`Mulut`='$mulut',`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',
		`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',
		`AsalRujukan`='$asalrujukan',`RiwayatPengobatan`='$riwayatpengobatan',`DidugaTB`='$didugatb',`TotalSkoring`='$totalskoring',
		`TglDahak`='$tgl_dahak',`TglMikoskopis`='$tgl_mikroskopis',`HasilA`='$hasil_a',`HasilB`='$hasil_b',`HasilC`='$hasil_c',
		`TglBiakan`='$tgl_biakan',`HasilBiakan`='$hasil_biakan',`TglKepekaan`='$tgl_kepekaan',`HasilH`='$hasil_kepekaan_h',
		`HasilR`='$hasil_kepekaan_r',`HasilZ`='$hasil_kepekaan_z',`HasilE`='$hasil_kepekaan_e',`HasilS`='$hasil_kepekaan_s',
		`HasilKm`='$hasil_kepekaan_km',`HasilAmk`='$hasil_kepekaan_amk',`HasilOfx`='$hasil_kepekaan_ofx',`TglXpert`='$tgl_xpert',
		`HasilXpert`='$hasil_xpert',`TglLpa`='$tgl_lpa',`HasilLpa`='$hasil_lpa',`NoRegTB04`='$noreg_tb04',`HasilToraks`='$hasil_toraks',
		`KriteriaMdr`='$kriteria_mdr',`StatusHIV`='$status_hiv',`RujukanTB`='$rujukan_tb',`TglPengobatanTB`='$tgl_pengobatan_tb',
		`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',
		`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{
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
	}
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if ($pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){
	// kecelakaan
	$kcl_jam_kecelakaan = $_POST['kcl_jam_kecelakaan'];
	$kcl_jam_berobat = $_POST['kcl_jam_berobat'];
	$kcl_jeniskendaraan = $_POST['kcl_jeniskendaraan'];
	$kcl_nomorpolisi = $_POST['kcl_nomorpolisi'];
	$kcl_lokasikejadian = $_POST['kcl_lokasikejadian'];
	
	$cektindakan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoPemeriksaan` FROM `tbpolitindakan` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
	if($cektindakan['NoPemeriksaan'] != ""){
		$str = "UPDATE `tbpolitindakan` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
		`PemeriksaanPenunjang`='$pemeriksaanpenunjang',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',`BeratBadan`='$beratbadan',
		`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',
		`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',
		`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',`ExBawah`='$exbawah',`StatusLokalis`='$lokalis',
		`Effloresensi`='$effloresensi',`JamKecelakaan`='$kcl_jam_kecelakaan',`JamBerobat`='$kcl_jam_berobat',`JenisKendaraanTerlibat`='$kcl_jeniskendaraan',
		`NomorPolisi`='$kcl_nomorpolisi',`LokasiKejadian`='$kcl_lokasikejadian',`RiwayatPenyakit`='$riwayatpenyakit',
		`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',
		`RujukLanjut`='$rujuklanjut',
		`NamaPegawaiEdit`='$tenagamedisbpjs',`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	}else{
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
	}
	
	$query=mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}else if ($pelayanan == 'POLI LABORATORIUM'){	
	$lab_catin_hiv = $_POST['lab_catin_hiv'];
	$lab_catin_hbsag = $_POST['lab_catin_hbsag'];
	$lab_catin_ppt = $_POST['lab_catin_ppt'];	
	$idtindakan = $_POST['idtindakan'];
	$jenistindakan= $_POST['jenistindakan'];
	$kategoritindakan= $_POST['kategoritindakan'];
	$hasilkdtindakan= $_POST['hasilkdtindakan'];
	$arrykdtindakan = explode(",",$idtindakan);
	foreach($arrykdtindakan as $kd){
		$hasilkdtindakan2 = $hasilkdtindakan[$kd];
		$jenistindakan2 = $jenistindakan[$kd];
		$kelompoktindakan2 = $kategoritindakan[$kd];
		// update hasil tbtindakanpasiendetail
		$str2 = "UPDATE `$tbtindakanpasien` SET `Keterangan`='$hasilkdtindakan2' WHERE `IdPasienrj` = '$idpasienrj' AND IdTindakan = '$kd'";
	
		mysqli_query($koneksi, $str2);
		
		$hasilkdtindakan_ar[] = $hasilkdtindakan2;
		$jenistindakan_ar[] = $jenistindakan2;
		$kategoritindakan_ar[] = $kelompoktindakan2;	
	}
	$hasiltindakan = implode(",",$hasilkdtindakan_ar);
	$jenistindakan = implode(",",$jenistindakan_ar);
	$kategoritindakan = implode(",",$kategoritindakan_ar);

	// delete
	mysqli_query($koneksi, "DELETE FROM `tbpolilaboratorium` WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'");	// AND `IdTindakan` = '$idtindakan'
	$str = "INSERT INTO `tbpolilaboratorium`(`TanggalPeriksa`,`NoPemeriksaan`,`NoIndex`,`NoCM`,`NamaPasien`,`IdTindakan`,`JenisTindakan`,`KelompokTindakan`,`Hasil`,`NilaiRujukan`,`Catin_Hiv`,`Catin_Hbsag`,`Catin_Ppt`,`Kesadaran`,`StatusPulang`,`NamaPegawaiSimpan`) 
	VALUES ('$tanggal_registrasi','$nopemeriksaan','$noindex','$nocm','$namapasien','$idtindakan','$jenistindakan','$kategoritindakan','$hasiltindakan','0','$lab_catin_hiv','$lab_catin_hbsag','$lab_catin_ppt','$kesadaran','$statuspulang','$tenagalab')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	// update polirujukan
	//mysqli_query($koneksi,$strpolirujukan);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}elseif($pelayanan == 'NURSING CENTER'){
	$str = "UPDATE `tbpolinursingcenter` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
	`PemeriksaanPenunjang`='$pemeriksaanpenunjang',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
	`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',
	`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
	`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
	`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',
	`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',
	`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	$query=mysqli_query($koneksi,$str);
		
	//update polirujukan
	//mysqli_query($koneksi,$strpolirujukan);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}elseif($pelayanan == 'POLI INFEKSIUS'){
	$str = "UPDATE `tbpoliinfeksius` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
	`PemeriksaanPenunjang`='$pemeriksaanpenunjang',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
	`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',
	`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
	`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
	`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',
	`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',
	`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	$query=mysqli_query($koneksi,$str);
		
	//update polirujukan
	//mysqli_query($koneksi,$strpolirujukan);	
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
	
}elseif($pelayanan == 'POLI SCREENING'){
	$str = "UPDATE `tbpoliscreening` SET `Anamnesa`='$anamnesa',`Anjuran`='$anjuran',`PemeriksaanHasilLab`='$pemeriksaanhasillab',
	`PemeriksaanPenunjang`='$pemeriksaanpenunjang',`Sistole`='$sistole',`Diastole`='$diastole',`SuhuTubuh`='$suhutubuh',
	`BeratBadan`='$beratbadan',`TinggiBadan`='$tinggibadan',`DetakNadi`='$heartrate',`RR`='$resprate',`LingkarPerut`='$lingkarperut',
	`Imt`='$imt_pasien',`Kesadaran`='$kesadaran',`Kepala`='$kepala',`Mata`='$mata',`Hidung`='$hidung',`Telinga`='$telinga',`Mulut`='$mulut',
	`Leher`='$leher',`Dada`='$dada',`Punggung`='$punggung',`CP`='$cp',`Perut`='$perut',`HL`='$hl',`Kelamin`='$kelamin',`ExAtas`='$exatas',
	`ExBawah`='$exbawah',`Lokalis`='$lokalis',`Effloresensi`='$effloresensi',`Terapi`='$terapi',`Diagnosa`='$jsondiagnosa',
	`StatusPulang`='$statuspulang',`RujukInternal`='$rujukinternal',`RujukLanjut`='$rujuklanjut',`NamaPegawaiEdit`='$tenagamedisbpjs',
	`TanggalEdit`='$tgl' WHERE `NoPemeriksaan` = '$nopemeriksaan' AND `NoCM`='$nocm'";
	
	$query = mysqli_query($koneksi,$str);
	mysqli_query($koneksi, "UPDATE `tbrujukinternal` SET `StatusPemeriksaan` = 'Sudah' WHERE `NoRujukan` = '$nopemeriksaan' AND `PoliRujukan` = '$rujukinternal'");
}

// update tbpasienrj
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
	mysqli_query($koneksi, "DELETE FROM `tbrujukinternal` WHERE `NoRujukan`='$nopemeriksaan'");
	$str_rujuklanjut = "INSERT INTO `tbrujukinternal`(`TanggalRujukan`,`NoRujukan`, `PoliRujukan`,`StatusPemeriksaan`) VALUES ('$tgl','$nopemeriksaan','$rujukinternal','Rujuk')";
	// echo $str_rujuklanjut;
	// die();
	mysqli_query($koneksi,$str_rujuklanjut);

	// ketika di rujuk internal ke poli lab
	mysqli_query($koneksi, "DELETE FROM `$tbtindakanpasien` WHERE `IdPasienrj`='$idpasienrj' AND `KategoriTindakan` = 'Laboratorium' AND `Keterangan` = '-'");
	if($rujukinternal == 'POLI LABORATORIUM' || $rujukinternal2 == 'POLI LABORATORIUM' || $rujukinternal3 == 'POLI LABORATORIUM' || $rujukinternal4 == 'POLI LABORATORIUM' || $rujukinternal5 == 'POLI LABORATORIUM'){
		$tindakanlabs = $_POST['tindakanlabs'];
		foreach($tindakanlabs as $kd){
			$sekinsertbtindakandetail = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbtindakanpasien` WHERE `IdPasienrj`='$idpasienrj' AND `IdTindakan`='$kd'"));
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
	$dt_rujuk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbrujukluargedung` WHERE `NoRegistrasi`='$nopemeriksaan'"));
	if ($dt_rujuk == 0){
		$str_rujuk_lg = "INSERT INTO `tbrujukluargedung`(`TanggalRujukan`, `NoRegistrasi`, `KodeRumahSakit`, `Poli`, `KodeDiagnosa`) 
						VALUES ('$tanggal_registrasi','$nopemeriksaan','$rujuklanjut','$kdPoliRujukLanjut','$kdDiag1')";
	}else{
		$str_rujuk_lg = "UPDATE `tbrujukluargedung` SET `KodeRumahSakit`='$rujuklanjut', `Poli`='$kdPoliRujukLanjut', `KodeDiagnosa`='$kdDiag1' WHERE `NoRegistrasi`='$nopemeriksaan'";
	}
	mysqli_query($koneksi,$str_rujuk_lg);
}		

// delete tbdiagnosapasien
$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
$tbdiagnosapasien_bulan = 'tbdiagnosapasien_'.substr($nopemeriksaan,14,2);

// insert tbdiagnosapasien 
$strdeletdiag = "DELETE FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$idpasienrj'";
mysqli_query($koneksi,$strdeletdiag);

$strdeletdiag2= "DELETE FROM `$tbdiagnosapasien_bulan` WHERE `IdPasienrj` = '$idpasienrj'";
mysqli_query($koneksi,$strdeletdiag2);

$kasusdiagnosa = $_POST['kasusdiagnosabpjs'];
if($kasusdiagnosa != null){
	$no = -1;	
	foreach($kasusdiagnosa as $kasus){
	$no = $no + 1;
		$str_kasus_diagnosa = "INSERT INTO `$tbdiagnosapasien`(`IdPasienrj`,`TanggalDiagnosa`,`NoIndex`,`NoCM`,`NoRegistrasi`,`KodeDiagnosa`,`Kasus`,`Asuransi`,`Kelompok`,`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin`) VALUES 
		('$idpasienrj','$tanggal_registrasi','$noindex','$nocm','$nopemeriksaan','$kddiagnosabpjs[$no]','$kasus','$asuransi','$kelompok[$no]','$umurtahunpasien','$umurbulanpasien','$umurharipasien','$kelaminpasien')";
		mysqli_query($koneksi,$str_kasus_diagnosa);

		$str_diagnosa_bulan = "INSERT INTO `$tbdiagnosapasien_bulan`(`IdPasienrj`,`TanggalDiagnosa`,`NoIndex`,`NoCM`,`NoRegistrasi`,`KodeDiagnosa`,`Kasus`,`Asuransi`,`Kelompok`,`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin`) VALUES 
		('$idpasienrj','$tanggal_registrasi','$noindex','$nocm','$noregistrasi','$kddiagnosabpjs[$no]','$kasus','$asuransi','$kelompok[$no]','$umurtahunpasien','$umurbulanpasien','$umurharipasien','$kelaminpasien')";
		mysqli_query($koneksi, $str_diagnosa_bulan);
	}
}	

// insert askep
$tbdiagnosaaskep = 'tbdiagnosaaskep_'.str_replace(' ', '', $namapuskesmas);
$strdeldgsaaskep = "DELETE FROM `$tbdiagnosaaskep` WHERE `NoRegistrasi` = '$nopemeriksaan' AND `NoCM`='$nocm'";
mysqli_query($koneksi,$strdeldgsaaskep);

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
// $cektindakanps = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$nopemeriksaan' AND `KategoriTindakan` != 'Laboratorium'"));
// if($cektindakanps > 0){
// 	mysqli_query($koneksi, "DELETE FROM `$tbtindakanpasien` WHERE `IdPasienrj`='$idpasienrj' AND `KategoriTindakan` != 'Laboratorium'");
// 	$idtindakanbpjs = $_POST['idtindakanbpjs'];
// 	$tariftindakanbpjs = $_POST['tariftindakanbpjs'];
// 	$keteranganbpjs = $_POST['keteranganbpjs'];
// 	if($idtindakanbpjs != null){
// 		$no = -1;
// 		foreach($idtindakanbpjs as $kdtindakan){
// 			$no = $no + 1;
	
// 			// tbtindakan
// 			$getkategoritindakan = 	mysqli_query($koneksi,"SELECT * FROM `tbtindakan` WHERE IdTindakan = '$idtindakanbpjs[$no]'");
// 			if(mysqli_num_rows($getkategoritindakan) > 0){
// 				$dttindakan = mysqli_fetch_assoc($getkategoritindakan);
// 				$kattindakan = $dttindakan['KelompokTindakan'];
// 				$tariftindakan = $dttindakan['Tarif'];
// 				$total_tariftindakan = $total_tariftindakan + $tariftindakan;
// 			}else{
// 				$kattindakan = '-';
// 				$tariftindakan = 0;
// 				$total_tariftindakan = 0;
// 			}
			
// 			$str_tindakanpasiendetail = "INSERT INTO `$tbtindakanpasien`(`IdPasienrj`,`TanggalTindakan`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`PoliAsal`,`CaraBayar`,`IdTindakan`,`Tarif`,`KategoriTindakan`,`Keterangan`,`StatusBayar`,`NamaPegawaiSimpan`) 
// 			VALUES ('$idpasienrj','$tanggal_time','$nopemeriksaan','$noindex','$nocm','$namapasien','$pelayanan','$asuransi','$idtindakanbpjs[$no]','$tariftindakanbpjs[$no]','$kattindakan','$keteranganbpjs[$no]','BELUM','$namapegawai')";
// 			mysqli_query($koneksi,$str_tindakanpasiendetail);
// 		}	
// 	}
// }else{

	if($pelayanan != 'POLI LABORATORIUM'){
		mysqli_query($koneksi, "DELETE FROM `$tbtindakanpasien` WHERE `IdPasienrj`='$idpasienrj' AND `KategoriTindakan` != 'Laboratorium'");
		$idtindakanbpjs = $_POST['idtindakanbpjs'];
		if($idtindakanbpjs != null){
			foreach($idtindakanbpjs as $idtindakan){
				$getdttindakan = mysqli_query($koneksi,"SELECT * FROM `tbtindakan` WHERE IdTindakan = '$idtindakan'");
				if(mysqli_num_rows($getdttindakan) > 0){
					$getdttindakan_tersimpan = mysqli_query($koneksi,"SELECT * FROM `$tbtindakanpasien` WHERE IdTindakan = '$idtindakan' AND `IdPasienrj` = '$idpasienrj'");
					if(mysqli_num_rows($getdttindakan_tersimpan) == 0){
						$dttindakan = mysqli_fetch_assoc($getdttindakan);
						$tariftindakan = $dttindakan['Tarif'];
						$total_tariftindakan = $total_tariftindakan + $tariftindakan;
						$kategoritindakan = $dttindakan['KelompokTindakan'];
						$str_tindakanpasiendetail = "INSERT INTO `$tbtindakanpasien`(`IdPasienrj`,`TanggalTindakan`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`PoliAsal`,`CaraBayar`,`IdTindakan`,`Tarif`,`KategoriTindakan`,`Keterangan`,`StatusBayar`,`NamaPegawaiSimpan`) 
						VALUES ('$idpasienrj','$tanggal_time','$nopemeriksaan','$noindex','$nocm','$namapasien','$pelayanan','$asuransi','$idtindakan','$tariftindakan','$kategoritindakan','-','BELUM','$namapegawai')";
						// echo $str_tindakanpasiendetail;
						// die();
						mysqli_query($koneksi,$str_tindakanpasiendetail);
					}
					
				}
			}	
		}
	}	
// }

// jika editnya dari laboratorium, hanya mengupdate status poli rujukan saja
if($pelayanan == "POLI LABORATORIUM"){
	$kodetindakanlab = explode(',',$kodetindakanlab1);
	foreach($kodetindakanlab as $kdtndlab){
		$str_tindakanpasien_detail = "UPDATE `$tbtindakanpasien` SET `PoliRujukan`='$pelayanan' WHERE `NoRegistrasi`='$nopemeriksaan'";
		mysqli_query($koneksi,$str_tindakanpasien_detail);	
	}
}

// update tariftindakan
$tarifkarcis = $datapasienrj['TarifKarcis'];
$tarifkir = $datapasienrj['TarifKir'];
$totaltarif = $tarifkarcis + $tarifkir + $total_tariftindakan;
$update_tarif = "UPDATE `$tbpasienrj` SET `TarifTindakan`='$total_tariftindakan', `TotalTarif`='$totaltarif' WHERE `IdPasienrj` = '$idpasienrj'";
mysqli_query($koneksi, $update_tarif);
$update_tarif = "UPDATE `$tbpasienrj_retensi` SET `TarifTindakan`='$total_tariftindakan', `TotalTarif`='$totaltarif' WHERE `IdPasienrj` = '$idpasienrj'";
mysqli_query($koneksi, $update_tarif);


// edit tbpasienperpegawai
$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
if ($pelayanan == 'POLI LABORATORIUM'){
	$str_pgw = "UPDATE `$tbpasienperpegawai` SET `Lab`='$tenagalab'
	WHERE `NoRegistrasi` = '$nopemeriksaan'";
}else{
	// cek data dulu
	$cek_perpegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi` = '$nopemeriksaan'"));
	if($cek_perpegawai == ''){
		$str_pgw = "INSERT INTO `$tbpasienperpegawai`(`TanggalRegistrasi`,`NoRegistrasi`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`)
		VALUES ('$tanggal_registrasi','$nopemeriksaan','$tenagamedisbpjs','$tenagamedis2','$tenagamedis3')";
	}else{
		$str_pgw = "UPDATE `$tbpasienperpegawai` SET `NamaPegawai1` = '$tenagamedisbpjs', `NamaPegawai2` = '$tenagamedis2',
		`NamaPegawai3` = '$tenagamedis3',`Lab`='$tenagalab',`Farmasi` = '$tenagafarmasi'
		WHERE `NoRegistrasi` = '$nopemeriksaan'";
	}
}

$query1 = mysqli_query($koneksi,$str_pgw);	
	
// edit ke tabel periksa server BPJS
$hariini = date('d-m-Y');
$tglkunjunganbpjs = $_POST['tglkunjbpjs'];
$nokunjunganbpjs = $_POST['nokunjbpjs'];

if(substr($asuransi,0,4) == 'BPJS'){
	// if($kodepuskesmas == 'P3202280201' OR $kodepuskesmas == 'P3202180201' OR $kodepuskesmas == 'P3202230101'){
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
		// echo "Nokunjngan : ".$nokunjungan;
		// die();
		
		if($nokunjungan == '' OR $nokunjungan == 'G' OR $nokunjungan == '0'){
			$hasil_simpan_bpjs = simpan_pemeriksaan_spesialis($nokartu,$tanggal_bpjs,$kdpoli,$keluhan,$kdSadar,$sistole_p,$diastole_p,$beratbadan_p,$tinggibadan_p,$resprate_p,$heartrate_p,
			$lingkarperut_p,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdsubspesialis_spesial,$kdsarana,$kdtacc,$alasantacc);
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

			// update nokunjungan bpjs
			$strupdatenokunjungan = "UPDATE `$tbpasienrj` SET `NoKunjunganBpjs`= '$no_kunjungan', `KeteranganBridging` = '$keteranganbridging' WHERE `IdPasienrj` = '$idpasienrj'";
			mysqli_query($koneksi,$strupdatenokunjungan);
			$strupdatenokunjungan_retensi = "UPDATE `$tbpasienrj_retensi` SET `NoKunjunganBpjs`= '$no_kunjungan', `KeteranganBridging` = '$keteranganbridging' WHERE `IdPasienrj` = '$idpasienrj'";
			mysqli_query($koneksi,$strupdatenokunjungan_retensi);
		}else{
			$hasil_simpan_bpjs = edit_pemeriksaan($nokunjunganbpjs,$nokartu,$keluhan,$kdSadar,$sistole_p,$diastole_p,$beratbadan_p,$tinggibadan_p,$resprate_p,$heartrate_p,
			$lingkarperut_p,$kdStatusPulang,$tglPulang,$kdDokter,$kdDiag1,$kdDiag2,$kdDiag3,$tglEstRujuk,$kdppk,$kdsubspesialis_spesial,$kdsarana,$kdtacc,$alasantacc);
		
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
		}
	// }
}

// insert tbresep
$kdobatsk = 0;
$jumlahbpjs=$_POST['jumlahbpjs'];
$kdobat = $_POST['kodeobatbpjs'];
$nobatch = $_POST['nobatch'];
$kdobatlokal = $_POST['kodeobatlokal'];
$racikan= $_POST['status_racikan_bpjs'];
$dosisbpjs1 = $_POST['dosisbpjs1'];
$dosisbpjs2 = $_POST['dosisbpjs2'];
$anjuranterapi = $_POST['anjuranterapi'];
$namaobatbpjs = $_POST['namaobatbpjs'];
$namaobatnonbpjs = $_POST['namaobatnonbpjs'];
$kdobathapus=$_POST['kdobathapus'];
$ket_racikan = $_POST['ket_racikan'];
$arraykdobathapus = explode(",",$kdobathapus);

if ($_POST['jenis_pio'] != null){
	$jenis_pio = implode(",", $_POST['jenis_pio']);	
}else{
	$jenis_pio = "";
}

// insert tbresep
// jangan diaktifkan, karena klo tidak ada menambahkan data obat maka insert data tidak akan jalan. 
// Kebutuhannya untuk merubah status resep (diberikan, konseling, resep luar)

if($_POST['kodeobatlokal'] != ''){
	$nomorantrian = $_POST['noantrianresep'];
	mysqli_query($koneksi, "DELETE FROM `$tbresep` WHERE `NoResep`='$nopemeriksaan' AND `NoCM`='$nocm'");
	$str_resep = "INSERT INTO `$tbresep`(`TanggalResep`, `NoResep`, `NoIndex`, `NoCM`, `IdPasienrj`, `NamaPasien`, `UmurTahun`, `UmurBulan`, `StatusBayar`, `Pelayanan`, `NamaPegawai`, `Status`, `StatusLoket`,`Pio`,`Diagnosa`,`WaktuPenyerahan`,`NomorAntrian`,`OpsiResep`,`KetResepLuar`) VALUES
	('$tanggal_time','$nopemeriksaan','$noindex','$nocm','$idpasienrj','$namapasien','$umurtahun','$umurbulan','$asuransi','$pelayanan','$tenagamedisbpjs','Belum','LOKET OBAT','$jenis_pio','$kddiagnosaprimary','$tanggal_time','$nomorantrian','$opsiresep','$ket_resep_luar')";
	// echo $str_resep;
	// die();
	$query2=mysqli_query($koneksi,$str_resep);
}
	
foreach($arraykdobathapus as $ko){
	$ko2 = explode("|", $ko);
	$kdobt = $ko2[0];
	$nobtc = $ko2[1];

	// cek stok
	$get_jml_resep_detail = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `jumlahobat` FROM `$tbresepdetail` WHERE `NoResep` = '$nopemeriksaan' AND `KodeBarang`='$kdobt' AND `NoBatch`='$nobtc'"));
	$get_stok_apotik = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `$tbapotikstok` WHERE KodeBarang='$kdobt' AND `NoBatch`='$nobtc' AND `StatusBarang`='LOKET OBAT'"));
	$stok_lama = $get_jml_resep_detail['jumlahobat'] + $get_stok_apotik['Stok'];
	
	// tbapotikstok update jumlah
	$str_obat_update_apotik_stok = "UPDATE `$tbapotikstok` SET `Stok`='$stok_lama' WHERE KodeBarang='$kdobt' AND `NoBatch`='$nobtc' AND `StatusBarang`='LOKET OBAT'";
	mysqli_query($koneksi,$str_obat_update_apotik_stok);
		
	// tbresepdetail delete
	$str_delete_resep_detail = "DELETE FROM `$tbresepdetail` WHERE `NoResep` = '$nopemeriksaan' AND `KodeBarang`='$kdobt' AND `NoBatch`='$nobtc'";	
	mysqli_query($koneksi,$str_delete_resep_detail);
}	

if($_POST['kodeobatlokal'] != ''){
	$i = -1;	
	foreach($kdobat as $kdt){
		$i= $i + 1;
		
		if($racikan[$i] == 'true'){
			$kdracikan= 'R.01';
			$jmlpermintaan = $jumlahbpjs[$i] / 500;
		}else{
			$kdracikan= 'N';
			$jmlpermintaan = 0;
		}
		
		if($kdt == ''){
			$namaobatbpjs= false;
			$namaobatnondpho= $namaobatnonbpjs[$i];
		}else{
			$namaobatbpjs= true;
			$namaobatnondpho= $namaobatbpjs[$i];
		}
		
		// tbresepdetail
		$str_resep_detail = "INSERT INTO `$tbresepdetail`(`TanggalResep`,`NoResep`,`IdPasienrj`,`racikan`,`kdRacikan`,`obatDPHO`,`KodeBarang`,`NoBatch`,`signa1`,`signa2`,`jumlahobat`,`jmlPermintaan`,`nmObatNonDPHO`,`KdObatSk`,`Pelayanan`,`AnjuranResep`,`KeteranganRacikan`,`Depot`) VALUES
		('$tanggal_time','$nopemeriksaan','$idpasienrj','$racikan[$i]','$kdracikan','$namaobatbpjs','$kdobatlokal[$i]','$nobatch[$i]','$dosisbpjs1[$i]','$dosisbpjs2[$i]','$jumlahbpjs[$i]','$jmlpermintaan','$namaobatnondpho','$kdobatsk2','$pelayanan','$anjuranterapi[$i]','$ket_racikan[$i]','LOKET OBAT')";
		// echo $str_resep_detail;
		// die();
		mysqli_query($koneksi, $str_resep_detail);
		
		$get_stok_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"Select Stok from `$tbapotikstok` WHERE KodeBarang = '$kdobatlokal[$i]' AND `NoBatch`='$nobatch[$i]' AND `StatusBarang`='LOKET OBAT'"));
		$stok_baru = $get_stok_lama['Stok'] - $jumlahbpjs[$i];
		
		$str_obat_update = "UPDATE `$tbapotikstok` SET `Stok`='$stok_baru' WHERE KodeBarang = '$kdobatlokal[$i]' AND `NoBatch`='$nobatch[$i]' AND `StatusBarang`='LOKET OBAT'";
		mysqli_query($koneksi,$str_obat_update);

		// ketika dia pasien bpjs
		/*if($codedaftar == '200'){	
			if($_SESSION['koneksi_bpjs']== 'Stabil'){
				// hapus data obat bpjs
				// if($_SESSION['koneksi_bpjs']== 'Stabil'){
					// if($nokunjunganbpjs != 0){
						// $kdobathapusbpjs = $_POST['kdobathapusbpjs'];
						// $arraykdobatbpjshapus = explode(",",$kdobathapusbpjs);	
						// foreach($arraykdobatbpjshapus as $ko){
							// hapus_obat_bpjs($ko,$nokunjunganbpjs);
						// }
					// }
				// }
				
				if($nokunjunganbpjs != 0){	
					$simpan_terapi_bpjs = simpan_terapi_bpjs($kdobatsk,$nokunjunganbpjs,$racikan[$i],$kdracikan,$namaobatbpjs,$kdt,$dosisbpjs1[$i],$dosisbpjs2[$i],$jumlahbpjs[$i],$jmlpermintaan,$namaobatnondpho);
					$json_hasil_simpan_obat_bpjs = json_decode($simpan_terapi_bpjs,True);
					$kdobatsk2 = $json_hasil_simpan_obat_bpjs['response'][0]['message'];
				}else{
					$kdobatsk2 = "0";
				}
			}
		}*/
	}
}	

// tindakan 
$kdtindakan = $_POST['kodetindakanbpjs'];
if($kdtindakan != null){
	$kdtindakan2 = implode($kdtindakan,"','");
	$sumtarif = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(Tarif)as total FROM tbtindakan WHERE IdTindakan IN('$kdtindakan2')"));
	$grandtotalbiaya = $sumtarif['total'];
	$strtindakan = "UPDATE `tbtindakan` SET GrandTotal = '$grandtotalbiaya' Where `NoRegistrasi` = '$nopemeriksaan'";
	mysqli_query($koneksi,$strtindakan);
}
	
if($query){	
	mysqli_query($koneksi,"UPDATE `$tbpasienrj` SET `StatusPulang`= '$statuspulang' WHERE `IdPasienrj` = '$idpasienrj'");
	mysqli_query($koneksi, $strdiagnosapasien);
	
	alert_swal('sukses','Data berhasil disimpan');
	echo "<script>";
	// echo "alert('Data berhasil disimpan...');";
	if($pelayanan == 'POLI SKD'){
		echo "document.location.href='index.php?page=poli_skd_blangko&id=$nopemeriksaan&nocm=$nocm&noindex=$noindex';";
	}else{
		// echo "document.location.href='index.php?page=poli&pelayanan=$pelayanan&status=Antri';";
		echo "document.location.href='index.php?page=poli_periksa_print&noreg=$nopemeriksaan&idrj=$idpasienrj&pelayanan=$pelayanan';";
	}
	echo "</script>";
}else{
	// echo $str;
	// die();
	alert_swal('gagal','Data gagal disimpan');
	echo "<script>";
	// echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=poli_periksa_edit&id=$idpasienrj&pelayanan=$pelayanan';";
	echo "</script>";
} 
?>