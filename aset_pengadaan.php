<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>	
			<h3 class="judul">PENGADAAN BARANG <small>(Aset)</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="aset_pengadaan"/>
						<div class="col-sm-8">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nomor Faktur, minimal 4 digit" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=aset_pengadaan" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-refresh"></span></a>
							<a href="?page=aset_pengadaan_tambah" class="btn btn-sm btn-success">Buat Faktur</a>
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
							<th width="3%">NO.</th>
							<th width="10%">TANGGAL</th>
							<th width="10%">NO.FAKTUR</th>
							<th width="10%">SUMBER</th>
							<th width="10%">TAHUN</th>
							<th width="22%">SUPPLIER</th>
							<th width="20%">KETERANGAN</th>
							<th width="15%">AKSI</th>
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
						
						$str = "SELECT * FROM `tbasetpengadaan` WHERE SUBSTRING(NoFaktur,1,11)='$kodepuskesmas'".$strcari;	
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
							$kodesupplier = $data['KodeSupplier'];
							
							// produsen
							$dtprodusen = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$kodesupplier'"));
						
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalPengadaan'];?></td>
								<td align="center" class="nama"><?php echo substr($data['NoFaktur'],-8);?></td>
								<td align="center"><?php echo $data['SumberAnggaran'];?></td>
								<td align="center"><?php echo $data['TahunAnggaran'];?></td>
								<td align="left"><?php echo strtoupper($dtprodusen['nama_prod_obat']);?></td>
								<td align="left"><?php echo strtoupper($data['Keterangan']);?></td>
								<td align="center">
									<a href="?page=aset_pengadaan_lihat&id=<?php echo $data['IdPengadaan'];?>" class="btn btn-xs btn-info btn-white"> Lihat</a>
									<?php
										// jika masih adata data, tidak dapat dihapus
										$cekdata = mysqli_num_rows(mysqli_query($koneksi, "SELECT KodeBarang FROM `tbasetpengadaandetail` WHERE `Nofaktur`='$data[NoFaktur]'"));
										if($cekdata == ''){
									?>
									<a href="?page=aset_pengadaan_delete&id=<?php echo $data['NoFaktur'];?>" class="btn btn-xs btn-danger btn-white"> Hapus</a>
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
						echo "<li><a href='?page=aset_pengadaan&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
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
