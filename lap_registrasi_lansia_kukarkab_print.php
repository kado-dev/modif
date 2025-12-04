<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate = $_GET['keydate'];
	// filter
	$opsiform = $_GET['opsiform'];
?>
<html lang="en">
<head>
	<title>Register Lansia</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_lansia_kukarkab&opsiform=<?php echo $opsiform;?>&keydate=<?php echo $keydate;?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER LANSIA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
			?>
		</span>
		<br/>
	</div>
	
	<div class="atastabel font11">
		<div style="float:left; width:35%; margin-bottom:10px;">	
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kelurahan/Desa</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo strtoupper($kelurahan);?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Kecamatan</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo strtoupper($kecamatan);?></td>
				</tr>
			</table>
		</div>	
	</div>
	
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead style="font-size:8px;">
					<tr style="border:1px solid #000;">
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.RM</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
						<th colspan="5" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Data Obyektif</th>
						<th colspan="5" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P3G</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jaminan</th>
						<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tekanan</th>
						<th colspan="6" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Hasil Laboratorium</th>
						<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Rujuk</th>
						<th rowspan="2" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Diagnosa</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Therapy</th>
						<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Crn</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Ket</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th style="text-align:center; border:1px solid #000; padding:3px;">JK</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">BB</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">TB</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">LP</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">IMT</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Adl</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">R.Jatuh</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Gds</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Mme</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Mna</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Normal</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Tinggi</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Gdp</th><!--Hasil Laboratorium-->
						<th style="text-align:center; border:1px solid #000; padding:3px;">Gds</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Koles</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Au</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Hb</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Protein</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">RS</th><!--Rujuk-->
						<th style="text-align:center; border:1px solid #000; padding:3px;">Poli</th>
					</tr>
				</thead>
				<tbody style="font-size:8px;">
					<?php
					if($kunjungan == 'Baru'){
						$status_kunj = " AND b.StatusKunjungan = 'Baru'";
					}elseif ($kunjungan == 'Lama'){
						$status_kunj = " AND b.StatusKunjungan = 'Lama'";
					}else{
						$status_kunj = " ";
					}
					
					if($kelompokumur == 'Pralansia (45 s/d 59)'){
						$status_umur = " AND b.UmurTahun BETWEEN '45' AND '59'";
					}elseif ($kelompokumur == 'Lansia (>60)'){
						$status_umur = " AND b.UmurTahun BETWEEN '60' AND '100'";
					}else{
						$status_umur = " ";
					}
					
					if($opsiform == 'bulan'){
						$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
						$tbpasienperpegawai='tbpasienperpegawai_'.$bulan;
						$str = "SELECT * FROM `$tbpolilansia`
						WHERE  MONTH(TanggalPeriksa) = '$bulan' and YEAR(TanggalPeriksa) = '$tahun' and substring(NoPemeriksaan,1,11) = '$kodepuskesmas'"
						.$status_kunj.$status_umur;
						$str2 = $str."ORDER BY `TanggalPeriksa` DESC";
					}else{
						// $tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate));
						$tbdiagnosapasien = 'tbdiagnosapasien_'.date('m', strtotime($keydate));
						$tbpasienperpegawai='tbpasienperpegawai_'.date('m', strtotime($keydate));
						$str = "SELECT * FROM `$tbpolilansia` WHERE TanggalPeriksa = '$keydate' AND substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";				
						$str2 = $str."ORDER BY `NoPemeriksaan` DESC";
					}
					// echo ($str);
					// die();				
										
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noregistrasi = $data['NoPemeriksaan'];
						$noindex = $data['NoIndex'];
						$anamnesa = $data['Anamnesa'];
						$kunjungan = $data['StatusKunjungan'];
						$sistole = $data['Sistole'];
						$diastole = $data['Diastole'];
						$BB = $data['BeratBadan'];
						$TB = $data['TinggiBadan'];
						$LP = $data['LingkarPerut'];
						$IMT = $data['Imt'];
						$status_td = $data['StatusTekananDarah'];
						$adl = $data['Adl'];
						$resikojatuh = $data['ResikoJatuh'];
						$gds = $data['Gds'];
						$mme = $data['Mme'];
						$mna = $data['Mna'];
						$gdplab = $data['GdpLab'];
						$gdslab = $data['GdsLab'];
						$koleslab = $data['KolesLab'];
						$aulab = $data['AuLab'];
						$hblab = $data['HbLab'];
						$protlab = $data['ProtLab'];
						
						// tbpasienperpegawai
						$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
						if($dt_pegawai['NamaPegawai1']!=''){
							$pemeriksa = $dt_pegawai['NamaPegawai1'];
						}else{
							$pemeriksa = $dt_pegawai['NamaPegawai2'];
						}
						
						// tbpasienrj
						$str_rj = "SELECT NoRM, JenisKelamin, UmurTahun, PoliPertama, StatusPulang, Asuransi FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
						$query_rj = mysqli_query($koneksi,$str_rj);
						$data_rj = mysqli_fetch_assoc($query_rj);
						$norm = substr($data_rj['NoRM'],-8);
						$kelamin = $data_rj['JenisKelamin'];
						$umur = $data_rj['UmurTahun']." th";
						$asuransi = $data_rj['Asuransi'];
						
						// tbkk
						$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
						$query_kk = mysqli_query($koneksi,$str_kk);
						$data_kk = mysqli_fetch_assoc($query_kk);
						
						if($alamat != null || $alamat != '' || $alamat != '-'){
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
						}else{
							$alamat = "-";
						}
						
						// tbdiagnosapasien
						$str_diagnosapsn = "SELECT a.`KodeDiagnosa`, b.Diagnosa FROM `$tbdiagnosapasien` a JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa  WHERE a.`NoRegistrasi` = '$noregistrasi'";
						$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);						
						while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
							$array_data[$no][] = $data_diagnosapsn['Diagnosa'];
						}
						if ($array_data[$no] != ''){
							$data_dgs = implode(",", $array_data[$no]);
						}else{
							$data_dgs ="-";
						}
						// echo $data_dgs;
						
						// therapy 
						$str_therapy = "SELECT a.`KodeBarang`, b.`NamaBarang` FROM `tbresepdetail` a 
						JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.`NoResep` = '$noregistrasi'";
						$query_therapy = mysqli_query($koneksi,$str_therapy);
						while($data_therapy = mysqli_fetch_array($query_therapy)){
							$array_data_trp[$no][] = $data_therapy['NamaBarang'];
						}
						if ($array_data_trp[$no] != ''){
							$data_trp = implode(",", $array_data_trp[$no]);
						}else{
							$data_trp ="-";
						}
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $norm;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $alamat;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kelamin;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $BB;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $TB;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $LP;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $IMT;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $adl;?></td><!--P3G-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $resikojatuh;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gds;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $mme;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $mna;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $asuransi;?></td>
							<?php
								if($sistole == '' || $diastole == ''){
									$td_normal = '-';
									$td_tinggi = '-';
								}else{
									if($status_td == 'N'){
										$td_normal = $sistole."/".$diastole;
									}else{
										$td_normal = '-';
									}
									
									if($status_td == 'T'){
										$td_tinggi = $sistole."/".$diastole;
									}else{
										$td_tinggi = '-';
									}
								}
							?>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $td_normal;?></td><!--Tekanan Darah-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $td_tinggi;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gdplab;?></td><!--Hasil Laboratorium-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gdslab;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $koleslab;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $aulab;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $hblab;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $protlab;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td><!--Rujuk-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data_trp;?></td><!--Therapy-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td><!--Crn-->
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pemeriksa;?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>