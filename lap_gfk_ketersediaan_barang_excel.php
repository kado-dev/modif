<?php
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$tanggal_awal = $_GET['tanggal_awal'];
	$tanggal_akhir = $_GET['tanggal_akhir'];
	$program = $_GET['program'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Ketersediaan_Barang (".$kota.").xls");
	if(isset($tanggal_awal) and isset($tanggal_akhir)){
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
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN KETERSEDIAAN BARANG</b></span><br>
	<span class="font12" style="margin:1px;">
		<?php 
			if($_GET['tanggal_awal'] == "" OR $_GET['tanggal_akhir'] == ""){		
		?>
			Periode Laporan: <?php echo nama_bulan(date('m'))." ".date('Y');?>
		<?php 
			}else{		
		?>
			Periode Laporan: <?php echo $_GET['tanggal_awal']." s/d ".$_GET['tanggal_akhir'];?>
		<?php 
			}	
		?>
		
	</span>
</div><br/>

<div class="row noprint">
	<div class="col-sm-12">
		<div class="table-responsive noprint">
			<table class="table table-condensed" border="1">
				<thead>
					<tr>
						<th width="3%" rowspan="2">No.</td>
						<th width="5%" rowspan="2">Kode</td>
						<th width="20%" rowspan="2">Nama Barang</td>
						<th width="5%" rowspan="2">Satuan</td>
						<th width="5%" rowspan="2">Batch</td>
						<th width="5%" rowspan="2">Harga<br/>Satuan</td>
						<th width="12%" rowspan="2">Sumber<br/>Anggaran</td>
						<th width="10%" rowspan="2">Suppliyer <br/></td>
						<th width="10%" colspan="2">Saldo Awal</td>
						<th width="10%" colspan="2">Penerimaan</td>
						<th width="10%" colspan="2">Pengeluaran</td>
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
								<td style="text-align:center;"><?php echo $data['KodeBarang'];?></td>
								<td style="text-align:left;" class="namabarangcls">
									<?php echo str_replace("+", "+ ", $data['NamaBarang']);?>
								</td>
								<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:left;"><?php echo $batch;?></td>
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
								<td style="text-align:center;"><?php echo $data['SumberAnggaran']." - ".$data['TahunAnggaran'];?></td>
								<td style="text-align:left;">
									<?php 
										$dtsupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$dtpenerimaan[KodeSupplier]'"));
										echo $dtsupplier['nama_prod_obat'];
									?>
								</td>
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
							<td align="center" colspan="9">Total</td>
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
<?php
}
?>