<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN & RUJUKAN RAWAT JALAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_carabayar_rujukan"/>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
								for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-10">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_carabayar_rujukan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_loket_carabayar_rujukan_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
	
	<?php
	$tahun = $_GET['tahun'];

	if (isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>KUNJUNGAN & RUJUKAN RAWAT JALAN</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo "Tahun ".$_GET['tahun'];?></span>
		<br/>
	</div>

	<div class="atastabel font12">
		<div style="float:left; width:35%; margin-bottom:10px;">	
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
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="4" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="4" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">BULAN</th>
							<th colspan="11" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">KUNJUNGAN PASIEN</th>
							<th colspan="5" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">RUJUKAN PASIEN</th>
							<th rowspan="4" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">KUNJUNGAN SEHAT</th>
						</tr>
						<tr>
							<th colspan="4" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BPJS</th>
							<th rowspan="2" colspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">UMUM</th>
							<th rowspan="2" colspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">GRATIS / SKTM</th>
							<th rowspan="2" colspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">PBI</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">NON PBI</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">UMUM</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">KTP/SKTM</th>
							<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
						</tr>
						<tr>
							<th colspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">PBI</th>
							<th colspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">NON PBI</th>
						</tr>
						<tr>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BARU</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">LAMA</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BARU</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">LAMA</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BARU</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">LAMA</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BARU</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">LAMA</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BARU</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">LAMA</th>
						</tr>
					</thead>
					<tbody>
						<?php					
						$tahuns = $_GET['tahun'];
						$array_bulan = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05','Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
						$no = 1;
						
						foreach($array_bulan as $namebulan => $nobulan ){
							$bpjs_pbi_baru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND StatusKunjungan = 'Baru'"))['jml'];
							$bpjs_pbi_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND StatusKunjungan = 'Lama'"))['jml'];
							$bpjs_nonpbi_baru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND StatusKunjungan = 'Baru'"))['jml'];
							$bpjs_nonpbi_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND StatusKunjungan = 'Lama'"))['jml'];
							$umum_baru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND StatusKunjungan = 'Baru'"))['jml'];
							$umum_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND StatusKunjungan = 'Lama'"))['jml'];
							$ktp_baru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND StatusKunjungan = 'Baru'"))['jml'];
							$ktp_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND StatusKunjungan = 'Lama'"))['jml'];
							$jumlah_baru = $bpjs_pbi_baru + $bpjs_nonpbi_baru + $umum_baru + $ktp_baru;
							$jumlah_lama = $bpjs_pbi_lama + $bpjs_nonpbi_lama + $umum_lama + $ktp_lama;
							$jumlah_total = $jumlah_baru + $jumlah_lama;
							$rujukan_pbi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND `StatusPulang`='4'"))['jml'];
							$rujukan_nonpbi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND `StatusPulang`='4'"))['jml'];
							$rujukan_umum = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND `StatusPulang`='4'"))['jml'];
							$rujukan_ktp = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND `StatusPulang`='4'"))['jml'];
							$rujukan_jumlah = $rujukan_pbi + $rujukan_nonpbi + $rujukan_umum + $rujukan_ktp;
							$kunjungan_sehat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND StatusPasien='2'"))['jml'];
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namebulan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi_baru;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi_lama;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_nonpbi_baru;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $bpjs_nonpbi_lama;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umum_baru;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umum_lama;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $ktp_baru;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $ktp_lama;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jumlah_baru;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jumlah_lama;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jumlah_total;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $rujukan_pbi;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $rujukan_nonpbi;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $rujukan_umum;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $rujukan_ktp;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $rujukan_jumlah;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_sehat;?></td>
							</tr>
						<?php
						$no = $no + 1;	
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="bawahtabel font12">
		<table width="100%">
			<tr>
				<td></td>
				<td></td>
				<td style="text-align:center;">
					<br>
					DIBUAT OLEH
					<br>
					<br>
					<br>
					<br>
					(..........................................................................)
				</td>
				<td style="text-align:center;">
					<?php echo $_SESSION['kota'].", ".date('d-m-Y');?><br/>
					KEPALA PUSKESMAS
					<br>
					<br>
					<br>
					<br>
					(..........................................................................)
				</td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
	<?php
	}
	?>
</div>	



