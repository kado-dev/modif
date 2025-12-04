<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DATA ASET</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="master_aset"/>
						<div class="col-sm-8">
							<input type="text" name="key" class="form-control key" placeholder="Ketikan Nama Aset" value="<?php echo $_GET['key'];?>">
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_aset" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="?page=master_aset_tambah" class="btn btn-sm btn-success">Tambah Data</a>
							<!--<a href="master_aset_excel.php?bulan=<?php echo date("m");?>&tahun=<?php echo date("Y");?>&namaprg=<?php echo $_GET['namaprg'];?>$key=<?php echo $_GET['key'];?>" class="btn btn-info btn-white">Excel</a>-->
						</div>
					</form>	
				</div>	
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
		
		$key = $_GET['key'];
		$namaprg = $_GET['namaprg'];
		
		if($namaprg == ""){
			$program = "";				
		}else{
			$program = " AND `NamaProgram` = '$namaprg'";
		}			
		
		$str = "SELECT * FROM `ref_aset` WHERE (`NamaBarang` like '%$key%')".$program;
		$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="5%">NO.</th>
							<th width="60%">NAMA BARANG</th>
							<th width="15%">SATUAN</th>
							<th width="20%">KELOMPOK</th>
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
								<td align="left" class="nama"><?php echo strtoupper($data['NamaBarang']);?></td>		
								<td align="center"><?php echo strtoupper($data['Satuan']);?></td>		
								<td align="center"><?php echo strtoupper($data['Kelompok']);?></td>		
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
						echo "<li><a href='?page=master_aset&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<!--<div class="row noprint">
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
	</div>-->
</div>	