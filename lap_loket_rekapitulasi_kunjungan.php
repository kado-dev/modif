<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN BARU & LAMA (CARA BAYAR)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_rekapitulasi_kunjungan"/>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
								for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<SELECT name="statuspasien" class="form-control">
								<option value="semua">Semua</option>
								<option value="1" <?php if($_GET['statuspasien'] == '1'){echo "SELECTED";}?>>Kunjungan Sakit</option>
								<option value="2" <?php if($_GET['statuspasien'] == '2'){echo "SELECTED";}?>>Kunjungan Sehat</option>
							</SELECT>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rekapitulasi_kunjungan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_rekapitulasi_kunjungan_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	
	<?php
	$tahun = $_GET['tahun'];
	$statuspasien = $_GET['statuspasien'];

	if (isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>KUNJUNGAN PASIEN BARU & LAMA (CARA BAYAR <?php if($statuspasien == "1"){ echo "KUNJUNGAN SAKIT";}elseif($statuspasien == "2") { echo "KUNJUNGAN SEHAT";}?>)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo "Tahun ".$_GET['tahun'];?></span>
	</div><br/>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="2">NO.</th>
							<th rowspan="2">BULAN</th>
							<th colspan="2">BPJS PBI</th>
							<th colspan="2">BPJS NON PBI</th>
							<th colspan="2">UMUM</th>
							<th colspan="2">GRATIS / SKTM</th>
							<th colspan="2">JUMLAH</th>
						</tr>
						<tr>
							<th>B</th>
							<th>L</th>
							<th>B</th>
							<th>L</th>
							<th>B</th>
							<th>L</th>
							<th>B</th>
							<th>L</th>
							<th>B</th>
							<th>L</th>
						</tr>
					</thead>
					<tbody>
						<?php					
						$tahuns = $_GET['tahun'];
						$array_bulan = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05','Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
						$no = 1;
												
						foreach($array_bulan as $namebulan => $nobulan ){
							$pbi_b = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND StatusKunjungan = 'Baru'"))['jml'];
							$pbi_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS PBI' AND StatusKunjungan = 'Lama'"))['jml'];
							$nonpbi_b = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND StatusKunjungan = 'Baru'"))['jml'];
							$nonpbi_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND  MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='BPJS NON PBI' AND StatusKunjungan = 'Lama'"))['jml'];
							$umum_b = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND StatusKunjungan = 'Baru'"))['jml'];
							$umum_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND Asuransi='UMUM' AND StatusKunjungan = 'Lama'"))['jml'];
							$gratis_b = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND StatusKunjungan = 'Baru'"))['jml'];
							$gratis_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdPasienrj) as jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahuns' AND MONTH(TanggalRegistrasi) = '$nobulan' AND (Asuransi='GRATIS' OR Asuransi='SKTM') AND StatusKunjungan = 'Lama'"))['jml'];
							$jml_b = $pbi_b + $nonpbi_b + $umum_b + $gratis_b;
							$jml_l = $pbi_l + $nonpbi_l + $umum_l + $gratis_l;
						?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $namebulan;?></td>
								<td><?php echo $pbi_b;?></td>
								<td><?php echo $pbi_l;?></td>
								<td><?php echo $nonpbi_b;?></td>
								<td><?php echo $nonpbi_l;?></td>
								<td><?php echo $umum_b;?></td>
								<td><?php echo $umum_l;?></td>
								<td><?php echo $gratis_b;?></td>
								<td><?php echo $gratis_l;?></td>
								<td><?php echo $jml_b;?></td>
								<td><?php echo $jml_l;?></td>
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
	<?php
	}
	?>
</div>	



