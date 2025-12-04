<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $MakanManis = $_POST['diabetes_01'];
    $AktifitasFisik = $_POST['diabetes_02'];
    $IstirahatCukup = $_POST['diabetes_03'];
    $RisikoMerokok = $_POST['diabetes_04'];
    $MinumAlkohol = $_POST['diabetes_05'];
    $ObatSteroid = $_POST['diabetes_06'];
    $BeratBadan = $_POST['pemeriksaanfisik_01'];
    $TinggiBadan = $_POST['pemeriksaanfisik_02'];
    $LingkarPerut = $_POST['pemeriksaanfisik_03'];
    $Imt = $_POST['pemeriksaanfisik_04'];
    $StatusObesitas = $_POST['pemeriksaanfisik_05'];
    $StatusGizi = $_POST['pemeriksaanfisik_06'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_diabetes`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`MakanManis`,`AktifitasFisik`,`IstirahatCukup`,`RisikoMerokok`,`MinumAlkohol`,`ObatSteroid`,`BeratBadan`,`TinggiBadan`,`LingkarPerut`,`Imt`,`StatusObesitas`,`StatusGizi`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$MakanManis','$AktifitasFisik','$IstirahatCukup','$RisikoMerokok','$MinumAlkohol','$ObatSteroid','$BeratBadan','$TinggiBadan','$LingkarPerut','$Imt','$StatusObesitas','$StatusGizi')";
        }else{
            $str = "UPDATE `$tbskrining_diabetes` SET `MakanManis`='$MakanManis',`AktifitasFisik`='$AktifitasFisik',`IstirahatCukup`='$IstirahatCukup',`RisikoMerokok`='$RisikoMerokok',`MinumAlkohol`='$MinumAlkohol',`ObatSteroid`='$ObatSteroid',
            `BeratBadan`='$BeratBadan',`TinggiBadan`='$TinggiBadan',`LingkarPerut`='$LingkarPerut',`Imt`='$Imt',`StatusObesitas`='$StatusObesitas',`StatusGizi`='$StatusGizi'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_diabetes&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_diabetes&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_diabetes
    $idpasienrj = $_GET['id'];
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_diabetes` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_diabetes.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>"> 
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Diabetes
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Anamnesis</p>
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
                                        <td>1.</td>
                                        <td>Kebiasaan makan manis ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="diabetes_01" value="ya" <?php if($datapemeriksaan['MakanManis'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="diabetes_01" value="tidak" <?php if($datapemeriksaan['MakanManis'] == 'tidak'){echo "checked";}?>> Tidak
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
                                                    <input type="radio" name="diabetes_02" value="ya" <?php if($datapemeriksaan['AktifitasFisik'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="diabetes_02" value="tidak" <?php if($datapemeriksaan['AktifitasFisik'] == 'tidak'){echo "checked";}?>> Tidak
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
                                                    <input type="radio" name="diabetes_03" value="ya" <?php if($datapemeriksaan['IstirahatCukup'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="diabetes_03" value="tidak" <?php if($datapemeriksaan['IstirahatCukup'] == 'tidak'){echo "checked";}?>> Tidak
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
                                                    <input type="radio" name="diabetes_04" value="ya" <?php if($datapemeriksaan['RisikoMerokok'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="diabetes_04" value="tidak" <?php if($datapemeriksaan['RisikoMerokok'] == 'tidak'){echo "checked";}?>> Tidak
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
                                                    <input type="radio" name="diabetes_05" value="ya" <?php if($datapemeriksaan['MinumAlkohol'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="diabetes_05" value="tidak" <?php if($datapemeriksaan['MinumAlkohol'] == 'tidak'){echo "checked";}?>> Tidak
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
                                                    <input type="radio" name="diabetes_06" value="ya" <?php if($datapemeriksaan['ObatSteroid'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="diabetes_06" value="tidak" <?php if($datapemeriksaan['ObatSteroid'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pemeriksaan Fisik</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="70%">Pemeriksaan</td>
                                        <td width="25%">Hasil</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Berat Badan</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="pemeriksaanfisik_01" class="form-control inputan" value=<?php echo $datapemeriksaan['BeratBadan'];?>>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">kg</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Tinggi Badan</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="pemeriksaanfisik_02" class="form-control inputan" value=<?php echo $datapemeriksaan['TinggiBadan'];?>>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">cm</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Lingkar Perut</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="pemeriksaanfisik_03" class="form-control inputan" value=<?php echo $datapemeriksaan['LingkarPerut'];?>>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">cm</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>IMT (BB/TB2)</td>
                                        <td>
                                            <input type="text" name="pemeriksaanfisik_04" class="form-control inputan" value=<?php echo $datapemeriksaan['Imt'];?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Status Obesitas Sentral</td>
                                        <td>
                                            <input type="text" name="pemeriksaanfisik_05" class="form-control inputan" value=<?php echo $datapemeriksaan['StatusObesitas'];?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Kategori Status Gizi</td>
                                        <td>
                                            <div class="input-group">
                                                <select name="pemeriksaanfisik_06" class="form-control inputan">
                                                    <option value="">--Pilih--</option>
                                                    <option value="Gizi Kurang" <?php if($datapemeriksaan['StatusGizi'] == 'Gizi Kurang'){echo "selected";}?>>Gizi Kurang</option>
                                                    <option value="Gizi Baik" <?php if($datapemeriksaan['StatusGizi'] == 'Gizi Baik'){echo "selected";}?>>Gizi Baik</option>
                                                    <option value="Gizi Lebih" <?php if($datapemeriksaan['StatusGizi'] == 'Gizi Lebih'){echo "selected";}?>>Gizi Lebih</option>
                                                    <option value="Obesitas" <?php if($datapemeriksaan['StatusGizi'] == 'Obesitas'){echo "selected";}?>>Obesitas</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Pilih</span>
                                                </div>
                                            </div>	
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
