<?php
	include "config/helper_pasienrj.php";
	include_once('config/koneksi.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Keuangan (".$namapuskesmas." ".$kota.").xls");
?>
<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN KEUANGAN</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $_GET['tanggal_awal']." s/d ".$_GET['tanggal_akhir'];?></span>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%" rowspan="2">No.</td>
					<th width="15%" rowspan="2">Nama Barang</td>
					<th width="7%" rowspan="2">Satuan</td>
					<th width="5%" rowspan="2">Harga<br/>Satuan</td>
					<th width="7%" rowspan="2">Expire</td>
					<th width="10%" rowspan="2">Sumber Anggaran</td>
					<th width="10%" colspan="2">Saldo Awal</td>
					<th width="10%" colspan="2">Penerimaan</td>
					<th width="10%" colspan="2">Pengeluaran</td>
					<th width="10%" colspan="2">Saldo Akhir</td>
				</tr>
				<tr>
					<th>Jumlah</td><!--Saldo Awal-->
					<th>Saldo</td>
					<th>Jumlah</td><!--Penerimaan-->
					<th>Saldo</td>
					<th>Jumlah</td><!--Pengeluaran-->
					<th>Saldo</td>
					<th>Jumlah</td><!--Saldo Akhir-->
					<th>Saldo</td>
				</tr>
			</thead>
			<tbody>
				<?php
					
					$no = 0;
					$tanggal_awal = date("Y-m-d", strtotime($_GET['tanggal_awal']));
					$tanggal_akhir = date("Y-m-d", strtotime($_GET['tanggal_akhir']));
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
						$nobatch = $data['NoBatch'];
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
							<td style="text-align:center;"><?php echo $no;?></td>
							<td style="text-align:left;" class="namabarangcls"><?php echo $data['NamaBarang']." ".$kodebarang;?></td>
							<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:right;">
								<?php 
									$cx = strpos($hargabeli, ".");
									// $cx = strpos($hargabeli, ",");
									if($cx > 0){
										echo number_format($hargabeli,2,",",".");
									}else{
										echo $hargabeli;
									}
								?>
							</td>
							<td style="text-align:center;"><?php echo $expire;?></td>
							<td style="text-align:center;"><?php echo $sumberanggaran;?></td>
							<td style="text-align:right;"><?php echo $stokawal;?></td>
							<td style="text-align:right;"><?php echo $stokawal_ttl;?></td>
							<td style="text-align:right;"><?php echo $penerimaans;?></td>
							<td style="text-align:right;"><?php echo $penerimaan_ttls;?></td>
							<td style="text-align:right;"><?php echo $pengeluarans;?></td>
							<td style="text-align:right;"><?php echo $pengeluaran_ttls;?></td>
							<td style="text-align:right;"><?php echo $sisaakhir;?></td>
							<td style="text-align:right;"><?php echo $sisaakhir_ttl;?></td>
						</tr>
					<?php
					}
					
					?>
					<tr style="font-weight: bold;">
						<td align="center" colspan="7">Total</td>
						<td align="right"><?php echo number_format($ttl_stokawal,2,",",".");?></td>
						<td align="right"></td>
						<td align="right"><?php echo number_format($ttl_penerimaan,2,",",".");?></td>
						<td align="right"></td>
						<td align="right"><?php echo number_format($ttl_pengeluaran,2,",",".");?></td>
						<td align="right"></td>
						<td align="right"><?php echo number_format($ttl_sisaakhir,2,",",".");?></td>
					</tr>	
			</tbody>
		</table>
	</div>
</div>