<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $MudahLelah = $_POST['thalasemia_01'];
    $KonsumsiSayur = $_POST['thalasemia_02'];
    $KonsumsiProtein = $_POST['thalasemia_03'];
    $KonsumsiTambahDarah = $_POST['thalasemia_04'];
    $KelainanDarah = $_POST['thalasemia_05'];
    $RiwayatKeluarga = $_POST['thalasemia_06'];
    $RiwayatTransfusi = $_POST['thalasemia_07'];
    $TandaKlinisAnemia = $_POST['thalasemia_08'];
    $PemeriksaanHb = $_POST['thalasemia_09'];
    $PemeriksaanMcv = $_POST['thalasemia_10'];
    $PemeriksaanMch = $_POST['thalasemia_11'];
    $HasilSkrining = $_POST['thalasemia_12'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_thalasemia`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`MudahLelah`,`KonsumsiSayur`,
            `KonsumsiProtein`,`KonsumsiTambahDarah`,`KelainanDarah`,`RiwayatKeluarga`,`RiwayatTransfusi`,
            `TandaKlinisAnemia`,`PemeriksaanHb`,`PemeriksaanMcv`,`PemeriksaanMch`,`HasilSkrining`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$MudahLelah','$KonsumsiSayur',
            '$KonsumsiProtein','$KonsumsiTambahDarah','$KelainanDarah','$RiwayatKeluarga','$RiwayatTransfusi',
            '$TandaKlinisAnemia','$PemeriksaanHb','$PemeriksaanMcv','$PemeriksaanMch','$HasilSkrining')";
        }else{
            $str = "UPDATE `$tbskrining_thalasemia` 
            `MudahLelah`='$MudahLelah',`KonsumsiSayur`='$KonsumsiSayur',
            `KonsumsiProtein`='$KonsumsiProtein',`KonsumsiTambahDarah`='$KonsumsiTambahDarah',
            `KelainanDarah`='$KelainanDarah',`RiwayatKeluarga`='$RiwayatKeluarga',
            `RiwayatTransfusi`='$RiwayatTransfusi',`TandaKlinisAnemia`='$TandaKlinisAnemia',
            `PemeriksaanHb`='$PemeriksaanHb',`PemeriksaanMcv`='$PemeriksaanMcv',
            `PemeriksaanMch`='$PemeriksaanMch',`HasilSkrining`='$HasilSkrining'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_thalasemia&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_thalasemia&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_thalasemia
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_thalasemia` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_thalasemia.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">   
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Kesehatan Jiwa Dewasa dan Lansia (PHQ-4)
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Patient Health Questionnaire-2 (PHQ-2)</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="65%">Pertanyaan</td>
                                        <td width="20%">Jawaban</td>
                                        <td width="10%">Skor</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Dalam 2 minggu terakhir, seberapa sering anda kurang/tidak bersemangat dalam melakukan kegiatan sehari-hari?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Tidak sama sekali" <?php if($datapemeriksaan['MudahLelah'] == 'Tidak sama sekali'){echo "checked";}?>> Tidak sama sekali
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Kurang dari 1 (satu) minggu" <?php if($datapemeriksaan['MudahLelah'] == 'Kurang dari 1 (satu) minggu'){echo "checked";}?>> Kurang dari 1 (satu) minggu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Lebih dari 1 (satu) minggu" <?php if($datapemeriksaan['MudahLelah'] == 'Lebih dari 1 (satu) minggu'){echo "checked";}?>> Lebih dari 1 (satu) minggu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Hampir setiap hari" <?php if($datapemeriksaan['MudahLelah'] == 'Hampir setiap hari'){echo "checked";}?>> Hampir setiap hari
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Dalam 2 minggu terakhir, seberapa sering anda merasa murung, tertekan, atau putus asa?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Tidak sama sekali" <?php if($datapemeriksaan['MudahLelah'] == 'Tidak sama sekali'){echo "checked";}?>> Tidak sama sekali
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Kurang dari 1 (satu) minggu" <?php if($datapemeriksaan['MudahLelah'] == 'Kurang dari 1 (satu) minggu'){echo "checked";}?>> Kurang dari 1 (satu) minggu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Lebih dari 1 (satu) minggu" <?php if($datapemeriksaan['MudahLelah'] == 'Lebih dari 1 (satu) minggu'){echo "checked";}?>> Lebih dari 1 (satu) minggu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Hampir setiap hari" <?php if($datapemeriksaan['MudahLelah'] == 'Hampir setiap hari'){echo "checked";}?>> Hampir setiap hari
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>                                    
                                </tbody>
                            </table>                            
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Generalized Anxiety Disorder-2 (GAD-2)</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="65%">Pertanyaan</td>
                                        <td width="20%">Jawaban</td>
                                        <td width="10%">Skor</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Dalam 2 minggu terakhir, seberapa sering anda merasa gugup, cemas, atau gelisah?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Tidak sama sekali" <?php if($datapemeriksaan['MudahLelah'] == 'Tidak sama sekali'){echo "checked";}?>> Tidak sama sekali
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Kurang dari 1 (satu) minggu" <?php if($datapemeriksaan['MudahLelah'] == 'Kurang dari 1 (satu) minggu'){echo "checked";}?>> Kurang dari 1 (satu) minggu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Lebih dari 1 (satu) minggu" <?php if($datapemeriksaan['MudahLelah'] == 'Lebih dari 1 (satu) minggu'){echo "checked";}?>> Lebih dari 1 (satu) minggu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Hampir setiap hari" <?php if($datapemeriksaan['MudahLelah'] == 'Hampir setiap hari'){echo "checked";}?>> Hampir setiap hari
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Dalam 2 minggu terakhir, seberapa sering anda tidak mampu mengendalikan rasa khawatir?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Tidak sama sekali" <?php if($datapemeriksaan['MudahLelah'] == 'Tidak sama sekali'){echo "checked";}?>> Tidak sama sekali
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Kurang dari 1 (satu) minggu" <?php if($datapemeriksaan['MudahLelah'] == 'Kurang dari 1 (satu) minggu'){echo "checked";}?>> Kurang dari 1 (satu) minggu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Lebih dari 1 (satu) minggu" <?php if($datapemeriksaan['MudahLelah'] == 'Lebih dari 1 (satu) minggu'){echo "checked";}?>> Lebih dari 1 (satu) minggu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="thalasemia_01" value="Hampir setiap hari" <?php if($datapemeriksaan['MudahLelah'] == 'Hampir setiap hari'){echo "checked";}?>> Hampir setiap hari
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>                                    
                                </tbody>
                            </table>                            
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Hasil Skrining</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-3">Hasil<br/>
                                    <td class="col-sm-9">
                                        <select name="skrining" class="form-control inputan" required>
                                            <option value="">Pilih</option>
                                            <option value="normal" <?php if($datapemeriksaan['HasilSkrining'] == 'normal'){echo "selected";}?>>Normal</option>
                                            <option value="suspek" <?php if($datapemeriksaan['HasilSkrining'] == 'suspek'){echo "selected";}?>>Suspek</option>
                                        </select>
                                    </td>
                                </tr>
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
