<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $RiwayatBab = $_POST['kanker_01'];
    $RiwayatPolip = $_POST['kanker_02'];
    $RiwayatReseksi = $_POST['kanker_03'];
    $RiwayatKanker = $_POST['kanker_04'];
    $ColokDubur = $_POST['kanker_05'];
    $DarahSamar = $_POST['kanker_06'];
    $Rujuk = $_POST['kanker_07'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_kolorektal`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`RiwayatBab`,`RiwayatPolip`,
            `RiwayatReseksi`,`RiwayatKanker`,`ColokDubur`,`DarahSamar`,`Rujuk`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$RiwayatBab','$RiwayatPolip','$RiwayatReseksi','$RiwayatKanker',
            '$ColokDubur','$DarahSamar','$Rujuk')";
        }else{
            $str = "UPDATE `$tbskrining_kolorektal` SET `RiwayatBab`='$RiwayatBab',`RiwayatPolip`='$RiwayatPolip',
            `RiwayatReseksi`='$RiwayatReseksi',`RiwayatKanker`='$RiwayatKanker',`ColokDubur`='$ColokDubur',            
            `DarahSamar`='$DarahSamar',`Rujuk`='$Rujuk'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kolorektal&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kolorektal&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_wast
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_kolorektal` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_kolorektal.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">   
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Kanker Kolorektal
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Riwayat Diri Sendiri</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="70%">Pemeriksaan</td>
                                        <td width="25%">Hasil</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Riwayat BAB Berdarah tanpa hemoroid</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_01" value="ada" <?php if($datapemeriksaan['RiwayatBab'] == 'ada'){echo "checked";}?>> Ada
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_01" value="tidak" <?php if($datapemeriksaan['RiwayatBab'] == 'tidak'){echo "checked";}?>> Tidak ada
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Riwayat Polip Adenomatosa</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_02" value="ada" <?php if($datapemeriksaan['RiwayatPolip'] == 'ada'){echo "checked";}?>> Ada
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_02" value="tidak" <?php if($datapemeriksaan['RiwayatPolip'] == 'tidak'){echo "checked";}?>> Tidak ada
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Riwayat Reseksi Kuratif Kanker Kolerektal</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_03" value="ada" <?php if($datapemeriksaan['RiwayatReseksi'] == 'ada'){echo "checked";}?>> Ada
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_03" value="tidak" <?php if($datapemeriksaan['RiwayatReseksi'] == 'tidak'){echo "checked";}?>> Tidak ada
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Riwayat Keluarga</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="70%">Pemeriksaan</td>
                                        <td width="25%">Hasil</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Riwayat Kanker Kolerektal Pada Keluarga</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_04" value="ada" <?php if($datapemeriksaan['RiwayatKanker'] == 'ada'){echo "checked";}?>> Ada
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_04" value="tidak" <?php if($datapemeriksaan['RiwayatKanker'] == 'tidak'){echo "checked";}?>> Tidak ada
                                                </label>
                                            </div>
                                        </td>
                                    </tr>                                    
                                </tbody>
                            </table>                            
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Hasil Pemeriksaan</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="70%">Pemeriksaan</td>
                                        <td width="25%">Hasil</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Colok Dubur</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_05" value="normal" <?php if($datapemeriksaan['ColokDubur'] == 'normal'){echo "checked";}?>> Normal
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_05" value="tidak" <?php if($datapemeriksaan['ColokDubur'] == 'tidak'){echo "checked";}?>> Tidak Normal
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Darah Samar Feses</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_06" value="normal" <?php if($datapemeriksaan['DarahSamar'] == 'normal'){echo "checked";}?>> Normal
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_06" value="tidak" <?php if($datapemeriksaan['DarahSamar'] == 'tidak'){echo "checked";}?>> Tidak Normal
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Rujuk</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="kanker_07" value="rujuk" <?php if($datapemeriksaan['Rujuk'] == 'rujuk'){echo "checked";}?>> Rujuk
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="kanker_07" value="tidak" <?php if($datapemeriksaan['Rujuk'] == 'tidak'){echo "checked";}?>> Tidak Rujuk
                                                </label>
                                            </div>
                                        </td>
                                    </tr>                                    
                                </tbody>
                            </table>   
                        </div>
                        <div class="formbg mt-2">
                            <p>
                                <b>Hasil Skrining</b><br/>
                            </p>
                            <div class="input-group">
                                <select name="wilayah" class="form-control inputan wilayah" required>
                                    <option value="">--Pilih--</option>
                                    <option value="Normal" selected>Normal</option>
                                    <option value="Suspek">Suspek</option>
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
