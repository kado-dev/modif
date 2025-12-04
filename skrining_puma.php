<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $JenisKelamin = $_POST['jeniskelamin'];
    $KategoriUsia = $_POST['puma_01'];
    $Merokok = $_POST['puma_02'];
    $NapasPendek = $_POST['puma_03'];
    $Dahak = $_POST['puma_04'];
    $BatukPilek = $_POST['puma_05'];
    $Spirometri = $_POST['puma_06'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_puma`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`JenisKelamin`,`KategoriUsia`,
            `Merokok`,`NapasPendek`,`Dahak`,`BatukPilek`,`Spirometri`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$JenisKelamin','$KategoriUsia',
            '$Merokok','$NapasPendek','$Dahak','$BatukPilek','$Spirometri')";
        }else{
            $str = "UPDATE `$tbskrining_puma` SET 
            `JenisKelamin`='$JenisKelamin',`KategoriUsia`='$KategoriUsia',
            `Merokok`='$Merokok',`NapasPendek`='$NapasPendek',
            `Dahak`='$Dahak',`BatukPilek`='$BatukPilek',`Spirometri`='$Spirometri'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_puma&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_puma&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_puma
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps']; 
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_puma` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_puma.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">   
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Puma / Deteksi dini Penyakit Paru Obstruktif Kronik (PPOK)
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <p style="font-size: 16px; font-weight: bold; border: none;" class="judul mt-3"> Pertanyaan Awal</p>
                        <div class="table-responsive mt--3">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="55%">Pertanyaan</td>
                                        <td width="30%">Jawaban</td>
                                        <td width="10%">Skor</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Jenis kelamin</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="jeniskelamin" value="laki" <?php if($datapemeriksaan['JenisKelamin'] == 'laki'){echo "checked";}?>> Laki-laki
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="jeniskelamin" value="perempuan" <?php if($datapemeriksaan['JenisKelamin'] == 'perempuan'){echo "checked";}?>> Perempuan
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Kategori usia</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="puma_01" value="40" <?php if($datapemeriksaan['KategoriUsia'] == '40'){echo "checked";}?>> 40-49 tahun
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="puma_01" value="50" <?php if($datapemeriksaan['KategoriUsia'] == '50'){echo "checked";}?>> 50-59 tahun
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="puma_01" value="60" <?php if($datapemeriksaan['KategoriUsia'] == '60'){echo "checked";}?>> Lebih/sama dengan 60 tahun
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Apakah merokok</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="puma_02" value="ya" <?php if($datapemeriksaan['Merokok'] == 'ya'){echo "checked";}?>> Ya
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="puma_02" value="tidak" <?php if($datapemeriksaan['Merokok'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Apakah Anda pernah merasa napas pendek ketika Anda berjalan lebih cepat pada jalan datar atau sedikit menanjak?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="puma_03" value="ya" <?php if($datapemeriksaan['NapasPendek'] == 'ya'){echo "checked";}?>> Ya
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="puma_03" value="tidak" <?php if($datapemeriksaan['NapasPendek'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Apakah Anda biasanya mempunyai dahak yang berasal dari paru atau sulit mengeluarkan dahak saat Anda sedang tidak pilek/flu?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="puma_04" value="ya" <?php if($datapemeriksaan['Dahak'] == 'ya'){echo "checked";}?>> Ya
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="puma_04" value="tidak" <?php if($datapemeriksaan['Dahak'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Apakah Anda biasanya batuk saat Anda sedang tidak menderita pilek/flu?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="puma_05" value="ya" <?php if($datapemeriksaan['BatukPilek'] == 'ya'){echo "checked";}?>> Ya
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="puma_05" value="tidak" <?php if($datapemeriksaan['BatukPilek'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Apakah Anda pernah melakukan pemeriksaan spirometri atau peak flow meter (meniup udara ke dalam pipa) untuk mengetahui fungsi paru anda?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="puma_06" value="ya" <?php if($datapemeriksaan['Spirometri'] == 'ya'){echo "checked";}?>> Ya
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="puma_06" value="tidak" <?php if($datapemeriksaan['Spirometri'] == 'tidak'){echo "checked";}?>> Tidak
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
