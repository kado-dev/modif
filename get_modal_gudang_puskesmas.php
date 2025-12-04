<!--untuk menampilkan modal-->
<div class="modal fade" id="modalgudangpuskesmas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Data Barang</h4>
			</div>

			<div class="modal-body">
				<!--cari barang-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<h4><span class="glyphicon glyphicon-search"></span>  Cari Berdasar</h4>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<form role="form">
								<div class="col-sm-2">
									<select name="kategori" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="NamaBarang">Nama Barang</option>
										<option value="Puskesmas">Batch</option>
									</select>
								</div>
								<div class="col-sm-8">
									<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-md btn-primary">Cari</button>
									<a href="#" class="btn btn-md btn-success"><span class="glyphicon glyphicon-refresh"></span></a>
								</div>
								<input type="text" name="page" value="apotik_gudang_stok"/><!--cara manggil value-->
							</form>	
						</div>
					</div>
				</div>
				<hr>
				
				<!--data barang-->
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th class="col-sm-2">Kode</th>
							<th class="col-sm-6">Nama Barang</th>
							<th class="col-sm-2">Satuan</th>
							<th class="col-sm-2">Aksi</th>
						</tr>
					</thead>
					
					<tbody>
						<?php
						//cari
						$kategori = $_GET['kategori'];		
						$key = $_GET['key'];		
						
						if(isset($kategori) && isset($key)){
							if($kategori == 'NamaBarang'){
								$strcari = " AND tbgfkstok.NamaBarang Like '%$key%'";
							}else{
								$strcari = " AND tbgfkstok.NoBatch Like '%$key%'";
							}
						}else{
							$strcari = " ";
						}
						
						include "config/koneksi.php";
						$query = mysqli_query($koneksi,"select * from `tbgfkstok` group by `NamaBarang`");
						while($data = mysqli_fetch_assoc($query)){
						?>
						<tr>
							<td><?php echo $data['KodeBarang'];?></td>
							<td class="nama"><?php echo $data['NamaBarang'];?></td>
							<td class="nama"><?php echo $data['Satuan'];?></td>
							<td>
								<a href="?page=master_asuransi_edit&id=<?php echo $data['KodeBarang'];?>" class="btn btn-xs btn-info">Pilih</a>
							</td>	
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>