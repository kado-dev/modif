<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DIARE (BULANAN)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_Diare_Bulanan"/>
						<div class="col-xl-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</SELECT>	
						</div>
						<div class="col-xl-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
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
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<SELECT name="kasus" class="form-control">
								<option value="Semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</SELECT>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Diare_Bulanan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
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
	$kasus = $_GET['kasus'];
	$opsiform = $_GET['opsiform'];
	
	if(isset($kasus) and isset($opsiform)){
	?>

	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN DIARE</b></span><br>
		<?php if($opsiform == 'bulan'){ ?>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
		<?php }else{ ?>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
		<?php } ?>
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
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="4">NO.</th>
							<th rowspan="4" width="8%";>DESA / KELURAHAN</th>
							<th colspan="22">SARANA KESEHATAN</th>
							<th colspan="19">KADER</th>
							<th colspan="7">TOTAL SARANA KESEHATAN & KADER</th>
							<th colspan="3">DERAJAT DEHIDRASI</th>
							<th colspan="2">PEMERIKSAAN LAB</th>
						</tr>
						<tr>
							<th colspan="4"><1 TH</th><!--sarana kesehatan-->
							<th colspan="4">1-4 TH</th>
							<th colspan="4">>5 TH</th>
							<th colspan="4">JUMLAH</th>
							<th rowspan="2" colspan="3">JUMLAH<br/>PENDERITA DIBERI</th>
							<th rowspan="2" colspan="3">JUMLAH<br/>PEMAKAIAN</th>
							<th colspan="4"><1 Thn</th><!--kader-->
							<th colspan="4">1-4 TH</th>
							<th colspan="4">>5 TH</th>
							<th colspan="4">JUMLAH</th>
							<th rowspan="2" colspan="3">JUMLAH<br/>PEMAKAIAN</th><!--total sarana kesehatan & kader-->
							<th rowspan="2" colspan="2">P</th>
							<th rowspan="2" colspan="2">M</th>
							<th rowspan="2" colspan="3">PEMAKAIAN</th>
							<th rowspan="3">TANPA<br/>DEHIDRASI</th><!--derajat dehidrasi-->
							<th rowspan="3">SEDANG</th>
							<th rowspan="3">BERAT</th>
							<th rowspan="3">JUMLAH<br/>SPESIMEN</th><!--Pemeriksaan Lab-->
							<th rowspan="3">POS</th>
						</tr>
						<tr>
							<th colspan="2">P</th><!--sarana kesehatan-->
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th><!--kader-->
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
							<th colspan="2">P</th>
							<th colspan="2">M</th>
						</tr>
						<tr>
							<th>L</th><!--Penderita-Laki-<1thn--><!--sarana kesehatan-->
							<th>P</th><!--Penderita-Perempuan_<1thn-->
							<th>L</th><!--Meninggal-Laki-<1thn-->
							<th>P</th><!--Meninggal-Perempuan<1thn-->
							<th>L</th><!--Penderita-Laki-1-4thn-->
							<th>P</th><!--Penderita-Laki-1-4thn-->
							<th>L</th><!--Meninggal-Laki-1-4thn-->
							<th>P</th><!--Meninggal-Perempuan-1-4thn-->
							<th>L</th><!--Penderita-Laki->5thn-->
							<th>P</th><!--Penderita-Perempuan->5thn-->
							<th>L</th><!--Meninggal-Laki->5thn-->
							<th>P</th><!--Meninggal-Perempuan>5thn-->
							<th>L</th><!--Penderita-Laki-Jumlah-->
							<th>P</th><!--Penderita-Perempuan-Jumlah-->
							<th>L</th><!--Meninggal-Laki-Jumlah-->
							<th>P</th><!--Meninggal-Perempuan-Jumlah-->
							<th>ORL</th>
							<th>ZNC</th>
							<th>RL</th>
							<th>ORL</th>
							<th>ZNC</th>
							<th>RL</th>
							<th>L</th><!--Penderita-Laki-<1thn--><!--kader-->
							<th>P</th><!--Penderita-Perempuan_<1thn-->
							<th>L</th><!--Meninggal-Laki-<1thn-->
							<th>P</th><!--Meninggal-Perempuan<1thn-->
							<th>L</th><!--Penderita-Laki-1-4thn-->
							<th>P</th><!--Penderita-Laki-1-4thn-->
							<th>L</th><!--Meninggal-Laki-1-4thn-->
							<th>P</th><!--Meninggal-Perempuan-1-4thn-->
							<th>L</th><!--Penderita-Laki->5thn-->
							<th>P</th><!--Penderita-Perempuan->5thn-->
							<th>L</th><!--Meninggal-Laki->5thn-->
							<th>P</th><!--Meninggal-Perempuan>5thn-->
							<th>L</th><!--Penderita-Laki-Jumlah-->
							<th>P</th><!--Penderita-Perempuan-Jumlah-->
							<th>L</th><!--Meninggal-Laki-Jumlah-->
							<th>P</th><!--Meninggal-Perempuan-Jumlah-->
							<th>ORL</th>
							<th>ZNC</th>
							<th>RL</th>
							<th>L</th><!--Penderita-Laki-<1thn--><!--total sarana kesehatan & kader-->
							<th>P</th><!--Penderita-Perempuan_<1thn-->
							<th>L</th><!--Meninggal-Laki-<1thn-->
							<th>P</th><!--Meninggal-Perempuan<1thn-->
							<th>ORL</th>
							<th>ZNC</th>
							<th>RL</th>
						</tr>
					</thead>
					<tbody style="font-size: 10px;">
						<?php
						if($opsiform == 'bulan'){
							$waktu = "YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND ";
							$tbdiagnosadiare = 'tbdiagnosadiare';
						}else{
							$waktu = "a.TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2' AND ";
							$tbdiagnosadiare = 'tbdiagnosadiare';
						}
						
						// tbdiagnosadiare
						if($kasus != 'Semua'){
							$qkasus = " AND Kunjungan = '$kasus' ";
						}else{
							$qkasus = " ";
						}
						
						$str_kelurahan = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas' ORDER BY Kelurahan";
						$query_kelurahan = mysqli_query($koneksi,$str_kelurahan);
						while($dtkelurahan = mysqli_fetch_assoc($query_kelurahan)){
							$no = $no + 1;
							$kelurahan = $dtkelurahan['Kelurahan'];
							
							// Sarana Kesehatan
							$data_diare_0_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN `$tbkk` c ON a.NoIndex = c.NoIndex WHERE MONTH(a.TanggalDiagnosa)='$bulan' AND YEAR(a.TanggalDiagnosa)='$tahun' AND (a.KodeDiagnosa = 'A03.0' OR a.KodeDiagnosa = 'A06.0' OR a.KodeDiagnosa = 'A09' OR a.KodeDiagnosa = 'A00.9' OR a.KodeDiagnosa = 'K58.0' OR a.KodeDiagnosa = 'K58.9') AND b.`JenisKelamin` = 'L' AND (b.UmurTahun BETWEEN '0' AND '0') AND c.Kelurahan = '$kelurahan'"));
							$data_diare_0_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN `$tbkk` c ON a.NoIndex = c.NoIndex WHERE MONTH(a.TanggalDiagnosa)='$bulan' AND YEAR(a.TanggalDiagnosa)='$tahun' AND (a.KodeDiagnosa = 'A03.0' OR a.KodeDiagnosa = 'A06.0' OR a.KodeDiagnosa = 'A09' OR a.KodeDiagnosa = 'A00.9' OR a.KodeDiagnosa = 'K58.0' OR a.KodeDiagnosa = 'K58.9') AND b.`JenisKelamin` = 'P' AND (b.UmurTahun BETWEEN '0' AND '0') AND c.Kelurahan = '$kelurahan'"));
							$data_diare_1_4_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN `$tbkk` c ON a.NoIndex = c.NoIndex WHERE MONTH(a.TanggalDiagnosa)='$bulan' AND YEAR(a.TanggalDiagnosa)='$tahun' AND (a.KodeDiagnosa = 'A03.0' OR a.KodeDiagnosa = 'A06.0' OR a.KodeDiagnosa = 'A09' OR a.KodeDiagnosa = 'A00.9' OR a.KodeDiagnosa = 'K58.0' OR a.KodeDiagnosa = 'K58.9') AND b.`JenisKelamin` = 'L' AND (b.UmurTahun BETWEEN '1' AND '4') AND c.Kelurahan = '$kelurahan'"));
							$data_diare_1_4_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN `$tbkk` c ON a.NoIndex = c.NoIndex WHERE MONTH(a.TanggalDiagnosa)='$bulan' AND YEAR(a.TanggalDiagnosa)='$tahun' AND (a.KodeDiagnosa = 'A03.0' OR a.KodeDiagnosa = 'A06.0' OR a.KodeDiagnosa = 'A09' OR a.KodeDiagnosa = 'A00.9' OR a.KodeDiagnosa = 'K58.0' OR a.KodeDiagnosa = 'K58.9') AND b.`JenisKelamin` = 'P' AND (b.UmurTahun BETWEEN '1' AND '4') AND c.Kelurahan = '$kelurahan'"));
							$data_diare_5_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN `$tbkk` c ON a.NoIndex = c.NoIndex WHERE MONTH(a.TanggalDiagnosa)='$bulan' AND YEAR(a.TanggalDiagnosa)='$tahun' AND (a.KodeDiagnosa = 'A03.0' OR a.KodeDiagnosa = 'A06.0' OR a.KodeDiagnosa = 'A09' OR a.KodeDiagnosa = 'A00.9' OR a.KodeDiagnosa = 'K58.0' OR a.KodeDiagnosa = 'K58.9') AND b.`JenisKelamin` = 'L' AND (b.UmurTahun >= '5') AND c.Kelurahan = '$kelurahan'"));
							$data_diare_5_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN `$tbkk` c ON a.NoIndex = c.NoIndex WHERE MONTH(a.TanggalDiagnosa)='$bulan' AND YEAR(a.TanggalDiagnosa)='$tahun' AND (a.KodeDiagnosa = 'A03.0' OR a.KodeDiagnosa = 'A06.0' OR a.KodeDiagnosa = 'A09' OR a.KodeDiagnosa = 'A00.9' OR a.KodeDiagnosa = 'K58.0' OR a.KodeDiagnosa = 'K58.9') AND b.`JenisKelamin` = 'P' AND (b.UmurTahun >= '5') AND c.Kelurahan = '$kelurahan'"));
							$jumlah_sarana_laki =  mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN `$tbkk` c ON a.NoIndex = c.NoIndex WHERE MONTH(a.TanggalDiagnosa)='$bulan' AND YEAR(a.TanggalDiagnosa)='$tahun' AND (a.KodeDiagnosa = 'A03.0' OR a.KodeDiagnosa = 'A06.0' OR a.KodeDiagnosa = 'A09' OR a.KodeDiagnosa = 'A00.9' OR a.KodeDiagnosa = 'K58.0' OR a.KodeDiagnosa = 'K58.9') AND b.`JenisKelamin` = 'L' AND (b.UmurTahun BETWEEN '1' AND '100') AND c.Kelurahan = '$kelurahan'"));
							$jumlah_sarana_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi JOIN `$tbkk` c ON a.NoIndex = c.NoIndex WHERE MONTH(a.TanggalDiagnosa)='$bulan' AND YEAR(a.TanggalDiagnosa)='$tahun' AND (a.KodeDiagnosa = 'A03.0' OR a.KodeDiagnosa = 'A06.0' OR a.KodeDiagnosa = 'A09' OR a.KodeDiagnosa = 'A00.9' OR a.KodeDiagnosa = 'K58.0' OR a.KodeDiagnosa = 'K58.9') AND b.`JenisKelamin` = 'P' AND (b.UmurTahun BETWEEN '1' AND '100') AND c.Kelurahan = '$kelurahan'"));
														
							// $data_diare_0_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '0' AND '0') AND Kelurahan = '$kelurahan' AND Nakes='Sarana Kesehatan'"));
							// $data_diare_0_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '0' AND '0') AND Kelurahan = '$kelurahan' AND Nakes='Sarana Kesehatan'"));
							// $data_diare_1_4_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '1' AND '4') AND Kelurahan = '$kelurahan' AND Nakes='Sarana Kesehatan'"));
							// $data_diare_1_4_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '1' AND '4') AND Kelurahan = '$kelurahan' AND Nakes='Sarana Kesehatan'"));
							// $data_diare_5_Laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun >= '5') AND Kelurahan = '$kelurahan' AND Nakes='Sarana Kesehatan'"));
							// $data_diare_5_Perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun >= '5') AND Kelurahan = '$kelurahan' AND Nakes='Sarana Kesehatan'"));
							// $jumlah_sarana_laki =  mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '1' AND '100') AND Kelurahan = '$kelurahan' AND Nakes='Sarana Kesehatan'"));
							// $jumlah_sarana_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '1' AND '100') AND Kelurahan = '$kelurahan' AND Nakes='Sarana Kesehatan'"));
						
							// Sarana Kesehatan
							$data_diare_0_Laki_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '0' AND '0') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_0_Perempuan_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '0' AND '0') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_1_4_Laki_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '1' AND '4') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_1_4_Perempuan_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '1' AND '4') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_5_Laki_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun >= '5') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$data_diare_5_Perempuan_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun >= '5') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$jumlah_sarana_laki_kdr =  mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'L' AND (UmurTahun BETWEEN '1' AND '100') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
							$jumlah_sarana_perempuan_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Kelamin = 'P' AND (UmurTahun BETWEEN '1' AND '100') AND Kelurahan = '$kelurahan' AND Nakes='Kader'"));
						
							// Total Sarana Kesehatan dan Kader
							$total_p_l = $jumlah_sarana_laki['Jumlah'] + $jumlah_sarana_laki_kdr['Jumlah'];
							$total_p_p = $jumlah_sarana_perempuan['Jumlah'] + $jumlah_sarana_perempuan_kdr['Jumlah'];
							?>
							
							<?php
							// jumlah pemberian
							$str_pemberian = "SELECT TindakanPengobatan FROM `tbdiagnosadiare` WHERE `Kelurahan` = '$kelurahan'";
							$query_pemberian = mysqli_query($koneksi,$str_pemberian);
							
							while($data_pemberian = mysqli_fetch_array($query_pemberian)){
								$array_data[$dtkelurahan['Kelurahan']][] = $data_pemberian['TindakanPengobatan'];
							}

							$data_pmb = implode(",",$array_data[$dtkelurahan['Kelurahan']]);
							$acv = array_count_values(explode(",",$data_pmb));	
								$jmloralit = $acv['Oralit'];
								$jmlzinc = $acv['Zinc'];
								$jmlinfus = $acv['Infus'];
							//echo $data_pmb."<br/>";
							?>
							
							<?php
							// jumlah pemakaian Sarana Kesehatan
							$data_oralit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%oralit%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Sarana Kesehatan'"));
							$data_zink = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%zink%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Sarana Kesehatan'"));
							$data_rl = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%ringer laktat%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Sarana Kesehatan'"));
							if ($data_oralit != ''){
								$oralit = $data_oralit['JumlahObat'];
							}else{
								$oralit = 0;
							}
							
							if ($data_zink != ''){
								$zink = $data_zink['JumlahObat'];
							}else{
								$zink = 0;
							}
							
							if ($data_rl != ''){
								$ringer_laktat = $data_rl['JumlahObat'];
							}else{
								$ringer_laktat = 0;
							}
							
							// jumlah pemakaian kader
							$data_oralit_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%oralit%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
							$data_zink_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%zink%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
							$data_rl_kdr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(tbresepdetail.JumlahObat) AS JumlahObat FROM tbresepdetail join tbgfkstok on tbresepdetail.KodeBarang = tbgfkstok.KodeBarang join tbdiagnosadiare on tbresepdetail.NoResep = tbdiagnosadiare.NoRegistrasi WHERE tbgfkstok.NamaBarang like '%ringer laktat%' and tbdiagnosadiare.kelurahan = '$kelurahan' and Nakes='Kader'"));
							if ($data_oralit_kdr != ''){
								$oralit_kdr = $data_oralit_kdr['JumlahObat'];
							}else{
								$oralit_kdr = 0;
							}
							
							if ($data_zink_kdr != ''){
								$zink_kdr = $data_zink_kdr['JumlahObat'];
							}else{
								$zink_kdr = 0;
							}
							
							if ($data_rl_kdr != ''){
								$ringer_laktat_kdr = $data_rl_kdr['JumlahObat'];
							}else{
								$ringer_laktat_kdr = 0;
							}

							// jumlah pemakaian sarana kesehatan dan kader
							$jml_oralit = $oralit + $oralit_kdr;
							$jml_zinc = $zink + $zink_kdr;
							$jml_ringer_laktat = $ringer_laktat + $ringer_laktat_kdr;
							?>
						
						
							<?php
							// derajat dehidrasi
							$data_dehidrasi_ringan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Tanpa Dehidrasi' AND Kelurahan = '$kelurahan'"));
							$data_dehidrasi_sedang = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Sedang' AND Kelurahan = '$kelurahan'"));
							$data_dehidrasi_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(Klasifikasi)AS Jumlah FROM `tbdiagnosadiare` WHERE MONTH(TanggalRegistrasi)='$bulan' AND YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(NoRegistrasi, 1, 11) = '$kodepuskesmas' AND Klasifikasi = 'Berat' AND Kelurahan = '$kelurahan'"));
							?>
						
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $dtkelurahan['Kelurahan'];?></td>
								<!--sarana kesehatan-->
								<td><?php echo $data_diare_0_Laki['Jumlah'];?></td><!--Penderita-Laki-<1thn--><!--sarana kesehatan-->
								<td><?php echo $data_diare_0_Perempuan['Jumlah'];?></td>
								<td><?php echo '-';?></td><!--Meninggal-Laki-<1thn-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan<1thn-->
								<td><?php echo $data_diare_1_4_Laki['Jumlah'];?></td>
								<td><?php echo $data_diare_1_4_Perempuan['Jumlah'];?></td>
								<td><?php echo '-';?></td><!--Meninggal-Laki-1-4thn-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan-1-4thn-->
								<td><?php echo $data_diare_5_Laki['Jumlah'];?></td><!--Penderita-Laki->5thn-->
								<td><?php echo $data_diare_5_Perempuan['Jumlah'];?></td><!--Penderita-Perempuan->5thn-->
								<td><?php echo '-';?></td><!--Meninggal-Laki->5thn-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan>5thn-->
								<td><?php echo $jumlah_sarana_laki['Jumlah'];?></td><!--Penderita-Laki-Jumlah-->
								<td><?php echo $jumlah_sarana_perempuan['Jumlah'];?></td><!--Penderita-Perempuan-Jumlah-->
								<td><?php echo '-';?></td><!--Meninggal-Laki-Jumlah-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan-Jumlah-->
								<!--jumlahpenderita-->
								<td><?php echo round($jmloralit,0);?></td><!--Oralit--><!--jumlah pemberian-->
								<td><?php echo round($jmlzinc,0);?></td><!--Zinc-->
								<td><?php echo round($jmlinfus,0);?></td><!--RL-->
								<!--jumlahpemakaian-->
								<td><?php echo round($oralit,0);?></td><!--Oralit--><!--jumlah pemakaian-->
								<td><?php echo round($zink,0);?></td><!--Zink-->
								<td><?php echo round($ringer_laktat,0);?></td><!--RL-->
								<!--kader-->
								<td><?php echo $data_diare_0_Laki_kdr['Jumlah'];?></td><!--Penderita-Laki-<1thn--><!--kader-->
								<td><?php echo $data_diare_0_Perempuan_kdr['Jumlah'];?></td><!--Penderita-Perempuan_<1thn-->
								<td><?php echo '-';?></td><!--Meninggal-Laki-<1thn-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan<1thn-->
								<td><?php echo $data_diare_1_4_Laki_kdr['Jumlah'];?></td><!--Penderita-Laki-1-4thn-->
								<td><?php echo $data_diare_1_4_Perempuan_kdr['Jumlah'];?></td><!--Penderita-Perempuan-1-4thn-->
								<td><?php echo '-';?></td><!--Meninggal-Laki-1-4thn-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan-1-4thn-->
								<td><?php echo $data_diare_5_Laki_kdr['Jumlah'];?></td><!--Penderita-Laki->5thn-->
								<td><?php echo $data_diare_5_Perempuan_kdr['Jumlah'];?></td><!--Penderita-Perempuan->5thn-->
								<td><?php echo '-';?></td><!--Meninggal-Laki->5thn-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan>5thn-->
								<td><?php echo $jumlah_sarana_laki_kdr['Jumlah'];?></td><!--Penderita-Laki-Jumlah-->
								<td><?php echo $jumlah_sarana_perempuan_kdr['Jumlah'];?></td><!--Penderita-Perempuan-Jumlah-->
								<td><?php echo '-';?></td><!--Meninggal-Laki-Jumlah-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan-Jumlah-->
								<!--jumlahpemakaian-->
								<td><?php echo round($oralit_kdr,0);?></td><!--Oralit-->
								<td><?php echo round($zink_kdr,0);?></td><!--Zinc-->
								<td><?php echo round($ringer_laktat_kdr,0);?></td><!--RL-->
								<!--total sarana dan kader-->
								<td><?php echo $total_p_l;?></td><!--Penderita-Laki-<1thn--><!--total sarana kesehatan & kader-->
								<td><?php echo $total_p_p?></td><!--Penderita-Perempuan_<1thn-->
								<td><?php echo '-';?></td><!--Meninggal-Laki-<1thn-->
								<td><?php echo '-';?></td><!--Meninggal-Perempuan<1thn-->
								<td><?php echo round($jml_oralit,0);?></td><!--Oralit-->
								<td><?php echo round($jml_zinc,0);?></td><!--Zinc-->
								<td><?php echo round($jml_ringer_laktat,0);?></td><!--RL-->
								<!--derajat dehidrasi-->
								<td><?php echo $data_dehidrasi_ringan['Jumlah'];?></td><!--Tanpa Dehidrasi--><!--derajat dehidrasi-->
								<td><?php echo $data_dehidrasi_sedang['Jumlah'];?></td><!--Ringan/Sedang-->
								<td><?php echo $data_dehidrasi_berat['Jumlah'];?></td><!--Dehidrasi Berat-->
								<!--lab-->
								<td><?php echo '-';?></td><!--Jumlah Spesimen--><!--pemeriksaan lab-->
								<td><?php echo '-';?></td><!--POS-->
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<?php
	}
	?>

	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Kategori Kode Penyakit :</b> A03.0, A06.0, A09, A00.9, K58.0, K58.9<br>
				Kelurahan dambil berdasar kasus/kejadian.</p>
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
</script>