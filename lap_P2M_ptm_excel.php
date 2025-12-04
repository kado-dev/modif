<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_PTM (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>PTM BERBASIS FKTP</b></h4>
	<p style="margin:1px; margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></p>
</div><br/>

<div class="atastabel font14">
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kelurahan;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kecamatan;?></h5 ></td>
			</tr>
		</table>
	</div>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th width="2%" rowspan="2">NO.</th>
					<th rowspan="2">TGL.PERIKSA</th>
					<th colspan="11">IDENTITAS</th>
					<th width="20%" colspan="4">WAWANCARA</th>
					<th width="8%" colspan="2">IMT</th>
					<th width="4%" rowspan="2">LINGKAR PERUT</th>
					<th width="4%" colspan="2">TD</th>
					<th colspan="2">GULA DARAH</th>
					<th colspan="2">KOLESTEROL</th>
					<th rowspan="2">LDL</th>
					<th rowspan="2">HDL</th>
					<th rowspan="2">ARUS PUNCAK EKSPIRASI (APE)</th>
					<th rowspan="2">KADAR ALKOHOL PERNAFASAN</th>
					<th rowspan="2">TES AMFETAMIN URIN</th>
					<th rowspan="2">BENJOLAN ABNORMAL PAYUDARA</th>
					<th rowspan="2">PAP SMEAR</th>
					<th rowspan="2">HASIL PERIKSA IVA</th>
					<th rowspan="2">KRIOTERAPI</th>
					<th width="10%" rowspan="2">DIAGNOSA</th>
					<th width="4%" colspan="4">PEMERIKSAAN PENUNJANG</th>
					<th width="4%" rowspan="2">DIRUJUK</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th width="4%" rowspan="1">NO.INDEX</th>
					<th width="5%" rowspan="1">NO.KTP</th>
					<th width="8%" rowspan="1">NAMA PASIEN</th>
					<th width="2%" rowspan="1">L/P</th>
					<th width="4%" rowspan="1">TGL.LAHIR</th>
					<th width="4%" rowspan="1">UMUR</th>
					<th width="25%" rowspan="1">ALAMAT-TELP</th>
					<th width="2%" rowspan="1">GOL.DRH</th>
					<th width="4%" rowspan="1">STATUS</th>
					<th width="1%" rowspan="1">SUKU</th>
					<th width="4%" rowspan="1">PEKERJAAN</th>
					<th>MEROKOK</th>
					<th>KURANG AKTIVITAS FISIK</th>
					<th>KURANG MAKAN SAYUR</th>
					<th>KONSUMSI ALKOHOL</th>
					<th width="2%">TB</th>
					<th width="2%">BB</th>
					<th width="2%">SISTOL</th>
					<th width="2%">DIASTOL</th>
					<th>SEWAKTU</th>
					<th>PUASA</th>
					<th>KOLESTEROL TOTAL</th>
					<th>TRIGLISERIDA</th>
					<th>EKG</th>
					<th>RADIOLOGI</th>
					<th>DARAH LENGKAP</th>
					<th>URIN RUTIN & MIKROSKOPIK</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$no = 0;
				// tbdiagnosadiare
				$str_diagnosa = "SELECT * FROM `tbdiagnosaptm` WHERE MONTH(TanggalRegistrasi) = '$bulan' 
				AND YEAR(TanggalRegistrasi) = '$tahun' AND substring(NoRegistrasi,1,11) = '$kodepuskesmas'";
				$str2 = $str_diagnosa."order by `TanggalRegistrasi`";
				// echo $str2;	
				$query_diagnosa = mysqli_query($koneksi, $str2);
				while($data_diagnosa = mysqli_fetch_assoc($query_diagnosa)){
					$no = $no + 1;
					$noregistrasi = $data_diagnosa['NoRegistrasi'];
					$tglregistrasi = $data_diagnosa['TanggalRegistrasi'];
					$tinggibadan = $data_diagnosa['TB'];
					$beratbadan = $data_diagnosa['BB'];
					$lingkarperut = $data_diagnosa['LingkarPerut'];
					$sistole = $data_diagnosa['Sistole'];
					$diastole = $data_diagnosa['Diastole'];	
														
					// tbpasienrj
					$str_rj = "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$idpasienrj = $data_rj['IdPasienrj'];
					$idpasien = $data_rj['IdPasien'];
					$noindex = $data_rj['NoIndex'];
					$nocm = $data_rj['NoCM'];
					$poli = $data_rj['PoliPertama'];
					
					if(strlen($noindex) == 24){
						$noindex2 = substr($data_rj['NoIndex'],14);
					}else{
						$noindex2 = $data_rj['NoIndex'];
					}
					
					// tbkk
					$str_kk = "SELECT * FROM `$tbkk` WHERE NoIndex = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$datakk = mysqli_fetch_assoc($query_kk);

					// ec_subdistricts
					$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
					if($dt_subdis['subdis_name'] != ''){
						$desa = $dt_subdis['subdis_name'];
					}else{
						$desa = $datakk['kelurahan'];	
					}

					// ec_districts
					$dt_districts = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_name`='$datakk[Kecamatan]'"));
					if($dt_districts['dis_name'] != ''){
						$kecamatan = $dt_districts['dis_name'];
					}else{
						$kecamatan = $datakk['Kecamatan'];	
					}

					// ec_cities
					$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
					if($dt_citi['city_name'] != ''){
						$kota = $dt_citi['city_name'];
					}else{
						$kota = $datakk['Kota'];	
					}

					$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($desa).", ".strtoupper($kecamatan).", ".strtoupper($kota);
					
					// tbpasien
					$data_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'"));
					if($data_pasien['StatusKeluarga'] == "KEPALA KELUARGA") {
						$statusklg = "KK";
					}else{
						$statusklg = $data_pasien['StatusKeluarga'];
					}

					// tbdiagnosapasien							
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(", ", $array_data[$no]);
					}else{
						$data_dgs ="";
					}

					// vital sign
					$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
					$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
					$dtsistole = $dtvs['Sistole'];
					$dtdiastole = $dtvs['Diastole'];
					$dtsuhutubuh = $dtvs['SuhuTubuh'];
					$dttinggiBadan = $dtvs['TinggiBadan'];
					$dtberatBadan = $dtvs['BeratBadan'];
					$dtheartRate = $dtvs['HeartRate'];
					$dtrespRate = $dtvs['RespiratoryRate'];
					$dtLingkarPerut = $dtvs['LingkarPerut'];
					$imt = $dtvs['IMT'];

					if($dtsistole != ''){
						$dtsistole = $dtsistole;
						$dtdiastole = $dtdiastole;
						$dttinggiBadan = $dttinggiBadan;
						$dtberatBadan = $dtberatBadan;
						$dtLingkarPerut = $dtLingkarPerut;
					}else{
						if ($data_rj['PoliPertama'] == 'POLI UMUM'){
							$tbpoli = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
						}elseif($data_rj['PoliPertama'] == 'POLI ANAK'){
							$data_rj = 'tbpolianak';
						}elseif($data_rj['PoliPertama'] == 'POLI GIGI'){
							$tbpoli = 'tbpoligigi';
						}elseif($data_rj['PoliPertama'] == 'POLI GIZI'){
							$tbpoli = 'tbpoligizi';
						}elseif($data_rj['PoliPertama'] == 'POLI BERSALIN'){
							$tbpoli = 'tbpolibersalin';
						}elseif($data_rj['PoliPertama'] == 'POLI ISOLASI'){
							$tbpoli = 'tbpoliisolasi';	
						}elseif($data_rj['PoliPertama'] == 'POLI KB'){
							$tbpoli = 'tbpolikb';
						}elseif($data_rj['PoliPertama'] == 'POLI KIA'){
							$tbpoli = 'tbpolikia';
						}elseif($data_rj['PoliPertama'] == 'POLI LANSIA'){
							$tbpoli = 'tbpolilansia';
						}elseif($data_rj['PoliPertama'] == 'POLI MTBM'){
							$tbpoli = 'tbpolimtbm';
						}elseif($data_rj['PoliPertama'] == 'POLI MTBS'){
							$tbpoli = 'tbpolimtbs';
						}elseif($data_rj['PoliPertama'] == 'POLI PANDU PTM'){
							$tbpoli = 'tbpolipanduptm';	
						}elseif($data_rj['PoliPertama'] == 'POLI INFEKSIUS'){
							$tbpoli = 'tbpoliinfeksius';	
						}elseif($data_rj['PoliPertama'] == 'POLI SCREENING'){
							$tbpoli = 'tbpoliscreening';	
						}elseif($data_rj['PoliPertama'] == 'POLI SKD'){
							$tbpoli = 'tbpoliskd';
						}elseif($data_rj['PoliPertama'] == 'POLI TB DOTS'){
							$tbpoli = 'tbpolitb';
						}elseif($data_rj['PoliPertama'] == 'POLI UGD' || $data_rj['PoliPertama'] == 'POLI TINDAKAN'){
							$tbpoli = 'tbpolitindakan';
						}elseif($data_rj['PoliPertama'] == 'NURSING CENTER'){
							$tbpoli = 'tbpolinursingcenter';
						}

						// poli
						$poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoli` WHERE `NoPemeriksaan` = '$noregistrasi' AND `NoCM`='$nocm'"));
						$dtsistole = $poli['Sistole'];
						$dtdiastole = $poli['Diastole'];
						$dttinggiBadan = $poli['TinggiBadan'];
						$dtberatBadan = $poli['BeratBadan'];
						$dtLingkarPerut = $poli['LingkarPerut'];
					}
				?>
					<tr style="border:1px solid #000;">
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($data_diagnosa['TanggalRegistrasi']));?></td>
						<td align="center"><?php echo $noindex2;?></td>
						<td align="center" class="str"><?php echo $data_pasien['Nik'];?></td><!--noktp-->
						<td align="left"><?php echo $data_rj['NamaPasien'];?></td>
						<td align="center"><?php echo $data_rj['JenisKelamin'];?></td>
						<td align="center"><?php echo $data_pasien['TanggalLahir'];?></td>
						<td><?php echo $data_rj['UmurTahun']." Th, ".$data_rj['UmurBulan']." Bl";?></td>
						<td><?php echo $alamat;?></td>
						<td><?php if ($data_diagnosa['Darah'] == ''){echo '-';}else{echo $data_diagnosa['Darah'];}?></td><!--gol darah-->
						<td align="center"><?php echo $statusklg;?></td><!--status-->
						<td><?php echo '-'?></td><!--suku-->
						<td><?php echo $data_pasien['Pekerjaan'];?></td><!--pekerjaan-->
						<td><?php if ($data_diagnosa['Merokok'] == 'Y'){echo "YA";}else{echo "TD";}?></td>
						<td><?php if ($data_diagnosa['AktifitasFisik'] == 'Y'){echo "YA";}else{echo "TD";}?></td>
						<td><?php if ($data_diagnosa['KuranMakanSayur'] == 'Y'){echo "YA";}else{echo "TD";}?></td>
						<td><?php if ($data_diagnosa['KonsumsiAlkohol'] == 'Y'){echo "YA";}else{echo "TD";}?></td>
						<td align="center"><?php echo $dttinggiBadan;?></td><!--tinggi badan-->
						<td align="center"><?php echo $dtberatBadan;?></td><!--berat badan-->
						<td align="center"><?php echo $dtLingkarPerut;?></td><!--lingkar perut-->
						<td align="center"><?php echo $dtsistole;?></td><!--sistol-->
						<td align="center"><?php echo $dtdiastole;?></td><!--diastol-->
						<td><?php echo ''?></td><!--gula darah sewaktu-->
						<td><?php echo ''?></td><!--gula darah puasa-->
						<td><?php echo ''?></td><!--kolestrol total-->
						<td><?php echo ''?></td><!--trigliserida-->
						<td><?php echo ''?></td><!--ldl-->
						<td><?php echo ''?></td><!--hdl-->
						<td><?php echo ''?></td><!--ape-->
						<td><?php echo ''?></td><!--kadar alkohol-->
						<td><?php echo ''?></td><!--urin-->
						<td><?php echo ''?></td><!--benjolan-->
						<td><?php echo ''?></td><!--pap smear-->
						<td><?php echo ''?></td><!--iva-->
						<td><?php echo ''?></td><!--krioterapi-->
						<td><?php echo $data_dgs;?></td><!--diagnosa-->
						<td><?php echo ''?></td><!--ekg-->
						<td><?php echo ''?></td><!--radiologi-->
						<td><?php echo ''?></td><!--darah lengkap-->
						<td><?php echo ''?></td><!--urin rutin-->
						<td><?php echo ''?></td><!--dirujuk-->
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