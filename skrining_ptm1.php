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
            $str = "INSERT INTO `tbskrining_ptm`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`RiwayatKontak`,`PernahTerdiagnosa`,
            `PernahBerobat`,`Malnutrisi`,`Merokok`,`RiwayatDM`,`ODHIV`,`Lansia`,`IbuHamil`,`WargaBinaanPemasyarakatan`,
            `TinggalWilayahKumuh`,`Abnormalitas`,`Batuk`,`BbTurun`,`Demam`,`Berkeringat`,`PenyakitPernapasan`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$riwayatkontak','$pernahterdiagnosa',
            '$pernahberobat','$malnutrisi','$merokok','$riwayatdm','$odhiv','$lansia','$ibuhamil','$wargabinaan',
            '$tinggalwilayah','$abnormalitas','$batuk','$bbturun','$demam','$berkeringat','$penyakitpernapasan')";
        }else{
            $str = "UPDATE `tbskrining_ptm` 
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
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `tbskrining_ptm` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_ptm.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">  
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>"> 
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining PTM
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <p style="font-size: 16px; font-weight: bold;" class="judul"> Faktor Resiko</p>
                                <tr>
                                    <td class="col-sm-3">Merokok</td>
                                    <td class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_01" value="ya" <?php if($datapemeriksaan['PernahTerdiagnosa'] == 'ya'){echo "checked";}?>> Ya (Aktif)
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_01" value="tidak" <?php if($datapemeriksaan['PernahTerdiagnosa'] == 'tidak'){echo "checked";}?>> Ya (pasif)
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_01" value="tidak" <?php if($datapemeriksaan['PernahTerdiagnosa'] == 'tidak'){echo "checked";}?>> Tidak Merokok
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kurang Aktivitas Fisik</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_02" value="ya" <?php if($datapemeriksaan['PernahBerobat'] == 'ya'){echo "checked";}?>> Ya (< 3 kali per minggu)
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_02" value="tidak" <?php if($datapemeriksaan['PernahBerobat'] == 'tidak'){echo "checked";}?>> Tidak (≥ 3 kali per minggu)
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gula Berlebihan</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_03" value="ya" <?php if($datapemeriksaan['Malnutrisi'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_03" value="tidak" <?php if($datapemeriksaan['Malnutrisi'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Garam Berlebihan</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_04" value="ya" <?php if($datapemeriksaan['Merokok'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_04" value="tidak" <?php if($datapemeriksaan['Merokok'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lemak Berlebihan</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_05" value="ya" <?php if($datapemeriksaan['RiwayatDM'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_05" value="tidak" <?php if($datapemeriksaan['RiwayatDM'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kurang Makan Buah dan Sayur</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_06" value="ya" <?php if($datapemeriksaan['ODHIV'] == 'ya'){echo "checked";}?>> Ya (< 5 porsi per hari)
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_06" value="tidak" <?php if($datapemeriksaan['ODHIV'] == 'tidak'){echo "checked";}?>> Tidak (≥ 5 porsi per hari)
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Konsumsi Alkohol</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_07" value="ya" <?php if($datapemeriksaan['Lansia'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_07" value="tidak" <?php if($datapemeriksaan['Lansia'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Gangguan Penglihatan</p>
                        <div class="table-responsive">
                            <table class="table-judul" width="100%">
                                <tr>
                                    <td colspan = "2"><b>Katarak</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-3">Mata Kanan</td>
                                    <td class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_01" value="ya" <?php if($datapemeriksaan['Batuk'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_01" value="tidak" <?php if($datapemeriksaan['Batuk'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mata Kiri</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_02" value="ya" <?php if($datapemeriksaan['BbTurun'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_02" value="tidak" <?php if($datapemeriksaan['BbTurun'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rujuk Puskesmas</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_03" value="ya" <?php if($datapemeriksaan['Demam'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_03" value="tidak" <?php if($datapemeriksaan['Demam'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan = "2"><b>Kelainan Refraksi</b></td>
                                </tr>
                                <tr>
                                    <td>Mata Kanan</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mata Kiri</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rujuk Puskesmas</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Gangguan Pendengaran</p>
                        <div class="table-responsive">
                            <table class="table-judul" width="100%">
                                <tr>
                                    <td colspan = "2"><b>Curiga Tuli Kongenital</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-3">Telinga  Kanan</td>
                                    <td class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_01" value="ya" <?php if($datapemeriksaan['Batuk'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_01" value="tidak" <?php if($datapemeriksaan['Batuk'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Telinga  Kiri</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_02" value="ya" <?php if($datapemeriksaan['BbTurun'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_02" value="tidak" <?php if($datapemeriksaan['BbTurun'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rujuk Puskesmas</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_03" value="ya" <?php if($datapemeriksaan['Demam'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_03" value="tidak" <?php if($datapemeriksaan['Demam'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan = "2"><b>OMSK/Congek</b></td>
                                </tr>
                                <tr>
                                    <td>Telinga Kanan</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Telinga Kiri</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rujuk Puskesmas</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan = "2"><b>Serumen</b></td>
                                </tr>
                                <tr>
                                    <td>Telinga Kanan</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Telinga Kiri</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rujuk Puskesmas</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Form UBM (Upaya Berhenti Merokok)</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-3">Konseling</td>
                                    <td class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Konseling 1
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Konseling 2
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Konseling 3
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Konseling 4
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Konseling 5
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Konseling 6
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Car</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Car 3
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Car 6
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Car 9
                                            </label>&nbsp &nbsp
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rujuk</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kondisi</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Do
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Kambuh
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Sukses
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Riwayat PTM Pada Keluarga</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-3">Diabetes</td>
                                    <td class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hipertensi</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jantung</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stroke</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Asma</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kanker</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kolesterol Tinggi</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Benjolan Payudara</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Riwayat PTM Pada Diri Sendiri</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-3">Diabetes</td>
                                    <td class="col-sm-9">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hipertensi</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jantung</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stroke</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Asma</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kanker</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kolesterol Tinggi</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Benjolan Payudara</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Tekanan Darah & IMT</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-3">Sistole </td>
                                    <td class="col-sm-9">
                                        <input type="text" name="penyakitpernapasan" class="form-control inputan">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diastole  </td>
                                    <td>
                                        <input type="text" name="penyakitpernapasan" class="form-control inputan">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tinggi Badan </td>
                                    <td>
                                        <input type="text" name="penyakitpernapasan" class="form-control inputan">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Berat Badan </td>
                                    <td>
                                        <input type="text" name="penyakitpernapasan" class="form-control inputan">
                                    </td>
                                </tr>
                                <tr>
                                    <td>IMT </td>
                                    <td>
                                        <input type="text" name="penyakitpernapasan" class="form-control inputan">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hasil IMT </td>
                                    <td>
                                        <input type="text" name="penyakitpernapasan" class="form-control inputan">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Pemeriksaan</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-3">Lingkar Perut </td>
                                    <td class="col-sm-9">
                                        <input type="text" name="penyakitpernapasan" class="form-control inputan">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pemeriksaan Gula  </td>
                                    <td>
                                        <input type="text" name="penyakitpernapasan" class="form-control inputan">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rujuk Puskesmas</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Terapi Farmakologi</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Diberikan Obat
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak Diberikan Obat
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Edukasi</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Konseling, Informasi dan Edukasi Kesehatan</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Aktifitas Fisik
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Gizi
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Pemeriksaan IVA dan Sadanis</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td>Hasil IVA</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Positif
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Negatif
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Curiga Kanker
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tindak Lanjut Iva Positif</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Krioterapi
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Rujuk
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hasil Sanadis</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Benjolan
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Tidak Ada Benjolan
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="tidak" <?php if($datapemeriksaan['Berkeringat'] == 'tidak'){echo "checked";}?>> Curiga Kanker
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tindak Lanjut Sanadis</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="gejala_tbc_04" value="ya" <?php if($datapemeriksaan['Berkeringat'] == 'ya'){echo "checked";}?>> Rujuk
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div><hr/>
                        <button type="submit" name="btnsimpan" value="simpan" class="btn btn-round btn-success btnsimpan">Simpan Skrining</button>
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

