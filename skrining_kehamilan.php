<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['hamil_01'])) {$MempunyaiBayi = $_POST['hamil_01'];} else {$MempunyaiBayi = "";}
    if (isset($_POST['hamil_02'])) {$Bersenggama = $_POST['hamil_02'];} else {$Bersenggama = "";}
    if (isset($_POST['hamil_03'])) {$BaruMelahirkan = $_POST['hamil_03'];} else {$BaruMelahirkan = "";}
    if (isset($_POST['hamil_04'])) {$HaidTerakhir = $_POST['hamil_04'];} else {$HaidTerakhir = "";}
    if (isset($_POST['hamil_05'])) {$Keguguran = $_POST['hamil_05'];} else {$Keguguran = "";}
    if (isset($_POST['hamil_06'])) {$Kontrasepsi = $_POST['hamil_06'];} else {$Kontrasepsi = "";}

    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_kehamilan`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`MempunyaiBayi`,`Bersenggama`,
            `BaruMelahirkan`,`HaidTerakhir`,`Keguguran`,`Kontrasepsi`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$MempunyaiBayi','$Bersenggama',
            '$BaruMelahirkan','$HaidTerakhir','$Keguguran','$Kontrasepsi')";
        }else{
            $str = "UPDATE `$tbskrining_kehamilan` 
            SET `MempunyaiBayi`='$MempunyaiBayi',
            `Bersenggama`='$Bersenggama',
            `BaruMelahirkan`='$BaruMelahirkan',
            `HaidTerakhir`='$HaidTerakhir',
            `Keguguran`='$Keguguran',
            `Kontrasepsi`='$Kontrasepsi'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kehamilan&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kehamilan&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_kehamilan
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_kehamilan` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_kehamilan.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>"> 
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Penapisan Kehamilan Pasien KB
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive">
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
                                        <td>Apakah Anda mempunyai bayi berumur kurang dari 6 bulan dan apakah Anda menyusui secara ekslusif dan belum mendapat haid ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hamil_01" value="ya" <?php if($datapemeriksaan['MempunyaiBayi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hamil_01" value="tidak" <?php if($datapemeriksaan['MempunyaiBayi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Apakah Anda pantang bersenggama sejak haid terakhir atau bersalin ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hamil_02" value="ya" <?php if($datapemeriksaan['Bersenggama'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hamil_02" value="tidak" <?php if($datapemeriksaan['Bersenggama'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Apakah Anda baru melahirkan bayi kurang dari 4 minggu ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hamil_03" value="ya" <?php if($datapemeriksaan['BaruMelahirkan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hamil_03" value="tidak" <?php if($datapemeriksaan['BaruMelahirkan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Apakah haid terakhir dimulai 7 hari terakhir (atau 12 hari terakhir apabila klien ingin menggunakan IUD) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hamil_04" value="ya" <?php if($datapemeriksaan['HaidTerakhir'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hamil_04" value="tidak" <?php if($datapemeriksaan['HaidTerakhir'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Apakah Anda mengalami keguguran dalam 7 hari terakhir (atau 12 hari terakhir bila klien ingin menggunakan AKDR) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hamil_05" value="ya" <?php if($datapemeriksaan['Keguguran'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hamil_05" value="tidak" <?php if($datapemeriksaan['Keguguran'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Apakah Anda menggunakan metode kontrasepsi secara tepat dan kosisten? (apabila pasien ganti cara kembali sesuai jadwal yang diberikan)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="hamil_06" value="ya" <?php if($datapemeriksaan['Kontrasepsi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="hamil_06" value="tidak" <?php if($datapemeriksaan['Kontrasepsi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br/>
                            <div class="formbg mt-2">
                                <div class="input-group">
                                    <span>
                                        <b>Perhatikan</b><br/>
                                        <span>Jika dari 6 pertanyaan satu saja dijawab "ya" pasien dapat segera menggunakan alat kontrasepsi, tetapi apabila 6 pertanyaan dijawab "tidak” maka pasien harus menunggu haid bulan berikutnya untuk menggunakan alat kontrasepsi (skrining penapisan kehamilan KLOP KB WHO)</span>
                                    </span>
                                </div>	
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

