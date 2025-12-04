<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12">
			<a href="index.php?page=lap_farmasi_dkh" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>DETAIL DKH </b></h3>
			<div class="alert alert-block alert-success fade in">
				<?php
					$iddkh = $_GET['iddkh'];
					$dtdkh = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbgudangpkmdkh WHERE `IdDkh`='$iddkh'"));
				?>
				<table width="100%">
					<tr>
						<td width="15%">Kegiatan</td>
						<td width="85%"><?php echo ": ".$dtdkh['Kegiatan'];?></td>
					</tr>
					<tr>
						<td>Pekerjaan</td>
						<td><?php echo ": ".$dtdkh['Pekerjaan'];?></td>
					</tr>
					<tr>
						<td>Kode Kegiatan</td>
						<td><?php echo ": ".$dtdkh['KodeKegiatan'];?></td>
					</tr>
					<tr>
						<td>Kode Rekening</td>
						<td><?php echo ": ".$dtdkh['KodeRekening'];?></td>
					</tr>
					<tr>
						<td>Pagu Dana</td>
						<td><?php echo ": Rp. ".rupiah($dtdkh['PaguDana']);?></td>
					</tr>
					<tr>
						<td>Sumber Anggaran</td>
						<td><?php echo ": ".$dtdkh['TahunAnggaran'];?></td>
					</tr>
					<tr>
						<td>Status</td>
						<td><?php echo ": ".$dtdkh['StatusKatalog'];?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="formbg" style="padding: 30px 30px 30px 30px;">
				<div class = "row">
					<form action="?page=lap_farmasi_dkh_detail_proses" method="post">
						<div class="table-responsive" style="overflow-x: hidden;">
							<table class="table">
								<tr>
									<td class="col-sm-2">Katalog</td>
									<td class="col-sm-10">
										<input type="text" name="katalog" class="form-control idpbf" placeholder="Misal : KATALOG A" required>
									</td>
								</tr>
								<tr>
									<td>Pabrikan</td>
									<td>
										<div class="row">
											<div class="col-sm-8">
												<input type="text" name="pabrikan" class="form-control nama_pbf" Placeholder="Ketikan Nama Pabrikan (Auto)" required>
											</div>
											<div class="col-sm-4">
												<input type="text" name="kodepabrikan" class="form-control idpbf" readonly>
											</div>
										</div>	
									</td>
								<tr>
								<tr>
									<td>Keterangan</td>
									<td>
										<input type="text" name="keterangan" class="form-control" placeholder="Isi jika pabrikan lainnya">
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Nama Obat/Barang</td>
									<td>
										<div class="row">
											<div class="col-sm-10">
												<input type="text" name="namabarang" class="form-control nama_barang_lplpo" placeholder="Ketikan Nama Barang (Sumber: Data Fornas)" required>
											</div>
											<div class="col-sm-2">
												<input type="text" name="kodebarang" class="form-control kodeobat" readonly>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Nama Barang di Ekatalog</td>
									<td>
										<input type="text" name="namabarangekatalog" class="form-control" maxlength ="200" placeholder="Ketik manual">
									</td>
								</tr>
								<tr>
									<td>Kemasan</td>
									<td>
										<select name="sediaan" class="form-control jarak">
											<option value="BOX">BOX</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
												while($data = mysqli_fetch_assoc($query)){
													echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Satuan</td>
									<td>
										<select name="satuan" class="form-control jarak">
											<option value="TABLET">TABLET</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
												while($data = mysqli_fetch_assoc($query)){
													echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Minimal Kadaluarsa</td>
									<td>
										<input type="text" name="bulankadaluarsa" class="form-control" maxlength ="2" placeholder="Misal : 15 Bulan">
									</td>
								</tr>
								<tr>
									<td>Kebutuhan (Kemasan)</td>
									<td>
										<input type="text" name="kebutuhan" class="form-control" maxlength ="10" placeholder="Misal : 40.000 (Tanpa Titik)">
									</td>
								</tr>
								<tr>
									<td>Harga Ekatalog</td>
									<td>
										<input type="text" name="hargaekatalog" class="form-control" maxlength ="10" placeholder="Misal : 1.600 (Tanpa Titik)">
									</td>
								</tr>
								<tr>
									<td>Harga Dpa</td>
									<td>
										<input type="text" name="hargadpa" class="form-control" maxlength ="10" placeholder="Misal : 1.600 (Tanpa Titik)">
									</td>
								</tr>
								<?php
									$statuskatalog = $_GET['status'];
									if($statuskatalog == 'Non Ekatalog'){
								?>
								<tr>
									<td>Spesifikasi</td>
									<td>
										<textarea name="spesifikasi" class="form-control" maxlength ="10" placeholder="Jelaskan Spesifikasi Barang" required></textarea>
									</td>
								</tr>
								<?php
									}
								?>
							</table>
						</div>
						<input type="hidden" name="iddkh" class="form-control" value ="<?php echo $iddkh;?>">
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</form>	
				</div>
			</div>	
		</div>	
	</div>
	<?php
		$jumlah_perpage = 20;
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$key = $_GET['key'];
		if($key != ''){
			$keys = " WHERE `NamaBarang` like '%$key%'";				
		}else{
			$keys = "";
		}		
		$str = "SELECT * FROM `tbgudangpkmdkhdetail` WHERE `IdDkh`='$iddkh'".$keys;
		$str2 = $str." ORDER BY IdDkh LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<th width="10%">Nama Obat/Barang</th>
							<th width="8%">Nama Barang di Ekatalog</th>
							<th width="3%">Kemasan</th>
							<th width="5%">Satuan</th>
							<th width="10%">Nama Pabrikan</th>
							<th width="5%">Kadaluarsa Minimal</th>
							<th width="5%">Kebutuhan (Kemasan)</th>
							<th width="5%">Harga (Ekatalog)</th>
							<th width="5%">Total Harga (Ekatalog)</th>
							<th width="5%">Harga DPA</th>
							<th width="5%">Total DPA</th>
							<th width="6%">Total Efesiensi (Total Dpa - Total Harga)</th>
							<th width="5%">Aksi</th>
						</tr>
					</thead>
					<tbody style="font-size: 10px;">
					<?php
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>							
							<td align="left"><?php echo $data['NamaBarang'];?></td>	
							<td align="left"><?php echo $data['NamaBarangEkatalog'];?></td>									
							<td align="center"><?php echo $data['Sediaan'];?></td>		
							<td align="center"><?php echo $data['Satuan'];?></td>									
							<td align="left"><?php echo $data['Pabrikan'];?></td>									
							<td align="center"><?php echo $data['MinimalKadaluarsa'];?></td>									
							<td align="right"><?php echo rupiah($data['Kebutuhan']);?></td>										
							<td align="right"><?php echo rupiah($data['HargaEkatalog']);?></td>								
							<td align="right"><?php echo rupiah($data['TotalHargaEkatalog']);?></td>									
							<td align="right"><?php echo rupiah($data['HargaDpa']);?></td>								
							<td align="right"><?php echo rupiah($data['TotalDpa']);?></td>									
							<td align="right"><?php echo rupiah($data['TotalEfesiensi']);?></td>									
							<td align="right">
								<a onClick="return confirm('Anda yakin data ingin dihapus...?')" href="?page=lap_farmasi_dkh_detail_hapus&iddtl=<?php echo $data['IdDkhDetail'];?>&iddkh=<?php echo $data['IdDkh'];?>" class="btnmodalpegawaiedit btn btn-xs btn-danger btn-white">Hapus</a>
							</td>									
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div><hr/>
	
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
						echo "<li><a href='?page=lap_farmasi_dkh&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	