<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Rujukan Pasien</h1>
		</div>
	</div>
</div>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>RUJUKAN PASIEN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_loket_rujukan_bandung"/>
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
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_rup" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
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
	if($_SESSION['kodepuskesmas'] == '-'){
		$kdpuskesmas = $_GET['kodepuskesmas'];
		if($kdpuskesmas == 'semua'){
			$semua = " ";
		}else{
			$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
		}
	}else{
		$kdpuskesmas = $_SESSION['kodepuskesmas'];
		$semua = " AND substring(NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:2px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN RUJUKAN PASIEN</b></span><br>
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

	<!--tabel view-->
	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive font10">
				<table class="table-judul-laporan-min">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="3" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="3" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Diagnosa</th>
							<th colspan="4" width="30%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Golongan Umur</th>
							<th colspan="5" width="25%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jaminan/Cara Bayar</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; width:1.5%; vertical-align:middle; border:1px solid #000; padding:3px;"><1 th</th>
							<th style="text-align:center; width:1.5%; vertical-align:middle; border:1px solid #000; padding:3px;">1-5 th</th>
							<th style="text-align:center; width:1.5%; vertical-align:middle; border:1px solid #000; padding:3px;">6-18 th</th>
							<th style="text-align:center; width:1.5%; vertical-align:middle; border:1px solid #000; padding:3px;">>18 th</th>
						
							<th style="text-align:center; width:1%; border:1px solid #000; padding:3px;">PBI</th>
							<th style="text-align:center; width:1%; border:1px solid #000; padding:3px;">NON PBI</th>
							<th style="text-align:center; width:1%; border:1px solid #000; padding:3px;">Umum</th>
							<th style="text-align:center; width:1%; border:1px solid #000; padding:3px;">Gratis</th>
							<th style="text-align:center; width:1%; border:1px solid #000; padding:3px;">Sktm</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$str = "SELECT a.KodeDiagnosa, b.Diagnosa, COUNT(a.KodeDiagnosa)AS jml 
						FROM `tbrujukluargedung` a JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa
						WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun' 
						GROUP BY a.KodeDiagnosa 
						ORDER BY jml DESC LIMIT 30";
						// echo $str;
						$no = 0;
						$query = mysqli_query($koneksi,$str);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kode_dgs = $data['KodeDiagnosa'];
							$diagnosa = $data['Diagnosa'];
							$gol_umur_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND b.Umurtahun = '0' AND a.KodeDiagnosa='$kode_dgs'"));
							$gol_umur_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND b.Umurtahun BETWEEN '1' AND '5' AND a.KodeDiagnosa='$kode_dgs'"));
							$gol_umur_3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND b.Umurtahun BETWEEN '6' AND '18' AND a.KodeDiagnosa='$kode_dgs'"));
							$gol_umur_4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND b.Umurtahun > '18' AND a.KodeDiagnosa='$kode_dgs'"));
						
							// jaminan
							$bpjs_pbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND (b.Asuransi = 'BPJS PBI APBD' OR b.Asuransi = 'BPJS PBI APBN') AND a.KodeDiagnosa='$kode_dgs'"));	
							$bpjs_non_pbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND b.Asuransi = 'BPJS NON PBI' AND a.KodeDiagnosa='$kode_dgs'"));
							$umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND b.Asuransi = 'UMUM' AND a.KodeDiagnosa='$kode_dgs'"));
							$gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND b.Asuransi = 'GRATIS' AND a.KodeDiagnosa='$kode_dgs'"));
							$sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeDiagnosa)AS jml FROM tbrujukluargedung a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
							WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND MONTH(a.TanggalRujukan)='$bulan' AND YEAR(a.TanggalRujukan)='$tahun'
							AND b.Asuransi = 'SKTM' AND a.KodeDiagnosa='$kode_dgs'"));
							
								
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kode_dgs;?></td>	
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $diagnosa;?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gol_umur_1['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gol_umur_2['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gol_umur_3['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gol_umur_4['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_pbi['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $bpjs_non_pbi['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umum['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $gratis['jml'];?></td>	
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $sktm['jml'];?></td>	
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