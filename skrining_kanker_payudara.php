<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $RiwayatPenyakitKeluarga = $_POST['payudara_01'];
    $RiwayatPenyakitDiriSendiri = $_POST['payudara_02'];
    $Merokok = $_POST['payudara_03'];
    $KurangAktifitas = $_POST['payudara_04'];
    $GulaBerlebihan = $_POST['payudara_05'];
    $GaramBerlebihan = $_POST['payudara_06'];
    $LemakBerlebihan = $_POST['payudara_07'];
    $KurangMakanBuah = $_POST['payudara_08'];
    $KonsumsiAlkohol = $_POST['payudara_09'];
    $HasilSadanis = $_POST['payudara_10'];
    $TindakanSadanis = $_POST['payudara_11'];
    $HasilSadanisUsg = $_POST['payudara_12'];
    $HasilSkrining = $_POST['hasilskrining'];    
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_kanker_payudara`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,
            `RiwayatPenyakitKeluarga`,`RiwayatPenyakitDiriSendiri`,`Merokok`,
            `KurangAktifitas`,`GulaBerlebihan`,`GaramBerlebihan`,
            `LemakBerlebihan`,`KurangMakanBuah`,`KonsumsiAlkohol`,
            `HasilSadanis`,`TindakanSadanis`,`HasilSadanisUsg`,
            `HasilSkrining`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$RiwayatPenyakitKeluarga','$RiwayatPenyakitDiriSendiri',
            '$Merokok','$KurangAktifitas','$GulaBerlebihan','$GaramBerlebihan',
            '$LemakBerlebihan','$KurangMakanBuah','$KonsumsiAlkohol','$HasilSadanis',
            '$TindakanSadanis','$HasilSadanisUsg','$HasilSkrining')";
        }else{
            $str = "UPDATE `$tbskrining_kanker_payudara` 
            SET `RiwayatPenyakitKeluarga`='$RiwayatPenyakitKeluarga',`RiwayatPenyakitDiriSendiri`='$RiwayatPenyakitDiriSendiri',
            `Merokok`='$Merokok',`KurangAktifitas`='$KurangAktifitas',`GulaBerlebihan`='$GulaBerlebihan',
            `GaramBerlebihan`='$GaramBerlebihan',`LemakBerlebihan`='$LemakBerlebihan',`KurangMakanBuah`='$KurangMakanBuah',
            `KonsumsiAlkohol`='$KonsumsiAlkohol',`HasilSadanis`='$HasilSadanis',`TindakanSadanis`='$TindakanSadanis',
            `HasilSadanisUsg`='$HasilSadanisUsg',`HasilSkrining`='$HasilSkrining'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kanker_payudara&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kanker_payudara&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_wast
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_kanker_payudara` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_kanker_payudara.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>"> 
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">  
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Risiko Kanker Payudara
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Riwayat Penyakit</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-4">Riwayat Penyakit Keluarga </td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="payudara_01" value="Kanker" <?php if($datapemeriksaan['RiwayatPenyakitKeluarga'] == 'Kanker'){echo "checked";}?>> Kanker
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="payudara_01" value="Benjolan Abnormal Pada Payudara" <?php if($datapemeriksaan['RiwayatPenyakitKeluarga'] == 'Benjolan Abnormal Pada Payudara'){echo "checked";}?>> Benjolan Abnormal Pada Payudara
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-4">Riwayat Penyakit Diri Sendiri </td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="payudara_02" value="Kanker" <?php if($datapemeriksaan['RiwayatPenyakitDiriSendiri'] == 'Kanker'){echo "checked";}?>> Kanker
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="payudara_02" value="Benjolan Abnormal Pada Payudara" <?php if($datapemeriksaan['RiwayatPenyakitDiriSendiri'] == 'Benjolan Abnormal Pada Payudara'){echo "checked";}?>> Benjolan Abnormal Pada Payudara
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Faktor Risiko</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="70%">Pertanyaan</td>
                                        <td width="25%">Jawaban</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>#</b></td>
                                        <td><b>Pilih semua jawaban</b></td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="pilihsemua" value="ya"> <b>Ya</b>
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="pilihsemua" value="tidak"> <b>Tidak</b>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Merokok ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="payudara_03" value="ya" <?php if($datapemeriksaan['Merokok'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="payudara_03" value="tidak" <?php if($datapemeriksaan['Merokok'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Kurang Aktifitas Fisik ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="payudara_04" value="ya" <?php if($datapemeriksaan['KurangAktifitas'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="payudara_04" value="tidak" <?php if($datapemeriksaan['KurangAktifitas'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Gula Berlebihan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="payudara_05" value="ya" <?php if($datapemeriksaan['GulaBerlebihan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="payudara_05" value="tidak" <?php if($datapemeriksaan['GulaBerlebihan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Garam Berlebihan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="payudara_06" value="ya" <?php if($datapemeriksaan['GaramBerlebihan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="payudara_06" value="tidak" <?php if($datapemeriksaan['GaramBerlebihan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Lemak Berlebihan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="payudara_07" value="ya" <?php if($datapemeriksaan['LemakBerlebihan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="payudara_07" value="tidak" <?php if($datapemeriksaan['LemakBerlebihan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Kurang Makan Buah dan Sayur ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="payudara_08" value="ya" <?php if($datapemeriksaan['KurangMakanBuah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="payudara_08" value="tidak" <?php if($datapemeriksaan['KurangMakanBuah'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Konsumsi Alkohol ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="payudara_09" value="ya" <?php if($datapemeriksaan['KonsumsiAlkohol'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="payudara_09" value="tidak" <?php if($datapemeriksaan['KonsumsiAlkohol'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pemeriksaan Sadanis</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-4">Hasil Sadanis </td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="payudara_10" value="Normal" <?php if($datapemeriksaan['HasilSadanis'] == 'Normal'){echo "checked";}?>> Normal
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="payudara_10" value="Ditemukan Benjolan" <?php if($datapemeriksaan['HasilSadanis'] == 'Ditemukan Benjolan'){echo "checked";}?>> Ditemukan Benjolan
                                            </label> &nbsp &nbsp
                                            <label>
                                                <input type="radio" name="payudara_10" value="Curiga Kanker" <?php if($datapemeriksaan['HasilSadanis'] == 'Curiga Kanker'){echo "checked";}?>> Curiga Kanker
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-4">Tindakan Sadanis </td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="payudara_11" value="Rujuk" <?php if($datapemeriksaan['TindakanSadanis'] == 'Rujuk'){echo "checked";}?>> Rujuk
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="payudara_11" value="Tidak Rujuk" <?php if($datapemeriksaan['TindakanSadanis'] == 'Tidak Rujuk'){echo "checked";}?>> Tidak Rujuk
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pemeriksaan Usg</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-4">Hasil Sadanis </td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="payudara_12" value="Normal" <?php if($datapemeriksaan['HasilSadanisUsg'] == 'Normal'){echo "checked";}?>> Normal
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="payudara_12" value="Simple Cyst" <?php if($datapemeriksaan['HasilSadanisUsg'] == 'Simple Cyst'){echo "checked";}?>> Simple Cyst
                                            </label> &nbsp &nbsp
                                            <label>
                                                <input type="radio" name="payudara_12" value="Non Simple Cyst" <?php if($datapemeriksaan['HasilSadanisUsg'] == 'Non Simple Cyst'){echo "checked";}?>> Non Simple Cyst
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="formbg mt-4">
                            <p>
                                <b>Hasil Skrining</b><br/>
                            </p>
                            <div class="input-group">
                                <select name="hasilskrining" class="form-control inputan" required>
                                    <option value="">--Pilih--</option>
                                    <option value="Normal" <?php if($datapemeriksaan['HasilSkrining'] == 'Normal'){echo "selected";}?>>Normal</option>
                                    <option value="Kemungkinan Kelainan Payudara Jinak" <?php if($datapemeriksaan['HasilSkrining'] == 'Kemungkinan Kelainan Payudara Jinak'){echo "selected";}?>>Kemungkinan Kelainan Payudara Jinak</option>
                                    <option value="Curiga Kelainan Payudara Ganas" <?php if($datapemeriksaan['HasilSkrining'] == 'Curiga Kelainan Payudara Ganas'){echo "selected";}?>>Curiga Kelainan Payudara Ganas</option>
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text">Pilih</span>
                                </div>
                            </div>	
                        </div>
                        <br/>
                        <button type="submit" name="btnsimpan" value="simpan" class="btn btn-round btn-success btnsimpan">Simpan Pemeriksaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    }
?>
