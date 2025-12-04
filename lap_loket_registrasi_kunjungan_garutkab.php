<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>REGISTER KUNJUNGAN PASIEN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_loket_registrasi_kunjungan_garutkab"/>
						<div class="col-sm-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-sm-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
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
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="asalpasien" class="form-control asuransi">
								<option value='semua_pasien'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbasalpasien` order by `AsalPasien` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['asalpasien'] == $data['AsalPasien']){
											echo "<option value='$data[Id]' SELECTed>$data[AsalPasien]</option>";
										}else{
											echo "<option value='$data[Id]'>$data[AsalPasien]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_registrasi_kunjungan_garutkab" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_registrasi_kunjungan_garutkab_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&asalpasien=<?php echo $_GET['asalpasien'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
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
	$hariini = date('d');
	if(isset($bulan) and isset($tahun)){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan">
						<thead>
							<tr style="border:1px solid #000;">
								<th width="3%" rowspan="2">NO.</th>
								<th width="12%" rowspan="2">NAMA PASIEN</th>
								<th colspan="2">UMUR</th>
								<th rowspan="2">NO.KARTU</th>
								<th rowspan="2">KUNJG</th>
								<th rowspan="2">ALAMAT RT/RW</th>
								<th colspan="2">BP</th>
								<th colspan="2">KIA</th>
								<th colspan="2">GIGI</th>
								<th colspan="2">MTBS</th>
								<th colspan="2">IMUNISASI</th>
								<th colspan="2">TB</th>
								<th colspan="2">KESWA</th>
								<th colspan="2">IGD</th>
							</tr>
							<tr style="border:1px solid #000;">
								<th width="4%">L</th>
								<th width="4%">P</th>
								<th>UMUM</th><!--bp-->
								<th>BPJS</th>
								<th>UMUM</th><!--kia-->
								<th>BPJS</th>
								<th>UMUM</th><!--gigi-->
								<th>BPJS</th>
								<th>UMUM</th><!--mtbs-->
								<th>BPJS</th>
								<th>UMUM</th><!--imunisasi-->
								<th>BPJS</th>
								<th>UMUM</th><!--tb-->
								<th>BPJS</th>
								<th>UMUM</th><!--keswa-->
								<th>BPJS</th>
								<th>UMUM</th><!--igd-->
								<th>BPJS</th>
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
								$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";			
								if ($asalpasien == 'semua_pasien'){
									$str = "SELECT * FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
								}else{
									$str = "SELECT * FROM `$tbpasienrj` WHERE ".$waktu." AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND AsalPasien='$asalpasien'";
								}	
								// echo $str;
							}else{
								$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
								$tbpasienrj2 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
								
								if ($asalpasien == 'semua_pasien'){
									$str = "SELECT * FROM(
									SELECT * FROM `$tbpasienrj`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
									UNION
									SELECT * FROM `$tbpasienrj2`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
									) tbalias";
								}else{
									$str = "SELECT * FROM(
									SELECT * FROM `$tbpasienrj`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu." and AsalPasien='$asalpasien'
									UNION
									SELECT * FROM `$tbpasienrj2`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu." and AsalPasien='$asalpasien'
									) tbalias";
								}
							}
							$str2 = $str." ORDER BY TanggalRegistrasi DESC, NamaPasien ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
								if($hariini != $data['TanggalRegistrasi']){
									echo "<tr style='border:1px dashed #7a7a7a; font-weight: bold;'><td colspan='23'>$data[TanggalRegistrasi]</td></tr>";
									$hariini = $data['TanggalRegistrasi'];
								}	
								$no = $no + 1;
								$noindex = $data['NoIndex'];
								$nocm = $data['NoCM'];
								$asuransi = $data['Asuransi'];
								$nomorasuransi = $data['nokartu'];
								
								// tbkk
								$strkk = "SELECT Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
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
								
								// tbpasien
								$strpasien = "SELECT NoRM FROM `tbpasien` WHERE `NoCM` = '$nocm'";
								$querypasien = mysqli_query($koneksi,$strpasien);
								$datapasien = mysqli_fetch_assoc($querypasien);
							?>
								<tr style="border:1px solid #000;">
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaPasien']);?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['JenisKelamin'] == "L"){
												if($data['UmurTahun'] != 0 || $data['UmurTahun'] == null){
													echo $data['UmurTahun']." Th";
												}elseif($data['UmurTahun'] == 0 && $data['UmurBulan'] != ""){
													echo $data['UmurBulan']." Bl";
												}else{
													echo $data['UmurHari']." Hr";
												}	
											}else{	
												echo "";
											}
										?>	
									</td>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['JenisKelamin'] == "P"){
												if($data['UmurTahun'] != 0 || $data['UmurTahun'] == null){
													echo $data['UmurTahun']." Th";
												}elseif($data['UmurTahun'] == 0 && $data['UmurBulan'] != ""){
													echo $data['UmurBulan']." Bl";
												}else{
													echo $data['UmurHari']." Hr";
												}	
											}else{	
												echo "";
											}
										?>	
									</td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($datapasien['NoRM'],-6);?></td>
									<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['StatusKunjungan']);?></td>
									<td style="text-align:left; border:1px solid #000; padding:3px;">
										<?php 
											if ($noindex == ''){
												echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
											}else{
												echo $alamat;
											}
										?>
									</td>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											// poli umum
											if($data['PoliPertama'] == "POLI UMUM" AND $data['Asuransi'] == "UMUM"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['PoliPertama'] == "POLI UMUM" AND substr($data['Asuransi'],0,4) == "BPJS"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											// poli kia
											if(($data['PoliPertama'] == "POLI KIA" OR $data['PoliPertama'] == "POLI KB") AND $data['Asuransi'] == "UMUM"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if(($data['PoliPertama'] == "POLI KIA" OR $data['PoliPertama'] == "POLI KB") AND substr($data['Asuransi'],0,4) == "BPJS"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											// poli gigi
											if($data['PoliPertama'] == "POLI GIGI" AND $data['Asuransi'] == "UMUM"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['PoliPertama'] == "POLI GIGI" AND substr($data['Asuransi'],0,4) == "BPJS"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											// poli mtbs
											if($data['PoliPertama'] == "POLI MTBS" AND $data['Asuransi'] == "UMUM"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['PoliPertama'] == "POLI MTBS" AND substr($data['Asuransi'],0,4) == "BPJS"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											// poli imunisasi
											if($data['PoliPertama'] == "POLI IMUNISASI" AND $data['Asuransi'] == "UMUM"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['PoliPertama'] == "POLI IMUNISASI" AND substr($data['Asuransi'],0,4) == "BPJS"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td><td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											// poli tb
											if($data['PoliPertama'] == "POLI TB" AND $data['Asuransi'] == "UMUM"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['PoliPertama'] == "POLI TB" AND substr($data['Asuransi'],0,4) == "BPJS"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>
									</td><td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											// poli keswa
											if($data['PoliPertama'] == "POLI KESWA" AND $data['Asuransi'] == "UMUM"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['PoliPertama'] == "POLI KESWA" AND substr($data['Asuransi'],0,4) == "BPJS"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td></td><td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											// poli igd
											if($data['PoliPertama'] == "POLI UGD" AND $data['Asuransi'] == "UMUM"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>	
									<td style="text-align:center; border:1px solid #000; padding:3px;">
										<?php 
											if($data['PoliPertama'] == "POLI UGD" AND substr($data['Asuransi'],0,4) == "BPJS"){
												echo '<span class="fa fa-check"></span>';
											}else{
												echo "";
											}	
										?>
									</td>
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
						echo "<li><a href='?page=lap_loket_registrasi_kunjungan_garutkab&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&asalpasien=$asalpasien&h=$i'>$i</a></li>";
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
					Print laporan silahkan klik tombol Export
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