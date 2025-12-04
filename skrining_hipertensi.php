<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $RiwayatHipertensi = $_POST['hipertensi_01'];
    $RiwayatKeluarga = $_POST['hipertensi_02'];
    $RiwayatMerokok = $_POST['hipertensi_03'];
    $RiwayatAlkohol = $_POST['hipertensi_04'];
    $RiwayatMakanAsin = $_POST['hipertensi_05'];
    $AktifitasFisik = $_POST['hipertensi_06'];
    $IstirahatCukup = $_POST['hipertensi_07'];
    $KurangMakanBuah = $_POST['hipertensi_08'];
    $Sistole = $_POST['pemeriksaanfisik_01'];
    $Diastole = $_POST['pemeriksaanfisik_02'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_hipertensi`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`RiwayatHipertensi`,`RiwayatKeluarga`,`RiwayatMerokok`,`RiwayatAlkohol`,`RiwayatMakanAsin`,`AktifitasFisik`,`IstirahatCukup`,`KurangMakanBuah`,`Sistole`,`Diastole`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$RiwayatHipertensi','$RiwayatKeluarga','$RiwayatMerokok','$RiwayatAlkohol','$RiwayatMakanAsin','$AktifitasFisik','$IstirahatCukup','$KurangMakanBuah','$Sistole','$Diastole')";
        }else{
            $str = "UPDATE `$tbskrining_hipertensi` SET `RiwayatHipertensi`='$RiwayatHipertensi',`RiwayatKeluarga`='$RiwayatKeluarga',`RiwayatMerokok`='$RiwayatMerokok',`RiwayatAlkohol`='$RiwayatAlkohol',`RiwayatMakanAsin`='$RiwayatMakanAsin',
            `AktifitasFisik`='$AktifitasFisik',`IstirahatCukup`='$IstirahatCukup',`KurangMakanBuah`='$KurangMakanBuah',`Sistole`='$Sistole',`Diastole`='$Diastole'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_hipertensi&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_hipertensi&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_hipertensi
    $idpasienrj = $_GET['id'];
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_hipertensi` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_hipertensi.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">  
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Hipertensi
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
                                        <td>Riwayat Pribadi Hipertensi ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hipertensi_01" value="ya" <?php if($datapemeriksaan['RiwayatHipertensi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hipertensi_01" value="tidak" <?php if($datapemeriksaan['RiwayatHipertensi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Riwayat keluarga Tekanan Darah Tinggi ( Hipertensi) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hipertensi_02" value="ya" <?php if($datapemeriksaan['RiwayatKeluarga'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hipertensi_02" value="tidak" <?php if($datapemeriksaan['RiwayatKeluarga'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Riwayat Merokok ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hipertensi_03" value="ya" <?php if($datapemeriksaan['RiwayatMerokok'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hipertensi_03" value="tidak" <?php if($datapemeriksaan['RiwayatMerokok'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Riwayat Minum alkohol / Merokok di Keluarga ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hipertensi_04" value="ya" <?php if($datapemeriksaan['RiwayatAlkohol'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hipertensi_04" value="tidak" <?php if($datapemeriksaan['RiwayatAlkohol'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Kebiasaan makan asin ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hipertensi_05" value="ya" <?php if($datapemeriksaan['RiwayatMakanAsin'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hipertensi_05" value="tidak" <?php if($datapemeriksaan['RiwayatMakanAsin'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Aktifitas fisik setiap hari ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hipertensi_06" value="ya" <?php if($datapemeriksaan['AktifitasFisik'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hipertensi_06" value="tidak" <?php if($datapemeriksaan['AktifitasFisik'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Istirahat cukup ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hipertensi_07" value="ya" <?php if($datapemeriksaan['IstirahatCukup'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hipertensi_07" value="tidak" <?php if($datapemeriksaan['IstirahatCukup'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8.</td>
                                        <td>Kurang Makan Buah dan Sayur ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hipertensi_08" value="ya" <?php if($datapemeriksaan['KurangMakanBuah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hipertensi_08" value="tidak" <?php if($datapemeriksaan['KurangMakanBuah'] == 'tidak'){echo "checked";}?>> Tidak
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
                                        <td>Sistole</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="pemeriksaanfisik_01" class="form-control inputan" value="<?php echo $datapemeriksaan['Sistole'];?>" maxlength="20" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">mmHg</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Diastole</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="pemeriksaanfisik_02" class="form-control inputan" value="<?php echo $datapemeriksaan['Diastole'];?>" maxlength="20" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">mmHg</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>   
                        </div>
                        <div class="formbg mt-2">
                            <p>
                                <b>Klasifikasi HT</b><br/>
                                -
                            </p>
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
