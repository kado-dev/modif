<?php
	session_start();
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
	include "config/koneksi.php";
	
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kasus = $_GET['kasus'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Diare (".$hariini.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI DIARE</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="7%">TANGGAL</th>
					<th rowspan="2" width="17%">NAMA PASIEN-KK</th>
					<th colspan="2" width="8%">UMUR</th>
					<th rowspan="2" width="5%">KUNJ.</th>
					<th colspan="4" width="8%">VITAL SIGN</th>
					<th rowspan="2" width="10%">ANAMNESA</th>
					<th rowspan="2" width="5%">DIAGNOSA</th>
					<th rowspan="2" width="12%">THERAPY</th>
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
					<!-- <th>ANTIBIOTIK</th>
					<th>ORALIT</th> -->
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
				$str_diare = "SELECT * FROM `$tbdiagnosapasien` WHERE date(TanggalDiagnosa) BETWEEN '$keydate1' AND '$keydate2' AND (`KodeDiagnosa`='A03.0' OR `KodeDiagnosa`='A06.0' OR `KodeDiagnosa` like '%A09%' OR `KodeDiagnosa` = 'A00.9' OR `KodeDiagnosa` = 'K58.0' OR `KodeDiagnosa` = 'K58.9')";
				$str2 = $str_diare."GROUP BY `NoRegistrasi` ORDER BY `TanggalDiagnosa`";
				// echo $str2;
								
				$query_diare = mysqli_query($koneksi,$str2);
				while($data_diare = mysqli_fetch_assoc($query_diare)){
					$no = $no + 1;
					$idpasienrj = $data_diare['IdPasienrj'];
					$noreg = $data_diare['NoRegistrasi'];
					$noindex = $data_diare['NoIndex'];
					$nocm = $data_diare['NoCM'];

					// tbkk
					$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Telepon` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
					$alamat = strtoupper($dtkk['Alamat']).", RT.".$dtkk['RT'].", NO.".$dtkk['No']." ".strtoupper($dtkk['Kelurahan']);
					
					// tbpasien
					$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `TanggalLahir`,`Nik`,`Telpon` FROM `$tbpasien` WHERE `NoCM`='$nocm'"));
					
					// tbpasienrj
					$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPasien`,`JenisKelamin`,`UmurTahun`,`UmurBulan`,`UmurHari`,`PoliPertama`,`StatusKunjungan`,`Asuransi`,`StatusPulang`
					FROM $tbpasienrj WHERE `IdPasienrj`='$idpasienrj'"));
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
						$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
					}elseif($pelayanan == 'POLI LANSIA'){
						$pelayanan = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
						$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
					}elseif($pelayanan == 'POLI MTBS'){
						$pelayanan = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
						$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
					}elseif($pelayanan == 'POLI KIA'){
						$pelayanan = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
						$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
					}else{
						$pelayanan = "tb".strtolower(str_replace(' ', '', $dt_pasienrj['PoliPertama']));
						$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa`,`Sistole`,`Diastole`,`BeratBadan`,`TinggiBadan`,`SuhuTubuh`,`DetakNadi`,`RR`,`StatusPulang` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
					}
					
					// cek rujukan
					$rujukan = $dt_pasienrj['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = 'TDK';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$berobatjalan = '-';
						$rujuklanjut = 'YA';
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
					
					// tbdiagnosadiare
					// $dtdiare = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosadiare` WHERE `NoRegistrasi`='$noreg'"));
					// $tindakan = $dtdiare['TindakanPengobatan'];	
												
					// tindakan pengobatan
					// $pecah = explode(",",$tindakan);														
					// if($pecah[0] == 'Oralit' || $pecah[0] = 'Infus' || $pecah[0] = 'Zinc'){
					// 	$oralit = '<span class="glyphicon glyphicon-ok"></span>';
					// 	$antibiotik = '-';
					// }elseif($pecah[1] == 'Oralit' || $pecah[1] == 'Oralit' and $pecah[1] == 'Oralit'){
					// 	$oralit = '<span class="glyphicon glyphicon-ok"></span>';
					// 	$antibiotik = '-';
					// }elseif($pecah[2] == 'Antibiotik' || $pecah[2] == 'Antibiotik' and $pecah[2] == 'Antibiotik'){
					// 	$oralit = '-';
					// 	$antibiotik = '<span class="glyphicon glyphicon-ok"></span>';	
					// }
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noreg' GROUP BY NoRegistrasi, KodeDiagnosa";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode("<br/>", $array_data[$no]);
					}else{
						$data_dgs ="";
					}

					// therapy
					$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$noreg'";
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
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($data_diare['TanggalDiagnosa']));?></td>
						<td align="left">
							<?php 
								echo "<b>".strtoupper($dt_pasienrj['NamaPasien']."</b><br/>".
								"NIK : ".$dtpasien['Nik']."</b><br/>".
								"TGL.LAHIR : ".date('d-m-Y', strtotime($dtpasien['TanggalLahir']))."<br/><br/>".
								"<b>".strtoupper($dtkk['NamaKK'])."</b><br/>".
								"No.Index : ".substr($noindex, -10)."<br/>".
								"CARA BAYAR : ".$dt_pasienrj['Asuransi']."<br/>".
								"PELAYANAN : ".str_replace('POLI','RUANG', $dt_pasienrj['PoliPertama'])."<br/>".
								"ALAMAT : ".$dtkk['Alamat'].", ".$dtkk['RT'].", ".$dtkk['Kelurahan'])."<br/>";
								
								if($dtkk['Telepon'] != ''){
									echo "TELP. : ".$dtkk['Telepon'];
								}else{
									if($dtpasien['Telpon'] != ''){
										echo "TELP. : ".$dtpasien['Telpon'];
									}else{
										echo "TELP. 0";
									}	
								}
								
							?>
						</td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="center"><?php echo $kunjungan;?></td>
						<td align="center"><?php echo $dtsistole."/".$dtdiastole;?></td>
						<td align="center"><?php echo $dtberatBadan."/".$dttinggiBadan;?></td>
						<td align="center"><?php echo $dtsuhutubuh;?></td>
						<td align="center"><?php echo $dtheartRate."/".$dtrespRate;?></td>
						<td align="left"><?php echo $datapoli['Anamnesa'];?></td>
						<td align="center"><?php echo $data_dgs;?></td>
						<td align="center"><?php echo $data_trp;?></td>
						<td align="left"><?php echo $rujuklanjut;?></td>
						<td align="left"><?php echo $berobatjalan;?></td>
						<td align="left"><?php echo strtoupper($pemeriksa);?></td>
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