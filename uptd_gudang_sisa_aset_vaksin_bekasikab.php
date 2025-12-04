<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>KETERSEDIAAN </b><small>Gudang Vaksin</small></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="uptd_gudang_sisa_aset_vaksin_bekasikab"/>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon tesdate">
									<span class="fa fa-calendar"></span>
								</span>
								<input type="text" name="tanggal_awal" class="form-control datepicker" value="<?php echo $_GET['tanggal_awal'];?>" placeholder="Tanggal Awal" autofocus required>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon tesdate">
									<span class="fa fa-calendar"></span>
								</span>
								<input type="text" name="tanggal_akhir" class="form-control datepicker" value="<?php echo $_GET['tanggal_akhir'];?>" placeholder="Tanggal Akhir" required>
							</div>
						</div>
						<div class="col-sm-2">
							<select name="sumberanggaran" class="form-control">
								<option value="Semua" <?php if($_GET['sumberanggaran'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD KAB/KOTA</option>
								<option value="APBD PROV" <?php if($_GET['sumberanggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBN / APBD PROV</option>
								<option value="HIBAH" <?php if($_GET['sumberanggaran'] == 'HIBAH'){echo "SELECTED";}?>>HIBAH</option>
								<option value="LAINNYA" <?php if($_GET['sumberanggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
							</select>
						</div>	
						<div class="col-sm-2">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Barang">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=uptd_gudang_sisa_aset_vaksin_bekasikab" class="btn btn-success"><span class="fa fa-refresh"></span></a>
							<a href="uptd_gudang_sisa_aset_vaksin_bekasikab_excel.php?tanggal_awal=<?php echo $_GET['tanggal_awal'];?>&tanggal_akhir=<?php echo $_GET['tanggal_akhir'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-info">Excel</a>
							<a href="javascript:print()" class="btn btn-primary">Print</a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php
		if(isset($_GET['tanggal_awal'])){
	?>	
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERSEDIAAN VAKSIN</b></span><br>
		<span class="font10" style="margin:15px 5px 5px 5px;">Periode : <?php echo $_GET['tanggal_awal']." s/d ".$_GET['tanggal_akhir'];?></span><br>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="2">No.</td>
							<th width="20%" rowspan="2">Nama Barang</td>
							<th width="7%" rowspan="2">Satuan</td>
							<th width="5%" rowspan="2">Batch</td>
							<th width="5%" rowspan="2">Harga<br/>Satuan</td>
							<th width="12%" rowspan="2">Sumber<br/>Anggaran</td>
							<th width="15%" colspan="2">Saldo Awal</td>
							<th width="15%" colspan="2">Penerimaan</td>
							<th width="15%" colspan="2">Pengeluaran</td>
							<th width="15%" colspan="2">Saldo Akhir</td>
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
							$tahun = date("Y", strtotime($tanggal_awal));
							$tahunlalu = $tahun - 1;
							$sumberanggaran = $_GET['sumberanggaran'];
							$key = $_GET['key'];
							
							if($key != ""){
								$namabarang = "AND `NamaBarang` like '%$key%'";
							}else{
								$namabarang = "";
							}	
														
							// tahap1, tarik data dari tbgfk_vaksin_stok	
							if($sumberanggaran == 'Semua'){
								$str = "SELECT * FROM `tbgfk_vaksin_stok` WHERE `namabarang` like '%$key%' GROUP BY `NoBatch`";	
							}else{
								$str = "SELECT * FROM `tbgfk_vaksin_stok` WHERE `SumberAnggaran`='$sumberanggaran' GROUP BY `NoBatch`".$namabarang;	
							}	
							$str_obat = $str." ORDER BY NamaBarang, NoBatch";
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
								$strstokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_vaksin` WHERE `KodeBarang`='$kodebarang' AND `HargaBeli`='$hargabeli' AND `SumberAnggaran`='$sumberanggaran' AND `NoBatch`='$nobatch' AND `Tahun` < '$tahun'";
								$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, $strstokawal));
								if ($dtstokawal['Stok'] != ''){
									$stokawal = $dtstokawal['Stok'];
								}else{
									$stokawal = '0';
								}							
								
								// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
								$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
								FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPenerimaan < '$tanggal_awal'";
								// echo $str_terima_lalu;
								$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
								if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
									$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
								}else{
									$penerimaan_lalu = '0';
								}
								
								// tahap2.2 cek pengeluaran sebelumnya
								$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a 
								JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPengeluaran < '$tanggal_awal'";	
								// echo $str_pengeluaran_lalu;
								$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
								if ($dt_pengeluaran_lalu['Jumlah'] != null){
									$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
								}else{
									$pengeluaran_lalu = '0';
								}
								
								// echo "Stok Awal : ".$stokawal."<br/>";
								// echo "Penerimaan Lalu : ".$penerimaan_lalu."<br/>";
								// echo "Pengeluaran Lalu : ".$pengeluaran_lalu."<br/>";
								
								$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;
								$stokawal_total_rupiah = $stokawal_total * $hargabeli;	

								$stokawalstok[] = $stokawal_total * $hargabeli;
								$ttl_stokawal = array_sum($stokawalstok);
								
								$itemstokawalstok[] = $stokawal_total;
								$jml_item_stokawal = array_sum($itemstokawalstok);								
																
								// tahap3, menentukan penerimaan
								$strpenerimaan = "SELECT Jumlah FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND a.`Nobatch`='$nobatch' AND a.`NomorPembukuan`='$nofakturterima' AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								$penerimaan = $dtpenerimaan['Jumlah'];
								$penerimaan_ttl = $penerimaan * $hargabeli;
																
								if(strpos($penerimaan_ttl,".") != false){
									$penerimaan_ttl = number_format($penerimaan_ttl,2,",",".");
								}else{
									$penerimaan_ttl = number_format($penerimaan_ttl,0,",",".");
								}
								
								$penerimaans = $penerimaan;
								$penerimaan_ttls = $penerimaan_ttl;	
								
								$penerimaanstok[] = $penerimaans * $hargabeli;
								$ttl_penerimaan = array_sum($penerimaanstok);
								
								$itempenerimaanstok[] = $penerimaans;
								$jml_item_penerimaan = array_sum($itempenerimaanstok);								
														
								// tahap4, karantina
								$str_karantina = "SELECT a.`Jumlah`, b.TanggalKarantina, b.NoFaktur, b.StatusKarantina FROM `tbgfk_karantinadetail` a JOIN `tbgfk_karantina` b ON a.NoFaktur=b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch'";
								$dt_karantina = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
								$karantina = $dt_karantina['Jumlah'];
								$karantina_ttl = $karantina * $hargabeli;
														
								$karantinastok[] = $karantina * $hargabeli;
								$ttl_karantina = array_sum($karantinastok);
								
								// tahap5, menentukan pemakaian/pengeluaran
								$strpengeluaran = "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`Harga`='$hargabeli' AND a.`NoBatch`='$nobatch' AND a.`NoFakturTerima`='$nofakturterima' AND b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
								// echo $strpengeluaran;
								$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
								$pengeluaran = $dtpengeluaran['Jumlah'];
								$pengeluaran_ttl = ($pengeluaran + $karantina) * $hargabeli;
								
								$pengeluarans = $pengeluaran + $karantina;
								$pengeluaran_ttls = $pengeluaran_ttl;	
								
								if(strpos($pengeluaran_ttls,".") != false){
									$pengeluaran_ttls = number_format($pengeluaran_ttls,2,",",".");
								}else{
									$pengeluaran_ttls = number_format($pengeluaran_ttls,0,",",".");
								}
								
								$pengeluaranstok[] = $pengeluarans * $hargabeli;
								$ttl_pengeluaran = array_sum($pengeluaranstok);
								
								$itempengeluaranstok[] = $pengeluarans;
								$jml_item_pengeluaran = array_sum($itempengeluaranstok);
								
								// tahap5, sisaakhir
								$sisaakhir = $stokawal_total + $penerimaans - $pengeluarans;
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
									<td style="text-align:left;"><?php echo $data['NamaBarang'],", ".$data['KodeBarang'];?></td>
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
									<td style="text-align:right;"><?php echo rupiah($stokawal_total);?></td>
									<td style="text-align:right;"><?php echo $stokawal_total_rupiah;?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaans);?></td>
									<td style="text-align:right;"><?php echo $penerimaan_ttls;?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluarans);?></td>
									<td style="text-align:right;"><?php echo $pengeluaran_ttls;?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
									<td style="text-align:right;"><?php echo $sisaakhir_ttl;?></td>
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
	</div>
	<?php }?>
</div>	