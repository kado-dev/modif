<?php
	error_reporting(0);
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	// get
	$bulanawal = $_GET['bulanawal'];
	$bulanakhir = $_GET['bulanakhir'];	
	$tahunawal = $_GET['tahunawal'];	
	$tahunakhir = $_GET['tahunakhir'];
	$sumberanggaran = $_GET['sumberanggaran'];
	$namaprogram = $_GET['namaprogram'];	
	$key = $_GET['key'];
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
	<title>SO Triwulan</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=uptd_gudang_sisa_aset_triwulan_bogorkab&bulanawal=<?php echo  $_GET['bulanawal'];?>&tahunawal=<?php echo $_GET['tahunawal'];?>&bulanakhir=<?php echo  $_GET['bulanakhir'];?>&tahunakhir=<?php echo $_GET['tahunakhir'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>&key=<?php echo $_GET['key'];?>'">
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>STOK OPNAME (TRIWULAN)</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulanawal)." ".$tahunawal." s/d ".nama_bulan($bulanakhir)." ".$tahunakhir;?></span>
		<br/><br/>
	</div>
	
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead style="font-size: 10px;">
						<tr>
							<th rowspan="3" width="3%">No.</th>
							<th rowspan="3" width="4%">Kode</th>
							<th rowspan="3" width="10%">Nama Barang</th>
							<th rowspan="3" width="5%">Satuan</th>
							<th rowspan="2" colspan="2" width="6%">Saldo Awal</th>
							<th colspan="7" width="20%">Saldo Awal</th>
							<th rowspan="2" colspan="3" width="20%">Penerimaan</th>
							<th rowspan="3" width="5%">Total Persediaan</th>
							<th rowspan="3" width="5%">Total Rupiah</th>
							<th colspan="3" rowspan="2" width="15%">Jumlah Pengeluaran</th>
							<th colspan="2" rowspan="2" width="15%">Saldo Administrasi</th>
							<!--<th rowspan="3" width="5%">Total Saldo Fisik</th>
							<th rowspan="3" width="5%">Total Nilai Persediaan</th>
							<th colspan="2" rowspan="2" width="10%">Selisih Administrasi & Fisik</th>-->
						</tr>
						<tr>
							<th colspan="2" width="3%">2017</th>
							<th colspan="2" width="3%">2018</th>
							<th colspan="2" width="3%">2019</th>
							<th rowspan="2" width="3%">Total</th>
						</tr>
						<tr>
							<th rowspan="3" width="3%">APBD</th><!--Saldo Awal-->
							<th rowspan="3" width="3%">Total</th>
							<th rowspan="3" width="3%">APBD</th><!--Saldo Awal Per-Tahun-->
							<th rowspan="3" width="3%">Harga</th>
							<th rowspan="3" width="3%">APBD</th>
							<th rowspan="3" width="3%">Harga</th>
							<th rowspan="3" width="3%">APBD</th>
							<th rowspan="3" width="3%">Harga</th>
							<th rowspan="3" width="3%">APBD</th><!--Penerimaan-->
							<th rowspan="3" width="3%">Harga</th>
							<th rowspan="3" width="3%">Total</th>
							<th rowspan="3" width="3%">APBD</th><!--Jumlah Pengeluaran-->
							<th rowspan="3" width="3%">Harga</th>
							<th rowspan="3" width="3%">Total</th>
							<th rowspan="3" width="3%">APBD</th><!--Saldo Administrasi-->
							<th rowspan="3" width="3%">Total</th>
							<!--<th rowspan="3" width="3%" >Unit</th><!--Selisih Administrasi & Fisik-->
							<!--<th rowspan="3" width="3%" >Rp.</th>-->
						</tr>
					</thead>
					<tbody style="font-size: 11px;">
						<?php
							$no = 0;							
							if($namaprogram == 'semua'){
								$str = "SELECT * FROM `ref_obat_lplpo`";
							}else{
								$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram`='$namaprogram'";	
							}
							$str_obat = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
							
							$query_obat = mysqli_query($koneksi,$str_obat);
							while($data = mysqli_fetch_assoc($query_obat)){
								if($namaprogram != $data['NamaProgram']){
									if($data['NamaProgram'] == "PKD"){
										$prg = "OBAT (PKD)";	
									}
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='23'>$prg</td></tr>";
									$namaprogram = $data['NamaProgram'];
								}
								$no = $no +1;
								$kodebarang = $data['KodeBarang'];
								$kodebaranggroup = $data['KodeBarangGroup'];
								$idbarangs = $data['IdBarang'];
								$namabarang = $data['NamaBarang'];
								
								// saldo awal, tampilkan berdasar Stok lebihdari 0
								$dt_2017= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `TahunAnggaran`='2017'"));
								$dt_2018= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `TahunAnggaran`='2018'"));
								$dt_2019= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `TahunAnggaran`='2019'"));
								$jml_akhir = $dt_2017['Stok'] + $dt_2018['Stok'] + $dt_2019['Stok'];			
								$saldo_akhir = ($dt_2017['Stok'] * $dt_2017['HargaBeli']) + ($dt_2018['Stok'] * $dt_2018['HargaBeli']) + ($dt_2019['Stok'] * $dt_2019['HargaBeli']);			
								$total = $total + $saldo_akhir;
								
								// penerimaan
								$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah, Harga FROM `tbgfkpenerimaandetail` WHERE `KodeBarang`='$kodebarang'"));
								$totalpenerimaan = $penerimaan['Jumlah'] * $penerimaan['Harga'];
								
								// totalpersediaan
								$totalpersediaan = $jml_akhir + $penerimaan['Jumlah'];
								
								// totalrupiah
								$totalrupiah = $saldo_akhir + $totalpenerimaan;
								
								// pengeluaran
								$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah, Harga FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodebarang'"));
								$totalpengeluaran = $pengeluaran['Jumlah'] * $pengeluaran['Harga'];
								
								// saldo administrasi
								$saldoadmin = $totalpersediaan - $pengeluaran['Jumlah'];
								$totalsaldoadmin = $saldoadmin * $pengeluaran['Harga'];
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:center;"><?php echo $kodebarang;?></td>
									<td class="namabarangcls" style="text-align:left;"><?php echo $namabarang;?></td>
									<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:right;"><!--saldoawal-->
										<?php echo rupiah($jml_akhir);?>
									</td>
									<td style="text-align:right;">
										<?php echo rupiah($saldo_akhir);?>
									</td>
									<td style="text-align:right;"><!--saldoawal_2017-->
										<?php
											if($dt_2017['Stok'] != ""){
												echo $dt_2017['Stok'];
											}else{
												echo "0";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php
											if($dt_2017['HargaBeli'] != 0){
												echo $dt_2017['HargaBeli'];
											}else{
												echo "0";
											}	
										?>
									</td>
									<td style="text-align:right;"><!--saldoawal_2018-->
										<?php
											if($dt_2018['Stok'] != ""){
												echo $dt_2018['Stok'];
											}else{
												echo "0";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php
											if($dt_2018['HargaBeli'] != 0){
												echo $dt_2018['HargaBeli'];
											}else{
												echo "0";
											}	
										?>
									</td>
									<td style="text-align:right;"><!--saldoawal_2019-->
										<?php
											if($dt_2019['Stok'] != ""){
												echo $dt_2019['Stok'];
											}else{
												echo "0";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php
											if($dt_2019['HargaBeli'] != 0){
												echo $dt_2019['HargaBeli'];
											}else{
												echo "0";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php echo rupiah($saldo_akhir);?>
									</td>
									<td style="text-align:right;"><!--penerimaan-->
										<?php echo rupiah($penerimaan['Jumlah']);?>
									</td>
									<td style="text-align:right;">
										<?php echo rupiah($penerimaan['Harga']);?>
									</td>
									<td style="text-align:right;">
										<?php echo rupiah($totalpenerimaan);?>
									</td>
									<td style="text-align:right;"><!--totalpersediaan-->
										<?php echo rupiah($totalpersediaan);?>
									</td>
									<td style="text-align:right;"><!--totalrupiah-->
										<?php echo rupiah($totalrupiah);?>
									</td>
									<td style="text-align:right;"><!--pengeluaran-->
										<?php echo rupiah($pengeluaran['Jumlah']);?>
									</td>
									<td style="text-align:right;">
										<?php echo rupiah($pengeluaran['Harga']);?>
									</td>
									<td style="text-align:right;">
										<?php echo rupiah($totalpengeluaran);?>
									</td>
									<td style="text-align:right;"><!--saldo administrasi-->
										<?php echo rupiah($saldoadmin);?>
									</td>
									<td style="text-align:right;">
										<?php echo rupiah($totalsaldoadmin);?>
									</td>
									<!--<td style="text-align:right;"></td>
									<td style="text-align:right;"></td>
									<td style="text-align:right;"></td>
									<td style="text-align:right;"></td>-->
								</tr>
							<?php
							}
							?>
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</body>
</html>