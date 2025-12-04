<?php
	$id = $_GET['id'];
	$bulan = date('m');
	$tahun = date('Y');
?>

<html lang="en">
<head>
	<title>Lap.Gema Cermat</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<!--<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_umum&opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">-->
<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_besar_gemacermat'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN GEMA CERMAT</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php echo nama_bulan($bulan)." ".$tahun;?>
		</span>
		<br/>
	</div>
	
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead style="font-size:10px;">
					<tr style="border:1px dashed #000;">
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
						<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Penyelenggara</th>
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Tempat</th>
						<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Sumber Dana</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Peserta Peremuan</th>
						<th colspan="5" width="20%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Jumlah Peserta</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Hasil Pelaksanaan Kegiatan</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px dashed #000; padding:3px;">Rencana Tindak Lanjut</th>
					</tr>
					<tr style="border:1px dashed #000;">
						<th style="text-align:center; border:1px dashed #000; padding:3px;">Apoteker</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">Nakes Lainnya</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">Kader</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">Masyarakat Umum</th>
						<th style="text-align:center; border:1px dashed #000; padding:3px;">Total</th>
					</tr>
				</thead>
				<tbody style="font-size:10px;">
					<?php	
					$str = "SELECT * from tbgfkgemacermat where IdKegiatan = '$id'";
					$query = mysqli_query($koneksi,$str);
					
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$total = $data['JumlahApoteker'] + $data['JumlahNakesLain'] + $data['JumlahKader']+ $data['JumlahMasyarakat'];
					?>					
						<tr style="border:1px dashed #000;">
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['Penyelenggara'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['Tempat'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo "-";?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['Peserta'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['JumlahApoteker'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['JumlahNakesLain'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['JumlahKader'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['JumlahMasyarakat'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $total;?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['HasilKegiatan'];?></td>
							<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['RencanaTindakLanjut'];?></td>
						</tr>
					<?php
						$fotokegiatan1 = $data['FotoKegiatan1'];
						$fotokegiatan2 = $data['FotoKegiatan2'];
						$fotokegiatan3 = $data['FotoKegiatan3'];
					}
					?>
					<tr>
						<td colspan="12" align="center">
							<?php if($fotokegiatan1 != ""){?>
							<p style="margin-top: 20px;font-size: 15px;">Gambar 1</p>
							<img src="image/gemacermat/<?php echo $fotokegiatan1;?>" max-width="800px">
							<hr/>
							<?php 
							}
							if($fotokegiatan2 != ""){?>
							<p style="margin-top: 20px;font-size: 15px;">Gambar 2</p>
							<img src="image/gemacermat/<?php echo $fotokegiatan2;?>" max-width="800px">
							<hr/>
							<?php 
							}
							if($fotokegiatan3 != ""){?>
							<p style="margin-top: 20px;font-size: 15px;">Gambar 3</p>
							<img src="image/gemacermat/<?php echo $fotokegiatan3;?>" max-width="800px">
							<hr/>
							<?php }?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>