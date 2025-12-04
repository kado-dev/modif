<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	include "config/helper_report.php";
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$tanggal = date('Y-m-d');
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
?>
<html>
<head>
	<title>Register PIO</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_pio_hari&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>'">

<!--tabel report-->
<div class="printheader">
	<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:10px; border:1px solid #000">
	<span class="font14"><b>LEMBAR CHEKLIS PEMBERIAN INFORMASI OBAT (PIO)</b></span><br>
		<?php echo "Periode : ".date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));?>
	<br/>
</div>

<div class="atastabel">
	<div style="float:left; width:35%; margin-top:10;">	
		<table style="font-size:12px; width:300px;">
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
<div class="row ">
	<div class="col-sm-12">
		<table class="table-judul-laporan-min" style="font-size:12px; margin-top: 10px;" width="100%">
			<thead >
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
					<th rowspan="2" width="7%" style="vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
					<th rowspan="2" width="15%" style="vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
					<th rowspan="2" width="7%" style="vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
					<th rowspan="2" width="10%" style="vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan</th>
					<th rowspan="2" width="7%" style="vertical-align:middle; border:1px solid #000; padding:3px;">Jml.Obat</th>
					<th rowspan="2" width="10%" style="vertical-align:middle; border:1px solid #000; padding:3px;">Diagnosa</th>
					<th colspan="10" style="vertical-align:middle; border:1px solid #000; padding:3px;">Informasi yang diberikan</th>
					<th rowspan="2" width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">Ket</th>
				</tr>
				<tr>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">1</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">2</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">3</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">4</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">5</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">6</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">7</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">8</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">9</th>
					<th width="3%" style="vertical-align:middle; border:1px solid #000; padding:3px;">10</th>
				</tr>
			</thead>
			<tbody>
				<?php	
				$str = "SELECT * FROM `$tbresep` WHERE `TanggalResep` BETWEEN '$keydate1' AND '$keydate2' AND SUBSTRING(NoResep,1,11)='$kodepuskesmas'";
				$str2 = $str."ORDER BY `TanggalResep` DESC";
				// echo ($str2);
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noresep = $data['NoResep'];
					$noindex = $data['NoIndex'];
					$umur_thn = $data['UmurTahun'];
					$umur_bln = $data['UmurBulan'];
					$jaminan = $data['StatusBayar'];
					$pelayanan = $data['Pelayanan'];
					$data_dgs = $data['Diagnosa'];
					$pio = $data['Pio'];
					$jenis_pio = explode(",", $pio);
					// echo $jenis_pio[0];
					
					//tbresepdetail
					$dt_detailrsp = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdResepDetail` FROM `$tbresepdetail` WHERE `NoResep`='$noresep'"));
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data['TanggalResep']));?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $umur_thn."Th ".$umur_bln."Bl";?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $pelayanan;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dt_detailrsp;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Nama Obat',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";
							}
						?>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Sediaan',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";						
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Dosis',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Cara Pakai',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Penyimpanan',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Indikasi',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Kontra Indikasi',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Stabilitas',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Efek Samping',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Interaksi',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
						<?php
							if(in_array('Interaksi',$jenis_pio)){
								// echo "<i class='fa fa-check'></i>";
								echo "Y";							
							}
						?>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table><br/>
		<table style="font-size:12px;">
			<tr><td><b>KETERANGAN :</b></td></tr>
			<tr><td>1. Nama Obat</td><td>6. Indikasi</td></tr>
			<tr><td>2. Sediaan</td><td>7. Kontra Indikasi</td></tr>
			<tr><td>3. Dosis</td><td>8. Stabilitas</td></tr>
			<tr><td>4. Cara Pakai</td><td>9. Efek Samping</td></tr>
			<tr><td>5. Penyimpanan</td><td>10. Interaksi</td></tr>
		</table>
	</div>
</div>
</body>
</html>

