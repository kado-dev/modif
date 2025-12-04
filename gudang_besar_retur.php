<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>RETUR PUSKESMAS</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="gudang_besar_retur"/>
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
							<button type="submit" class="btn btn-round btn-warning">Cari</button>
							<a href="?page=gudang_besar_retur" class="btn btn-round btn-success">Refresh</a>
							<!--<a href="?page=gudang_besar_retur_tambah" class="btn btn-round btn-success">Entry Baru</a>-->
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
					
		$str = "SELECT * FROM `tbgudangpkmretur`";
		$str2 = $str." ORDER BY IdRetur DESC LIMIT $mulai,$jumlah_perpage";
		
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
							<th width="15%">Status</th>
							<th width="15%">Penerima</th>
							<th width="25%">Keterangan</th>
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
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalRetur']));?></td>
								<td align="center"><?php echo $data['NoFaktur'];?></td>
									<td align="center"><?php echo $data['StatusRetur'];?></td>
								<td align="center"><?php echo $data['Penerima'];?></td>
								<td align="center"><?php echo $data['Keterangan'];?></td>
								<td align="center">
									<a href="?page=gudang_besar_retur_lihat&nf=<?php echo $data['NoFaktur'];?>" class="btn btn-round btn-xs btn-info">Lihat</a>
									<a href="?page=gudang_besar_retur_hapus&nf=<?php echo $data['NoFaktur'];?>" class="btn btn-round btn-xs btn-danger" onClick="return confirm('Anda yakin data ingin dihapus...?')">Hapus</a>
								</td>			
							</tr>
						<?php } ?>
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
						echo "<li><a href='?page=gudang_besar_retur&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
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
					- Pertama, klik menu Buat Faktur</br>
					- Kedua, klik menu Lihat lalu isikan kolom Retur Barang
				</p>
			</div>
		</div>
	</div>
</div>	
 
