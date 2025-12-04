<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	date_default_timezone_set('Asia/Jakarta');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
?>

<html lang="en">
<head>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_kunjungan_resep&opsiform=<?php echo $opsiform;?>&keydate1=<?php echo $keydate1;?>&keydate2=<?php echo $keydate2;?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">
<img src="image/logo_puskesmas.png" class="imglogo" style="margin-top:10px;">
<div class="printheader" >
	<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br/>
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br/>
	<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:10px 5px 5px 5px; border:1px solid #000">
	<span class="font16" style="margin:50px;"><b>LAPORAN KUNJUNGAN RESEP</b></span><br/>
	<span class="font14" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span><br/>
</div>
<br/>

<div class="row font10">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 12px;">Kode Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 12px;">Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
			</tr>
		</table>
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
	<div class="col-sm-12">
		<table class="table table-condensed">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="2%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
					<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
					<th rowspan="2" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
					<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
					<th rowspan="2" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
					<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
					<th rowspan="2" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jaminan</th>
					<th rowspan="2" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan</th>
					<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Therapy</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				$str = "SELECT * FROM `tbresep` WHERE YEAR(TanggalResep) = '$tahun' AND MONTH(TanggalResep)='$bulan' AND SUBSTRING(NoResep,1,11) = '$kodepuskesmas'";
				$str2 = $str."ORDER BY `TanggalResep` DESC";				
				// echo $str2;
				
				$query = mysqli_query($koneksi,$str2);					
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noresep = $data['NoResep'];
					$noindex = $data['NoIndex'];
					$umur_thn = $data['UmurTahun'];
					$umur_bln = $data['UmurBulan'];
					$jaminan = $data['StatusBayar'];
					$pelayanan = $data['Pelayanan'];
					
					// tbkk
					$str_kk = "SELECT `Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					if($alamat != null || $alamat != '' || $alamat != '-'){
						$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
					}else{
						$alamat = "-";
					}
					
					// tbresepdetail						
					$str_resepdtl = "SELECT a.KodeBarang, b.NamaBarang FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang=b.KodeBarang WHERE a.`NoResep` = '$noresep'";
					$query_resepdtl = mysqli_query($koneksi,$str_resepdtl);
					while($data_resepdtl = mysqli_fetch_array($query_resepdtl)){
						$array_data[$no][] = $data_resepdtl['NamaBarang'];
					}
					if ($array_data[$no] != ''){
						$data_rsp = implode(",", $array_data[$no]);
					}else{
						$data_rsp ="";
					}
					// echo $data_rsp;
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalResep'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noindex2,14);?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $umur_thn."Th ".$umur_bln."Bl";?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $alamat;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $jaminan;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pelayanan;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data_rsp;?></td>
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

