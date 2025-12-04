<?php
	include "config/helper_pasienrj.php";
	include "config/helper.php";
	include_once('config/koneksi.php');
	session_start();
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
		
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Sisa_Aset (".$namapuskesmas." ".$kota.").xls");
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
.str{
	mso-number-format:\@; 
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERSEDIAAN</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $_GET['tanggal_awal']." s/d ".$_GET['tanggal_akhir'];?></span>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%" rowspan="2">No.</td>
					<th width="20%" rowspan="2">Nama Barang</td>
					<th width="7%" rowspan="2">Satuan</td>
					<th width="7%" rowspan="2">Batch</td>
					<th width="5%" rowspan="2">Harga<br/>Satuan</td>
					<th width="10%" rowspan="2">Sumber<br/>Anggaran</td>
					<th width="15%" colspan="2">Saldo Awal</td>
					<th width="15%" colspan="2">Penerimaan</td>
					<th width="15%" colspan="2">Pengeluaran</td>
					<th width="15%" colspan="2">Saldo Akhir</td>
				</tr>
				<tr>
					<th>Jumlah</td><!--Saldo Awal-->
					<th>Total<br/>Harga</td>
					<th>Jumlah</td><!--Penerimaan-->
					<th>Total<br/>Harga</td>
					<th>Jumlah</td><!--Pengeluaran-->
					<th>Total<br/>Harga</td>
					<th>Jumlah</td><!--Saldo Akhir-->
					<th>Total<br/>Harga</td>
				</tr>
			</thead>
			<tbody>
				<?php								
					$no = 0;
					$tanggal_awal = date("Y-m-d", strtotime($_GET['tanggal_awal']));
					$tanggal_akhir = date("Y-m-d", strtotime($_GET['tanggal_akhir']));
					$tahunawal = date("Y", strtotime($tanggal_awal));
					$bulanawal = date("m", strtotime($tanggal_awal));
					if ($bulanawal == '01'){
						$bulanlalu = "12";
						$tahunlalu = $tahunawal - 1;
					}else{
						$bulanlalu = $bulanawal - 1;
						$tahunlalu = $tahunawal;
					}
					
					$bulanakhir = date("m", strtotime($tanggal_akhir));
					$tahunakhir = date("Y", strtotime($tanggal_akhir));
					$sumberanggaran = $_GET['sumberanggaran'];
					$key = $_GET['key'];
					
					if($key != ""){
						$namabarang = "AND (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%')";
					}else{
						$namabarang = "";
					}	
																			
					// tahap1, tarik data dari tbgfkstok	
					if($sumberanggaran == 'Semua'){
						$str = "SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%') GROUP BY `KodeBarang`,`NoBatch`";	
					}elseif($sumberanggaran == 'Semua Apbd'){
						$str = "SELECT * FROM `tbgfkstok` WHERE (`SumberAnggaran` LIKE '%APBD OBAT%' OR `SumberAnggaran` LIKE '%APBD BAHAN OBAT%') AND (`NamaBarang` LIKE '%$key%' OR `KodeBarang` LIKE '%$key%' OR `NoBatch` LIKE '%$key%') GROUP BY `KodeBarang`,`NoBatch`";
					}else{
						$str = "SELECT * FROM `tbgfkstok` WHERE `SumberAnggaran`='$sumberanggaran'".$namabarang." GROUP BY `KodeBarang`,`NoBatch`";	
					}	
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
						$nofakturterima = $data['NoFakturTerima'];
																					
						// tahap2, menentukan stok awal stok / saldo awal
						if($tahunawal == '2020'){
							$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `HargaBeli`='$hargabeli' AND `SumberAnggaran`='$sumberanggaran' AND `NoBatch`='$nobatch' AND `Tahun`='$tahunlalu'";
						}else{
							$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
						}	
						// echo "Hasil : ".$str_stokawal;
						$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
						if ($dt_stokawal_dtl['Stok'] != null){
							$stokawal = $dt_stokawal_dtl['Stok'];
						}else{
							$stokawal = '0';
						}
						
						// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
						if(substr($namabarang,0,6) == "VAKSIN" || substr($namabarang,0,7) == "PELARUT"){
							$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
							FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NomorPembukuan`='$nofakturterima' AND (b.TanggalPenerimaan < '$tanggal_awal' AND YEAR(b.TanggalPenerimaan) != 2019)";
						}else{
							$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
							FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NomorPembukuan`='$nofakturterima' AND (b.TanggalPenerimaan < '$tanggal_awal' AND YEAR(b.TanggalPenerimaan) != 2019)";
						}
						// echo $str_terima_lalu;
						$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
						if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
							$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
						}else{
							$penerimaan_lalu = '0';
						}

						// tahap2.2 cek pengeluaran sebelumnya
						if(substr($namabarang,0,6) == "VAKSIN" || substr($namabarang,0,7) == "PELARUT"){
							$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
							JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NoFakturTerima`='$nofakturterima' AND b.TanggalPengeluaran < '$tanggal_awal'";	
						}else{
							$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
							JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
							WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NoFakturTerima`='$nofakturterima' AND b.TanggalPengeluaran < '$tanggal_awal' AND a.`Harga`='$hargabeli'";	
						}
						// echo $str_pengeluaran_lalu;
						$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
						if ($dt_pengeluaran_lalu['Jumlah'] != null){
							$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
						}else{
							$pengeluaran_lalu = '0';
						}	
						
						// tahap2.3 cek pengeluaran sebelumnya
						$str_pengeluaran_lalu_2019 = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
						JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
						WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) = '2019'";	
						// echo $str_pengeluaran_lalu_2019;
						$dt_pengeluaran_lalu_2019 = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu_2019));									
						if ($dt_pengeluaran_lalu_2019['Jumlah'] != null){
							$pengeluaran_lalu_2019 = $dt_pengeluaran_lalu_2019['Jumlah'];
						}else{
							$pengeluaran_lalu_2019 = '0';
						}	
						
						$pengeluaran_lalu_jumlah = $pengeluaran_lalu - $pengeluaran_lalu_2019;
						if ($pengeluaran_lalu_jumlah < 0){
							$pengeluaran_lalu_jumlah1 = 0;
						}else{
							$pengeluaran_lalu_jumlah1 = $pengeluaran_lalu_jumlah;
						}	
						
						// tahap 2.4 cek karantina lalu
						$str_karantina_lalu = "SELECT SUM(`Jumlah`) AS Jumlah , TanggalKarantina, StatusKarantina 
						FROM `tbgfk_karantinadetail` 
						WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND TanggalKarantina < '$tanggal_awal'";
						$dt_karantina_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina_lalu));
						$karantina_lalu = $dt_karantina_lalu['Jumlah'];
								
						$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu_jumlah1 - $karantina_lalu;
						$stokawal_rupiah = $stokawal_total * $hargabeli;	

						if(strpos($stokawal_rupiah,".") != false){
							$stokawal_rupiah = number_format($stokawal_rupiah,2,",",".");
						}else{
							$stokawal_rupiah = number_format($stokawal_rupiah,0,",",".");
						}	
						
						$stokawalstok[] = $stokawal_total * $hargabeli;
						$ttl_stokawal = array_sum($stokawalstok);								
						$itemstokawalstok[] = $stokawal_total;
						$jml_item_stokawal = array_sum($itemstokawalstok);	
						
						// tahap3, menentukan penerimaan
						$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah) AS Jumlah, `Harga` FROM `tbgfkpenerimaandetail` a
						JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
						WHERE a.`KodeBarang`='$kodebarang' AND a.`Nobatch`='$nobatch'
						AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
						AND a.`NomorPembukuan`='$data[NoFakturTerima]'";
						$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
						if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
							$penerimaan_ob = $dtpenerimaan['Jumlah'];
						}else{
							$penerimaan_ob = '0';
						}															
						$penerimaan_ob_rupiah = $penerimaan_ob * $hargabeli;
						
						// penerimaan vaksin (jika vaksin tidak udah pakai sumber anggaran sudah pasti APBN)
						$strpenerimaan_vk = "SELECT Jumlah FROM `tbgfk_vaksin_penerimaandetail` a 
						JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
						WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NomorPembukuan`='$nofakturterima' 
						AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
						$dtpenerimaan_vk = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan_vk));
						if ($dtpenerimaan_vk['Jumlah'] != null || $dtpenerimaan_vk['Jumlah'] != 0){
							$penerimaan_vk = $dtpenerimaan_vk['Jumlah'];
						}else{
							$penerimaan_vk = '0';
						}
						
						$penerimaan_vk_rupiah = $penerimaan_vk * $hargabeli;
						
						
						if($jenisbarang == "VAKSIN"){
							$penerimaan = $penerimaan_vk;	
							$penerimaan_rupiah = $penerimaan_vk_rupiah;
						}else{
							$penerimaan = $penerimaan_ob;
							$penerimaan_rupiah = $penerimaan_ob_rupiah;	
						}

						if(strpos($penerimaan_rupiah,".") != false){
							$penerimaan_rupiah = number_format($penerimaan_rupiah,2,",",".");
						}else{
							$penerimaan_rupiah = number_format($penerimaan_rupiah,0,",",".");
						}	
						
						$penerimaanstok[] = $penerimaan * $hargabeli;
						$ttl_penerimaan = array_sum($penerimaanstok);								
						$itempenerimaanstok[] = $penerimaan;
						$jml_item_penerimaan = array_sum($itempenerimaanstok);								
												
						// tahap4, karantina gak peru bulan tahun katrena berdasarkan batch
						$str_karantina = "SELECT SUM(`Jumlah`) AS Jumlah , TanggalKarantina, StatusKarantina 
						FROM `tbgfk_karantinadetail` 
						WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND TanggalKarantina BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
						$dt_karantina = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
						$karantina = $dt_karantina['Jumlah'];
						$karantina_ttl = $karantina * $hargabeli;
						$karantinastok[] = $karantina * $hargabeli;
						$ttl_karantina = array_sum($karantinastok);
						
						// tahap5, menentukan pemakaian/pengeluaran
						$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
						JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
						WHERE a.`KodeBarang`='$kodebarang' AND a.`Harga`='$hargabeli' AND a.`NoBatch`='$nobatch' 
						AND a.`NoFakturTerima`='$nofakturterima' AND b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
						// echo $strpengeluaran;
						$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));								
						if ($dtpengeluaran['Jumlah'] != null || $dtpengeluaran['Jumlah'] != 0){
							$pengeluaran = $dtpengeluaran['Jumlah'];
						}else{
							$pengeluaran = '0';
						}								
						$pengeluaran_ob_rupiah = $pengeluaran * $hargabeli;
						
						// pengeluaran vaksin
						$strpengeluaran_vk = "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
						JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur 
						WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NoFakturTerima`='$nofakturterima' 
						AND b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
						$dtpengeluaran_vk = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran_vk));
						$pengeluaran_vk = $dtpengeluaran_vk['Jumlah'];
						$pengeluaran_ttl_vk = ($pengeluaran_vk + $karantina) * $hargabeli;
						
						if($jenisbarang == "VAKSIN"){
							$pengeluarans = $pengeluaran_vk + $karantina;	
							$pengeluaran_ttls = $pengeluaran_ttl_vk;
						}else{
							$pengeluarans = $pengeluaran + $karantina;
							$pengeluaran_ttls = $pengeluaran_ob_rupiah;	
						}
						
						if(strpos($pengeluaran_ttls,".") != false){
							$pengeluaran_ttls = number_format($pengeluaran_ttls,2,",",".");
						}else{
							$pengeluaran_ttls = number_format($pengeluaran_ttls,0,",",".");
						}
						
						$pengeluaranstok[] = $pengeluarans * $hargabeli;
						$ttl_pengeluaran = array_sum($pengeluaranstok);
						
						$itempengeluaranstok[] = $pengeluarans;
						$jml_item_pengeluaran = array_sum($itempengeluaranstok);
														
						// tahap6, sisaakhir
						$sisaakhir = $stokawal_total + $penerimaan - $pengeluarans;
						$sisaakhir_ttl = $sisaakhir * $hargabeli;
						
						if(strpos($sisaakhir_ttl,".") != false){
							$sisaakhir_ttl = number_format($sisaakhir_ttl,2,",",".");
						}else{
							$sisaakhir_ttl = number_format($sisaakhir_ttl,0,",",".");
						}
						
						$sisaakhirstok[] = $sisaakhir * $hargabeli;
						$ttl_sisaakhir = array_sum($sisaakhirstok);
						
						$itemsisaakhirstok[] = $sisaakhir;
						$jml_item_sisaakhirstok = array_sum($itemsisaakhirstok);
						
				?>
					<tr>
						<td style="text-align:center;"><?php echo $no;?></td>
						<td style="text-align:left;">
							<?php 
								echo "<b>".$data['NamaBarang'].", ".$data['KodeBarang']."</b><br/>";
								// echo $data['KodeBarang']."<br/>";
								// echo "<b>Keterangan :</b><br/>";
								// echo "Stok Master = ".$stokawal."<br/>";
								// echo "Penerimaan Lalu = ".$penerimaan_lalu."<br/>";
								// echo "Penerimaan = ".$penerimaan."<br/>";
								// echo "Pengeluaran Lalu = ".$pengeluaran_lalu_jumlah."<br/>";
								// echo "Pengeluaran = ".$pengeluarans."<br/>";
								// echo "Karantina Lalu = ".$karantina_lalu."<br/>";
								// echo "Karantina = ".$karantina."<br/>";
								// echo "Saldo Awal = ".$stokawal_total;
							?>
						</td>
						<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:left;"><?php echo $nobatch;?></td>
						<td style="text-align:right;">
							<?php 
								$cx = strpos($hargabeli, ".");
								// $cx = strpos($hargabeli, ",");
								if($cx > 0){
									echo number_format($hargabeli,2,",",".");
								}else{
									echo rupiah($hargabeli);
								}
							?>
						</td>
						<td style="text-align:center;"><?php echo $data['SumberAnggaran'];?></td>
						<td style="text-align:right;" class="str"><?php echo rupiah($stokawal_total);?></td>
						<td style="text-align:right;" class="str"><?php echo $stokawal_rupiah;?></td>
						<td style="text-align:right;" class="str"><?php echo rupiah($penerimaan);?></td>
						<td style="text-align:right;" class="str"><?php echo $penerimaan_rupiah;?></td>
						<td style="text-align:right;" class="str"><?php echo rupiah($pengeluarans);?></td>
						<td style="text-align:right;" class="str"><?php echo $pengeluaran_ttls;?></td>
						<td style="text-align:right;" class="str"><?php echo rupiah($sisaakhir);?></td>
						<td style="text-align:right;" class="str"><?php echo $sisaakhir_ttl;?></td>
					</tr>
					<?php
						}
					?>
					<tr style="font-weight: bold;">
						<td align="center" colspan="6">Total</td>
						<td align="right"><?php echo number_format($jml_item_stokawal,2,",",".");?></td>
						<td align="right"><?php echo number_format($ttl_stokawal,2,",",".");?></td>
						<td align="right"><?php echo number_format($jml_item_penerimaan,2,",",".");?></td>
						<td align="right"><?php echo number_format($ttl_penerimaan,2,",",".");?></td>
						<td align="right"><?php echo number_format($jml_item_pengeluaran,2,",",".");?></td>
						<td align="right"><?php echo number_format($ttl_pengeluaran,2,",",".");?></td>
						<td align="right"><?php echo number_format($jml_item_sisaakhirstok,2,",",".");?></td>
						<td align="right"><?php echo number_format($ttl_sisaakhir,2,",",".");?></td>
					</tr>
			</tbody>
		</table>
	</div>
</div>