<?php
	include "config/helper_report.php";
	$id = $_GET['id'];
	$dtkarantina=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_karantina` WHERE `NoFaktur`='$id'"));
?>
<style>
.imglogo{
	width: 55px;
	height: 65px;
	margin-left: 40px;
	margin-bottom: -70px;
	display: none;
}
.table-responsive{
	overflow-x: hidden;
}	
	
@media print{
	.imglogo{
		display:block;
	}
}
</style>

<div class="tableborderdiv noprint">	
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_karantina" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA KARANTINA </b></h3>
			<div class="table-responsive">
				<?php
					$datapenerimaan=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan`='$id'"));
				?>
				<table class="table-judul">
					<thead>
						<tr>
							<th width="20%">TGL.KARANTINA</th>
							<th width="30%">NO.FAKTUR</th>
							<th width="30%">GUDANG</th>
							<th width="20%">OPSI</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center"><?php echo $dtkarantina['TanggalKarantina'];?></td>
							<td align="center"><?php echo $dtkarantina['NoFaktur'];?></td>
							<td align="center"><?php echo strtoupper($dtkarantina['StatusGudang']);?></td>
							<td align="center">
								<a href="gudang_karantina_print.php?id=<?php echo $_GET['id'];?>&periode=<?php echo $dtkarantina['TanggalKarantina'];?>" class="btnsimpan">PRINT</span></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
		// cek obat ED
		$hariiini = date('Y-m-d');
		$str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' AND `Expire` < '$hariiini' AND `NamaProgram` != 'VAKSIN' AND `SumberAnggaran` != 'BLUD' ORDER BY NamaBarang ASC";
		$cekitem = mysqli_num_rows(mysqli_query($koneksi, $str));
		if($cekitem > 0){
	?>
	<br/>
	<div class="formbg" style="padding: 0px 20px 0px 20px;">
		<div class="table-responsive"><br/>
			<form action="?page=gudang_karantina_lihat_proses_semua" method="post">
				<input type="hidden" name="nofaktur" class="form-control" value="<?php echo $id;?>">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th>NO.</th>
							<th>NAMA BARANG</th>
							<th>NO.BATCH</th>
							<th>NAMA PROGRAM</th>
							<th>JUMLAH</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 0;
							$query = mysqli_query($koneksi,$str);
							while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
						?>
						<tr>
							<td width="3%" align="center"><?php echo $no;?></td>
							<td width="22%" align="left"><?php echo strtoupper($data['NamaBarang']);?></td>
							<td width="22%" align="left"><?php echo strtoupper($data['NoBatch']);?></td>
							<td align="center"><?php echo strtoupper($data['NamaProgram']);?></td>
							<td align="right"><?php echo rupiah($data['Stok']);?></td>
						</tr>
						<?php
							}
						?>	
					</tbody>
				</table><hr/>
				<button type="submit" class="btnsimpan">SIMPAN</button><br/>
			</form>
		</div>
	</div>
	<?php
		}
	?>
</div>

