<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>RUP JKN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_loket_rup_jkn_bulungankab"/>
						<div class="col-sm-2">
							<div>
								<input type="text" name="keydate" class="form-control datepicker2" placeholder = "Pilih Tanggal" value="<?php echo $_GET['keydate'];?>" required>
							</div>
						</div>
						<div class="col-sm-2">
							<select name="pelayanankes" class="form-control asuransi" required>
								<option value='Semua'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE `JenisPelayanan` = 'KUNJUNGAN SAKIT' order by `Pelayanan` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['pelayanankes'] == $data['Pelayanan']){
											echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
										}else{
											echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="kunjungans" class="form-control" required>
								<option value='Semua' <?php if($_GET['kunjungans'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value='Baru' <?php if($_GET['kunjungans'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value='Lama' <?php if($_GET['kunjungans'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rup_jkn_bulungankab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_loket_rup_jkn_bulungankab_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate=<?php echo $_GET['keydate'];?>&pel=<?php echo $_GET['pelayanankes'];?>&kunj=<?php echo $_GET['kunjungans'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

<?php
$keydate = $_GET['keydate'];
$pelayanankes = $_GET['pelayanankes'];
$kunjungans = $_GET['kunjungans'];
$tbpasienrj = 'tbpasienrj_'.substr($keydate,5,2);
if(isset($keydate) AND isset($pelayanankes)){
?>

<div class="printheader">
	<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI UMUM PUSKESMAS (RUP - JKN)</b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($_GET['keydate']));?></span>
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
	<!--tabel view-->
	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive font10">
				<table class="table-judul-laporan-min">
					<thead style="font-size:9px;">
						<tr style="border:1px solid #000;">
							<th rowspan="4" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="4" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.RM</th>
							<th rowspan="4" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
							<th rowspan="4" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Noka.Peserta</th>
							<th colspan="14" width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
							<th rowspan="4" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Diagnosa</th>
							<th colspan="12" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Kunjungan JKN</th>
							<th rowspan="4" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Poli</th>
							<th rowspan="4" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Rujuk</th>
							<th rowspan="4" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Wilayah</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;"><1Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">1-4Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">5-14Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">15-44Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">45-54Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">55-64Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">>65Th</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pbi APBN</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pbi APBD</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Non Pbi</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--1Th-->
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--1-4Th-->
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--5-14Th-->
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--15-44Th-->
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--45-54Th-->
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--55-64Th-->
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--diatas 65Th-->
							<th rowspan="2" style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px;">Baru</th><!--Kunjungan-->
							<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px;">Lama</th>
							<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px;">Baru</th>
							<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px;">Lama</th>
							<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px;">Baru</th>
							<th colspan="2" style="text-align:center; border:1px solid #000; padding:3px;">Lama</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--Kunjungan-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
						</tr>
					</thead>
					<tbody style="font-size:9px;">
						<?php
						$jumlah_perpage = 20;
				
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($pelayanankes == 'Semua'){
							$pelayanan = '';
							
						}else{
							$pelayanan = " AND `PoliPertama`='$pelayanankes'";
						}
											
						if($kunjungans == 'Semua'){
							$skunjungan = '';
						}else{
							$skunjungan = " AND `StatusKunjungan`='$kunjungans'";
						}
						
						// tbpasienrj_bulan
						$str = "SELECT * FROM `$tbpasienrj`
						WHERE `TanggalRegistrasi` = '$keydate' AND SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND
						SUBSTRING(Asuransi,1,4) = 'BPJS'".$pelayanan.$skunjungan;
						$str2 = $str." ORDER BY `TanggalRegistrasi` Desc limit $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$noregistrasi = $data['NoRegistrasi'];
							$nocm = $data['NoCM'];
							$noindex = $data['NoIndex'];
							
							// tbpasien
							$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpasien` WHERE `NoCM`='$nocm'"));
							$normpasien = substr($dt_pasien['NoRM'],-6);							
												
							// umur
							$umur_1L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurBulan` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur_1P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurBulan` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur1_4L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '1' AND '4' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur1_4P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '1' AND '4' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur5_14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '5' AND '14' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur5_14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '5' AND '14' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur15_44L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '15' AND '44' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur15_44P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '15' AND '44' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur45_54L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '45' AND '54' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur45_54P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '45' AND '54' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur55_64L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '55' AND '64' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur55_64P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '55' AND '64' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur55_65L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` > '64' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur55_65P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` > '64' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
						
							// kunjungan BPJS PBIP
							$kunjungan_pbiapbn_br_lk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'L' AND `Asuransi`='BPJS PBIP' AND `StatusKunjungan`='Baru'"));
							if ($kunjungan_pbiapbn_br_lk['StatusKunjungan'] == 'Baru'){
								$kunjungan_pbiapbn_b_l = 'Y';
							}else{
								$kunjungan_pbiapbn_b_l = '-';
							}
							
							$kunjungan_pbiapbn_br_pr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'P' AND `Asuransi`='BPJS PBIP' AND `StatusKunjungan`='Baru'"));
							if ($kunjungan_pbiapbn_br_pr['StatusKunjungan'] == 'Baru'){
								$kunjungan_pbiapbn_b_p = 'Y';
							}else{
								$kunjungan_pbiapbn_b_p = '-';
							}
							
							$kunjungan_pbiapbn_lm_lk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'L' AND `Asuransi`='BPJS PBIP' AND `StatusKunjungan`='Lama'"));
							if ($kunjungan_pbiapbn_lm_lk['StatusKunjungan'] == 'Lama'){
								$kunjungan_pbiapbn_l_l = 'Y';
							}else{
								$kunjungan_pbiapbn_l_l = '-';
							}
							
							$kunjungan_pbiapbn_lm_pr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'P' AND `Asuransi`='BPJS PBIP' AND `StatusKunjungan`='Lama'"));
							if ($kunjungan_pbiapbn_lm_pr['StatusKunjungan'] == 'Lama'){
								$kunjungan_pbiapbn_l_p = 'Y';
							}else{
								$kunjungan_pbiapbn_l_p = '-';
							}
							
							// kunjungan BPJS PBID
							$kunjungan_pbiapbd_br_lk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'L' AND `Asuransi`='BPJS PBID' AND `StatusKunjungan`='Baru'"));
							if ($kunjungan_pbiapbd_br_lk['StatusKunjungan'] == 'Baru'){
								$kunjungan_pbiapbd_b_l = 'Y';
							}else{
								$kunjungan_pbiapbd_b_l = '-';
							}
							
							$kunjungan_pbiapbd_br_pr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'P' AND `Asuransi`='BPJS PBID' AND `StatusKunjungan`='Baru'"));
							if ($kunjungan_pbiapbd_br_pr['StatusKunjungan'] == 'Baru'){
								$kunjungan_pbiapbd_b_p = 'Y';
							}else{
								$kunjungan_pbiapbd_b_p = '-';
							}
							
							$kunjungan_pbiapbd_lm_lk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'L' AND `Asuransi`='BPJS PBID' AND `StatusKunjungan`='Lama'"));
							if ($kunjungan_pbiapbd_lm_lk['StatusKunjungan'] == 'Lama'){
								$kunjungan_pbiapbd_l_l = 'Y';
							}else{
								$kunjungan_pbiapbd_l_l = '-';
							}
							
							$kunjungan_pbiapbd_lm_pr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'P' AND `Asuransi`='BPJS PBID' AND `StatusKunjungan`='Lama'"));
							if ($kunjungan_pbiapbd_lm_pr['StatusKunjungan'] == 'Lama'){
								$kunjungan_pbiapbd_l_p = 'Y';
							}else{
								$kunjungan_pbiapbd_l_p = '-';
							}
							
							// kunjungan NON PBI / BPJS MANDIRI
							$kunjungan_mandiri_br_lk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'L' AND (`Asuransi`='BPJS MANDIRI' OR `Asuransi`='BPJS NON PBI') AND `StatusKunjungan`='Baru'"));
							if ($kunjungan_mandiri_br_lk['StatusKunjungan'] == 'Baru'){
								$kunjungan_mandiri_b_l = 'Y';
							}else{
								$kunjungan_mandiri_b_l = '-';
							}
							
							$kunjungan_mandiri_br_pr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'P' AND (`Asuransi`='BPJS MANDIRI' OR `Asuransi`='BPJS NON PBI') AND `StatusKunjungan`='Baru'"));
							if ($kunjungan_mandiri_br_pr['StatusKunjungan'] == 'Baru'){
								$kunjungan_mandiri_b_p = 'Y';
							}else{
								$kunjungan_mandiri_b_p = '-';
							}
							
							$kunjungan_mandiri_lm_lk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'L' AND (`Asuransi`='BPJS MANDIRI' OR `Asuransi`='BPJS NON PBI') AND `StatusKunjungan`='Lama'"));
							if ($kunjungan_mandiri_lm_lk['StatusKunjungan'] == 'Lama'){
								$kunjungan_mandiri_l_l = 'Y';
							}else{
								$kunjungan_mandiri_l_l = '-';
							}
							
							$kunjungan_mandiri_lm_pr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi' AND `JenisKelamin` = 'P' AND (`Asuransi`='BPJS MANDIRI' OR `Asuransi`='BPJS NON PBI') AND `StatusKunjungan`='Lama'"));
							if ($kunjungan_mandiri_lm_pr['StatusKunjungan'] == 'Lama'){
								$kunjungan_mandiri_l_p = 'Y';
							}else{
								$kunjungan_mandiri_l_p = '-';
							}
							
							// ttv
							if($data['PoliPertama'] == 'POLI UMUM'){
								$bln = substr($noregistrasi,14,2);
								$tbpoliumum = 'tbpoliumum_'.$bln;
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoliumum` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI ANAK'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolianak` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI GIGI'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpoligigi` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI KB'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikb` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI KIA'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikia` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI IMUNISASI'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpoliimunisasi` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI LANSIA'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI MTBS'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolimtbs` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI MTBM'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolimtbm` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI TB'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolitb` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}else if($data['PoliPertama'] == 'POLI UGD'){
								$dt_poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan`='$noregistrasi'"));
							}
							
							// rujukan
							$rujuk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StatusPulang` FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `NoRegistrasi`='$noregistrasi'"));
							if($rujuk['StatusPulang'] == '3'){
								$statusrujuk = '-';
							}else{
								$statusrujuk = 'Y';
							}	

							// wilayah
							$wilayah = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Wilayah` FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
							if($wilayah['Wilayah'] == 'Dalam'){
								$statuswilayah = 'Dalam';
							}else{
								$statuswilayah = 'Luar';
							}							
							
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $normpasien;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['nokartu'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur1_1L['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur1_1P['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur1_4L['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur1_4P['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur5_14L['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur5_14P['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur15_44L['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur15_44P['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur45_54L['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur45_54P['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur55_64L['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur55_64P['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur55_65L['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur55_65P['Jml'];?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php if($dt_poli['Diagnosa'] != ''){echo $dt_poli['Diagnosa'];}else{echo '-';}?></td><!--diagnosa-->
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_pbiapbn_b_l;?></td><!--kunjungan-->
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_pbiapbn_b_p;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_pbiapbn_l_l;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_pbiapbn_l_p;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_pbiapbd_b_l;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_pbiapbd_b_p;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_pbiapbd_l_l;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_pbiapbd_l_p;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_mandiri_b_l;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_mandiri_b_p;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_mandiri_l_l;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kunjungan_mandiri_l_p;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['PoliPertama'];?></td><!--poli-->
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $statusrujuk;?></td><!--rujukan-->
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $statuswilayah?></td><!--wilayah-->
							<!--<td style="text-align:left; border:1px solid #000; padding:3px;"><?php ?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $mandiris_l;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $mandiris_p;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pnss_l;?></td></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pnss_p;?></td></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pbips_l;?></td></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pbips_p;?></td></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pbids_l;?></td></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pbids_p;?></td></td>-->
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
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
						echo "<li><a href='?page=lap_loket_rup_jkn_bulungankab&keydate=$keydate&pelayanankes=$pelayanankes&kunjungans=$kunjungans&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	