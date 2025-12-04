<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
	$tanggal_awal = $_GET['tanggal_awal'];
	$tanggal_akhir = $_GET['tanggal_akhir'];
	$program = $_GET['program'];
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
	<title>Ketersediaan Barang</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_gfk_ketersediaan_barang&tanggal_awal=<?php echo  $_GET['tanggal_awal'];?>&tanggal_akhir=<?php echo  $_GET['tanggal_akhir'];?>&program=<?php echo $_GET['program'];?>&key=<?php echo $_GET['key'];?>'">
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>KETERSEDIAAN BARANG</b></span><br>
		<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tanggal;?></span>
		<br/><br/>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</td>
							<th width="20%" rowspan="2">NAMA BARANG</td>
							<th width="7%" rowspan="2">SATUAN</td>
							<th width="5%" rowspan="2">HARGA<br/>SAT.</td>
							<th width="15%" rowspan="2">SUMBER<br/>ANGGARAN</td>
							<th colspan="2">SALDO AWAL</td>
							<th colspan="2">PENERIMAAN</td>
							<th colspan="2">PENGELUARAN</td>
							<th colspan="2">SALDO AKHIR</td>
						</tr>
						<tr>
							<th width="5%">JML</td><!--Saldo Awal-->
							<th>TTL</td>
							<th width="5%">JML</td><!--Penerimaan-->
							<th>TTL</td>
							<th width="5%">JML</td><!--Pengeluaran-->
							<th>TTL</td>
							<th width="5%">JML</td><!--Saldo Akhir-->
							<th>TTL</td>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php
							$no = 0;
							$tanggal_awal = date("Y-m-d", strtotime($_GET['tanggal_awal']));
							$tanggal_akhir = date("Y-m-d", strtotime($_GET['tanggal_akhir']));
							$tahun = date("Y", strtotime($tanggal_akhir));
							$tahunlalu = $tahun - 1;
							$program = $_GET['program'];
							$key = $_GET['key'];
							
							if($key != ""){
								$namabarang = "AND `NamaBarang` like '%$key%'";
							}else{
								$namabarang = "";
							}

							if($program == "semua"){
								$str = "SELECT * FROM `tbgfkstok` WHERE `NamaBarang` like '%$key%' GROUP BY KodeBarang, IdBarang";
							}else{
								$str = "SELECT * FROM `tbgfkstok` WHERE `NamaProgram` = '$program'".$namabarang." GROUP BY KodeBarang, IdBarang";
							}	
														
							// tahap1, tarik data dari tbgfkstok	
							$str_obat = $str." ORDER BY NamaBarang";
							// echo $str_obat;
														
							$query_obat = mysqli_query($koneksi,$str_obat);
							while($data = mysqli_fetch_assoc($query_obat)){
								$no = $no +1;
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$batch = $data['NoBatch'];
								$hargabeli = $data['HargaBeli'];
																							
								// tahap2, menentukan stok awal stok / saldo awal
								$strstokawal = "SELECT `Stok` FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$batch'";
								$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, $strstokawal));
								$stokawal = $dtstokawal['Stok'];
								$stokawal_ttl = $stokawal * $hargabeli;
								
								if(strpos($stokawal_ttl,".") != false){
									$stokawal_ttl = number_format($stokawal_ttl,2,",",".");
								}else{
									$stokawal_ttl = number_format($stokawal_ttl,0,",",".");
								}
								
								$stokawalstok[] = $stokawal * $hargabeli;
								$ttl_stokawal = array_sum($stokawalstok);
																
								// tahap3, menentukan penerimaan (tampil semua aja, tidak perlu tanggal nanti minus di sisa akhir)
								$strpenerimaan = "SELECT SUM(a.Jumlah) AS Jumlah, a.`Harga`, b.`KodeSupplier` FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND `NoBatch`='$batch'";
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								$penerimaan = $dtpenerimaan['Jumlah'];
								$penerimaan_ttl = $penerimaan * $hargabeli;
																
								if(strpos($penerimaan_ttl,".") != false){
									$penerimaan_ttl = number_format($penerimaan_ttl,2,",",".");
								}else{
									$penerimaan_ttl = number_format($penerimaan_ttl,0,",",".");
								}
								
								$penerimaanstok[] = $penerimaan * $hargabeli;
								$ttl_penerimaan = array_sum($penerimaanstok);
								
								// tahap4, menentukan pemakaian/pengeluaran
								if($_GET['tanggal_awal'] == "" AND $_GET['tanggal_akhir'] == ""){
									$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$batch'";
								}else{
									$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND `NoBatch`='$batch' AND b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
								}	
								$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
								$pengeluaran = $dtpengeluaran['Jumlah'];
								$pengeluaran_ttl = $pengeluaran * $hargabeli;
								
								if(strpos($pengeluaran_ttl,".") != false){
									$pengeluaran_ttl = number_format($pengeluaran_ttl,2,",",".");
								}else{
									$pengeluaran_ttl = number_format($pengeluaran_ttl,0,",",".");
								}
								
								$pengeluaranstok[] = $pengeluaran * $hargabeli;
								$ttl_pengeluaran = array_sum($pengeluaranstok);
								
								// tahap5, sisaakhir
								$sisaakhir = $stokawal + $penerimaan - $pengeluaran;
								$sisaakhir_ttl = $sisaakhir * $hargabeli;
								
								if(strpos($sisaakhir_ttl,".") != false){
									$sisaakhir_ttl = number_format($sisaakhir_ttl,2,",",".");
								}else{
									$sisaakhir_ttl = number_format($sisaakhir_ttl,0,",",".");
								}
								
								$sisaakhirstok[] = $sisaakhir * $hargabeli;
								$ttl_sisaakhir = array_sum($sisaakhirstok);
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:left;" class="namabarangcls">
										<?php 
											$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dtpenerimaan[KodeSupplier]'"));
											echo str_replace("+", "+ ", $data['NamaBarang'])."<br/>";											
											echo "<span style='font-size:10px'> Batch : ".str_replace(",", ", ", $batch)."</span><br/>";											
											echo "<span style='font-size:10px'> Supplier : ".$dtsupplier['nama_prod_obat']."</span>";											
											
										?>
									</td>
									<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:right;">
										<?php 
											$cx = strpos($hargabeli, ",");
											if($cx > 0){
												echo number_format($hargabeli,2,",",".");
											}else{
												echo rupiah($hargabeli);
											}
										?>
									</td>
									<td style="text-align:center;"><?php echo $data['SumberAnggaran']." - ".$data['TahunAnggaran'];?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal);?></td>
									<td style="text-align:right;"><?php echo $stokawal_ttl;?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
									<td style="text-align:right;"><?php echo $penerimaan_ttl;?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran);?></td>
									<td style="text-align:right;"><?php echo $pengeluaran_ttl;?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
									<td style="text-align:right;"><?php echo $sisaakhir_ttl;?></td>
								</tr>
							<?php
							}
							?>	
							<tr style="font-weight: bold;">
								<td align="center" colspan="6">Total</td>
								<td align="right"><?php echo rupiah($ttl_stokawal);?></td>
								<td align="right"></td>
								<td align="right"><?php echo rupiah($ttl_penerimaan);?></td>
								<td align="right"></td>
								<td align="right"><?php echo rupiah($ttl_pengeluaran);?></td>
								<td align="right"></td>
								<td align="right"><?php echo rupiah($ttl_sisaakhir);?></td>
							</tr>	
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</body>
</html>