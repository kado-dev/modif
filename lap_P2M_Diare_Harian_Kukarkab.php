<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DIARE (REGISTER)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_Diare_Harian_Kukarkab"/>
						<div class="col-sm-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-sm-3 tanggalformcari" style="display:none">
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
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="kasus" class="form-control">
								<option value="semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Diare_Harian_Kukarkab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<?php if($_GET['opsiform'] == 'tanggal'){?>
							<a href="lap_P2M_Diare_Harian_Kukarkab_print.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<?php } ?>
							<a href="lap_P2M_Diare_Harian_Kukarkab_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&keydate=<?php echo $_GET['keydate'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-sm btn-info">Excel</a>
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
	$kasus = $_GET['kasus'];
	$opsiform = $_GET['opsiform'];
	$tbdiagnosapasien = "tbdiagnosapasien_".$bulan;
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl.Reg</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.RM</th>
							<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien & Nik</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kelamin</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Desa/Kel</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Derajat Dehidrasi</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemakaian</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Antibiotik</th>
							<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Therapy</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Status</th>
							<th rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Konseling</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;">Oralit</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">Infus</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">Zinc</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($kasus == "semua"){
							$qkasus = " ";
						}else{
							$qkasus = " AND `Kasus`='$kasus'";
						}
						
						$str = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `KodeDiagnosa`='A09'".$qkasus; 
						$str2 = $str." LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_diare = mysqli_query($koneksi,$str2);
						while($data_diare = mysqli_fetch_assoc($query_diare)){
							$no = $no + 1;
							$nocm = $data_diare['NoCM'];
							$noregistrasi = $data_diare['NoRegistrasi'];
							$tanggaldiagnosa = $data_diare['TanggalDiagnosa'];
													
							// tbpasien
							$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpasien` WHERE `NoCM` = '$nocm'"));
							$nik = $datapasien['Nik'];
							$norm = $datapasien['NoRM'];
							$namapasien = $datapasien['NamaPasien'];
							$desa = $datapasien['Kelurahan'];
							$alamat = $datapasien['Alamat'];
							
							// tbpasienrj
							$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
							$kunjungan = $datapasienrj['StatusKunjungan'];
							$jeniskelamin = $datapasienrj['JenisKelamin'];
							$umurtahun = $datapasienrj['UmurTahun'];
							$umurbulan= $datapasienrj['UmurBulan'];
							$pelayanan= $datapasienrj['PoliPertama'];
							
							if ($umurtahun != '0'){
								$umur = $umurtahun."Th";
							}else{
								$umur = $umurbulan."Bl";
							}
							
							// derajat dehidrasi
							if ($pelayanan == 'POLI MTBS'){
								$dt_mtbs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolimtbs` WHERE `NoPemeriksaan`='$noregistrasi'"));
								$dehidrasi = $dt_mtbs['KlasifikasiDiare'];
							}else{
								$dehidrasi = "-";
							}
							
							// tbresepdetail
							$oralit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.jumlahobat FROM `tbresepdetail` a
									JOIN `tbgudangpkmstok` b ON a.KodeBarang = b.KodeBarang
									WHERE a.`NoResep`='$noregistrasi' AND `NamaBarang` like '%ORALIT%'"));
									
									if($oralit != 0){
										$oralit_jml = $oralit['jumlahobat'];
									}else{
										$oralit_jml = "-";
									}
							
							$infus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.jumlahobat FROM `tbresepdetail` a
									JOIN `tbgudangpkmstok` b ON a.KodeBarang = b.KodeBarang
									WHERE a.`NoResep`='$noregistrasi' AND `NamaBarang` like '%RINGER LAKTAT%'"));
									
									if($infus != 0){
										$infus_jml = $infus['jumlahobat'];
									}else{
										$infus_jml = "-";
									}
									
							$zinc = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.jumlahobat FROM `tbresepdetail` a
									JOIN `tbgudangpkmstok` b ON a.KodeBarang = b.KodeBarang
									WHERE a.`NoResep`='$noregistrasi' AND `NamaBarang` like '%ZINC%'"));
									
									if($zinc != 0){
										$zinc_jml = $zinc['jumlahobat'];
									}else{
										$zinc_jml = "-";
									}
									
							// therapy
							$str_therapy = "SELECT * FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.`NoResep` = '$noregistrasi'";
							$query_therapy = mysqli_query($koneksi, $str_therapy);
							while($dt_therapy = mysqli_fetch_array($query_therapy)){
								$array_therapy[$no][] = $dt_therapy['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
							}
							if ($array_therapy[$no] != ''){
								$data_trp = implode(",", $array_therapy[$no]);
							}else{
								$data_trp ="";
							}
												
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $tanggaldiagnosa;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($norm,-8);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapasien."<br/>"."Nik : ".$nik; ?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jeniskelamin;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $desa;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $alamat;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pelayanan;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($dehidrasi);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $oralit_jml;?></td><!--oralit-->
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $infus_jml;?></td><!--infus-->
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $zinc_jml;?></td><!--zinc-->
								<td style="text-align:left; border:1px solid #000; padding:3px;">Tidak</td><!--antibiotik-->
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data_trp;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">Hidup</td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">Ya</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
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
						echo "<li><a href='?page=lap_P2M_Diare_Harian_Kukarkab&opsiform=$opsiform&keydate=$keydate&bulan=$bulan&tahun=$tahun&kasus=$kasus&h=$i'>$i</a></li>";
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
				<p><b>Perhatikan :</b><br/>
				- Silahkan pilih periode Bulan / Tanggal lalu klik menu cari<br/>
				- Klasifikasi Diare Kode ICD X (A09)</p>
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