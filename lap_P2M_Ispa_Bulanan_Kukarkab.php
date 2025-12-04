<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>ISPA (BULANAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_Ispa_Bulanan_Kukarkab"/>
						<div class="col-sm-2">
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
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<SELECT name="kasus" class="form-control">
								<option value="semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Kasus</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</SELECT>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Ispa_Bulanan_Kukarkab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<!--<a href="lap_P2M_Ispa_Bulanan_Kukarkab_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-sm btn-info">Excel</a>-->
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kasus = $_GET['kasus'];
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN PROGRAM PENGENDALIAN ISPA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
			?>
		</span>
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
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr>
							<th rowspan="4" width="2%">No.</th>
							<th rowspan="4" width="10%">Kelurahan</th>
							<th rowspan="4" width="3%">Jml Pdkk</th>
							<th rowspan="4" width="3%">Jml Pdkk Balita (10% pddk)</th>
							<th rowspan="4" width="3%">Target Pene muan Pddk Pneu monia</th>
							<th colspan="4">Pneumonia</th>
							<th colspan="4">Pneumonia Berat</th>
							<th colspan="7">Jumlah</th>
							<th rowspan="4">%</th>
							<th colspan="5">Batuk Bukan Pneumonia</th>
							<th colspan="6">Jml Kematian Balita Krn Penumonia</th>
							<th colspan="6">ISPA >5 Thn</th>
							<th rowspan="4">Dirujuk</th>
						</tr>
						<tr>
							<th colspan="2"><1 Thn</th><!--Pneumonia-->
							<th colspan="2">1-4 Thn</th>
							<th colspan="2"><1 Thn</th><!--Pneumonia Berat-->
							<th colspan="2">1-4 Thn</th>
							<th colspan="2"><1 Thn</th><!--Jumlah-->
							<th colspan="2">1-4 Thn</th>
							<th colspan="2">SubTotal</th>
							<th rowspan="2">Total</th>
							<th colspan="2"><1 Thn</th><!--Bukan Pneumonia-->
							<th colspan="2">1-4 Thn</th>
							<th rowspan="2">Total</th>
							<th colspan="2"><1 Thn</th><!--Jml Kematian Balita Krn Penumonia-->
							<th colspan="2">1-4 Thn</th>
							<th colspan="2">Total</th>
							<th colspan="3">Bkn Pneumonia</th>
							<th colspan="3">Pneumonia</th><!--ISPA >5 Thn-->
						</tr>
						<tr style="border:1px solid #000;">
							<th>L</th><!--Pneumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Pneumonia Berat-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Jumlah-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Bukan Pneumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Jml Kematian Balita Krn Penumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Pneumonia-->
							<th>P</th>
							<th>T</th>
							<th>L</th><!--Bukan Pneumonia-->
							<th>P</th>
							<th>T</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						// tbdiagnosaispa
						if($kasus != 'semua'){
							$qkasus = " AND c.Kasus = '$kasus' ";
						}else{
							$qkasus = " ";
						}
						
						$str_kelurahan = "SELECT * FROM `tbkelurahan` WHERE KodePuskesmas = '$kodepuskesmas' OR KodePuskesmas = '*'";
						$str2 = $str_kelurahan."ORDER BY Kelurahan";
						// echo $str2;
						
						$query_kelurahan = mysqli_query($koneksi,$str2);
						while($data_kelurahan = mysqli_fetch_assoc($query_kelurahan)){
							$no = $no + 1;
							$noregistrasi = $data_kelurahan['NoRegistrasi'];
							$umurtahun = $data_kelurahan['UmurTahun'];
							$kelurahan = $data_kelurahan['Kelurahan'];
						
							// pneumonia < 5th
							$ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa like '%J10%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J12.2' OR c.KodeDiagnosa = 'J12.8' OR c.KodeDiagnosa = 'J12.9' OR c.KodeDiagnosa = 'J15.8' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J18%' OR c.KodeDiagnosa = 'J39.8')".$qkasus));
							$ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa like '%J10%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J12.2' OR c.KodeDiagnosa = 'J12.8' OR c.KodeDiagnosa = 'J12.9' OR c.KodeDiagnosa = 'J15.8' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J18%' OR c.KodeDiagnosa = 'J39.8')".$qkasus));
							$ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa like '%J10%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J12.2' OR c.KodeDiagnosa = 'J12.8' OR c.KodeDiagnosa = 'J12.9' OR c.KodeDiagnosa = 'J15.8' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J18%' OR c.KodeDiagnosa = 'J39.8')".$qkasus));
							$ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa like '%J10%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J12.2' OR c.KodeDiagnosa = 'J12.8' OR c.KodeDiagnosa = 'J12.9' OR c.KodeDiagnosa = 'J15.8' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J18%' OR c.KodeDiagnosa = 'J39.8')".$qkasus));
							$ispa_0_Laki = $ispa_0_Laki_pneumonia['Jumlah'];
							$ispa_1_4_Laki =  $ispa_1_4_Laki_pneumonia['Jumlah'];
							$laki_pneumonia = $ispa_0_Laki + $ispa_1_4_Laki;
							$ispa_0_perempuan = $ispa_0_Perempuan_pneumonia['Jumlah'];
							$ispa_1_4_perempuan =  $ispa_1_4_Perempuan_pneumonia['Jumlah'];
							$perempuan_pneumonia = $ispa_0_perempuan + $ispa_1_4_perempuan;
							
							// pneumonia_berat < 5th
							$ispa_0_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J15.9')".$qkasus));
							$ispa_0_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J15.9')".$qkasus));
							$ispa_1_4_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J15.9')".$qkasus));
							$ispa_1_4_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J15.9')".$qkasus));
							$ispa_0_Laki_berat = $ispa_0_Laki_pneumonia_berat['Jumlah'];
							$ispa_1_4_Laki_berat =  $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
							$laki_pneumonia_berat = $ispa_0_Laki_berat + $ispa_1_4_Laki_berat;			
							$ispa_0_perempuan_berat = $ispa_0_Perempuan_pneumonia_berat['Jumlah'];
							$ispa_1_4_perempuan_berat =  $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
							$perempuan_pneumonia_berat = $ispa_0_perempuan_berat + $ispa_1_4_perempuan_berat;
						
							// sub total
							$jumlah_0_Laki = $ispa_1_4_Laki_pneumonia['Jumlah'];
							$jumlah_1_4_Laki = $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
							$sublaki = $jumlah_0_Laki + $jumlah_1_4_Laki;			
							$jumlah_0_perempuan = $ispa_1_4_Perempuan_pneumonia['Jumlah'];
							$jumlah_1_4_perempuan = $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
							$subperempuan = $jumlah_0_perempuan + $jumlah_1_4_perempuan;
						
							// total
							$total  = $sublaki + $subperempuan;
							
							// batuk bukan pneumonia < 5th
							$ispa_0_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa like '%J00%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J06%' OR c.KodeDiagnosa like '%J04%' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
							$ispa_0_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa like '%J00%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J06%' OR c.KodeDiagnosa like '%J04%' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
							$ispa_1_4_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa like '%J00%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J06%' OR c.KodeDiagnosa like '%J04%' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
							$ispa_1_4_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa like '%J00%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J06%' OR c.KodeDiagnosa like '%J04%' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
							$ttl_pneumonia_bukan = $ispa_0_Laki_pneumonia_bukan['Jumlah'] + $ispa_0_Perempuan_pneumonia_bukan['Jumlah'] + $ispa_1_4_Laki_pneumonia_bukan['Jumlah'] + $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];
							
							// ispa > 5th bukan pneumonia
							$ispa_5_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa like '%J00%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J06%' OR c.KodeDiagnosa like '%J04%' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
							$ispa_5_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J39.9' OR c.KodeDiagnosa like '%J00%' OR c.KodeDiagnosa like '%J11%' OR c.KodeDiagnosa = 'J02.9' OR c.KodeDiagnosa = 'J03.9' OR c.KodeDiagnosa = 'J15.9' OR c.KodeDiagnosa like '%J06%' OR c.KodeDiagnosa like '%J04%' OR c.KodeDiagnosa = 'J20.9')".$qkasus));
							$ttl_5_pneumonia_bukan = $ispa_5_Laki_pneumonia_bukan['Jumlah'] + $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];
													
							// ispa > 5th pneumonia
							$ispa_5_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J18.9')".$qkasus));
							$ispa_5_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `$tbdiagnosapasien` c ON a.NoRegistrasi = c.NoRegistrasi WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND b.Kelurahan = '$kelurahan' AND (c.KodeDiagnosa = 'J18.9')".$qkasus));
							$ttl_5_pneumonia = $ispa_5_Laki_pneumonia['Jumlah'] + $ispa_5_Perempuan_pneumonia['Jumlah'];
						?>
						
							<tr style="border:1px solid #000;">
								<td style="border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="border:1px solid #000; padding:3px;"><?php echo $data_kelurahan['Kelurahan'];?></td>
								<td style="border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td style="border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td style="border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td><?php echo $ispa_0_Laki_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_0_Perempuan_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Laki_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Perempuan_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_0_Laki_pneumonia_berat['Jumlah'];?></td>
								<td><?php echo $ispa_0_Perempuan_pneumonia_berat['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Laki_pneumonia_berat['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];?></td>
								<td><?php echo $laki_pneumonia;?></td>
								<td><?php echo $perempuan_pneumonia;?></td>
								<td><?php echo $laki_pneumonia_berat;?></td>
								<td><?php echo $perempuan_pneumonia_berat;?></td>
								<td><?php echo $sublaki;?></td>
								<td><?php echo $subperempuan;?></td>
								<td><?php echo $total;?></td>
								<td>0</td>
								<td><?php echo $ispa_0_Laki_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ispa_0_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Laki_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ttl_pneumonia_bukan?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
								<td><?php echo $ispa_5_Laki_pneumonia_bukan['Jumlah'];?></td><!--ispa >5 tahun-->
								<td><?php echo $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ttl_5_pneumonia_bukan;?></td>
								<td><?php echo $ispa_5_Laki_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_5_Perempuan_pneumonia['Jumlah'];?></td>
								<td><?php echo $ttl_5_pneumonia;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px; text-align:center;">-</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table><br/>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Kategori Kode Penyakit :</b><br>
				- Pneumonia (J10, J11, J12.2, J12.9, J12.8, J15.8, J15.9, J18.0, J18.8, J18.9, J39.8)<br/>
				- Pneumonia Berat (J15.9)<br/>
				- Batuk Bukan Pneumonia (J00, J02.9, J03.9, J04, J06, J11, J15.9, J20.9, J39.9)<br/>
				- Bukan Pneumonia > 5Th(J00, J02.9, J03.9, J04, J06, J11, J15.9, J20.9, J39.9)<br/>
				- Pneumonia > 5Th (J18.9)<br/>
				
				</p>
			</div>
		</div>
	</div>
</div>	