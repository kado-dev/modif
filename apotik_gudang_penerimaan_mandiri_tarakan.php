<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbgudangpkmpenerimaan = "tbgudangpkmpenerimaan_".str_replace(' ', '', $namapuskesmas);
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">PENERIMAAN BARANG</h3>
			<div class="formbg">	
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="apotik_gudang_penerimaan_mandiri_tarakan"/>
						<div class="col-sm-8">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nomor Faktur, minimal 4 digit" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=apotik_gudang_penerimaan_mandiri" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-refresh"></span></a>
							<?php 
							if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
								if($kota == "KOTA TARAKAN"){
							?>
								<a href="?page=apotik_gudang_penerimaan_mandiri_tambah_tarakan" class="btn btn-sm btn-success">Entry Baru</a>
							<?php }else{ ?>			
								<a href="?page=apotik_gudang_penerimaan_mandiri_tambah" class="btn btn-sm btn-success">Entry Baru</a>
							<?php 
								} 
							}
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">	
		<div class="col-lg-12">
			
			<div class="table-responsive" style="font-size:12px">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="12%">TGL.PENERIMAAN</th>
							<th width="30%">NO.FAKTUR</th>
							<th width="45%">KETERANGAN</th>
							<th width="10%">#</th>
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
						
						if(isset($key)){
							$strcari = " AND `NoFaktur` Like '%$key%'";
						}else{
							$strcari = " ";
						}
						
						$tahun = date('Y');
						$str = "SELECT * FROM `$tbgudangpkmpenerimaan` WHERE YEAR(`TanggalPenerimaan`)='$tahun'".$strcari;	
						$str2 = $str." ORDER BY `IdGudangPenerimaan` DESC limit $mulai,$jumlah_perpage";
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
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalPenerimaan'];?></td>
								<td align="center" class="nama"><?php echo $data['NoFaktur'];?></td>
								<td align="left"><?php echo $data['Keterangan'];?></td>
								<td align="center">
									<a href="?page=apotik_gudang_penerimaan_mandiri_lihat_tarakan&id=<?php echo $data['NoFaktur'];?>&tgl=<?php echo $data['TanggalPenerimaan'];?>" class="btn btn-xs btn-info">Lihat</a>
									<a onClick="return confirm('Data ingin didelete...?')" href="?page=apotik_gudang_penerimaan_mandiri_tarakan_hapus&id=<?php echo $data['IdGudangPenerimaan'];?>" class="btn btn-xs btn-danger">Hapus</a>
								</td>							
							</tr>
						<?php
						}
						?>
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
						echo "<li><a href='?page=apotik_gudang_penerimaan_mandiri&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul> 
</div>	
