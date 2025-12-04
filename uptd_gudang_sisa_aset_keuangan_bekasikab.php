<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>KEUANGAN </b><small>Gudang Besar</small></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="uptd_gudang_sisa_aset_keuangan_bekasikab"/>
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
						<div class="col-sm-3">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Barang">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=uptd_gudang_sisa_aset_keuangan_bekasikab" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="uptd_gudang_sisa_aset_keuangan_bekasikab_excel.php?tanggal_awal=<?php echo $_GET['tanggal_awal'];?>&tanggal_akhir=<?php echo $_GET['tanggal_akhir'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
							<!--<a href="javascript:print()" class="btn btn-primary btn-white">Print</a>-->
							<a href="uptd_gudang_sisa_aset_keuangan_bekasikab_print.php?tanggalawal=<?php echo $_GET['tanggal_awal'];?>&tanggalakhir=<?php echo $_GET['tanggal_akhir'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
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
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN KEUANGAN</b></span><br>
		<span class="font10" style="margin:15px 5px 5px 5px;">Periode : <?php echo $_GET['tanggal_awal']." s/d ".$_GET['tanggal_akhir'];?></span><br>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" style="width:1500px;">
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
							$jumlah_perpage = 50;
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}

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
							$str_obat = $str." ORDER BY NamaBarang LIMIT $mulai,$jumlah_perpage";
							// echo $str_obat;	
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}

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
												echo rupiah($hargabeli);
											}
										?>
									</td>
									<td style="text-align:center;"><?php echo $expire;?></td>
									<td style="text-align:center;"><?php echo $sumberanggaran;?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal);?></td>
									<td style="text-align:right;"><?php echo $stokawal_ttl;?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaans);?></td>
									<td style="text-align:right;"><?php echo $penerimaan_ttls;?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluarans);?></td>
									<td style="text-align:right;"><?php echo $pengeluaran_ttls;?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
									<td style="text-align:right;"><?php echo $sisaakhir_ttl;?></td>
								</tr>
							<?php
							}

							$query2 = mysqli_query($koneksi,$str);
							$jumlah_query = mysqli_num_rows($query2);
							
							if(($jumlah_query % $jumlah_perpage) > 0){
								$jumlah = ($jumlah_query / $jumlah_perpage)+1;
							}else{
								$jumlah = $jumlah_query / $jumlah_perpage;
							}
									
							if($_GET['h'] == Floor($jumlah)){

							$str2 = "SELECT KodeBarang, NoBatch, HargaBeli, SumberAnggaran FROM `tbgfkstok` ".$namabarang." GROUP BY KodeBarang, HargaBeli, SumberAnggaran";							
					
							$query_obat2 = mysqli_query($koneksi,$str2);
							while($data2 = mysqli_fetch_assoc($query_obat2)){
								$kodebarang = $data2['KodeBarang'];							
								$nobatch = $data2['NoBatch'];							
								$sumberanggaran = $data2['SumberAnggaran'];
								$hargabeli = $data2['HargaBeli'];

								$strstokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `HargaBeli`='$hargabeli' AND `SumberAnggaran`='$sumberanggaran' AND `Tahun`='$tahunlalu'";
								$dtstokawal = mysqli_fetch_assoc(mysqli_query($koneksi, $strstokawal));
								$stokawal = $dtstokawal['Stok'];
								$stokawalstok[] = $stokawal * $hargabeli;
								$ttl_stokawal = array_sum($stokawalstok);
								
								// penerimaan
								$strpenerimaan = "SELECT SUM(Jumlah) AS Jumlah, `Harga` FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND `Harga`='$hargabeli' AND a.`SumberAnggaran`='$sumberanggaran' AND YEAR(b.TanggalPenerimaan) > '2019' AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								$penerimaan = $dtpenerimaan['Jumlah'];
								$penerimaanstok[] = $penerimaan * $hargabeli;
								$ttl_penerimaan = array_sum($penerimaanstok);
								
								$strpenerimaan_vk = "SELECT SUM(Jumlah) AS Jumlah, `Harga` FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b. NomorPembukuan WHERE a.`KodeBarang`='$kodebarang' AND `Harga`='$hargabeli' AND YEAR(b.TanggalPenerimaan) > '2019' AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
								$dtpenerimaan_vk = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan_vk));
								$penerimaan_vk = $dtpenerimaan_vk['Jumlah'];
								$penerimaanstok_vk[] = $penerimaan * $hargabeli;
								$ttl_penerimaan_vk = array_sum($penerimaanstok_vk);
																
								if($jenisbarang == "VAKSIN"){
									$ttl_penerimaans = $ttl_penerimaan_vk;	
								}else{
									$ttl_penerimaans = $ttl_penerimaan;
								}	
								
								// pengeluaran
								$strpengeluaran = "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`Harga`='$hargabeli' AND a.`SumberAnggaran`='$sumberanggaran' AND YEAR(b.TanggalPengeluaran) > '2019' AND b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
								$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));
								$pengeluaran = $dtpengeluaran['Jumlah'];
								$pengeluaranstok[] = $pengeluaran * $hargabeli;
								$ttl_pengeluaran = array_sum($pengeluaranstok);
								
								$strpengeluaran_vk = "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfk_vaksin_pengeluarandetail` a JOIN `tbgfk_vaksin_pengeluaran` b ON a.NoFaktur = b.NoFaktur WHERE a.`KodeBarang`='$kodebarang' AND a.`Harga`='$hargabeli' AND YEAR(b.TanggalPengeluaran) > '2019' AND b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
								$dtpengeluaran_vk = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran_vk));
								$pengeluaran_vk = $dtpengeluaran_vk['Jumlah'];
								$pengeluaran_ttl_vk = $pengeluaran_vk * $hargabeli;
								
								if($jenisbarang == "VAKSIN"){
									$ttl_pengeluarans = $pengeluaran_ttl_vk;	
								}else{
									$ttl_pengeluarans = $ttl_pengeluaran;
								}
								
								// sisa akhir
								$sisaakhir = $stokawal + $penerimaan - $pengeluaran;
								$sisaakhirstok[] = $sisaakhir * $hargabeli;
								$ttl_sisaakhir = array_sum($sisaakhirstok);

							}	
							
							?>
							<tr style="font-weight: bold;">
								<td align="center" colspan="7">Total</td>
								<td align="right"><?php echo number_format($ttl_stokawal,2,",",".");?></td>
								<td align="right"></td>
								<td align="right"><?php echo number_format($ttl_penerimaans,2,",",".");?></td>
								<td align="right"></td>
								<td align="right"><?php echo number_format($ttl_pengeluarans,2,",",".");?></td>
								<td align="right"></td>
								<td align="right"><?php echo number_format($ttl_sisaakhir,2,",",".");?></td>
							</tr>	
							<?php
								}
							?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<ul class="pagination noprint">
		<?php			
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=uptd_gudang_sisa_aset_keuangan_bekasikab&tanggal_awal=$tanggal_awal&tanggal_akhir=$tanggal_akhir&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php }?>
</div>	