<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";   

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $MakanManis = $_POST['obesitas_01'];
    $AktifitasFisik = $_POST['obesitas_02'];
    $IstirahatCukup = $_POST['obesitas_03'];
    $Merokok = $_POST['obesitas_04'];
    $MinumAlkohol = $_POST['obesitas_05'];
    $ObatSteroid = $_POST['obesitas_06'];
    $BeratBadan = $_POST['obesitas_07'];
    $TinggiBadan = $_POST['obesitas_08'];
    $LingkarPerut = $_POST['obesitas_09'];
    $Imt = $_POST['obesitas_10'];
    $StatusObesitasSentral = $_POST['obesitas_11'];
    $KategoriStatusGizi = $_POST['obesitas_12'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_obesitas`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`MakanManis`,`AktifitasFisik`,
            `IstirahatCukup`,`Merokok`,`MinumAlkohol`,`ObatSteroid`,`BeratBadan`,`TinggiBadan`,
            `LingkarPerut`,`Imt`,`StatusObesitasSentral`,`KategoriStatusGizi`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$MakanManis','$AktifitasFisik',
            '$IstirahatCukup','$Merokok','$MinumAlkohol','$ObatSteroid','$BeratBadan','$TinggiBadan',
            '$LingkarPerut','$Imt','$StatusObesitasSentral','$KategoriStatusGizi')";
        }else{
            $str = "UPDATE `$tbskrining_obesitas` 
            SET `MakanManis`='$MakanManis',`AktifitasFisik`='$AktifitasFisik',
            `IstirahatCukup`='$IstirahatCukup',`Merokok`='$Merokok',
            `MinumAlkohol`='$MinumAlkohol',`ObatSteroid`='$ObatSteroid',
            `BeratBadan`='$BeratBadan',`TinggiBadan`='$TinggiBadan',
            `LingkarPerut`='$LingkarPerut',`Imt`='$Imt',
            `StatusObesitasSentral`='$StatusObesitasSentral',`KategoriStatusGizi`='$KategoriStatusGizi'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_obesitas&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_obesitas&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_obesitas
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_obesitas` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_obesitas.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">  
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>"> 
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Obesitas
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pertanyaan Awal</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="75%">Pertanyaan</td>
                                        <td width="20%">Jawaban</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Kebiasaan makan manis ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="obesitas_01" value="ya" <?php if($datapemeriksaan['MakanManis'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="obesitas_01" value="tidak" <?php if($datapemeriksaan['MakanManis'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Aktifitas fisik setiap hari ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="obesitas_02" value="ya" <?php if($datapemeriksaan['AktifitasFisik'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="obesitas_02" value="tidak" <?php if($datapemeriksaan['AktifitasFisik'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Istirahat cukup ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="obesitas_03" value="ya" <?php if($datapemeriksaan['IstirahatCukup'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="obesitas_03" value="tidak" <?php if($datapemeriksaan['IstirahatCukup'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Risiko Merokok ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="obesitas_04" value="ya" <?php if($datapemeriksaan['RisikoMerokok'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="obesitas_04" value="tidak" <?php if($datapemeriksaan['RisikoMerokok'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Riwayat Minum alkohol / Merokok di Keluarga ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="obesitas_05" value="ya" <?php if($datapemeriksaan['KelainanDarah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="obesitas_05" value="tidak" <?php if($datapemeriksaan['KelainanDarah'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Riwayat penggunaan obat-obatan steroid ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="obesitas_06" value="ya" <?php if($datapemeriksaan['Thalasemia'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="obesitas_06" value="tidak" <?php if($datapemeriksaan['Thalasemia'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Pemeriksaan Fisik</p>
                        <div class="table-responsive">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="50%">Pemeriksaan</td>
                                        <td width="45%">Hasil</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Berat Badan</td>
                                        <td>
                                            <input type="text" name="obesitas_07" class="form-control inputan" value="<?php echo $datapemeriksaan['PemeriksaanMch'];?>" maxlength="20" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Tinggi Badan</td>
                                        <td>
                                            <input type="text" name="obesitas_08" class="form-control inputan" value="<?php echo $datapemeriksaan['PemeriksaanMch'];?>" maxlength="20" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Lingkar Perut</td>
                                        <td>
                                            <input type="text" name="obesitas_09" class="form-control inputan" value="<?php echo $datapemeriksaan['PemeriksaanMch'];?>" maxlength="20" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>IMT (BB/TB2)</td>
                                        <td>
                                            <input type="text" name="obesitas_10" class="form-control inputan" value="<?php echo $datapemeriksaan['PemeriksaanMch'];?>" maxlength="20" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Status Obesitas Sentral</td>
                                        <td>
                                            <input type="text" name="obesitas_11" class="form-control inputan" value="<?php echo $datapemeriksaan['PemeriksaanMch'];?>" maxlength="20" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Kategori Status Gizi</td>
                                        <td>
                                            <select name="obesitas_12" class="form-control inputan" required>
                                                <option value="">Pilih</option>
                                                <option value="Gizi Kurang" <?php if($datapemeriksaan['HasilSkrining'] == 'Gizi Kurang'){echo "selected";}?>>Gizi Kurang</option>
                                                <option value="Gizi Baik" <?php if($datapemeriksaan['HasilSkrining'] == 'Gizi Baik'){echo "selected";}?>>Gizi Baik</option>
                                                <option value="Gizi Lebih" <?php if($datapemeriksaan['HasilSkrining'] == 'Gizi Lebih'){echo "selected";}?>>Gizi Lebih</option>
                                                <option value="Obesitas" <?php if($datapemeriksaan['HasilSkrining'] == 'Obesitas'){echo "selected";}?>>Obesitas</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
