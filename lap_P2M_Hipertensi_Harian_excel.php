<?php
    error_reporting(0);
    session_start();
    include_once('config/koneksi.php');
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
    $kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kasus = $_GET['kasus'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Hipertensi dan DM (".$hariini.").xls");
	if(isset($keydate1) and isset($keydate2)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Trebuchet MS";
}
.printheader p{
	font-size:14px;
	font-family: "Trebuchet MS";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}
.str{
	mso-number-format:\@; 
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI HIPERTENSI & DM</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
                <tr>
                    <th rowspan="2" width="3%">NO.</th>
                    <th rowspan="2" width="7%">TANGGAL</th>
                    <th rowspan="2" width="10%">NIK</th>
                    <th rowspan="2" width="5%">NO.INDEX</th>
                    <th rowspan="2" width="10%">NAMA PASIEN-KK</th>
                    <th rowspan="2" width="10%">ALAMAT</th>
                    <th rowspan="2" width="5%">CARA BAYAR</th>
                    <th rowspan="2" width="5%">PELAYANAN</th>
                    <th rowspan="2" width="5%">TANGGAL LAHIR</th>
                    <th colspan="2" width="5%">UMUR</th>
                    <th rowspan="2" width="5%">KUNJ.</th>
                    <th colspan="4" width="5%">VITAL SIGN</th>
                    <th rowspan="2" width="10%">ANAMNESA</th>
                    <th rowspan="2" width="5%">DIAGNOSA</th>
                    <th rowspan="2" width="10%">THERAPY</th>
                    <th colspan="2" width="5%">RUJUK</th>
                    <th rowspan="2" width="5%">KET.</th>
                </tr>
                <tr>
                    <th>L</th>
                    <th>P</th>
                    <th>TD</th>
                    <th>BB/TB</th>
                    <th>SUHU</th>
                    <th>HR/RR</th>
                    <th>YA</th>
                    <th>TDK</th>
                </tr>
			</thead>
			<tbody>
            <?php
                $waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
                $tbdiagnosadiare = 'tbdiagnosadiare';
                                
                // tbdiagnosadiare
                $kasus = $_GET['kasus'];
                if($kasus != 'Semua'){
                    $qkasus = " AND Kunjungan = '$kasus' ";
                }else{
                    $qkasus = " ";
                }
                
                // tbdiagnosa_bulan
                $str_diare = "SELECT * FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2' AND (`KodeDiagnosa` like '%I10%' OR `KodeDiagnosa` like '%I15%' OR `KodeDiagnosa` like '%E10%' OR `KodeDiagnosa` like '%E11%' OR `KodeDiagnosa` like '%E14%')";
                $str2 = $str_diare."order by `TanggalDiagnosa`";
                // echo $str2;
                
                $query_diare = mysqli_query($koneksi,$str2);
                while($data_diare = mysqli_fetch_assoc($query_diare)){
                    $no = $no + 1;
                    $noreg = $data_diare['NoRegistrasi'];
                    $noindex = $data_diare['NoIndex'];
                    $nocm = $data_diare['NoCM'];

                    // tbkk
                    $dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Telepon` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
                    $alamat = strtoupper($dtkk['Alamat']).", RT.".$dtkk['RT'].", NO.".$dtkk['No']." ".strtoupper($dtkk['Kelurahan']);
                    
                    // tbpasien
                    $dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `TanggalLahir`,`Nik`,`Telpon` FROM `$tbpasien` WHERE `NoCM`='$nocm'"));
                    
                    // tbpasienrj
                    $dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPasien`,`JenisKelamin`,`UmurTahun`,`UmurBulan`,`UmurHari`,`PoliPertama`,`StatusKunjungan`,`Asuransi`
                    FROM $tbpasienrj WHERE `NoRegistrasi`='$noreg'"));
                    $kelamin = $dt_pasienrj['JenisKelamin'];
                    $kunjungan = strtoupper($dt_pasienrj['StatusKunjungan']);
                    $pelayanan = $dt_pasienrj['PoliPertama'];
                    
                    // cek umur kelamin
                    if ($kelamin == 'L'){
                        if($dt_pasienrj['UmurTahun'] != 0){
                            $umur_l = $dt_pasienrj['UmurTahun']." TH";
                        }else{
                            if($dt_pasienrj['UmurBulan'] == 0){
                                $umur_l = $dt_pasienrj['UmurBulan']." BL";
                            }else{
                                $umur_l = $dt_pasienrj['UmurHari']." HR";
                            }	
                        }	
                        $umur_p = "-";
                    }else{
                        $umur_l = "-";
                        if($dt_pasienrj['UmurTahun'] != 0){
                            $umur_p = $dt_pasienrj['UmurTahun']." TH";
                        }else{
                            if($dt_pasienrj['UmurBulan'] == 0){
                                $umur_p = $dt_pasienrj['UmurBulan']." BL";
                            }else{
                                $umur_p = $dt_pasienrj['UmurHari']." HR";
                            }
                        }
                    }
                    
                    // poli
                    if($pelayanan == 'POLI UMUM'){
                        $pelayanan = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
                        $datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa`,`Sistole`,`Diastole`,`BeratBadan`,`TinggiBadan`,`SuhuTubuh`,`DetakNadi`,`RR`,`StatusPulang` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
                    }else{
                        $pelayanan = "tb".strtolower(str_replace(' ', '', $dt_pasienrj['PoliPertama']));
                        $datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa`,`Sistole`,`Diastole`,`BeratBadan`,`TinggiBadan`,`SuhuTubuh`,`DetakNadi`,`RR`,`StatusPulang` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
                    }
                    
                    $tensi = $datapoli['Sistole']."/".$datapoli['Diastole'];
                    $bbtb = $datapoli['BeratBadan']."/".$datapoli['TinggiBadan'];
                    $suhu = $datapoli['SuhuTubuh'];
                    $hrrr = $datapoli['DetakNadi']."/".$datapoli['RR'];	

                    // cek rujukan
                    $rujukan = $datapoli['StatusPulang'];
                    if ($rujukan == 3){
                        $berobatjalan = '<span class="fa fa-check"></span>';
                        $rujuklanjut = '-';
                    }else if($rujukan == 4){
                        $rujuklanjut = '<span class="fa fa-check"></span>';
                        $berobatjalan = '-';
                    }							
                    
                    // tbdiagnosadiare
                    $dtdiare = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosadiare` WHERE `NoRegistrasi`='$noreg'"));
                    $tindakan = $dtdiare['TindakanPengobatan'];	
                                                
                    // tindakan pengobatan
                    $pecah = explode(",",$tindakan);
                                                
                    if($pecah[0] == 'Oralit' || $pecah[0] = 'Infus' || $pecah[0] = 'Zinc'){
                        $oralit = '<span class="glyphicon glyphicon-ok"></span>';
                        $antibiotik = '-';
                    }elseif($pecah[1] == 'Oralit' || $pecah[1] == 'Oralit' and $pecah[1] == 'Oralit'){
                        $oralit = '<span class="glyphicon glyphicon-ok"></span>';
                        $antibiotik = '-';
                    }elseif($pecah[2] == 'Antibiotik' || $pecah[2] == 'Antibiotik' and $pecah[2] == 'Antibiotik'){
                        $oralit = '-';
                        $antibiotik = '<span class="glyphicon glyphicon-ok"></span>';	
                    }
                                        
                    // tbpasienperpegawai
                    $tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
                    $dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$noreg'"));
                    if($dt_pegawai['NamaPegawai1']!=''){
                        $pemeriksa = $dt_pegawai['NamaPegawai1'];
                    }else{
                        $pemeriksa = $dt_pegawai['NamaPegawai2'];
                    }
                
                ?>
                    <tr>
                        <td align="center" style="vertical-align: middle;"><?php echo $no;?></td>
                        <td align="center" style="vertical-align: middle;"><?php echo date('d-m-Y', strtotime($data_diare['TanggalDiagnosa']));?></td>
                        <td align="center" style="vertical-align: middle;" class="str"><?php echo $dtpasien['Nik'];?></td>
                        <td align="center" style="vertical-align: middle;" class="str"><?php echo substr($noindex, -10);?></td>
                        <td align="left" style="vertical-align: middle;">
                            <?php 
                                echo "<b>".strtoupper($dt_pasienrj['NamaPasien'])."</b><br/>".
                                "<b>KK. ".strtoupper($dtkk['NamaKK'])."</b><br/>";
                            ?>
                        </td>
                        <td align="left" style="vertical-align: middle;"><?php echo $dtkk['Alamat'].", RT.".$dtkk['RT']." RW.".$dtkk['RW'].", ".$dtkk['Kelurahan'];?></td>
                        <td align="center" style="vertical-align: middle;"><?php echo $dt_pasienrj['Asuransi'];?></td>
                        <td align="center" style="vertical-align: middle;"><?php echo str_replace('POLI','', $dt_pasienrj['PoliPertama']);?></td>
                        <td align="center" style="vertical-align: middle;" class="str"><?php echo date('d-m-Y', strtotime($dtpasien['TanggalLahir']));?></td>
                        <td align="center" style="vertical-align: middle;"><?php echo $umur_l;?></td>
                        <td align="center" style="vertical-align: middle;"><?php echo $umur_p;?></td>
                        <td align="center" style="vertical-align: middle;"><?php echo $kunjungan;?></td>
                        <td align="center" style="vertical-align: middle;">
                            <?php 
                                if($datapoli['Sistole'] != ""){
                                    echo $tensi;
                                }else{
                                    echo "0";
                                }	
                            ?>
                        </td>
                        <td align="center" style="vertical-align: middle;"><?php echo $bbtb;?></td>
                        <td align="center" style="vertical-align: middle;">
                            <?php 
                                if($datapoli['SuhuTubuh'] != ""){
                                    echo $suhu;
                                }else{
                                    echo "0";
                                }
                            ?>
                        </td>
                        <td align="center" style="vertical-align: middle;">
                            <?php 
                                if($datapoli['DetakNadi'] != ""){
                                    echo $hrrr;
                                }else{
                                    echo "0";
                                }
                            ?>
                        </td>
                        <td align="left" style="vertical-align: middle;"><?php echo $datapoli['Anamnesa'];?></td>
                        <td align="center" style="vertical-align: middle;">
                           <?php
                                // tbdiagnosapasien
                                $str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noreg'";
                                $query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
                                while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
                                    $array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
                                }

                                if ($array_data[$no] != ''){
                                    $data_dgs = implode("<br/>", $array_data[$no]);
                                    echo $data_dgs;
                                }else{
                                    echo "X";
                                }
                            ?> 
                        </td>
                        <td align="center" style="vertical-align: middle;">
                            <?php
                                // therapy
                                $qrdata_therapy = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$data_diare[NoRegistrasi]' AND DATE(TanggalResep) IS NOT NULL GROUP BY NoResep, KodeBarang, Pelayanan");
                                while($data_therapy = mysqli_fetch_array($qrdata_therapy)){
                                    $data_obat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang` = '$data_therapy[KodeBarang]' GROUP BY KodeBarang"));
                                    $array_obat[$no][] = $data_obat['NamaBarang'];
                                }
                                
                                if ($array_obat[$no] != ''){
                                    $data_obt = implode(", ", $array_obat[$no]);
                                    echo $data_obt;
                                }else{
                                    echo "X";
                                }
                            ?>
                        </td>
                        <td align="left" style="vertical-align: middle;"><?php echo $rujuklanjut;?></td>
                        <td align="left" style="vertical-align: middle;"><?php echo $berobatjalan;?></td>
                        <td align="left" style="vertical-align: middle;"><?php echo strtoupper($pemeriksa);?></td>
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