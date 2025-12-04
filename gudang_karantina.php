<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>KARANTINA BARANG</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="gudang_karantina"/>
						<div class="col-sm-2">
							<select name="kategori" class="form-control" required>
								<option value="">--Pilih--</option>
								<option value="NoFaktur" <?php if($_GET['kategori'] == 'NoFaktur'){echo "SELECTED";}?>>No.Faktur</option>
								<option value="Penerima" <?php if($_GET['kategori'] == 'Penerima'){echo "SELECTED";}?>>Penerima</option>
							</select>
						</div>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=gudang_karantina" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="?page=gudang_karantina_tambah" class="btn btn-sm btn-success"><span class="fa fa-plus"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="7%">TGL.KARANTINA</th>
							<th width="10%">NO.FAKTUR</th>
							<th width="10%">GUDANG</th>
							<th width="15%">STATUS KARANTINA</th>
							<th width="10%">TOTAL RUPIAH</th>
							<th width="10%">#</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$jumlah_perpage = 100;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$kategori = $_GET['kategori'];		
					$key = $_GET['key'];	
					
					if($kategori !='' && $key !=''){
						$strcari = " where ".$kategori." Like '%$key%'";
					}else{
						$strcari = " ";
					}
					
					$str = "SELECT * FROM `tbgfk_karantina`".$strcari;
					$str2 = $str." ORDER BY `NoFaktur` Desc limit $mulai,$jumlah_perpage";
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
							<td align="right"><?php echo $no;?></td>
							<td align="center"><?php echo $data['TanggalKarantina'];?></td>
							<td align="center"><?php echo $data['NoFaktur'];?></td>
							<td align="left"><?php echo strtoupper($data['StatusGudang']);?></td>
							<td align="left"><?php echo strtoupper($data['StatusKarantina']);?></td>
							<td align="right">
								<?php 
									$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
									FROM `tbgfk_karantinadetail` a 
									JOIN `tbgfk_karantina` b ON a.NoFaktur = b.NoFaktur
									WHERE a.NoFaktur LIKE '%$data[NoFaktur]%'";
									$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
									echo rupiah($dtgt['Jumlah']);
								?>
							</td>
							<td align="center">
								<a href="?page=gudang_karantina_lihat&id=<?php echo $data['NoFaktur'];?>" class="btn btn-sm btn-info">LIHAT</a>
								<?php
									$cekbrg = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdKarantinaDetail` FROM `tbgfk_karantinadetail` WHERE `NoFaktur`='$data[NoFaktur]'"));
									if ($cekbrg == 0){
								?>
								<a href="?page=gudang_karantina_hapus&nf=<?php echo $data['NoFaktur'];?>" class="btn btn-sm btn-danger btnhapus">HAPUS</a>
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
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=gudang_karantina&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatikan :</b><br>
				Menu hapus tampil jika tidak ada data barang pada faktur tersebut</p>
			</div>
		</div>
	</div>
</div>	
