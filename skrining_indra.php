<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['indra_01'])) {$KongentialKiri = $_POST['indra_01'];} else {$KongentialKiri = "";}
    if (isset($_POST['indra_02'])) {$KongentialKanan = $_POST['indra_02'];} else {$KongentialKanan = "";}
    if (isset($_POST['indra_03'])) {$KongentialRujuk = $_POST['indra_03'];} else {$KongentialRujuk = "";}
    if (isset($_POST['indra_04'])) {$SerumenKiri = $_POST['indra_04'];} else {$SerumenKiri = "";}
    if (isset($_POST['indra_05'])) {$SerumenKanan = $_POST['indra_05'];} else {$SerumenKanan = "";}
    if (isset($_POST['indra_06'])) {$SerumenRujuk = $_POST['indra_06'];} else {$SerumenRujuk = "";}
    if (isset($_POST['indra_07'])) {$CongekKiri = $_POST['indra_07'];} else {$CongekKiri = "";}
    if (isset($_POST['indra_08'])) {$CongekKanan = $_POST['indra_08'];} else {$CongekKanan = "";}
    if (isset($_POST['indra_09'])) {$CongekRujuk = $_POST['indra_09'];} else {$CongekRujuk = "";}
    if (isset($_POST['indra_10'])) {$PresbikusisKiri = $_POST['indra_10'];} else {$PresbikusisKiri = "";}
    if (isset($_POST['indra_11'])) {$PresbikusisKanan = $_POST['indra_11'];} else {$PresbikusisKanan = "";}
    if (isset($_POST['indra_12'])) {$BisikanKiri = $_POST['indra_12'];} else {$BisikanKiri = "";}
    if (isset($_POST['indra_13'])) {$BisikanKanan = $_POST['indra_13'];} else {$BisikanKanan = "";}

    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_indra`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`KongentialKiri`,`KongentialKanan`,
            `KongentialRujuk`,`SerumenKiri`,`SerumenKanan`,`SerumenRujuk`,`CongekKiri`,`CongekKanan`,`CongekRujuk`,
            `PresbikusisKiri`,`PresbikusisKanan`,`BisikanKiri`,`BisikanKanan`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$KongentialKiri','$KongentialKanan',
            '$KongentialRujuk','$SerumenKiri','$SerumenKanan','$SerumenRujuk','$CongekKiri','$CongekKanan','$CongekRujuk',
            '$PresbikusisKiri','$PresbikusisKanan','$BisikanKiri','$BisikanKanan')";
        }else{
            $str = "UPDATE `$tbskrining_indra` 
            SET `KongentialKiri`='$KongentialKiri',
            `KongentialKanan`='$KongentialKanan',
            `KongentialRujuk`='$KongentialRujuk',
            `SerumenKiri`='$SerumenKiri',
            `SerumenKanan`='$SerumenKanan',
            `SerumenRujuk`='$SerumenRujuk',
            `CongekKiri`='$CongekKiri',
            `CongekKanan`='$CongekKanan',
            `CongekRujuk`='$CongekRujuk',
            `PresbikusisKiri`='$PresbikusisKiri',
            `PresbikusisKanan`='$PresbikusisKanan',
            `BisikanKiri`='$BisikanKiri',
            `BisikanKanan`='$BisikanKanan'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_indra&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_indra&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_indra
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_indra` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_indra.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>"> 
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Indra Pendengaran
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="50%">Pertanyaan</td>
                                        <td width="15%">Telinga Kiri</td>
                                        <td width="15%">Telinga Kanan</td>
                                        <td width="15%">Rujuk RS</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>#</b></td>
                                        <td><b>Pilih semua jawaban</b></td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="pilihsemua_01" value="ya"> <b>Ya</b>
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="pilihsemua_01" value="tidak"> <b>Tidak</b>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="pilihsemua_02" value="ya"> <b>Ya</b>
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="pilihsemua_02" value="tidak"> <b>Tidak</b>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="pilihsemua_03" value="rujuk"> <b>Rujuk</b>
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="pilihsemua_03" value="tidak"> <b>Tidak Rujuk</b>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Curiga Tuli Kongential ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_01" value="ya" <?php if($datapemeriksaan['KongentialKiri'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_01" value="tidak" <?php if($datapemeriksaan['KongentialKiri'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_02" value="ya" <?php if($datapemeriksaan['KongentialKanan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_02" value="tidak" <?php if($datapemeriksaan['KongentialKanan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_03" value="rujuk" <?php if($datapemeriksaan['KongentialRujuk'] == 'rujuk'){echo "checked";}?>> Rujuk
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_03" value="tidak" <?php if($datapemeriksaan['KongentialRujuk'] == 'tidak'){echo "checked";}?>> Tidak Rujuk
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Sumbatan Serumen ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_04" value="ya" <?php if($datapemeriksaan['SerumenKiri'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_04" value="tidak" <?php if($datapemeriksaan['SerumenKiri'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_05" value="ya" <?php if($datapemeriksaan['SerumenKanan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_05" value="tidak" <?php if($datapemeriksaan['SerumenKanan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_06" value="rujuk" <?php if($datapemeriksaan['SerumenRujuk'] == 'rujuk'){echo "checked";}?>> Rujuk
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_06" value="tidak" <?php if($datapemeriksaan['SerumenRujuk'] == 'tidak'){echo "checked";}?>> Tidak Rujuk
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>OMSK/Congek ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_07" value="ya" <?php if($datapemeriksaan['CongekKiri'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_07" value="tidak" <?php if($datapemeriksaan['CongekKiri'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_08" value="ya" <?php if($datapemeriksaan['CongekKanan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_08" value="tidak" <?php if($datapemeriksaan['CongekKanan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_09" value="ya" <?php if($datapemeriksaan['CongekRujuk'] == 'ya'){echo "checked";}?>> Rujuk
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_09" value="tidak" <?php if($datapemeriksaan['CongekRujuk'] == 'tidak'){echo "checked";}?>> Tidak Rujuk
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Penurunan pendengaran karena usia lanjut (Presbikusis) ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_10" value="ya" <?php if($datapemeriksaan['PresbikusisKiri'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_10" value="tidak" <?php if($datapemeriksaan['PresbikusisKiri'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_11" value="ya" <?php if($datapemeriksaan['PresbikusisKanan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_11" value="tidak" <?php if($datapemeriksaan['PresbikusisKanan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Mendengar bisikan saat TES BISIK ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_12" value="ya" <?php if($datapemeriksaan['BisikanKiri'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_12" value="tidak" <?php if($datapemeriksaan['BisikanKiri'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="indra_13" value="ya" <?php if($datapemeriksaan['BisikanKanan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="indra_13" value="tidak" <?php if($datapemeriksaan['BisikanKanan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                 
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

