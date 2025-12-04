<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LEPTOSPIROSIS</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_leptospirosis_dinkes"/>
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
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-sm-3">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
										echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
									}else{
										echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
									}
								}
								?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_leptospirosis_dinkes" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_leptospirosis_dinkes_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $_GET['kodepuskesmas'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepkm = $_GET['kodepuskesmas'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive font10">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px dashed #000;">
							<th rowspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Penyakit</th>
							<th colspan="24" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Kasus Per-Golongan Umur</th>
						</tr>
						<tr style="border:1px dashed #000">
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">15-19Th</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">20-44Th</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">45-54Th</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">55-59Th</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">60-69Th</th>
							<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">>70</th>
						</tr>
						<tr style="border:1px dashed #000;">
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th><!--15-19Hr-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th><!--20-44Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th><!--45-54Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th><!--55-59Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th><!--60-69Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th><!--70Th-->
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
						</tr>
						<tr style="border:1px dashed #000;">
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--15-19Hr-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--20-44Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--45-54Thh-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--55-59Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--60-69Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th><!--70Th-->
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						if($kodepkm == 'semua'){
							$kodepuskesmas = "";
							$kodepuskesmas2 = "";
						}else{
							$kodepuskesmas = "AND SUBSTRING(a.NoRegistrasi,1,11) = '$kodepkm'";
							$kodepuskesmas2 = "AND SUBSTRING(NoRegistrasi,1,11) = '$kodepkm'";
						}
						
						// insert ke tbdiagnosapasien_bulan
						$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' ".$kodepuskesmas2;
						$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
						mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
						while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
							$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
							('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
							mysqli_query($koneksi, $strdiagnosa);
						}
						
						$str = "SELECT * FROM `tbdiagnosalestospirosis`";
						$str2 = $str." order by `KodeDiagnosa`";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = $data['KodeDiagnosa'];
							// 15-19Th
							$umur1519L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur1519P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur1519L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
							$umur1519P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
							// 20-44Th
							$umur2044L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur2044P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur2044L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
							$umur2044P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
							// 45-54Th
							$umur4554L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur4554P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur4554L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
							$umur4554P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
							// 55-59Th
							$umur5559L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur5559P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur5559L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
							$umur5559P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
							// 60-69Th
							$umur6069L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur6069P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur6069L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
							$umur6069P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
							// 70Th
							$umur70L_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur70P_B = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur70L_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
							$umur70P_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi) = '$tahun' ".$kodepuskesmas." AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
						?>	
							<tr style="border:1px dashed #000;">
								<td><?php echo $data['IdDiagnosa'];?></td>
								<td><?php echo $data['KodeDiagnosa'];?></td>
								<td><?php echo $data['NamaDiagnosa'];?></td>
								<td><?php echo $umur1519L_B['Jml'];?></td>
								<td><?php echo $umur1519P_B['Jml'];?></td>
								<td><?php echo $umur1519L_L['Jml'];?></td>
								<td><?php echo $umur1519P_L['Jml'];?></td>
								<td><?php echo $umur2044L_B['Jml'];?></td>
								<td><?php echo $umur2044P_B['Jml'];?></td>
								<td><?php echo $umur2044L_L['Jml'];?></td>
								<td><?php echo $umur2044P_L['Jml'];?></td>
								<td><?php echo $umur4554L_B['Jml'];?></td>
								<td><?php echo $umur4554P_B['Jml'];?></td>
								<td><?php echo $umur4554L_L['Jml'];?></td>
								<td><?php echo $umur4554P_L['Jml'];?></td>
								<td><?php echo $umur5559L_B['Jml'];?></td>
								<td><?php echo $umur5559P_B['Jml'];?></td>
								<td><?php echo $umur5559L_L['Jml'];?></td>
								<td><?php echo $umur5559P_L['Jml'];?></td>
								<td><?php echo $umur6069L_B['Jml'];?></td>
								<td><?php echo $umur6069P_B['Jml'];?></td>
								<td><?php echo $umur6069L_L['Jml'];?></td>
								<td><?php echo $umur6069P_L['Jml'];?></td>
								<td><?php echo $umur70L_B['Jml'];?></td>
								<td><?php echo $umur70P_B['Jml'];?></td>
								<td><?php echo $umur70L_L['Jml'];?></td>
								<td><?php echo $umur70P_L['Jml'];?></td>
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