<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $JenisKelamin = $_POST['paru_01'];
    $Umur = $_POST['paru_02'];
    $Kanker = $_POST['paru_03'];
    $Keluarga = $_POST['paru_04'];
    $RiwayatMerokok = $_POST['paru_05'];
    $RiwayatBekerja = $_POST['paru_06'];
    $LingkunganBerpolusi = $_POST['paru_07'];
    $LingkunganTidakSehat = $_POST['paru_08'];
    $DiagnosisParuKronik = $_POST['paru_09'];
    $TotalSkor = $_POST['paru_10'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_kanker_paru`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`JenisKelamin`,`Umur`,
            `Kanker`,`Keluarga`,`RiwayatMerokok`,`RiwayatBekerja`,`LingkunganBerpolusi`,`LingkunganTidakSehat`,
            `DiagnosisParuKronik`,`TotalSkor`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$JenisKelamin','$Umur','$Kanker','$Keluarga',
            '$RiwayatMerokok','$RiwayatBekerja','$LingkunganBerpolusi','$LingkunganTidakSehat',
            '$DiagnosisParuKronik','$TotalSkor')";
        }else{
            $str = "UPDATE `$tbskrining_kanker_paru` 
            SET `JenisKelamin`='$JenisKelamin',`Umur`='$Umur',`Kanker`='$Kanker',`Keluarga`='$Keluarga',
            `RiwayatMerokok`='$RiwayatMerokok',`RiwayatBekerja`='$RiwayatBekerja',
            `LingkunganBerpolusi`='$LingkunganBerpolusi',`LingkunganTidakSehat`='$LingkunganTidakSehat',
            `DiagnosisParuKronik`='$DiagnosisParuKronik',`TotalSkor`='$TotalSkor'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kanker_paru&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_kanker_paru&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_kanker_paru
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_kanker_paru` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_kanker_paru.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Risiko Kanker Paru
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive mt-0">
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
                                        <td>Jenis Kelamin Anda ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_01" value="laki" <?php if($datapemeriksaan['JenisKelamin'] == 'laki'){echo "checked";}?>> Laki-laki
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_01" value="perempuan" <?php if($datapemeriksaan['JenisKelamin'] == 'perempuan'){echo "checked";}?>> Perempuan
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Usia / umur Anda sekarang ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_02" value=">65" <?php if($datapemeriksaan['Umur'] == '>65'){echo "checked";}?>> > 65 Tahun
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_02" value="45" <?php if($datapemeriksaan['Umur'] == '45'){echo "checked";}?>> 45-65 Tahun
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_02" value="<45" <?php if($datapemeriksaan['Umur'] == '<45'){echo "checked";}?>> < 45 Tahun
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Apakah pernah di diagnosis menderita kanker ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_03" value=">5" <?php if($datapemeriksaan['Kanker'] == '>5'){echo "checked";}?>> Ya, pernah > 5 tahun yang lalu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_03" value="<5" <?php if($datapemeriksaan['Kanker'] == '<5'){echo "checked";}?>> Ya, pernah < 5 tahun yang lalu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_03" value="tidak" <?php if($datapemeriksaan['Kanker'] == 'tidak'){echo "checked";}?>> Tidak Pernah
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Apakah ada keluarga (ayah/ ibu/ saudara kandung) menderita kanker ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_04" value="kanker" <?php if($datapemeriksaan['Keluarga'] == 'kanker'){echo "checked";}?>> Ya, Kanker Paru
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_04" value="jenislain" <?php if($datapemeriksaan['Keluarga'] == 'jenislain'){echo "checked";}?>> Ya, Kanker jenis lain
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_04" value="tidak" <?php if($datapemeriksaan['Keluarga'] == 'tidak'){echo "checked";}?>> Tidak ada
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Riwayat merokok / paparan asap rokok (rokok kretek / rokok putih / vape / shisya / cerutu / rokok linting, dll)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_05" value="perokokaktif" <?php if($datapemeriksaan['RiwayatMerokok'] == 'perokokaktif'){echo "checked";}?>> Perokok aktif, masih merokok 1 tahun ini
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_05" value="bekasperokok" <?php if($datapemeriksaan['RiwayatMerokok'] == 'bekasperokok'){echo "checked";}?>> Bekas perokok, berhensi < 15 Tahun
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_05" value="perokokpasif" <?php if($datapemeriksaan['RiwayatMerokok'] == 'perokokpasif'){echo "checked";}?>> Perokok Pasif (dari lingkungan rumah.kantor)
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_05" value="tidakmerokok" <?php if($datapemeriksaan['RiwayatMerokok'] == 'tidakmerokok'){echo "checked";}?>> Tidak Merokok
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Riwayat bekerja di lingkungan yang mengandung zat karsinogen (pertambangan / pabrik / bengkel / garmen / laboratorium kimia / galangan kapal, dII)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_06" value="ya" <?php if($datapemeriksaan['RiwayatBekerja'] == 'ya'){echo "checked";}?>> Ya
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_06" value="tidakyakin" <?php if($datapemeriksaan['RiwayatBekerja'] == 'tidakyakin'){echo "checked";}?>> Tidak Yakin/Ragu-ragu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_06" value="tidak" <?php if($datapemeriksaan['RiwayatBekerja'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Lingkungan tempat tinggal berpolusi tinggi (lingkungan pabrik / pertambangan / tempat buangan sampah / tepi jalan besar)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_07" value="ya" <?php if($datapemeriksaan['LingkunganBerpolusi'] == 'ya'){echo "checked";}?>> Ya
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_07" value="tidakyakin" <?php if($datapemeriksaan['LingkunganBerpolusi'] == 'tidakyakin'){echo "checked";}?>> Tidak Yakin/Ragu-ragu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_07" value="tidak" <?php if($datapemeriksaan['LingkunganBerpolusi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8.</td>
                                        <td>Lingkungan dalam rumah yang tidak sehat (ventilasi buruk / atap dari asbes / lantai tanah / dapur kayu bakar / dapur breket / menggunakan rutin obat nyamuk bakar / semprot, dll)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_08" value="ya" <?php if($datapemeriksaan['LingkunganTidakSehat'] == 'ya'){echo "checked";}?>> Ya
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_08" value="tidakyakin" <?php if($datapemeriksaan['LingkunganTidakSehat'] == 'tidakyakin'){echo "checked";}?>> Tidak Yakin/Ragu-ragu
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_08" value="tidak" <?php if($datapemeriksaan['LingkunganTidakSehat'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9.</td>
                                        <td>Pernah di diagnosis / di obati penyakit paru kronik ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="paru_09" value="tbc" <?php if($datapemeriksaan['DiagnosisParuKronik'] == 'ya'){echo "checked";}?>> Ya, pernah tuberkulosis (TBC)
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_09" value="paru" <?php if($datapemeriksaan['DiagnosisParuKronik'] == 'ya'){echo "checked";}?>> Ya, pernah penyakit paru kronik (PPOK)
                                                </label><br/>
                                                <label>
                                                    <input type="radio" name="paru_09" value="tidak" <?php if($datapemeriksaan['DiagnosisParuKronik'] == 'tidak'){echo "checked";}?>> tidak
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
                        <div class="formbg mt-2">
                           <div class="input-group">
                                <span>
                                    <b>Total Skor</b><br/>
                                    -
                                </span>
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
