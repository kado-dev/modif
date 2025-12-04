<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$keydate = $_GET['keydate'];
	// filter
	$tanggal_awal = $_GET['tanggalawal'];
	$tanggal_akhir = $_GET['tanggalakhir'];
	$key = $_GET['key'];
?>
<html lang="en">
<head>
	<title>Laporan Keuangan</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<body onload="window.print()" onafterprint="document.location = 'index.php?page=uptd_gudang_sisa_aset_keuangan_bekasikab&tanggal_awal=<?php echo $tanggal_awal;?>&tanggal_akhir=<?php echo $tanggal_akhir;?>&key=<?php echo $key;?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN KEUANGAN</b></span><br>
		<span class="font10" style="margin:15px 5px 5px 5px;">Periode : <?php echo $tanggal_awal." s/d ".$tanggal_akhir;?></span><br>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-condensed" width="100%">
				<thead style="font-size:11px;">
					<tr>
						<th width="3%" rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</td>
						<th width="22%" rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</td>
						<th width="5%" rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</td>
						<th width="5%" rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Harga<br/>Satuan</td>
						<th width="10%" rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Expire</td>
						<th width="15%" rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Sumber Anggaran</td>
						<th width="10%" colspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Saldo Awal</td>
						<th width="10%" colspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Penerimaan</td>
						<th width="10%" colspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Pengeluaran</td>
						<th width="10%" colspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Saldo Akhir</td>
					</tr>
					<tr>
						<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</td><!--Saldo Awal-->
						<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Saldo</td>
						<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</td><!--Penerimaan-->
						<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Saldo</td>
						<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</td><!--Pengeluaran-->
						<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Saldo</td>
						<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</td><!--Saldo Akhir-->
						<th style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Saldo</td>
					</tr>
				</thead>
				<tbody style="font-size:11px;">
					<?php
						$no = 0;
						$tanggal_awal = date("Y-m-d", strtotime($tanggal_awal));
						$tanggal_akhir = date("Y-m-d", strtotime($tanggal_akhir));
						$tahun = date("Y", strtotime($tanggal_akhir));
						$tahunlalu = $tahun - 1;
						$key = $_GET['key'];
						
						if($key != ""){
							$namabarang = "WHERE `NamaBarang` like '%$key%'";
						}else{
							$namabarang = "";
						}	
													
						// tahap1, tarik data dari tbgfkstok						
						$str = "SELECT * FROM `tbgfkstok` ".$namabarang." GROUP BY KodeBarang, HargaBeli, SumberAnggaran";	
						$str_obat = $str." ORDER BY NamaBarang";
						// echo $str_obat;
																			
						$query_obat = mysqli_query($koneksi,$str_obat);
						while($data = mysqli_fetch_assoc($query_obat)){
							$no = $no +1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							$batch = $data['NoBatch'];
							$hargabeli = $data['HargaBeli'];
							$expire = $data['Expire'];
							$sumberanggaran = $data['SumberAnggaran'];
							$jenisbarang = $data['JenisBarang'];
																						
							// tahap2, menentukan stok awal stok / saldo awal (berdasarkan kode barang saja karena disum dan diloopingnya pakai group)
							$strstokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `HargaBeli`='$hargabeli' AND `SumberAnggaran`='$sumberanggaran' AND `Tahun`='$tahunlalu'";
							$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, $strstokawal));
							$stokawal = $dtstokawal['Stok'];
							$stokawal_ttl = $stokawal * $hargabeli;
							
							if(strpos($stokawal_ttl,".") != false){
								$stokawal_ttl = number_format($stokawal_ttl,2,",",".");
							}else{
								$stokawal_ttl = number_format($stokawal_ttl,2,",",".");
							}
							
							$stokawalstok[] = $stokawal * $hargabeli;
							$ttl_stokawal = array_sum($stokawalstok);
															
							// tahap3, menentukan penerimaan
							$strpenerimaan = "SELECT SUM(Jumlah) AS Jumlah, `Harga` FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND `Harga`='$hargabeli' AND a.`SumberAnggaran`='$sumberanggaran' AND YEAR(b.TanggalPenerimaan) > '2019' AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
							$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
							$penerimaan = $dtpenerimaan['Jumlah'];
							$penerimaan_ttl = $penerimaan * $hargabeli;
															
							if(strpos($penerimaan_ttl,".") != false){
								$penerimaan_ttl = number_format($penerimaan_ttl,2,",",".");
							}else{
								$penerimaan_ttl = number_format($penerimaan_ttl,2,",",".");
							}
							
							$penerimaanstok[] = $penerimaan * $hargabeli;
							$ttl_penerimaan = array_sum($penerimaanstok);
							
							// penerimaan vaksin (jika vaksin tidak udah pakai sumber anggaran sudah pasti APDN)
							$strpenerimaan_vk = "SELECT SUM(Jumlah) AS Jumlah, `Harga` FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND `Harga`='$hargabeli' AND YEAR(b.TanggalPenerimaan) > '2019' AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
							$dtpenerimaan_vk = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan_vk));
							$penerimaan_vk = $dtpenerimaan_vk['Jumlah'];
							$penerimaan_ttl_vk = $penerimaan_vk * $hargabeli;
							
							if(strpos($penerimaan_ttl_vk,".") != false){
								$penerimaan_ttl_vk = number_format($penerimaan_ttl_vk,2,",",".");
							}else{
								$penerimaan_ttl_vk = number_format($penerimaan_ttl_vk,2,",",".");
							}
							
							if($jenisbarang == "VAKSIN"){
								$penerimaans = $penerimaan_vk;	
								$penerimaan_ttls = $penerimaan_ttl_vk;
							}else{
								$penerimaans = $penerimaan;
								$penerimaan_ttls = $penerimaan_ttl;	
							}	
							
							// tahap4, menentukan pemakaian/pengeluaran
							$strpengeluaran = "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`Harga`='$hargabeli' AND a.`SumberAnggaran`='$sumberanggaran' AND YEAR(b.TanggalPengeluaran) > '2019' AND b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
							$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
							$pengeluaran = $dtpengeluaran['Jumlah'];
							$pengeluaran_ttl = $pengeluaran * $hargabeli;
							
							if(strpos($pengeluaran_ttl,".") != false){
								$pengeluaran_ttl = number_format($pengeluaran_ttl,2,",",".");
							}else{
								$pengeluaran_ttl = number_format($pengeluaran_ttl,2,",",".");
							}
							
							$pengeluaranstok[] = $pengeluaran * $hargabeli;
							$ttl_pengeluaran = array_sum($pengeluaranstok);
							
							// pengeluaran vaksin
							$strpengeluaran_vk = "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`Harga`='$hargabeli' AND YEAR(b.TanggalPengeluaran) > '2019' AND b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
							$dtpengeluaran_vk = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran_vk));
							$pengeluaran_vk = $dtpengeluaran_vk['Jumlah'];
							$pengeluaran_ttl_vk = $pengeluaran_vk * $hargabeli;
							
							if(strpos($pengeluaran_ttl_vk,".") != false){
								$pengeluaran_ttl_vk = number_format($pengeluaran_ttl_vk,2,",",".");
							}else{
								$pengeluaran_ttl_vk = number_format($pengeluaran_ttl_vk,2,",",".");
							}
							
							if($jenisbarang == "VAKSIN"){
								$pengeluarans = $pengeluaran_vk;	
								$pengeluaran_ttls = $pengeluaran_ttl_vk;
							}else{
								$pengeluarans = $pengeluaran;
								$pengeluaran_ttls = $pengeluaran_ttl;	
							}
							
							// tahap5, sisaakhir
							$sisaakhir = $stokawal + $penerimaan - $pengeluaran;
							$sisaakhir_ttl = $sisaakhir * $hargabeli;
							
							if(strpos($sisaakhir_ttl,".") != false){
								$sisaakhir_ttl = number_format($sisaakhir_ttl,2,",",".");
							}else{
								$sisaakhir_ttl = number_format($sisaakhir_ttl,2,",",".");
							}
							
							$sisaakhirstok[] = $sisaakhir * $hargabeli;
							$ttl_sisaakhir = array_sum($sisaakhirstok);
					?>
							<tr>
								<td style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;" class="namabarangcls"><?php echo strtoupper($namabarang);?></td>
								<td style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">
									<?php 
										$cx = strpos($hargabeli, ".");
										if($cx > 0){
											echo number_format($hargabeli,2,",",".");
										}else{
											echo rupiah($hargabeli);
										}
									?>
								</td>
								<td style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $expire;?></td>
								<td style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $sumberanggaran;?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($stokawal);?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $stokawal_ttl;?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($penerimaans);?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $penerimaan_ttls;?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($pengeluarans);?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $pengeluaran_ttls;?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo rupiah($sisaakhir);?></td>
								<td style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $sisaakhir_ttl;?></td>
							</tr>
						<?php
						}
						?>	
						<tr style="font-weight: bold;">
							<td align="center" colspan="7" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Total</td>
							<td align="right" style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo number_format($ttl_stokawal,2,",",".");?></td>
							<td align="right" style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"></td>
							<td align="right" style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo number_format($ttl_penerimaan,2,",",".");?></td>
							<td align="right" style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"></td>
							<td align="right" style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo number_format($ttl_pengeluaran,2,",",".");?></td>
							<td align="right" style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"></td>
							<td align="right" style="text-align:right;width:0.5%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo number_format($ttl_sisaakhir,2,",",".");?></td>
						</tr>	
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>