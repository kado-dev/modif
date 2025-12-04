<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER POLI UMUM</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_umum_kukarkab"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-3 tanggalformcari" style="display:none">
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
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_lansia_kukarkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php if($_GET['opsiform'] == 'tanggal'){?>
							<a href="lap_registrasi_umum_kukarkab_print.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kunjungan=<?php echo $_GET['kunjungan'];?>&kelompokumur=<?php echo $_GET['kelompokumur'];?>" class="btn btn-round btn-info"><span class="fa fa-print noprint"></span></a>
							<?php } ?>
							<a href="lap_registrasi_umum_kukarkab_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kunjungan=<?php echo $_GET['kunjungan'];?>&kelompokumur=<?php echo $_GET['kelompokumur'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="table-responsive">
		<table class="table-judul-laporan">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="6%">TGL.PERIKSA</th>
					<th rowspan="2" width="4%">NO.RM</th>
					<th rowspan="2" width="8%">NAMA PASIEN</th>
					<th rowspan="2" width="8%">ALAMAT</th>
					<th colspan="2" width="6%">UMUR</th>
					<th colspan="7" width="20%">VITAL SIGN</th>
					<th rowspan="2" width="5%">KODE ICD X</th>
					<th rowspan="2" width="5%">DIAGNOSA</th>
					<th rowspan="2" width="8%">THERAPY</th>
					<th rowspan="2" width="3%">RUJUK</th>
					<th rowspan="2" width="5%">ASURANSI</th>
					<th rowspan="2" width="5%">KUNJ.</th>
					<th rowspan="2" width="8%">KET.</th>
				</tr>
				<tr>
					<th>L</th>
					<th>P</th>
					<th>TD</th><!--Vitalsign-->
					<th>N</th>
					<th>S</th>
					<th>P</th>
					<th>BB</th>
					<th>TB</th>
					<th>LP</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$jumlah_perpage = 20;
				
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				if($opsiform == 'bulan'){
					$str = "SELECT * FROM `$tbpoliumum`
					WHERE  MONTH(TanggalPeriksa) = '$bulan' and YEAR(TanggalPeriksa) = '$tahun' and substring(NoPemeriksaan,1,11) = '$kodepuskesmas'"
					.$status_kunj.$status_umur;
					$str2 = $str."ORDER BY `TanggalPeriksa` DESC, `NamaPasien` ASC LIMIT $mulai,$jumlah_perpage";
				}else{
					$str = "SELECT * FROM `$tbpoliumum` WHERE TanggalPeriksa = '$keydate' AND substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";				
					$str2 = $str."ORDER BY `NoPemeriksaan` DESC, `NamaPasien` ASC LIMIT $mulai,$jumlah_perpage";
				}
				// echo $str2;
				// die();
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$norm = $data['NoRM'];
					$kelamin = $data['JenisKelamin'];
					$td = $data['Sistole']."/".$data['Diastole'];
					$rr = $data['RR'];
					$nadi = $data['DetakNadi'];
					$suhu = $data['SuhuTubuh'];
					$bb = $data['BeratBadan'];
					$tb = $data['TinggiBadan'];
					$lp = $data['LingkarPerut'];
					$asuransi = $data['Asuransi'];
				
					// tbpasienperpegawai
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
					
					// tbpasienrj
					$str_rj = "SELECT `NoRM`, `JenisKelamin`, `UmurTahun`, `PoliPertama`, `StatusPulang`, `Asuransi`, `StatusKunjungan` FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$norm = substr($data_rj['NoRM'],-8);
					$kelamin = $data_rj['JenisKelamin'];
					$umur = $data_rj['UmurTahun']." Th";
					$asuransi = $data_rj['Asuransi'];
					$kunjungan = $data_rj['StatusKunjungan'];
					
					// tbkk
					$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					
					if($alamat != null || $alamat != '' || $alamat != '-'){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", DS.".$data_kk['Kelurahan'];
					}else{
						$alamat = "-";
					}			
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT a.`KodeDiagnosa`, b.Diagnosa FROM `$tbdiagnosapasien` a JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa  WHERE a.`NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);						
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['Diagnosa'];
						$array_data1[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="-";
					}
					
					if ($array_data1[$no] != ''){
						$kode_dgs = implode(",", $array_data1[$no]);
					}else{
						$kode_dgs ="-";
					}				
					
					//cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $umur;
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $umur;
					}
					
					//cek rujukan
					$rujukan = $data_rj['StatusPulang'];
					if ($rujukan == 3){
						$rujuk = 'Tidak';
					}else{
						$rujuk = 'Ya';
					}
					
					// therapy
					$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
					$query_therapy = mysqli_query($koneksi, $str_therapy);
					while($dt_therapy = mysqli_fetch_array($query_therapy)){
						$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NamaBarang FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
						$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
					}
					if ($array_therapy[$no] != ''){
						$data_trp = implode(",", $array_therapy[$no]);
					}else{
						$data_trp ="";
					}
					
				?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $data['TanggalPeriksa'];?></td>
						<td><?php echo substr($norm,-8);?></td>
						<td><?php echo $data['NamaPasien'];?></td>
						<td><?php echo $alamat;?></td>
						<td><?php echo $umur_l;?></td>
						<td><?php echo $umur_p;?></td>
						<td><?php echo $td;?></td><!--Vitalsign-->
						<td><?php echo $nadi;?></td>
						<td><?php echo $suhu;?></td>
						<td><?php echo $rr;?></td>
						<td><?php echo $bb;?></td>
						<td><?php echo $tb;?></td>
						<td><?php echo $lp;?></td>
						<td><?php echo str_replace(",", ", ", $kode_dgs);?></td>
						<td><?php echo str_replace(",", ", ", $data_dgs);?></td>
						<td><?php echo $data_trp;?></td>
						<td><?php echo $rujuk;?></td>
						<td><?php echo $asuransi;?></td>
						<td><?php echo $kunjungan;?></td>
						<td><?php echo $pemeriksa;?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<br>
	<ul class="pagination">
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
						echo "<li><a href='?page=lap_registrasi_umum_kukarkab&opsiform=$opsiform&keydate=$keydate&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
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



