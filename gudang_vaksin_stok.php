<?php
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK BARANG </b><small>Gudang Vaksin</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="gudang_vaksin_stok"/>
						<div class="col-sm-5">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Kode/Nama/Batch/No.Faktur Terima">
						</div>
						<div class="col-sm-2">
							<select name="jmltersedia" class="form-control">
								<option value="Tersedia" <?php if($_GET['jmltersedia'] == 'Tersedia'){echo "SELECTED";}?>>Tersedia</option>
								<option value="Keseluruhan" <?php if($_GET['jmltersedia'] == 'Keseluruhan'){echo "SELECTED";}?>>Keseluruhan</option>								
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=gudang_vaksin_stok&jmltersedia=Tersedia" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="gudang_vaksin_stok_excel.php?kategori=<?php echo $_GET['kategori'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
							<!--<a href="?page=gudang_vaksin_stok_tambah" class="btn btn-sm btn-success">Tambah Data</a>-->
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="5%">KODE</th>
							<th width="17%">NAMA BARANG</th>
							<th width="5%">SATUAN</th>
							<th width="10%">BATCH</th>
							<th width="10%">EXPIRE</th>
							<th width="10%">SUMBER</th>
							<th width="5%">TAHUN</th>							
							<th width="5%">PROGRAM</th>
							<th width="5%">STOK</th>
							<th width="5%">#</th>
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
						
						$jmltersedia = $_GET['jmltersedia'];							
						$key = $_GET['key'];	

						if($jmltersedia == 'Keseluruhan'){
							$stoks = "";
						}else{
							$stoks = "`Stok` > '0' AND";
						}	
						
						if($key !=''){
							$strcari = "(`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%' OR `NoBatch` like '%$key%' OR `NamaProgram` like '%$key%' OR `NoFakturTerima` like '%$key%')";
						}else{
							$strcari = " `SumberAnggaran` != 'BLUD'";
						}
		
						$str = "SELECT * FROM `tbgfk_vaksin_stok` WHERE".$stoks.$strcari;
						$str2 = $str." order by NamaBarang, NoFakturTerima ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}	
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){							
							$kodeobat = $data['KodeBarang'];
							$nobatch = $data['NoBatch'];
							$nomorpembukuan = $data['NoFakturTerima'];
							$Expire = $data['Expire'];

							// mencari jumlah hari sebelum expire
							$wl = explode("-",$Expire);
							$waktu_expire = mktime(0,0,0,$wl[1],$wl[2],$wl[0]);
							$now = mktime(0,0,0,date("m"),date("d"),date("Y"));
							$selisih = $waktu_expire - $now;
							$day = floor($selisih/86400);
							
							if($data['Stok'] <= $data['MinimalStok']){
								$warna = 'pink';
							}else{	
								if($day < 180){	
									if($day > 0){
										$warna = 'lightblue';
									}else{
										$warna = 'yellow';
									}
								}else{
									$warna = 'white';
								}
							}
							
							$no = $no + 1;
						?>
						
						<tr style="background:<?php echo $warna;?>;">
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeBarang'];?></td>
							<td class="nama"><?php echo $data['NamaBarang'];?></td>
							<td align="center"><?php echo $data['Satuan'];?></td>
							<td align="center"><?php echo $data['NoBatch'];?></td>
							<td align="center"><?php echo $data['Expire'];?></td>
							<td align="center"><?php echo $data['SumberAnggaran'];?></td>
							<td align="center"><?php echo $data['TahunAnggaran'];?></td>
							<td align="center"><?php echo $data['NamaProgram'];?></td>
							<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Stok']);?></td>
							<td align="center">
								<div class="btn-group">
									<button data-toggle="dropdown" class="btn btn-xs btn-info btn-white dropdown-toggle" aria-expanded="true">Opsi<span class="ace-icon fa fa-caret-down icon-on-right"></span></button>
									<ul class="dropdown-menu dropdown-info dropdown-menu-right">
										<?php
											if (in_array("PROGRAMMER", $otoritas) || in_array("APOTEKER", $otoritas) || in_array("ASISTEN APOTEKER", $otoritas)){
										?>
										<li><a href="?page=gudang_vaksin_stok_edit&kd=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>">Edit</a></li>
										<?php
											}
										?>	
										<li><a href="?page=gudang_vaksin_stok_detail&id=<?php echo $data['KodeBarang'];?>&batch=<?php echo $data['NoBatch'];?>">Detail</a></li>
										<!--<li><a href="?page=gudang_vaksin_stok_delete&id=<?php //echo $data['KodeBarang'];?>" class="btnhapus">Delete</a></li>-->
									</ul>
								</div>
							</td>			
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
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
						echo "<li><a href='?page=gudang_vaksin_stok&key=$key&jmltersedia=$jmltersedia&h=$i'>$i</a></li>";
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
						- Warna <b>Kuning</b>, obat sudah expire</br>
						- Warna <b>Biru</b>, kurang dari 6 bulan memasuki expire</br>
						- Warna <b>Pink</b>, jumlah stok kurang dari minimal stok
					</p>
			</div>
		</div>
	</div>
</div>	