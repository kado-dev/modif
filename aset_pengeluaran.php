<?php
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul">PENGELUARAN BARANG <small>(Aset)</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="aset_pengeluaran"/>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=aset_pengeluaran" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="?page=aset_pengeluaran_tambah" class="btn btn-sm btn-success">Buat Faktur</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">	
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="5%">NO.</th>
							<th width="10%">TANGGAL</th>
							<th width="10%">FAKTUR</th>
							<th width="15%">PENERIMA</th>
							<th width="15%">KET</th>
							<th width="10%">AKSI</th>
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
						$kodepuskesmas = $_SESSION['kodepuskesmas'];		
						
						$str = "SELECT * FROM `tbasetpengeluaran` WHERE SUBSTRING(NoFaktur,1,11) = '$kodepuskesmas' AND `Penerima` Like '%$key%'";
						$str2 = $str." ORDER BY `NoFaktur` DESC LIMIT $mulai,$jumlah_perpage";
						// echo var_dump($str2);
						// die();
						
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
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalPengeluaran'];?></td>
								<td align="center"><?php echo substr($data['NoFaktur'], -8);?></td>
								<td align="left"><?php echo $data['Penerima'];?></td>
								<td align="left"><?php echo strtoupper($data['Keterangan']);?></td>	
								<td align="center">
									<a href="?page=aset_pengeluaran_lihat&id=<?php echo $data['IdDistribusi'];?>" class="btn btn-xs btn-info">Lihat</a>
									<?php
										$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoFaktur` FROM `tbasetpengeluarandetail` WHERE `NoFaktur` = '$data[NoFaktur]'"));
										if($cek == 0){
									?>
									<a href="?page=aset_pengeluaran_hapus&id=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-danger btnhapus">Hapus</a>
									<?php 
										}
									?>	
								</td>
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
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=apotik_gudang_stok&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
