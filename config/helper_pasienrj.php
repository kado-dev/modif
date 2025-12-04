<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$kota = $_SESSION['kota'];
$kecamatan = $_SESSION['kecamatan'];
$kelurahan = $_SESSION['kelurahan'];
$alamat = $_SESSION['alamat'];
$telepon = $_SESSION['telepon'];
$email = $_SESSION['email'];
$kodeppk = $_SESSION['kodeppk'];
$kapus = $_SESSION['kapus'];
$kapusnip = $_SESSION['kapusnip'];
$nomorsuratsehat = $_SESSION['nomorsuratsehat'];
$nomorsuratsakit = $_SESSION['nomorsuratsakit'];
$bulanini = date('m');
$tahunini = date('Y');
$tbantrianpasien = "tbantrian_pasien_".$kodepuskesmas;
$tbpasienonline = 'tbpasienonline_'.$kodepuskesmas;
$tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
$tbpasienrj_retensi = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas)."_RETENSI";
$tbpasien = 'tbpasien_'.str_replace(' ', '', $namapuskesmas);
$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
$tbdiagnosaaskep = 'tbdiagnosaaskep_'.str_replace(' ', '', $namapuskesmas);
$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
$tbpoligigi = 'tbpoligigi_'.str_replace(' ', '', $namapuskesmas);
$tbpolikia = 'tbpolikia_'.str_replace(' ', '', $namapuskesmas);
$tbpolilansia = 'tbpolilansia_'.str_replace(' ', '', $namapuskesmas);
$tbpolimtbs = 'tbpolimtbs_'.str_replace(' ', '', $namapuskesmas);
$tbpoliumum = 'tbpoliumum_'.str_replace(' ', '', $namapuskesmas);
$tbresep = 'tbresep_'.str_replace(' ', '', $namapuskesmas);
$tbresepdetail = 'tbresepdetail_'.str_replace(' ', '', $namapuskesmas);
$tbvitalsign = 'tbvitalsign_'.str_replace(' ', '', $namapuskesmas);
$tbgudangpkmstok = 'tbgudangpkmstok_'.str_replace(' ', '', $namapuskesmas);
$tbapotikstok = 'tbapotikstok_'.str_replace(' ', '', $namapuskesmas);
$tbgudangpkmpenerimaandetail = 'tbgudangpkmpenerimaandetail_'.str_replace(' ', '', $namapuskesmas);
$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
$tbtte = 'tbtte_'.str_replace(' ', '', $namapuskesmas);
$tbgeneralkonsen = 'tbgeneralkonsen_'.str_replace(' ', '', $namapuskesmas);
$tbgeneralkonsen_detail = 'tbgeneralkonsen_detail_'.str_replace(' ', '', $namapuskesmas);
$tbsuratsehat = 'tbsuratsehat_'.str_replace(' ', '', $namapuskesmas);
$tbsuratsakit = 'tbsuratsakit_'.str_replace(' ', '', $namapuskesmas);
$tbsuratberobat = 'tbsuratberobat_'.str_replace(' ', '', $namapuskesmas);
$tbsuratmata = 'tbsuratmata_'.str_replace(' ', '', $namapuskesmas);
$tbsurathaji = 'tbsurathaji_'.str_replace(' ', '', $namapuskesmas);
$tbsuratcatin = 'tbsuratcatin_'.str_replace(' ', '', $namapuskesmas);

// skrining ilp
$tbskrining_tbc  = 'tbskrining_tbc_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_merokok  = 'tbskrining_merokok_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_wast  = 'tbskrining_wast_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_puma  = 'tbskrining_puma_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_thalasemia  = 'tbskrining_thalasemia_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_obesitas  = 'tbskrining_obesitas_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_diabetes  = 'tbskrining_diabetes_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_hipertensi  = 'tbskrining_hipertensi_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_penglihatan  = 'tbskrining_penglihatan_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_kolorektal  = 'tbskrining_kolorektal_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_layak_hamil  = 'tbskrining_layak_hamil_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_malaria  = 'tbskrining_malaria_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_kanker_payudara  = 'tbskrining_kanker_payudara_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_anemia  = 'tbskrining_anemia_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_selfereporting  = 'tbskrining_selfereporting_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_kanker_paru  = 'tbskrining_kanker_paru_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_jantung  = 'tbskrining_jantung_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_kehamilan  = 'tbskrining_kehamilan_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_kebugaran  = 'tbskrining_kebugaran_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_gigi_lansia  = 'tbskrining_gigi_lansia_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_kanker_serviks  = 'tbskrining_kanker_serviks_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_indra  = 'tbskrining_indra_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_ptm  = 'tbskrining_ptm_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_imunisasi_dewasa  = 'tbskrining_imunisasi_dewasa_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_sdidtk  = 'tbskrining_sdidtk_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_hipoteroid  = 'tbskrining_hipoteroid_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_jantung_bawaan  = 'tbskrining_jantung_bawaan_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_gigi_balita  = 'tbskrining_gigi_balita_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_gigi_remaja  = 'tbskrining_gigi_remaja_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_gigi_dewasa  = 'tbskrining_gigi_dewasa_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_assist  = 'tbskrining_assist_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_stroke  = 'tbskrining_stroke_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_eklamsia  = 'tbskrining_eklamsia_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_sdq_6  = 'tbskrining_sdq_6_'.str_replace(' ', '', $namapuskesmas);
$tbskriningtbskrining_sdq_11_tbc  = 'tbskrining_sdq_11_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_gds  = 'tbskrining_gds_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_mma  = 'tbskrining_mma_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_sppb  = 'tbskrining_sppb_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_mental  = 'tbskrining_mental_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_syndrome  = 'tbskrining_syndrome_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_cog  = 'tbskrining_cog_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_adl  = 'tbskrining_adl_'.str_replace(' ', '', $namapuskesmas);
$tbskrining_skilas  = 'tbskrining_skilas_'.str_replace(' ', '', $namapuskesmas);

if($kota == "KOTA TARAKAN" OR $kota == "KABUPATEN SUKABUMI"){
    $ref_obat_lplpo = "ref_obat_lplpo_".str_replace(' ', '', $namapuskesmas);
}else{
    $ref_obat_lplpo = "ref_obat_lplpo";
}

if($kota == "KOTA TARAKAN"){
    date_default_timezone_set('Asia/Ujung_Pandang');
}else{
    date_default_timezone_set('Asia/Jakarta');
}
?>