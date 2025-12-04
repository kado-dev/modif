<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PENDAMPINGAN SIMPUS</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="invoice_add"/>
						<div class="col-xl-2">
							<select name="kategori" class="form-control" required>
								<option value="">--Pilih--</option>
								<option value="NoFaktur" <?php if($_GET['kategori'] == 'NoFaktur'){echo "SELECTED";}?>>No.Faktur</option>
							</select>
						</div>
						<div class="col-xl-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=adm_pendampingan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php
								if($_SESSION['otoritas'] == 'PROGRAMMER' ||$_SESSION['otoritas'] == 'IMPLEMENTATOR'){
							?>
							<a href="?page=adm_pendampingan_tambah" class="btn btn-round btn-success">Tambah Data</a>
							<?php } ?>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	

	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%">Tgl.Kunjungan</th>
						<th width="15%">Puskesmas</th>
						<th width="10%">Jml.Komputer</th>
						<th width="10%">Jml.Printer</th>
						<th width="10%">Kecepatan Internet</th>
						<th width="10%">Aksi</th>
					</tr>
				</thead>
				<tbody>
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
													
					$str = "select * from `tbadm_pendampingan`";
					$str2 = $str." order by `NoFaktur` Desc limit $mulai,$jumlah_perpage";
					// echo $str2;
					
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
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $data['Tanggal'];?></td>
							<td align="left" class="nama"><?php echo $data['Puskesmas'];?></td>
							<td align="right"><?php echo $data['Komputer'];?></td>
							<td align="right"><?php echo $data['Printer'];?></td>
							<td align="right"><?php echo $data['Internet'];?></td>
							<td align="center">
								<!--<button class="btn btn-xs btn-info btn-white btnmodallihat" id="<?php echo $data['Foto'];?>">Lihat</button>-->
								<button class="btn btn-xs btn-info btn-white btnmodallihat" data-nofaktur="<?php echo $data['NoFaktur'];?>">Lihat</button>
								<?php if($_SESSION['otoritas'] == 'PROGRAMMER'){ ?>
								<a href="?page=adm_pendampingan_hapus&faktur=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-danger btn-white btnhapus">Hapus</a>
								<?php }?>	
							</td>			
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
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
						echo "<li><a href='?page=adm_pendampingan&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
	