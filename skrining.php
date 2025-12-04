<?php
    session_start();
    error_reporting(0);
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";
    $idpasienrj = $_GET['idrj'];
    $idsiklushidup = $_GET['idsh'];

    // tbpasienrj
    $query = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'");
    if(mysqli_num_rows($query ) > 0){
        $data = mysqli_fetch_assoc($query);
        $idpasien = $data['IdPasien'];
        $nocm = $data['NoCM'];
        $noindex = $data['NoIndex'];
        $noregistrasi = $data['NoRegistrasi'];
        $jeniskunjungan = $data['JenisKunjungan'];
        $kdprovider = $data['kdprovider'];
        $pelayanan = $data['PoliPertama'];

        // tbkk
        $datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));

        // tbpasien
        $datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'"));

?>


<style>
    .font_tabel{
        font-size: 14px;
        font-family: "Poppins", sans-serif;
    }
    .tableborder tr{
        border-bottom: 1px solid #dbdbdb;
    }
    .tabel_judul th{
        background: #3bac9b;
        border-collapse: separate;
        font-size: 12px;
        line-height: 20px;
        text-align: center;
        padding: 5px 10px;
        color: #fff;
    }
    .tabel_isi{
        background: #fff;
        color: #000;
        padding: 5px 10px;
        text-align: center;
    }
    .autocomplete-suggestions {
        width: 500px !important;
    }
    .table-responsive{
        overflow: hidden;
    }
