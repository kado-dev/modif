<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK OPNAME (TRIWULAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="uptd_gudang_sisa_aset_triwulan_bogorkab"/>
						<div class="col-sm-2">
							<div class="tampilformdate">
								<div class="input-group tampilformdate">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
									<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="tampilformdate">
								<div class="input-group tampilformdate">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
									<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
								</div>
							</div>
						</div>					
						<div class="col-sm-3">
							<div class="input-group">
								<select name="namaprg" class="form-control">
									<option value='Semua'>Semua</option>
									<?php
									$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['namaprg'] == $data3['nama_program']){
											echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
										}else{
											echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
										}
									}
									?>
								</select>
								<span class="input-group-addon">Program</span>
							</div>
						</div>
						<div class="col-sm-2">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nama Barang">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=uptd_gudang_sisa_aset_triwulan_bogorkab" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="uptd_gudang_sisa_aset_triwulan_bogorkab_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&namaprg=<?php echo $_GET['namaprg'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
		$keydate1 = $_GET['keydate1'];
		$keydate2 = $_GET['keydate2'];	
		$namaprg = $_GET['namaprg'];
		$key = $_GET['key'];
		if(isset($_GET['namaprg'])){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan"><!--style="width:1200px;"-->
					<thead>
						<tr>
							<th rowspan="2">No.</th>
							<th rowspan="2">Kode</th>
							<th rowspan="2" width="15%">Nama Barang</th>
							<th rowspan="2">Satuan</th>
							<th rowspan="2">Batch</th>
							<th rowspan="2">Harga<br/>Satuan</th>
							<th rowspan="2">Sumber</th>
							<th rowspan="2">Tahun</th>
							<th colspan="2">Saldo Awal</th>
							<th colspan="2">Penerimaan</th>
							<th colspan="2">Persediaan</th>
							<th colspan="2">Pengeluaran</th>
							<th colspan="2">Sisa Akhir</th>
						</tr>
						<tr>
							<th>Jml</th><!--Saldo Awal-->
							<th>Saldo</th>
							<th>Jml</th><!--Penerimaan-->
							<th>Saldo</th>
							<th>Jml</th><!--Persediaan-->
							<th>Saldo</th>
							<th>Jml</th><!--Pengeluaran-->
							<th>Saldo</th>
							<th>Jml</th><!--Sisa Akhir-->
							<th>Saldo</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$jumlah_perpage = 25;
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							if($namaprg == "Semua" || $namaprg == ""){
								$program = "";
							}else{
								$program = "AND `NamaProgram`='$namaprg'";
							}
							
							// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
							$str = "SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%') ".$program;
							$str2 = $str." ORDER BY `IdProgram`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;	
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query_obat = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query_obat)){
								if($namaprg != $data['NamaProgram']){
									if($data['NamaProgram'] == "PKD"){
										$prg = "OBAT (PKD)";	
									}
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='23'>$prg</td></tr>";
									$namaprg = $data['NamaProgram'];
								}
								$no = $no +1;
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$satuan = $data['Satuan'];
								$harga = $data['HargaBeli'];
								$nobatch = $data['NoBatch'];
								$sumberanggaran = $data['SumberAnggaran'];
								$tahunanggaran = $data['TahunAnggaran'];
								
								// tahap2, stokawal
								$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
								// echo $str_stokawal;
								$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
								if ($dt_stokawal_dtl['Stok'] != null){
									$stokawal = $dt_stokawal_dtl['Stok'];
								}else{
									$stokawal = '0';
								}
								
								// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
								$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
								FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPenerimaan < '$keydate1'";
								// echo $str_terima_lalu;
								$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
								if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
									$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
								}else{
									$penerimaan_lalu = '0';
								}

								// tahap2.2 cek pengeluaran sebelumnya
								$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPengeluaran < '$keydate1'";	
								// echo $str_pengeluaran_lalu;
								$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
								if ($dt_pengeluaran_lalu['Jumlah'] != null){
									$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
								}else{
									$pengeluaran_lalu = '0';
								}	
								
								$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;
								$stokawal_rupiah = $stokawal_total * $harga;
								
								// penerimaan berdasar sumber anggaran
								$str_penerimaan = "SELECT SUM(a.Jumlah) AS Jumlah FROM `tbgfkpenerimaandetail` a 
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPenerimaan BETWEEN '$keydate1' AND '$keydate2'";
								$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $str_penerimaan));
								// echo $str_penerimaan;
								if ($penerimaan['Jumlah'] != null || $penerimaan['Jumlah'] != 0){
									$penerimaan = $penerimaan['Jumlah'];
								}else{
									$penerimaan = '0';
								}	
								$penerimaan_rupiah = $penerimaan * $harga;
								
								// totalpersediaan
								$persediaan = $stokawal_total + $penerimaan;
								$persediaan_rupiah = $persediaan * $harga;
								
								// totalrupiah
								$totalrupiah = $saldo_akhir + $totalpenerimaan;
								
								// pengeluaran
								$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2'"));
								$pengeluaran_rupiah = $pengeluaran['Jumlah'] * $harga;
								
								// saldo akhir
								$saldoakhir = $stokawal_total + $penerimaan - $pengeluaran['Jumlah'];
								$saldoakhir_rupiah = $saldoakhir * $harga;
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:center;"><?php echo $kodebarang;?></td>
									<td class="namabarangcls" style="text-align:left;"><?php echo $namabarang;?></td>
									<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:center;"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
									<td style="text-align:right;"><?php echo rupiah($data['HargaBeli']);?></td>
									<td style="text-align:center;"><?php echo $sumberanggaran;?></td>
									<td style="text-align:center;"><?php echo $tahunanggaran;?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal_total);?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($persediaan);?></td>
									<td style="text-align:right;"><?php echo rupiah($persediaan_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran['Jumlah']);?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($saldoakhir);?></td>
									<td style="text-align:right;"><?php echo rupiah($saldoakhir_rupiah);?></td>
									
								</tr>
							<?php
							}
							?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<ul class="pagination">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			$namaprg = $_GET['namaprg'];
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=uptd_gudang_sisa_aset_triwulan_bogorkab&keydate1=$keydate1&keydate2=$keydate2&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	?>
</div>	