<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['kanker_01'])) {$Merokok = $_POST['kanker_01'];} else {$Merokok = "";}
    if (isset($_POST['kanker_02'])) {$AktifitasFisik = $_POST['kanker_02'];} else {$AktifitasFisik = "";}
    if (isset($_POST['kanker_03'])) {$Gula = $_POST['kanker_03'];} else {$Gula = "";}
    if (isset($_POST['kanker_04'])) {$Garam = $_POST['kanker_04'];} else {$Garam = "";}
    if (isset($_POST['kanker_05'])) {$Lemak = $_POST['kanker_05'];} else {$Lemak = "";}
    if (isset($_POST['kanker_06'])) {$BuahSayur = $_POST['kanker_06'];} else {$BuahSayur = "";}
    if (isset($_POST['kanker_07'])) {$Alkohol = $_POST['kanker_07'];} else {$Alkohol = "";}
    if (isset($_POST['kanker_08'])) {$HasilIva = $_POST['kanker_08'];} else {$HasilIva = "";}

    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_kanker_serviks`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`Merokok`,`AktifitasFisik`,
            `Gula`,`Garam`,`Lemak`,`BuahSayur`,`Alkohol`,`HasilIva`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$Merokok','$AktifitasFisik',
            '$Gula','$Garam','$Lemak','$BuahSayur','$Alkohol','$HasilIva')";
        }else{
            $str = "UPDATE `$tbskrining_kanker_serviks` 
            SET `Merokok`='$Merokok',
            `AktifitasFisik`='$AktifitasFisik',
            `Gula`='$Gula',
            `Garam`='$Garam',
            `Lemak`='$Lemak',
            `BuahSayur`='$BuahSayur',
            `Alkohol`='$Alkohol',
            `HasilIva`='$HasilIva'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kanker_serviks&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kanker_serviks&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_kanker_serviks
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_kanker_serviks` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_kanker_serviks.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">  
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>"> 
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Risiko Kanker Serviks
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
                                        <td>Merokok ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_01" value="ya" <?php if($datapemeriksaan['Merokok'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_01" value="tidak" <?php if($datapemeriksaan['Merokok'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Kurang Aktifitas Fisik ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_02" value="ya" <?php if($datapemeriksaan['AktifitasFisik'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_02" value="tidak" <?php if($datapemeriksaan['AktifitasFisik'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Gula Berlebihan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_03" value="ya" <?php if($datapemeriksaan['Gula'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_03" value="tidak" <?php if($datapemeriksaan['Gula'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Garam Berlebihan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_04" value="ya" <?php if($datapemeriksaan['Garam'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_04" value="tidak" <?php if($datapemeriksaan['Garam'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Lemak Berlebihan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_05" value="ya" <?php if($datapemeriksaan['Lemak'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_05" value="tidak" <?php if($datapemeriksaan['Lemak'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Kurang Makan Buah dan Sayur ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_06" value="ya" <?php if($datapemeriksaan['BuahSayur'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_06" value="tidak" <?php if($datapemeriksaan['BuahSayur'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Konsumsi Alkohol ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_07" value="ya" <?php if($datapemeriksaan['Alkohol'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_07" value="tidak" <?php if($datapemeriksaan['Alkohol'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Pemeriksaan IVA</p>
                            <div class="table-responsive">
                                <table class="table-konten" width="100%">
                                    <tr>
                                        <td class="col-sm-2">Hasil IVA</td>
                                        <td class="col-sm-10">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="gejala_tbc_04" value="positif" <?php if($datapemeriksaan['HasilIva'] == 'positif'){echo "checked";}?>> Positif
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="gejala_tbc_04" value="negatif" <?php if($datapemeriksaan['HasilIva'] == 'negatif'){echo "checked";}?>> Negatif
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="gejala_tbc_04" value="curiga" <?php if($datapemeriksaan['HasilIva'] == 'curiga'){echo "checked";}?>> Curiga Kanker
                                                </label>
                                            </div>
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
?>

