<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER KECELAKAAN LALU LINTAS</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_kecelakaan_lalulintas"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
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
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_kecelakaan_lalulintas" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_kecelakaan_lalulintas_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&asalpasien=<?php echo $_GET['asalpasien'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$asalpasien = $_GET['asalpasien'];
	if(isset($bulan) and isset($tahun)){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="row font10">
			<div class="col-sm-12">
				<div class="table-responsive text_nowrap">
					<table class="table-judul-laporan-min" width="100%"><!--style="width:1500px;"-->
						<thead>
							<tr style="border:1px solid #000;">
								<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
								<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Hari</th>
								<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
								<th colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Jam</th>
								<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Kendaraan<br> Yang Terlibat</th>
								<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.Polisi</th>
								<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Lokasi Kejadian</th>
								<th colspan="5" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Identitas Pasien</th>
								<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Diagnosis</th>
								<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Therapy</th>
								<th colspan="3" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Kondisi Akhir</th>
							</tr>
							<tr style="border:1px solid #000;">
								<th style="text-align:center;border:1px solid #000; padding:3px;">Kecelakaan</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">Berobat</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">Nama</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">Umur</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">JK</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">Alamat</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">Telp.</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">Pulang</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">Rujuk</th>
								<th style="text-align:center;border:1px solid #000; padding:3px;">Meninggal</th>
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
							
							if($opsiform == 'bulan'){
								$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";			
								if ($asalpasien == 'semua_pasien'){
									$str = "SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
								}else{
									$str = "SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND AsalPasien='$asalpasien'";
								}	
							}else{
								$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
								$tbpasienrj2 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
								
								if ($asalpasien == 'semua_pasien'){
									$str = "SELECT * FROM(
									SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu 
									FROM `$tbpasienrj`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
									UNION
									SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu 
									FROM `$tbpasienrj2`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
									) tbalias";
								}else{
									$str = "SELECT * FROM(
									SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu
									FROM `$tbpasienrj`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu." and AsalPasien='$asalpasien'
									UNION
									SELECT TanggalRegistrasi, NoRegistrasi, NoIndex, NoCM, NoRM, NamaPasien, JenisKelamin, UmurTahun, PoliPertama, Asuransi, StatusKunjungan, StatusPulang, TarifKarcis, nokartu
									FROM `$tbpasienrj2`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu." and AsalPasien='$asalpasien'
									) tbalias";
								}
							}
							$str2 = $str." ORDER BY Tanggalregistrasi, NoRegistrasi DESC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$noindex = $data['NoIndex'];
								$nocm = $data['NoCM'];
								$asuransi = $data['Asuransi'];
								$nomorasuransi = $data['nokartu'];
							
								if(strlen($nocm) == 23){
									$thn = substr($data['NoCM'],12,4);
									$tbpasien='tbpasien_'.$thn;
									$dt_nojaminan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoAsuransi FROM `$tbpasien` WHERE NoCM = '$nocm'"));
									$nocm = $dt_nojaminan['NoAsuransi'];
								}else{
									$nocm = $data['NoCM'];
								}
												
								// tbkk
								$strkk = "SELECT Alamat, RT, RW FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
								$querykk = mysqli_query($koneksi,$strkk);
								$datakk = mysqli_fetch_assoc($querykk);
								$alamat = $datakk['Alamat'];
								
								if($alamat != null){
									$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'];
								}else{
									$alamat = "-";
								}
								
								if($asuransi == 'BPJS PBI' || $asuransi == 'BPJS NON PBI' || $asuransi == 'KIS'){
									$noasuransi = $nomorasuransi;
								}else{
									$noasuransi = "0";
								}
							?>
								<tr style="border:1px solid #000;">
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalRegistrasi'];?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoRegistrasi'],19);?></td>
									<?php if($kota != 'KABUPATEN KUTAI KARTANEGARA'){ ?>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php
											if ($noindex == ''){
												echo $noindex = '0';
											}else{
												echo $noindex = substr($noindex,14);
											}
										?>
									</td>
									<?php } ?>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){
												$norms = substr($data['NoRM'],-6);
											}elseif ($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
												$norms = substr($data['NoRM'],-6);
											}elseif ($_SESSION['kota'] == 'KABUPATEN BANDUNG'){
												$norms = substr($data['NoRM'],-6);
											}elseif ($_SESSION['kota'] == 'KOTA BANDUNG'){
												$norms = substr($data['NoRM'],-6);	
											}else{
												if(strlen($data['NoRM']) == 22){
													$norms = substr($data['NoRM'],-11);
												}elseif(strlen($data['NoRM']) == 20){
													$norms = substr($data['NoRM'],-9);
												}elseif(strlen($data['NoRM']) == 17){
													$norms = substr($data['NoRM'],-6);
												}elseif(strlen($data['NoRM']) == 19){
													$norms = substr($data['NoRM'],-8);
												}
											}
											echo $norms;
										?>
									</td>
									<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaPasien']);?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['JenisKelamin'];?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['UmurTahun']."Th";?><!--, <?php echo $data['UmurBulan'];?> Bl,  <?php echo $data['UmurHari'];?> Hr--></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
		
	<hr class="noprint"><!--css-->
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
						echo "<li><a href='?page=lap_loket_kecelakaan_lalulintas&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&asalpasien=$asalpasien&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<b>Perhatikan :</b><br/>
					- Print laporan silahkan klik tombol Export<br/>
					- Format Laporan : 441/020/Yankes
				</p>
			</div>
		</div>
	</div>
	
	<?php
	}
	?>
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