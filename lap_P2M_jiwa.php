<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KESEHATAN JIWA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_jiwa"/>
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
						<div class="col-xl-2" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_jiwa" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_jiwa_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:1px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN KESEHATAN JIWA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
	</div><br/>
	
	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="4">NO.</th>
							<th rowspan="4">KODE</th>
							<th rowspan="4">JENIS PENYAKIT</th>
							<th colspan="36">JUMLAH KASUS PER-GOLONGAN UMUR</th>
						</tr>
						<tr>
							<th colspan="4">1-4Th</th>
							<th colspan="4">5-9Th</th>
							<th colspan="4">10-14Th</th>
							<th colspan="4">15-19Th</th>
							<th colspan="4">20-44Th</th>
							<th colspan="4">45-54Th</th>
							<th colspan="4">55-59Th</th>
							<th colspan="4">60-69Th</th>
							<th colspan="4">>70</th>
						</tr>
						<tr>
							<th colspan="2">B</th><!--1-4Th -->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--5-9Hr-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--10-14Th-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--15-19Th-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--20-44Th-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--45-54Th-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--55-59Th-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--60-69Th-->
							<th colspan="2">L</th>
							<th colspan="2">B</th><!--70Th-->
							<th colspan="2">L</th>
						</tr>
						<tr>
							<th>L</th><!--1-4Th -->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--5-9Hr-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--10-14Th-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--15-19Th-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--20-44Th-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--45-54Th-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--55-59Th-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--60-69Th-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--70Th-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php
						$str = "SELECT * FROM `tbdiagnosajiwa`";
						$str2 = $str." order by `KodeDiagnosa`";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = $data['KodeDiagnosa'];
							$umur14L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							// echo "SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L' AND Kasus = 'Baru'";
							$umur14P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur14L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							echo "SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'L' AND Kasus = 'Lama'";
							$umur14P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '1' AND '4' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$umur59L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur59P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur59L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$umur59P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '5' AND '9' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$umur1014L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur1014P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur1014L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$umur1014P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '10' AND '14' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$umur1519L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur1519P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur1519L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$umur1519P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '15' AND '19' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$umur2044L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur2044P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur2044L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$umur2044P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '20' AND '44' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$umur4554L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur4554P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur4554L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$umur4554P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '45' AND '54' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$umur5559L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur5559P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur5559L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$umur5559P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '55' AND '59' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$umur6069L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur6069P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur6069L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$umur6069P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
							$umur70L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur70P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							$umur70L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L' AND Kasus = 'Lama'"));
							$umur70P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND KodeDiagnosa like '%$kodedgs%' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P' AND Kasus = 'Lama'"));
						?>
							<tr>
								<td align="center" width="3%"><?php echo $data['IdDiagnosa'];?></td>
								<td align="center" width="6%"><?php echo $data['KodeDiagnosa'];?></td>
								<td align="left" width="15%"><?php echo strtoupper($data['NamaDiagnosa']);?></td>
								<td align="right"><?php echo $umur14L_B['Jml'];?></td>
								<td align="right"><?php echo $umur14P_B['Jml'];?></td>
								<td align="right"><?php echo $umur14L_L['Jml'];?></td>
								<td align="right"><?php echo $umur14P_L['Jml'];?></td>
								<td align="right"><?php echo $umur59L_B['Jml'];?></td>
								<td align="right"><?php echo $umur59P_B['Jml'];?></td>
								<td align="right"><?php echo $umur59L_L['Jml'];?></td>
								<td align="right"><?php echo $umur59P_L['Jml'];?></td>
								<td align="right"><?php echo $umur1014L_B['Jml'];?></td>
								<td align="right"><?php echo $umur1014P_B['Jml'];?></td>
								<td align="right"><?php echo $umur1014L_L['Jml'];?></td>
								<td align="right"><?php echo $umur1014P_L['Jml'];?></td>
								<td align="right"><?php echo $umur1519L_B['Jml'];?></td>
								<td align="right"><?php echo $umur1519P_B['Jml'];?></td>
								<td align="right"><?php echo $umur1519L_L['Jml'];?></td>
								<td align="right"><?php echo $umur1519P_L['Jml'];?></td>
								<td align="right"><?php echo $umur2044L_B['Jml'];?></td>
								<td align="right"><?php echo $umur2044P_B['Jml'];?></td>
								<td align="right"><?php echo $umur2044L_L['Jml'];?></td>
								<td align="right"><?php echo $umur2044P_L['Jml'];?></td>
								<td align="right"><?php echo $umur4554L_B['Jml'];?></td>
								<td align="right"><?php echo $umur4554P_B['Jml'];?></td>
								<td align="right"><?php echo $umur4554L_L['Jml'];?></td>
								<td align="right"><?php echo $umur4554P_L['Jml'];?></td>
								<td align="right"><?php echo $umur5559L_B['Jml'];?></td>
								<td align="right"><?php echo $umur5559P_B['Jml'];?></td>
								<td align="right"><?php echo $umur5559L_L['Jml'];?></td>
								<td align="right"><?php echo $umur5559P_L['Jml'];?></td>
								<td align="right"><?php echo $umur6069L_B['Jml'];?></td>
								<td align="right"><?php echo $umur6069P_B['Jml'];?></td>
								<td align="right"><?php echo $umur6069L_L['Jml'];?></td>
								<td align="right"><?php echo $umur6069P_L['Jml'];?></td>
								<td align="right"><?php echo $umur70L_B['Jml'];?></td>
								<td align="right"><?php echo $umur70P_B['Jml'];?></td>
								<td align="right"><?php echo $umur70L_L['Jml'];?></td>
								<td align="right"><?php echo $umur70P_L['Jml'];?></td>
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