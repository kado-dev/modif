<?php
    session_start();
    include "config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="image/sehat.png" type="image/png" sizes="16x16">
        <title>Surat Berobat</title>
        <style>
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #FAFAFA;
                font: 12pt "Tahoma";
            }
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }
            .page {
                width: 180mm;
                min-height: 297mm;
                padding: 10mm;
                margin: 10mm auto;
                border: 1px #D3D3D3 solid;
                border-radius: 5px;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);                           
                /* line-height:25px !important; */
            }
            .subpage {
                padding: 1cm;
                border: 5px red solid;
                height: 257mm;
                outline: 2cm #FFEAEA solid;
            }
            
            @page {
                size: A4;
                margin: 0;     
            }
            @media print {
                html, body {
                    width: 210mm;
                    height: 297mm;        
                }
                .page {
                    margin: 0;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                    line-height:25px !important;
                }
            }
            .garis-bawah{
                border-bottom:2px dashed #ccc
            }
            .tabelformchecklist{
                width: 100%;
                border:1px solid #ccc;
                border-collapse:collapse;
                margin-bottom:10px
            }
            .tabelformchecklist tr{
                border:1px solid #ccc;
            }
            .tabelformchecklist td{
                border:1px solid #ccc;padding:4px 8px;
            }
            .tablenama{
                border:1px solid #000;
                border-collapse:collapse;
                margin-bottom:10px
            }
            .tablenama tr{
                border:1px solid #000;
            }
            .tablenama td{
                border:1px solid #000;padding:4px 8px;
            }
        </style>
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
    </head>
    <body>
        <?php
            include "config/helper_pasienrj.php";
            $idpasien = $_GET['idpsn'];
            $idpasienrj = $_GET['idrj'];

            // tbpasienrj
            $datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));
          
            // tbpasien
            $datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'"));
            $noindex = $datapasien['NoIndex'];
            if($datapasien['JenisKelamin'] == 'L'){
                $jeniskelamin = 'Laki-laki';
            }else{
                $jeniskelamin = 'Perempuan';
            }

            // tbkk
            $datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));

            // ec_subdistricts
            $dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
            if($dt_subdis['subdis_name'] != ''){
                $kelurahan = $dt_subdis['subdis_name'];
            }else{
                $kelurahan = $datakk['Kelurahan'];
            }

            // ec_districts
            $dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
            if($dt_dis['dis_name'] != ''){
                $kecamatan = $dt_dis['dis_name'];
            }else{
                $kecamatan = $datakk['Kecamatan'];
            }

            // ec_cities
            $dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
            if($dt_citi['city_name'] != ''){
                $kota_ps = $dt_citi['city_name'];
            }else{
                $kota_ps = $datakk['Kota'];
            }

            if($datakk['Alamat'] != ''){
                $alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
                strtoupper($kelurahan).", ".strtoupper($kecamatan).", ".strtoupper($kota_ps);
            }else{
                $alamat = "Tidak ditemukan";
            }

            // tbsuratberobat
            $dtsuratberobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbsuratberobat` WHERE `IdPasienrj` = '$idpasienrj'"));
        
       ?>
            <div class="page">
                <?php
                    include('kop_surat.php');
                ?>
                <p style="font-size: 18px; font-weight: bold; text-align: center; text-decoration: underline;">SURAT KETERANGAN BEROBAT</p>
                <p style="text-align: center; margin-bottom: 30px; margin-top: -10px;"><?php echo "Nomor : ".$dtsuratberobat['NomorSurat'];?></p>
                <p>
                    Yang bertanda tangan dibawah ini, menerangkan bahwa :
                </p>
                <table width="100%">
                    <tr><td width="25%">Nama </td><td width="10px">:</td><td class="garis-bawah"><?php echo $datapasien['NamaPasien'];?></td></tr>
                    <tr><td>Tanggal Lahir / Usia </td><td>:</td><td class="garis-bawah"><?php echo date('d-m-Y', strtotime($datapasien['TanggalLahir']))." / ".$datapasienrj['UmurTahun']." Tahun";?></td></tr>
                    <tr><td>Jenis Kelamin </td><td>:</td><td class="garis-bawah"><?php echo $jeniskelamin;?></td></tr>
                    <tr><td>Alamat </td><td>:</td><td class="garis-bawah"><?php echo $alamat;?></td></tr>
                    <tr><td>Pekerjaan </td><td>:</td><td class="garis-bawah"><?php echo $datapasien['Pekerjaan'];?></td></tr>
                </table>
                <p>
                    Adalah <b>BENAR</b> Pada tanggal <?php echo date('d-m-Y', strtotime($dtsuratberobat['TanggalBerobat']));?> telah melakukan kunjungan pemeriksaan berobat di Puskesmas 
                    <?php echo $_SESSION['namapuskesmas'];?>, demikian Surat Keterangan Berobat ini dibuat dengan sesungguhnya untuk dipergunakan sebagaimana mestinya.
                </p>                
                <table width="100%" align="center" class="fontkonten">
                    <tr>
                        <td width="50%" valign="top">
                            <!-- <table width="100%">
                                <tr><td align="center"><b>PETUGAS</b></td></tr>
                                <tr><td align="center"><br/><br/>__________________________</td></tr>
                            </table> -->
                        </td>
                        <td width="50%" valign="top">
                            <table width="100%">
                                <tr><td align="center"><?php echo $kota.", ".date('d-m-Y', strtotime($dtsuratberobat['TanggalPeriksa']));?></td></tr>
                                <tr><td align="center">Dokter Pemeriksa</td></tr>
                                <tr><td align="center"><br/><br/><br/><?php echo $dtsuratberobat['NamaDokter'];?></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
    </body>
</html>