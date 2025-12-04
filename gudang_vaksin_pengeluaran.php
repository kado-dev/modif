<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PENGELUARAN </b><small>Gudang Vaksin</small></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="gudang_vaksin_pengeluaran"/>
						<div class="col-xl-2">
							<select name="kategori" class="form-control kategori_bulan" required>
								<option value="">--Pilih--</option>
								<option value="NoFaktur" <?php if($_GET['kategori'] == 'NoFaktur'){echo "SELECTED";}?>>No.Faktur</option>
								<option value="Penerima" <?php if($_GET['kategori'] == 'Penerima'){echo "SELECTED";}?>>Penerima</option>
								<option value="TanggalPengeluaran" <?php if($_GET['kategori'] == 'TanggalPengeluaran'){echo "SELECTED";}?>>Bulan</option>
							</select>
						</div>
						<div class="col-xl-6 isi_bulan">
							<?php
							if($_GET['kategori'] == 'TanggalPengeluaran'){
								echo "<select class='form-control' name='key'><option value='01'>Januari</option><option value='02'>Februari</option><option value='03'>Maret</option><option value='04'>April</option><option value='05'>Mei</option><option value='06'>Juni</option></select>";
							}else{
							?>
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
							<?php
							}
							?>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=gudang_vaksin_pengeluaran" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="?page=gudang_vaksin_pengeluaran_tambah" class="btn btn-round btn-success">Faktur Baru</a>
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
		$kategori = $_GET['kategori'];		
		$key = $_GET['key'];	
		$tahun = date('Y');	
		
		if($kategori !='' && $key !=''){
			if($kategori == 'TanggalPengeluaran'){
				$key2 = date('Y')."-".$key;
			}else{
				$key2 = $key;
			}
			$strcari = " WHERE ".$kategori." Like '%$key2%'";
		}else{
			$strcari = " WHERE YEAR(TanggalPengeluaran)='$tahun'";
		}
		
		$str = "select * from `tbgfk_vaksin_pengeluaran`".$strcari;
		$str2 = $str." ORDER BY `IdDistribusi` DESC limit $mulai,$jumlah_perpage";
		
		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		// sort by
		if($_GET['sort'] == 'ASC'){
			$sorts = 'DESC';
		}else{
			$sorts = 'ASC';
		}
	?>		
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="5%">NO</th>
							<th width="10%"><a href="?page=gudang_vaksin_pengeluaran&orderby=TanggalPengeluaran&sort=<?php echo $sorts;?>">TGL DISTRIBUSI <?php echo iconsort("TanggalPengeluaran",$sorts);?></th>
							<th width="15%"><a href="?page=gudang_vaksin_pengeluaran&orderby=NoFaktur&sort=<?php echo $sorts;?>">NOMOR FAKTUR <?php echo iconsort("NoFaktur",$sorts);?></th>
							<th width="10%">STS PENGELUARAN</th>
							<th width="20%"><a href="?page=gudang_vaksin_pengeluaran&orderby=Penerima&sort=<?php echo $sorts;?>">UNIT PENERIMA <?php echo iconsort("Penerima",$sorts);?></th>
							<th width="10%">YANG MENERIMA</th>
							<th width="10%">GRAND TOTAL</th>
							<th width="5%">FOTO</th>
							<th width="15%">AKSI</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if($_GET['orderby'] == '' or $_GET['sort'] == ''){
						$orderbys = "ORDER BY `IdDistribusi` DESC";
					}else{
						$orderbys = "ORDER BY ".$_GET['orderby']." ".$_GET['sort'];
					}
					
					$str2 = $str." ".$orderbys." LIMIT $mulai,$jumlah_perpage";
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['TanggalPengeluaran'];?></td>
							<td align="center" class="nama"><?php echo $data['NoFaktur'];?></td>
							<td align="left"><?php echo $data['StatusPengeluaran'];?></td>
							<td align="left"><?php echo $data['Penerima'];?></td>
							<td align="left"><?php echo strtoupper($data['PetugasPenerima']);?></td>
							<td align="right">
								<b>
									<?php 
										$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
										FROM tbgfk_vaksin_pengeluarandetail a JOIN tbgfk_vaksin_pengeluaran b ON a.NoFaktur = b.NoFaktur
										WHERE a.NoFaktur LIKE '%$data[NoFaktur]%'";
										// echo $strgt;
										$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
										echo rupiah($dtgt['Jumlah']);
									?>
								</b>								
							</td>
							<td align="center">
								<?php
									$cekgambar = file_exists ( 'image/dokumen_pengeluaran_vaksin/'.$data['ImageDok'] );
									if($cekgambar == true){
								?>
								<span class="btnimgmodal" id="<?php echo $data['ImageDok'];?>" data-id="<?php echo $data['IdDistribusi'];?>" style="cursor: pointer;"><i class="fas fa-image"></i></span>
								<?php
									}else{
								?>
									<span class="btnuploadlist" id="<?php echo $data['IdDistribusi'];?>" style="cursor: pointer;"><i class="fas fa-image"></i></span>
								<?php		
									}
								?>
							</td>
							<td align="center">
								<a href="?page=gudang_vaksin_pengeluaran_edit&nf=<?php echo $data['NoFaktur'];?>" class="btn btn-sm btn-round btn-success">Edit</a>
								<a href="?page=gudang_vaksin_pengeluaran_lihat&id=<?php echo $data['IdDistribusi'];?>&nf=<?php echo $data['NoFaktur'];?>&penerima=<?php echo $data['Penerima'];?>" class="btn btn-sm btn-round btn-info">Lihat</a>
								<?php 
									// cek apakah ada item barang di dalam faktur, jika masih ada data tidak dapat dihapus
									$str_cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbgfk_vaksin_pengeluarandetail` WHERE `NoFaktur` = '$data[NoFaktur]'"));
									if ($str_cek['KodeBarang'] == ''){ 
								?>
								<a href="?page=gudang_vaksin_pengeluaran_hapus&id=<?php echo $data['IdDistribusi'];?>&nf=<?php echo $data['NoFaktur'];?>" class="btnhapus btn btn-sm btn-round btn-dange">Hapus</a>
								<?php } ?>
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
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=gudang_vaksin_pengeluaran&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p><b>Keterangan : </b> <br/>
				- Menu hapus tampil jika status pengeluarannya ke Puskesmas<br/>
				- Puskesmas belum memvalidasi satatus penerimaan barang</p>	
			</div>
		</div>
	</div>
</div>
<?php
function iconsort($nmkolom,$sorttype){
	$sorticon = "<i class='fa fa-sort'></i>";
	$downs = "<i class='fa fa-sort-down'></i>";
	$ups = "<i class='fa fa-sort-up'></i>";
	if(isset($_GET["sort"])){
		if($nmkolom == $_GET['orderby']){
			if($sorttype == 'ASC'){
				$h = $downs;
			}else{
				$h = $ups;
			}
		}else{
			$h = $sorticon;
		}
	}else{
		$h = $sorticon;
	}
	return $h;
}
?>
<script src="assets/js/jquery.js"></script>	
<script>	
	$(".btnimgmodal").click(function(){
		var namagambar = $(this).attr('id');
		var idpener = $(this).data('id');
		var srcs = 'image/dokumen_pengeluaran_vaksin/'+namagambar;
		$(".imgmodals").attr('src',srcs);
		$(".btnuploadlist").attr('id',idpener);
		$(".btnuploadlist").attr('data-namelama',namagambar);
		$("#exampleModal").modal('show');

		$(".btnuploadlist").click(function(){
			$("#exampleModal").modal('hide');
			var id = $(this).attr('id');
			var namelama = $(this).data('namelama');
			$("#id").val(id);
			$("#namelama").val(namelama);
			$("#ModalUps").modal('show');
		});
	});

	$(".btnuploadlist").click(function(){
		$("#exampleModal").modal('hide');
		var id = $(this).attr('id');
		$("#id").val(id);
		$("#ModalUps").modal('show');
	});
</script>

<!-- Modal View-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<h4 class="modal-title" id="exampleModalLabel">Foto</h4>
      </div>
      <div class="modal-body">
		<p style="text-align:center">
			<img src="" class="img-fluid imgmodals" width="550px">
		</p><hr/>
		<button type="button" class="btnuploadlist btnsimpan">Edit</button>
      </div>
    </div>
  </div>
</div>
 
<!-- Modal Upload-->
<div class="modal fade" id="ModalUps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      	<div class="modal-header">
		 	<h4 class="modal-title" id="exampleModalLabel">Upload Foto</h4>
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
      <div class="modal-body">
      	<form action="gudang_vaksin_pengeluaran_upload.php" method="post" enctype="multipart/form-data">
      		<input type="hidden" name="id" id="id">
      		<input type="hidden" name="namalama" id="namelama">
      		<input type="file" name="foto" class="form-control">
      		<input type="submit" value="Upload" class="btnsimpan" style="margin-top: 10px">
      	</form>		
      </div>
    </div>
  </div>
</div>
