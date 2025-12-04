<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $MataLuar = $_POST['penglihatan_01'];
    $PenglihatanMataKiri = $_POST['penglihatan_02'];
    $PenglihatanMataKanan = $_POST['penglihatan_03'];
    $ButaWarnaKiri = $_POST['penglihatan_04'];
    $ButaWarnaKanan = $_POST['penglihatan_05'];   
    $Kacamata = $_POST['penglihatan_06'];
    $GangguanRefraksiMataKiri = $_POST['penglihatan_07'];
    $GangguanRefraksiMataKanan = $_POST['penglihatan_08'];
    $GangguanRefraksiRujukRS = $_POST['penglihatan_09'];
    $NilaiVisusMataKiri = $_POST['penglihatan_10'];
    $NilaiVisusMataKanan = $_POST['penglihatan_11'];
    $KatarakMataKiri = $_POST['penglihatan_12'];
    $KatarakMataKanan = $_POST['penglihatan_13'];
    $KatarakRujukRS = $_POST['penglihatan_14'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_penglihatan`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`MataLuar`,
            `PenglihatanMataKiri`,`PenglihatanMataKanan`,`ButaWarnaKiri`,`ButaWarnaKanan`,`Kacamata`,
            `GangguanRefraksiMataKiri`,`GangguanRefraksiMataKanan`,`GangguanRefraksiRujukRS`,
            `NilaiVisusMataKiri`,`NilaiVisusMataKanan`,`KatarakMataKiri`,`KatarakMataKanan`,`KatarakRujukRS`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$MataLuar',
            '$PenglihatanMataKiri','$PenglihatanMataKanan','$ButaWarnaKiri','$ButaWarnaKanan','$Kacamata',
            '$GangguanRefraksiMataKiri','$GangguanRefraksiMataKanan','$GangguanRefraksiRujukRS',
            '$NilaiVisusMataKiri','$NilaiVisusMataKanan','$KatarakMataKiri','$KatarakMataKanan','$KatarakRujukRS')";
        }else{
            $str = "UPDATE `$tbskrining_penglihatan` 
            SET `MataLuar`='$MataLuar',
            `PenglihatanMataKiri`='$PenglihatanMataKiri',`PenglihatanMataKanan`='$PenglihatanMataKanan',
            `ButaWarnaKiri`='$ButaWarnaKiri',`ButaWarnaKanan`='$ButaWarnaKanan',
            `Kacamata`='$Kacamata',`GangguanRefraksiMataKiri`='$GangguanRefraksiMataKiri',
            `GangguanRefraksiMataKanan`='$GangguanRefraksiMataKanan',`GangguanRefraksiRujukRS`='$GangguanRefraksiRujukRS',
            `NilaiVisusMataKiri`='$NilaiVisusMataKiri',`NilaiVisusMataKanan`='$NilaiVisusMataKanan',
            `KatarakMataKiri`='$KatarakMataKiri',`KatarakMataKanan`='$KatarakMataKanan',`KatarakRujukRS`='$KatarakRujukRS'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_penglihatan&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_penglihatan&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_penglihatan
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_penglihatan` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_penglihatan.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">  
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Kesehatan Penglihatan
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pemeriksaan Fisik</p>
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
                                        <td>Mata Luar</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_01" value="normal" <?php if($datapemeriksaan['MataLuar'] == 'normal'){echo "checked";}?>> Normal
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_01" value="tidaksehat" <?php if($datapemeriksaan['MataLuar'] == 'tidaksehat'){echo "checked";}?>> Tidak Sehat
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
                                        <td width="70%">Pemeriksaan</td>
                                        <td width="25%">Hasil</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan = '2'>1.</td>
                                        <td>Tajam Penglihatan (Mata Kiri)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_02" value="normal" <?php if($datapemeriksaan['PenglihatanMataKiri'] == 'normal'){echo "checked";}?>> Normal (6/6 - 6/18)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_02" value="kelainan" <?php if($datapemeriksaan['PenglihatanMataKiri'] == 'kelainan'){echo "checked";}?>> Kelainan Refraksi (< 6/18 - 6/60)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_02" value="lowvision" <?php if($datapemeriksaan['PenglihatanMataKiri'] == 'lowvision'){echo "checked";}?>> Low Vision (6/60 - 3/60)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_02" value="kebutaan" <?php if($datapemeriksaan['PenglihatanMataKiri'] == 'kebutaan'){echo "checked";}?>> Kebutaan (< 3/60)
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tajam Penglihatan (Mata Kanan)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_03" value="normal" <?php if($datapemeriksaan['PenglihatanMataKanan'] == 'normal'){echo "checked";}?>> Normal (6/6 - 6/18)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_03" value="kelainan" <?php if($datapemeriksaan['PenglihatanMataKanan'] == 'kelainan'){echo "checked";}?>> Kelainan Refraksi (< 6/18 - 6/60)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_03" value="lowvision" <?php if($datapemeriksaan['PenglihatanMataKanan'] == 'lowvision'){echo "checked";}?>> Low Vision (6/60 - 3/60)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_03" value="kebutaan" <?php if($datapemeriksaan['PenglihatanMataKanan'] == 'kebutaan'){echo "checked";}?>> Kebutaan (< 3/60)
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan = '2'>2.</td>
                                        <td>Buta Warna (Mata Kiri)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_04" value="ya" <?php if($datapemeriksaan['ButaWarnaKiri'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_04" value="tidak" <?php if($datapemeriksaan['ButaWarnaKiri'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Buta Warna (Mata Kanan)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_05" value="ya" <?php if($datapemeriksaan['ButaWarnaKanan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_05" value="tidak" <?php if($datapemeriksaan['ButaWarnaKanan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Kacamata</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_06" value="ya" <?php if($datapemeriksaan['Kacamata'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_06" value="tidak" <?php if($datapemeriksaan['Kacamata'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan = '3'>4.</td>
                                        <td>Gangguan Refraksi (Mata Kiri)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_07" value="ya" <?php if($datapemeriksaan['GangguanRefraksiMataKiri'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_07" value="tidak" <?php if($datapemeriksaan['GangguanRefraksiMataKiri'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gangguan Refraksi (Mata Kanan)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_08" value="ya" <?php if($datapemeriksaan['GangguanRefraksiMataKanan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_08" value="tidak" <?php if($datapemeriksaan['GangguanRefraksiMataKanan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rujuk RS</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_09" value="ya" <?php if($datapemeriksaan['GangguanRefraksiRujukRS'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_09" value="tidak" <?php if($datapemeriksaan['GangguanRefraksiRujukRS'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan = '2'>5.</td>
                                        <td>Nilai Visus (Mata Kiri)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_10" value="normal" <?php if($datapemeriksaan['NilaiVisusMataKiri'] == 'normal'){echo "checked";}?>> Normal (6/6 - 6/18)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_10" value="kelaianan" <?php if($datapemeriksaan['NilaiVisusMataKiri'] == 'kelaianan'){echo "checked";}?>> Kelainan Refraksi (< 6/18 - 6/60)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_10" value="lowvision" <?php if($datapemeriksaan['NilaiVisusMataKiri'] == 'lowvision'){echo "checked";}?>> Low Vision (6/60 - 3/60)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_10" value="kebutaan" <?php if($datapemeriksaan['NilaiVisusMataKiri'] == 'kebutaan'){echo "checked";}?>> Kebutaan (< 3/60)
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai Visus (Mata Kanan)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_11" value="normal" <?php if($datapemeriksaan['NilaiVisusMataKanan'] == 'normal'){echo "checked";}?>> Normal (6/6 - 6/18)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_11" value="kelaianan" <?php if($datapemeriksaan['NilaiVisusMataKanan'] == 'kelaianan'){echo "checked";}?>> Kelainan Refraksi (< 6/18 - 6/60)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_11" value="lowvision" <?php if($datapemeriksaan['NilaiVisusMataKanan'] == 'lowvision'){echo "checked";}?>> Low Vision (6/60 - 3/60)
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_11" value="kebutaan" <?php if($datapemeriksaan['NilaiVisusMataKanan'] == 'kebutaan'){echo "checked";}?>> Kebutaan (< 3/60)
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan = '3'>6.</td>
                                        <td>Katarak (Mata Kiri)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_12" value="ya" <?php if($datapemeriksaan['KatarakMataKiri'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_12" value="tidak" <?php if($datapemeriksaan['KatarakMataKiri'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Katarak (Mata Kanan)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_13" value="ya" <?php if($datapemeriksaan['KatarakMataKanan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_13" value="tidak" <?php if($datapemeriksaan['KatarakMataKanan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rujuk RS</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="penglihatan_14" value="ya" <?php if($datapemeriksaan['KatarakRujukRS'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="penglihatan_14" value="tidak" <?php if($datapemeriksaan['KatarakRujukRS'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>   
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
