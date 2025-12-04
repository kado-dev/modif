<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $MerasaLelah = $_POST['anemia_01'];
    $KonsumsiSayur = $_POST['anemia_02'];
    $KonsumsiProtein = $_POST['anemia_03'];
    $MasalahPubertas = $_POST['anemia_04'];
    $RisikoIms = $_POST['anemia_05'];
    $KekerasanSeksual = $_POST['anemia_06'];
    $Menstruasi = $_POST['anemia_07'];
    $GangguanMenstruasi = $_POST['anemia_08'];
    $TabletTambahDarah = $_POST['anemia_09'];
    $KelainanDarah = $_POST['anemia_10'];
    $Thalasemia = $_POST['anemia_11'];
    $Rambut = $_POST['anemia_12'];
    $Kulit = $_POST['anemia_13'];
    $Suntikan = $_POST['anemia_14'];
    $Kuku = $_POST['anemia_15'];
    $TandaKlinisAnemia = $_POST['anemia_16'];
    $PemeriksaanHb = $_POST['anemia_17'];
    $KadarHemoglobin = $_POST['anemia_18'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_anemia`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`MerasaLelah`, `KonsumsiSayur`, 
            `KonsumsiProtein`, `MasalahPubertas`, `RisikoIms`, `KekerasanSeksual`, `Menstruasi`, `GangguanMenstruasi`, 
            `TabletTambahDarah`, `KelainanDarah`, `Thalasemia`, `Rambut`, `Kulit`, `Suntikan`, `Kuku`, 
            `TandaKlinisAnemia`, `PemeriksaanHb`, `KadarHemoglobin`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$MerasaLelah','$KonsumsiSayur',
            '$KonsumsiProtein','$MasalahPubertas','$RisikoIms','$KekerasanSeksual','$Menstruasi','$GangguanMenstruasi',
            '$TabletTambahDarah','$KelainanDarah','$Thalasemia','$Rambut','$Kulit','$Suntikan','$Kuku',
            '$TandaKlinisAnemia','$PemeriksaanHb','$KadarHemoglobin')";
        }else{
            $str = "UPDATE `$tbskrining_anemia` SET `MerasaLelah`='$MerasaLelah',`KonsumsiSayur`='$KonsumsiSayur',
            `KonsumsiProtein`='$KonsumsiProtein',`MasalahPubertas`='$MasalahPubertas',`RisikoIms`='$RisikoIms',
            `KekerasanSeksual`='$KekerasanSeksual',`Menstruasi`='$Menstruasi',`GangguanMenstruasi`='$GangguanMenstruasi',
            `TabletTambahDarah`='$TabletTambahDarah',`KelainanDarah`='$KelainanDarah',`Thalasemia`='$Thalasemia',
            `Rambut`='$Rambut',`Kulit`='$Kulit',`Kulit`='$Kulit',`Suntikan`='$Suntikan',`Kuku`='$Kuku',
            `TandaKlinisAnemia`='$TandaKlinisAnemia',`PemeriksaanHb`='$PemeriksaanHb',`KadarHemoglobin`='$KadarHemoglobin'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_anemia&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_anemia&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_anemia
    $idpasienrj = $_GET['id'];
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_anemia` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_anemia.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">  
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">                
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">                
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Anemia</p>
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
                                        <td>Apakah Anda sering merasa mudah lelah, letih, lesu, lunglai, lalai (sering lupa) atau sakit kepala ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_01" value="ya" <?php if($datapemeriksaan['MerasaLelah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_01" value="tidak" <?php if($datapemeriksaan['MerasaLelah'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Apakah Anda mengkonsumsi sayur dan buah setiap hari ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_02" value="ya" <?php if($datapemeriksaan['KonsumsiSayur'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_02" value="tidak" <?php if($datapemeriksaan['KonsumsiSayur'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Apakah Anda sering mengkonsumsi protein hewani ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_03" value="ya" <?php if($datapemeriksaan['KonsumsiProtein'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_03" value="tidak" <?php if($datapemeriksaan['KonsumsiProtein'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan='6'>4</td>
                                        <td><b>Kesehatan Reproduksi</b></td>
                                        <td>
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Masalah Pubertas ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_04" value="ya" <?php if($datapemeriksaan['MasalahPubertas'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_04" value="tidak" <?php if($datapemeriksaan['MasalahPubertas'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Risiko IMS ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_05" value="ya" <?php if($datapemeriksaan['RisikoIms'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_05" value="tidak" <?php if($datapemeriksaan['RisikoIms'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Risiko Kekerasan Seksual ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_06" value="ya" <?php if($datapemeriksaan['KekerasanSeksual'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_06" value="tidak" <?php if($datapemeriksaan['KekerasanSeksual'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apakah Anda sudah mengalami menstruasi ? (Rematri SMP dan SMA) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_07" value="ya" <?php if($datapemeriksaan['Menstruasi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_07" value="tidak" <?php if($datapemeriksaan['Menstruasi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gangguan Menstruasi ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_08" value="ya" <?php if($datapemeriksaan['GangguanMenstruasi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_08" value="tidak" <?php if($datapemeriksaan['GangguanMenstruasi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Apakah Anda rutin mengkonsumsi Tablet Tambah Darah ? (Rematri SMP dan SMA) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_09" value="ya" <?php if($datapemeriksaan['TabletTambahDarah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_09" value="tidak" <?php if($datapemeriksaan['TabletTambahDarah'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Apakah Anda memiliki riwayat penyakit kelainan darah ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_10" value="ya" <?php if($datapemeriksaan['KelainanDarah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_10" value="tidak" <?php if($datapemeriksaan['KelainanDarah'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Apakah di keluarga Anda ada yang menderita Thalasemia ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_11" value="ya" <?php if($datapemeriksaan['Thalasemia'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_11" value="tidak" <?php if($datapemeriksaan['Thalasemia'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan='5'>8.</td>
                                        <td><b>Pemeriksaan Kebersihan Diri</b></td>
                                        <td>
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rambut ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_12" value="sehat" <?php if($datapemeriksaan['Rambut'] == 'sehat'){echo "checked";}?>> Sehat
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_12" value="tidaksehat" <?php if($datapemeriksaan['Rambut'] == 'tidaksehat'){echo "checked";}?>> Tidak Sehat
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kulit ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_13" value="sehat" <?php if($datapemeriksaan['Kulit'] == 'sehat'){echo "checked";}?>> Sehat
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_13" value="tidaksehat" <?php if($datapemeriksaan['Kulit'] == 'tidaksehat'){echo "checked";}?>> Tidak Sehat
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kulit Ada Bekas Suntikan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_14" value="ya" <?php if($datapemeriksaan['Suntikan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_14" value="tidak" <?php if($datapemeriksaan['Suntikan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kuku ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_15" value="sehat" <?php if($datapemeriksaan['Kuku'] == 'sehat'){echo "checked";}?>> Sehat
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_15" value="tidaksehat" <?php if($datapemeriksaan['Kuku'] == 'tidaksehat'){echo "checked";}?>> Tidak Sehat
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
                                        <td width="70%">Pertanyaan</td>
                                        <td width="25%">Jawaban</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Tanda Klinis anemia (Pucat Pada Bagian Konjungtiva/Kelopak Mata Bag. Dalam Bawah, Bibir, Lidah, Telapak Tangan)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="anemia_16" value="ya" <?php if($datapemeriksaan['TandaKlinisAnemia'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="anemia_16" value="tidak" <?php if($datapemeriksaan['TandaKlinisAnemia'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pemeriksaan Penunjang</p>
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
                                        <td>Pemeriksaan HB</td>
                                        <td>
                                            <div class="input-group">
                                                <input type ="text" name ="anemia_17" class="sistole form-control inputan onfocusoutvalidation" maxlength="10" value="<?php echo $datapemeriksaan['PemeriksaanHb'];?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">mg/dL</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                        <div class="formbg mt-4">
                            <p>
                                <b>Kadar Hemoglobin</b><br/>
                            </p>
                            <div class="input-group">
                                <select name="anemia_18" class="form-control inputan " required>
                                    <option value="">--Pilih--</option>
                                    <option value="≥ 12 g/dl" <?php if($datapemeriksaan['KadarHemoglobin'] == '≥ 12 g/dl'){echo "selected";}?>>≥ 12 g/dl</option>
                                    <option value="11,9-11 g/dl" <?php if($datapemeriksaan['KadarHemoglobin'] == '11,9-11 g/dl'){echo "selected";}?>>11,9-11 g/dl</option>
                                    <option value="10.9-8 g/dl" <?php if($datapemeriksaan['KadarHemoglobin'] == '10.9-8 g/dl'){echo "selected";}?>>10.9-8 g/dl</option>
                                    <option value="< 8 g/dl" <?php if($datapemeriksaan['KadarHemoglobin'] == '< 8 g/dl'){echo "selected";}?>>< 8 g/dl</option>
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
