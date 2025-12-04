<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['gigilansia_01'])) {$RutinKontrol = $_POST['gigilansia_01'];} else {$RutinKontrol = "";}
    if (isset($_POST['gigilansia_02'])) {$PolaMakanSehat = $_POST['gigilansia_02'];} else {$PolaMakanSehat = "";}
    if (isset($_POST['gigilansia_03'])) {$SikatGigi = $_POST['gigilansia_03'];} else {$SikatGigi = "";}
    if (isset($_POST['gigilansia_04'])) {$GigiPalsu = $_POST['gigilansia_04'];} else {$GigiPalsu = "";}
    if (isset($_POST['gigilansia_05'])) {$GigiBerfungsi = $_POST['gigilansia_05'];} else {$GigiBerfungsi = "";}
    if (isset($_POST['gigilansia_06'])) {$MukosaMulut = $_POST['gigilansia_06'];} else {$MukosaMulut = "";}
    
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_gigi_lansia`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`RutinKontrol`,`PolaMakanSehat`,
            `SikatGigi`,`GigiPalsu`,`GigiBerfungsi`,`MukosaMulut`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$RutinKontrol','$PolaMakanSehat',
            '$SikatGigi','$GigiPalsu','$GigiBerfungsi','$MukosaMulut')";
        }else{
            $str = "UPDATE `$tbskrining_gigi_lansia` 
            SET `RutinKontrol`='$RutinKontrol',
            `PolaMakanSehat`='$PolaMakanSehat',
            `SikatGigi`='$SikatGigi',
            `GigiPalsu`='$GigiPalsu',
            `GigiBerfungsi`='$GigiBerfungsi',
            `MukosaMulut`='$MukosaMulut'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_gigi_lansia&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_gigi_lansia&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_gigi_lansia
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_gigi_lansia` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_gigi_lansia.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>"> 
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Gigi Lansia
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
                                        <td>Apakah rutin kontrol ke dokter gigi , minimal sekali dalam 6 bulan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="gigilansia_01" value="ya" <?php if($datapemeriksaan['RutinKontrol'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="gigilansia_01" value="tidak" <?php if($datapemeriksaan['RutinKontrol'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Apakah sudah melakukan pola makan yang sehat dan pemilihan makanan yang tepat ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="gigilansia_02" value="ya" <?php if($datapemeriksaan['PolaMakanSehat'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="gigilansia_02" value="tidak" <?php if($datapemeriksaan['PolaMakanSehat'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Berapa kali sikat gigi dalam sehari (minimal 2 kali) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="gigilansia_03" value="ya" <?php if($datapemeriksaan['SikatGigi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="gigilansia_03" value="tidak" <?php if($datapemeriksaan['SikatGigi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Jika menggunakan gigi palsu, apakah rutin selalu dibersihkan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="gigilansia_04" value="ya" <?php if($datapemeriksaan['GigiPalsu'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="gigilansia_04" value="tidak" <?php if($datapemeriksaan['GigiPalsu'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Apakah masih memiliki gigi yang berfungsi baik (minimal 20 gigi tidak goyang & lubang) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="gigilansia_05" value="ya" <?php if($datapemeriksaan['GigiBerfungsi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="gigilansia_05" value="tidak" <?php if($datapemeriksaan['GigiBerfungsi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Apakah ada keluhan pada mukosa mulut (deteksi dini penyakit mulut) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="gigilansia_06" value="ya" <?php if($datapemeriksaan['MukosaMulut'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="gigilansia_06" value="tidak" <?php if($datapemeriksaan['MukosaMulut'] == 'tidak'){echo "checked";}?>> Tidak
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
                                        <b>Tindak Lanjut:</b><br/>
                                        <span>Isi semua jawaban untuk melihat tindak lanjut</span>
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

