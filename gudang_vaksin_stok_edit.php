<?php
	//tbgfk_vaksin_stok
	$kd = $_GET['kd'];
	$batch = $_GET['batch'];
	$str = "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kd' AND `NoBatch`='$batch'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_vaksin_stok" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>EDIT BARANG </b><small>Gudang Vaksin</small></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<form class="form-horizontal" action="index.php?page=gudang_vaksin_stok_edit_proses" method="post" role="form">
						<div class="table-responsive" style="overflow-x: hidden;">
							<table class="table-judul">
								<tr>
									<td class="col-sm-2">Nama Barang</td>
									<td class="col-sm-10">
										<div class="row">
											<div class="col-sm-12">
												<input type="text" name="namabarang" class="form-control" value="<?php echo $data['NamaBarang'];?>" readonly>
											</div>
										</div>	
									</td>
								</tr>
								<tr>
									<td>Kode Barang - Barcode</td>
									<td>
										<div class="row">
											<div class="col-sm-6">
												<input type="text" name="kodebarang" class="form-control" value="<?php echo $data['KodeBarang'];?>" readonly>
											</div>
											<div class="col-sm-6">
												<input type="text" name="barcode" class="form-control" value="<?php echo $data['Barcode'];?>" readonly>
											</div>
										</div>	
									</td>
								</tr>
								<tr>
									<td>Batch</td>
									<td>
										<input type="text" name="nobatchedit" class="form-control" maxlength = "30" value="<?php echo $data['NoBatch'];?>">
										<input type="hidden" name="nobatch" class="form-control" maxlength = "30" value="<?php echo $data['NoBatch'];?>" readonly>
									</td>
								</tr>
								<tr>
									<td>Satuan</td>
									<td>
										<select name="satuan" class="form-control">
											<option>--Pilih--</option>
											<?php
											$query_sat = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` ORDER BY `satuan_obat`");
												while($dtsatuan = mysqli_fetch_assoc($query_sat)){
													if($dtsatuan['satuan_obat'] == $data['Satuan']){
														echo "<option value='$dtsatuan[satuan_obat]' SELECTED>$dtsatuan[satuan_obat]</option>";
													}else{
														echo "<option value='$dtsatuan[satuan_obat]'>$dtsatuan[satuan_obat]</option>";
													}
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
								<td class="col-sm-2">Nama Program</td>
									<td class="col-sm-10">
										<select name="namaprogram" class="form-control">
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` WHERE `keterangan`='VAKSIN' ORDER BY `nama_program`");
												while($dataprogram = mysqli_fetch_assoc($query)){
													if($dataprogram['nama_program'] == $data['NamaProgram']){
														echo "<option value='$dataprogram[nama_program]' SELECTED>$dataprogram[nama_program]</option>";
													}else{
														echo "<option value='$dataprogram[nama_program]'>$dataprogram[nama_program]</option>";
													}
												}
											?>
										</select>	
									</td>		
								</tr>
								<tr>
									<td>Expire</td>
									<td>
										<input type="text" name="expire" class="form-control datepicker" value="<?php echo date('d-m-Y',strtotime($data['Expire']));?>">
									</td>
								</tr>
								<tr>
									<td>Harga Satuan</td>
									<td>
										<input type="text" name="hargabeli" class="form-control" maxlength = "30" value="<?php echo $data['HargaBeli'];?>" required>
									</td>
								</tr>
								<tr>
									<td>Stok</td>
									<td>
										<input type="text" name="stok" class="form-control" maxlength = "10" value="<?php echo $data['Stok'];?>" readonly>
									</td>
								</tr>
							</table><hr>
						</div>
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</form>	
				</div>
			</div>	
		</div>	
	</div>
</div>