<div class="tableborderdiv noprint">
	<?php
		if($dtkarantina['StatusKarantina'] != 'Expire'){
	?>
	<div class="row">
		<div class="col-xs-12">
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<div class="table-responsive">
						<form action="?page=gudang_karantina_lihat_proses" method="post">	
							<table class="table-judul">
								<tr>
									<td class="col-sm-2">Nama Barang</td>
									<td class="col-sm-10">
										<div class="row">
											<div class="col-sm-10">
												<?php 
													if($dtkarantina['StatusGudang']=='Gudang Besar'){
												?>
													<input type="text" name="namabarang" class="form-control nama_barang_gudang_besar" placeholder="Ketikan Nama Barang" required>
												<?php 
													}elseif($dtkarantina['StatusGudang']=='Gudang Vaksin'){
												?>
													<input type="text" name="namabarang" class="form-control nama_barang_gudang_vaksin" placeholder="Ketikan Nama Barang" required>
												<?php 
													}
												?>
											</div>
											<div class="col-sm-2">
												<input type="text" name="kodebarang" class="form-control kodebarang" maxlength = "20" readonly>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Satuan</td>
									<td>
										<input type="text" name="satuan" class="form-control satuan" maxlength = "20" readonly>
									</td>
								</tr>
								<tr>
									<td>Harga Beli</td>
									<td>
										<input type="text" name="hargabeli" class="form-control hargabeli" maxlength="10" readonly>
									</td>
								</tr>
								<tr>
									<td>Batch</td>
									<td>
										<input type="text" name="nobatch" class="form-control nobatch" maxlength="30" readonly>
									</td>
								</tr>
								<tr>
									<td>Expire</td>
									<td>
										<input type="text" name="expire" class="form-control expire" maxlength="10" readonly>
									</td>
								</tr>
								<tr>
									<td>Stok</td>
									<td>
										<input type="text" name="stok" class="form-control stok" maxlength="10" readonly>
									</td>
								</tr>
								<tr>
									<td>Jumlah Karantina</td>
									<td>
										<input type="number" name="jumlahkarantina" class="form-control jumlah" maxlength="10" required>
									</td>
								</tr>
							</table><hr/>
							<input type="hidden" name="nofaktur" class="form-control" value="<?php echo $dtkarantina['NoFaktur']?>" readonly>
							<input type="hidden" name="statusgudang" class="form-control" value="<?php echo $dtkarantina['StatusGudang']?>" readonly>
							<input type="hidden" class="lokasikota" value="<?php echo $kota;?>">
							<button type="submit" class="btnsimpan">SIMPAN</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		}
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="3%">NO.</th>
							<th width="22%">NAMA BARANG</th>
							<th width="10%">BATCH</th>
							<th width="15%">SUMBER</th>
							<th width="10%">EXPIRE</th>
							<th width="5%">HARGA</th>
							<th width="10%">JML</th>
							<th width="10%">TOTAL</th>
							<th width="5%">AKSI</th>
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
							
							$str = "SELECT * FROM `tbgfk_karantinadetail`WHERE NoFaktur='$id'";
							$str2 = $str." ORDER BY `IdKarantinaDetail` DESC LIMIT $mulai,$jumlah_perpage";
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
								$kdbrg = $data['KodeBarang'];
								$nobatch = $data['NoBatch'];
								
								if($dtkarantina['StatusGudang'] == "Gudang Besar"){
									$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang`,`Satuan`,`SumberAnggaran`,`TahunAnggaran`,`HargaBeli`,`Expire` FROM `tbgfkstok` WHERE `KodeBarang` = '$kdbrg' AND `NoBatch`='$nobatch'"));
								}elseif($dtkarantina['StatusGudang'] == "Gudang Vaksin"){
									$dtbrg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang`,`Satuan`,`SumberAnggaran`,`TahunAnggaran`,`HargaBeli`,`Expire` FROM `tbgfk_vaksin_stok`WHERE KodeBarang='$kdbrg' AND `NoBatch`='$nobatch'"));
								}
								
								// total
								$total = $dtbrg['HargaBeli'] * $data['Jumlah'];
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="left" class="nama"><?php echo strtoupper($dtbrg['NamaBarang']);?></td>
									<td align="center"><?php echo strtoupper($data['NoBatch']);?></td>
								<td align="center"><?php echo $dtbrg['SumberAnggaran']." - ".$dtbrg['TahunAnggaran'];?></td>
								<td align="center"><?php echo $dtbrg['Expire'];?></td>
								<td align="right"><?php echo rupiah($dtbrg['HargaBeli']);?></td>
								<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($data['Jumlah']);?></td>
								<td align="right" style="color:red;font-weight:bold"><?php echo rupiah($total);?></td>
								<td align="center">
									<a href="?page=gudang_karantina_lihat_hapus&id=<?php echo $data['IdKarantinaDetail'];?>&idbrg=<?php echo $data['IdBarang'];?>&nf=<?php echo $data['NoFaktur'];?>&stok=<?php echo $data['Jumlah'];?>" class="btn btn-xs btn-danger">HAPUS</a>
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

	<ul class="pagination noprint">
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
						echo "<li><a href='?page=gudang_karantina_lihat&id=$id&h=$i'>$i</a></li>";
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
				Saat hapus, maka jumlah akan dikembalikan ke stok gudang besar</p>
			</div>
		</div>
	</div>
</div>	