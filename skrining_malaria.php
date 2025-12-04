<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $RiwayatBepergian = $_POST['malaria_01'];
    $RiwayatTransfusi = $_POST['malaria_02'];
    $PernahMalaria = $_POST['malaria_03'];
    $MikroskopisMalaria = $_POST['malaria_04'];
    $HasilSkrining = $_POST['hasilskrining'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_malaria`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`RiwayatBepergian`,`RiwayatTransfusi`,
            `PernahMalaria`,`MikroskopisMalaria`,`HasilSkrining`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$RiwayatBepergian','$RiwayatTransfusi',
            '$PernahMalaria','$MikroskopisMalaria','$HasilSkrining')";
        }else{
            $str = "UPDATE `$tbskrining_malaria` 
            SET `RiwayatBepergian`='$RiwayatBepergian',`RiwayatTransfusi`='$RiwayatTransfusi',
            `PernahMalaria`='$PernahMalaria',`MikroskopisMalaria`='$MikroskopisMalaria',
            `HasilSkrining`='$HasilSkrining'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_malaria&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_malaria&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_malaria
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_malaria` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_malaria.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">   
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Malaria
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
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
                                        <td>Riwayat bepergian ke daerah endemis malaria dalam kurun waktu 1 bulan terakhir ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="malaria_01" value="ya" <?php if($datapemeriksaan['RiwayatBepergian'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="malaria_01" value="tidak" <?php if($datapemeriksaan['RiwayatBepergian'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Riwayat tranfusi darah 1 bulan terakhir ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="malaria_02" value="ya" <?php if($datapemeriksaan['RiwayatTransfusi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="malaria_02" value="tidak" <?php if($datapemeriksaan['RiwayatTransfusi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Pernah menderita malaria sebelumnya ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="malaria_03" value="ya" <?php if($datapemeriksaan['PernahMalaria'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="malaria_03" value="tidak" <?php if($datapemeriksaan['PernahMalaria'] == 'tidak'){echo "checked";}?>> Tidak
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
                                        <td width="35%">Pemeriksaan</td>
                                        <td width="20%">Hasil</td>
                                        <td width="20%">Nilai Rujukan</td>
                                        <td width="20%">Satuan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Mikroskopis malaria</td>
                                        <td>
                                            <input type="text" name="malaria_04" class="form-control inputan" value="<?php echo $datapemeriksaan['MikroskopisMalaria'];?>" maxlength="20" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control inputan" maxlength="20" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control inputan" maxlength="20" readonly>
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
                                <select name="hasilskrining" class="form-control inputan" required>
                                    <option value="">--Pilih--</option>
                                    <option value="Negatif Malaria" <?php if($datapemeriksaan['HasilSkrining'] == 'Negatif Malaria'){echo "selected";}?>>Negatif Malaria</option>
                                    <option value="Positif Malaria" <?php if($datapemeriksaan['HasilSkrining'] == 'Positif Malaria'){echo "selected";}?>>Positif Malaria</option>
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
