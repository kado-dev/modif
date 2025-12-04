<?php
	include "otoritas.php";
	include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PELAYANAN KESEHATAN KELUARGA MISKIN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_keluarga_miskin"/>
						<div class="col-xl-2 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_registrasi_kunjungan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>	
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	if(isset($tahun)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>PELAYANAN KESEHATAN KELUARGA MISKIN</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
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
			<div class="table-responsive ">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Kelurahan / Desa</th>
							<th colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Penduduk Miskin</th>
							<th colspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Cakupan Pelayanan Kesehatan Bagi Penduduk Miskin</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="15%" style="text-align:center;border:1px solid #000; padding:3px;">KK</th>
							<th width="15%" style="text-align:center;border:1px solid #000; padding:3px;">Jiwa</th>
							<th width="15%" style="text-align:center;border:1px solid #000; padding:3px;">Jumlah</th>
							<th width="15%" style="text-align:center;border:1px solid #000; padding:3px;">%</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$no = 0;
						$str_puskesmas = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$_SESSION[kodepuskesmas]'";
						$query = mysqli_query($koneksi,$str_puskesmas);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kelurahan = $data['Kelurahan'];
						$jml_kk = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.NoIndex FROM `$tbkk` a JOIN `$tbpasien` b ON a.NoIndex = b.NoIndex
						WHERE YEAR(a.TanggalDaftar) = '$tahun' AND a.Kelurahan = '$kelurahan' AND (b.`Asuransi` like '%BPJS%' OR b.`Asuransi` = 'SKTM')"));
						$jml_jiwa = mysqli_num_rows(mysqli_query($koneksi, "SELECT a.`NoCM` FROM `$tbpasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex
						WHERE SUBSTRING(a.NoCM,1,11)='$kodepuskesmas' AND (a.`Asuransi` like '%BPJS%' OR a.`Asuransi` = 'SKTM') AND b.Kelurahan = '$kelurahan'"));
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kelurahan;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml_kk;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml_jiwa;?></td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>		
								<td style="text-align:right; border:1px solid #000; padding:3px;">-</td>		
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
</div>	