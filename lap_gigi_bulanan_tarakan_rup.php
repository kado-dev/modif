<?php
	session_start();
	include "otoritas.php";
	include "config/helper_pasienrj.php";?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>CARA BAYAR</b></h3>
			<div class="formbg">
				<form role="form">	
					<div class = "row">
						<input type="hidden" name="page" value="lap_gigi_bulanan_tarakan_rup"/>
						<div class="col-xl-2">
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
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gigi_bulanan_tarakan_rup" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_gigi_bulanan_tarakan_rup_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN CARA BAYAR</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive" width="100%">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="5" width="3%">TGL</th>
							<th rowspan="5" width="3%">TOTAL</th>
							<th rowspan="5" width="3%">TOTAL MANUAL</th>
							<th colspan="16" width="20%">KELOMPOK UMUR</th>
							<th colspan="22" width="30%">TINDAKAN</th>
							<th colspan="3" width="6%">RUJUKAN</th>
						</tr>
						<tr>
							<th colspan="4">BAYI-BALITA</th>
							<th colspan="4">APRAS</th>
							<th colspan="4">ANAK SEKOLAH</th>
							<th colspan="4">UMUM</th>
							<th colspan="10">GIGI SUSU</th>
							<th colspan="10">GIGI TETAP</th>
							<th rowspan="4">SCLG</th>
							<th rowspan="4">PREMED</th>
							<th colspan="2">INTERNAL</th>
							<th>EKSTERNAL</th>
						</tr>
						<tr>
							<th colspan="2">BARU</th><!--bayi balita-->
							<th colspan="2">LAMA</th>
							<th colspan="2">BARU</th><!--apras-->
							<th colspan="2">LAMA</th>
							<th colspan="2">BARU</th><!--anak sekolah-->
							<th colspan="2">LAMA</th>
							<th colspan="2">BARU</th><!--umum-->
							<th colspan="2">LAMA</th>
							<th colspan="2" rowspan="2">LCR</th><!--gigi susu-->
							<th colspan="2" rowspan="2">GIC</th>
							<th colspan="2" rowspan="2">TS</th>
							<th colspan="4">EXO</th>
							<th colspan="2" rowspan="2">LCR</th><!--gigi tetap-->
							<th colspan="2" rowspan="2">GIC</th>
							<th colspan="2" rowspan="2">TS</th>
							<th colspan="4">EXO</th>
							<th rowspan="3">DARI</th><!--rujukan-->
							<th rowspan="3">KE</th>
							<th rowspan="3">RS</th>
						</tr>
						<tr>
							<th rowspan="2">L</th><!--bayi balita-->
							<th rowspan="2">P</th>
							<th rowspan="2">L</th>
							<th rowspan="2">P</th>
							<th rowspan="2">L</th><!--apras-->
							<th rowspan="2">P</th>
							<th rowspan="2">L</th>
							<th rowspan="2">P</th>
							<th rowspan="2">L</th><!--anak sekolah-->
							<th rowspan="2">P</th>
							<th rowspan="2">L</th>
							<th rowspan="2">P</th>
							<th rowspan="2">L</th><!--umum-->
							<th rowspan="2">P</th>
							<th rowspan="2">L</th>
							<th rowspan="2">P</th>
							<th colspan="2">DALAM</th><!--gigi susu lcr-->
							<th colspan="2">LUAR</th>
							<th colspan="2">DALAM</th><!--gigi tetap lcr-->
							<th colspan="2">LUAR</th>
						</tr>
						<tr>
							<th>L</th><!--gigi susu lcr-->
							<th>P</th>
							<th>L</th><!--gigi susu gic-->
							<th>P</th>
							<th>L</th><!--gigi susu ts-->
							<th>P</th>
							<th>L</th><!--gigi susu exo dalam-->
							<th>P</th>
							<th>L</th><!--gigi susu exo luar-->
							<th>P</th>
							<th>L</th><!--gigi tetap lcr-->
							<th>P</th>
							<th>L</th><!--gigi tetap gic-->
							<th>P</th>
							<th>L</th><!--gigi tetap ts-->
							<th>P</th>
							<th>L</th><!--gigi tetap exo dalam-->
							<th>P</th>
							<th>L</th><!--gigi tetap exo luar-->
							<th>P</th>
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
						<?php
						$tgl1 = $tahun.'-'.$bulan.'-01';
						$tgl2 = date('Y-m-t', strtotime($tgl1));
						$begin = new DateTime( $tgl1 );
						$end   = new DateTime( $tgl2 );
						for($i = $begin; $i <= $end; $i->modify('+1 day')){
							$tgl = $i->format("Y-m-d");			
							
							// jumlah
							$jumlah_kunjungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl'"));
							$total = $jumlah_kunjungan ;
							
							// bayi balita
							$bb_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'IBU HAMIL' AND `StatusKunjungan` = 'Baru' AND `JenisKelamin` = 'L'"));
							$bb_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'IBU HAMIL' AND `StatusKunjungan` = 'Baru' AND `JenisKelamin` = 'P'"));
							$bb_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'IBU HAMIL' AND `StatusKunjungan` = 'Lama' AND `JenisKelamin` = 'L'"));
							$bb_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'IBU HAMIL' AND `StatusKunjungan` = 'Lama' AND `JenisKelamin` = 'P'"));
							// bayi aspras
							$aspras_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'ANAK PRASEKOLAH' AND `StatusKunjungan` = 'Baru' AND `JenisKelamin` = 'L'"));
							$aspras_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'ANAK PRASEKOLAH' AND `StatusKunjungan` = 'Baru' AND `JenisKelamin` = 'P'"));
							$aspras_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'ANAK PRASEKOLAH' AND `StatusKunjungan` = 'Lama' AND `JenisKelamin` = 'L'"));
							$aspras_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'ANAK PRASEKOLAH' AND `StatusKunjungan` = 'Lama' AND `JenisKelamin` = 'P'"));
							// bayi anak sekolah
							$as_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'ANAK SEKOLAH' AND `StatusKunjungan` = 'Baru' AND `JenisKelamin` = 'L'"));
							$as_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'ANAK SEKOLAH' AND `StatusKunjungan` = 'Baru' AND `JenisKelamin` = 'P'"));
							$as_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'ANAK SEKOLAH' AND `StatusKunjungan` = 'Lama' AND `JenisKelamin` = 'L'"));
							$as_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'ANAK SEKOLAH' AND `StatusKunjungan` = 'Lama' AND `JenisKelamin` = 'P'"));
							// umum
							$umum_b_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'MASYARAKAT UMUM' AND `StatusKunjungan` = 'Baru' AND `JenisKelamin` = 'L'"));
							$umum_b_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'MASYARAKAT UMUM' AND `StatusKunjungan` = 'Baru' AND `JenisKelamin` = 'P'"));
							$umum_l_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'MASYARAKAT UMUM' AND `StatusKunjungan` = 'Lama' AND `JenisKelamin` = 'L'"));
							$umum_l_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `KunjunganGigi` = 'MASYARAKAT UMUM' AND `StatusKunjungan` = 'Lama' AND `JenisKelamin` = 'P'"));
							
							// tambal gigi susu
							$t_susu_lcr_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENAMBALAN GIGI SULUNG (LC/KOMPOSIT)' AND `JenisKelamin` = 'L'"));
							$t_susu_lcr_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENAMBALAN GIGI SULUNG (LC/KOMPOSIT)' AND `JenisKelamin` = 'P'"));
							$t_susu_gic_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENAMBALAN GIGI SULUNG (GIC)' AND `JenisKelamin` = 'L'"));
							$t_susu_gic_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENAMBALAN GIGI SULUNG (GIC)' AND `JenisKelamin` = 'P'"));
							$t_susu_ts_l = "0";
							$t_susu_ts_p = "0";
							$t_susu_exo_dalam_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENCABUTAN GIGI SULUNG' AND `JenisKelamin` = 'L'"));
							$t_susu_exo_dalam_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENCABUTAN GIGI SULUNG' AND `JenisKelamin` = 'P'"));
							$t_susu_exo_luar_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENCABUTAN GIGI SULUNG' AND `JenisKelamin` = 'L'"));
							$t_susu_exo_luar_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENCABUTAN GIGI SULUNG' AND `JenisKelamin` = 'P'"));
							
							// tambal gigi tetap
							$t_tetap_lcr_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENAMBALAN GIGI TETAP (LC/KOMPOSIT)' AND `JenisKelamin` = 'L'"));
							$t_tetap_lcr_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENAMBALAN GIGI TETAP (LC/KOMPOSIT)' AND `JenisKelamin` = 'P'"));
							$t_tetap_gic_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENAMBALAN GIGI TETAP (GIC)' AND `JenisKelamin` = 'L'"));
							$t_tetap_gic_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENAMBALAN GIGI TETAP (GIC)' AND `JenisKelamin` = 'P'"));
							$t_tetap_ts_l = "0";
							$t_tetap_ts_p = "0";
							$t_tetap_exo_dalam_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENCABUTAN GIGI SULUNG' AND `JenisKelamin` = 'L'"));
							$t_tetap_exo_dalam_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENCABUTAN GIGI SULUNG' AND `JenisKelamin` = 'P'"));
							$t_tetap_exo_luar_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENCABUTAN GIGI SULUNG' AND `JenisKelamin` = 'L'"));
							$t_tetap_exo_luar_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PENCABUTAN GIGI SULUNG' AND `JenisKelamin` = 'P'"));
							
							// scalling dan premedikasi
							$sclg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'SCALLING' AND `JenisKelamin` = 'L'"));
							$premed = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `TindakLanjut1` = 'PREMEDIKASI' AND `JenisKelamin` = 'P'"));
							
							// rukuk
							$internal_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `StatusPulang` = '0'"));
							$internal_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `StatusPulang` = '5'"));
							$eksternal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPemeriksaan) AS Jumlah FROM `$tbpoligigi` WHERE SUBSTRING(NoPemeriksaan,1,11)='$kodepuskesmas' AND date(`TanggalPeriksa`) = '$tgl' AND `StatusPulang` = '4'"));
							
							// total		
							$jumlah_kunjungan_total[] = $jumlah_kunjungan['Jumlah'];
							$bb_b_l_total[] = $bb_b_l['Jumlah'];
							$bb_b_p_total[] = $bb_b_p['Jumlah'];
							$bb_l_l_total[] = $bb_l_l['Jumlah'];
							$bb_l_p_total[] = $bb_l_p['Jumlah'];
							$aspras_b_l_total[] = $aspras_b_l['Jumlah'];
							$aspras_b_p_total[] = $aspras_b_p['Jumlah'];
							$aspras_l_l_total[] = $aspras_l_l['Jumlah'];
							$aspras_l_p_total[] = $aspras_l_p['Jumlah'];
							$as_b_l_total[] = $as_b_l['Jumlah'];
							$as_b_p_total[] = $as_b_p['Jumlah'];
							$as_l_l_total[] = $as_l_l['Jumlah'];
							$as_l_p_total[] = $as_l_p['Jumlah'];
							$umum_b_l_total[] = $umum_b_l['Jumlah'];
							$umum_b_p_total[] = $umum_b_p['Jumlah'];
							$umum_l_l_total[] = $umum_l_l['Jumlah'];
							$umum_l_p_total[] = $umum_l_p['Jumlah'];
							$t_susu_lcr_l_total[] = $t_susu_lcr_l['Jumlah'];
							$t_susu_lcr_p_total[] = $t_susu_lcr_p['Jumlah'];
							$t_susu_gic_l_total[] = $t_susu_gic_l['Jumlah'];
							$t_susu_gic_p_total[] = $t_susu_gic_p['Jumlah'];
							$t_susu_ts_l_total[] = $t_susu_ts_l['Jumlah'];
							$t_susu_ts_p_total[] = $t_susu_ts_p['Jumlah'];
							$t_susu_exo_dalam_l_total[] = $t_susu_exo_dalam_l['Jumlah'];
							$t_susu_exo_dalam_p_total[] = $t_susu_exo_dalam_p['Jumlah'];
							$t_susu_exo_luar_l_total[] = $t_susu_exo_luar_l['Jumlah'];
							$t_susu_exo_luar_p_total[] = $t_susu_exo_luar_p['Jumlah'];
							$t_tetap_lcr_l_total[] = $t_tetap_lcr_l['Jumlah'];
							$t_tetap_lcr_p_total[] = $t_tetap_lcr_p['Jumlah'];
							$t_tetap_gic_l_total[] = $t_tetap_gic_l['Jumlah'];
							$t_tetap_gic_p_total[] = $t_tetap_gic_p['Jumlah'];
							$t_tetap_ts_l_total[] = $t_tetap_ts_l['Jumlah'];
							$t_tetap_ts_p_total[] = $t_tetap_ts_p['Jumlah'];
							$t_tetap_exo_dalam_l_total[] = $t_tetap_exo_dalam_l['Jumlah'];
							$t_tetap_exo_dalam_p_total[] = $t_tetap_exo_dalam_p['Jumlah'];
							$t_tetap_exo_luar_l_total[] = $t_tetap_exo_luar_l['Jumlah'];
							$t_tetap_exo_luar_p_total[] = $t_tetap_exo_luar_p['Jumlah'];
							$sclg_total[] = $sclg['Jumlah'];
							$premed_total[] = $premed['Jumlah'];
							$internal_1_total[] = $internal_1['Jumlah'];
							$internal_2_total[] = $internal_2['Jumlah'];
							$eksternal_total[] = $eksternal['Jumlah'];
							
							
							// $totaljml[] = $jumlah_b_l + $jumlah_b_p + $jumlah_l_l + $jumlah_l_p;
						?>
							<tr>
								<td align="center"><?php echo $i->format("d");?></td>	
								<td align="right"><?php echo $jumlah_kunjungan['Jumlah'];?></td>
								<td align="center">-</td>
								<td align="right"><?php echo $bb_b_l['Jumlah'];?></td>
								<td align="right"><?php echo $bb_b_p['Jumlah'];?></td>
								<td align="right"><?php echo $bb_l_l['Jumlah'];?></td>
								<td align="right"><?php echo $bb_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $aspras_b_l['Jumlah'];?></td>
								<td align="right"><?php echo $aspras_b_p['Jumlah'];?></td>
								<td align="right"><?php echo $aspras_l_l['Jumlah'];?></td>
								<td align="right"><?php echo $aspras_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $as_b_l['Jumlah'];?></td>
								<td align="right"><?php echo $as_b_p['Jumlah'];?></td>
								<td align="right"><?php echo $as_l_l['Jumlah'];?></td>
								<td align="right"><?php echo $as_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $umum_b_l['Jumlah'];?></td>
								<td align="right"><?php echo $umum_b_p['Jumlah'];?></td>
								<td align="right"><?php echo $umum_l_l['Jumlah'];?></td>
								<td align="right"><?php echo $umum_l_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_lcr_l['Jumlah'];?></td><!--penambalan gigi susu-->
								<td align="right"><?php echo $t_susu_lcr_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_gic_l['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_gic_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_ts_l['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_ts_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_exo_dalam_l['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_exo_dalam_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_exo_luar_l['Jumlah'];?></td>
								<td align="right"><?php echo $t_susu_exo_luar_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_lcr_l['Jumlah'];?></td><!--penambalan gigi tetap-->
								<td align="right"><?php echo $t_tetap_lcr_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_gic_l['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_gic_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_ts_l['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_ts_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_exo_dalam_l['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_exo_dalam_p['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_exo_luar_l['Jumlah'];?></td>
								<td align="right"><?php echo $t_tetap_exo_luar_p['Jumlah'];?></td>
								<td align="right"><?php echo $sclg['Jumlah'];?></td>
								<td align="right"><?php echo $premed['Jumlah'];?></td>
								<td align="right"><?php echo $internal_1['Jumlah'];?></td>
								<td align="right"><?php echo $internal_2['Jumlah'];?></td>
								<td align="right"><?php echo $eksternal['Jumlah'];?></td>
							</tr>
						<?php
						}
						?>
						<tr>
							<td align="center">TOTAL</td>							
							<td align="right"><?php echo array_sum($jumlah_kunjungan_total);?></td>
							<td align="center">-</td>
							<td align="right"><?php echo array_sum($bb_b_l_total);?></td>
							<td align="right"><?php echo array_sum($bb_b_p_total);?></td>
							<td align="right"><?php echo array_sum($bb_l_l_total);?></td>
							<td align="right"><?php echo array_sum($bb_l_p_total);?></td>
							<td align="right"><?php echo array_sum($aspras_b_l_total);?></td>
							<td align="right"><?php echo array_sum($aspras_b_p_total);?></td>
							<td align="right"><?php echo array_sum($aspras_l_l_total);?></td>
							<td align="right"><?php echo array_sum($aspras_l_p_total);?></td>
							<td align="right"><?php echo array_sum($as_b_l_total);?></td>
							<td align="right"><?php echo array_sum($as_b_p_total);?></td>
							<td align="right"><?php echo array_sum($as_l_l_total);?></td>
							<td align="right"><?php echo array_sum($as_l_p_total);?></td>
							<td align="right"><?php echo array_sum($umum_b_l_total);?></td>
							<td align="right"><?php echo array_sum($umum_b_p_total);?></td>
							<td align="right"><?php echo array_sum($umum_l_l_total);?></td>
							<td align="right"><?php echo array_sum($umum_l_p_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_lcr_l_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_lcr_p_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_gic_l_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_gic_p_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_ts_l_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_ts_p_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_exo_dalam_l_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_exo_dalam_p_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_exo_luar_l_total);?></td>
							<td align="right"><?php echo array_sum($t_susu_exo_luar_p_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_lcr_l_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_lcr_p_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_gic_l_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_gic_p_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_ts_l_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_ts_p_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_exo_dalam_l_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_exo_dalam_p_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_exo_luar_l_total);?></td>
							<td align="right"><?php echo array_sum($t_tetap_exo_luar_p_total);?></td>
							<td align="right"><?php echo array_sum($sclg_total);?></td>
							<td align="right"><?php echo array_sum($premed_total);?></td>
							<td align="right"><?php echo array_sum($internal_1_total);?></td>
							<td align="right"><?php echo array_sum($internal_2_total);?></td>
							<td align="right"><?php echo array_sum($eksternal_total);?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	<?php
	}
	?>
</div>	