<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['mentaltest_01'])) {$Umur = $_POST['mentaltest_01'];} else {$Umur = "";}
    if (isset($_POST['mentaltest_02'])) {$Waktu = $_POST['mentaltest_02'];} else {$Waktu = "";}
    if (isset($_POST['mentaltest_03'])) {$Alamat = $_POST['mentaltest_03'];} else {$Alamat = "";}
    if (isset($_POST['mentaltest_04'])) {$TahunSekarang = $_POST['mentaltest_04'];} else {$TahunSekarang = "";}
    if (isset($_POST['mentaltest_05'])) {$BeradaDimana = $_POST['mentaltest_05'];} else {$BeradaDimana = "";}
    if (isset($_POST['mentaltest_06'])) {$MengenaliOrang = $_POST['mentaltest_06'];} else {$MengenaliOrang = "";}
    if (isset($_POST['mentaltest_07'])) {$TahunKemerdekaan = $_POST['mentaltest_07'];} else {$TahunKemerdekaan = "";}
    if (isset($_POST['mentaltest_08'])) {$NamaPresiden = $_POST['mentaltest_08'];} else {$NamaPresiden = "";}
    if (isset($_POST['mentaltest_09'])) {$TahunKelahiran = $_POST['mentaltest_09'];} else {$TahunKelahiran = "";}
    if (isset($_POST['mentaltest_10'])) {$MenghitungTerbalik = $_POST['mentaltest_10'];} else {$MenghitungTerbalik = "";}
    
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];        

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_mental`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`Umur`,`Waktu`,`Alamat`,
            `TahunSekarang`,`BeradaDimana`,`MengenaliOrang`,`TahunKemerdekaan`,`NamaPresiden`,`TahunKelahiran`,`MenghitungTerbalik`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$Umur','$Waktu','$Alamat','$TahunSekarang','$BeradaDimana','$MengenaliOrang',
            '$TahunKemerdekaan','$NamaPresiden','$TahunKelahiran','$MenghitungTerbalik')";
        }else{
            $str = "UPDATE `$tbskrining_mental` 
            SET `Umur`='$Umur',
            `Waktu`='$Waktu',
            `Alamat`='$Alamat',
            `TahunSekarang`='$TahunSekarang',
            `BeradaDimana`='$BeradaDimana',
            `MengenaliOrang`='$MengenaliOrang',
            `TahunKemerdekaan`='$TahunKemerdekaan',
            `NamaPresiden`='$NamaPresiden',
            `TahunKelahiran`='$TahunKelahiran',
            `MenghitungTerbalik`='$MenghitungTerbalik'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_mental&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan..');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_mental&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_mental
    $idpasienrj = $_GET['id'];
    $idpasien = $_GET['idps']; 
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_mental` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<style>
    .bgskor{
        border-radius:20px;background:#fff;margin-bottom:20px;box-shadow:0px 0px 0px #ddd;
    }
</style>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_mental.php" method="post">
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Abbreviated Mental Test</p>
                        <div class="table-responsive mt--3">
                            <table class="table-konten" width="100%">
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
                                                    <input type="radio" class="pilihsemua" name="pilihsemua" value="opsisalah"> <b>Salah</b>
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihsemua" name="pilihsemua" value="opsibenar"> <b>Benar</b>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Umur</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_01" value="salah" <?php if($datapemeriksaan['Umur'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_01" value="benar" <?php if($datapemeriksaan['Umur'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Waktu / Jam sekarang</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_02" value="salah" <?php if($datapemeriksaan['Waktu'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_02" value="benar" <?php if($datapemeriksaan['Waktu'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Alamat tempat tinggal</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_03" value="salah" <?php if($datapemeriksaan['Alamat'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_03" value="benar" <?php if($datapemeriksaan['Alamat'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Tahun sekarang></td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_04" value="salah" <?php if($datapemeriksaan['TahunSekarang'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_04" value="benar" <?php if($datapemeriksaan['TahunSekarang'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Saat ini berada di mana</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_05" value="salah" <?php if($datapemeriksaan['BeradaDimana'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_05" value="benar" <?php if($datapemeriksaan['BeradaDimana'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Mengenali orang lain di RS. (dokter, perawat, dll)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_06" value="salah" <?php if($datapemeriksaan['MengenaliOrang'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_06" value="benar" <?php if($datapemeriksaan['MengenaliOrang'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Tahun kemerdekaan RI</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_07" value="salah" <?php if($datapemeriksaan['TahunKemerdekaan'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_07" value="benar" <?php if($datapemeriksaan['TahunKemerdekaan'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8.</td>
                                        <td>Nama Presiden RI</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_08" value="salah" <?php if($datapemeriksaan['NamaPresiden'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_08" value="benar" <?php if($datapemeriksaan['NamaPresiden'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9.</td>
                                        <td>Tahun kelahiran pasien atau anak terakhir</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_09" value="salah" <?php if($datapemeriksaan['TahunKelahiran'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_09" value="benar" <?php if($datapemeriksaan['TahunKelahiran'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10.</td>
                                        <td>Menghitung terbalik (20 s/d 1) </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="pilihansalah" name="mentaltest_10" value="salah" <?php if($datapemeriksaan['MenghitungTerbalik'] == 'salah'){echo "checked";}?>> Salah
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" class="pilihanbenar" name="mentaltest_10" value="benar" <?php if($datapemeriksaan['MenghitungTerbalik'] == 'benar'){echo "checked";}?>> Benar
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><hr/>
                        <div class="bgskor mt-4">
                            <div class="row ">
                                <div class="col-md-2" style="padding:10px 50px 20px">
                                    <b>Total Skor</b><br/>
                                    <span class="skor"></span>
                                </div>
                                <div class="col-md-10" style="padding:10px 50px 20px">
                                    <b>Hasil IMT</b><br/>
                                    <span class="hasilimt"></span>
                                </div>
                            </div>
                        </div>
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
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>

$(document).ready(function() {
    $(".pilihsemua").click(function(){
        var thiss = $("input[name='pilihsemua']:checked").val();
        if(thiss == 'opsisalah'){
            $(".pilihansalah").prop("checked", true);
            $(".pilihanbenar").prop("checked", false);
        }else{
            $(".pilihanbenar").prop("checked", true);
            $(".pilihansalah").prop("checked", false);
        }
    });

    $(".pilihanbenar, .pilihansalah").click(function(){
        hitung_skor();
    });

    function hitung_skor(){
        //hasil imt, 8-10 normal, 4-7 gangguan ingatan, 1-3 berat
        //var thiss = $("input[type='radio']:checked").length;
        var jmlbenar = $('input.pilihanbenar:checked').length;
        $(".skor").text(jmlbenar);
        if(jmlbenar >= 8){
            $(".hasilimt").text('Normal');
            $(".bgskor").css({"background-color":"green","color":"white"});
        }else if(jmlbenar >= 4){
            $(".hasilimt").text('Gangguan ingatan');
            $(".bgskor").css({"background-color":"orange","color":"white"});
        }else{
            $(".hasilimt").text('Gangguan ingatan berat');
            $(".bgskor").css({"background-color":"red","color":"white"});
        }
    }
});
</script>