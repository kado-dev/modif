<?php
    session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kasus = $_GET['kasus'];
	$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Katarak (".$namapuskesmas.").xls");
	if(isset($keydate1) and isset($keydate2)){
?>

<style>
.str{
	mso-number-format:\@; 
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI KATARAK</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
            <thead>
                <tr style="border:1px solid #000;">
                    <th rowspan="2" width="3%">NO.</th>
                    <th rowspan="2" width="10%">TANGGAL<br/>KUNJUNGAN</th>
                    <th rowspan="2">NIK</th>
                    <th rowspan="2">NAMA PASIEN</th>
                    <th colspan="2" width="8%">UMUR</th>
                    <th rowspan="2" width="20%">ALAMAT</th>
                    <th colspan="5" width="8%">VITAL SIGN</th>
                    <th rowspan="2" width="10%">ANAMNESA</th>
                    <th rowspan="2" width="5%">DIAGNOSA</th>
                    <th rowspan="2" width="10%">THERAPY</th>
                    <th colspan="2">KUNJ.</th>
                    <th rowspan="2">KET.</th>
                </tr>
                <tr style="border:1px solid #000;">
                    <th>L</th>
                    <th>P</th>
                    <!--vitalsign-->
                    <th>TD</th>
                    <th>BB</th>
                    <th>TB</th>
                    <th>SUHU</th>
                    <th>HR/RR</th>
                    <!--kunjungan-->
                    <th>B</th>
                    <th>L</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                    <th>11</th>
                    <th>12</th>
                    <th>13</th>
                    <th>14</th>
                    <th>15</th>
                    <th>16</th>
                    <th>17</th>
                    <th>18</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $kasus = $_GET['kasus'];
                if($kasus == "semua"){
                    $qkasus = " ";
                }else{
                    $qkasus = " AND `Kasus`='$kasus'";
                }
                
                // tbdiagnosa_bulan
                $str = "SELECT * FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2' AND (`KodeDiagnosa` like '%H25%' OR `KodeDiagnosa` like '%H26%')".$qkasus; 
                $str2 = $str." GROUP BY `NoRegistrasi`,`KodeDiagnosa`";
               
                $query_ispa = mysqli_query($koneksi, $str2);
                while($data = mysqli_fetch_assoc($query_ispa)){
                    $no = $no + 1;
                    $idpasienrj = $data['IdPasienrj'];
                    $nocm = $data['NoCM'];
                    $noregistrasi = $data['NoRegistrasi'];
                    $tanggaldiagnosa = $data['TanggalDiagnosa'];
                    
                    // vital sign
                    $strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
                    $dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
                    $tensi = $dtvs['Sistole']."/".$dtvs['Diastole'];
                    $bb = $dtvs['BeratBadan'];
                    $tb = $dtvs['TinggiBadan'];
                    $suhu = $dtvs['SuhuTubuh'];
                    $hrrr = $dtvs['HeartRate']."/".$dtvs['RespiratoryRate'];
                    
                    // tbpasien
                    $datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
                    $nik = $datapasien['Nik'];
                    
                    // tbpasienrj
                    $dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
                    $noindex = $dt_pasienrj['NoIndex'];
                    $kunjungan = $dt_pasienrj['StatusKunjungan'];
                    $kelamin = $dt_pasienrj['JenisKelamin'];
                    $pelayanan = $dt_pasienrj['PoliPertama'];

                    // pelayanan
                    if($pelayanan == 'POLI ANAK'){
                        $polis = 'tbpolianak';
                    }else if($pelayanan == 'POLI BERSALIN'){
                        $polis = 'tbpolibersalin';
                    }else if($pelayanan == 'POLI GIGI'){
                        $polis = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
                    }else if($pelayanan == 'POLI GIZI'){
                        $polis = 'tbpoligizi';
                    }else if($pelayanan == 'POLI HIV'){
                        $polis = 'tbpolihiv';	
                    }else if($pelayanan == 'POLI IMUNISASI'){
                        $polis = 'tbpoliimunisasi';
                    }else if($pelayanan == 'POLI ISOLASI'){
                        $polis = 'tbpoliisolasi';	
                    }else if($pelayanan == 'POLI KB'){
                        $polis = 'tbpolikb';
                    }else if($pelayanan == 'POLI KIA'){
                        $polis = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
                    }else if($pelayanan == 'POLI KIR'){
                        $polis = 'tbpolikir';
                    }else if($pelayanan == 'POLI LANSIA'){
                        $polis = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
                    }else if($pelayanan == 'POLI MTBS'){
                        $polis = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
                    }else if($pelayanan == 'POLI PANDU PTM'){
                        $polis = 'tbpolipanduptm';
                    }else if($pelayanan == 'POLI PROLANIS'){
                        $polis = 'tbpoliprolanis';
                    }else if($pelayanan == 'POLI INFEKSIUS'){
                        $polis = 'tbpoliinfeksius';
                    }else if($pelayanan == 'POLI SCREENING'){
                        $polis = 'tbpoliscreening';		
                    }else if($pelayanan == 'POLI SKD'){
                        $polis = 'tbpoliskd';
                    }else if($pelayanan == 'POLI TB DOTS'){
                        $polis = 'tbpolitb';
                    }else if($pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){
                        $polis = 'tbpolitindakan';
                    }else if($pelayanan == 'POLI UMUM'){
                        $polis = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
                    }else if($pelayanan == 'RAWAT INAP'){
                        $polis = 'tbpolirawatinap';
                    }else if($pelayanan == 'POLI LABORATORIUM'){
                        $polis = 'tbpolilaboratorium';
                    }else if($pelayanan == 'NURSING CENTER'){
                        $polis = 'tbpolinursingcenter';	
                    }

                    // select tbpoli
                    if ($pelayanan == 'POLI KB'){
                        $querypolisemua = mysqli_query($koneksi,"SELECT * FROM `tbpolikb_kunjunganulang` WHERE `NoPemeriksaan` = '$noregistrasi'");
                        $polisemua = mysqli_fetch_assoc($querypolisemua);
                    }else{
                        $querypolisemua = mysqli_query($koneksi,"SELECT * FROM `".$polis."` WHERE `NoPemeriksaan` = '$noregistrasi'");
                        $polisemua = mysqli_fetch_assoc($querypolisemua);
                    }

                    // cek anamnesa
                    $anamnesa = $polisemua['Anamnesa'];
                    
                    // cek umur kelamin
                    if ($kelamin == 'L'){
                        $umur_l = $dt_pasienrj['UmurTahun']." TH";
                        $umur_p = "-";
                    }else{
                        $umur_l = "-";
                        $umur_p = $dt_pasienrj['UmurTahun']." TH";
                    }
                    
                    // tbkk
                    $datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
                    
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

                    $alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
                    strtoupper($kelurahan).", ".strtoupper($kecamatan);

                    // kunjungan baru dan lama
                    if($kunjungan == 'Baru'){
                        $statuskunj_baru = '<span class="fa fa-check"></span>';
                    }else{
                        $statuskunj_baru = "-";
                    }
                    
                    if($kunjungan == 'Lama'){
                        $statuskunj_lama = '<span class="fa fa-check"></span>';
                    }else{
                        $statuskunj_lama = "-";
                    }
                                                
                    // cek diagnosa pasien
                    $str = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$idpasienrj'";
                    $query = mysqli_query($koneksi,$str);
                    
                    while($data_diagnosapsn = mysqli_fetch_array($query)){
                        $array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
                    }
                    
                    if ($array_data[$no] != ''){
                        $data_dgs = implode(",", $array_data[$no]);
                    }else{
                        $data_dgs ="";
                    }

                    // therapy
                    $str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
                    $query_therapy = mysqli_query($koneksi, $str_therapy);
                    while($dt_therapy = mysqli_fetch_array($query_therapy)){
                        $dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `NamaBarang` FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
                        $array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
                    }
                    if ($array_therapy[$no] != ''){
                        $data_trp = implode("<br/>", $array_therapy[$no]);
                    }else{
                        $data_trp = "";
                    }			
                
                ?>
                    <tr style="border:1px solid #000;">
                        <td align="center"><?php echo $no;?></td>
                        <td align="center"><?php echo $tanggaldiagnosa;?></td>
                        <td align="center" class="str"><?php echo $nik;?></td>
                        <td align="left">
                            <?php 
                                echo "<b>".strtoupper($dt_pasienrj['NamaPasien']."</b><br/>".
                                strtoupper($datakk['NamaKK'])."<br/>".
                                substr($noindex, -10)."<br/>".
                                $dt_pasienrj['Asuransi']."<br/>".
                                $dt_pasienrj['PoliPertama']);
                            ?>
                        </td>
                        <td align="center"><?php echo $umur_l;?></td>
                        <td align="center"><?php echo $umur_p;?></td>
                        <td align="left">
                            <?php
                                if($datakk['Alamat'] == ''){
                                    echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
                                }else{
                                    echo strtoupper($alamat);
                                }
                            ?>
                        </td>
                        <td align="center"><?php echo $tensi;?></td>
                        <td align="center"><?php echo $bb;?></td>
                        <td align="center"><?php echo $tb;?></td>
                        <td align="center"><?php echo $suhu;?></td>
                        <td align="center"><?php echo $hrrr;?></td>
                        <td align="left"><?php echo strtoupper($anamnesa);?></td>
                        <td align="left"><?php echo strtoupper($data_dgs);?></td>
                        <td align="left"><?php echo strtoupper($data_trp);?></td>
                        <td align="center"><?php echo $statuskunj_baru;?></td>
                        <td align="center"><?php echo $statuskunj_lama;?></td>
                        <td align="center"><?php echo $data_dgs;?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
		</table>
	</div>
</div>
<?php
}
?>