<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA SUPPLIER </b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="master_supplier"/>
						<div class="col-sm-9">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_supplier" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="?page=master_supplier_tambah" class="btn btn-round btn-success">Tambah</a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>

	<!--data-->
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="5%">Kode</th>
						<th width="90%">Supplier</th>
						<th width="5%">Aksi</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$jumlah_perpage = 20;
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
							
					$key = $_GET['key'];
					if($key !=''){
						$strcari = "WHERE nama_prod_obat LIKE '%".$key."%'";
					}else{
						$strcari = "";
					}
					
					$str = "SELECT * FROM `ref_pabrik` ".$strcari." ";
					$dt_supplier = $str."order by `id` DESC Limit $mulai,$jumlah_perpage";
					$query = mysqli_query($koneksi,$dt_supplier);
					while($data = mysqli_fetch_assoc($query)){
					?>
						<tr>
							<td align="center"><?php echo $data['id'];?></td>		
							<td align="left" class="nama"><?php echo $data['nama_prod_obat'];?></td>
							<td>
								<a href="?page=master_supplier_delete&id=<?php echo $data['id'];?>" class="btn btn-round btn-sm btn-danger btnhapus">Hapus</a>
							</td>		
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<hr>
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
								echo "<li><a href='?page=master_supplier&key=$key&h=$i'>$i</a></li>";
							}
						}
					}
				?>	
			</ul>
		</div>
	</div>
</div>