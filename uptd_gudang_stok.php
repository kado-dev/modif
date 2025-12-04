<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Stok Barang <small>Gudang Obat UPTD</small></h1>
		</div>
	</div>
</div>

<!--cari data-->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="search-area well well-sm">
			<div class="search-filter-header bg-primary">
				<h4 class="panel-title"><i class="fa fa-search"></i> Cari Barang</h4>
			</div>
			<div class="space-10"></div>
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="uptd_gudang_stok"/>
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
						<a href="?page=uptd_gudang_stok" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						<a href="?page=uptd_gudang_stok_tambah" class="btn btn-sm btn-danger"><span class="fa fa-plus-circle"></span> Master Brg</a>
						<!--<a href="import_obat_bpjs.php" class="btn btn-sm btn-danger">Import</a>-->
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<?php
	// include "config/helper_bpjs.php";
	// $jsontherapy = get_data_therapy();
	// echo $jsontherapy;
?>

<!--Kolom Entry-->
<div class="col-xs-12">
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
								<th>Pkm</th>
								<th>Kode</th>
								<th class="col-sm-3">Nama Barang</th><!--class="col-sm-4"-->
								<th>Satuan</th>
								<th>Batch</th>
								<th>Expire</th>
								<th>Stok</th>
								<th>Status</th>
								<th width="120">Aksi</th>
							</tr>
						</thead>
						<tbody font="8">
							<!--paging-->
							<?php
							$jumlah_perpage = 50;
							
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$kategori = $_GET['kategori'];		
							$key = $_GET['key'];		
							$kodepuskesmas = $_SESSION['kodepuskesmas'];		
							
							if($kategori != '' && $key != ''){
								$strcari = " AND b.".$kategori." Like '%$key%'";
							}else{
								$strcari = " ";
							}
							
							$str = "SELECT * FROM `tbgudanguptdstok` a
							JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
							WHERE a.`KodePuskesmas` = '$kodepuskesmas'".$strcari;
						
							$str2 = $str." order by b.`NamaBarang` Asc limit $mulai,$jumlah_perpage";
							// echo var_dump($str);
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
									<td><?php echo $data['KodePuskesmas'];?></td>
									<td><?php echo $data['KodeBarang'];?></td>
									<td class="nama"><?php echo $data['NamaBarang'];?></td>
									<td><?php echo $data['Satuan'];?></td>
									<td><?php echo $data['NoBatch'];?></td>
									<td><?php echo $data['Expire'];?></td>
									<td><?php echo $data['Stok'];?></td>
									<td><?php echo $data['SumberAnggaran'];?></td>
									<td>
										<a href="?page=uptd_gudang_stok_edit&id=<?php echo $data['KodeBarang'];?>" class="btn btn-xs btn-info">Edit</a>
										<a href="?page=uptd_gudang_stok_delete&id=<?php echo $data['KodeBarang'];?>"  class="btn btn-xs btn-danger btnhapus">Hapus</a>
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