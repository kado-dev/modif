<?php
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">PENGELUARAN VAKSIN</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="apotik_vaksin_gudang_pengeluaran"/>
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
							<a href="?page=apotik_vaksin_gudang_pengeluaran" class="btn btn-round btn-primary"><span class="fa fa-refresh"></span></a>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<a href="?page=apotik_vaksin_gudang_pengeluaran_tambah" class="btn btn-round btn-success">Buat Faktur</a>
							<?php }?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row">	
		<div class="col-lg-12">
			<div class="table-responsive" style="font-size:12px">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="5%">NO.</th>
							<th width="15%">TANGGAL</th>
							<th width="15%">NO.FAKTUR</th>
							<th width="50%">PENERIMA</th>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<th width="15%">#</th>
							<?php }?>
						</tr>
					</thead>
					<tbody font="8">
						<!--paging-->
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
						
						if($kodepuskesmas == ''){
						
						}
						
						if(isset($kategori) && isset($key)){
							$strcari = " AND tbpuskesmas.".$kategori." Like '%$key%' ";
						}else{
							$strcari = " ";
						}
						
						$str = "select * from `tbgudangpkmvaksinpengeluaran`  where substring(NoFaktur,1,11) = '$kodepuskesmas' ".$strcari;
						$str2 = $str." order by `NoFaktur` Desc limit $mulai,$jumlah_perpage";
						// echo var_dump($str2);
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
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalPengeluaran'];?></td>
								<td align="center" class="nama"><?php echo substr($data['NoFaktur'],12,10);?></td>
								<td align="left"><?php echo strtoupper($data['Penerima']);?></td>
								<?php 
									// cukup apotek dan programmer saja yg bs menghapus, dengan syarat item baramg difaktur sdh 0
									if (in_array("APOTEK", $otoritas) || in_array("PROGRAMMER", $otoritas)){
								?>			
								<td align="center">
									<a href="?page=apotik_vaksin_gudang_pengeluaran_lihat&nf=<?php echo $data['NoFaktur'];?>" class="btn btn-round btn-sm btn-info">LIHAT</a>
									<?php
										$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoFaktur` FROM `tbgudangpkmvaksinpengeluarandetail` WHERE `NoFaktur` = '$data[NoFaktur]'"));
										if($cek == 0){
									?>
									<a href="?page=apotik_vaksin_gudang_pengeluaran_hapus&id=<?php echo $data['NoFaktur'];?>" class="btn btn-round btn-sm btn-danger btnhapus">HAPUS</a>
									<?php 
										}
									?>	
								</td>
								<?php 
									}
								?>
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
						echo "<li><a href='?page=apotik_gudang_stok&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
