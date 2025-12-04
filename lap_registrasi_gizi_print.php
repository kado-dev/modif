<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
?>

<html lang="en">
<head>
	<title>Register Umum</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<!--<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_umum&opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">-->
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_gizi'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PASIEN POLI GIZI</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
			?>
		</span>
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
	
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr style="border:1px dashed #000;">
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tanggal</th>
						<?php
							if($kota == 'TANJUNG SELOR'){
						?>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.RM</th>
						<?php
							}else{
						?>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.Index</th>
						<?php
							}
						?>
						<th rowspan="2" width="9%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Bayi/Balita</th>
						<th colspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Umur</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tgl.Lahir</th>
						<th rowspan="2" width="9%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Nama Ortu</th>
						<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Alamat</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">BB</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">TB</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">NTOB</th>
						<th colspan="3" width="12%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Status Gizi</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">ASI</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Ket.</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th style="text-align:center; border:1px dashed #000; padding:3px;">L</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">P</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">BB/U</th><!--Status Gizi-->
						<th style="text-align:center; border:1px dashed #000; padding:3px;">BB/TB</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">TB/U</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php
					if ($opsiform == 'bulan'){
						$str = "SELECT *
						FROM `tbpoligizi` a 
						JOIN `tbpasienrj_bulan` b ON a.NoPemeriksaan = b.NoRegistrasi
						WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND MONTH(a.TanggalPeriksa) = '$bulan' and YEAR(a.TanggalPeriksa) = '$tahun'";
					}else{
						$tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate1));
						$tbpasienrj2 = 'tbpasienrj_'.date('m', strtotime($keydate2));
						$str = "SELECT * FROM(
						SELECT a.TanggalPeriksa as TanggalPeriksa,a.NoIndex as NoIndex,a.NoCM as NoCM,b.NoRegistrasi as NoRegistrasi,b.NamaPasien as NamaPasien,b.UmurBulan as UmurBulan,b.UmurTahun as UmurTahun,b.JenisKelamin as JenisKelamin,a.BeratBadan as BeratBadan,a.TinggiBadan as TinggiBadan,a.Ntob as Ntob,a.Bbu as Bbu,a.Bbtb as Bbtb,a.Tbu as Tbu,a.Asi as Asi
						FROM `tbpoligizi` a 
						JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi
						WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND a.TanggalPeriksa BETWEEN  '$keydate1' and '$keydate2'
						UNION
						SELECT a.TanggalPeriksa as TanggalPeriksa,a.NoIndex as NoIndex,a.NoCM as NoCM,b.NoRegistrasi as NoRegistrasi,b.NamaPasien as NamaPasien,b.UmurBulan as UmurBulan,b.UmurTahun as UmurTahun,b.JenisKelamin as JenisKelamin,a.BeratBadan as BeratBadan,a.TinggiBadan as TinggiBadan,a.Ntob as Ntob,a.Bbu as Bbu,a.Bbtb as Bbtb,a.Tbu as Tbu,a.Asi as Asi
						FROM `tbpoligizi` a 
						JOIN `$tbpasienrj2` b ON a.NoPemeriksaan = b.NoRegistrasi
						WHERE SUBSTRING(a.NoPemeriksaan,1,11) = '$kodepuskesmas' AND a.TanggalPeriksa BETWEEN  '$keydate1' and '$keydate2'
						) a ";
					}
					$str2 = $str." ORDER BY a.`TanggalPeriksa` Desc";
					// echo ($str2);
					// die();
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noregistrasi = $data['NoRegistrasi'];
						$noindex = $data['NoIndex'];
						$nocm = $data['NoCM'];
						$norm = $data['NoRM'];
						$anamnesa = $data['Anamnesa'];
						$kelamin = $data['JenisKelamin'];
						
						// tbpasienperpegawai
						$dt_pasien_prpg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai1`,`NamaPegawai2`
						FROM `tbpasienperpegawai_bulan`
						WHERE `NoRegistrasi` = '$noregistrasi'"));
						if($dt_pasien_prpg['NamaPegawai1']!=''){
							$pemeriksa = $dt_pasien_prpg['NamaPegawai1'];
						}else{
							$pemeriksa = $dt_pasien_prpg['NamaPegawai2'];
						}
						
						// pasien
						if (strlen($noindex) == 24){
							$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex` FROM `tbpasien` WHERE `NoIndex` = '$noindex'"));
							$noindex2 = $dt_pasien['NoIndex'];
						}else{
							$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex` FROM `tbpasien` WHERE `NoAsuransi` = '$noindex'"));
							if ($dt_pasien['NoIndex'] != ''){
								$noindex2 = $dt_pasien['NoIndex'];
							}else{
								$noindex2 = $noindex;
							}
						}
						
						// tanggal lahir
						// $tbpasien = "tbpasien_".substr($nocm,12,4);
						$tbpasien = 'tbpasien_'.substr($noindex,14,4);
						$tbpasien2 = 'tbpasien_'.substr($noindex,14,4);
						$str_tlahir = "SELECT * FROM(
						SELECT TanggalLahir
						FROM `$tbpasien` 
						WHERE `NoCM`='$nocm'
						UNION
						SELECT TanggalLahir
						FROM `$tbpasien2` 
						WHERE `NoCM`='$nocm'
						) a ";
						$query_tlahir = mysqli_query($koneksi,$str_tlahir);
						$data_tlahir = mysqli_fetch_assoc($query_tlahir);
						// echo $str_tlahir;
						
						// tbkk
						$str_kk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex2'";
						$query_kk = mysqli_query($koneksi,$str_kk);
						$data_kk = mysqli_fetch_assoc($query_kk);
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
									
						//cek umur kelamin
						if ($kelamin == 'L'){
							$umur_l = $data['UmurBulan']."B, ".$data['UmurTahun']."T";
							$umur_p = "-";
						}else{
							$umur_l = "-";
							$umur_p = $data['UmurBulan']."B, ".$data['UmurTahun']."T";
						}
						
					?>
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['TanggalPeriksa'];?></td>
							<?php
								if($kota == 'TANJUNG SELOR'){
							?>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($norm,6);?></td>
							<?php
								}else{
							?>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo substr($noindex2,14);?></td>
							<?php
								}
							?>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_l;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $umur_p;?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data_tlahir['TanggalLahir'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['NamaKK'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['BeratBadan'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['TinggiBadan'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Ntob'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Bbu'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Bbtb'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Tbu'];?></td>
							<td style="text-align:center; border:1px dashed #000; padding:3px;"><?php echo $data['Asi'];?></td>
							<td style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $pemeriksa;?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>