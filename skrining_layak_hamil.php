<?php
    session_start();
    include "config/koneksi.php";
    include "config/helper_pasienrj.php";

    // variabel
    $tanggal_time = date('Y-m-d')." ".date('G:i:s');
    $LingkarLengan = $_POST['layakhamil_01'];
    $KadarHb = $_POST['layakhamil_02'];
    $JumlahAnak = $_POST['layakhamil_03'];
    $WaktuPersalinan = $_POST['layakhamil_04'];
    $SedangHamil = $_POST['layakhamil_05'];
    $InginHamil = $_POST['layakhamil_06'];
    $Hipertensi = $_POST['layakhamil_07'];
    $Diabetes = $_POST['layakhamil_08'];
    $Jantung = $_POST['layakhamil_09'];
    $Asma = $_POST['layakhamil_10'];
    $Ginjal = $_POST['layakhamil_11'];
    $Gondok = $_POST['layakhamil_12'];
    $Autoimun = $_POST['layakhamil_13'];
    $Kanker = $_POST['layakhamil_14'];
    $Malaria = $_POST['layakhamil_15'];
    $Torch = $_POST['layakhamil_16'];
    $TbParu = $_POST['layakhamil_17'];
    $Hepatitis = $_POST['layakhamil_18'];
    $Pms = $_POST['layakhamil_19'];
    $Hiv = $_POST['layakhamil_20'];
    $GangguanMental = $_POST['layakhamil_21'];
    $Talasemia = $_POST['layakhamil_22'];
    $SakitKepala = $_POST['layakhamil_23'];
    $NafsuMakan = $_POST['layakhamil_24'];
    $TidakLelap = $_POST['layakhamil_25'];
    $MejadiKuat = $_POST['layakhamil_26'];
    $Cemas = $_POST['layakhamil_27'];
    $Gemetar = $_POST['layakhamil_28'];
    $GangguanPencernaan = $_POST['layakhamil_29'];
    $SulitBerpikir = $_POST['layakhamil_30'];
    $TidakBahagia = $_POST['layakhamil_31'];
    $SeringNangis = $_POST['layakhamil_32'];
    $SulitAktivitas = $_POST['layakhamil_33'];
    $SulitKeputusan = $_POST['layakhamil_34'];
    $TidakBerperanHidup = $_POST['layakhamil_35'];
    $KehilanganMinat = $_POST['layakhamil_36'];
    $TidakBerharga = $_POST['layakhamil_37'];
    $MerasaSulit = $_POST['layakhamil_38'];
    $MengakhiriHidup = $_POST['layakhamil_39'];
    $LelahSepanjangWaktu = $_POST['layakhamil_40'];
    $TidakEnakPerut = $_POST['layakhamil_41'];
    $MudahLelah = $_POST['layakhamil_42'];
    $HasilSkrining = $_POST['hasilshrining'];
       
    if($_POST['btnsimpan'] == 'simpan'){
        include "config/helper.php";
        $idpasienrj  = $_POST['idpasienrj'];
        $idpasien  = $_POST['idpasien'];
        $idsiklushidup  = $_POST['idsh'];
        $status  = $_POST['status'];

        // tahap 1, simpan
        if($status == 'simpan'){
            $str = "INSERT INTO `$tbskrining_layak_hamil`(`IdPasienrj`,`IdPasien`,`TanggalPeriksa`,`LingkarLengan`, `KadarHb`, 
             `JumlahAnak`, `WaktuPersalinan`, `SedangHamil`, `InginHamil`, `Hipertensi`, `Diabetes`, 
             `Jantung`, `Asma`, `Ginjal`, `Gondok`, `Autoimun`, `Kanker`, `Malaria`, `Torch`, `TbParu`, 
             `Hepatitis`, `Pms`, `Hiv`, `GangguanMental`, `Talasemia`, `SakitKepala`, `NafsuMakan`, 
             `TidakLelap`, `MejadiKuat`, `Cemas`, `Gemetar`, `GangguanPencernaan`, `SulitBerpikir`, 
             `TidakBahagia`, `SeringNangis`, `SulitAktivitas`, `SulitKeputusan`, `TidakBerperanHidup`, 
             `KehilanganMinat`, `TidakBerharga`, `MerasaSulit`, `MengakhiriHidup`, `LelahSepanjangWaktu`, 
             `TidakEnakPerut`, `MudahLelah`, `HasilSkrining`)
            VALUES ('$idpasienrj','$idpasien','$tanggal_time','$LingkarLengan','$KadarHb',
            '$JumlahAnak','$WaktuPersalinan','$SedangHamil','$InginHamil','$Hipertensi','$Diabetes',
            '$Jantung','$Asma','$Ginjal','$Gondok','$Autoimun','$Kanker','$Malaria','$Torch','$TbParu',
            '$Hepatitis','$Pms','$Hiv','$GangguanMental','$Talasemia','$SakitKepala','$NafsuMakan',
            '$TidakLelap','$MejadiKuat','$Cemas','$Gemetar','$GangguanPencernaan','$SulitBerpikir',
            '$TidakBahagia','$SeringNangis','$SulitAktivitas','$SulitKeputusan','$TidakBerperanHidup',
            '$KehilanganMinat','$TidakBerharga','$MerasaSulit','$MengakhiriHidup','$LelahSepanjangWaktu',
            '$TidakEnakPerut','$MudahLelah','$HasilSkrining')";
        }else{
            $str = "UPDATE `$tbskrining_layak_hamil` 
            SET `LingkarLengan`='$LingkarLengan',`KadarHb`='$KadarHb',
            `JumlahAnak`='$JumlahAnak',`WaktuPersalinan`='$WaktuPersalinan',`WaktuPersalinan`='$WaktuPersalinan',
            `SedangHamil`='$SedangHamil',`InginHamil`='$InginHamil',`Hipertensi`='$Hipertensi',
            `Diabetes`='$Diabetes',`Jantung`='$Jantung',`Asma`='$Asma',`Ginjal`='$Ginjal',`Gondok`='$Gondok',
            `Autoimun`='$Autoimun',`Kanker`='$Kanker',`Malaria`='$Malaria',`Torch`='$Torch',`TbParu`='$TbParu',
            `Hepatitis`='$Hepatitis',`Pms`='$Pms',`Hiv`='$Hiv',`GangguanMental`='$GangguanMental',`Talasemia`='$Talasemia',
            `SakitKepala`='$SakitKepala',`NafsuMakan`='$NafsuMakan',`TidakLelap`='$TidakLelap',`MejadiKuat`='$MejadiKuat',
            `Cemas`='$Cemas',`Gemetar`='$Gemetar',`GangguanPencernaan`='$GangguanPencernaan',`SulitBerpikir`='$SulitBerpikir',
            `TidakBahagia`='$TidakBahagia',`SeringNangis`='$SeringNangis',`SulitAktivitas`='$SulitAktivitas',
            `SulitKeputusan`='$SulitKeputusan',`TidakBerperanHidup`='$TidakBerperanHidup',`KehilanganMinat`='$KehilanganMinat',
            `TidakBerharga`='$TidakBerharga',`MerasaSulit`='$MerasaSulit',`MengakhiriHidup`='$MengakhiriHidup',
            `LelahSepanjangWaktu`='$LelahSepanjangWaktu',`TidakEnakPerut`='$TidakEnakPerut',`MudahLelah`='$MudahLelah',`HasilSkrining`='$HasilSkrining'
            WHERE `IdPasienrj`='$idpasienrj'";
        } 
        // echo $str;
        // die();
        $query = mysqli_query($koneksi, $str);

        if($query){
            alert_swal('sukses','Data berhasil disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_layak_hamil&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }else{
            alert_swal('gagal','Data gagal disimpan');
            echo "<script>";
            echo "document.location.href='index.php?page=skrining_layak_hamil&idrj=$idpasienrj&idps=$idpasien&idsh=$idsiklushidup';";	
            echo "</script>";
        }

    }else{

    // tahap 2, cek data skrining_wast
    $idpasienrj = $_GET['id']; 
    $idpasien = $_GET['idps'];
    $idsiklushidup = $_GET['idsh'];
    $querypemeriksaan = mysqli_query($koneksi, "SELECT * FROM `$tbskrining_layak_hamil` WHERE `IdPasien` = '$idpasien'");
    $datapemeriksaan = mysqli_fetch_assoc($querypemeriksaan);
?>

<?php include "identitaspasien.php";?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <form action="skrining_layak_hamil.php" method="post">  
                <input type="hidden" name="idpasienrj" value="<?php echo $_GET['idrj'];?>">
                <input type="hidden" name="idpasien" value="<?php echo $_GET['idps'];?>">  
                <input type="hidden" name="idsh" value="<?php echo $_GET['idsh'];?>"> 
                <input type="hidden" name="status" value="<?php echo (mysqli_num_rows($querypemeriksaan) > 0) ? 'edit': 'simpan';?>" class="statussimpan"/>                                
                <div class="card">
                    <div class="card-body">
                        <p style="font-size: 20px; font-weight: bold;" class="judul">Skrining Layak Hamil
                            <a href="index.php?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $idsiklushidup;?>" class="btn btn-info btn-round pull-right">Kembali</a>
                        </p>
                        <div class="table-responsive mt-0">
                            <table class="table-judul" width="100%">
                                <thead>
                                    <tr>
                                        <td width="5%">No.</td>
                                        <td width="50%">Pemeriksaan</td>
                                        <td width="45%">Hasil</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Lingkar Lengan Atas</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_01" value=">25" <?php if($datapemeriksaan['LingkarLengan'] == '>25'){echo "checked";}?>> ≥ 23,5 cm
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_01" value="<25" <?php if($datapemeriksaan['LingkarLengan'] == '<25'){echo "checked";}?>> < 23.5 cm
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Kadar Hb</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_02" value=">12" <?php if($datapemeriksaan['KadarHb'] == '>12'){echo "checked";}?>> Hb ≥ 12 g/dL
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_02" value="<12" <?php if($datapemeriksaan['KadarHb'] == '<12'){echo "checked";}?>> Hb < 12 g/dL
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_02" value="tidak" <?php if($datapemeriksaan['KadarHb'] == 'tidak'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Jumlah Anak</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_03" value="<3" <?php if($datapemeriksaan['JumlahAnak'] == '<3'){echo "checked";}?>> 1-2 anak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_03" value=">3" <?php if($datapemeriksaan['JumlahAnak'] == '>3'){echo "checked";}?>> ≥ 3 anak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_03" value="belum" <?php if($datapemeriksaan['JumlahAnak'] == 'belum'){echo "checked";}?>> Belum Punya Anak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td> Waktu Persalinan Terakhir</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_04" value=">2tahun" <?php if($datapemeriksaan['WaktuPersalinan'] == '>2tahun'){echo "checked";}?>> ≥ 2 tahun lalu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_04" value="2tahunlalu" <?php if($datapemeriksaan['WaktuPersalinan'] == '2tahunlalu'){echo "checked";}?>> 2 Tahun Lalu
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_04" value="belum" <?php if($datapemeriksaan['WaktuPersalinan'] == 'belum'){echo "checked";}?>> Belum Pernah Melakukan Persalinan
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>#</b></td>
                                        <td><b>Pilih Semua Jawaban</b></td>
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
                                        <td>5.</td>
                                        <td>Apakah sedang hamil ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_05" value="ya" <?php if($datapemeriksaan['SedangHamil'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_05" value="tidak" <?php if($datapemeriksaan['SedangHamil'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Apakah masih mengiginkan kehamilan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_06" value="ya" <?php if($datapemeriksaan['InginHamil'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_06" value="tidak" <?php if($datapemeriksaan['InginHamil'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan='17'>7</td>
                                        <td>Apakah Anda pernah atau sedang menderita penyakit di bawah ini ?</td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Pilih Semua Jawaban</b></td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="pilihsemua" value="ya"> <b>Ya</b>
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="pilihsemua" value="tidak"> <b>Tidak</b>
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="pilihsemua" value="tidaktahu"> <b>Tidak Tahu</b>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Darah Tinggi (Hipertensi)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_07" value="ya" <?php if($datapemeriksaan['Hipertensi'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_07" value="tidak" <?php if($datapemeriksaan['Hipertensi'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_07" value="tidaktahu" <?php if($datapemeriksaan['Hipertensi'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Diabetes Melitus</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_08" value="ya" <?php if($datapemeriksaan['Diabetes'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_08" value="tidak" <?php if($datapemeriksaan['Diabetes'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_08" value="tidaktahu" <?php if($datapemeriksaan['Diabetes'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Penyakit Jantung</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_09" value="ya" <?php if($datapemeriksaan['Jantung'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_09" value="tidak" <?php if($datapemeriksaan['Jantung'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_09" value="tidaktahu" <?php if($datapemeriksaan['Jantung'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Asma</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_10" value="ya" <?php if($datapemeriksaan['Asma'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_10" value="tidak" <?php if($datapemeriksaan['Asma'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_10" value="tidaktahu" <?php if($datapemeriksaan['Asma'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Penyakit Ginjal Kronis</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_11" value="ya" <?php if($datapemeriksaan['Ginjal'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_11" value="tidak" <?php if($datapemeriksaan['Ginjal'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_11" value="tidaktahu" <?php if($datapemeriksaan['Ginjal'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gondok (Tiroid)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_12" value="ya" <?php if($datapemeriksaan['Gondok'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_12" value="tidak" <?php if($datapemeriksaan['Gondok'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_12" value="tidaktahu" <?php if($datapemeriksaan['Gondok'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Penyakit auto imun (SLE,dll)</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_13" value="ya" <?php if($datapemeriksaan['Autoimun'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_13" value="tidak" <?php if($datapemeriksaan['Autoimun'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_13" value="tidaktahu" <?php if($datapemeriksaan['Autoimun'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kanker</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_14" value="ya" <?php if($datapemeriksaan['Kanker'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_14" value="tidak" <?php if($datapemeriksaan['Kanker'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_14" value="tidaktahu" <?php if($datapemeriksaan['Kanker'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Malaria</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_15" value="ya" <?php if($datapemeriksaan['Malaria'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_15" value="tidak" <?php if($datapemeriksaan['Malaria'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_15" value="tidaktahu" <?php if($datapemeriksaan['Malaria'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Torch</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_16" value="ya" <?php if($datapemeriksaan['Torch'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_16" value="tidak" <?php if($datapemeriksaan['Torch'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_16" value="tidaktahu" <?php if($datapemeriksaan['Torch'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TB Paru</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_17" value="ya" <?php if($datapemeriksaan['TbParu'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_17" value="tidak" <?php if($datapemeriksaan['TbParu'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_17" value="tidaktahu" <?php if($datapemeriksaan['TbParu'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hepatitis</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_18" value="ya" <?php if($datapemeriksaan['Hepatitis'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_18" value="tidak" <?php if($datapemeriksaan['Hepatitis'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_18" value="tidaktahu" <?php if($datapemeriksaan['Hepatitis'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Penyakit Menular Seksual</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_19" value="ya" <?php if($datapemeriksaan['Pms'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_19" value="tidak" <?php if($datapemeriksaan['Pms'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_19" value="tidaktahu" <?php if($datapemeriksaan['Pms'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>HIV</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_20" value="ya" <?php if($datapemeriksaan['Hiv'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_20" value="tidak" <?php if($datapemeriksaan['Hiv'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_20" value="tidaktahu" <?php if($datapemeriksaan['Hiv'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gangguan Mental</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_21" value="ya" <?php if($datapemeriksaan['GangguanMental'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_21" value="tidak" <?php if($datapemeriksaan['GangguanMental'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_21" value="tidaktahu" <?php if($datapemeriksaan['GangguanMental'] == 'tidaktahu'){echo "checked";}?>> Tidak Tahu
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8.</td>
                                        <td>Talasemi/Hemofilia ?</td>
                                        <td>
                                            <div class="radio">
                                                <?php $prktalasemi = explode(',',$datapemeriksaan['Talasemia']);?>
                                                <label><input type="checkbox" name="takasemi[]" value="Pembawa Sifat Hemofilia" <?php if (in_array("Pembawa Sifat Hemofilia", $prktalasemi)) {echo "checked";}?>> Pembawa Sifat Hemofilia</label><br>
                                                <label><input type="checkbox" name="takasemi[]" value="Penderita Hemofilia" <?php if (in_array("Penderita Hemofilia", $prktalasemi)) {echo "checked";}?>> Penderita Hemofilia</label><br>
                                                <label><input type="checkbox" name="takasemi[]" value="Pembawa Sifat Talasemia" <?php if (in_array("Pembawa Sifat Talasemia", $prktalasemi)) {echo "checked";}?>> Pembawa Sifat Talasemia</label><br>
                                                <label><input type="checkbox" name="takasemi[]" value="Penderita Hemofilia" <?php if (in_array("Penderita Hemofilia", $prktalasemi)) {echo "checked";}?>> Penderita Hemofilia</label><br>
                                                <label><input type="checkbox" name="takasemi[]" value="Tidak Ada" <?php if (in_array("Tidak Ada", $prktalasemi)) {echo "checked";}?>> Tidak Ada</label><br>
										    </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>9.</td>
                                        <td>Apakah Anda sering menderita sakit kepala ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_22" value="ya" <?php if($datapemeriksaan['SakitKepala'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_22" value="tidak" <?php if($datapemeriksaan['SakitKepala'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10.</td>
                                        <td>Apakah Anda kehilangan nafsu makan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_23" value="ya" <?php if($datapemeriksaan['NafsuMakan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_23" value="tidak" <?php if($datapemeriksaan['NafsuMakan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>11.</td>
                                        <td>Apakah tidur Anda tidak lelap ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_24" value="ya" <?php if($datapemeriksaan['TidakLelap'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_24" value="tidak" <?php if($datapemeriksaan['TidakLelap'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>12.</td>
                                        <td>Apakah Anda mudah menjadi takut ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_25" value="ya" <?php if($datapemeriksaan['MejadiKuat'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_25" value="tidak" <?php if($datapemeriksaan['MejadiKuat'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>13.</td>
                                        <td>Apakah Anda merasa cemas, tegang dan khawatir ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_26" value="ya" <?php if($datapemeriksaan['Cemas'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_26" value="tidak" <?php if($datapemeriksaan['Cemas'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>14.</td>
                                        <td>Apakah tangan Anda gemetar ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_27" value="ya" <?php if($datapemeriksaan['Gemetar'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_27" value="tidak" <?php if($datapemeriksaan['Gemetar'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>15.</td>
                                        <td>Apakah Anda mengalami gangguan pencernaan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_28" value="ya" <?php if($datapemeriksaan['GangguanPencernaan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_28" value="tidak" <?php if($datapemeriksaan['GangguanPencernaan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>16.</td>
                                        <td>Apakah Anda merasa sulit berpikir jernih ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_29" value="ya" <?php if($datapemeriksaan['SulitBerpikir'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_29" value="tidak" <?php if($datapemeriksaan['SulitBerpikir'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>17.</td>
                                        <td>Apakah Anda merasa tidak bahagia ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_30" value="ya" <?php if($datapemeriksaan['TidakBahagia'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_30" value="tidak" <?php if($datapemeriksaan['TidakBahagia'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>18.</td>
                                        <td>Apakah Anda lebih sering menangis ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_31" value="ya" <?php if($datapemeriksaan['SeringNangis'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_31" value="tidak" <?php if($datapemeriksaan['SeringNangis'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>19.</td>
                                        <td>Apakah Anda merasa sulit untuk menikmati aktivitas sehari-hari ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_32" value="ya" <?php if($datapemeriksaan['SulitAktivitas'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_32" value="tidak" <?php if($datapemeriksaan['SulitAktivitas'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>20.</td>
                                        <td>Apakah Anda mengalami kesulitan untuk mengambil keputusan ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_33" value="ya" <?php if($datapemeriksaan['SulitKeputusan'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_33" value="tidak" <?php if($datapemeriksaan['SulitKeputusan'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>21.</td>
                                        <td>Apakah Anda merasa tidak mampu berperan dalam kehidupan ini ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_34" value="ya" <?php if($datapemeriksaan['TidakBerperanHidup'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_34" value="tidak" <?php if($datapemeriksaan['TidakBerperanHidup'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>22.</td>
                                        <td>Apakah Anda kehilangan minat terhadap banyak hal ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_35" value="ya" <?php if($datapemeriksaan['KehilanganMinat'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_35" value="tidak" <?php if($datapemeriksaan['KehilanganMinat'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>23.</td>
                                        <td>Apakah Anda merasa tidak berharga ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_36" value="ya" <?php if($datapemeriksaan['TidakBerharga'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_36" value="tidak" <?php if($datapemeriksaan['TidakBerharga'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>24.</td>
                                        <td>Apakah Anda merasa sulit untuk menikmati aktivitas sehari-hari ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_37" value="ya" <?php if($datapemeriksaan['MerasaSulit'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_37" value="tidak" <?php if($datapemeriksaan['MerasaSulit'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>25.</td>
                                        <td>Apakah Anda mempunyai pikiran untuk mengakhiri hidup Anda ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_38" value="ya" <?php if($datapemeriksaan['MengakhiriHidup'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_38" value="tidak" <?php if($datapemeriksaan['MengakhiriHidup'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>26.</td>
                                        <td>Apakah Anda merasa lelah sepanjang waktu ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_39" value="ya" <?php if($datapemeriksaan['LelahSepanjangWaktu'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_39" value="tidak" <?php if($datapemeriksaan['LelahSepanjangWaktu'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>27.</td>
                                        <td>Apakah Anda merasa tidak enak di perut ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_40" value="ya" <?php if($datapemeriksaan['TidakEnakPerut'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_40" value="tidak" <?php if($datapemeriksaan['TidakEnakPerut'] == 'tidak'){echo "checked";}?>> Tidak
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>28.</td>
                                        <td>Apakah Anda mudah lelah ?</td>
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="layakhamil_41" value="ya" <?php if($datapemeriksaan['MudahLelah'] == 'ya'){echo "checked";}?>> Ya
                                                </label>&nbsp &nbsp
                                                <label>
                                                    <input type="radio" name="layakhamil_41" value="tidak" <?php if($datapemeriksaan['MudahLelah'] == 'tidak'){echo "checked";}?>> Tidak
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
                                <select name="hasilshrining" class="form-control inputan" required>
                                    <option value="">--Pilih--</option>
                                    <option value="Layak Hamil" <?php if($datapemeriksaan['HasilSkrining'] == 'Layak Hamil'){echo "selected";}?>>Layak Hamil</option>
                                    <option value="Tidak Layak Hamil" <?php if($datapemeriksaan['HasilSkrining'] == 'Tidak Layak Hamil'){echo "selected";}?>>Tidak Layak Hamil</option>
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
