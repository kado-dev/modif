<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tanggal = date('Y-m-d');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	// filterdata
	$opsiform = $_GET['opsiform'];
	$keydate = $_GET['keydate'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Kohort_Lansia (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
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
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KOHORT LANSIA</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $keydat;?></p>
		<?php } ?>
	</p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th rowspan="4" width="3%">No.</th>
					<th rowspan="4" width="10%">Nama Pasien</th>
					<th rowspan="4" width="10%">Alamat</th>
					<th rowspan="4">L/P</th>
					<th colspan="3">Umur</th>
					<th colspan="2" width="8%">Tgl.Pemeriksaan Status Fungsional & Lab</th>
					<th colspan="14">P3G</th>
					<th rowspan="4" width="3%">Penyuluhan</th>
					<th rowspan="4" width="3%">Pemberdayaan</th>
					<th colspan="8" width="3%">Pemeriksaan Fisik & Tindakan</th>
					
				</tr>
				<tr style="border:1px solid #000;">
					<th rowspan="3">45-59 tahun</th>
					<th rowspan="3">60-69 tahun</th>
					<th rowspan="3">≥ 70 tahun</th>
					<th rowspan="3">1</th>
					<th rowspan="3">2</th>
					<th colspan="6">Tingkat Kemandirian (AKS/ADL)</th>
					<th colspan="2">Gangguan Mental Emosional</th>
					<th colspan="2">Gangguan Kognitif</th>
					<th colspan="2">Penilaian Risiko Malnutrisi (MNA)</th>
					<th colspan="2">Penilaian Risiko Jatuh</th>
					<th colspan="8"><?php echo nama_bulan($bulan);?></th>
				</tr>
				<tr style="border:1px solid #000;">
					<th colspan="3">1</th>
					<th colspan="3">2</th>
					<th rowspan="2">1</th>
					<th rowspan="2">2</th>
					<th rowspan="2">1</th>
					<th rowspan="2">2</th>
					<th rowspan="2">1</th>
					<th rowspan="2">2</th>
					<th rowspan="2">1</th>
					<th rowspan="2">2</th>
					<th rowspan="2" width="5%">Tanggal</th>
					<th rowspan="2">BB</th>
					<th rowspan="2">BB</th>
					<th rowspan="2">TD<br/>(mmHg)</th>
					<th rowspan="2">Lain-lain</th>
					<th colspan="3">Tindakan</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>A</th>
					<th>B</th>
					<th>C</th>
					<th>A</th>
					<th>B</th>
					<th>C</th>
					<th>Tatalaksana</th>
					<th>K</th>
					<th>R</th>
				</tr>
				<tr style="border:1px solid #000;">
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
					<th>19</th>
					<th>20</th>
					<th>21</th>
					<th>22</th>
					<th>23</th>
					<th>24</th>
					<th>25</th>
					<th>26</th>
					<th>27</th>
					<th>28</th>
					<th>29</th>
					<th>30</th>
					<th>31</th>
					<th>32</th>
					<th>33</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
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
					$str = "SELECT * FROM `$tbpolilansia`
					WHERE  MONTH(TanggalPeriksa) = '$bulan' and YEAR(TanggalPeriksa) = '$tahun' and substring(NoPemeriksaan,1,11) = '$kodepuskesmas'"
					.$status_kunj.$status_umur;
					$str2 = $str."ORDER BY `TanggalPeriksa` DESC";
				}else{
					$str = "SELECT * FROM `$tbpolilansia` WHERE TanggalPeriksa = '$keydate' AND substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";				
					$str2 = $str."ORDER BY `NoPemeriksaan` DESC";
				}
				
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
					$str_kk = "SELECT `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					
					if($alamat != null || $alamat != '' || $alamat != '-'){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", DS.".$data_kk['Kelurahan'];
					}else{
						$alamat = "-";
					}
					
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right;"><?php echo $no;?></td>
						<td style="text-align:left;"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:left;"><?php echo $alamat;?></td>
						<td style="text-align:center;"><?php echo $kelamin;?></td>
						<td style="text-align:center;"><?php echo $umur4550;?></td>
						<td style="text-align:center;"><?php echo $umur6069;?></td>
						<td style="text-align:center;"><?php echo $umur70;?></td>
						<td style="text-align:center;"><?php echo date("d/m/y", strtotime($data['TanggalPeriksa']));?></td><!--Tgl.PeriksaLab-->
						<td style="text-align:center;"></td>
						<td style="text-align:center;"><?php echo $kemandirian_a;?></td><!--kemandirian-->
						<td style="text-align:center;"><?php echo $kemandirian_b;?></td>
						<td style="text-align:center;"><?php echo $kemandirian_c;?></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"><?php echo $data['GangguanEmosional'];?></td><!--gangguan mental-->
						<td style="text-align:center;"></td>
						<td style="text-align:center;"><?php echo $kognitif;?></td><!--gangguan kognitif-->
						<td style="text-align:center;"></td>
						<td style="text-align:center;"><?php echo $data['Mna'];?></td><!--Penilaian Risiko Malnutrisi (MNA)-->
						<td style="text-align:center;"></td>
						<td style="text-align:center;"><?php echo $data['ResikoJatuh'];?></td><!--Penilaian Risiko Jatuh-->
						<td style="text-align:center;"></td>
						<td style="text-align:center;"><?php echo $data['Penyuluhan'];?></td><!--penyuluhan-->
						<td style="text-align:center;"><?php echo $data['Pemberdayaan'];?></td><!--pemberdayaan-->
						<td style="text-align:center;"><?php echo $tanggalperiksa;?></td>
						<td style="text-align:center;"><?php echo $beratbadan;?></td>
						<td style="text-align:center;"><?php echo $tinggibadan;?></td>
						<td style="text-align:center;"><?php echo $tensi;?></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"></td>
						<td style="text-align:center;"></td>
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