<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KETERSEDIAAN (PER-BATCH)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_ketersediaan_barang_bandungkab"/>
						<div class="col-sm-2">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="tampilformdate">
								<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
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
								<div class="input-group-append">
									<span class="input-group-text">Program</span>
								</div>
							</div>
						</div>	
						<div class="col-sm-2">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nama Barang">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_ketersediaan_barang_bandungkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_ketersediaan_barang_bandungkab_excel.php?tanggal_awal=<?php echo $_GET['keydate1'];?>&tanggal_akhir=<?php echo $_GET['keydate2'];?>&namaprg=<?php echo $_GET['namaprg'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php
		$tanggal_awal = date('Y-m-d', strtotime($_GET['keydate1']));
		$tanggal_akhir = date('Y-m-d', strtotime($_GET['keydate2']));
		$namaprg = $_GET['namaprg'];
		$key = $_GET['key'];
		if(isset($_GET['namaprg'])){
	?>	
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERSEDIAAN</b></span><br>
		<span class="font10" style="margin:15px 5px 5px 5px;">Periode : <?php echo $_GET['tanggal_awal']." s/d ".$_GET['tanggal_akhir'];?></span><br>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive text_nowrap">
				<table class="table-judul-laporan-min" style="font-size:11px;">
					<thead>
						<tr>
							<th width="3%" rowspan="2">No.</td>
							<th width="15%" rowspan="2">Nama Barang</td>
							<th width="5%" rowspan="2">Satuan</td>
							<th width="8%" rowspan="2">Batch</td>
							<th width="4%" rowspan="2">Harga<br/>Satuan</td>
							<th width="7%" rowspan="2">Expire</td>
							<th width="10%" rowspan="2">Sumber Anggaran</td>
							<th width="3%" rowspan="2">Tahun</td>
							<th width="9%" rowspan="2">Supplier</td>
							<th width="9%" colspan="2">Saldo Awal</td>
							<th width="9%" colspan="2">Penerimaan</td>
							<th width="9%" colspan="2">Pengeluaran</td>
							<th width="9%" colspan="2">Saldo Akhir</td>
						</tr>
						<tr>
							<th>Jumlah</td><!--Saldo Awal-->
							<th>Rupiah</td>
							<th>Jumlah</td><!--Penerimaan-->
							<th>Rupiah</td>
							<th>Jumlah</td><!--Pengeluaran-->
							<th>Rupiah</td>
							<th>Jumlah</td><!--Saldo Akhir-->
							<th>Rupiah</td>
						</tr>
					</thead>
					<tbody>
						<?php						
							$jumlah_perpage = 15;
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
							$str2 = $str." ORDER BY `NamaProgram`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;	

							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
														
							$query_obat = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query_obat)){
								if($namaprogram != $data['NamaProgram']){
									if($data['NamaProgram'] == "PKD"){
										$prg = "OBAT (PKD)";	
									}else{
										$prg = $data['NamaProgram'];
									}	
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17'>$prg</td></tr>";
									$namaprogram = $data['NamaProgram'];
								}
								
								$no = $no + 1;
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$nobatch = $data['NoBatch'];
								
								// harga satuan, ambil yang terakhir
								$harga_satuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `HargaBeli` != '0'")); //  ORDER BY IdBarang DESC
																	
								// Supplier
								$no4 = 0;
								$query_supplier = mysqli_query($koneksi, "SELECT nama_prod_obat FROM `ref_pabrik` WHERE `id`='$data[Produsen]'");
								$dt_supplier= mysqli_fetch_assoc($query_supplier);
																															
								// tahap2, menentukan stok awal stok / saldo awal
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
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND a.`NamaProgram`='$namaprogram' AND b.TanggalPenerimaan < '$tanggal_awal'";
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
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND b.TanggalPengeluaran < '$tanggal_awal'";	
								// echo $str_pengeluaran_lalu;
								$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
								if ($dt_pengeluaran_lalu['Jumlah'] != null){
									$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
								}else{
									$pengeluaran_lalu = '0';
								}	
								
								$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;
								$stokawal_rupiah = $stokawal_total * $harga_satuan['HargaBeli'];							
																
								// tahap3, menentukan penerimaan (tampil semua aja, tidak perlu tanggal nanti minus di sisa akhir)
								$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' 
								AND b.TanggalPenerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir' 
								AND a.`NomorPembukuan`='$data[NoFakturTerima]'";																
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
									$penerimaan = $dtpenerimaan['Jumlah'];
								}else{
									$penerimaan = '0';
								}															
								$penerimaan_rupiah = $penerimaan * $harga_satuan['HargaBeli'];
								
								// tahap4, menentukan pemakaian/pengeluaran
								$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' AND 
								b.TanggalPengeluaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";								
								$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));								
								if ($dtpengeluaran['Jumlah'] != null || $dtpengeluaran['Jumlah'] != 0){
									$pengeluaran = $dtpengeluaran['Jumlah'];
								}else{
									$pengeluaran = '0';
								}								
								$pengeluaran_rupiah = $pengeluaran * $harga_satuan['HargaBeli'];
																
								// tahap5, sisaakhir
								// if($stokawal == $pengeluaran){
									// $stokawal = "0";
									// $stokawal_rupiah = "0";
									// $pengeluaran = "0";
									// $pengeluaran_rupiah = "0";
								// }	
								$sisaakhir = $stokawal_total + $penerimaan - $pengeluaran;
								$sisaakhir_rupiah = $sisaakhir * $harga_satuan['HargaBeli'];
								
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:left;" class="namabarangcls">
										<?php 
											echo "<b>".strtoupper($data['NamaBarang'])."</b><br/>";
											echo $data['KodeBarang']."<br/>";
											// echo "<b>Keterangan :</b><br/>";
											// echo "Stok Master = ".$stokawal."<br/>";
											// echo "Penerimaan Lalu = ".$penerimaan_lalu."<br/>";
											// echo "Pengeluaran Lalu = ".$pengeluaran_lalu."<br/>";
											// echo "Saldo Awal = ".$stokawal_total;
										?>
									</td>
									<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
									<td style="text-align:right;"><?php echo rupiah($harga_satuan['HargaBeli']);?></td>
									<td style="text-align:center;"><?php echo str_replace(",", ", ", $data['Expire']);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $data['SumberAnggaran']);?></td>
									<td style="text-align:center;"><?php echo $data['TahunAnggaran'];?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $dt_supplier['nama_prod_obat']);?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal_total);?></td>
									<td style="text-align:right;"><?php echo rupiah($stokawal_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan);?></td>
									<td style="text-align:right;"><?php echo rupiah($penerimaan_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran);?></td>
									<td style="text-align:right;"><?php echo rupiah($pengeluaran_rupiah);?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir_rupiah);?></td>
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
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
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
						echo "<li><a href='?page=lap_gfk_ketersediaan_barang_bandungkab&keydate1=$tanggal_awal&keydate2=$tanggal_akhir&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Perhatikan :</b><br/>
					Saldo Awal = Saldo Awal (Master) + Penerimaan Sebelumnya - Pengeluaran Sebelumnya<br/>
					Penerimaan = Penerimaan berdasar periode yang dipilih<br>
					Pengeluran = Pengeluaran berdasar periode yang dipilih<br>
					Saldo Akhir = Saldo Awal + Penerimaan - Pengeluaran<br>
				</p>
			</div>
		</div>
	</div>
	<?php }?>
</div>	