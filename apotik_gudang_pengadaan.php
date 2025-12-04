<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-xl table-responsive">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>	
			<?php if($kota == "KABUPATEN BOGOR"){ ?>
				<h3 class="judul">PENERIMAAN NON DINAS</h3>
			<?php }else{ ?>
				<h3 class="judul">PENGADAAN BARANG</h3>
			<?php } ?>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="apotik_gudang_pengadaan"/>
						<div class="col-xl-8">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nomor Faktur, minimal 4 digit" required>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=apotik_gudang_pengadaan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
							<a href="?page=apotik_gudang_pengadaan_tambah" class="btn btn-round btn-success">Buat Faktur</a>
							<?php }?>
						</div>
					</div>
				</form>
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
							<th width="10%">TGL.PENGADAAN</th>
							<th width="10%">NO.FAKTUR</th>
							<th width="10%">SUMBER ANGGARAN</th>
							<th width="7%">TAHUN</th>
							<th width="25%">SUPPLLIER</th>
							<th width="20%">KETERANGAN</th>
							<th width="15%">#</th>
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
						// echo $str2;
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
								<td align="left"><?php echo $dtprodusen['nama_prod_obat'];?></td>
								<td align="left"><?php echo strtoupper($data['Keterangan']);?></td>
								<td align="center">
									<a href="?page=apotik_gudang_pengadaan_lihat&id=<?php echo $data['NoFaktur'];?>" class="btn btn-round btn-sm btn-info"> Lihat</a>
									<?php
										// jika masih adata data, tidak dapat dihapus
										$cekdata = mysqli_num_rows(mysqli_query($koneksi, "SELECT KodeBarang FROM `tbgudangpkmpengadaandetail` WHERE `Nofaktur`='$data[NoFaktur]'"));
										if($cekdata == ''){
									?>
									<a href="?page=apotik_gudang_pengadaan_delete&id=<?php echo $data['NoFaktur'];?>" class="btn btn-round btn-sm btn-danger"> Hapus</a>
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
						echo "<li><a href='?page=apotik_gudang_pengadaan&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
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
