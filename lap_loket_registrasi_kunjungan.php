<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>Register Kunjungan Pasien</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_registrasi_kunjungan"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-4 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:170px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:170px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
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
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="asalpasien" class="form-control asuransi">
								<option value='semua_pasien'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbasalpasien` order by `AsalPasien` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['asalpasien'] == $data['AsalPasien']){
											echo "<option value='$data[Id]' SELECTED>$data[AsalPasien]</option>";
										}else{
											echo "<option value='$data[Id]'>$data[AsalPasien]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_registrasi_kunjungan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_registrasi_kunjungan_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&asalpasien=<?php echo $_GET['asalpasien'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
				<div class="table-responsive font10">
					<table class="table-judul-laporan" width="100%">
						<thead>
							<tr style="border:1px solid #000;">
								<th width="3%" rowspan="2">NO.</th>
								<th width="6%" rowspan="2">TANGGAL</th>
								<th width="5%" rowspan="2">NIK</th>
								<th width="8%" rowspan="2">NAMA PASIEN</th>
								<th width="2%" rowspan="2">L/P</th>
								<th width="3%" rowspan="2">UMUR</th>
								<th width="12%" rowspan="2">ALAMAT</th>
								<th width="4%" rowspan="2">PELAYANAN</th>
								<th colspan="2" >CARA BAYAR</th>
								<th width="3%" rowspan="2">KUNJ.</th>
								<th width="3%" rowspan="2">TARIF</th>
								<th width="5%" rowspan="2">KET.</th>
							</tr>
							<tr style="border:1px solid #000;">
								<th width="5%">CARA BAYAR</th>
								<th width="5%">NOMOR</th>
							</tr>
						</thead>
						<tbody style="font-size:12px;">
							<?php
							$jumlah_perpage = 50;
							
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
								$waktu = "date(`TanggalRegistrasi`) BETWEEN '$keydate1' AND '$keydate2'";
								
								if ($asalpasien == 'semua_pasien'){
									$str = "SELECT * FROM(
									SELECT * FROM `$tbpasienrj`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
									UNION
									SELECT * FROM `$tbpasienrj`
									WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND ".$waktu."
									) tbalias";
								}else{
									$str = "SELECT * FROM(
									SELECT * FROM `$tbpasienrj`
									WHERE ".$waktu." and AsalPasien='$asalpasien'
									UNION
									SELECT * FROM `$tbpasienrj`
									WHERE ".$waktu." and AsalPasien='$asalpasien'
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
								$idpasien = $data['IdPasien'];
								$noindex = $data['NoIndex'];
								$nocm = $data['NoCM'];
								$asuransi = $data['Asuransi'];
								$nomorasuransi = $data['nokartu'];
								
								// tbpasien
								$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Nik` FROM `$tbpasien` WHERE IdPasien = '$idpasien'"));
																				
								// tbkk
								$strkk = "SELECT `Alamat`, `RT`, `No`, `Kelurahan`, `Kecamatan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
								$querykk = mysqli_query($koneksi,$strkk);
								$datakk = mysqli_fetch_assoc($querykk);

								// ec_subdistricts
								$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
								if($dt_subdis['subdis_name'] != ''){
									$kelurahan = $dt_subdis['subdis_name'];
								}else{
									$kelurahan = $datakk['Kelurahan'];
								}

								// ec_districts
								$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
								if($dt_dis['dis_name'] != ''){
									$kecamatan = $dt_dis['dis_name'];
								}else{
									$kecamatan = $datakk['Kecamatan'];
								}

								$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
								strtoupper($kelurahan).", ".strtoupper($kecamatan);
								
								if($asuransi == 'BPJS PBI' || $asuransi == 'BPJS NON PBI' || $asuransi == 'KIS'){
									$noasuransi = $nomorasuransi;
								}else{
									$noasuransi = "0";
								}
							?>
								<tr style="border:1px solid #000;">
									<td align="center"><?php echo $no;?></td>
									<td align="center"><?php echo date('d-m-Y G:i:s', strtotime($data['TanggalRegistrasi']));?></td>
									<td align="left"><?php echo $dtpasien['Nik'];?></td>
									<td align="left"><?php echo strtoupper($data['NamaPasien']);?></td>
									<td align="center"><?php echo $data['JenisKelamin'];?></td>
									<td align="center">
										<?php 
											if($data['UmurTahun'] != 0 || $data['UmurTahun'] == null){
												echo $data['UmurTahun']." Th";
											}elseif($data['UmurTahun'] == 0 && $data['UmurBulan'] != ""){
												echo $data['UmurBulan']." Bl";
											}else{
												echo $data['UmurHari']." Hr";
											}	
										?>
									</td>
									<td align="left">
										<?php 
											if ($noindex == ''){
												echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
											}else{
												echo strtoupper($alamat);
											}
										?>
									</td>
									<td align="left"><?php echo str_replace('POLI','',$data['PoliPertama']);?></td>
									<td align="left"><?php echo $data['Asuransi'];?></td>
									<td align="center"><?php echo $noasuransi;?></td>
									<td align="center"><?php echo strtoupper($data['StatusKunjungan']);?></td>	
									<td align="right"><?php echo rupiah($data['TarifKarcis']);?></td>		
									<td align="center">
										<?php 
											if($data['AsalPasien'] == "1"){
												echo "KELAS BALITA";
											}elseif($data['AsalPasien'] == "2"){
												echo "KELAS IBU";
											}elseif($data['AsalPasien'] == "3"){
												echo "PENYULUHAN KELOMPOK";
											}elseif($data['AsalPasien'] == "4"){
												echo "PENYULUHAN KELUARGA";
											}elseif($data['AsalPasien'] == "5"){
												echo "POLINDES";
											}elseif($data['AsalPasien'] == "6"){
												echo "POSBINDU";
											}elseif($data['AsalPasien'] == "7"){
												echo "POSKESDES";
											}elseif($data['AsalPasien'] == "8"){
												echo "POSYANDU";
											}elseif($data['AsalPasien'] == "9"){
												echo "PUSKEL";
											}elseif($data['AsalPasien'] == "10"){
												echo "PUSKESMAS";
											}elseif($data['AsalPasien'] == "11"){
												echo "PUSTU";
											}elseif($data['AsalPasien'] == "12"){
												echo "STBM";
											}elseif($data['AsalPasien'] == "13"){
												echo "PERKESMAS";
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
						echo "<li><a href='?page=lap_loket_registrasi_kunjungan&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&asalpasien=$asalpasien&h=$i'>$i</a></li>";
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