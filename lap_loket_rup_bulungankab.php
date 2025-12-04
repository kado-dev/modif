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
			<h3 class="judul"><b>RUP UMUM</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_loket_rup_bulungankab"/>
						<div class="col-sm-2">
							<div>
								<input type="text" name="keydate" class="form-control datepicker2" placeholder = "Pilih Tanggal" value="<?php echo $_GET['keydate'];?>" required>
							</div>
						</div>
						<div class="col-sm-2">
							<select name="pelayanankes" class="form-control asuransi" required>
								<option value=''>Semua</option>
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
								<option value='Semua'>Semua</option>
								<option value='Baru'>Baru</option>
								<option value='Lama'>Lama</option>
							</select>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rup_bulungankab" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
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

	if(isset($keydate) AND isset($pelayanankes)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "UPT. PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>REGISTRASI UMUM PUSKESMAS (RUP)</b></span><br>
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
							<th rowspan="3" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
							<th rowspan="3" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.RM</th>
							<th colspan="18" width="25%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kunjungan Menurut Kelompok Umur</th>
							<th colspan="10" width="25%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Status Bayar</th>
							<th rowspan="3" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan</th>
							<th colspan="8" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Kunjungan</th>
							<th rowspan="3" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Paham</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">0-7Hr</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">8-28Hr</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">1-11Bl</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">1-4Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">5-14Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">15-44Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">45-54Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">55-64Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">>65Th</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Bayar</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Gratis</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Siswa</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kader</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Lainnya</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Baru</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Lama</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Dalam</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Luar</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--0-7Hr-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--8-28Hr-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--1-11Bl-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--1-4Th-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--5-14Th-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--15-44Th-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--45-54Th-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--55-64Th-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--65-100Th-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--Bayar-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--Gratis-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--Siswa-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--Kader-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--Lainnya-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--Jenis Kunjungan-->
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
						
						if($pelayanankes != ''){
							$pelayanan = $pelayanankes;
						}else{
							$pelayanan = '';
						}
						
						if($kunjungans == 'Semua'){
							$skunjungan = '';
						}else{
							$skunjungan = " AND `StatusKunjungan`='$kunjungans'";
						}
						
						if ($pelayanan == 'POLI IMUNISASI'){
							$str = "select * FROM `tbrujukinternal` a 
							JOIN `$tbpasienrj` b ON a.NoRujukan = b.NoRegistrasi 
							WHERE a.TanggalRujukan ='$keydate' AND a.PoliRujukan = 'POLI IMUNISASI' AND SUBSTRING(b.Asuransi,1,4) <> 'BPJS'";
							$str2 = $str." ORDER BY b.`NamaPasien` limit $mulai,$jumlah_perpage";
						}elseif($pelayanan == 'POLI ANAK'){
							$str = "select * FROM `tbrujukinternal` a 
							JOIN `$tbpasienrj` b ON a.NoRujukan = b.NoRegistrasi 
							WHERE a.TanggalRujukan ='$keydate' AND a.PoliRujukan = 'POLI ANAK' AND SUBSTRING(b.Asuransi,1,4) <> 'BPJS'";
							$str2 = $str." ORDER BY b.`NamaPasien` limit $mulai,$jumlah_perpage";
						}else{
							$str = "SELECT * FROM `$tbpasienrj`
							WHERE SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND `TanggalRegistrasi` = '$keydate' AND
							`PoliPertama`='$pelayanan' AND SUBSTRING(Asuransi,1,4) <> 'BPJS'".$skunjungan;
							$str2 = $str." ORDER BY `NamaPasien` limit $mulai,$jumlah_perpage";
						}					
						
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
							
							// tbpasien
							$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpasien` WHERE `NoCM`='$nocm'"));						
							$normpasien = substr($dt_pasien['NoRM'],-6);
							
												
							// umur
							$umur0_7L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurHari` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND `UmurBulan` = '0' AND UmurHari BETWEEN '0' AND '7' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur0_7P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurHari` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND `UmurBulan` = '0' AND UmurHari BETWEEN '0' AND '7' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur8_28L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurHari` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND `UmurBulan` = '0' AND UmurHari BETWEEN '8' AND '28' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur8_28P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurHari` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND `UmurBulan` = '0' AND UmurHari BETWEEN '8' AND '28' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur1_11L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurBulan` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND `UmurBulan` BETWEEN '1' AND '11' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur1_11P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurBulan` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` = '0' AND `UmurBulan` BETWEEN '1' AND '11' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur1_4L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '1' AND '4' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur1_4P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '1' AND '4' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur5_14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '5' AND '14' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur11_14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '5' AND '14' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur15_44L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '15' AND '44' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur15_44P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '15' AND '44' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur45_54L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '45' AND '54' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur45_54P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '45' AND '54' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur55_64L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '55' AND '64' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur55_64P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '55' AND '64' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							$umur65_100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '65' AND '100' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							$umur65_100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `UmurTahun` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `UmurTahun` BETWEEN '65' AND '100' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
						
							// status bayar
							$bayar_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'UMUM' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							if ($bayar_l['Jml'] == 'UMUM'){
								$umum_lk = '<span class="fa fa-check"></span>';
							}else{
								$umum_lk = '-';
							}
							$bayar_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'UMUM' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							if ($bayar_p['Jml'] == 'UMUM'){
								$umum_pr = '<span class="fa fa-check"></span>';
							}else{
								$umum_pr = '-';
							}
							$gratis_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'GRATIS' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							if ($gratis_l['Jml'] == 'GRATIS'){
								$gratis_lk = '<span class="fa fa-check"></span>';
							}else{
								$gratis_lk = '-';
							}
							$gratis_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'GRATIS' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							if ($gratis_p['Jml'] == 'GRATIS'){
								$gratis_pr = '<span class="fa fa-check"></span>';
							}else{
								$gratis_pr = '-';
							}
							$gratis_siwa_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'SISWA' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							if ($gratis_siwa_l['Jml'] == 'SISWA'){
								$gratis_siswa_lk = '<span class="fa fa-check"></span>';
							}else{
								$gratis_siswa_lk = '-';
							}
							$gratis_siwa_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'SISWA' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							if ($gratis_siwa_p['Jml'] == 'SISWA'){
								$gratis_siswa_pr = '<span class="fa fa-check"></span>';
							}else{
								$gratis_siswa_pr = '-';
							}
							$gratis_kader_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'KADER' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							if ($gratis_kader_l['Jml'] == 'KADER'){
								$gratis_kader_lk = '<span class="fa fa-check"></span>';
							}else{
								$gratis_kader_lk = '-';
							}
							$gratis_kader_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'KADER' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							if ($gratis_kader_p['Jml'] == 'KADER'){
								$gratis_kader_pr = '<span class="fa fa-check"></span>';
							}else{
								$gratis_kader_pr = '-';
							}
							$gratis_lainnya_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'LAINNYA' AND JenisKelamin = 'L' AND `NoRegistrasi`='$noregistrasi'"));
							if ($gratis_lainnya_l['Jml'] == 'LAINNYA'){
								$gratis_lainnya_lk = '<span class="fa fa-check"></span>';
							}else{
								$gratis_lainnya_lk = '-';
							}
							$gratis_lainnya_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Asuransi` AS Jml FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$keydate' AND `Asuransi` = 'LAINNYA' AND JenisKelamin = 'P' AND `NoRegistrasi`='$noregistrasi'"));
							if ($gratis_lainnya_p['Jml'] == 'LAINNYA'){
								$gratis_lainnya_pr = '<span class="fa fa-check"></span>';
							}else{
								$gratis_lainnya_pr = '-';
							}
							
							// jenis kunjungan
							$baru_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `StatusKunjungan`='Baru' AND `JenisKelamin`='L' AND `NoRegistrasi`='$noregistrasi'"));
							if ($baru_l['StatusKunjungan'] == 'Baru'){
								$baru_lk = '<span class="fa fa-check"></span>';
							}else{
								$baru_lk = '-';
							}
							$baru_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `StatusKunjungan`='Baru' AND `JenisKelamin`='P' AND `NoRegistrasi`='$noregistrasi'"));
							if ($baru_p['StatusKunjungan'] == 'Baru'){
								$baru_pr = '<span class="fa fa-check"></span>';
							}else{
								$baru_pr = '-';
							}
							$lama_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `StatusKunjungan`='Lama' AND `JenisKelamin`='L' AND `NoRegistrasi`='$noregistrasi'"));
							if ($lama_l['StatusKunjungan'] == 'Lama'){
								$lama_lk = '<span class="fa fa-check"></span>';
							}else{
								$lama_lk = '-';
							}
							$lama_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StatusKunjungan` FROM `$tbpasienrj` WHERE `StatusKunjungan`='Lama' AND `JenisKelamin`='P' AND `NoRegistrasi`='$noregistrasi'"));
							if ($lama_p['StatusKunjungan'] == 'Lama'){
								$lama_pr = '<span class="fa fa-check"></span>';
							}else{
								$lama_pr = '-';
							}
							$dalam_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT b.Wilayah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex=b.NoIndex WHERE a.`JenisKelamin`='L' AND b.Wilayah='Dalam' AND a.`NoRegistrasi`='$noregistrasi'"));
							if ($dalam_l['Wilayah'] == 'Dalam'){
								$dalam_lk = '<span class="fa fa-check"></span>';
							}else{
								$dalam_lk = '-';
							}
							$dalam_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT b.Wilayah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex=b.NoIndex WHERE a.`JenisKelamin`='P' AND b.Wilayah='Dalam' AND a.`NoRegistrasi`='$noregistrasi'"));
							if ($dalam_p['Wilayah'] == 'Dalam'){
								$dalam_pr = '<span class="fa fa-check"></span>';
							}else{
								$dalam_pr = '-';
							}
							$luar_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT b.Wilayah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex=b.NoIndex WHERE a.`JenisKelamin`='L' AND b.Wilayah='Luar' AND a.`NoRegistrasi`='$noregistrasi'"));
							if ($luar_l['Wilayah'] == 'Luar'){
								$luar_lk = '<span class="fa fa-check"></span>';
							}else{
								$luar_lk = '-';
							}
							$luar_p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT b.Wilayah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex=b.NoIndex WHERE a.`JenisKelamin`='P' AND b.Wilayah='Luar' AND a.`NoRegistrasi`='$noregistrasi'"));
							if ($luar_p['Wilayah'] == 'Luar'){
								$luar_pr = '<span class="fa fa-check"></span>';
							}else{
								$luar_pr = '-';
							}
							
						?>
						<tr style="border:1px solid #000;">
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaPasien']);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $normpasien;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur0_7L['Jml'];?></td><!--0_7_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur0_7P['Jml'];?></td><!--0_7_P-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur8_28L['Jml'];?></td><!--8_28_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur8_28P['Jml'];?></td><!--8_28_P-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1_11L['Jml'];?></td><!--1_11_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1_11P['Jml'];?></td><!--1_11_P-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1_4L['Jml'];?></td><!--1_4_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1_4P['Jml'];?></td><!--1_4_P-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5_14L['Jml'];?></td><!--5_14_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur11_14P['Jml'];?></td><!--5_14_P-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur15_44L['Jml'];?></td><!--15_44_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur15_44P['Jml'];?></td><!--15_44_P-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur45_54L['Jml'];?></td><!--45_54_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur45_54P['Jml'];?></td><!--45_54_P-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur55_64L['Jml'];?></td><!--55_64_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur55_64P['Jml'];?></td><!--55_64_P-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur65_100L['Jml'];?></td><!--65_100_L-->
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur65_100P['Jml'];?></td><!--65_100_P-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umum_lk;?></td><!--umum_l-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umum_pr;?></td><!--umum_p-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_lk;?></td><!--gratis_siswa_L-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_pr;?></td><!--gratis_siswa_P-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_siswa_lk;?></td><!--gratis_siswa_L-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_siswa_pr;?></td><!--gratis_siswa_P-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_kader_lk;?></td><!--gratis_kader_L-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_kader_pr;?></td><!--gratis_kader_P-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_lainnya_lk;?></td><!--gratis_lainnya_L-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis_lainnya_pr;?></td><!--gratis_lainnya_P-->
							<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($pelayanan == 'POLI IMUNISASI'){
									echo "POLI IMUNISASI";
								}elseif($pelayanan == 'POLI ANAK'){
									echo "POLI ANAK";
								}else{
									echo $data['PoliPertama'];
								}
							?>
							</td><!--pelayanan-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $baru_lk;?></td><!--kunjungan-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $baru_pr;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $lama_lk;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $lama_pr;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dalam_lk;?></td><!--wilayah-->
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dalam_pr;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $luar_lk;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $luar_pr;?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"></td><!--paham-->
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
						echo "<li><a href='?page=lap_loket_rup_bulungankab&keydate=$keydate&pelayanankes=$pelayanankes&kunjungans=$kunjungans&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	