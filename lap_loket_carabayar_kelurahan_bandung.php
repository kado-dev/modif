<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>CARA BAYAR (DESA/KELURAHAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_loket_carabayar_kelurahan_bandung"/>
						<div class="col-sm-2" >
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
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="asalpasien" class="form-control">
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
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_registrasi_kunjungan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$asalpasien = $_GET['asalpasien'];

	if($bulan != null AND $tahun != null){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:2px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN CARA BAYAR PASIEN (KELURAHAN/DESA)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
			</table><p/>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Kelurahan/Desa</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Kecamatan</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
				</tr>
			</table>
		</div>	
	</div>

	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="2%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th width="20%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Kelurahan / Desa</th>
							<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Umum</th>
							<th width="5%" colspan="3" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">BPJS</th>
							<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Gratis</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="5%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">PBI APBD</th>
							<th width="5%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">PBI APBN</th>
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
						$tbpasienrj = 'tbpasienrj_'.$bulan;
						$str_puskesmas = "SELECT * FROM `tbkelurahan` WHERE (`KodePuskesmas` = '$kodepuskesmas' OR `KodePuskesmas` = '*')";
						$query = mysqli_query($koneksi,$str_puskesmas);
						while($data = mysqli_fetch_array($query)){
						$no = $no + 1;
						$kelurahan = $data['Kelurahan'];
											
						// echo "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalRegistrasi) = '$bulan' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.`Asuransi` = 'UMUM' AND
						// (b.Kelurahan = '$kelurahan1' AND b.Kelurahan = '$kelurahan1')";					
											
						if ($asalpasien == 'semua'){
							$aslpsn = " ";
						}else{
							$aslpsn = " AND a.`AsalPasien` = '$asalpasien'";
						}
						
						$umum = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalRegistrasi) = '$bulan' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.`Asuransi` = 'UMUM' AND b.Kelurahan = '$kelurahan'".$aslpsn));
						$bpjs_pbi_apbd = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalRegistrasi) = '$bulan' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.`Asuransi` = 'BPJS PBI APBD' AND b.Kelurahan = '$kelurahan'".$aslpsn));
						$bpjs_pbi_apbn = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalRegistrasi) = '$bulan' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.`Asuransi` = 'BPJS PBI APBN' AND b.Kelurahan = '$kelurahan'".$aslpsn));
						$bpjs_nonpbi = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalRegistrasi) = '$bulan' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.`Asuransi` = 'BPJS NON PBI' AND b.Kelurahan = '$kelurahan'".$aslpsn));
						$bpjs_gratis = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoRegistrasi` FROM `$tbpasienrj` a LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalRegistrasi) = '$bulan' AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.`Asuransi` = 'GRATIS' AND b.Kelurahan = '$kelurahan'".$aslpsn));
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kelurahan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umum;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi_apbd;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi_apbn;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_nonpbi;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_gratis;?></td>		
							</tr>
						<?php
							$umum_total = $umum_total + $umum;
							$bpjs_pbi_apbd_total = $bpjs_pbi_apbd_total + $bpjs_pbi_apbd;
							$bpjs_pbi_apbn_total = $bpjs_pbi_apbn_total + $bpjs_pbi_apbn;
							$bpjs_nonpbi_total = $bpjs_nonpbi_total + $bpjs_nonpbi;
							$bpjs_gratis_total = $bpjs_gratis_total + $bpjs_gratis;
							}
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:center; border:1px solid #000; padding:3px;" colspan="2">Total</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umum_total;?></td>		
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi_apbd_total;?></td>		
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi_apbn_total;?></td>		
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_nonpbi_total;?></td>		
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_gratis_total;?></td>	
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	