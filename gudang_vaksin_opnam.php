<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>STOK OPNAME</b><small> Gudang Vaksin</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="gudang_vaksin_opnam"/>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning">Cari</button>
							<a href="?page=gudang_vaksin_opnam" class="btn btn-sm btn-success">Refresh</a>
							<a href="?page=gudang_vaksin_opnam_tambah" class="btn btn-sm btn-primary">Buat Faktur</a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>
	<?php
		$jumlah_perpage = 12;		
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}		
		
		$key = $_GET['key'];			
					
		$str = "SELECT * FROM tbstokbulananvaksindinas ";
		$str2 = $str." GROUP BY Bulan, Tahun ORDER BY IdBarang DESC LIMIT $mulai,$jumlah_perpage";
		
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
							<th width="10%">Bulan</th>
							<th width="10%">Tahun</th>
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
								<td align="right"><?php echo $no;?></td>
								<td align="left"><?php echo nama_bulan($data['Bulan']);?></td>
								<td align="center"><?php echo $data['Tahun'];?></td>
								<td align="left"><?php echo $data['Keterangan'];?></td>
								<td align="center">
									<a href="?page=gudang_vaksin_opnam_lihat&bl=<?php echo $data['Bulan'];?>&th=<?php echo $data['Tahun'];?>" class="btn btn-xs btn-info btn-white">Lihat</a>
									<?php
										// cek faktur jika ada tdk bisa dihapus
										$cekfaktur = mysqli_num_rows(mysqli_query($koneksi, "SELECT KodeBarang FROM `tbstokbulananvaksindinas` WHERE `Bulan`='$data[Bulan]' AND `Tahun`='$data[Tahun]'"));
										if($cekfaktur == 0){
									?>
										<a href="?page=gudang_vaksin_opnam_hapus&nf=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-danger btn-white">Hapus</a>
									<?php } ?>
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
			$query2 = mysqli_query($koneksi,$str2);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=gudang_vaksin_opnam&h=$i'>$i</a></li>";
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
					- Kedua, klik menu Lihat lalu isikan kolom Stok Fisik
				</p>
			</div>
		</div>
	</div>
</div>	
 
