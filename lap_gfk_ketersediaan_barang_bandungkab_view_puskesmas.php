<?php
	$kota = $_SESSION['kota'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$hariini = date('Y-m-d');
 ?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>STOK BARANG </b><small>GUDANG DINKES (IFK)</small></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_ketersediaan_barang_bandungkab_view_puskesmas"/>
						<div class="col-xl-5">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama/Kode Barang/Batch/Program">
						</div>
						<div class="col-xl-2">
							<select name="jmltersedia" class="form-control">
								<option value="Tersedia" <?php if($_GET['jmltersedia'] == 'Tersedia'){echo "SELECTED";}?>>Tersedia</option>
								<option value="Keseluruhan" <?php if($_GET['jmltersedia'] == 'Keseluruhan'){echo "SELECTED";}?>>Keseluruhan</option>
								<option value="Expire" <?php if($_GET['jmltersedia'] == 'Expire'){echo "SELECTED";}?>>Expire</option>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_ketersediaan_barang_bandungkab_view_puskesmas&jmltersedia=Tersedia" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="lap_gfk_ketersediaan_barang_bandungkab_view_puskesmas_excel.php?key=<?php echo $_GET['key'];?>&jmltersedia=<?php echo $_GET['jmltersedia'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>-->
							<!--<a href="?page=lap_gfk_ketersediaan_barang_bandungkab_view_puskesmas_tambah" class="btn btn-sm btn-info">Tambah Data</a>-->
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	<?php	
		$jumlah_perpage = 50;
		
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
			$stoks = "`Stok` > '0' AND `Expire` < '$hariini' AND `NamaProgram` != 'VAKSIN' AND";
		}else{
			$stoks = "`Stok` > '0' AND";
		}	
		
		if($key !=''){
			$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%') AND `SumberAnggaran` != 'BLUD'";
		}else{
			$strcari = " `SumberAnggaran` != 'BLUD'";
		}
			
		$str = "SELECT * FROM `tbgfkstok` WHERE".$stoks.$strcari;
		$str2 = $str." order by NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
		
		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
	?>

	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul" width="100%">
				<thead>
					<tr>
						<th width="3%">NO.</th>
						<th width="5%">KODE</th>
						<th width="30%">NAMA BARANG</th>
						<th width="5%">SATUAN</th>
						<th width="10%">BATCH</th>
						<th width="10%">EXPIRE</th>
						<th width="10%">SUMBER</th>
						<th width="5%">TAHUN</th>
						<th width="10%">PROGRAM</th>
						<th width="5%">HARGA</th>
						<th width="7%">STOK</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;										
						$Expire = $data['Expire'];
						$kodeobat = $data['KodeBarang'];
						$nobatch = $data['NoBatch'];

						// mencari jumlah hari sebelum expire
						$wl = explode("-",$Expire);
						$waktu_expire = mktime(0,0,0,$wl[1],$wl[2],$wl[0]);
						$now = mktime(0,0,0,date("m"),date("d"),date("Y"));
						$selisih = $waktu_expire - $now;
						$day = floor($selisih/86400);
						
						// if($data['Stok'] <= $data['MinimalStok']){
							// $warna = 'lightblue';
						// }else{	
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
						// }
						
						
						if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
							$sumber = "APBD"; 
						}else{
							$sumber = $data['SumberAnggaran']; 
						}

						if($data['NamaProgram'] == "BAHAN HABIS PAKAI" || $data['NamaProgram'] == "BAHAN MEDIS HABIS PAKAI"){
							$namaprogram = "BMHP";
						}else{
							$namaprogram = $data['NamaProgram'];
						}	
					?>
					<tr style="background:<?php echo $warna;?>;">
						<td align="right"><?php echo $no;?></td>
						<td align="center"><?php echo $data['KodeBarang'];?></td>
						<td class="nama">
							<?php 
								echo $data['NamaBarang']."<br/>";									
								if($data['NamaTambahan'] != "-"){
							?>
								<span style='font-size: 10px; font-style: italic'><?php echo $data['NamaTambahan'];?></span>
							<?php } ?>
						</td>
						<td align="center"><?php echo $data['Satuan'];?></td>
						<td align="center"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
						<td align="center"><?php echo $data['Expire'];?></td>
						<td align="center"><?php echo $sumber;?></td>
						<td align="center"><?php echo $data['TahunAnggaran'];?></td>
						<td align="center"><?php echo $namaprogram;?></td>
						<td align="right"><?php echo number_format("$data[HargaBeli]",2,",",".");?></td>
						<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Stok']);?></td>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
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
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_gfk_ketersediaan_barang_bandungkab_view_puskesmas&key=$key&jmltersedia=$jmltersedia&h=$i'>$i</a></li>";
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