<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Pengeluaran Barang <small>Gudang Obat UPTD</small></h1>
		</div>
	</div>
</div>

<!--cari barang-->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-search"></i> Cari Barang</h4>
			</div>
			<div class="space-10"></div>
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="uptd_gudang_pengeluaran"/>
						<div class="col-sm-2">
							<select name="kategori" class="form-control" required>
								<option value="">--Pilih--</option>
								<option value="NoFaktur" <?php if($_GET['kategori'] == 'NoFaktur'){echo "SELECTED";}?>>No.Faktur</option>
							</select>
						</div>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=uptd_gudang_pengeluaran" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="?page=uptd_gudang_pengeluaran_tambah" class="btn btn-sm btn-danger"><span class="fa fa-plus-circle"></span> Entry Baru</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!--data barang-->
<div class="row">	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h4 class="panel-title"><i class="fa fa-bars"></i> Data Barang</h4>
		</div>
		<div class="box-body">
			<div class="table-responsive" style="font-size:12px">
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Faktur</th>
							<th>Kode</th>
							<th>Puskesmas</th>
							<th>Keterangan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody font="8">
						<!--paging-->
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$kategori = $_GET['kategori'];		
						$key = $_GET['key'];		
						$kodepuskesmas = $_SESSION['kodepuskesmas'];		
						
						if($kodepuskesmas == ''){
						
						}
						
						if(isset($kategori) && isset($key)){
							$strcari = " AND tbpuskesmas.".$kategori." Like '%$key%' ";
						}else{
							$strcari = " ";
						}
						
						$str = "select * from `tbgudanguptdpengeluaran`  where substring(NoFaktur,1,11) = '$kodepuskesmas' ".$strcari;
						$str2 = $str." order by `NoFaktur` Desc limit $mulai,$jumlah_perpage";
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
								<td><?php echo $no;?></td>
								<td><?php echo $data['TanggalPengeluaran'];?></td>
								<td class="nama"><?php echo $data['NoFaktur'];?></td>
								<td><?php echo $data['KodePuskesmas'];?></td>
								<?php
									$str_pkm = "SELECT * from tbpuskesmas where KodePuskesmas = '$data[KodePuskesmas]'";
									$query_pkm = mysqli_query($koneksi,$str_pkm);
									$data_pkm = mysqli_fetch_assoc($query_pkm);
								?>
								<td><?php echo $data_pkm['NamaPuskesmas'];?></td>
								<td><?php echo $data['Keterangan'];?></td>
								<td>
									<a href="?page=uptd_gudang_pengeluaran_lihat&id=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-info">Lihat</a>
									<a href="?page=uptd_gudang_pengeluaran_hapus&id=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-danger btnhapus">Hapus</a>
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
					echo "<li><a href='?page=uptd_gudang_stok&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>
