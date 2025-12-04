<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>SISA ASET </b><small>Gudang Besar</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="uptd_gudang_sisa_aset"/>
						<div class="col-sm-2">
							<SELECT name="kategori" class="form-control" required>
								<option value="">--Pilih--</option>
								<option value="NamaBarang">Nama Barang</option>
								<option value="NoBatch">No Batch</option>
								<option value="Kemasan">Kemasan</option>
								<option value="Satuan">Satuan</option>
								<option value="JenisBarang">Jenis Barang</option>
							</SELECT>
						</div>
						<div class="col-sm-5">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=uptd_gudang_sisa_aset" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="uptd_gudang_sisa_aset_excel.php?tahun=<?php echo date('Y');?>" class="btn btn-info btn-white">Excel</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th width='3%' rowspan="3">No.</td>
							<th width='15%' rowspan="3">Nama Barang</td>
							<th width='5%' rowspan="3">Satuan</td>
							<th width='40%' colspan="8">Sisa Stok</td>
							<th width='15%' colspan="2">Saldo Akhir</td>
						</tr>
						<tr>
							<th colspan="2">2016</td>
							<th colspan="2">2017</td>
							<th colspan="2">2018</td>
							<th colspan="2">2019</td>
							<th rowspan="2">Jumlah</td>
							<th rowspan="2">Harga</td>
						</tr>
						<tr>
							<th>Jumlah</td><!--2016-->
							<th>Harga</td>
							<th>Jumlah</td><!--2017-->
							<th>Harga</td>
							<th>Jumlah</td><!--2018-->
							<th>Harga</td>
							<th>Jumlah</td><!--2019-->
							<th>Harga</td>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 0;
							$str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' GROUP BY KodeBarang, IdBarang";
							$str_obat = $str." order by NamaBarang";
							// echo $str_obat;
							$kbg = '';
							$query_obat = mysqli_query($koneksi,$str_obat);
							while($data = mysqli_fetch_assoc($query_obat)){
								$no = $no +1;
								$kodebarang = $data['KodeBarang'];
								$kodebaranggroup = $data['KodeBarangGroup'];
								$idbarangs = $data['IdBarang'];
								$namabarang = $data['NamaBarang'];
								
								$dt_2016= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `IdBarang`='$idbarangs' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2016' AND Stok > '0'"));
								$dt_2017= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `IdBarang`='$idbarangs' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2017' AND Stok > '0'"));
								$dt_2018= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `IdBarang`='$idbarangs' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2018' AND Stok > '0'"));
								$dt_2019= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok`, `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `IdBarang`='$idbarangs' AND SUBSTRING(SumberAnggaran,1,4)='APBD' AND `TahunAnggaran`='2019' AND Stok > '0'"));
								$jml_akhir = $dt_2016['Stok'] + $dt_2017['Stok'] + $dt_2018['Stok'] + $dt_2019['Stok'];			
								$saldo_akhir = ($dt_2016['Stok'] * $dt_2016['HargaBeli']) + ($dt_2017['Stok'] * $dt_2017['HargaBeli']) + ($dt_2018['Stok'] * $dt_2018['HargaBeli']) + ($dt_2019['Stok'] * $dt_2019['HargaBeli']);			
								$total = $total + $saldo_akhir;
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:left;"><?php echo $data['NamaBarang'];?></td>
									<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:right;"><!--2016-->
										<?php 
											if($dt_2016['Stok'] !=0){
												echo rupiah($dt_2016['Stok']);
											}else{
												echo "-";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php 
											if($dt_2016['HargaBeli'] !=0){
												echo number_format("$dt_2016[HargaBeli]",2,",",".");
											}else{
												echo "-";
											}	
										?>
									</td>
									<td style="text-align:right;"><!--2017-->
										<?php 
											if($dt_2017['Stok'] !=0){
												echo rupiah($dt_2017['Stok']);
											}else{
												echo "-";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php 
											if($dt_2017['HargaBeli'] !=0){
												echo number_format("$dt_2017[HargaBeli]",2,",",".");
											}else{
												echo "-";
											}	
										?>
									</td>
									<td style="text-align:right;"><!--2018-->
										<?php 
											if($dt_2018['Stok'] !=0){
												echo rupiah($dt_2018['Stok']);
											}else{
												echo "-";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php 
											if($dt_2018['HargaBeli'] !=0){
												echo number_format("$dt_2018[HargaBeli]",2,",",".");
											}else{
												echo "-";
											}	
										?>
									</td>
									<td style="text-align:right;"><!--2019-->
										<?php 
											if($dt_2019['Stok'] !=0){
												echo rupiah($dt_2019['Stok']);
											}else{
												echo "-";
											}	
										?>
									</td>
									<td style="text-align:right;">
										<?php 
											if($dt_2019['HargaBeli'] !=0){
												echo number_format("$dt_2019[HargaBeli]",2,",",".");
											}else{
												echo "-";
											}	
										?>
									</td>
									<td style="text-align:right;"><!--Jumlah Akhir-->
										<?php
											echo rupiah($jml_akhir);
										?>
									</td>
									<td style="text-align:right;"><!--Saldo Akhir-->
										<?php
											echo number_format("$saldo_akhir",2,",",".");
										?>
									</td>
								</tr>
							<?php
							}
							?>
							<tr style="font-weight: bold;">
								<td style="text-align:center;"></td>
								<td style="text-align:center;" colspan="11">Total Rupiah</td>
								<td style="text-align:right;">
									<?php
										echo number_format("$total",2,",",".");
									?>
								</td>
							</tr>	
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<ul class="pagination">
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
						echo "<li><a href='?page=uptd_gudang_sisa_aset&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	