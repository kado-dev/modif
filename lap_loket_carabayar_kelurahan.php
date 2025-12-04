<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>CARA BAYAR (DESA / KELURAHAN)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_carabayar_kelurahan"/>
						<div class="col-xl-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tahun" <?php if($_GET['opsiform'] == 'tahun'){echo "SELECTED";}?>>Tahun</option>
							</SELECT>	
						</div>
						<div class="col-xl-2 bulanformcari" >
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
						<div class="col-xl-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="asalpasien" class="form-control asuransi">
								<option value='semua'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbasalpasien` order by `AsalPasien` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['asalpasien'] == $data['Id']){
											echo "<option value='$data[Id]' SELECTED>$data[AsalPasien]</option>";
										}else{
											echo "<option value='$data[Id]'>$data[AsalPasien]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-xl-2">
							<SELECT name="statuspasien" class="form-control">
								<option value="semua">Semua</option>
								<option value="1" <?php if($_GET['statuspasien'] == '1'){echo "SELECTED";}?>>Kunjungan Sakit</option>
								<option value="2" <?php if($_GET['statuspasien'] == '2'){echo "SELECTED";}?>>Kunjungan Sehat</option>
							</SELECT>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_carabayar_kelurahan" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
		$opsiform = $_GET['opsiform'];
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$asalpasien = $_GET['asalpasien'];
		$statuspasien = $_GET['statuspasien'];
				
		if($bulan != null AND $tahun != null){
	?>

	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN CARA BAYAR PASIEN (KELURAHAN/DESA)</b></span><br>
			<?php if($opsiform == 'bulan'){ ?>
				<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
			<?php }else{ ?>
				<span class="font11" style="margin:1px;">Periode Laporan: <?php echo "Tahun ".$_GET['tahun'];?></span>
			<?php } ?>
			<br/>
		</div>

		<div class="atastabel font11">
			<div style="float:left; width:35%; margin-bottom:10px;">	
				<table>
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
				<div class="table-responsive font10">
					<table class="table-judul-laporan">
						<thead style="font-size:10px;">
							<tr style="border:1px solid #000;">
								<th width="2%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
								<th width="20%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Kelurahan / Desa</th>
								<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Umum</th>
								<th width="5%" colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">BPJS</th>
								<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Gratis</th>
								<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">SKTM</th>
							</tr>
							<tr style="border:1px solid #000;">
								<th width="5%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">PBI</th>
								<th width="5%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NON PBI</th>
							</tr>
						</thead>
						<tbody style="font-size:10px;">
							<?php
							$no = 0;
							$umum_total=0;
							$bpjs_pbi_total=0;
							$bpjs_nonpbi_total=0;
							$bpjs_gratis_total=0;
							$bpjs_sktm_total=0;
							$str_puskesmas = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' ORDER BY Kelurahan";
							$query = mysqli_query($koneksi,$str_puskesmas);
							while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kelurahan = $data['Kelurahan'];
							
							if ($asalpasien == 'semua'){
								$aslpsn = " ";
								$aslpsn2 = " ";
							}else{
								$aslpsn = " AND a.`AsalPasien` = '$asalpasien'";
								$aslpsn2 = " AND `AsalPasien` = '$asalpasien'";
							}
							
							if ($statuspasien == 'semua'){
								$stspsn = " ";
								$stspsn2 = " ";
							}else{
								$stspsn = " AND a.`StatusPasien` = '$statuspasien'";
								$stspsn2 = " AND `StatusPasien` = '$statuspasien'";
							}
							
							if ($opsiform == 'bulan'){
								$umum = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND  a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
							}else{
								$umum1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$umum = $umum1['Jml'] + $umum2['Jml'] + $umum3['Jml'] + $umum4['Jml'] + $umum5['Jml'] + $umum6['Jml'] + $umum7['Jml'] + $umum8['Jml'] + $umum9['Jml'] + $umum10['Jml'] + $umum11['Jml'] + $umum12['Jml'];
							
								$bpjs_pbi1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` like '%BPJS PBI%' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_pbi = $bpjs_pbi1['Jml'] + $bpjs_pbi2['Jml'] + $bpjs_pbi['Jml'] + $bpjs_pbi4['Jml'] + $bpjs_pbi5['Jml'] + $bpjs_pbi6['Jml'] + $bpjs_pbi7['Jml'] + $bpjs_pbi8['Jml'] + $bpjs_pbi9['Jml'] + $bpjs_pbi10['Jml'] + $bpjs_pbi11['Jml'] + $bpjs_pbi12['Jml'];
								
								$bpjs_nonpbi1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi0 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_nonpbi = $bpjs_nonpbi1['Jml'] + $bpjs_nonpbi2['Jml'] + $bpjs_nonpbi3['Jml'] + $bpjs_nonpbi4['Jml'] + $bpjs_nonpbi5['Jml'] + $bpjs_nonpbi6['Jml'] + $bpjs_nonpbi7['Jml'] + $bpjs_nonpbi8['Jml'] + $bpjs_nonpbi9['Jml'] + $bpjs_nonpbi10['Jml'] + $bpjs_nonpbi11['Jml'] + $bpjs_nonpbi12['Jml'];
								
								$bpjs_gratis1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_gratis = $bpjs_gratis1['Jml'] + $bpjs_gratis2['Jml'] + $bpjs_gratis3['Jml'] + $bpjs_gratis4['Jml'] + $bpjs_gratis5['Jml'] + $bpjs_gratis6['Jml'] + $bpjs_gratis7['Jml'] + $bpjs_gratis8['Jml'] + $bpjs_gratis9['Jml'] + $bpjs_gratis10['Jml'] + $bpjs_gratis11['Jml'] + $bpjs_gratis12['Jml'];
								
								$bpjs_sktm1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan'  AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoRegistrasi`) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND a.`Asuransi` = 'SKTM' AND b.Kelurahan = '$kelurahan'".$aslpsn.$stspsn));
								$bpjs_sktm = $bpjs_sktm1['Jml'] + $bpjs_sktm2['Jml'] + $bpjs_sktm3['Jml'] + $bpjs_sktm4['Jml'] + $bpjs_sktm5['Jml'] + $bpjs_sktm6['Jml'] + $bpjs_sktm7['Jml'] + $bpjs_sktm8['Jml'] + $bpjs_sktm9['Jml'] + $bpjs_sktm10['Jml'] + $bpjs_sktm11['Jml'] + $bpjs_sktm12['Jml'];
							}
								
							// menghitung per jenis cara bayar
							?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kelurahan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umum;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_nonpbi;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_gratis;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_sktm;?></td>		
							</tr>
							<?php
							$umum_total = $umum_total + $umum;
							$bpjs_pbi_total = $bpjs_pbi_total + $bpjs_pbi;
							$bpjs_nonpbi_total = $bpjs_nonpbi_total + $bpjs_nonpbi;
							$bpjs_gratis_total = $bpjs_gratis_total + $bpjs_gratis;
							$bpjs_sktm_total = $bpjs_sktm_total + $bpjs_sktm;
							}
							
							// menghitung luar wilayah
							$totalumum = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND `Asuransi` = 'UMUM'".$aslpsn2.$stspsn2));
							$totalbpjs_pbi = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND `Asuransi` = 'BPJS PBI'".$aslpsn2.$stspsn2));
							$totalbpjs_nonpbi = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND `Asuransi` = 'BPJS NON PBI'".$aslpsn2.$stspsn2));
							$totalbpjs_gratis = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND `Asuransi` = 'GRATIS'".$aslpsn2.$stspsn2));
							$totalbpjs_sktm = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND `Asuransi` = 'SKTM'".$aslpsn2.$stspsn2));
							?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;" colspan="2">Total</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umum_total;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi_total;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_nonpbi_total;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_gratis_total;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_sktm_total;?></td>		
							</tr>
							
							<?php
							
							$umum_lw = $totalumum - $umum_total;
							$bpjs_pbi_lw = $totalbpjs_pbi - $bpjs_pbi_total;
							$bpjs_nonpbi_lw = $totalbpjs_nonpbi - $bpjs_nonpbi_total;
							$bpjs_gratis_lw = $totalbpjs_gratis - $bpjs_gratis_total;
							$bpjs_sktm_lw = $totalbpjs_sktm - $bpjs_sktm_total;
							?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">Luar Wilayah</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umum_lw;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi_lw;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_nonpbi_lw;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_gratis_lw;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_sktm_lw;?></td>		
							</tr>
							
							
						
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;" colspan="2">Total Keseluruhan</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $totalumum;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $totalbpjs_pbi;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $totalbpjs_nonpbi;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $totalbpjs_gratis;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $totalbpjs_sktm;?></td>		
							</tr>
						</tbody>
					</table>
				</div>
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