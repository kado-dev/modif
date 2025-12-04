<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$id = $_GET['id'];
	$nofaktur = $_GET['nf'];
	$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur` = '$nofaktur'"));
	$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `NamaPuskesmas` = '$pengeluaran[Penerima]'"));
?>

<html lang="en">
<head>
	<title>SBBK</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
	<!--style custom pkmonline-->
	<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css?=3">
	<style>
		.logokab{
			width: 90px;
			height: 70px;
			margin: 20px 50px 0px 50px;
			filter: grayscale(100%);
		}
	</style>	
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_besar_pengeluaran_lihat&id=<?php echo $id;?>&nf=<?php echo $nofaktur;?>'">
	<img src="image/bandungkabnew.jpg" class="logokab">	
	<div class="printheader" style="margin-top: -80px;">
		<span class="font22" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font30" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font16" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font22" style="margin:15px 5px 5px 5px;"><b>SURAT BUKTI BARANG KELUAR (GUDANG BESAR DINKES)</b></span><br>
		<span class="font22" style="margin:1px;"><b><?php echo "NO.FAKTUR : ".$nofaktur;?></b></span><br/>
		<span class="font22" style="margin:1px;"><?php echo "TANGGAL ENTRY : ".tgl_slas($pengeluaran['TanggalPengeluaran']);?></span>
	</div>

	<?php  
	$tgl = explode("-",$pengeluaran['TanggalPengeluaran']);
	$tgllaporan = $tgl[1] - 1;
	$tglpermintaan = $tgl[1];
	?>
	
	<div class="atastabel" style="margin-top: 0px;">
		<div style="float:left; width:65%;">
			<table style="width:500px;">
				<tr>
					<td style="padding:2px 4px;">PENERIMA</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $pengeluaran['Penerima'];?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">KECAMATAN</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo strtoupper($dtpuskesmas['Kecamatan']);?></td>
				</tr>
			</table><p/>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table style="width:500px;">
				<tr>
					<td style="padding:2px 4px;">PELAPORAN BULAN</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo strtoupper(nama_bulan($tgllaporan))." ".$tgllaporan[0];?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">PERMINTAAN BULAN</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo strtoupper(nama_bulan($tglpermintaan))." ".$tgllaporan[0];?></td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead>
					<tr style="border:1px solid #000;">
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
						<th rowspan="2" width="25%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">EXPIRE</th>
						<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">BATCH</th>
						<th rowspan="2" width="14%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SUMBER</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">STATUS</th>
						<th colspan="6" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PEMBERIAN</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">QTY</th>
						<th width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SAT.</th>
						<th width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">QTY</th>
						<th width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KEM.</th>
						<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">HARGA</th>
						<th width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$qty = 0;
					$total = 0;
					$no = 0;
					$str2_print = "SELECT a.KodeBarang, b.NamaBarang, b.SumberAnggaran, b.TahunAnggaran,  b.StatusAnggaran, b.IsiKemasan, b.Kemasan, b.Satuan, a.NoBatch, b.Expire, b.HargaBeli, a.Jumlah, b.NamaTambahan 
					FROM `tbgfkpengeluarandetail` a
					JOIN `tbgfkstok` b on a.KodeBarang = b.KodeBarang AND a.NoBatch = b.NoBatch
					WHERE a.NoFaktur = '$nofaktur' AND a.NoBatch = b.NoBatch  GROUP BY a.Id ORDER BY NamaBarang";
					$query_print = mysqli_query($koneksi,$str2_print);
					while($data = mysqli_fetch_assoc($query_print)){
						$no = $no + 1;
						$jumlah = $data['HargaBeli'] * $data['Jumlah'];
						$total = $jumlah + $total;
						if($data['IsiKemasan'] != 0){
							$qty = $data['Jumlah'] / $data['IsiKemasan'];
						}else{
							$qty = "-";
						}
					?>
						<tr>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo $no.".";?></td>
							<td align="left" style="border:1px solid #000; padding:3px;">
								<?php 
									echo $data['NamaBarang']."<br/>";	
									if($data['NamaTambahan'] != "-"){
								?>
									<span style='font-size: 13px; font-style: italic'><?php echo $data['NamaTambahan'];?></span>
								<?php } ?>
							</td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo tgl_singkat($data['Expire']);?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['NoBatch'];?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['SumberAnggaran']." ".$data['TahunAnggaran'];?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['StatusAnggaran'];?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo $qty;?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['Kemasan'];?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo rupiah($data['HargaBeli']);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo rupiah($data['HargaBeli'] * $data['Jumlah']);?></td>
						</tr>
					<?php
					}
					?>
						<tr>
							<td colspan="11" style="text-align:center; border:1px solid #000; padding:3px;">TOTAL</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total)?></td>
						</tr>
				</tbody>
			</table>
		</div>
		<div class="bawahtabel">
			<table width="100%">
				<tr>
					<td style="text-align:center;">
					KEPALA PUSKESMAS
					<br>
					<br>
					<br>
					<br>
					(..............................)
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
					DITERIMA OLEH
					<br>
					<br>
					<br>
					<br>
					(..............................)
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
					DISERAHKAN OLEH
					<br>
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