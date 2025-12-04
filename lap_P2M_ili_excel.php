<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
    include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kelurahan = $_GET['kelurahan'];
	$kasus = $_GET['kasus'];
	$tanggal = date('Y-m-d');
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Ili (".$bulan.'-'.$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
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
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
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
	<span class="font14" style="margin:1px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:1px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER ILI</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
	<br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
            <thead>
                <tr style="border:1px solid #000;">
                    <th rowspan="2" width="3%">NO.</th>
                    <th colspan="9" width="3%">UMUM</th>							
                    <th colspan="13" width="3%">TANDA & GEJALA</th>							
                    <th colspan="5" width="3%">RIWAYAT PENYAKIT & KONTAK</th>						
                    <th colspan="6" width="3%">PENGAMBILAN & PENGIRIMAN SPESIMEN</th>						
                </tr>
                <tr>
                    <th rowspan="2" width="5%">TGL.</th><!--Umum-->
                    <th rowspan="2" width="5%">NO.INDEX</th>
                    <th rowspan="2" width="5%">NIK</th>
                    <th rowspan="2" width="10%">NAMA PASIEN</th>
                    <th rowspan="2" width="10%">NAMA KK</th>							
                    <th rowspan="2" width="5%">TGL.LAHIR</th>
                    <th rowspan="2" width="3%">UMUR (TH)</th>
                    <th rowspan="2" width="2%">L/P</th>
                    <th rowspan="2" width="8%">ALAMAT</th>
                    <th rowspan="2" width="8%">SUHU</th><!--Tanda & gejala-->
                    <th rowspan="2" width="10%">LAMA DEMAM</th>
                    <th rowspan="2" width="5%">MINUM OBAT<br/>DEMAM</th>
                    <th rowspan="2" width="5%">BATUK</th>
                    <th rowspan="2" width="5%">SAKIT<br/>TENGGOROKAN</th>
                    <th rowspan="2" width="5%">FREKUENSI<br/>NAFAS</th>
                    <th rowspan="2" width="5%">SESAK<br/>NAFAS</th>
                    <th rowspan="2" width="5%">LAMA<br/>SESAK (HR)</th>
                    <th rowspan="2" width="5%">NYERI OTOT</th>
                    <th rowspan="2" width="5%">Pilik</th>
                    <th rowspan="2" width="5%">ADA PENYAKIT<br/>KRONIS</th>
                    <th rowspan="2" width="5%">HAMIL</th>
                    <th rowspan="2" width="5%">JNS.PENYAKIT<br/>KRONIS</th>							
                    <th rowspan="2" width="5%">ADA RIYATA ANGGOTA KK (DEMAM/BATUK/PILEK)</th><!--Riwayat Penyakit & Kontak-->
                    <th rowspan="2" width="5%">RUMAH DEKET PETERNAKAN UNGGAS</th>
                    <th rowspan="2" width="5%">VAKSINASI FLU 1<br/>TAHUN TERAKHIR</th>
                    <th rowspan="2" width="5%">KONTAK DENGAN AYAM<br/>(SAKIT/MATI)</th>
                    <th rowspan="2" width="5%">KONTAK DENGAN KASUS<br/>KONFIMRASI/PR<br/>OBABAEL</th>
                    <th rowspan="2" width="5%">SWAB TENGGOROK</th><!--Pengambilan & Pengiriman Spesimen-->
                    <th rowspan="2" width="5%">SWAB HIDUNG</th>
                    <th rowspan="2" width="5%">TGL.PENGAMBILAN</th>
                    <th rowspan="2" width="5%">TGL.PENGIRIMAN</th>
                    <th rowspan="2" width="5%">SUHU PENGIRIMAN</th>
                    <th rowspan="2" width="5%">HASIL PEMERIKSAAN<br/>RT & PCR</th>
                </tr>
            </thead>
			<tbody>
                <?php
                // tbdiagnosapasien
                if($_GET['kasus'] != ''){
                    $kasus = "AND Kasus = '$_GET[kasus]'";
                    $kasus2 = "AND a.Kasus = '$_GET[kasus]'";
                }else{
                    $kasus = "";
                    $kasus2 = "";
                }
                
                $str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` 
                WHERE (KodeDiagnosa ='A93.8' OR KodeDiagnosa ='R50.9' OR KodeDiagnosa ='J06.9' OR KodeDiagnosa like '%J11%' OR KodeDiagnosa like '%J12%') ".$kasus." AND YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' GROUP BY IdPasienrj ";
                $str2 = $str_diagnosa." ORDER BY TanggalDiagnosa";
                // echo $str2;
                
                $query_diagnosa = mysqli_query($koneksi,$str2);
                while($dtdiagnosa = mysqli_fetch_assoc($query_diagnosa)){
                    $no = $no + 1;
                    $idpasienrj = $dtdiagnosa['IdPasienrj'];
                    $noindex = $dtdiagnosa['NoIndex'];
                    $noregistrasi = $dtdiagnosa['NoRegistrasi'];
                    $kodediagnosa = $dtdiagnosa['KodeDiagnosa'];
                    $kasus = $dtdiagnosa['Kasus'];
                
                    // tbpasienrj 
                    $data_rj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idpasienrj'"));
                                            
                    // tbpasien
                    $dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex`,`Nik`,`TanggalLahir` FROM `$tbpasien` WHERE `NoIndex`='$noindex'"));
                
                    // tbkk
                    $dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
                    if($dtkk['Alamat'] != ''){
                        $alamat_kk = $dtkk['Alamat']." RT. ".$dtkk['RT'].", Kel.".$dtkk['Kelurahan'];
                    }else{
                        $alamat_kk = "Alamat Belum di Inputkan";
                    }
                
                    // tbpoliumum
                    if ($poli == 'POLI UMUM'){
                        $poliumum = 'tbpoliumum_'.$bulan;
                        $str_umum = "SELECT * FROM `$poliumum` WHERE `NoPemeriksaan` = '$noregistrasi'";
                        $query_umum = (mysqli_query($koneksi,$str_umum));
                        $data_umum = mysqli_fetch_assoc($query_umum);
                        $anamnesa = $data_umum['Anamnesa'];
                        $sistole = $data_umum['Sistole'];
                        if ($anamnesa != null){$anamnesa = $data_umum['Anamnesa'];}else{$anamnesa = "-";}
                        if ($sistole != null){$sistole = $data_umum['Sistole']."/".$data_umum['Diastole'];}else{$sistole = "-";}
                    }else if ($poli == 'POLI UGD'){
                        $str_ugd = "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'";
                        $query_ugd = (mysqli_query($koneksi,$str_ugd));
                        $data_ugd = mysqli_fetch_assoc($query_ugd);
                        $anamnesa = $data_ugd['Anamnesa'];
                        $sistole = $data_ugd['Sistole'];
                        if ($anamnesa != null){$anamnesa = $data_ugd['Anamnesa'];}else{$anamnesa = "-";}
                        if ($sistole != null){$sistole = $data_ugd['Sistole']."/".$data_ugd['Diastole'];}else{$sistole = "-";}
                    }else if ($poli == 'POLI LANSIA'){
                        $str_lansia = "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan` = '$noregistrasi'";
                        $query_lansia = (mysqli_query($koneksi,$str_lansia));
                        $data_lansia = mysqli_fetch_assoc($query_lansia);
                        $anamnesa = $data_lansia['Anamnesa'];
                        $sistole = $data_lansia['Sistole'];
                        if ($anamnesa != null){$anamnesa = $data_lansia['Anamnesa'];}else{$anamnesa = "-";}
                        if ($sistole != null){$sistole = $data_lansia['Sistole']."/".$data_lansia['Diastole'];}else{$sistole = "-";}
                    }

                    // vital sign
                    $strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
                    $dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
                    $dtsuhutubuh = $dtvs['SuhuTubuh'];
                
                    // kelamin
                    if($kelamin == 'L'){
                        $kelamin_l = $data_rj['UmurTahun']."Th, ".$data_rj['UmurBulan']."Bl";
                        $kelamin_p = '-';
                    }else{
                        $kelamin_p = $data_rj['UmurTahun']."Th, ".$data_rj['UmurBulan']."Bl";
                        $kelamin_l = '-';
                    }
                
                ?>
                    <tr style="border:1px solid #000;">
                        <td align="center"><?php echo $no;?></td>
                        <td><?php echo date('d-m-Y', strtotime($dtdiagnosa['TanggalDiagnosa']));?></td>
                        <td><?php echo substr($data_rj['NoIndex'],-10);?></td>
                        <td class="str"><?php echo $dtpasien['Nik'];?></td>
                        <td><?php echo strtoupper($data_rj['NamaPasien']);?></td>
                        <td><?php echo strtoupper($dtkk['NamaKK']);?></td>
                        <td><?php echo date('d-m-Y', strtotime($dtpasien['TanggalLahir']));?></td>
                        <td><?php echo $data_rj['UmurTahun'];?></td>
                        <td><?php echo $data_rj['JenisKelamin'];?></td>
                        <td><?php echo strtoupper($alamat_kk);?></td>
                        <td align="center"><?php echo $dtsuhutubuh;?></td><!--Tanda & gejala-->
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td><!--Riwayat Penyakit & Kontak-->
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td><!--Pengambilan & Pengiriman Spesimen-->
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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