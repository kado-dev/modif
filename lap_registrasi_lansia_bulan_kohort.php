<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER POLI LANSIA (KOHORT)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_lansia_bulan_kohort"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-2 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate" class="form-control datepicker2" value="<?php echo $_GET['keydate'];?>" placeholder = "Tanggal">
							</div>
						</div>
						<div class="col-xl-2 bulanformcari">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-1 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="kunjungan" class="form-control"placeholder="--Kunj--">
								<option value="Semua" <?php if($_GET['kunjungan'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kunjungan'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kunjungan'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="kelompokumur" class="form-control"placeholder="--Kunj--">
								<option value="Semua" <?php if($_GET['kelompokumur'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Pralansia (45 s/d 59)" <?php if($_GET['kelompokumur'] == 'Pralansia (45 s/d 59)'){echo "SELECTED";}?>>Pralansia (45 s/d 59)</option>
								<option value="Lansia (>60)" <?php if($_GET['kelompokumur'] == 'Lansia (>60)'){echo "SELECTED";}?>>Lansia (>60)</option>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_lansia_bulan_kohort" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php if($_GET['opsiform'] == 'tanggal'){?>
							<a href="lap_registrasi_lansia_bulan_kohort_print.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kunjungan=<?php echo $_GET['kunjungan'];?>&kelompokumur=<?php echo $_GET['kelompokumur'];?>" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<?php } ?>
							<a href="lap_registrasi_lansia_bulan_kohort_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kunjungan=<?php echo $_GET['kunjungan'];?>&kelompokumur=<?php echo $_GET['kelompokumur'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
	<?php
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$keydate = $_GET['keydate'];
		$opsiform = $_GET['opsiform'];
		$kunjungan = $_GET['kunjungan'];
		$kelompokumur = $_GET['kelompokumur'];
		if(isset($bulan) and isset($tahun)){
	?>

	<div class="table-responsive noprint">
		<table class="table-judul-laporan">
			<thead>
				<tr>
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
				<tr>
					<th rowspan="3">45-59 TH</th>
					<th rowspan="3">60-69 TH</th>
					<th rowspan="3">≥ 70 TH</th>
					<th rowspan="3">1</th>
					<th rowspan="3">2</th>
					<th colspan="6">Tingkat Kemandirian (AKS/ADL)</th>
					<th colspan="2">Gangguan Mental Emosional</th>
					<th colspan="2">Gangguan Kognitif</th>
					<th colspan="2">Penilaian Risiko Malnutrisi (MNA)</th>
					<th colspan="2">Penilaian Risiko Jatuh</th>
					<th colspan="8">
						<?php 
							if($opsiform == "Bulan"){
								echo nama_bulan($bulan);
							}else{
								echo nama_bulan(date('m', strtotime($keydate)));
							}	
						?>
					</th>
				</tr>
				<tr>
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
				<tr>
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
			<tbody>
				<?php
				$jumlah_perpage = 50;
				
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
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
					$str2 = $str."ORDER BY `TanggalPeriksa` DESC LIMIT $mulai,$jumlah_perpage";
				}else{
					$str = "SELECT * FROM `$tbpolilansia` WHERE TanggalPeriksa = '$keydate' AND substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";				
					$str2 = $str."ORDER BY `NoPemeriksaan` DESC LIMIT $mulai,$jumlah_perpage";
				}
				// echo $str;
				// die();				
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
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
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaPasien']);?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($alamat);?></td>
						<td><?php echo $kelamin;?></td>
						<td><?php echo $umur4550;?></td>
						<td><?php echo $umur6069;?></td>
						<td><?php echo $umur70;?></td>
						<td><?php echo date("d/m/y", strtotime($data['TanggalPeriksa']));?></td><!--Tgl.PeriksaLab-->
						<td></td>
						<td><?php echo $kemandirian_a;?></td><!--kemandirian-->
						<td><?php echo $kemandirian_b;?></td>
						<td><?php echo $kemandirian_c;?></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $data['GangguanEmosional'];?></td><!--gangguan mental-->
						<td></td>
						<td><?php echo $kognitif;?></td><!--gangguan kognitif-->
						<td></td>
						<td><?php echo $data['Mna'];?></td><!--Penilaian Risiko Malnutrisi (MNA)-->
						<td></td>
						<td><?php echo $data['ResikoJatuh'];?></td><!--Penilaian Risiko Jatuh-->
						<td></td>
						<td><?php echo $data['Penyuluhan'];?></td><!--penyuluhan-->
						<td><?php echo $data['Pemberdayaan'];?></td><!--pemberdayaan-->
						<td><?php echo $tanggalperiksa;?></td>
						<td><?php echo $beratbadan;?></td>
						<td><?php echo $tinggibadan;?></td>
						<td><?php echo $tensi;?></td>
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
	</div><br/>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_registrasi_lansia_bulan_kohort&opsiform=$opsiform&keydate=$keydate&bulan=$bulan&tahun=$tahun&kunjungan=$kunjungan&kelompokumur=$kelompokumur&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatian :</b><br/>
				- Jika filter berdasar <b>Bulan</b> silahkan klik tombol Excel untuk mencetak laporan<br/>
				- Jika filter berdasar <b>Tanggal</b> silahkan klik tombol Print untuk mencetak laporan</p>
			</div>
		</div>
	</div>
</div>	
<?php
}
?>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
$(document).ready(function(){
	if($(".opsiform").val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>