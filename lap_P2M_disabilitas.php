<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PENYANDANG DISABILITAS</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_disabilitas"/>
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
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-xl-2">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
							
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_disabilitas" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:1px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:1px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENYANDANG DISABILITAS (JK & UMUR)</b></span><br>
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
			<table style="font-size:10px; width:300px;">
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
				<span><b>Jumlah Kasus Baru dan Lama</b></span>
				<table class="table-judul-laporan-min">
					<thead>
						<tr>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Jenis Penyakit</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">0-7Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">8-28Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1-11Bl</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1-4Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">5-9Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">10-14Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">15-19Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">20-44Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">45-59Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">>59Th</th>
							<th colspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--0-7Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--8-28Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-11Bl-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-4Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--5-9Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--10-14Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--15-19Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--20-44Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--45-59Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--60Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--Jml-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th><!--Jml-->
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$str = "SELECT * FROM `tbdiagnosadisabilitas`";
						$str2 = $str." order by `KodeKelompok`,`IdDiagnosa`";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodedgs = $data['KodeDiagnosa'];
						$namadgs = $data['NamaDiagnosa'];
						
						if($data['KodeKelompok'] == 'A'){
						$umur17hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun = '0' AND b.UmurBulan = '0' AND b.UmurHari Between '1' AND '7' AND b.JenisKelamin = 'L'"));// AND b.Kasus = 'Baru'
						$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun = '0' AND b.UmurBulan = '0' AND b.UmurHari Between '1' AND '7' AND b.JenisKelamin = 'P'"));
						$umur828hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun = '0' AND b.UmurBulan = '0' AND b.UmurHari Between '8' AND '28' AND b.JenisKelamin = 'L'"));
						$umur828hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun = '0' AND b.UmurBulan = '0' AND b.UmurHari Between '8' AND '28' AND b.JenisKelamin = 'P'"));
						$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun = '0' AND b.UmurBulan Between '1' AND '12' AND b.JenisKelamin = 'L'"));
						$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun = '0' AND b.UmurBulan Between '1' AND '12' AND b.JenisKelamin = 'P'"));
						$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '1' AND '4' AND b.JenisKelamin = 'L'"));
						$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '1' AND '4' AND b.JenisKelamin = 'P'"));
						$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '5' AND '9' AND b.JenisKelamin = 'L'"));
						$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '5' AND '9' AND b.JenisKelamin = 'P'"));
						$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '10' AND '14' AND b.JenisKelamin = 'L'"));
						$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '10' AND '14' AND b.JenisKelamin = 'P'"));
						$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '15' AND '19' AND b.JenisKelamin = 'L'"));
						$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '15' AND '19' AND b.JenisKelamin = 'P'"));
						$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '20' AND '44' AND b.JenisKelamin = 'L'"));
						$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '20' AND '44' AND b.JenisKelamin = 'P'"));
						$umur4559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
						$umur4559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
						$umur60L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '60' AND '100' AND b.JenisKelamin = 'L'"));
						$umur60P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbdiagnosapasien` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalDiagnosa) = '$tahun'".$semua."AND a.KodeDiagnosa like '%$kodedgs%' AND b.UmurTahun Between '60' AND '100' AND b.JenisKelamin = 'P'"));
						$jumlah_l = $umur17hrL['Jml']+$umur828hrL['Jml']+$umur12blnL['Jml']+$umur14L['Jml']+$umur59L['Jml']+$umur1014L['Jml']+$umur1519L['Jml']+$umur2044L['Jml']+$umur4559L['Jml']+$umur60L['Jml'];
						$jumlah_p = $umur17hrP['Jml']+$umur828hrP['Jml']+$umur12blnP['Jml']+$umur14P['Jml']+$umur59P['Jml']+$umur1014P['Jml']+$umur1519P['Jml']+$umur2044P['Jml']+$umur4559P['Jml']+$umur60P['Jml'];			
						$total = $jumlah_l + $jumlah_p;
						}else{
						$umur17hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun = '0' AND b.UmurBulan = '0' AND b.UmurHari Between '1' AND '7' AND b.JenisKelamin = 'L'"));
						$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun = '0' AND b.UmurBulan = '0' AND b.UmurHari Between '1' AND '7' AND b.JenisKelamin = 'P'"));
						$umur828hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun = '0' AND b.UmurBulan = '0' AND b.UmurHari Between '8' AND '28' AND b.JenisKelamin = 'L'"));
						$umur828hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun = '0' AND b.UmurBulan = '0' AND b.UmurHari Between '8' AND '28' AND b.JenisKelamin = 'P'"));
						$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun = '0' AND b.UmurBulan Between '1' AND '12' AND b.JenisKelamin = 'L'"));
						$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun = '0' AND b.UmurBulan Between '1' AND '12' AND b.JenisKelamin = 'P'"));
						$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '1' AND '4' AND b.JenisKelamin = 'L'"));
						$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '1' AND '4' AND b.JenisKelamin = 'P'"));
						$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '5' AND '9' AND b.JenisKelamin = 'L'"));
						$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas`a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '5' AND '9' AND b.JenisKelamin = 'P'"));
						$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '10' AND '14' AND b.JenisKelamin = 'L'"));
						$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '10' AND '14' AND b.JenisKelamin = 'P'"));
						$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '15' AND '19' AND b.JenisKelamin = 'L'"));
						$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '15' AND '19' AND b.JenisKelamin = 'P'"));
						$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '20' AND '44' AND b.JenisKelamin = 'L'"));
						$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '20' AND '44' AND b.JenisKelamin = 'P'"));
						$umur4559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
						$umur4559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
						$umur60L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '60' AND '100' AND b.JenisKelamin = 'L'"));
						$umur60P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `tbpasiendisabilitas` a join `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '$bulan'".$semua."AND a.KelompokDisabilitas = '$namadgs' AND b.UmurTahun Between '60' AND '100' AND b.JenisKelamin = 'P'"));
						$jumlah_l = $umur17hrL['Jml']+$umur828hrL['Jml']+$umur12blnL['Jml']+$umur14L['Jml']+$umur59L['Jml']+$umur1014L['Jml']+$umur1519L['Jml']+$umur2044L['Jml']+$umur4559L['Jml']+$umur60L['Jml'];
						$jumlah_p = $umur17hrP['Jml']+$umur828hrP['Jml']+$umur12blnP['Jml']+$umur14P['Jml']+$umur59P['Jml']+$umur1014P['Jml']+$umur1519P['Jml']+$umur2044P['Jml']+$umur4559P['Jml']+$umur60P['Jml'];			
						$total = $jumlah_l + $jumlah_p;
						}
						if($data['IdDiagnosa'] == '01'){
							echo "<tr style='border:1px solid #000;'><td style='text-align:center; border:1px solid #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='25' style='text-align:left; font-weight:bold; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
						}
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $data['IdDiagnosa'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaDiagnosa'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur828hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur828hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4559L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4559P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur60L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur60P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jumlah_l;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jumlah_p;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
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