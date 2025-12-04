<?php
	$otoritas = explode(',',$_SESSION['otoritas']);
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>
<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul">STOK BARANG <small>(Aset)</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="aset_stok"/>
						<div class="col-sm-8">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Barang">
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=aset_stok" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="aset_stok_excel.php?key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>-->
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="35%">NAMA BARANG</th>
							<th width="10%">SATUAN</th>
							<th width="10%">SUMBER</th>
							<th width="10%">HARGA</th>
							<th width="10%">STOK</th>
							<!--<th width="15%">AKSI</th>-->
						</tr>
					</thead>
					<tbody>
						<?php		
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}	
												
						$key = $_GET['key'];

						if($key != ''){
							$strcari = "(`KodeBarang` like '%$key%' OR `NamaBarang` like '%$key%') AND ";
						}else{
							$strcari = "";
						}

						$str = "SELECT * FROM `tbasetstok` WHERE `KodePuskesmas` = '$kodepuskesmas' AND `Stok` > '0'".$strcari;			
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
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="left"><?php echo strtoupper($data['NamaBarang']);?><span class="badge badge-success" style="margin-left: 10px; font-size: 10px; padding: -2px;"><?php echo $data['Kelompok'];?></span></td>
								<td align="center"><?php echo strtoupper($data['Satuan']);?></td>
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
								<td align="right"><?php echo rupiah($data['HargaSatuan']);?></td>
								<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Stok']);?></td>
								<!--<td align="center">
									<a href="?page=aset_stok_lihat&id=<?php echo $data['IdBarangPkm'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-xs btn-primary">Lihat</a>
									<a href="?page=aset_stok_edit&kd=<?php echo $data['KodeBarang'];?>&pkm=<?php echo $data['KodePuskesmas'];?>&nb=<?php echo $data['NoBatch'];?>" class="btn btn-sm btn-info">Edit</a>
									<a href="?page=aset_stok_delete&id=<?php echo $data['IdBarangPkm'];?>&key=<?php echo $_GET['key'];?>&h=<?php echo $_GET['h'];?>" class="btn btn-sm btn-danger" onClick="return confirm('Anda yakin data ingin dikosongkan...?')">Habis</a>
								</td>-->
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
						echo "<li><a href='?page=aset_stok&h=$i'>$i</a></li>";
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
						- Nama barang yang ditampilkan stoknya > 0
					</p>
			</div>
		</div>
	</div>
</div>
