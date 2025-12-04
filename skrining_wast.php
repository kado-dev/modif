<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $KondisiHubungan = $_POST['wast_01'];
    $Berdebat = $_POST['wast_02'];
    $MerasaSedih = $_POST['wast_03'];
    $Pukulan = $_POST['wast_04'];
    $MerasaTakut = $_POST['wast_05'];
    $MelecehkanFisik = $_POST['wast_06'];
    $MelecehkanEmosioanal = $_POST['wast_07'];
    $MelecehkanSeksual = $_POST['wast_08'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_wast`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`KondisiHubungan`,`Berdebat`,`MerasaSedih`,
            `Pukulan`,`MerasaTakut`,`MelecehkanFisik`,`MelecehkanEmosioanal`,`MelecehkanSeksual`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$KondisiHubungan','$Berdebat','$MerasaSedih',
            '$Pukulan','$MerasaTakut','$MelecehkanFisik','$MelecehkanEmosioanal','$MelecehkanSeksual')";
        }else{
            $str = "UPDATE `$tbskrining_wast` 
            SET `KondisiHubungan`='$KondisiHubungan',`Berdebat`='$Berdebat',
            `MerasaSedih`='$MerasaSedih',`Pukulan`='$Pukulan',
            `MerasaTakut`='$MerasaTakut',`MelecehkanFisik`='$MelecehkanFisik',
            `MelecehkanEmosioanal`='$MelecehkanEmosioanal',`MelecehkanSeksual`='$MelecehkanSeksual'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_wast&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_wast&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_wast
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_wast` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_wast.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">   
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Kekerasan pada Perempuan (Woman Abuse Screening Tools/WAST)
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pertanyaan Awal</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="65%">Pertanyaan</td>
                                        <td width="20%">Jawaban</td>
                                        <td width="10%">Skor</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Secara umum, bagaimana Anda menggambarkan hubungan Anda ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="wast_01" value="tidak" <?php if($datapemeriksaan['KondisiHubungan'] == 'tidak'){echo "checked";}?>> Tidak ada ketegangan
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_01" value="beberapa" <?php if($datapemeriksaan['KondisiHubungan'] == 'beberapa'){echo "checked";}?>> Beberapa ketegangan
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_01" value="banyak" <?php if($datapemeriksaan['KondisiHubungan'] == 'banyak'){echo "checked";}?>> Banyak ketegangan
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Apakah Anda dan pasangan Anda berdebat dengan</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="wast_02" value="tidak" <?php if($datapemeriksaan['Berdebat'] == 'tidak'){echo "checked";}?>> Tidak ada kesulitan
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_02" value="beberapa" <?php if($datapemeriksaan['Berdebat'] == 'beberapa'){echo "checked";}?>> Beberapa kesulitan
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_02" value="kesulitan" <?php if($datapemeriksaan['Berdebat'] == 'kesulitan'){echo "checked";}?>> Kesulitan besar
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br/>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pertanyaan Lanjutan</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="65%">Pertanyaan</td>
                                        <td width="20%">Jawaban</td>
                                        <td width="10%">Skor</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Apakah pertengkaran pernah membuat Anda merasa sedih atau buruk tentang diri sendiri ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="wast_03" value="tidak" <?php if($datapemeriksaan['MerasaSedih'] == 'tidak'){echo "checked";}?>> Tidak pernah
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_03" value="kadang" <?php if($datapemeriksaan['MerasaSedih'] == 'kadang'){echo "checked";}?>> Kadang kadang
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_03" value="sering" <?php if($datapemeriksaan['MerasaSedih'] == 'sering'){echo "checked";}?>> Sering
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Apakah pertengkaran pernah menghasilkan pukulan, tendangan, atau dorongan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="wast_04" value="tidak" <?php if($datapemeriksaan['Pukulan'] == 'tidak'){echo "checked";}?>> Tidak pernah
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_04" value="kadang" <?php if($datapemeriksaan['Pukulan'] == 'kadang'){echo "checked";}?>> Kadang kadang
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_04" value="sering" <?php if($datapemeriksaan['Pukulan'] == 'sering'){echo "checked";}?>> Sering
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Apakah Anda pernah merasa takut dengan apa yang pasangan Anda katakan atau lakukan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="wast_05" value="tidak" <?php if($datapemeriksaan['MerasaTakut'] == 'tidak'){echo "checked";}?>> Tidak pernah
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_05" value="kadang" <?php if($datapemeriksaan['MerasaTakut'] == 'kadang'){echo "checked";}?>> Kadang kadang
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_05" value="sering" <?php if($datapemeriksaan['MerasaTakut'] == 'sering'){echo "checked";}?>> Sering
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Apakah pasangan Anda pernah melecehkan Anda secara fisik ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="wast_06" value="tidak" <?php if($datapemeriksaan['MelecehkanFisik'] == 'tidak'){echo "checked";}?>> Tidak pernah
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_06" value="kadang" <?php if($datapemeriksaan['MelecehkanFisik'] == 'kadang'){echo "checked";}?>> Kadang kadang
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_06" value="sering" <?php if($datapemeriksaan['MelecehkanFisik'] == 'sering'){echo "checked";}?>> Sering
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Pernahkah pasangan Anda melecehkan Anda secara emosional ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="wast_07" value="tidak" <?php if($datapemeriksaan['MelecehkanEmosioanal'] == 'tidak'){echo "checked";}?>> Tidak pernah
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_07" value="kadang" <?php if($datapemeriksaan['MelecehkanEmosioanal'] == 'kadang'){echo "checked";}?>> Kadang kadang
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_07" value="sering" <?php if($datapemeriksaan['MelecehkanEmosioanal'] == 'sering'){echo "checked";}?>> Sering
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Apakah pasangan Anda pernah melecehkan Anda secara seksual ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="wast_08" value="tidak" <?php if($datapemeriksaan['MelecehkanSeksual'] == 'tidak'){echo "checked";}?>> Tidak pernah
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_08" value="kadang" <?php if($datapemeriksaan['MelecehkanSeksual'] == 'kadang'){echo "checked";}?>> Kadang kadang
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="wast_08" value="sering" <?php if($datapemeriksaan['MelecehkanSeksual'] == 'sering'){echo "checked";}?>> Sering
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
?>
