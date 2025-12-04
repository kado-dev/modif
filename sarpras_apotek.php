<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">DATA APOTEK</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="sarpras_apotek"/>
						<div class="col-sm-8">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nomor Faktur, minimal 4 digit" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=sarpras_apotek" class="btn btn-primary btn-white"><span class="glyphicon glyphicon-refresh"></span></a>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<a href="?page=sarpras_apotek_tambah" class="btn btn-success btn-white">Tambah Data</a>
							<?php }?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!--data barang-->
	<div class="row">	
		<div class="col-lg-12">
			<div class="table-responsive" style="font-size:12px">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="4%">No</th>
							<th width="8%">Tanggal</th>
							<th width="10%">No.Faktur</th>
							<th width="10%">Sumber Anggaran</th>
							<th width="8%">Tahun</th>
							<th width="20%">Keterangan</th>
							<th width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 10;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$kategori = $_GET['kategori'];		
						$key = $_GET['key'];	
						
						if(isset($key)){
							$strcari = " AND `NoFaktur` Like '%$key%'";
						}else{
							$strcari = " ";
						}
						
						$str = "SELECT * FROM `tbgudangpkmpengadaan` WHERE SUBSTRING(NoFaktur,1,11)='$kodepuskesmas'".$strcari;	
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
								<td align="center"><?php echo $data['TanggalPengadaan'];?></td>
								<td align="center" class="nama"><?php echo $data['NoFaktur'];?></td>
								<td align="center"><?php echo $data['SumberAnggaran'];?></td>
								<td align="center"><?php echo $data['TahunAnggaran'];?></td>
								<td align="left"><?php echo $data['Keterangan'];?></td>
								<td align="center">
									<a href="?page=sarpras_apotek_lihat&id=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-info btn-white"> Lihat</a>
									<?php
										// jika masih adata data, tidak dapat dihapus
										$cekdata = mysqli_num_rows(mysqli_query($koneksi, "SELECT KodeBarang FROM `tbgudangpkmpengadaandetail` WHERE `Nofaktur`='$data[NoFaktur]'"));
										if($cekdata == ''){
									?>
									<a href="?page=sarpras_apotek_delete&id=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-danger btn-white"> Hapus</a>
									<?php
										}
									?>
								</td>							
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	
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
						echo "<li><a href='?page=sarpras_apotek&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul> 
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p><b>Perhatikan :</b><br/>
				Tombol hapus tampil jika tidak ada item barang pada detail pengadaan<br/>
			</div>
		</div>
	</div>
</div>	
