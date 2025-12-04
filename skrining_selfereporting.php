<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $SakitKepala = $_POST['selfe_01'];
    $NafsuMakan = $_POST['selfe_02'];
    $TidakNyenyak = $_POST['selfe_03'];
    $MerasaTakut = $_POST['selfe_04'];
    $MerasaCemas = $_POST['selfe_05'];
    $Gemetar = $_POST['selfe_06'];
    $Pencernaan = $_POST['selfe_07'];
    $BerfikirJernih = $_POST['selfe_08'];
    $TidakBahagia = $_POST['selfe_09'];
    $SeringMenangis = $_POST['selfe_10'];
    $MerasaSulitAktifitas = $_POST['selfe_11'];
    $MerasaSulitKeputusan = $_POST['selfe_12'];
    $TugasTerbengkalai = $_POST['selfe_13'];
    $TidakBerperan = $_POST['selfe_14'];
    $KehilanganMinat = $_POST['selfe_15'];
    $TidakBerharga = $_POST['selfe_16'];
    $MengakhiriHidup = $_POST['selfe_17'];
    $Lelah = $_POST['selfe_18'];
    $TidakEnakPerut = $_POST['selfe_19'];
    $MudahLelah = $_POST['selfe_20'];
    $MinumAlkohol = $_POST['selfe_21'];
    $Mencelakai = $_POST['selfe_22'];
    $MenggangguPikiran = $_POST['selfe_23'];
    $MendengarSuara = $_POST['selfe_24'];
    $Mimpi = $_POST['selfe_25'];
    $MenghindariKegiatan = $_POST['selfe_26'];
    $TerhadapTeman = $_POST['selfe_27'];
    $MeningatkanBencana = $_POST['selfe_28'];
    $KesulitanMemahami = $_POST['selfe_29'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_selfereporting`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`SakitKepala`, 
            `NafsuMakan`, `TidakNyenyak`, `MerasaTakut`, `MerasaCemas`, `Gemetar`, `Pencernaan`, 
            `BerfikirJernih`, `TidakBahagia`, `SeringMenangis`, `MerasaSulitAktifitas`, 
            `MerasaSulitKeputusan`, `TugasTerbengkalai`, `TidakBerperan`, `KehilanganMinat`, 
            `TidakBerharga`, `MengakhiriHidup`, `Lelah`, `TidakEnakPerut`, `MudahLelah`, 
            `MinumAlkohol`, `Mencelakai`, `MenggangguPikiran`, `MendengarSuara`, `Mimpi`, 
            `MenghindariKegiatan`, `TerhadapTeman`, `MeningatkanBencana`, `KesulitanMemahami`) 
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$SakitKepala','$NafsuMakan','$TidakNyenyak',
            '$MerasaTakut','$MerasaCemas','$Gemetar','$Pencernaan','$BerfikirJernih',
            '$TidakBahagia','$SeringMenangis','$MerasaSulitAktifitas','$MerasaSulitKeputusan','$TugasTerbengkalai',
            '$TidakBerperan','$KehilanganMinat','$TidakBerharga','$MengakhiriHidup','$Lelah',
            '$TidakEnakPerut','$MudahLelah','$MinumAlkohol','$Mencelakai','$MenggangguPikiran',
            '$MendengarSuara','$Mimpi','$MenghindariKegiatan','$TerhadapTeman','$MeningatkanBencana',
            '$KesulitanMemahami')";
        }else{
            $str = "UPDATE `$tbskrining_selfereporting` 
            SET `SakitKepala`='$SakitKepala',`NafsuMakan`='$NafsuMakan',
            `TidakNyenyak`='$TidakNyenyak',`MerasaTakut`='$MerasaTakut',`MerasaCemas`='$MerasaCemas',
            `Gemetar`='$Gemetar',`Pencernaan`='$Pencernaan',`BerfikirJernih`='$BerfikirJernih',
            `TidakBahagia`='$TidakBahagia',`SeringMenangis`='$SeringMenangis',`MerasaSulitAktifitas`='$MerasaSulitAktifitas',
            `MerasaSulitKeputusan`='$MerasaSulitKeputusan',`TugasTerbengkalai`='$TugasTerbengkalai',`TidakBerperan`='$TidakBerperan',
            `KehilanganMinat`='$KehilanganMinat',`TidakBerharga`='$TidakBerharga',`MengakhiriHidup`='$MengakhiriHidup',
            `Lelah`='$Lelah',`TidakEnakPerut`='$TidakEnakPerut',`MudahLelah`='$MudahLelah',
            `MinumAlkohol`='$MinumAlkohol',`Mencelakai`='$Mencelakai',`MenggangguPikiran`='$MenggangguPikiran',
            `MendengarSuara`='$MendengarSuara',`Mimpi`='$Mimpi',`MenghindariKegiatan`='$MenghindariKegiatan',
            `TerhadapTeman`='$TerhadapTeman',`MeningatkanBencana`='$MeningatkanBencana',`KesulitanMemahami`='$KesulitanMemahami'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_selfereporting&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_selfereporting&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_wast
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_selfereporting` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_selfereporting.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">   
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>">
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="formbg">
                    <div class="input-group">
                        <b>Perhatikan</b>
                        <p>Pertanyaan berikut berhubungan dengan masalah yang mungkin mengganggu Anda selama 30 hari terakhir. Jika Anda tidak yakin tentang jawabannya, berilah jawaban yang paling sesuai di antara Ya dan Tidak. Jawaban Anda bersifat rahasia dan akan digunakan hanya untuk membantu pemecahan masalah Anda.</p>
                    </div>	
                </div>
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Self-Reporting Questionnaire-29
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive mt-0">
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
                                        <td>Apakah Anda sering merasa sakit kepala ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_01" value="ya" <?php if($datapemeriksaan['SakitKepala'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_01" value="tidak" <?php if($datapemeriksaan['SakitKepala'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Apakah Anda kehilangan nafsu makan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_02" value="ya" <?php if($datapemeriksaan['NafsuMakan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_02" value="tidak" <?php if($datapemeriksaan['NafsuMakan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Apakah tidur Anda tidak nyenyak ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_03" value="ya" <?php if($datapemeriksaan['TidakNyenyak'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_03" value="tidak" <?php if($datapemeriksaan['TidakNyenyak'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Apakah Anda mudah merasa takut ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_04" value="ya" <?php if($datapemeriksaan['MerasaTakut'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_04" value="tidak" <?php if($datapemeriksaan['MerasaTakut'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Apakah Anda merasa cemas, tegang, atau khawatir ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_05" value="ya" <?php if($datapemeriksaan['MerasaCemas'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_05" value="tidak" <?php if($datapemeriksaan['MerasaCemas'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Apakah tangan Anda gemetar ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_06" value="ya" <?php if($datapemeriksaan['Gemetar'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_06" value="tidak" <?php if($datapemeriksaan['Gemetar'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Apakah Anda mengalami gangguan pencernaan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_07" value="ya" <?php if($datapemeriksaan['Pencernaan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_07" value="tidak" <?php if($datapemeriksaan['Pencernaan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8.</td>
                                        <td>Apakah Anda merasa sulit berpikir jernih ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_08" value="ya" <?php if($datapemeriksaan['BerfikirJernih'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_08" value="tidak" <?php if($datapemeriksaan['BerfikirJernih'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9.</td>
                                        <td>Apakah Anda merasa tidak bahagia ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_09" value="ya" <?php if($datapemeriksaan['TidakBahagia'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_09" value="tidak" <?php if($datapemeriksaan['TidakBahagia'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10.</td>
                                        <td>Apakah Anda lebih sering menangis ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_10" value="ya" <?php if($datapemeriksaan['SeringMenangis'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_10" value="tidak" <?php if($datapemeriksaan['SeringMenangis'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>11.</td>
                                        <td>Apakah Anda merasa sulit untuk menikmati aktivitas sehari-hari ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_11" value="ya" <?php if($datapemeriksaan['MerasaSulitAktifitas'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_11" value="tidak" <?php if($datapemeriksaan['MerasaSulitAktifitas'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>12.</td>
                                        <td>Apakah Anda mengalami kesulitan untuk mengambil keputusan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_12" value="ya" <?php if($datapemeriksaan['MerasaSulitKeputusan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_12" value="tidak" <?php if($datapemeriksaan['MerasaSulitKeputusan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>13.</td>
                                        <td>Apakah aktivitas/tugas sehari-hari Anda terbengkalai ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_13" value="ya" <?php if($datapemeriksaan['TugasTerbengkalai'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_13" value="tidak" <?php if($datapemeriksaan['TugasTerbengkalai'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>14.</td>
                                        <td>Apakah Anda merasa tidak mampu berperan dalam kehidupan ini ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_14" value="ya" <?php if($datapemeriksaan['TidakBerperan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_14" value="tidak" <?php if($datapemeriksaan['TidakBerperan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>15.</td>
                                        <td>Apakah Anda kehilangan minat terhadap banyak hal ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_15" value="ya" <?php if($datapemeriksaan['KehilanganMinat'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_15" value="tidak" <?php if($datapemeriksaan['KehilanganMinat'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>16.</td>
                                        <td>Apakah Anda merasa tidak berharga ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_16" value="ya" <?php if($datapemeriksaan['TidakBerharga'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_16" value="tidak" <?php if($datapemeriksaan['TidakBerharga'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>17.</td>
                                        <td>Apakah Anda mempunyai pikiran untuk mengakhiri hidup Anda ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_17" value="ya" <?php if($datapemeriksaan['MengakhiriHidup'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_17" value="tidak" <?php if($datapemeriksaan['MengakhiriHidup'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>18.</td>
                                        <td>Apakah Anda merasa lelah sepanjang waktu ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_18" value="ya" <?php if($datapemeriksaan['Lelah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_18" value="tidak" <?php if($datapemeriksaan['Lelah'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>19.</td>
                                        <td>Apakah Anda merasa tidak enak di perut ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_19" value="ya" <?php if($datapemeriksaan['TidakEnakPerut'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_19" value="tidak" <?php if($datapemeriksaan['TidakEnakPerut'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>20.</td>
                                        <td>Apakah Anda mudah lelah ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_20" value="ya" <?php if($datapemeriksaan['MudahLelah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_20" value="tidak" <?php if($datapemeriksaan['MudahLelah'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>21.</td>
                                        <td>Apakah Anda minum alkohol lebih banyak dari biasanya atau Anda menggunakan narkoba ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_21" value="ya" <?php if($datapemeriksaan['MinumAlkohol'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_21" value="tidak" <?php if($datapemeriksaan['MinumAlkohol'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>22.</td>
                                        <td>Apakah Anda yakin bahwa seseorang mencoba mencelakai Anda dengan cara tertentu ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_22" value="ya" <?php if($datapemeriksaan['Mencelakai'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_22" value="tidak" <?php if($datapemeriksaan['Mencelakai'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>23.</td>
                                        <td>Apakah ada yang mengganggu atau hal yang tidak biasa dalam pikiran Anda ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_23" value="ya" <?php if($datapemeriksaan['MenggangguPikiran'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_23" value="tidak" <?php if($datapemeriksaan['MenggangguPikiran'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>24.</td>
                                        <td>Apakah Anda pernah mendengar suara tanpa tahu sumbernya atau yang orang lain tidak dapat mendengar ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_24" value="ya" <?php if($datapemeriksaan['MendengarSuara'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_24" value="tidak" <?php if($datapemeriksaan['MendengarSuara'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>25.</td>
                                        <td>Apakah Anda mengalami mimpi yang mengganggu tentang suatu bencana/musibah atau adakah saat-saat Anda seolah mengalami kembali kejadian bencana tersebut ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_25" value="ya" <?php if($datapemeriksaan['Mimpi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_25" value="tidak" <?php if($datapemeriksaan['Mimpi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>26.</td>
                                        <td>Apakah Anda menghindari kegiatan, tempat, orang atau pikiran yang mengingatkan Anda akan bencana tersebut ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_26" value="ya" <?php if($datapemeriksaan['MenghindariKegiatan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_26" value="tidak" <?php if($datapemeriksaan['MenghindariKegiatan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>27.</td>
                                        <td>Apakah minat Anda terhadap teman dan kegiatan yang biasa Anda lakukan berkurang ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_27" value="ya" <?php if($datapemeriksaan['TerhadapTeman'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_27" value="tidak" <?php if($datapemeriksaan['TerhadapTeman'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>28.</td>
                                        <td>Apakah Anda merasa sangat terganggu jika berada dalam situasi yang mengingatkan Anda akan bencana atau jika Anda berpikir tentang bencana itu ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_28" value="ya" <?php if($datapemeriksaan['MeningatkanBencana'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_28" value="tidak" <?php if($datapemeriksaan['MeningatkanBencana'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>29.</td>
                                        <td>Apakah Anda kesulitan memahami atau mengekspresikan perasaan Anda ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="selfe_29" value="ya" <?php if($datapemeriksaan['KesulitanMemahami'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="selfe_29" value="tidak" <?php if($datapemeriksaan['KesulitanMemahami'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                        <br/>
                        <div class="formbg mt-2">
                           <div class="input-group">
                                <span>
                                    <b>Interpretasi</b><br/>
                                    Jawab semua pertanyaan untuk melihat interpretasi
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
