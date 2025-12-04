<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['mentaltest_01'])) {$RangsangBab = $_POST['mentaltest_01'];} else {$RangsangBab = "";}
    if (isset($_POST['mentaltest_02'])) {$RangsangBak = $_POST['mentaltest_02'];} else {$RangsangBak = "";}
    if (isset($_POST['mentaltest_03'])) {$MembersihkanDiri = $_POST['mentaltest_03'];} else {$MembersihkanDiri = "";}
    if (isset($_POST['mentaltest_04'])) {$PenggunaanWc = $_POST['mentaltest_04'];} else {$PenggunaanWc = "";}
    if (isset($_POST['mentaltest_05'])) {$MakanMinum = $_POST['mentaltest_05'];} else {$MakanMinum = "";}
    if (isset($_POST['mentaltest_06'])) {$Bergerak = $_POST['mentaltest_06'];} else {$Bergerak = "";}
    if (isset($_POST['mentaltest_07'])) {$Berjalan = $_POST['mentaltest_07'];} else {$Berjalan = "";}
    if (isset($_POST['mentaltest_08'])) {$Berpakain = $_POST['mentaltest_08'];} else {$Berpakain = "";}
    if (isset($_POST['mentaltest_09'])) {$NaikTurunTangga = $_POST['mentaltest_09'];} else {$NaikTurunTangga = "";}
    if (isset($_POST['mentaltest_10'])) {$Mandi = $_POST['mentaltest_10'];} else {$Mandi = "";}
 
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_adl`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`RangsangBab`,`RangsangBak`,`MembersihkanDiri`,`PenggunaanWc`,`MakanMinum`,`Bergerak`,`Berjalan`,`Berpakain`,`NaikTurunTangga`,`Mandi`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$RangsangBab','$RangsangBak','$MembersihkanDiri','$PenggunaanWc','$MakanMinum','$Bergerak','$Berjalan','$Berpakain','$NaikTurunTangga','$Mandi')";
        }else{
            $str = "UPDATE `$tbskrining_adl` 
            SET `RangsangBab`='$RangsangBab',
            `RangsangBak`='$RangsangBak',
            `MembersihkanDiri`='$MembersihkanDiri',
            `PenggunaanWc`='$PenggunaanWc',
            `MakanMinum`='$MakanMinum',
            `Bergerak`='$Bergerak',
            `Berjalan`='$Berjalan',
            `Berpakain`='$Berpakain',
            `NaikTurunTangga`='$NaikTurunTangga',
            `Mandi`='$Mandi'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        echo $str;
        die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_adl&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_adl&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_adl
    $idpasienrj = $_GET['id'];
    $idpasien = $_GET['idps']; 
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_adl` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_adl.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">   
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">   
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Activity Of Daily Living (ADL) Dengan Instrumen Indeks Barthel Modifikasi
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive mt--3">
                            <table class="table-konten" width="100%">
                            <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="55%">Pertanyaan</td>
                                        <td width="35%">Jawaban</td>
                                        <td width="5%">Skor</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Mengendalikan rangsang Buang Air Besar (BAB)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_01" value="tindakterkendali" <?php if($datapemeriksaan['RangsangBab'] == 'tindakterkendali'){echo "checked";}?>> Tidak terkendali / tak teratur (perlu pencahar)
                                                 </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_01" value="kadang" <?php if($datapemeriksaan['RangsangBab'] == 'kadang'){echo "checked";}?>> Kadang-kadang tak terkendali (1 x / minggu)
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_01" value="terkendali" <?php if($datapemeriksaan['RangsangBab'] == 'terkendali'){echo "checked";}?>> Terkendali teratur
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Mengendalikan rangsang Buang Air Kecil (BAK)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_02" value="tindakterkendali" <?php if($datapemeriksaan['RangsangBak'] == 'tindakterkendali'){echo "checked";}?>> Tak terkendali atau pakai kateter
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_02" value="kadang" <?php if($datapemeriksaan['RangsangBak'] == 'kadang'){echo "checked";}?>> Kadang-kadang tak terkendali (hanya 1 x / 24 jam)
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_02" value="mandiri" <?php if($datapemeriksaan['RangsangBak'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Membersihkan diri (mencuci wajah, menyikat rambut, mencukur kumis, sikat gigi)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_03" value="butuh" <?php if($datapemeriksaan['MembersihkanDiri'] == 'butuh'){echo "checked";}?>> Butuh pertolongan orang lain
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_03" value="mandiri" <?php if($datapemeriksaan['MembersihkanDiri'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Penggunaan WC (keluar masuk WC, melepas/memakai celana, cebok, menyiram)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_04" value="tergantung" <?php if($datapemeriksaan['PenggunaanWc'] == 'tergantung'){echo "checked";}?>> Tergantung pertolongan orang lain
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_04" value="perlu" <?php if($datapemeriksaan['PenggunaanWc'] == 'perlu'){echo "checked";}?>> Perlu pertolongan pada  beberapa Kegiatan tetapi dapat mengerjakan sendiri beberapa kegiatan yang lain
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_04" value="mandiri" <?php if($datapemeriksaan['PenggunaanWc'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Makan minum (jika makan harus berupa potongan, dianggap dibantu)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_05" value="tidakmampu" <?php if($datapemeriksaan['MakanMinum'] == 'tidakmampu'){echo "checked";}?>> Tidak mampu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_05" value="perlu" <?php if($datapemeriksaan['MakanMinum'] == 'perlu'){echo "checked";}?>> Perlu ditolong memotong makanan
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_05" value="mandiri" <?php if($datapemeriksaan['MakanMinum'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Bergerak dari kursi roda ke tempat tidur dan sebaliknya (termasuk duduk di tempat tidur)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_06" value="tidakmampu" <?php if($datapemeriksaan['Bergerak'] == 'tidakmampu'){echo "checked";}?>> Tidak mampu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_06" value="perlu" <?php if($datapemeriksaan['Bergerak'] == 'perlu'){echo "checked";}?>> Perlu banyak bantuan untuk bisa duduk (2 orang)
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_06" value="bantuan" <?php if($datapemeriksaan['Bergerak'] == 'bantuan'){echo "checked";}?>> Bantuan minimal 1 orang
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_06" value="mandiri" <?php if($datapemeriksaan['Bergerak'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Berjalan di tempat rata (atau jika tidak bisa berjalan, menjalankan kursi roda)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_07" value="tidakmampu" <?php if($datapemeriksaan['Berjalan'] == 'tidakmampu'){echo "checked";}?>> Tidak mampu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_07" value="bisa" <?php if($datapemeriksaan['Berjalan'] == 'bisa'){echo "checked";}?>> Bisa (pindah) dengan kursi roda
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_07" value="berjalan" <?php if($datapemeriksaan['Berjalan'] == 'berjalan'){echo "checked";}?>> Berjalan dengan bantuan 1 orang
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_07" value="mandiri" <?php if($datapemeriksaan['Berjalan'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8.</td>
                                        <td>Berpakaian (termasuk memasang tali sepatu, mengencangkan sabuk)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_08" value="tergantung" <?php if($datapemeriksaan['Berpakain'] == 'tergantung'){echo "checked";}?>> Tergantung orang lain
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_08" value="sebagian" <?php if($datapemeriksaan['Berpakain'] == 'sebagian'){echo "checked";}?>> Sebagian dibantu (mis: mengancing baju)
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_08" value="mandiri" <?php if($datapemeriksaan['Berpakain'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9.</td>
                                        <td>Naik turun tangga</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_09" value="tidakmampu" <?php if($datapemeriksaan['NaikTurunTangga'] == 'tidakmampu'){echo "checked";}?>> Tidak mampu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_09" value="butuh" <?php if($datapemeriksaan['NaikTurunTangga'] == 'butuh'){echo "checked";}?>> Butuh pertolongan
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_09" value="mandiri" <?php if($datapemeriksaan['NaikTurunTangga'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10.</td>
                                        <td>Mandi</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="mentaltest_10" value="tergantung" <?php if($datapemeriksaan['Mandi'] == 'tergantung'){echo "checked";}?>> Tergantung orang lain
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="mentaltest_10" value="mandiri" <?php if($datapemeriksaan['Mandi'] == 'mandiri'){echo "checked";}?>> Mandiri
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><hr/>
                        <button type="submit" name="btnsimpan" value="simpan" class="btn btn-round btn-success btnsimpan">Simpan Pemeriksaan</button>
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