</style>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <?php
                    $no = 0;
                    $qrysiklus = mysqli_query($koneksi, "SELECT * FROM `siklushidup_skrining` WHERE `IdSiklusHidup`='$idsiklushidup'");
                    while($dtsiklus = mysqli_fetch_assoc($qrysiklus)){
                        $no = $no + 1;
                        $tbsimpan = '';

                        // formulir
                        $dtskrining = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_skrining` WHERE `IdSkrining`='$dtsiklus[IdSkrining]'"));
                       
                        if($dtskrining['NamaFile'] == 'skrining_tbc'){
                            $tbsimpan = $tbskrining_tbc;
                        }elseif($dtskrining['NamaFile'] == 'skrining_merokok'){
                            $tbsimpan = $tbskrining_merokok;
                        }elseif($dtskrining['NamaFile'] == 'skrining_wast'){
                            $tbsimpan = $tbskrining_wast;
                        }elseif($dtskrining['NamaFile'] == 'skrining_puma'){
                            $tbsimpan = $tbskrining_puma;
                        }elseif($dtskrining['NamaFile'] == 'skrining_thalasemia'){
                            $tbsimpan = $tbskrining_thalasemia;
                        }elseif($dtskrining['NamaFile'] == 'skrining_obesitas'){
                            $tbsimpan = $tbskrining_obesitas;
                        }elseif($dtskrining['NamaFile'] == 'skrining_diabetes'){
                            $tbsimpan = $tbskrining_diabetes;
                        }elseif($dtskrining['NamaFile'] == 'skrining_hipertensi'){
                            $tbsimpan = $tbskrining_hipertensi;
                        }elseif($dtskrining['NamaFile'] == 'skrining_penglihatan'){
                            $tbsimpan = $tbskrining_penglihatan;
                        }elseif($dtskrining['NamaFile'] == 'skrining_kolorektal'){
                            $tbsimpan = $tbskrining_kolorektal;
                        }elseif($dtskrining['NamaFile'] == 'skrining_layak_hamil'){
                            $tbsimpan = $tbskrining_layak_hamil;
                        }elseif($dtskrining['NamaFile'] == 'skrining_malaria'){
                            $tbsimpan = $tbskrining_malaria;
                        }elseif($dtskrining['NamaFile'] == 'skrining_kanker_payudara'){
                            $tbsimpan = $tbskrining_kanker_payudara;
                        }elseif($dtskrining['NamaFile'] == 'skrining_anemia'){
                            $tbsimpan = $tbskrining_anemia;
                        }elseif($dtskrining['NamaFile'] == 'skrining_selfereporting'){
                            $tbsimpan = $tbskrining_selfereporting;
                        }elseif($dtskrining['NamaFile'] == 'skrining_kanker_paru'){
                            $tbsimpan = $tbskrining_kanker_paru;
                        }elseif($dtskrining['NamaFile'] == 'skrining_jantung'){
                            $tbsimpan = $tbskrining_jantung;
                        }elseif($dtskrining['NamaFile'] == 'skrining_kehamilan'){
                            $tbsimpan = $tbskrining_kehamilan;
                        }elseif($dtskrining['NamaFile'] == 'skrining_kebugaran'){
                            $tbsimpan = $tbskrining_kebugaran;
                        }elseif($dtskrining['NamaFile'] == 'skrining_gigi_lansia'){
                            $tbsimpan = $tbskrining_gigi_lansia;
                        }elseif($dtskrining['NamaFile'] == 'skrining_kanker_serviks'){
                            $tbsimpan = $tbskrining_kanker_serviks;
                        }elseif($dtskrining['NamaFile'] == 'skrining_indra'){
                            $tbsimpan = $tbskrining_indra;
                        }elseif($dtskrining['NamaFile'] == 'skrining_ptm'){
                            $tbsimpan = $tbskrining_ptm;
                        }elseif($dtskrining['NamaFile'] == 'skrining_imunisasi_dewasa'){
                            $tbsimpan = $tbskrining_imunisasi_dewasa;
                        }elseif($dtskrining['NamaFile'] == 'skrining_sdidtk'){
                            $tbsimpan = $tbskrining_sdidtk;
                        }elseif($dtskrining['NamaFile'] == 'skrining_hipoteroid'){
                            $tbsimpan = $tbskrining_hipoteroid;
                        }elseif($dtskrining['NamaFile'] == 'skrining_jantung_bawaan'){
                            $tbsimpan = $tbskrining_jantung_bawaan;
                        }elseif($dtskrining['NamaFile'] == 'skrining_gigi_balita'){
                            $tbsimpan = $tbskrining_gigi_balita;
                        }elseif($dtskrining['NamaFile'] == 'skrining_gigi_remaja'){
                            $tbsimpan = $tbskrining_gigi_remaja;
                        }elseif($dtskrining['NamaFile'] == 'skrining_gigi_dewasa'){
                            $tbsimpan = $tbskrining_gigi_dewasa;
                        }elseif($dtskrining['NamaFile'] == 'skrining_assist'){
                            $tbsimpan = $tbskrining_assist;
                        }elseif($dtskrining['NamaFile'] == 'skrining_stroke'){
                            $tbsimpan = $tbskrining_stroke;
                        }elseif($dtskrining['NamaFile'] == 'skrining_eklamsia'){
                            $tbsimpan = $tbskrining_eklamsia;
                        }elseif($dtskrining['NamaFile'] == 'skrining_sdq_6'){
                            $tbsimpan = $tbskrining_sdq_6;
                        }elseif($dtskrining['NamaFile'] == 'skrining_sdq_11'){
                            $tbsimpan = $tbskrining_sdq_11;
                        }elseif($dtskrining['NamaFile'] == 'skrining_gds'){
                            $tbsimpan = $tbskrining_gds;
                        }elseif($dtskrining['NamaFile'] == 'skrining_mma'){
                            $tbsimpan = $tbskrining_mma;
                        }elseif($dtskrining['NamaFile'] == 'skrining_sppb'){
                            $tbsimpan = $tbskrining_sppb;
                        }elseif($dtskrining['NamaFile'] == 'skrining_mental'){
                            $tbsimpan = $tbskrining_mental;
                        }elseif($dtskrining['NamaFile'] == 'skrining_syndrome'){
                            $tbsimpan = $tbskrining_psyndrome;
                        }elseif($dtskrining['NamaFile'] == 'skrining_cog'){
                            $tbsimpan = $tbskrining_cog;
                        }elseif($dtskrining['NamaFile'] == 'skrining_adl'){
                            $tbsimpan = $tbskrining_adl;
                        }elseif($dtskrining['NamaFile'] == 'skrining_skilas'){
                            $tbsimpan = $tbskrining_skilas;
                        }

                        if($tbsimpan != ''){
                            $cek = mysqli_query($koneksi, "SELECT * FROM $tbsimpan WHERE `IdPasien` = '$idpasien'");                            
                            $stssimpan = (mysqli_num_rows($cek) > 0) ? true : false;
                            if($stssimpan){
                                $tglskrining = mysqli_fetch_array($cek)['TanggalPeriksa'];
                            }
                        }else{
                            $stssimpan = false;
                        }
                    ?>
                        <div class="alert <?php echo ($stssimpan) ? 'alert-success': 'alert-primary';?>">
                            <?php echo $no;?>
                            <?php echo $dtskrining['NamaSkrining'];?>
                            <div style="position: absolute; right: 150px; top: 15px;"><?php echo ($stssimpan) ? ' '.$tglskrining: ' ';?></div>
                            <a href="?page=<?php echo $dtskrining['NamaFile'];?>&idrj=<?php echo $idpasienrj;?>&idps=<?php echo $idpasien;?>&idsh=<?php echo $idsiklushidup;?>" style="color:blue !important">
                                <button class="btn btn-round btn-sm <?php echo ($stssimpan) ? 'btn-success': 'btn-primary';?> pull-right" style="font-size: 12px; margin-top: -5px;"><?php echo ($stssimpan) ? 'Lihat': 'Formulir';?> Skrining</button>
                            </a>
                         </div>
                    <?php
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }
?>