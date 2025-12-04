<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $Merokok = $_POST['merokok_01'];
    $Dampak = $_POST['merokok_02'];
    $Melihat = $_POST['merokok_03'];
    $AnggotaKeluarga = $_POST['merokok_04'];
    $Teman = $_POST['merokok_05'];
    $PemeriksaanCo = $_POST['merokok_06'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_merokok`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`Merokok`,`Dampak`,`Melihat`,`AnggotaKeluarga`,`Teman`,`PemeriksaanCo`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$Merokok','$Dampak','$Melihat','$AnggotaKeluarga','$Teman','$PemeriksaanCo')";
        }else{
            $str = "UPDATE `$tbskrining_merokok` SET `Merokok`='$Merokok',`Dampak`='$Dampak',`Melihat`='$Melihat',`AnggotaKeluarga`='$AnggotaKeluarga',`Teman`='$Teman',`PemeriksaanCo`='$PemeriksaanCo'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_merokok&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_merokok&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_merokok
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_merokok` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_merokok.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>"> 
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>"> 
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Merokok
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <p style="font-size: 16px; font-weight: bold;" class="judul"> Perilaku Merokok</p>
                                <tr>
                                    <td class="col-sm-4">Apakah pasien merokok</td>
                                    <td class="col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="merokok_01" value="ya" <?php if($datapemeriksaan['Merokok'] == 'ya'){echo "checked";}?>> Ya, setiap hari
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="merokok_01" value="kadang" <?php if($datapemeriksaan['Merokok'] == 'kadang'){echo "checked";}?>> Kadang kadang
                                            </label>
                                            <label>
                                                <input type="radio" name="merokok_01" value="pernah" <?php if($datapemeriksaan['Merokok'] == 'pernah'){echo "checked";}?>> Pernah mencoba walau satu hisapan
                                            </label>
                                            <label>
                                                <input type="radio" name="merokok_01" value="tidak" <?php if($datapemeriksaan['Merokok'] == 'tidak'){echo "checked";}?>> Tidak merokok
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br/>
                            <table class="table-konten" width="100%">
                                <p style="font-size: 16px; font-weight: bold;" class="judul"> Pengetahuan Tentang Rokok dan Sumber Paparan</p>
                                <tr>
                                    <td class="col-sm-5">Apakah kamu tahu dampak buruk dari merokok ?</td>
                                    <td class="col-sm-7">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="merokok_02" value="ya" <?php if($datapemeriksaan['Dampak'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="merokok_02" value="tidak" <?php if($datapemeriksaan['Dampak'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Apakah kamu pernah melihat orang yang merokok di sekolah?</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="merokok_03" value="ya" <?php if($datapemeriksaan['Melihat'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="merokok_03" value="tidak" <?php if($datapemeriksaan['Melihat'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Apakah ada anggota keluarga di rumah yang merokok ?</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="merokok_04" value="ya" <?php if($datapemeriksaan['AnggotaKeluarga'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="merokok_04" value="tidak" <?php if($datapemeriksaan['AnggotaKeluarga'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Apakah teman-teman dekatmu banyak yang merokok ?</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="merokok_05" value="ya" <?php if($datapemeriksaan['Teman'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="merokok_05" value="tidak" <?php if($datapemeriksaan['Teman'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <p style="font-size: 16px; font-weight: bold;" class="judul mt-3"> Pemeriksaan Kadar CO Pernapasan</p>
                        <div class="table-responsive">
                            <table class="table-konten" width="100%">
                                <tr>
                                    <td class="col-sm-5">Apakah dilakukan pemeriksaan kadar CO pernapasan ?</td>
                                    <td class="col-sm-7">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="merokok_06" value="ya" <?php if($datapemeriksaan['PemeriksaanCo'] == 'ya'){echo "checked";}?>> Ya
                                            </label>&nbsp &nbsp
                                            <label>
                                                <input type="radio" name="merokok_06" value="tidak" <?php if($datapemeriksaan['PemeriksaanCo'] == 'tidak'){echo "checked";}?>> Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
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
