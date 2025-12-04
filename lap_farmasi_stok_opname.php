<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>CEK FISIK</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_stok_opname"/>
						<div class="col-sm-2">
							<select name="kategori" class="form-control" required>
								<option value="">--Pilih--</option>
								<option value="NomorPembukuan" <?php if($_GET['kategori'] == 'NomorPembukuan'){echo "SELECTED";}?>>No.Pembukuan</option>
								<option value="Supplier" <?php if($_GET['kategori'] == 'Supplier'){echo "SELECTED";}?>>Supplier</option>
								<option value="SumberAnggaran" <?php if($_GET['kategori'] == 'SumberAnggaran'){echo "SELECTED";}?>>Sumber Anggaran</option>
								<option value="TahunAnggaran" <?php if($_GET['kategori'] == 'TahunAnggaran'){echo "SELECTED";}?>>Tahun Anggaran</option>
							</select>
						</div>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="?page=lap_farmasi_stok_opname" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
							<a href="?page=lap_farmasi_stok_opname_tambah" class="btn btn-primary btn-white">Buat Faktur</a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>
	<?php
		$kodepuskesmas = $_SESSION['kodepuskesmas'];
		$jumlah_perpage = 20;		
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}		
		$key = $_GET['key'];			
					
		$str = "SELECT * FROM `tbstokopnam_puskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'";
		$str2 = $str." ORDER BY IdSo DESC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
		
		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="3%">No</th>
							<th width="10%">Tanggal</th>
							<th width="15%">No.Faktur</th>
							<th width="10%">Bulan</th>
							<th width="10%">Tahun</th>
							<th width="10%">Keterangan</th>
							<th width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalSo'];?></td>
								<td align="center"><?php echo $data['NoFaktur'];?></td>
								<td align="center"><?php echo $data['Bulan'];?></td>
								<td align="center"><?php echo $data['Tahun'];?></td>
								<td align="left"><?php echo $data['Keterangan'];?></td>
								<td align="center">
									<a href="?page=lap_farmasi_stok_opname_lihat_gudang&nf=<?php echo $data['NoFaktur'];?>&bl=<?php echo $data['Bulan'];?>&th=<?php echo $data['Tahun'];?>" class="btn btn-xs btn-info btn-white">Lihat</a>
								</td>			
							</tr>
						<?php } ?>
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
						echo "<li><a href='?page=lap_farmasi_stok_opname&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<h5><b>Perhatikan</b></h5> 
					- Silahkan klik tombol Buat Faktur
				</p>
			</div>
		</div>
	</div>
</div>	
 
