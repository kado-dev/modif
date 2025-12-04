<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    if (isset($_POST['kebugaran_01'])) {$Jantung = $_POST['kebugaran_01'];} else {$Jantung = "";}
    if (isset($_POST['kebugaran_02'])) {$NyeriDada = $_POST['kebugaran_02'];} else {$NyeriDada = "";}
    if (isset($_POST['kebugaran_03'])) {$Pingsan = $_POST['kebugaran_03'];} else {$Pingsan = "";}
    if (isset($_POST['kebugaran_04'])) {$DarahTinggi = $_POST['kebugaran_04'];} else {$DarahTinggi = "";}
    if (isset($_POST['kebugaran_05'])) {$SendiTulang = $_POST['kebugaran_05'];} else {$SendiTulang = "";}
    if (isset($_POST['kebugaran_06'])) {$Obatobatan = $_POST['kebugaran_06'];} else {$Obatobatan = "";}
    if (isset($_POST['kebugaran_07'])) {$LatihanFisik = $_POST['kebugaran_07'];} else {$LatihanFisik = "";}
    if (isset($_POST['kebugaran_08'])) {$Nadi = $_POST['kebugaran_08'];} else {$Nadi = "";}
    if (isset($_POST['kebugaran_09'])) {$BeratBadan = $_POST['kebugaran_09'];} else {$BeratBadan = "";}
    if (isset($_POST['kebugaran_10'])) {$TinggiBadan = $_POST['kebugaran_10'];} else {$TinggiBadan = "";}
    if (isset($_POST['kebugaran_11'])) {$Imt = $_POST['kebugaran_11'];} else {$Imt = "";}
    if (isset($_POST['kebugaran_12'])) {$KategoriImt = $_POST['kebugaran_12'];} else {$KategoriImt = "";}
    if (isset($_POST['kebugaran_13'])) {$Gds = $_POST['kebugaran_13'];} else {$Gds = "";}
    if (isset($_POST['kebugaran_14'])) {$Kolesterol = $_POST['kebugaran_14'];} else {$Kolesterol = "";}
    if (isset($_POST['kebugaran_15'])) {$Sistole = $_POST['kebugaran_15'];} else {$Sistole = "";}
    if (isset($_POST['kebugaran_16'])) {$Diastole = $_POST['kebugaran_16'];} else {$Diastole = "";}
    if (isset($_POST['kebugaran_17'])) {$Bodyage = $_POST['kebugaran_17'];} else {$Bodyage = "";}
    if (isset($_POST['kebugaran_18'])) {$RestMetabolic = $_POST['kebugaran_18'];} else {$RestMetabolic = "";}
    if (isset($_POST['kebugaran_19'])) {$VisceralFat = $_POST['kebugaran_19'];} else {$VisceralFat = "";}
    
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_kebugaran`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`Jantung`,`NyeriDada`,
            `Pingsan`,`DarahTinggi`,`SendiTulang`,`Obatobatan`,`LatihanFisik`,`Nadi`,`BeratBadan`,`TinggiBadan`,
            `Imt`,`KategoriImt`,`Gds`,`Kolesterol`,`Sistole`,`Diastole`,`Bodyage`,`RestMetabolic`,`VisceralFat`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$Jantung','$NyeriDada',
            '$Pingsan','$DarahTinggi','$SendiTulang','$Obatobatan','$LatihanFisik','$Nadi','$BeratBadan','$TinggiBadan',
            '$Imt','$KategoriImt','$Gds','$Kolesterol','$Sistole','$Diastole','$Bodyage','$RestMetabolic','$VisceralFat')";
        }else{
            $str = "UPDATE `$tbskrining_kebugaran` 
            SET `Jantung`='$Jantung',
            `NyeriDada`='$NyeriDada',
            `Pingsan`='$Pingsan',
            `DarahTinggi`='$DarahTinggi',
            `SendiTulang`='$SendiTulang',
            `Obatobatan`='$Obatobatan',
            `LatihanFisik`='$LatihanFisik',
            `Nadi`='$Nadi',
            `BeratBadan`='$BeratBadan',
            `TinggiBadan`='$TinggiBadan',
            `Imt`='$Imt',
            `KategoriImt`='$KategoriImt',
            `Gds`='$Gds',
            `Kolesterol`='$Kolesterol',
            `Sistole`='$Sistole',
            `Diastole`='$Diastole',
            `Bodyage`='$Bodyage',
            `RestMetabolic`='$RestMetabolic',
            `VisceralFat`='$VisceralFat'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kebugaran&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kebugaran&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_kebugaran
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_kebugaran` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_kebugaran.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">  
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Kebugaran - Dewasa
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
                                        <td>Apakah dokter pernah mengatakan bahwa Anda menderita penyakit jantung ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kebugaran_01" value="ya" <?php if($datapemeriksaan['Jantung'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kebugaran_01" value="tidak" <?php if($datapemeriksaan['Jantung'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Apakah Anda sering mengalami nyeri dada atau nyeri di bagian dada sebelah kiri ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kebugaran_02" value="ya" <?php if($datapemeriksaan['NyeriDada'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kebugaran_02" value="tidak" <?php if($datapemeriksaan['NyeriDada'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Apakah Anda sering merasa akan pingsan atau pusing kepala yang agak parah ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kebugaran_03" value="ya" <?php if($datapemeriksaan['Pingsan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kebugaran_03" value="tidak" <?php if($datapemeriksaan['Pingsan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Apakah dokter pernah mengatakan bahwa tekanan darah Anda terlalu tinggi ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kebugaran_04" value="ya" <?php if($datapemeriksaan['DarahTinggi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kebugaran_04" value="tidak" <?php if($datapemeriksaan['DarahTinggi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Apakah dokter pernah memberitahu bahwa Anda mengidap masalah sendi dan tulang ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kebugaran_05" value="ya" <?php if($datapemeriksaan['SendiTulang'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kebugaran_05" value="tidak" <?php if($datapemeriksaan['SendiTulang'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Apakah Anda selalu membawa obat-obatan berdasarkan resep dokter untuk penyakit jantung, tekanan darah tinggi, diabetes dll ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kebugaran_06" value="ya" <?php if($datapemeriksaan['Obatobatan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kebugaran_06" value="tidak" <?php if($datapemeriksaan['Obatobatan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Apakah ada alasan tertentu yang belum disebutkan di atas yang menyatakan bahwa Anda tidak boleh mengikuti suatu program latihan fisik/olahraga ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kebugaran_07" value="ya" <?php if($datapemeriksaan['LatihanFisik'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kebugaran_07" value="tidak" <?php if($datapemeriksaan['LatihanFisik'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br/>
                            <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pemeriksaan Kesehatan</p>
                            <div class="table-responsive mt--3">
                                <table class="table-judul" width="100%">
                                    <thead>
                                        <tr>
                                            <td width="5%">No.</td>
                                            <td width="25%">Pemeriksaan</td>
                                            <td width="70%">Hasil</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>Nadi</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="kebugaran_08" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Nadi']?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">x/menit</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Berat Badan</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="kebugaran_09" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['BeratBadan']?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">kg</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>Tinggi Badan</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="kebugaran_10" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['TinggiBadan']?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">cm</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>IMT</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="kebugaran_11" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Imt']?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">kg/m2</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5.</td>
                                            <td>Kategori IMT</td>
                                            <td>
                                                <input type="text" name="kebugaran_12" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['KategoriImt']?>" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6.</td>
                                            <td>Gula Darah Sewaktu</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="kebugaran_13" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Gds']?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">mg/dL</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7.</td>
                                            <td>Kolesterol Sewaktu</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="kebugaran_14" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Kolesterol']?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">mg/dL</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8.</td>
                                            <td>Sistole</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="kebugaran_15" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Sistole']?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">mm</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9.</td>
                                            <td>Diastole</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="kebugaran_16" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Diastole']?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Hg</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>10.</td>
                                            <td>Body age</td>
                                            <td>
                                                <input type="text" name="kebugaran_17" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Bodyage']?>" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>11.</td>
                                            <td>Rest Metabolic</td>
                                            <td>
                                                <input type="text" name="kebugaran_18" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['RestMetabolic']?>" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12.</td>
                                            <td>Visceral fat</td>
                                            <td>
                                                <input type="text" name="kebugaran_19" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['VisceralFat']?>" required>
                                            </td>
                                        </tr>
                                    </tbody>
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

