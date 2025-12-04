<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK OPNAME (TRIWULAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="uptd_gudang_sisa_aset_triwulan_bogorkab"/>
						<div class="col-sm-2">
							<select name="bulanawal" class="form-control">
								<option value="01" <?php if($_GET['bulanawal'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanawal'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanawal'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanawal'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanawal'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanawal'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanawal'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanawal'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanawal'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanawal'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanawal'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanawal'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="bulanakhir" class="form-control">
								<option value="01" <?php if($_GET['bulanakhir'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanakhir'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanakhir'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanakhir'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanakhir'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanakhir'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanakhir'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanakhir'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanakhir'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanakhir'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanakhir'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanakhir'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
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
							<a href="uptd_gudang_sisa_aset_triwulan_bogorkab_excel.php?bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>&namaprg=<?php echo $_GET['namaprg'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
		$bulanawal = $_GET['bulanawal'];
		$bulanakhir = $_GET['bulanakhir'];	
		$tahun = $_GET['tahun'];
		$namaprg = $_GET['namaprg'];
		$key = $_GET['key'];
		if(isset($_GET['namaprg'])){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" style="width:1500px;">
					<thead>
						<tr>
							<th rowspan="3">No.</th>
							<th rowspan="3">Kode</th>
							<th rowspan="3">Nama Barang</th>
							<th rowspan="3">Satuan</th>
							<th rowspan="2" colspan="2">Saldo Awal</th>
							<th colspan="7">Saldo Awal</th>
							<th rowspan="2" colspan="3">Penerimaan<br/><?php echo date('Y');?></th>
							<th rowspan="3">Total Persediaan</th>
							<th rowspan="3">Total Rupiah</th>
							<th colspan="3" rowspan="2">Jumlah Pengeluaran<br/><?php echo date('Y');?></th>
							<th colspan="2" rowspan="2">Saldo Administrasi</th>
							<!--<th rowspan="3" width="5%">Total Saldo Fisik</th>-->
							<!--<th rowspan="3" width="5%">Total Nilai Persediaan</th>-->
							<!--<th colspan="2" rowspan="2" width="10%">Selisih Administrasi & Fisik</th>-->
						</tr>
						<tr>
							<th colspan="2">2017</th>
							<th colspan="2">2018</th>
							<th colspan="2">2019</th>
							<th rowspan="2">Total Rupiah</th>
						</tr>
						<tr>
							<th rowspan="3">APBD</th><!--Saldo Awal-->
							<th rowspan="3">Harga</th>
							<th rowspan="3">APBD</th><!--Saldo Awal Per-Tahun-->
							<th rowspan="3">Harga</th>
							<th rowspan="3">APBD</th>
							<th rowspan="3">Harga</th>
							<th rowspan="3">APBD</th>
							<th rowspan="3">Harga</th>
							<th rowspan="3">APBD</th><!--Penerimaan-->
							<th rowspan="3">Harga</th>
							<th rowspan="3">Total</th>
							<th rowspan="3">APBD</th><!--Jumlah Pengeluaran-->
							<th rowspan="3">Harga</th>
							<th rowspan="3">Total</th>
							<th rowspan="3">APBD</th><!--Saldo Administrasi-->
							<th rowspan="3">Total</th>
							<!--<th rowspan="3">Unit</th><!--Selisih Administrasi & Fisik-->
							<!--<th rowspan="3">Rp.</th>-->
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
							
							// tahap1, ref_obat_lplpo
							$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` like '%$key%' ".$program;
							$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
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
								$kodebaranggroup = $data['KodeBarangGroup'];
								$idbarangs = $data['IdBarang'];
								$namabarang = $data['NamaBarang'];
								
								// saldo awal, tampilkan berdasar Stok lebihdari 0
								$dt_2017= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `TahunAnggaran`='2017'"));
								$dt_2018= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `TahunAnggaran`='2018'"));
								$dt_2019= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `TahunAnggaran`='2019'"));
								$jml_akhir = $dt_2017['Stok'] + $dt_2018['Stok'] + $dt_2019['Stok'];			
								$saldo_akhir = ($dt_2017['Stok'] * $dt_2017['HargaBeli'] + $dt_2018['Stok'] * $dt_2018['HargaBeli'] + $dt_2019['Stok'] * $dt_2019['HargaBeli']);			
								$total = $total + $saldo_akhir;
								
								// penerimaan berdasar sumber anggaran APBD KAB/KOTA
								$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(a.Jumlah) AS Jumlah, a.`Harga`, b.`KodeSupplier`, a.NomorPembukuan FROM `tbgfkpenerimaandetail` a 
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
								WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPenerimaan)='$tahun' AND MONTH(b.TanggalPenerimaan)  BETWEEN '$bulanawal' AND '$bulanakhir'"));
								$totalpenerimaan = $penerimaan['Jumlah'] * $penerimaan['Harga'];
								
								// totalpersediaan
								$totalpersediaan = $jml_akhir + $penerimaan['Jumlah'];
								
								// totalrupiah
								$totalrupiah = $saldo_akhir + $totalpenerimaan;
								
								// pengeluaran
								$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND YEAR(b.TanggalPengeluaran)='$tahun' AND MONTH(b.TanggalPengeluaran)  BETWEEN '$bulanawal' AND '$bulanakhir'"));
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
												echo rupiah($dt_2017['HargaBeli']);
											}else{
												echo "0";
											}	
										?>
									</td>
									<td style="text-align:right;"><!--saldoawal_2018-->
										<?php
											if($dt_2018['Stok'] != ""){
												echo rupiah($dt_2018['Stok']);
											}else{
												echo "0";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php
											if($dt_2018['HargaBeli'] != 0){
												echo rupiah($dt_2018['HargaBeli']);
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
												echo rupiah($dt_2019['HargaBeli']);
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
						echo "<li><a href='?page=uptd_gudang_sisa_aset_triwulan_bogorkab&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahun=$tahun&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	?>
</div>	