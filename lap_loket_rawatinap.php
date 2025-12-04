<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN RAWAT INAP</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_rawatinap"/>
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
							<a href="?page=lap_loket_rawatinap" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_rawatinap_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>	
				</form>
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
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>PELAYANAN RAWAT INAP</b></span><br>
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
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">BULAN</th>
							<th colspan="4" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH KUNJUNGAN</th>
							<th colspan="4" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH PASIEN DIRUJUK</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH HARI PERAWATAN</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BOR</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">LOS</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">TOI</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BTO</th>
						</tr>
						<tr>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">UMUM</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BPJS</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">KTP/SKTM</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">UMUM</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">BPJS</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">KTP/SKTM</th>
							<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
						</tr>
					</thead>
					<tbody>
						<?php					
						$tahuns = $_GET['tahun'];
						$array_bulan = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05','Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
						$no = 1;
						
						foreach($array_bulan as $namebulan => $nobulan ){
							$kunjungan_umum = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND Asuransi='UMUM' AND StatusPasien = '2'"))['jml'];
							$kunjungan_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND Asuransi like '%BPJS%' AND StatusPasien = '2'"))['jml'];
							$kunjungan_sktm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND (Asuransi='SKTM' OR Asuransi='GRATIS') AND StatusPasien = '2'"))['jml'];
							$kunjungan_jumlah = $kunjungan_umum + $kunjungan_bpjs + $kunjungan_sktm;
							$kunjungan_rujuk_umum = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND Asuransi='UMUM' AND StatusPasien = '2' AND `StatusPulang`='4'"))['jml'];
							$kunjungan_rujuk_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND Asuransi like '%BPJS%' AND StatusPasien = '2' AND `StatusPulang`='4'"))['jml'];
							$kunjungan_rujuk_sktm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi) as jml FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$nobulan' AND YEAR(TanggalRegistrasi) = '$tahuns' AND (Asuransi='SKTM' OR Asuransi='GRATIS') AND StatusPasien = '2' AND `StatusPulang`='4'"))['jml'];
							$kunjungan_rujuk_jumlah = $kunjungan_rujuk_umum + $kunjungan_rujuk_bpjs + $kunjungan_rujuk_sktm;
							?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namebulan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_umum;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_bpjs;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_sktm;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_jumlah;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_rujuk_umum;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_rujuk_bpjs;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_rujuk_sktm;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $kunjungan_rujuk_jumlah;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>
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



