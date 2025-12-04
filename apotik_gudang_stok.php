<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$hariini = date('Y-m-d');
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul">GUDANG OBAT PUSKESMAS</h3>
			<div class="formbg">
				<form role="form" method="get">
					<div class = "row">
						<input type="hidden" name="page" value="apotik_gudang_stok"/>
						<div class="col-sm-2">
							<select name="namaprg" class="form-control">
								<option value='Semua'>Semua</option>
								<!--<option value='JKN'>JKN</option>-->
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
						</div>
						<div class="col-sm-2">
							<select name="sumberanggaran" class="form-control" required>
								<option value='Semua' <?php if($_GET['sumberanggaran'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD</option>
								<option value="BOK" <?php if($_GET['sumberanggaran'] == 'BOK'){echo "SELECTED";}?>>BOK</option>
								<option value="DONASI" <?php if($_GET['sumberanggaran'] == 'DONASI'){echo "SELECTED";}?>>DONASI</option>
								<option value="HIBAH" <?php if($_GET['sumberanggaran'] == 'HIBAH'){echo "SELECTED";}?>>HIBAH</option>
								<option value="BLUD/JKN" <?php if($_GET['sumberanggaran'] == 'BLUD/JKN'){echo "SELECTED";}?>>BLUD/JKN</option>
								<option value="LAINNYA" <?php if($_GET['sumberanggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
							</select>	
						</div>
						<div class="col-sm-2">
							<select name="jmltersedia" class="form-control">
								<option value="Tersedia" <?php if($_GET['jmltersedia'] == 'Tersedia'){echo "SELECTED";}?>>Tersedia</option>
								<option value="Keseluruhan" <?php if($_GET['jmltersedia'] == 'Keseluruhan'){echo "SELECTED";}?>>Keseluruhan</option>
								<option value="Expire" <?php if($_GET['jmltersedia'] == 'Expire'){echo "SELECTED";}?>>Expire</option>
							</select>
						</div>
						<div class="col-sm-3">
							<input type="text" name="key" class="form-control cari" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Kode / No.Batch Barang / Sumber Dana">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning btnsubmit"><span class="fa fa-search"></span></button>
							<a href="?page=apotik_gudang_stok" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="apotik_gudang_stok_excel.php?namaprg=<?php echo $_GET['namaprg'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>&jmltersedia=<?php echo $_GET['jmltersedia'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<!--<a onclick="return confirm('Anda yakin ingin mengeksport data ke Loket Obat')" href="export_obat_gudang_puskesmas.php" class="btn btn-round btn-danger">Export LO</a>
							<a href="?page=apotik_gudang_stok_tambah" class="btn btn-danger"><span class="glyphicon glyphicon-plus"></span> Master Brg</a>-->
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="6%">KODE</th>
							<th width="20%">NAMA BARANG</th>
							<th width="8%">SATUAN</th>
							<th width="10%">BATCH</th>
							<th width="8%">EXPIRE</th>
							<th width="15%">SUMBER</th>
							<th width="6%">STOK</th>
							<?php
								if (in_array("PROGRAMMER", $otoritas) || in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
							?>
							<th width="15%">#</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php		
						$jumlah_perpage = 100;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}	
						
						$namaprg = $_GET['namaprg'];
						$sumberanggaran = $_GET['sumberanggaran'];
						$jmltersedia = $_GET['jmltersedia'];						
						$key = $_GET['key'];

						if($namaprg == 'Semua' || $namaprg == ''){
							$namaprogram = "";
						}else{
							$namaprogram = " AND `NamaProgram` = '$namaprg'";
						}

						if($sumberanggaran == 'Semua' || $sumberanggaran == ''){
							$sbanggaran = "";
						}else{
							$sbanggaran = " AND `SumberAnggaran` = '$sumberanggaran'";
						}

						if($jmltersedia == 'Keseluruhan'){
							$stoks = "";
						}elseif($jmltersedia == 'Expire'){
							$stoks = "`Stok` > '0' AND `Expire` < '$hariini' AND `NamaProgram` != 'VAKSIN' AND";
						}else{
							$stoks = "`Stok` > '0' AND";
						}						
									
						if($key != ''){
							$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `SumberAnggaran` like '%$key%' OR `NamaProgram` like '%$key%')";
						}else{
							$strcari = " `SumberAnggaran` != 'BLUD'";
						}
						
						$str = "SELECT * FROM `$tbgudangpkmstok` WHERE".$stoks.$strcari.$namaprogram.$sbanggaran;			
						$str2 = $str." ORDER BY NamaBarang LIMIT $mulai,$jumlah_perpage";						
						// echo $str2;	

						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}						
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kdbrg = $data['KodeBarang'];
							$nobatch = $data['NoBatch'];
							$Expire = $data['Expire'];
							$program = $data['NamaProgram'];

							// mencari jumlah hari sebelum expire
							$wl = explode("-",$Expire);
							$waktu_expire = mktime(0,0,0,$wl[1],$wl[2],$wl[0]);
							$now = mktime(0,0,0,date("m"),date("d"),date("Y"));
							$selisih = $waktu_expire - $now;
							$day = floor($selisih/86400);
						
							if($day < 180){	
								if($day > 0){
									$warna = 'yellow';
								}else{
									$warna = 'pink';
								}
							}elseif($data['Stok'] <= $data['MinimalStok']){
								$warna = 'lightblue';
							}else{
								$warna = 'white';
							}
							
							// tbgfkstok
							$dtgfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbrg'"));
							
							// tbgfk_vaksin 
							$dtgfkstok_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg'"));
						?>
							
							<tr style="background:<?php echo $warna;?>;" data-idbarang="<?php echo $datapenerimaan['IdBarangGdgPkm'];?>">
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $data['KodeBarang'];?></td>
								<td align="left" class="nama">
									<?php 
										if($data['NamaBarang'] != ""){
											echo strtoupper($data['NamaBarang']);
										}elseif($dtgfkstok['NamaBarang'] != ""){
											echo strtoupper($dtgfkstok['NamaBarang']);
										}else{
											echo strtoupper($dtgfkstok_vaksin['NamaBarang']);
										}
										
									?>
									<span class="badge badge-success" style='padding: 4px;'><?php echo $program;?></span>
								</td>
								<td align="center">
									<?php 
										if($data['Satuan'] != ""){
											echo strtoupper($data['Satuan']);
										}elseif($dtgfkstok['Satuan'] != ""){
											echo $dtgfkstok['Satuan'];
										}else{
											echo $dtgfkstok_vaksin['Satuan'];
										}	
									?>
								</td>
								<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
								<td align="center"><?php echo $data['Expire'];?></td>
								<td align="center">
									<?php 
										if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
											$sumber = "APBD";
										}else{
											$sumber = $data['SumberAnggaran'];
										}										
										echo $sumber." - ".$data['TahunAnggaran'];
									?>
								</td>
								<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Stok']);?></td>
								<?php
									if (in_array("PROGRAMMER", $otoritas) || in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
								?>
								<td align="center">
									<a href="?page=apotik_gudang_stok_edit&kd=<?php echo $data['KodeBarang'];?>&pkm=<?php echo $data['KodePuskesmas'];?>&nb=<?php echo $data['NoBatch'];?>&h=<?php echo $_GET['h'];?>" class="btn btn-sm btn-round btn-info">CEK STOK</a>
									<a href="?page=apotik_gudang_stok_lihat&id=<?php echo $data['IdBarangGdgPkm'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-round btn-primary">DETAIL</a>
									<!--<a href="?page=apotik_gudang_stok_delete&id=<?php echo $data['IdBarangGdgPkm'];?>&key=<?php echo $_GET['key'];?>&h=<?php echo $_GET['h'];?>" class="btn btn-sm btn-danger" onClick="return confirm('Anda yakin data ingin dikosongkan...?')">Habis</a>-->
								</td>	
								<?php
									}
								?>
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
			$namaprg = $_GET['namaprg'];	
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=apotik_gudang_stok&namaprg=$namaprg&kategori=$kategori&jmltersedia=$jmltersedia&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
					<p>
						<h4><b>Perhatikan</b></h4> 
						- Nama barang yang ditampilkan stoknya <> 0</br>
						- Penambahan item barang baru berdasar (Batch, Expire dan Sumber Anggaran, Harga Satuan)</br>
						- Warna <b>Pink</b>, obat sudah expire</br>
						- Warna <b>Kuning</b>, kurang dari 6 bulan memasuki expire</br>
						- Warna <b>Biru</b>, jumlah stok kurang dari minimal stok
					</p>
			</div>
		</div>
	</div>
</div>
