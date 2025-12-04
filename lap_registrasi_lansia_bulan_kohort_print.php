<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";	
	
	// get
	$opsiform = $_GET['opsiform'];
	$keydate = $_GET['keydate'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kunjungan = $_GET['kunjungan'];
	$kelompokumur = $_GET['kelompokumur'];
?>
<html lang="en">
<head>
	<title>Register Kohort Lansia</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_lansia_kukarkab&opsiform=<?php echo $opsiform;?>&keydate=<?php echo $keydate;?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KOHORT LANSIA</b></span><br>
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
	
	<div class="atastabel">
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
				<thead style="font-size: 10px;">
					<tr style="border:1px solid #000;">
						<th rowspan="4" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th rowspan="4" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
						<th rowspan="4" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
						<th rowspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L/P</th>
						<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
						<th colspan="2" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl.Pemeriksaan Sts.Fungsional & Lab</th>
						<th colspan="14" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P3G</th>
						<th rowspan="4" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penyu<br/>luhan</th>
						<th rowspan="4" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pember<br/>dayaan</th>
						<th colspan="8" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemeriksaan Fisik & Tindakan</th>
						
					</tr>
					<tr style="border:1px solid #000;">
						<th rowspan="3" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">45-59 tahun</th>
						<th rowspan="3" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">60-69 tahun</th>
						<th rowspan="3" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">≥ 70 tahun</th>
						<th rowspan="3" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">1</th>
						<th rowspan="3" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">2</th>
						<th colspan="6" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">Tingkat Kemandirian (AKS/ADL)</th>
						<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">Gangguan Mental Emosional</th>
						<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">Gangguan Kognitif</th>
						<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">Risiko Malnutrisi (MNA)</th>
						<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">Risiko Jatuh</th>
						<th colspan="8" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">
							<?php 
								if($opsiform == "Bulan"){
									echo nama_bulan($bulan);
								}else{
									echo nama_bulan(date('m', strtotime($keydate)));
								}	
							?>
						</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th colspan="3" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">1</th>
						<th colspan="3" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">2</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">1</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">2</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">1</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">2</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">1</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">2</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">1</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">2</th>
						<th rowspan="2" width="6%" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">Tanggal</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">BB</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">BB</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">TD<br/>(mmHg)</th>
						<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">Lain-lain</th>
						<th colspan="3" style="text-align:center; border:1px solid #000; padding:3px; vertical-align:middle;">Tindakan</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th style="text-align:center; border:1px solid #000; padding:3px;">A</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">B</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">C</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">A</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">B</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">C</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">Tatalaksana</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">K</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">R</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th style="text-align:center; border:1px solid #000; padding:3px;">1</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">2</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">3</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">4</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">5</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">6</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">7</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">8</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">9</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">10</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">11</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">12</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">13</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">14</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">15</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">16</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">17</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">18</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">19</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">20</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">21</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">22</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">23</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">24</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">25</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">26</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">27</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">28</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">29</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">30</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">31</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">32</th>
						<th style="text-align:center; border:1px solid #000; padding:3px;">33</th>
					</tr>
				</thead>
				<tbody style="font-size: 10px">
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
					// echo $str;
					// die();				
					
					
					$no = 0;
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$tanggalperiksa = $data['TanggalPeriksa'];
						$noregistrasi = $data['NoPemeriksaan'];
						$noindex = $data['NoIndex'];
						$anamnesa = $data['Anamnesa'];
						$kemandirian = $data['Kemandirian'];
						$beratbadan = $data['BeratBadan'];
						$tinggibadan = $data['TinggiBadan'];
						
						if ($data['Sistole'] == ""){
							$tensi = "-";
						}else{
							$tensi = $data['Sistole']."/".$data['Diastole'];
						}	
						
						// tbpasienrj
						$str_rj = "SELECT NoRM, JenisKelamin, UmurTahun, PoliPertama, StatusPulang, Asuransi FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
						$query_rj = mysqli_query($koneksi,$str_rj);
						$data_rj = mysqli_fetch_assoc($query_rj);
						$norm = substr($data_rj['NoRM'],-8);
						$kelamin = $data_rj['JenisKelamin'];
						$umur = $data_rj['UmurTahun']." th";
						$asuransi = $data_rj['Asuransi'];
						
						// umur
						if($data_rj['UmurTahun'] <= '59'){
							$umur4550 = $umur;
						}else{
							$umur4550 = "-";
						}	
						if($data_rj['UmurTahun'] >= '60' AND $data_rj['UmurTahun'] <= '69'){
							$umur6069 = $umur;
						}else{
							$umur6069 = "-";
						}		
						if($data_rj['UmurTahun'] >= '70'){
							$umur70 = $umur;
						}else{
							$umur70 = "-";
						}	
						
						// kemandirian
						if($data['Kemandirian'] == 'A'){
							$kemandirian_a = $kemandirian;
						}else{
							$kemandirian_a = '-';
						}		
						if($data['Kemandirian'] == 'B'){
							$kemandirian_b = $kemandirian;
						}else{
							$kemandirian_b = '-';
						}		
						if($data['Kemandirian'] == 'C'){
							$kemandirian_c = $kemandirian;	
						}else{
							$kemandirian_c = '-';
						}	

						// gangguan kognitif
						if($data['RiwayatPenyakit'] == ""){
							$kognitif = $data['Mme'];
						}else{	
							$array_data[$no][] = $data['RiwayatPenyakit'];
							if($array_data[$no] != ''){
								$kognitif = implode(",", $array_data[$no]);
							}else{
								$kognitif = "-";
							}
						}	
						
						// tbkk
						$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
						$query_kk = mysqli_query($koneksi,$str_kk);
						$data_kk = mysqli_fetch_assoc($query_kk);
						
						if($alamat != null || $alamat != '' || $alamat != '-'){
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
						}else{
							$alamat = "-";
						}
						
					?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaPasien']);?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($alamat);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kelamin;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur4550;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur6069;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur70;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date("d/m/y", strtotime($data['TanggalPeriksa']));?></td><!--Tgl.PeriksaLab-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kemandirian_a;?></td><!--kemandirian-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kemandirian_b;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kemandirian_c;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['GangguanEmosional'];?></td><!--gangguan mental-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kognitif;?></td><!--gangguan kognitif-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Mna'];?></td><!--Penilaian Risiko Malnutrisi (MNA)-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['ResikoJatuh'];?></td><!--Penilaian Risiko Jatuh-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Penyuluhan'];?></td><!--penyuluhan-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Pemberdayaan'];?></td><!--pemberdayaan-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date("d/m/y", strtotime($tanggalperiksa));?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $beratbadan;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tinggibadan;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tensi;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"></td>
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