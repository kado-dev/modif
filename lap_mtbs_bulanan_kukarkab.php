<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LAPORAN BULANAN MTBS</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_mtbs_bulanan_kukarkab"/>
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
							<a href="?page=lap_mtbs_bulanan_kukarkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
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
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:2px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN MTBS</b></span><br>
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

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" style="font-size:11px;">
					<thead>
						<tr>
							<th rowspan="3" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">NO.</th>
							<th rowspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">KELURAHAN</th>
							<th colspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">KUNJ.</th>
							<th colspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">JUMLAH KUNJ.BALITA SAKIT</th>
							<th colspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">JUMLAH KUNJ.BALITA SAKIT DI MTBS</th>
							<th colspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">TANDA BAHAYA UMUM</th>
							<th colspan="9" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">BATUK ATAU SUKAR BERNAFAS</th>
							<th colspan="18" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">DIARE</th>
						</tr>
						<tr>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">B</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--kunjungan baru dan lama-->
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--kunjungan balita sakit-->
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--tanda bahaya umum-->
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">PNEUMONIA BERAT</th><!--batuk atau sukar bernafas-->
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">PNEUMONIA</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">BATUK BKN PNEUMONIA</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">DEHIDRASI BERAT</th><!--diare-->
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">DEHIDRASI RINGAN/SEDANG</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">TANPA DEHIDRASI</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">PERSISTEN BERAT</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">PERSISTEN</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">DISENTRI</th>
						</tr>
						<tr>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--pneumonia berat-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--pneumonia-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--batuk bukan pneumonia-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--dehidrasi berat-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--ehidrasi ringan/sedang-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--tanpa dehidrasi-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--persisten berat-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--persisten-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--disentri-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
						</tr>	
					</thead>
					<tbody>
						<?php
						$str_kel = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR KodePuskesmas = '*'";
						$query = mysqli_query($koneksi,$str_kel);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kelurahan = $data['Kelurahan'];
							
							// tbpasienrj_bulan
							$kunj_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND a.`StatusKunjungan`='BARU' AND a.PoliPertama='POLI MTBS' AND b.Kelurahan='$kelurahan'"));
							$kunj_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND a.`StatusKunjungan`='LAMA' AND a.PoliPertama='POLI MTBS' AND b.Kelurahan='$kelurahan'"));
							
							// jml kunjungan balita sakit
							$kunj_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND a.PoliPertama='POLI MTBS' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan'"));
							$kunj_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi) AS Jml FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalRegistrasi)='$tahun' AND a.PoliPertama='POLI MTBS' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan'"));
							$ttl_kunj = $kunj_laki['Jml'] + $kunj_perempuan['Jml'];
					
							// jumlah balita dilayani di mtbs
							$kunj_mtbs_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND b.Kelurahan='$kelurahan'"));
							$kunj_mtbs_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND b.Kelurahan='$kelurahan'"));
							$ttl_mtbs_kunj = $kunj_mtbs_laki['Jml'] + $kunj_mtbs_perempuan['Jml'];
					
							// tanda bahaya umum
							$bahaya_umum_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiUmum`='Ada' AND b.Kelurahan='$kelurahan'"));
							$bahaya_umum_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiUmum`='Ada' AND b.Kelurahan='$kelurahan'"));
							$ttl_bahaya_umum = $bahaya_umum_laki['Jml'] + $bahaya_umum_perempuan['Jml'];
							
							// batuk atau sukar bernafas
							$pneumonia_berat_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiPneumonia`='Pneumonia Berat' AND b.Kelurahan='$kelurahan'"));
							$pneumonia_berat_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiPneumonia`='Pneumonia Berat' AND b.Kelurahan='$kelurahan'"));
							$ttl_pneumonia_berat = $pneumonia_berat_laki['Jml'] + $pneumonia_berat_perempuan['Jml'];
							
							$pneumonia_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiPneumonia`='Pneumonia' AND b.Kelurahan='$kelurahan'"));
							$pneumonia_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiPneumonia`='Pneumonia' AND b.Kelurahan='$kelurahan'"));
							$ttl_pneumonia = $pneumonia_laki['Jml'] + $pneumonia_perempuan['Jml'];
							
							$bukan_pneumonia_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiPneumonia`='Batuk Bukan Pneumonia' AND b.Kelurahan='$kelurahan'"));
							$bukan_pneumonia_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiPneumonia`='Batuk Bukan Pneumonia' AND b.Kelurahan='$kelurahan'"));
							$ttl_bukan_pneumonia = $bukan_pneumonia_laki['Jml'] + $bukan_pneumonia_perempuan['Jml'];
							
							// diare
							$dehidrasi_berat_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDiare`='Dehidrasi Berat' AND b.Kelurahan='$kelurahan'"));
							$dehidrasi_berat_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDiare`='Dehidrasi Berat' AND b.Kelurahan='$kelurahan'"));
							$ttl_dehidrasi_berat = $dehidrasi_berat_laki['Jml'] + $dehidrasi_berat_perempuan['Jml'];
							
							$dehidrasi_ringan_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDiare`='Dehidrasi Sedang atau Ringan' AND b.Kelurahan='$kelurahan'"));
							$dehidrasi_ringan_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDiare`='Dehidrasi Sedang atau Ringan' AND b.Kelurahan='$kelurahan'"));
							$ttl_dehidrasi_ringan = $dehidrasi_ringan_laki['Jml'] + $dehidrasi_ringan_perempuan['Jml'];
							
							$tanpa_dehidrasi_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDiare`='Diare Tanpa Dehidrasi' AND b.Kelurahan='$kelurahan'"));
							$tanpa_dehidrasi_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDiare`='Diare Tanpa Dehidrasi' AND b.Kelurahan='$kelurahan'"));
							$ttl_tanpa_dehidrasi = $tanpa_dehidrasi_laki['Jml'] + $tanpa_dehidrasi_perempuan['Jml'];
							
							$persisten_berat_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDiare`='Diare Persisten Berat' AND b.Kelurahan='$kelurahan'"));
							$persisten_berat_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDiare`='Diare Persisten Berat' AND b.Kelurahan='$kelurahan'"));
							$ttl_persisten_berat = $persisten_berat_laki['Jml'] + $persisten_berat_perempuan['Jml'];
							
							$persisten_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDiare`='Diare Persisten' AND b.Kelurahan='$kelurahan'"));
							$persisten_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDiare`='Diare Persisten' AND b.Kelurahan='$kelurahan'"));
							$ttl_persisten = $persisten_laki['Jml'] + $persisten_perempuan['Jml'];
							
							$disentri_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDiare`='Diare Persisten' AND b.Kelurahan='$kelurahan'"));
							$disentri_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDiare`='Diare Persisten' AND b.Kelurahan='$kelurahan'"));
							$ttl_disentri = $disentri_laki['Jml'] + $disentri_perempuan['Jml'];
							
					?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="left"><?php echo $kelurahan;?></td>
								<td align="right"><?php echo $kunj_baru['Jml'];?></td><!--kunjungan baru dan lama-->
								<td align="right"><?php echo $kunj_lama['Jml'];?></td>
								<td align="right"><?php echo $kunj_laki['Jml'];?></td><!--kunjungan balita sakit-->
								<td align="right"><?php echo $kunj_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_kunj;?></td>
								<td align="right"><?php echo $kunj_mtbs_laki['Jml'];?></td><!--kunjungan balita sakit di mtbs / dilayani-->
								<td align="right"><?php echo $kunj_mtbs_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_mtbs_kunj;?></td>
								<td align="right"><?php echo $bahaya_umum_laki['Jml'];?></td><!--tanda bahaya umum-->
								<td align="right"><?php echo $bahaya_umum_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_bahaya_umum;?></td>
								<td align="right"><?php echo $pneumonia_berat_laki['Jml'];?></td><!--batuk sukar bernafas-->
								<td align="right"><?php echo $pneumonia_berat_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_pneumonia_berat;?></td>
								<td align="right"><?php echo $pneumonia_laki['Jml'];?></td>
								<td align="right"><?php echo $pneumonia_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_pneumonia;?></td>
								<td align="right"><?php echo $bukan_pneumonia_laki['Jml'];?></td>
								<td align="right"><?php echo $bukan_pneumonia_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_bukan_pneumonia;?></td>
								<td align="right"><?php echo $dehidrasi_berat_laki['Jml'];?></td><!--diare-->
								<td align="right"><?php echo $dehidrasi_berat_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_dehidrasi_berat;?></td>
								<td align="right"><?php echo $dehidrasi_ringan_laki['Jml'];?></td>
								<td align="right"><?php echo $dehidrasi_ringan_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_dehidrasi_ringan;?></td>
								<td align="right"><?php echo $tanpa_dehidrasi_laki['Jml'];?></td>
								<td align="right"><?php echo $tanpa_dehidrasi_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_tanpa_dehidrasi;?></td>
								<td align="right"><?php echo $persisten_berat_laki['Jml'];?></td>
								<td align="right"><?php echo $persisten_berat_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_persisten_berat;?></td>
								<td align="right"><?php echo $persisten_laki['Jml'];?></td>
								<td align="right"><?php echo $persisten_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_persisten;?></td>
								<td align="right"><?php echo $disentri_laki['Jml'];?></td>
								<td align="right"><?php echo $disentri_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_disentri;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table><br/><br/>
				
				<!--demam, dbd, telinga-->
				<table class="table-judul-laporan-min" style="font-size:11px;">
					<thead>
						<tr>
							<th rowspan="3" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">NO.</th>
							<th rowspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">KELURAHAN</th>
							<th colspan="12" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">DEMAM</th>
							<th colspan="9" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">DBD</th>
							<th colspan="12" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">TELINGA</th>
						</tr>
						<tr>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">PENYAKIT BRT DGN DEMAM</th><!--demam-->
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">MALARIA</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">DEMAM MKN BKN MALARIA</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">DEMAM BKN MALARIA</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">DBD</th><!--dbd-->
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">MUNGKIN DBD</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">DEMAM MKN BKN DBD</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">MASTOIDITIS</th><!--telinga-->
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">INFEKSI TELINGA AKUT</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">INFEKSI TELINGA KRONIS</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">TDK ADA INFEKSI TELINGA</th>
						</tr>
						<tr>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--demam-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--dbd-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--telinga-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							
						</tr>	
					</thead>
					<tbody>
						<?php
						$no = 0;
						$str_kel = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR KodePuskesmas = '*'";
						$query = mysqli_query($koneksi,$str_kel);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kelurahan = $data['Kelurahan'];
							
							// demam
							$demam_berat_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDemam`='Penyakit Berat Dengan Demam' AND b.Kelurahan='$kelurahan'"));
							$demam_berat_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDemam`='Penyakit Berat Dengan Demam' AND b.Kelurahan='$kelurahan'"));
							$ttl_demam_berat = $demam_berat_laki['Jml'] + $demam_berat_perempuan['Jml'];
					
							$malaria_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDemam`='Penyakit Malaria' AND b.Kelurahan='$kelurahan'"));
							$malaria_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDemam`='Penyakit Malaria' AND b.Kelurahan='$kelurahan'"));
							$ttl_malaria = $malaria_laki['Jml'] + $malaria_perempuan['Jml'];
					
							$demam_mungkin_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDemam`='Demam Mungkin Bukan Malaria' AND b.Kelurahan='$kelurahan'"));
							$demam_mungkin_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDemam`='Demam Mungkin Bukan Malaria' AND b.Kelurahan='$kelurahan'"));
							$ttl_demam_mungkin = $demam_mungkin_laki['Jml'] + $demam_mungkin_perempuan['Jml'];
					
							$demam_malaria_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDemam`='Demam Bukan Malaria' AND b.Kelurahan='$kelurahan'"));
							$demam_malaria_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDemam`='Demam Bukan Malaria' AND b.Kelurahan='$kelurahan'"));
							$ttl_demam_malaria = $demam_malaria_laki['Jml'] + $demam_malaria_perempuan['Jml'];
							
							// dbd
							$dbd_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDBD`='Penyakit Demam Berdarah Dengue (DBD)' AND b.Kelurahan='$kelurahan'"));
							$dbd_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDBD`='Penyakit Demam Berdarah Dengue (DBD)' AND b.Kelurahan='$kelurahan'"));
							$ttl_dbd = $dbd_laki['Jml'] + $dbd_perempuan['Jml'];
					
							$mungkin_dbd_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDBD`='Penyakit Demam Mungkin DBD' AND b.Kelurahan='$kelurahan'"));
							$mungkin_dbd_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDBD`='Penyakit Demam Mungkin DBD' AND b.Kelurahan='$kelurahan'"));
							$ttl_mungkin_dbd = $mungkin_dbd_laki['Jml'] + $mungkin_dbd_perempuan['Jml'];
					
							$demam_dbd_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiDBD`='Penyakit Demam Mungkin Bukan DBD' AND b.Kelurahan='$kelurahan'"));
							$demam_dbd_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiDBD`='Penyakit Demam Mungkin Bukan DBD' AND b.Kelurahan='$kelurahan'"));
							$ttl_demam_dbd = $demam_dbd_laki['Jml'] + $demam_dbd_perempuan['Jml'];
							
							// telinga
							$mastoiditis_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiTelinga`='Mastoiditis' AND b.Kelurahan='$kelurahan'"));
							$mastoiditis_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiTelinga`='Mastoiditis' AND b.Kelurahan='$kelurahan'"));
							$ttl_mastoiditis = $mastoiditis_laki['Jml'] + $mastoiditis_perempuan['Jml'];
					
							$telinga_akut_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiTelinga`='Infeksi Telinga Akut' AND b.Kelurahan='$kelurahan'"));
							$telinga_akut_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiTelinga`='Infeksi Telinga Akut' AND b.Kelurahan='$kelurahan'"));
							$ttl_telinga_akut = $telinga_akut_laki['Jml'] + $telinga_akut_perempuan['Jml'];
					
							$telinga_kronis_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiTelinga`='Infeksi Telinga Kronis' AND b.Kelurahan='$kelurahan'"));
							$telinga_kronis_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiTelinga`='Infeksi Telinga Kronis' AND b.Kelurahan='$kelurahan'"));
							$ttl_telinga_kronis = $telinga_kronis_laki['Jml'] + $telinga_kronis_perempuan['Jml'];
							
							$telinga_tidak_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiTelinga`='Tidak Ada Infeksi Telinga' AND b.Kelurahan='$kelurahan'"));
							$telinga_tidak_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiTelinga`='Tidak Ada Infeksi Telinga' AND b.Kelurahan='$kelurahan'"));
							$ttl_telinga_tidak = $telinga_tidak_laki['Jml'] + $telinga_tidak_perempuan['Jml'];
							
					
					?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="left"><?php echo $kelurahan;?></td><!--demam-->
								<td align="right"><?php echo $demam_berat_laki['Jml'];?></td>
								<td align="right"><?php echo $demam_berat_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_demam_berat;?></td>
								<td align="right"><?php echo $malaria_laki['Jml'];?></td>
								<td align="right"><?php echo $malaria_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_malaria;?></td>
								<td align="right"><?php echo $demam_mungkin_laki['Jml'];?></td>
								<td align="right"><?php echo $demam_mungkin_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_demam_mungkin;?></td>
								<td align="right"><?php echo $demam_malaria_laki['Jml'];?></td>
								<td align="right"><?php echo $demam_malaria_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_demam_malaria;?></td>
								<td align="right"><?php echo $dbd_laki['Jml'];?></td><!--dbd-->
								<td align="right"><?php echo $dbd_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_dbd;?></td>
								<td align="right"><?php echo $mungkin_dbd_laki['Jml'];?></td>
								<td align="right"><?php echo $mungkin_dbd_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_mungkin_dbd;?></td>
								<td align="right"><?php echo $demam_dbd_laki['Jml'];?></td>
								<td align="right"><?php echo $demam_dbd_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_demam_dbd;?></td>
								<td align="right"><?php echo $mastoiditis_laki['Jml'];?></td><!--telinga-->
								<td align="right"><?php echo $mastoiditis_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_mastoiditis;?></td>
								<td align="right"><?php echo $telinga_akut_laki['Jml'];?></td>
								<td align="right"><?php echo $telinga_akut_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_telinga_akut;?></td>
								<td align="right"><?php echo $telinga_kronis_laki['Jml'];?></td>
								<td align="right"><?php echo $telinga_kronis_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_telinga_kronis;?></td>
								<td align="right"><?php echo $telinga_tidak_laki['Jml'];?></td>
								<td align="right"><?php echo $telinga_tidak_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_telinga_tidak;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table><br/><br/>
				
				<!--gizi, anemia, hiv-->
				<table class="table-judul-laporan-min" style="font-size:11px;">
					<thead>
						<tr>
							<th rowspan="3" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">NO.</th>
							<th rowspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">KELURAHAN</th>
							<th colspan="12" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">GIZI</th>
							<th colspan="9" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">ANEMIA</th>
							<th colspan="12" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:2px;">HIV</th>
						</tr>
						<tr>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">GIZI BURUK DGN KOMPLIKASI</th><!--gizi-->
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">GIZI BURUK TANPA KOMPLIKASI</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">GIZI KURANG</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">GIZI BAIK</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">ANEMIA BERAT</th><!--anemia-->
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">ANEMIA</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">TIDAK ANEMIA</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">INFEKSI HIV</th><!--hiv-->
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">DIDUGA TERINFEKSI HIV</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">TERPAJAN HIV</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">KEMUNGKINAN BKN INFEKSI HIV</th>
						</tr>
						<tr>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--gizi-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--anemia-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th><!--hiv-->
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">L</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">P</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:2px;">JML</th>
							
						</tr>	
					</thead>
					<tbody>
						<?php
						$no = 0;
						$str_kel = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' OR KodePuskesmas = '*'";
						$query = mysqli_query($koneksi,$str_kel);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kelurahan = $data['Kelurahan'];
							
							// gizi
							$gizi_buruk_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiGizi`='Gizi Buruk Dengan Komplikasi' AND b.Kelurahan='$kelurahan'"));
							$gizi_buruk_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiGizi`='Gizi Buruk Dengan Komplikasi' AND b.Kelurahan='$kelurahan'"));
							$ttl_gizi_buruk = $gizi_buruk_laki['Jml'] + $gizi_buruk_perempuan['Jml'];
					
							$gizi_kompikasi_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiGizi`='Gizi Buruk Tanpa Komplikasi' AND b.Kelurahan='$kelurahan'"));
							$gizi_kompikasi_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiGizi`='Gizi Buruk Tanpa Komplikasi' AND b.Kelurahan='$kelurahan'"));
							$ttl_gizi_kompikasi = $gizi_kompikasi_laki['Jml'] + $gizi_kompikasi_perempuan['Jml'];
					
							$gizi_kurang_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiGizi`='Gizi Kurang' AND b.Kelurahan='$kelurahan'"));
							$gizi_kurang_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiGizi`='Gizi Kurang' AND b.Kelurahan='$kelurahan'"));
							$ttl_gizi_kurang= $gizi_kurang_laki['Jml'] + $gizi_kurang_perempuan['Jml'];
					
							$gizi_baik_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiGizi`='Gizi Baik' AND b.Kelurahan='$kelurahan'"));
							$gizi_baik_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiGizi`='Gizi Baik' AND b.Kelurahan='$kelurahan'"));
							$ttl_gizi_baik = $gizi_baik_laki['Jml'] + $gizi_baik_perempuan['Jml'];
							
							// anemia
							$anemia_berat_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiAnemia`='Anemia Berat' AND b.Kelurahan='$kelurahan'"));
							$anemia_berat_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiAnemia`='Anemia Berat' AND b.Kelurahan='$kelurahan'"));
							$ttl_anemia_berat = $anemia_berat_laki['Jml'] + $anemia_berat_perempuan['Jml'];
					
							$anemia_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiAnemia`='Anemia' AND b.Kelurahan='$kelurahan'"));
							$anemia_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiAnemia`='Anemia' AND b.Kelurahan='$kelurahan'"));
							$ttl_anemia = $anemia_laki['Jml'] + $anemia_perempuan['Jml'];
					
							$tidak_anemia_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiAnemia`='Tidak Anemia' AND b.Kelurahan='$kelurahan'"));
							$tidak_anemia_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiAnemia`='Tidak Anemia' AND b.Kelurahan='$kelurahan'"));
							$ttl_tidak_anemia = $tidak_anemia_laki['Jml'] + $tidak_anemia_perempuan['Jml'];
							
							// hiv
							$infeksi_hiv_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiHiv`='Infeksi HIV Terkonfirmasi' AND b.Kelurahan='$kelurahan'"));
							$infeksi_hiv_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiHiv`='Infeksi HIV Terkonfirmasi' AND b.Kelurahan='$kelurahan'"));
							$ttl_infeksi_hiv = $infeksi_hiv_laki['Jml'] + $infeksi_hiv_perempuan['Jml'];
					
							$diduga_hiv_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiHiv`='Diduga Terinfeksi HIV' AND b.Kelurahan='$kelurahan'"));
							$diduga_hiv_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiHiv`='Diduga Terinfeksi HIV' AND b.Kelurahan='$kelurahan'"));
							$ttl_diduga_hiv = $diduga_hiv_laki['Jml'] + $diduga_hiv_perempuan['Jml'];
					
							$terpajan_hiv_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiHiv`='Terpajan HIV' AND b.Kelurahan='$kelurahan'"));
							$terpajan_hiv_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiHiv`='Terpajan HIV' AND b.Kelurahan='$kelurahan'"));
							$ttl_terpajan_hiv = $terpajan_hiv_laki['Jml'] + $terpajan_hiv_perempuan['Jml'];
							
							$bukan_hiv_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='L' AND `KlasifikasiHiv`='Kemungkinan Bukan Inveksi HIV' AND b.Kelurahan='$kelurahan'"));
							$bukan_hiv_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoPemeriksaan) AS Jml FROM `$tbpolimtbs` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE MONTH(a.TanggalPeriksa)='$bulan' AND YEAR(a.TanggalPeriksa)='$tahun' AND a.JenisKelamin='P' AND `KlasifikasiHiv`='Kemungkinan Bukan Inveksi HIV' AND b.Kelurahan='$kelurahan'"));
							$ttl_bukan_hiv = $bukan_hiv_laki['Jml'] + $bukan_hiv_perempuan['Jml'];
					
					?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="left"><?php echo $kelurahan;?></td>
								<td align="right"><?php echo $gizi_buruk_laki['Jml'];?></td><!--gizi-->
								<td align="right"><?php echo $gizi_buruk_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_gizi_buruk;?></td>
								<td align="right"><?php echo $gizi_kompikasi_laki['Jml'];?></td>
								<td align="right"><?php echo $gizi_kompikasi_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_gizi_kompikasi;?></td>
								<td align="right"><?php echo $gizi_kurang_laki['Jml'];?></td>
								<td align="right"><?php echo $gizi_kurang_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_gizi_kurang;?></td>
								<td align="right"><?php echo $gizi_baik_laki['Jml'];?></td>
								<td align="right"><?php echo $gizi_baik_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_gizi_baik;?></td>
								<td align="right"><?php echo $anemia_berat_laki['Jml'];?></td><!--anemia-->
								<td align="right"><?php echo $anemia_berat_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_anemia_berat;?></td>
								<td align="right"><?php echo $anemia_laki['Jml'];?></td>
								<td align="right"><?php echo $anemia_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_anemia;?></td>
								<td align="right"><?php echo $tidak_anemia_laki['Jml'];?></td>
								<td align="right"><?php echo $tidak_anemia_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_tidak_anemia;?></td>
								<td align="right"><?php echo $infeksi_hiv_laki['Jml'];?></td><!--hiv-->
								<td align="right"><?php echo $infeksi_hiv_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_infeksi_hiv;?></td>
								<td align="right"><?php echo $diduga_hiv_laki['Jml'];?></td>
								<td align="right"><?php echo $diduga_hiv_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_diduga_hiv;?></td>
								<td align="right"><?php echo $terpajan_hiv_laki['Jml'];?></td>
								<td align="right"><?php echo $terpajan_hiv_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_terpajan_hiv;?></td>
								<td align="right"><?php echo $bukan_hiv_laki['Jml'];?></td>
								<td align="right"><?php echo $bukan_hiv_perempuan['Jml'];?></td>
								<td align="right"><?php echo $ttl_bukan_hiv;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<br/>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatikan :</b><br/>
				Klasifikasi yang wajib diisi:<br/>
				1. Batuk Bukan Pneumonia<br/>
				2. Demam Mungkin Bukan Malaria<br/>
				3. Demam Mungkin Bukan DBD<br/>
				4. Tidak Ada Infeksi Telinga<br/>
				5. Gizi Baik<br/>
				6. Tidak Anemia<br/>
				7. Menilai Masalah Keluhan Lain<br/>
				8. Dokter Puskesmas
				</p>
			</div>
		</div>
	</div>
</div>	