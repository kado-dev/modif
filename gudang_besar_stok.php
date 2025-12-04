<?php
	$kota = $_SESSION['kota'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$hariini = date('Y-m-d');
 ?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK BARANG </b><small>Gudang Besar</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="gudang_besar_stok"/>
						<div class="col-sm-5">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama/Kode Barang/Batch/Program">
						</div>
						<div class="col-sm-2">
							<select name="jmltersedia" class="form-control">
								<option value="Tersedia" <?php if($_GET['jmltersedia'] == 'Tersedia'){echo "SELECTED";}?>>Tersedia</option>
								<option value="Keseluruhan" <?php if($_GET['jmltersedia'] == 'Keseluruhan'){echo "SELECTED";}?>>Keseluruhan</option>
								<option value="Expire" <?php if($_GET['jmltersedia'] == 'Expire'){echo "SELECTED";}?>>Expire</option>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=gudang_besar_stok&jmltersedia=Tersedia" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="gudang_besar_stok_excel.php?key=<?php echo $_GET['key'];?>&jmltersedia=<?php echo $_GET['jmltersedia'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
							<!--<a href="?page=gudang_besar_stok_tambah" class="btn btn-sm btn-info">Tambah Data</a>-->
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	<?php	
		$jumlah_perpage = 25;
		
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$jmltersedia = $_GET['jmltersedia'];	
		$key = $_GET['key'];		

		if($jmltersedia == 'Keseluruhan'){
			$stoks = "";
		}elseif($jmltersedia == 'Expire'){
			$stoks = " `Stok` > '0' AND `Expire` < '$hariini' AND `NamaProgram` != 'VAKSIN' AND";
		}else{
			$stoks = " `Stok` > '0' AND `Expire` > '$hariini' AND `NamaProgram` != 'VAKSIN' AND";
		}	
		
		if($key !=''){
			$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%')";
		}else{
			$strcari = " `SumberAnggaran` != 'BLUD'";
		}
			
		$str = "SELECT * FROM `tbgfkstok` WHERE".$stoks.$strcari;
		$str2 = $str." order by IdBarang, NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
		
		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
	?>			
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="5%">KODE</th>
							<th width="30%">NAMA BARANG</th>
							<th width="5%">SATUAN</th>
							<th width="15%">BATCH</th>
							<th width="10%">EXPIRE</th>
							<th width="10%">SUMBER</th>
							<th width="5%">TAHUN</th>
							<!--<th width="5%">HARGA</th>-->
							<th width="7%">STOK</th>
							<!--<th width="7%">STOK</th>-->
							<?php if($username != "DINAS KESEHATAN"){ ?>
							<th width="5%">#</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;										
							$expire = $data['Expire'];
							$kodebarang = $data['KodeBarang'];
							$nobatch = $data['NoBatch'];
							$nofakturterima = $data['NoFakturTerima'];

							// mencari jumlah hari sebelum expire
							$wl = explode("-",$expire);
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
							
							if($kota == "KABUPATEN BOGOR"){
								if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
									$sumber = "OBAT-OBATAN"; 
								}else{
									$sumber = $data['SumberAnggaran']; 
								}	
							}elseif($kota == "KABUPATEN BANDUNG"){
								if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
									$sumber = "APBD"; 
								}else{
									$sumber = $data['SumberAnggaran']; 
								}
							}elseif($kota == "KABUPATEN BEKASI"){
								if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
									$sumber = "APBD"; 
								}else{
									$sumber = $data['SumberAnggaran']; 
								}	
							}

							if($data['NamaProgram'] == "BAHAN HABIS PAKAI" || $data['NamaProgram'] == "BAHAN MEDIS HABIS PAKAI"){
								$namaprogram = "BMHP";
							}else{
								$namaprogram = $data['NamaProgram'];
							}	
						?>
						<tr style="background:<?php echo $warna;?>;">
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $kodebarang;?></td>
							<td class="nama">
								<?php 
									echo strtoupper($data['NamaBarang']);
									if($data['StatusKarantina'] == 'Y'){ 
										// cek karantina
										$dt_karantina = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_karantinadetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
								?>
									<span class="badge badge-danger" style='padding: 4px;'>
										<a href="?page=gudang_karantina_stok&key=<?php echo $kodebarang;?>" target="_blank"><?php echo "KARANTINA : ".$dt_karantina['Jumlah'];?></a>
									</span><br/>
								<?php }elseif($data['StatusPemusnahan'] == 'Y'){
										// cek pemusnahan
										$dt_pemusnahan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_pemusnahandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
								?>
									<span class="badge badge-danger" style='padding: 4px;'>
										<a href="?page=gudang_karantina_stok&key=<?php echo $kodebarang;?>" target="_blank"><?php echo "PEMUSNAHAN : ".$dt_pemusnahan['Jumlah'];?></a>
									</span><br/>
								<?php }else{ ?>
									<span style='font-size: 10px; font-style: italic;'>
										<?php 
											if($data['NamaTambahan'] != '-'){
												echo $data['NamaTambahan'];
											}
										?>
									</span>
								<?php 
									}
									if($data['NamaTambahan'] != "-"){
								?>
									<span class="badge badge-success" style='padding: 4px;'><?php echo "Prg. ".$namaprogram;?></span>
								<?php } ?>
							</td>
							<td align="center"><?php echo $data['Satuan'];?></td>
							<td align="left"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
							<td align="center"><?php echo date('d-m-Y',strtotime($data['Expire']));?></td>
							<td align="center"><?php echo $sumber;?></td>
							<td align="center"><?php echo $data['TahunAnggaran'];?></td>
							<td align="right" style="color:red;font-weight:bold">
								<?php 
									// 1. stok awal, ini ngambil sisa stok yang bulan des 2019
									$str_stokawal = "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang ' AND `NoBatch`='$nobatch'";
									$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
									if ($dt_stokawal_dtl['Stok'] != null){
										$stokawal = $dt_stokawal_dtl['Stok'];
									}else{
										$stokawal = '0';
									}
									// echo "Stok Awal : ".$stokawal."</br>";											
																		
									// 2. penerimaan, jika bekasi ngambil dari penerimaan yang tahunnya > 2019
									if($kota == "KABUPATEN BEKASI"){
										$dtpenerimaandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
										FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
										WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch' 
										AND YEAR(b.TanggalPenerimaan) > '2019'"));
									}else{
										$dtpenerimaandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
										FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b. NomorPembukuan 
										WHERE a.`KodeBarang`='$kodebarang' AND a.`NoBatch`='$nobatch'"));
									}
									
									if ($dtpenerimaandtl['Jumlah'] != null){
										$penerimaan = $dtpenerimaandtl['Jumlah'];
									}else{
										$penerimaan = '0';
									}
									// echo "Penerimaan : ".$penerimaan."</br>";
									
									// 3. pengeluaran detail, jika bekasi ngambil dari pengeluaran yang tahunnya > 2019
									if($kota == "KABUPATEN BEKASI"){
										$dtpengeluarandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah 
										FROM `tbgfkpengeluarandetail` a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur 
										WHERE a.`KodeBarang` = '$kodebarang' AND a.`NoBatch`='$nobatch' AND YEAR(b.TanggalPengeluaran) > '2019'"));
									}else{
										$stokawalmaster = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch'"));
										$dtpengeluarandtl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah 
										FROM `tbgfkpengeluarandetail` a JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur 
										WHERE a.`KodeBarang` = '$kodebarang' AND a.`NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'"));
									}	
									
									if ($dtpengeluarandtl['Jumlah'] != null){
										$pengeluaran = $dtpengeluarandtl['Jumlah'];
									}else{
										$pengeluaran = '0';
									}
									// echo "Pengeluaran : ".$pengeluaran."</br>";
									
									// 4. karantina detail
									$str_karantina = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_karantinadetail`
									WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
									$dt_karantina_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
									if ($dt_karantina_dtl['Jumlah'] != null){
										$karantina = $dt_karantina_dtl['Jumlah'];
									}else{
										$karantina = '0';
									}
									// echo "karantina : ".$karantina."</br>";

									// 5. pemusnahan detail
									$str_karantina = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfk_pemusnahandetail`
									WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
									$dt_pemusnahan_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_karantina));
									if ($dt_pemusnahan_dtl['Jumlah'] != null){
										$pemusnahan = $dt_pemusnahan_dtl['Jumlah'];
									}else{
										$pemusnahan = '0';
									}
									// echo "pemusnahan : ".$pemusnahan."</br>";
									
									// 6. sisastok, jika penerimaan 0, ngambil dari stok awal
									if($penerimaan == 0){
										$sisastok = $stokawal - $pengeluaran - $karantina - $pemusnahan;
										// echo "1";
									}else{
										$sisastok = $stokawal + $penerimaan - $pengeluaran - $karantina - $pemusnahan;
										// echo "2";
									}
									
									echo rupiah($sisastok);
								?>
							</td>
							<!-- <td>
								<?php // echo $data['Stok'];?>
							</td> -->
							<?php //} ?>
							<?php if($username != "DINAS KESEHATAN"){ ?>
							<td align="center">
								<div class="btn-group">
									<button data-toggle="dropdown" class="btn btn-xs btn-info btn-white dropdown-toggle" aria-expanded="true">Opsi<span class="ace-icon fa fa-caret-down icon-on-right"></span></button>
									<ul class="dropdown-menu dropdown-info dropdown-menu-right">
										<li><a href="?page=gudang_besar_karantina&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>&faktur=<?php echo $data['NoFakturTerima'];?>&stsgudang=GUDANG BESAR&key=<?php echo $_GET['key'];?>&jmltersedia=<?php echo $_GET['jmltersedia'];?>">Karantina</a></li>
										<li><a href="?page=gudang_besar_stok_detail&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>&faktur=<?php echo $data['NoFakturTerima'];?>">Detail</a></li>
										<?php
											// cukup programmer dan apoteker saja, operator jangan karena lbh ke rekam medis (pendaftaran)
											if (in_array("PROGRAMMER", $otoritas) || in_array("APOTEKER", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
										?>
										<li><a href="?page=gudang_besar_stok_edit&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>">Edit</a></li>
										<?php
											// cek data, jika brg belum pernah didditribusikan boleh dihapus
											$cekbrg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluarandetail` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]';"));
											if ($cekbrg == 0) {
										?>
										<li><a href="?page=gudang_besar_stok_delete&id=<?php echo $data['IdBarang'];?>" onClick="return confirm('Anda yakin data ingin dihapus...')">Delete</a><li>
										
										<?php
											}		
											}	
										?>
									</ul>
								</div>
							</td>		
							<?php } ?>			
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
						echo "<li><a href='?page=gudang_besar_stok&key=$key&jmltersedia=$jmltersedia&h=$i'>$i</a></li>";
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
						- Warna <b>Pink</b>, obat sudah expire</br>
						- Warna <b>Kuning</b>, kurang dari 6 bulan memasuki expire</br>
						- Warna <b>Biru</b>, jumlah stok kurang dari minimal stok
					</p>
			</div>
		</div>
	</div>
</div>	