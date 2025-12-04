<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PELAYANAN KESEHATAN GIGI & MULUT</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gigi_bulanan"/>
						<div class="col-sm-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</SELECT>	
						</div>
						<div class="col-sm-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" value="<?php echo $_GET['keydate1'];?>" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> 
								<input type="text" name="keydate2" value="<?php echo $_GET['keydate2'];?>" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
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
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-sm-2">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gigi_bulanan" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
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
	if($bulan != null AND $tahun != null){
	?>

	<!--data registrasi-->
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PELAYANAN KESEHATAN GIGI & MULUT</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span><br/>
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
			<table style="font-size:10px; width:300px;">
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

	<!--tabel view-->
	<div class="row font10">
		<div class="col-lg-12">
			<div class="table-responsive font10">
				<table class="table-judul-laporan-min" width="100%">
					<thead style="font-size:10px;">
						<tr>
							<th rowspan="2" style="text-align:center;width:5%;vertical-align:middle;border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" style="text-align:center;width:40%;vertical-align:middle;border:1px solid #000; padding:3px;">Kegiatan</th>
							<th rowspan="2" style="text-align:center;width:8%;vertical-align:middle;border:1px solid #000; padding:3px;">Satuan</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">Dalam Wilayah</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">Luar Wilayah</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">Jumlah</th>
							<th rowspan="2" style="text-align:center;width:6%;vertical-align:middle;border:1px solid #000; padding:3px;">Total</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">L</th><!--Dalam Wilayah-->
							<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">L</th><!--Luar Wilayah-->
							<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">L</th><!--Jumlah-->
							<th style="text-align:center;width:5%; border:1px solid #000; padding:3px;">P</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						// $a_l_dw_l_1 = 0;
						// $a_l_dw_l_2 = 0;
						// $a_l_dw_l = 0;
						// $a_p_dw_p_1 = 0;
						// $a_p_dw_p_2 = 0;
						// $a_p_dw_p = 0;
						// $a_l_lw_l_1 = 0;
						// $a_l_lw_l_2 = 0;
						// $a_l_lw_l = 0;
						// $a_p_lw_p_1 = 0;
						// $a_p_lw_p_2 = 0;
						// $a_p_lw_p = 0;
						$a_l_dw = 0;
						$a_p_dw = 0;
						$a_l_lw = 0;
						$a_p_lw = 0;
						$a_l_jml = 0;
						$a_p_jml = 0;
						$a_ttl = 0;
						
						$str = "SELECT * FROM `tbkegiatangigi` ORDER BY `KodeKelompok`, `KodeKegiatan`";
						$query = mysqli_query($koneksi,$str);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
											
						if($data['KodeKegiatan'] == '01'){
							echo "<tr style='border:1px solid #000;'><td style='text-align:center; border:1px solid #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='9' style='text-align:left; font-weight:bold; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
						}
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $data['KodeKegiatan'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Kegiatan'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<?php
								if($opsiform == 'bulan'){
									$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
									$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
									// echo $tbpasienrj;
									
									if ($data['Kegiatan'] == 'Jumlah Penduduk Wilayah Kerja Puskesmas'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi ke Puskesmas'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='BARU' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='BARU' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='BARU' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='BARU' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi ke Puskesmas'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='LAMA' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='LAMA' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='LAMA' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='LAMA' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi Luar Gedung (UKGS+UKGMD)'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi Luar Gedung (UKGS+UKGMD)'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}elseif ($data['Kegiatan'] == 'Jumlah Bumil di Wilayah Kerja Puskesmas'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi Bumil'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi Bumil'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Anak Prasekolah di Wilayah Kerja Puskesmas'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi Anak Prasekolah'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi Anak Prasekolah'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi Anak SD/MI'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi Anak SD/MI'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}elseif ($data['KlasifikasiDetail'] == 'K02'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'K04'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'K05'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'K08'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'K09'){
										$a_l_dw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_l_lw_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi join `$tbpoligigi` c on a.NoRegistrasi = c.NoPemeriksaan join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_l['Jml'];
										$a_p_dw = $a_p_dw_p['Jml'];
										$a_l_lw = $a_l_lw_l['Jml'];
										$a_p_lw = $a_p_lw_p['Jml'];
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'TUMPATAN GIGI TETAP'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENCABUTAN GIGI TETAP'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'TUMPATAN GIGI SULUNG'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENCABUTAN GIGI SULUNG'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENGOBATAN PULPA'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENGOBATAN PERIODONTAL'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PEMBERSIHAN KARANG GIGI'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'JUMLAH RUJUKAN'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENGOBATAN LAIN-LAIN'){
										$a_l_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_p_dw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_l_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_p_lw_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_l_dw = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'];
										$a_p_dw = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'];
										$a_l_lw = $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_lw = $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_l_jml = $a_l_dw_1['Jml'] + $a_l_dw_2['Jml'] + $a_l_lw_1['Jml'] + $a_l_lw_2['Jml'];
										$a_p_jml = $a_p_dw_1['Jml'] + $a_p_dw_2['Jml'] + $a_p_lw_1['Jml'] + $a_p_lw_2['Jml'];
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'Jumlah SD/MI di Wlayah Kerja Puskesmas'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}
								}else{
									$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
									$waktu2 = "TanggalRegistrasi <= '$keydate2'";
									$tbpasienrj_1 = 'tbpasienrj_'.date('m',strtotime($keydate1));
									$tbpasienrj_2 = 'tbpasienrj_'.date('m',strtotime($keydate2));
									$tbdiagnosapasien_1 = 'tbdiagnosapasien_'.date('m',strtotime($keydate1));
									$tbdiagnosapasien_2 = 'tbdiagnosapasien_'.date('m',strtotime($keydate2));
									
									if ($data['Kegiatan'] == 'Jumlah Penduduk Wilayah Kerja Puskesmas'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										// echo "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'";
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi ke Puskesmas'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='BARU' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='BARU' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='BARU' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='BARU' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='BARU' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='BARU' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='BARU' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='BARU' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi ke Puskesmas'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='LAMA' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='LAMA' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='LAMA' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='LAMA' and b.Wilayah = 'DALAM' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='LAMA' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='L' and a.StatusKunjungan='LAMA' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_1` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='LAMA' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpasienrj_2` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.JenisKelamin='P' and a.StatusKunjungan='LAMA' and b.Wilayah = 'LUAR' AND a.PoliPertama = 'POLI GIGI'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi Luar Gedung (UKGS+UKGMD)'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi Luar Gedung (UKGS+UKGMD)'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}elseif ($data['Kegiatan'] == 'Jumlah Bumil di Wilayah Kerja Puskesmas'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi Bumil'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi Bumil'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'IBU HAMIL' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Anak Prasekolah di Wilayah Kerja Puskesmas'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi Anak Prasekolah'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='BARU' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi Anak Prasekolah'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbkk` c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KunjunganGigi = 'ANAK PRASEKOLAH' and b.StatusKunjungan='LAMA' and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Baru Rawat Jalan Gigi Anak SD/MI'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}elseif ($data['Kegiatan'] == 'Jumlah Kunjungan Lama Rawat Jalan Gigi Anak SD/MI'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}elseif ($data['KlasifikasiDetail'] == 'K02'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K02%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'K04'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K04%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'K05'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K05%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'K08'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K08%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'K09'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='L' and d.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='P' and d.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='L' and d.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_1` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbdiagnosapasien_2` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join `$tbpoligigi` c on a.NoPemeriksaan = c.NoRegistrasi join tbkk d on c.NoIndex = d.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and a.KodeDiagnosa like '%K09%' and b.JenisKelamin='P' and d.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'TUMPATAN GIGI TETAP'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI TETAP%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI TETAP%') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENCABUTAN GIGI TETAP'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP' OR a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP' OR a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP' OR a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP' OR a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP' OR a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP' OR a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP' OR a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI TETAP' OR a.TindakLanjut2 = 'PENCABUTAN GIGI TETAP') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'TUMPATAN GIGI SULUNG'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN GIGI SULUNG%' OR a.TindakLanjut2 like 'PENAMBALAN GIGI SULUNG%') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENCABUTAN GIGI SULUNG'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG' OR a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG' OR a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG' OR a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG' OR a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG' OR a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG' OR a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG' OR a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENCABUTAN GIGI SULUNG' OR a.TindakLanjut2 = 'PENCABUTAN GIGI SULUNG') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENGOBATAN PULPA'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA' or a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA' or a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA' or a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA' or a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA' or a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA' or a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA' or a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut1 = 'PENGOBATAN PULPA' or a.TindakLanjut2 like 'PENAMBALAN SEMENTARA%' or a.TindakLanjut2 = 'PENGOBATAN PULPA') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENGOBATAN PERIODONTAL'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI' or a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI' or a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI' or a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI' or a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI' or a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI' or a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI' or a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut1 = 'PREMEDIKASI' or a.TindakLanjut2 = 'PENGOBATAN PERIODONTAL' or a.TindakLanjut2 = 'PREMEDIKASI') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PEMBERSIHAN KARANG GIGI'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING' OR a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING' OR a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING' OR a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING' OR a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING' OR a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING' OR a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING' OR a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'SCALLING' OR a.TindakLanjut2 = 'SCALLING') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'JUMLAH RUJUKAN'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK' OR a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK' OR a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK' OR a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK' OR a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK' OR a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK' OR a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK' OR a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'RUJUK' OR a.TindakLanjut2 = 'RUJUK') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'PENGOBATAN LAIN-LAIN'){
										$a_l_dw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA' OR a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA' OR a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='L' and c.Wilayah = 'DALAM'"));
										$a_l_dw_l = $a_l_dw_l_1['Jml'] + $a_l_dw_l_2['Jml'];
										$a_p_dw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA' OR a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA' OR a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='P' and c.Wilayah = 'DALAM'"));
										$a_p_dw_p = $a_p_dw_p_1['Jml'] + $a_p_dw_p_2['Jml'];
										$a_l_lw_l_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA' OR a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA' OR a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='L' and c.Wilayah = 'LUAR'"));
										$a_l_lw_l = $a_l_lw_l_1['Jml'] + $a_l_lw_l_2['Jml'];
										$a_p_lw_p_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_1` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA' OR a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan)AS Jml FROM `$tbpoligigi` a join `$tbpasienrj_2` b on a.NoPemeriksaan = b.NoRegistrasi join tbkk c on a.NoIndex = c.NoIndex WHERE $waktu and SUBSTRING(a.NoPemeriksaan,1,11)='$kodepuskesmas' and (a.TindakLanjut1 = 'LAINNYA' OR a.TindakLanjut2 = 'LAINNYA') and b.JenisKelamin='P' and c.Wilayah = 'LUAR'"));
										$a_p_lw_p = $a_p_lw_p_1['Jml'] + $a_p_lw_p_2['Jml'];
										$a_l_dw = $a_l_dw_l;
										$a_p_dw = $a_p_dw_p;
										$a_l_lw = $a_l_lw_l;
										$a_p_lw = $a_p_lw_p;
										$a_l_jml = $a_l_dw + $a_l_lw;
										$a_p_jml = $a_p_dw + $a_p_lw;
										$a_ttl = $a_l_jml + $a_p_jml;
									}elseif ($data['KlasifikasiDetail'] == 'Jumlah SD/MI di Wlayah Kerja Puskesmas'){
										$a_l_dw = 0;
										$a_p_dw = 0;
										$a_l_lw = 0;
										$a_p_lw = 0;
										$a_l_jml = 0;
										$a_p_jml = 0;
										$a_ttl = 0;
									}
								}
							?>

							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $a_l_dw;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $a_p_dw;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $a_l_lw;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $a_p_lw;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $a_l_jml;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $a_p_jml;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $a_ttl;?></td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="bawahtabel">
				<table width="100%">
					<tr>
						<td width="5%"></td>
						<td style="text-align:center;">
							MENGETAHUI<br>
							<?php echo "KEPALA UPT ".$datapuskesmas['NamaPuskesmas'];?>
							<br><br><br><br>
							<u><?php echo $datapuskesmas['KepalaPuskesmas'];?></u><br>
							<?php echo "NIP.".$datapuskesmas['Nip'];?>
						</td>
						<td width="10%"></td>
						<td style="text-align:center;">
							<?php echo $kota.", ___ ".strtoupper(nama_bulan($bulan))." ".$tahun;?><br>
							PELAKSANA PROGRAM
							<br><br><br><br>
							(..........................................................)
						</td>
					</tr>
				</table>
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
	if($('.opsiform').val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>
