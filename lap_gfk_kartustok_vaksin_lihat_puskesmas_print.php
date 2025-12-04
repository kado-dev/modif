<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	$kodebarang = $_GET['kd'];
	$nobatch = $_GET['batch'];
	$nopembukuan = $_GET['nf'];
	$key = $_GET['key'];
	$orderby = $_GET['orderby'];	
	$sort = $_GET['sort'];	
	
	// tbstok
	$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
?>
<style>
.table-judul-laporan>thead>tr>th {
	padding-top:15px;
	padding-bottom:15px;
	background:#939393;
	color:#fff;
	text-align:center;
	vertical-align:middle;
	border:1px solid #000;
	font-size: 12px;
	font-family: "Poppins", sans-serif;
}
.table-judul-laporan>tbody>tr>td {
	background:#fff;
	padding:5px;			
	border: 1px solid;  
	border-color:#000;
}
</style>

<html lang="en">
<head>
	<title>Kartu Stok</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_gfk_kartustok_vaksin_lihat&nf=<?php echo $nopembukuan;?>&kd=<?php echo $kodebarang;?>&batch=<?php echo $nobatch;?>&key=<?php echo $key;?>&orderby=<?php echo $_GET['orderby'];?>&sort=<?php echo $_GET['sort'];?>'">
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>KARTU STOK GUDANG VAKSIN</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tanggal;?></span>
		<br/><br/>
	</div>
	<table width="100%">
		<tr>
			<td width="20%">Kode Barang</td>
			<td width="2%">:</td>
			<td width="78%"><?php echo $kodebarang;?></td>
		</tr>
		<tr>
			<td>Nama Barang</td>
			<td>:</td>
			<td><b><?php echo $dtbrg['NamaBarang'];?></b></td>
		</tr>
		<tr>
			<td>No.Batch</td>
			<td>:</td>
			<td><?php echo $nobatch;?></td>
		</tr>
		<tr>
			<td>Expire</td>
			<td>:</td>
			<td><?php echo $dtbrg['Expire'];?></td>
		</tr>
		<tr>
			<td>Sumber</td>
			<td>:</td>
			<td><?php echo $dtbrg['SumberAnggaran'];?></td>
		</tr>
		<tr>
			<td>Program</td>
			<td>:</td>
			<td><?php echo $dtbrg['NamaProgram'];?></td>
		</tr>
	</table><br/>	
	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="4%">No.</th>
							<th width="15%">Tanggal</th>
							<th width="20%">No.Faktur</th>
							<th width="30%">Keterangan</th>
							<th>Stok Awal</th>
							<th>Penerimaan</th>
							<th>Pengeluaran</th>
						</tr>
					</thead>
					<tbody>
						<?php	
						$no = 0;
						// stok awal
						$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch'";
						$query_stokawal = mysqli_query($koneksi, $str_stokawal);
						while($dt_stokawal = mysqli_fetch_assoc($query_stokawal)){
							$no = $no + 1;
							$faktur_terima = $dt_stokawal['NomorPembukuan'];
							$jml_stokawal = $dt_stokawal['StokAwalSistem'];
							$tanggal_stokawal = $dt_stokawal['Bulan']." ".$dt_stokawal['Tahun'];
							
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $tanggal_stokawal;?></td>
								<td align="center">-</td>
								<td align="left"><?php echo "SO BULAN ".$tanggal_stokawal;?></td>
								<td align="right"><?php echo number_format($jml_stokawal, 0, ".", ".");?></td>
								<td align="center"></td>
								<td align="center"></td>
							</tr>	
						<?php
							}
						
						// penerimaan
						$str_terima = "SELECT * FROM `tbgfk_vaksin_penerimaandetail` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch'";
						$query_terima = mysqli_query($koneksi, $str_terima);
						while($dt_terima = mysqli_fetch_assoc($query_terima)){
							$no = $no + 1;
							$faktur_terima = $dt_terima['NomorPembukuan'];
							$jml_terima = $dt_terima['Jumlah'];
							$stokterima[] = $jml_terima;
							$ttl_terima = array_sum($stokterima);
							
							// detail penerimaan
							$dt_penerimaan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan`='$faktur_terima'"));
							$tanggal_terima  = $dt_penerimaan['TanggalPenerimaan'];
							$keterangan_terima = $dt_penerimaan['KodeSupplier'];
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $tanggal_terima;?></td>
								<td align="center"><?php echo $faktur_terima;?></td>
								<td align="left"><?php echo $keterangan_terima;?></td>
								<td align="center"></td>
								<td align="right"><?php echo number_format($jml_terima, 0, ".", ".");?></td>
								<td align="center"></td>
							</tr>	
						<?php
							}
							
						// detail pengeluaran
						$no = 0;
						
						if($_GET['orderby'] == '' or $_GET['sort'] == ''){
							$orderbys = "ORDER BY `NoFaktur` ASC";
						}else{
							$orderbys = "ORDER BY ".$_GET['orderby']." ".$_GET['sort'];
						}	
						
						$str_keluar = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nopembukuan'";
						$str_keluar2 = $str_keluar." ".$orderbys;
						// echo $str_keluar2;	
						$query_keluar = mysqli_query($koneksi, $str_keluar2);
						while($dt_keluar = mysqli_fetch_assoc($query_keluar)){
							$no = $no + 1;
							$nofaktur = $dt_keluar['NoFaktur'];
							$jml_keluar = $dt_keluar['Jumlah'];			
							$stokkeluar[] = $jml_keluar;
							$ttl_keluar = array_sum($stokkeluar);
							
							// pengeluaran
							$dt_distribusi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur`='$nofaktur'"));
							$tanggal_keluar  = $dt_distribusi['TanggalPengeluaran'];
							$faktur_keluar  = $dt_distribusi['NoFaktur'];
							$keterangan_keluar = $dt_distribusi['Penerima'];
						?>	
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $tanggal_keluar;?></td>
								<td align="center"><?php echo $faktur_keluar;?></td>
								<td align="left"><?php echo $keterangan_keluar;?></td>
								<td align="center"></td>
								<td align="center"></td>
								<td align="right"><?php echo number_format($jml_keluar, 0, ".", ".");?></td>
							</tr>
						<?php
							}
							$sisastok =  $jml_stokawal + $jml_terima - $ttl_keluar;
						?>
						
					</tbody>
				</table><br/><br/>
				<table class="table table-judul-form"  width="100%">
					<tbody>
						<tr style="background: #fff4b7; font-weight: bold;">
							<td colspan="5">Jumlah Pengeluaran</td>
							<td align="right"><?php echo number_format($ttl_keluar, 0, ".", ".");?></td>
						</tr>
						<tr style="background: #ffce8e; font-weight: bold;">
							<td colspan="5"> Sisa Stok</td>
							<td align="right"><?php  echo number_format($sisastok, 0, ".", ".");?></td>
						</tr>
					</tbody>
				</table>
			</table>
		</div>
	</div>
</body>
</html>