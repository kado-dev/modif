<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>RUJUKAN PASIEN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_rujukan"/>
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
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rup" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
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
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KASUS RUJUKAN PUSKESMAS</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
	</div>

	<div class="atastabel font11">
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
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="3" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" width="36%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Diagnosa</th>
							<th rowspan="3" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode ICD</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Golongan Umur (Th)</th>
							<th colspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Rujukan</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;"><1</th>
							<th width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">1-5</th>
							<th width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">6-18</th>
							<th width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">>18</th>
							<!--jaminan-->
							<th width="7%" style="text-align:center; border:1px solid #000; padding:3px;">BPJS</th>
							<th width="7%" style="text-align:center; border:1px solid #000; padding:3px;">UMUM</th>
							<th width="7%" style="text-align:center; border:1px solid #000; padding:3px;">SKTM</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// $str = "SELECT a.KodeDiagnosa, b.Diagnosa, COUNT(a.KodeDiagnosa)AS jml 
						// FROM `tbrujukluargedung` a JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa
						// WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun' 
						// GROUP BY a.KodeDiagnosa 
						// ORDER BY Diagnosa ASC";
						$tbdiagnosapasien = "tbdiagnosapasien_".$bulan;
						$str = "SELECT * FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b ON a.NoRegistrasi = b.NoRegistrasi
						WHERE MONTH(a.TanggalRegistrasi)='$bulan' AND YEAR(a.TanggalRegistrasi)='$tahun' 
						AND a.StatusPulang='4'
						GROUP BY b.KodeDiagnosa
						ORDER BY b.KodeDiagnosa";						
						// echo $str;
						
						$no = 0;
						$query = mysqli_query($koneksi,$str);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kode_dgs = $data['KodeDiagnosa'];
							
							// dtdiagnosa
							$dt_diagnnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$kode_dgs'"));
							
							// tbpasienrj
							$gol_umur_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b ON a.NoRegistrasi = b. NoRegistrasi WHERE MONTH(a.TanggalRegistrasi)='$bulan' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.Umurtahun = '0' AND b.KodeDiagnosa='$kode_dgs'"));
							$gol_umur_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b ON a.NoRegistrasi = b. NoRegistrasi WHERE MONTH(a.TanggalRegistrasi)='$bulan' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.Umurtahun BETWEEN '1' AND '5' AND b.KodeDiagnosa='$kode_dgs'"));
							$gol_umur_3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b ON a.NoRegistrasi = b. NoRegistrasi WHERE MONTH(a.TanggalRegistrasi)='$bulan' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.Umurtahun BETWEEN '6' AND '18' AND b.KodeDiagnosa='$kode_dgs'"));
							$gol_umur_4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b ON a.NoRegistrasi = b. NoRegistrasi WHERE MONTH(a.TanggalRegistrasi)='$bulan' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.Umurtahun > '18' AND b.KodeDiagnosa='$kode_dgs'"));
						
							// jaminan
							$bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b ON a.NoRegistrasi = b.NoRegistrasi WHERE MONTH(a.TanggalRegistrasi)='$bulan' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.Asuransi like '%BPJS%' AND b.KodeDiagnosa='$kode_dgs'"));	
							$umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b ON a.NoRegistrasi = b.NoRegistrasi WHERE MONTH(a.TanggalRegistrasi)='$bulan' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.Asuransi='UMUM' AND b.KodeDiagnosa='$kode_dgs'"));
							$sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS jml FROM `$tbpasienrj` a JOIN `$tbdiagnosapasien` b ON a.NoRegistrasi = b.NoRegistrasi WHERE MONTH(a.TanggalRegistrasi)='$bulan' AND YEAR(a.TanggalRegistrasi)='$tahun' AND a.Asuransi='SKTM' AND b.KodeDiagnosa='$kode_dgs'"));
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>	
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dt_diagnnosa['Diagnosa'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kode_dgs;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gol_umur_1['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gol_umur_2['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gol_umur_3['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gol_umur_4['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umum['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $sktm['jml'];?></td>	
								
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
</div>