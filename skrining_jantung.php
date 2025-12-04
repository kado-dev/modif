<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['jantung_01'])) {$Keluarga = $_POST['jantung_01'];} else {$Keluarga = "";}
    if (isset($_POST['jantung_02'])) {$DiriSendiri = $_POST['jantung_02'];} else {$DiriSendiri = "";}
    if (isset($_POST['jantung_03'])) {$Merokok = $_POST['jantung_03'];} else {$Merokok = "";}
    if (isset($_POST['jantung_04'])) {$AktifitasFisik = $_POST['jantung_04'];} else {$AktifitasFisik = "";}
    if (isset($_POST['jantung_05'])) {$Gula = $_POST['jantung_05'];} else {$Gula = "";}
    if (isset($_POST['jantung_06'])) {$Garam = $_POST['jantung_06'];} else {$Garam = "";}
    if (isset($_POST['jantung_07'])) {$Lemak = $_POST['jantung_07'];} else {$Lemak = "";}
    if (isset($_POST['jantung_08'])) {$BuahSayur = $_POST['jantung_08'];} else {$BuahSayur = "";}
    if (isset($_POST['jantung_09'])) {$Alkohol = $_POST['jantung_09'];} else {$Alkohol = "";}
    if (isset($_POST['jantung_10'])) {$Ekg = $_POST['jantung_10'];} else {$Ekg = "";}
    if (isset($_POST['jantung_11'])) {$EkgStatus = $_POST['jantung_11'];} else {$EkgStatus = "";}
    if (isset($_POST['jantung_12'])) {$Kardiovaskular = $_POST['jantung_12'];} else {$Kardiovaskular = "";}
   
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_jantung`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`Keluarga`,`DiriSendiri`,
            `Merokok`,`AktifitasFisik`,`Gula`,`Garam`,`Lemak`,`BuahSayur`,`Alkohol`,`Ekg`,
            `EkgStatus`,`Kardiovaskular`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$Keluarga','$DiriSendiri','$Merokok','$AktifitasFisik',
            '$Gula','$Garam','$Lemak','$BuahSayur','$Alkohol','$Ekg','$EkgStatus','$Kardiovaskular')";
        }else{
            $str = "UPDATE `$tbskrining_jantung` 
            SET `Keluarga`='$Keluarga',
            `DiriSendiri`='$DiriSendiri',
            `Merokok`='$Merokok',
            `AktifitasFisik`='$AktifitasFisik',
            `Gula`='$Gula',
            `Garam`='$Garam',
            `Lemak`='$Lemak',
            `BuahSayur`='$BuahSayur',
            `Alkohol`='$Alkohol',
            `Ekg`='$Ekg',
            `EkgStatus`='$EkgStatus',
            `Kardiovaskular`='$Kardiovaskular'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_jantung&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_jantung&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_jantung
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_jantung` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_jantung.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>"> 
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Risiko Penyakit Jantung
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-4">Riwayat Penyakit Keluarga </td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="jantung_01" value="Jantung" <?php if($datapemeriksaan['Keluarga'] == 'Jantung'){echo "checked";}?>> Jantung
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="jantung_01" value="tidak" <?php if($datapemeriksaan['Keluarga'] == 'tidak'){echo "checked";}?>> Tidak ada
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-4">Riwayat Penyakit Diri Sendiri </td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="jantung_02" value="Jantung" <?php if($datapemeriksaan['DiriSendiri'] == 'Jantung'){echo "checked";}?>> Jantung
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="jantung_02" value="tidak" <?php if($datapemeriksaan['DiriSendiri'] == 'tidak'){echo "checked";}?>> Tidak ada
                                            </label>
                                        </div>
                                    </td>
                                </tr>                               
                            </table>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Faktor Risiko</p>
                        <div class="table-responsive">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td class="col-sm-1">No.</td>
                                        <td class="col-sm-7">Pertanyaan</td>
                                        <td class="col-sm-4">Jawaban</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Merokok</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_03" value="ya" <?php if($datapemeriksaan['Merokok'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_03" value="tidak" <?php if($datapemeriksaan['Merokok'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Kurang Aktifitas Fisik</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_04" value="ya" <?php if($datapemeriksaan['AktifitasFisik'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_04" value="tidak" <?php if($datapemeriksaan['AktifitasFisik'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Gula Berlebihan</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_05" value="ya" <?php if($datapemeriksaan['Gula'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_05" value="tidak" <?php if($datapemeriksaan['Gula'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Garam Berlebihan</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_06" value="ya" <?php if($datapemeriksaan['Garam'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_06" value="tidak" <?php if($datapemeriksaan['Garam'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Lemak Berlebihan</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_07" value="ya" <?php if($datapemeriksaan['Lemak'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_07" value="tidak" <?php if($datapemeriksaan['Lemak'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td> Kurang Makan Buah dan Sayur</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_08" value="ya" <?php if($datapemeriksaan['BuahSayur'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_08" value="tidak" <?php if($datapemeriksaan['BuahSayur'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Konsumsi Alkohol</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_09" value="ya" <?php if($datapemeriksaan['Alkohol'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_09" value="tidak" <?php if($datapemeriksaan['Alkohol'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Pemeriksaan Kardiovaskular</p>
                            <div class="table-responsive">
                                <table class="table-konten" width="100%">
                                    <tr>
                                        <td class="col-sm-2">EKG</td>
                                        <td class="col-sm-6">
                                            <textarea name="jantung_10" class="form-control inputan"><?php echo $datapemeriksaan['Ekg'];?></textarea>
                                        </td>
                                        <td class="col-sm-4">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_11" value="ya" <?php if($datapemeriksaan['EkgStatus'] == 'ya'){echo "checked";}?>> Normal
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_11" value="tidak" <?php if($datapemeriksaan['EkgStatus'] == 'tidak'){echo "checked";}?>> Tidak Normal
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-2">Kardiovaskular Rujuk RS</td>
                                        <td class="col-sm-6">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jantung_12" value="ya" <?php if($datapemeriksaan['Kardiovaskular'] == 'ya'){echo "checked";}?>> Rujuk
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="jantung_12" value="tidak" <?php if($datapemeriksaan['Kardiovaskular'] == 'tidak'){echo "checked";}?>> Tidak Rujuk
                                                </label>
                                            </div>
                                        </td>
                                        <td class="col-sm-4">
                                           
                                        </td>
                                    </tr>
                                </table>
                            </div>
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
?>

