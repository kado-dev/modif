<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$telepon = $_SESSION['telepon'];
	$fax = $_SESSION['fax'];
?>

<html lang="en">
<head>
	<title>SBBK</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_vaksin_pengeluaran_lihat&id=<?php echo $_GET['id'];?>&nf=<?php echo $_GET['nf'];?>'">
	<?php
		$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur` = '$nf'"));
	?>
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo "UPT. PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>SURAT BUKTI BARANG KELUAR (GUDANG VAKSIN - DINKES)</b></span><br>
		<span class="font14" style="margin:1px;">No Faktur: <?php echo $nf;?></span><br/>
		<span class="font14" style="margin:1px;">Tanggal Entry: <?php echo ($pengeluaran['TanggalPengeluaran']);?></span><br/>
	</div>

	<?php  
	$tgl = explode("-",$pengeluaran['TanggalPengeluaran']);
	$tgllaporan = $tgl[1] - 1;
	$tglpermintaan = $tgl[1];
	?>
	
	<?php $datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `namapuskesmas` = '$pengeluaran[Penerima]'")); ?>
	<div style="float:left; width:65%; margin-bottom:10px; font-family: 'Arial Narrow'">
		<table style="font-size: 12px;">
			<tr>
				<td style="padding:2px 4px;">Penerima </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $pengeluaran['Penerima'];?></td>
			</tr>
			<?php
			if($pengeluaran['StatusPengeluaran'] == 'PUSKESMAS'){
			?>
			<tr>
				<td style="padding:2px 4px;">Kecamatan </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo strtoupper($datakecamatan['Kecamatan']);?></td>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table  style="font-size: 12px;">
			<tr>
				<td style="padding:2px 4px;">Pelaporan Bulan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo strtoupper(nama_bulan($tgllaporan))." ".$tgllaporan[0];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Permintaan Bulan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo strtoupper(nama_bulan($tglpermintaan))." ".$tgllaporan[0];?></td>
			</tr>
		</table>
	</div>	
	
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead style="font-size:14px;">
					<tr style="border:1px solid #000;">
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
						<th rowspan="2" width="27%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Expire</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NoBatch</th>
						<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Anggaran</th>
						<th colspan="6" width="23%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemberian</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Qty</th>
						<th width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sat</th>
						<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Qty</th>
						<th width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kem</th>
						<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Harga</th>
						<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
					</tr>
				</thead>
				<tbody style="font-size:15px;">
					<?php
					$qty = 0;
					$total = 0;
					$no = 0;
					$str = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` WHERE `Nofaktur`='$nf'";
					$query = mysqli_query($koneksi,$str);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kdbrg = $data['KodeBarang'];
						$batch = $data['NoBatch'];	
						
						// tbgfk_vaksin_stok
						$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
						$jumlah = $dt_gfkstok['HargaBeli'] * $data['Jumlah'];
						$total = $jumlah + $total;
						
						if($dt_gfkstok['IsiKemasan'] != ""){
							$qty = $data['Jumlah'] / $dt_gfkstok['IsiKemasan'];
						}else{
							$qty = "-";
						}
					?>
						<tr>
							<td align="right" style="border:1px solid #000; padding:0px;"><?php echo $no.".";?></td>
							<td align="left" style="border:1px solid #000; padding:0px;"><?php echo $dt_gfkstok['NamaBarang'];?></td>
							<!--<td align="center" style="border:1px solid #000; padding:0px;"><?php //echo tgl_singkat($dt_gfkstok['Expire']);?></td>-->
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo date('d-m-Y', strtotime($dt_gfkstok['Expire']));?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo $data['NoBatch'];?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo $dt_gfkstok['SumberAnggaran']." ".$dt_gfkstok['TahunAnggaran'];?></td>
							<td align="right" style="border:1px solid #000; padding:0px;"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo $dt_gfkstok['Satuan'];?></td>
							<td align="right" style="border:1px solid #000; padding:0px;"><?php echo $qty;?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo $dt_gfkstok['Kemasan'];?></td>
							<td align="right" style="border:1px solid #000; padding:0px;"><?php echo rupiah($dt_gfkstok['HargaBeli']);?></td>
							<td align="right" style="border:1px solid #000; padding:0px;"><?php echo rupiah($dt_gfkstok['HargaBeli'] * $data['Jumlah']);?></td>
						</tr>
					<?php
					}
					?>
						<tr>
							<td colspan="10" style="text-align:center; border:1px solid #000; padding:0px;">TOTAL</td>
							<td style="text-align:right; border:1px solid #000; padding:0px;"><?php echo rupiah($total)?></td>
						</tr>
				</tbody>
			</table>
		</div>
		<div class="bawahtabel">
			<table width="100%">
				<tr style="font-size: 14px;">
					<td style="text-align:center;">
					Kepala Puskesmas
					<br>
					<br>
					<br>
					(..............................)
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
					Diterima Oleh
					<br>
					<br>
					<br>
					<?php echo strtoupper($pengeluaran['PetugasPenerima']);?>
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
					Diserahkan Oleh
					<br>
					<br>
					<br>
					(..............................)
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>