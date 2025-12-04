<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PTM (KASUS)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_ptm_kasus"/>
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
						<?php
						if($kodepuskesmas == '-'){
						?>
							<div class="col-xl-2">
								<select name="kodepuskesmas" class="form-control">
									<option value='semua'>Semua</option>
									<?php
									$kota = $_SESSION['kota'];
									$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' ORDER BY `NamaPuskesmas`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
									}
									?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-xl-7">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_ptm_kasus" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_ptm_kasus_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>


	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
		
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	
	// insert ke tbpasienrj_bulan
	$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
	$querypasienrj = mysqli_query($koneksi, $strpasienrj);
	mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
	while($datapsrj= mysqli_fetch_assoc($querypasienrj)){
		$strpasienrjbulan = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,
		`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
		`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
		`nokartu`,`kdpoli`,`Kir`) VALUES 
		('$datapsrj[TanggalRegistrasi]','$datapsrj[NoRegistrasi]','$datapsrj[NoIndex]','$datapsrj[NoCM]','$datapsrj[NoRM]','$datapsrj[NamaPasien]',
		'$datapsrj[JenisKelamin]','$datapsrj[UmurTahun]','$datapsrj[UmurBulan]','$datapsrj[UmurHari]','$datapsrj[JenisKunjungan]','$datapsrj[AsalPasien]',
		'$datapsrj[StatusPasien]','$datapsrj[PoliPertama]','$datapsrj[Asuransi]','$datapsrj[StatusKunjungan]','$datapsrj[WaktuKunjungan]','$datapsrj[TarifKarcis]',
		'$datapsrj[TarifKir]','$datapsrj[TotalTarif]','$datapsrj[StatusPelayanan]','$datapsrj[StatusPulang]','$datapsrj[NamaPegawaiSimpan]','$datapsrj[NamaPegawaiEdit]'
		,'$datapsrj[TanggalEdit]','$datapsrj[NoKunjunganBpjs]','$datapsrj[NoUrutBpjs]','$datapsrj[kdprovider]','$datapsrj[nokartu]','$datapsrj[kdpoli]',
		'$datapsrj[Kir]')";
		mysqli_query($koneksi, $strpasienrjbulan);
	}
						
	// insert ke tbdiagnosapasien_bulan
	$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalDiagnosa`)='$tahun'";
	$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
	mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
	while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
		$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
		('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
		mysqli_query($koneksi, $strdiagnosa);
	}	
						
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>REKAPITULASI KASUS BARU - LAMA DAN KEMATIAN (PTM)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
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

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<span><b>Jumlah Kasus Baru</b></span>
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="3" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penyakit Tidak Menular</th>
							<th colspan="16" width="50%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Kelamin dan Umur (Th)</th>
							<th rowspan="3" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
						</tr>
						<tr>
							<th colspan="8" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Laki-laki (L)</th>
							<th colspan="8" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Perempuan (P)</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;"><15</th><!--15-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">15-19</th><!--15-19-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">20-44</th><!--20-44-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">45-54</th><!--45-54-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">55-59</th><!--55-59-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">60-69</th><!--60-69-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">>70</th><!--70-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">Jumlah</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;"><15</th><!--15-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">15-19</th><!--15-19-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">20-44</th><!--20-44-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">45-54</th><!--45-54-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">55-59</th><!--55-59-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">60-69</th><!--60-69-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">>70</th><!--70-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">Jumlah</th>
						</tr>
					</thead>
					<tbody style="font-size:9.5px;">
						<?php
						$str = "SELECT * FROM `tbdiagnosaptmkode`";
						$str2 = $str." ORDER BY `KodeKelompok`,`IdDiagnosa`";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = $data['KodeDiagnosa'];
							$umur15L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur70L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$jmlL = $umur15L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml'] + $umur6069L['Jml'] + $umur70L['Jml'];
							$umur15P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur70P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun > '70' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$jmlP = $umur15P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml'] + $umur6069P['Jml'] + $umur70P['Jml'];
							$total = $jmlL + $jmlP;
							if($data['IdDiagnosa'] == '01'){
								echo "<tr style='border:1px solid #000;'><td style='text-align:center; border:1px solid #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='19' style='text-align:left; font-weight:bold; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
							}
						?>
						
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $data['IdDiagnosa'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur15L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmlL;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur15P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmlP;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<br><br>
				<span><b>Jumlah Kasus Lama</b></span>
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="3" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Penyakit Tidak Menular</th>
							<th colspan="16" width="50%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Kelamin dan Umur (Th)</th>
							<th rowspan="3" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
						</tr>
						<tr>
							<th colspan="8" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Laki-laki (L)</th>
							<th colspan="8" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Perempuan (P)</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;"><15</th><!--15-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">15-19</th><!--15-19-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">20-44</th><!--20-44-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">45-54</th><!--45-54-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">55-59</th><!--55-59-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">60-69</th><!--60-69-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">>70</th><!--70-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">Jumlah</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;"><15</th><!--15-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">15-19</th><!--15-19-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">20-44</th><!--20-44-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">45-54</th><!--45-54-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">55-59</th><!--55-59-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">60-69</th><!--60-69-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">>70</th><!--70-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">Jumlah</th>
						</tr>
					</thead>
					<tbody style="font-size:9.5px;">
						<?php
						$str = "SELECT * FROM `tbdiagnosaptmkode`";
						$str2 = $str." order by `KodeKelompok`,`IdDiagnosa`";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodedgs = $data['KodeDiagnosa'];
						$umur15L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
						$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
						$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
						$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
						$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
						$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
						$umur70L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
						$jmlL = $umur15L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml'] + $umur6069L['Jml'] + $umur70L['Jml'];
						$umur15P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '1' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
						$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
						$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
						$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
						$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
						$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
						$umur70P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasienrj_bulan` a JOIN `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalRegistrasi) = '$tahun'".$semua."AND b.KodeDiagnosa like '%$kodedgs%' AND a.UmurTahun > '70' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
						$jmlP = $umur15P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml'] + $umur6069P['Jml'] + $umur70P['Jml'];
						$total = $jmlL + $jmlP;
						if($data['IdDiagnosa'] == '01'){
							echo "<tr style='border:1px solid #000;'><td style='text-align:center; border:1px solid #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='19' style='text-align:left; font-weight:bold; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
						}
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $data['IdDiagnosa'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur15L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmlL;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur15P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmlP;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $total;?></td>
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