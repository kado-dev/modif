<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = 'tbresepdetail_'.str_replace(' ', '', $namapuskesmas);
	$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>REGISTER RUANG LANSIA</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_registrasi_lansia_kukarkab"/>
						<div class="col-sm-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-sm-2 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate" class="form-control datepicker2" value="<?php echo $_GET['keydate'];?>" placeholder = "Tanggal">
							</div>
						</div>
						<div class="col-sm-2 bulanformcari">
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
						<div class="col-sm-1 bulanformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="kunjungan" class="form-control"placeholder="--Kunj--">
								<option value="Semua" <?php if($_GET['kunjungan'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kunjungan'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kunjungan'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="kelompokumur" class="form-control"placeholder="--Kunj--">
								<option value="Semua" <?php if($_GET['kelompokumur'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Pralansia (45 s/d 59)" <?php if($_GET['kelompokumur'] == 'Pralansia (45 s/d 59)'){echo "SELECTED";}?>>Pralansia (45 s/d 59)</option>
								<option value="Lansia (>60)" <?php if($_GET['kelompokumur'] == 'Lansia (>60)'){echo "SELECTED";}?>>Lansia (>60)</option>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_lansia_kukarkab" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<?php if($_GET['opsiform'] == 'tanggal'){?>
							<a href="lap_registrasi_lansia_kukarkab_print.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kunjungan=<?php echo $_GET['kunjungan'];?>&kelompokumur=<?php echo $_GET['kelompokumur'];?>" class="btn btn-sm btn-info"><span class="fa fa-print noprint"></span></a>
							<?php } ?>
							<a href="lap_registrasi_lansia_kukarkab_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kunjungan=<?php echo $_GET['kunjungan'];?>&kelompokumur=<?php echo $_GET['kelompokumur'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
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
		<table class="table-judul-laporan-min">
			<thead style="font-size: 8.5px;">
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="8%">TGL.</th>
					<th rowspan="2" width="8%">NIK</th>
					<th rowspan="2" width="5%">NO.RM</th>
					<th rowspan="2" width="10%">NAMA PASIEN</th>
					<th rowspan="2" width="10%">ALAMAT</th>
					<th rowspan="2">UMUR</th>
					<th colspan="5">DATA OBYEKTIF</th>
					<th colspan="5">P3G</th>
					<th rowspan="2">JAMINAN</th>
					<th colspan="2">TEKANAN</th>
					<th colspan="6">HASIL LABORAORIUM</th>
					<th colspan="2">RUJUK</th>
					<th rowspan="2" width="10%">DIAGNOSA</th>
					<th rowspan="2" width="10%">THERAPY</th>
					<th rowspan="2" width="10%">KET.</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>JK</th>
					<th>BB</th>
					<th>TB</th>
					<th>LP</th>
					<th>IMT</th>
					<th>ADL</th>
					<th>R.JATUH</th>
					<th>GDS</th>
					<th>MME</th>
					<th>MNA</th>
					<th>NORMAL</th>
					<th>TINGGI</th>
					<th>GDP</th><!--Hasil Laboratorium-->
					<th>GDS</th>
					<th>KOLES</th>
					<th>AU</th>
					<th>HB</th>
					<th>PROTEIN</th>
					<th>RS</th><!--Rujuk-->
					<th>POLI</th>
				</tr>
			</thead>
			<tbody style="font-size: 10px">
				<?php
				$jumlah_perpage = 25;
				
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
					$str2 = $str."ORDER BY `TanggalPeriksa` DESC limit $mulai,$jumlah_perpage";
				}else{
					$str = "SELECT * FROM `$tbpolilansia` WHERE TanggalPeriksa = '$keydate' AND substring(NoPemeriksaan,1,11) = '$kodepuskesmas'";				
					$str2 = $str."ORDER BY `NoPemeriksaan` DESC limit $mulai,$jumlah_perpage";
				}
				// echo ($str);
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
					$nocm = $data['NoCM'];
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
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
					
					// tbpasienrj
					$str_rj = "SELECT NoRM, JenisKelamin, UmurTahun, PoliPertama, StatusPulang, Asuransi, nokartu FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_rj = mysqli_query($koneksi,$str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$norm = substr($data_rj['NoRM'],-8);
					$kelamin = $data_rj['JenisKelamin'];
					$umur = $data_rj['UmurTahun']." th";
					$asuransi = $data_rj['Asuransi'];
					$nokartu = $data_rj['nokartu'];
					
					// tbkk
					$str_kk = "SELECT `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					
					if($alamat != null || $alamat != '' || $alamat != '-'){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", DS.".$data_kk['Kelurahan'];
					}else{
						$alamat = "-";
					}
					
					// tbpasien
					$str_pasien = "SELECT `Nik` FROM `$tbpasien` WHERE `NoCM` = '$nocm'";
					$query_pasien = mysqli_query($koneksi,$str_pasien);
					$data_pasien = mysqli_fetch_assoc($query_pasien);
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT a.`KodeDiagnosa`, b.Diagnosa FROM `$tbdiagnosapasien` a JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa  WHERE a.`NoRegistrasi` = '$noregistrasi'";
					// echo $str_diagnosapsn;
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
					$str_therapy = "SELECT a.`KodeBarang`, b.`NamaBarang` FROM `$tbresepdetail` a 
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
						<td><?php echo $data['TanggalPeriksa'];?></td>
						<td><?php echo $data_pasien['Nik'];?></td>
						<td><?php echo $norm;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $alamat;?></td>
						<td><?php echo $umur;?></td>
						<td><?php echo $kelamin;?></td>
						<td><?php echo $BB;?></td>
						<td><?php echo $TB;?></td>
						<td><?php echo $LP;?></td>
						<td><?php echo $IMT;?></td>
						<td><?php echo $adl;?></td><!--P3G-->
						<td><?php echo $resikojatuh;?></td>
						<td><?php echo $gds;?></td>
						<td><?php echo $mme;?></td>
						<td><?php echo $mna;?></td>
						<td><?php echo $asuransi."<br/>".$nokartu;?></td>
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
						<td><?php echo $td_normal;?></td><!--Tekanan Darah-->
						<td><?php echo $td_tinggi;?></td>
						<td><?php echo $gdplab;?></td><!--Hasil Laboratorium-->
						<td><?php echo $gdslab;?></td>
						<td><?php echo $koleslab;?></td>
						<td><?php echo $aulab;?></td>
						<td><?php echo $hblab;?></td>
						<td><?php echo $protlab;?></td>
						<td></td><!--Rujuk-->
						<td></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo str_replace(",", ", ", $data_dgs);?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data_trp;?></td><!--Therapy-->
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pemeriksa;?></td>
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
						echo "<li><a href='?page=lap_registrasi_lansia_kukarkab&opsiform=$opsiform&keydate=$keydate&bulan=$bulan&tahun=$tahun&kunjungan=$kunjungan&kelompokumur=$kelompokumur&h=$i'>$i</a></li>";
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