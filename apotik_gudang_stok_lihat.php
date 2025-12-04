<?php
	$id = $_GET['id'];
	$key = $_GET['key'];
	$str = "SELECT * FROM `$tbgudangpkmstok` WHERE `IdBarangGdgPkm` = '$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
?>

<div class="tableborderdiv">
	<a href="index.php?page=apotik_gudang_stok&key=<?php echo $key;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
	<h3 class="judul"><b>EDIT DATA BARANG <small>Gudang Obat Puskesmas</small></b></h3>
	<div class="formbg">
		<div class="row">
			<div class="col-lg-12">
				<form class="form-horizontal" action="index.php?page=apotik_gudang_stok_lihat_proses" method="post" role="form">
					<div class="table-responsive">	
						<table class="table-judul">
							<tr>
								<td class="col-sm-2">Nama / Kode Barang</td>
								<td class="col-sm-10" style="overflow-x:hidden">
									<div class="row">
										<div class="col-sm-10">
											<input type="text" name="namabarang" class="form-control" value="<?php echo strtoupper($data['NamaBarang']);?>" readonly>
										</div>
										<div class="col-sm-2">
											<input type="text" name="kodebarang" class="form-control" value="<?php echo $data['KodeBarang'];?>" readonly>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Satuan</td>
								<td>
									<input type="text" name="satuan" class="form-control nobatch" maxlength = "30" value="<?php echo strtoupper($data['Satuan']);?>" readonly>
								</td>
							</tr>
							<tr>
								<td>Batch*</td>
								<td>
									<input type="text" name="nobatch" class="form-control nobatch" maxlength = "30" value="<?php echo $data['NoBatch'];?>">
								</td>
							</tr>
							<tr>
								<td>Harga Beli*</td>
								<td>
									<input type="text" name="hargabeli" class="form-control" maxlength = "10"  value="<?php echo $data['HargaSatuan'];?>" required>
								</td>
							</tr>
							<tr>
								<td>Expire*</td>
								<td>
									<div class="input-group">
										<span class="input-group-addon"><!--panggil class diindex.php-->
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<?php
											$tgle = explode("-",$data['Expire']);
										?>
										<input type="text" name="expire" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>"><!--value="<?php echo date ('Y-m-d');?>"-->
									</div>
								</td>
							</tr>
							<tr>
								<td>Sumber Anggaran*</td>
								<td>
									<select name="sumberanggaran" class="form-control">
										<option value="APBD PROV" <?php if($data['SumberAnggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBD PROV</option>
										<option value="APBD KAB/KOTA" <?php if($data['SumberAnggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD KAB/KOTA</option>
										<option value="JKN" <?php if($data['SumberAnggaran'] == 'BLUD'){echo "SELECTED";}?>>JKN</option>
										<option value="LAINNYA" <?php if($data['SumberAnggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Tahun Anggaran*</td>
								<td>
									<input type="text" name="tahunanggaran" class="form-control" maxlength = "5" value="<?php echo $data['TahunAnggaran'];?>" required>
								</td>
							</tr>
						</table><hr/>
						<input type="hidden" name="idbarang" class="form-control" value="<?php echo $data['IdBarangGdgPkm'];?>" readonly>	
						<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
					</div>
				</form>
			</div>	
			<div class="row noprint">
				<div class="col-sm-12">
					<div class="alert alert-block alert-success fade in">
						<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
						<p>
							<b>Perhatikan :</b><br/>
							Silahkan edit data barang yang ada tanda (*)
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>