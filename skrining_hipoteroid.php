<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['riwayatkontaktb'])) {$riwayatkontak = $_POST['riwayatkontaktb'];} else {$riwayatkontak = "";}
    if (isset($_POST['faktor_resiko_01'])) {$pernahterdiagnosa = $_POST['faktor_resiko_01'];} else {$pernahterdiagnosa = "";}
    if (isset($_POST['faktor_resiko_02'])) {$pernahberobat = $_POST['faktor_resiko_02'];} else {$pernahberobat = "";}
    if (isset($_POST['faktor_resiko_03'])) {$malnutrisi = $_POST['faktor_resiko_03'];} else {$malnutrisi = "";}
    if (isset($_POST['faktor_resiko_04'])) {$merokok = $_POST['faktor_resiko_04'];} else {$merokok = "";}
    if (isset($_POST['faktor_resiko_05'])) {$riwayatdm = $_POST['faktor_resiko_05'];} else {$riwayatdm = "";}
    if (isset($_POST['faktor_resiko_06'])) {$odhiv = $_POST['faktor_resiko_06'];} else {$odhiv = "";}
    if (isset($_POST['faktor_resiko_07'])) {$lansia = $_POST['faktor_resiko_07'];} else {$lansia = "";}
    if (isset($_POST['faktor_resiko_08'])) {$ibuhamil = $_POST['faktor_resiko_08'];} else {$ibuhamil = "";}
    if (isset($_POST['faktor_resiko_09'])) {$wargabinaan = $_POST['faktor_resiko_09'];} else {$wargabinaan = "";}
    if (isset($_POST['faktor_resiko_10'])) {$tinggalwilayah = $_POST['faktor_resiko_10'];} else {$tinggalwilayah = "";}
    if (isset($_POST['faktor_resiko_11'])) {$abnormalitas = $_POST['faktor_resiko_11'];} else {$abnormalitas = "";}
    if (isset($_POST['gejala_tbc_01'])) {$batuk = $_POST['gejala_tbc_01'];} else {$batuk = "";}
    if (isset($_POST['gejala_tbc_02'])) {$bbturun = $_POST['gejala_tbc_02'];} else {$bbturun = "";}
    if (isset($_POST['gejala_tbc_03'])) {$demam = $_POST['gejala_tbc_03'];} else {$demam = "";}
    if (isset($_POST['gejala_tbc_04'])) {$berkeringat = $_POST['gejala_tbc_04'];} else {$berkeringat = "";}
    if (isset($_POST['penyakitpernapasan'])) {$penyakitpernapasan = $_POST['penyakitpernapasan'];} else {$penyakitpernapasan = "";}
    
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_ptm`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`RiwayatKontak`,`PernahTerdiagnosa`,
            `PernahBerobat`,`Malnutrisi`,`Merokok`,`RiwayatDM`,`ODHIV`,`Lansia`,`IbuHamil`,`WargaBinaanPemasyarakatan`,
            `TinggalWilayahKumuh`,`Abnormalitas`,`Batuk`,`BbTurun`,`Demam`,`Berkeringat`,`PenyakitPernapasan`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$riwayatkontak','$pernahterdiagnosa',
            '$pernahberobat','$malnutrisi','$merokok','$riwayatdm','$odhiv','$lansia','$ibuhamil','$wargabinaan',
            '$tinggalwilayah','$abnormalitas','$batuk','$bbturun','$demam','$berkeringat','$penyakitpernapasan')";
        }else{
            $str = "UPDATE `$tbskrining_ptm` 
            SET `RiwayatKontak`='$riwayatkontak',
            `PernahTerdiagnosa`='$pernahterdiagnosa',
            `PernahBerobat`='$pernahberobat',
            `Malnutrisi`='$malnutrisi',
            `Merokok`='$merokok',
            `RiwayatDM`='$riwayatdm',
            `ODHIV`='$odhiv',
            `Lansia`='$lansia',
            `IbuHamil`='$ibuhamil',
            `WargaBinaanPemasyarakatan`='$wargabinaan',
            `TinggalWilayahKumuh`='$tinggalwilayah',
            `Abnormalitas`='$abnormalitas',
            `Batuk`='$batuk',
            `BbTurun`='$bbturun',
            `Demam`='$demam',
            `Berkeringat`='$berkeringat',
            `PenyakitPernapasan`='$penyakitpernapasan'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_ptm&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_ptm&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_ptm
    $idpasienrj = $_GET['id'];
    $idpasien = $_GET['idps']; 
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_ptm` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_hipoteroid.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Hipotiroid
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                Dalam Proses Pengembangan...
                            </table>
                        </div><hr/>
                        <!-- <button type="submit" name="btnsimpan" value="simpan" class="btn btn-round btn-success btnsimpan">Simpan Skrining</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    }
    $koneksi -> close();
?>

