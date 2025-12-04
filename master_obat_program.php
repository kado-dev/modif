<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PROGRAM OBAT</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="master_obat_program"/>
						<div class="col-sm-9">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_obat_program" class="btn btn-round btn-info"><span class="fa fa-refresh"></a>
							<a href="?page=master_obat_program_tambah" class="btn btn-round btn-success">Tambah</a>
						</div>
					</div>	
				</form>	
			</div>
		</div>
	</div>


	<?php
		$jumlah_perpage = 20;
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$key = $_GET['key'];
		if($key != ''){
			$keys = " WHERE `nama_program` like '%$key%'";				
		}else{
			$keys = "";
		}		
		$str = "SELECT * FROM `ref_obatprogram`".$keys;
		$str2 = $str." ORDER BY nama_program LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="3%">No</th>
							<th width="90%">Nama Program</th>
							<th width="7%">Aksi</th>
						</tr>
					</thead>
					<tbody>
					<?php
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
							<td class="nama"><?php echo $data['nama_program'];?></td>									
							<td align="center">
								<?php if($_SESSION['otoritas'] == 'PROGRAMMER'){ ?>
									<a href="?page=master_obat_program_delete&id=<?php echo $data['id'];?>" class="btnmodalpegawaiedit btn-round btn btn-sm btn-danger" onClick="return confirm('Anda yakin data ingin didelete...?')">Hapus</a>
								<?php }?>	
							</td>									
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
						echo "<li><a href='?page=master_obat_program&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	