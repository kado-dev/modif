<?php
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA LPLPO</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="master_obat"/>
						<div class="col-xl-4">
							<div class="input-group">
								<select name="namaprg" class="form-control">
									<option value=''>Semua</option>
									<option value='JKN' <?php if($_GET['namaprg'] == 'JKN'){echo "SELECTED";}?>>JKN</option>
									<?php
									$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['namaprg'] == $data3['nama_program']){
											echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
										}else{
											echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
										}
									}
									?>
								</select>
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">Program</span>
								</div>
							</div>
						</div>
						<div class="col-xl-4">
							<input type="text" name="key" class="form-control key" placeholder="Ketikan Nama Barang" value="<?php echo $_GET['key'];?>">
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_obat" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="master_obat_excel.php?bulan=<?php echo date("m");?>&tahun=<?php echo date("Y");?>&namaprg=<?php echo $_GET['namaprg'];?>$key=<?php echo $_GET['key'];?>" class="btn btn-round btn-info">Excel</a>
							<a href="?page=master_obat_tambah" class="btn btn-round btn-success">Tambah</a>		
						</div>
					</div>
				</form>		
			</div>
		</div>
	</div>
	<?php
		$key = $_GET['key'];
		$namaprg = $_GET['namaprg'];
		
		if($namaprg == ""){
			$program = "";				
		}else{
			$program = " AND `NamaProgram` = '$namaprg'";
		}			
		
		$ref_obat_lplpo = "ref_obat_lplpo_".str_replace(' ', '', $namapuskesmas);
		$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')".$program;
		$str2 = $str." ORDER BY NamaProgram, NamaBarang ASC";
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="5%">NO.</th>
							<th width="10%">KODE ELOG</th>
							<th width="10%">KODE KFA</th>
							<th width="10%">KODE BARANG</th>
							<th width="50%">NAMA BARANG</th>
							<th width="15%">SATUAN</th>
							<th width="5%">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 0;	
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $data['IdKetersediaan'];?></td>
								<td align="center"><?php echo $data['IdKfa'];?></td>
								<td align="center"><?php echo $data['KodeBarang'];?></td>
								<td align="left" class="nama"><?php echo $data['NamaBarang'];?></td>		
								<td align="center" class="nama"><?php echo $data['Satuan'];?></td>	
								<td><a href='?page=master_obat_edit&id=<?php echo $data['IdBarang'];?>' class="btn btn-info">Edit</a></td>	
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
						echo "<li><a href='?page=master_obat&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
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