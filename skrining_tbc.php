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
            $str = "INSERT INTO `$tbskrining_tbc`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`RiwayatKontak`,`PernahTerdiagnosa`,
            `PernahBerobat`,`Malnutrisi`,`Merokok`,`RiwayatDM`,`ODHIV`,`Lansia`,`IbuHamil`,`WargaBinaanPemasyarakatan`,
            `TinggalWilayahKumuh`,`Abnormalitas`,`Batuk`,`BbTurun`,`Demam`,`Berkeringat`,`PenyakitPernapasan`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$riwayatkontak','$pernahterdiagnosa',
            '$pernahberobat','$malnutrisi','$merokok','$riwayatdm','$odhiv','$lansia','$ibuhamil','$wargabinaan',
            '$tinggalwilayah','$abnormalitas','$batuk','$bbturun','$demam','$berkeringat','$penyakitpernapasan')";
        }else{
            $str = "UPDATE `$tbskrining_tbc` 
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
            echo "document.location.href='index.php?page=skrining_tbc&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_tbc&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }
    }else{

    // tahap 2, cek data skrining_tbc
    $idpasienrj = $_GET['id'];
    $idpasien = $_GET['idps']; 
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_tbc` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_tbc.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">   
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining TBC
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-4">Riwayat Kontak TBC </td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="riwayatkontaktb" value="ya" <?php if($datapemeriksaan['RiwayatKontak'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="riwayatkontaktb" value="tidak" <?php if($datapemeriksaan['RiwayatKontak'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">	
                                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Faktor Resiko</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pernah terdiagnosa / berobat TBC</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_01" value="ya" <?php if($datapemeriksaan['PernahTerdiagnosa'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_01" value="tidak" <?php if($datapemeriksaan['PernahTerdiagnosa'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pernah berobat TBC tapi pernah tidak tuntas</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_02" value="ya" <?php if($datapemeriksaan['PernahBerobat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_02" value="tidak" <?php if($datapemeriksaan['PernahBerobat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Malnutrisi</td>
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
                                    <td>Merokok / Perokok Pasif</td>
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
                                    <td>Riwayat DM / Kencing Manis</td>
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
                                    <td>ODHIV</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_06" value="ya" <?php if($datapemeriksaan['ODHIV'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_06" value="tidak" <?php if($datapemeriksaan['ODHIV'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lansia > 65 tahun</td>
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
                                <tr>
                                    <td>Ibu Hamil</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_08" value="ya" <?php if($datapemeriksaan['IbuHamil'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_08" value="tidak" <?php if($datapemeriksaan['IbuHamil'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Warga Binaan Pemasyarakatan (WBP)</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_09" value="ya" <?php if($datapemeriksaan['WargaBinaanPemasyarakatan'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_09" value="tidak" <?php if($datapemeriksaan['WargaBinaanPemasyarakatan'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tinggal di wilayah padat kumuh miskin</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_10" value="ya" <?php if($datapemeriksaan['TinggalWilayahKumuh'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_10" value="tidak" <?php if($datapemeriksaan['TinggalWilayahKumuh'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Abnormalitas TBC</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="faktor_resiko_11" value="tbc" <?php if($datapemeriksaan['Abnormalitas'] == 'tbc'){echo "checked";}?>> TBC
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_11" value="bukantbc" <?php if($datapemeriksaan['Abnormalitas'] == 'bukantbc'){echo "checked";}?>> Bukan TBC
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="faktor_resiko_11" value="normal" <?php if($datapemeriksaan['Abnormalitas'] == 'normal'){echo "checked";}?>> Normal
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Gejala TBC</p>
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
                                        <td>Batuk (semua bentuk batuk tanpa melihat durasi)</td>
                                        <td>
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
                                        <td>2.</td>
                                        <td>BB turun tanpa penyebab jelas/BB tidak naik/nafsu makan turun</td>
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
                                        <td>3.</td>
                                        <td>Demam yang tidak diketahui penyebabnya</td>
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
                                        <td>4.</td>
                                        <td>Berkeringat malam hari tanpa kegiatan</td>
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
                                </tbody>
                            </table>

                            <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Penyakit Pernapasan</p>
                            <div class="table-responsive">
                                <table class="table-konten" width="100%">
                                    <tr>
                                        <td class="col-sm-4">sebutkan (seperti pilek/flu, sakit tenggorokan dll)</td>
                                        <td class="col-sm-8">
                                            <textarea name="penyakitpernapasan" class="form-control inputan"><?php echo $datapemeriksaan['PenyakitPernapasan'];?></textarea>
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
    $koneksi -> close();
?>

