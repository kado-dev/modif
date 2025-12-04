<?php
	$kd = $_GET['kd'];
	$batch = $_GET['batch'];
	$str = "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kd' AND `NoBatch`='$batch'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=gudang_besar_stok" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>Edit Barang </b><small>Gudang Besar</small></h3>
			<div class="formbg">
				<form class="form-horizontal" action="index.php?page=gudang_besar_stok_edit_proses" method="post" role="form">
					<table class="table-judul">
						<tr>
							<td class="col-sm-2">No.Faktur Terima</td>
							<td class="col-sm-10">
								<input type="text" name="nofakturterima" class="form-control" value="<?php echo $data['NoFakturTerima'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Kode Barang</td>
							<td class="col-sm-10">
								<div class="row">
									<div class="col-sm-6">
										<input type="text" name="kodebarang" class="form-control" value="<?php echo $data['KodeBarang'];?>" readonly>
									</div>
									<div class="col-sm-6">
										<input type="text" name="kodebarangedit" class="form-control kodeobat" value="<?php echo $data['KodeBarang'];?>" readonly>
									</div>
								</div>
								<input type="hidden" name="idbarang" class="form-control" value="<?php echo $data['IdBarang'];?>" readonly>
								
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Nama Barang</td>
							<td class="col-sm-10">
								<input type="text" name="namabarang" class="form-control nama_barang_lplpo" value="<?php echo $data['NamaBarang'];?>" placeholder="Ketikan Nama Barang">
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Batch</td>
							<td class="col-sm-10">
								<input type="hidden" name="nobatch" class="form-control nobatch" maxlength = "50" value="<?php echo $data['NoBatch'];?>" required>
								<input type="text" name="nobatchedit" class="form-control nobatch" maxlength = "50" value="<?php echo $data['NoBatch'];?>" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Isi Kemasan</td>
							<td class="col-sm-10">
								<input type="text" name="isikemasan" class="form-control" maxlength = "5" value="<?php echo $data['IsiKemasan'];?>" required>
							</td>
						</tr>				
						<tr>
							<td class="col-sm-2">Kemasan</td>
							<td class="col-sm-10">
								<select name="kemasan" class="form-control">
									<option>--Pilih--</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` ORDER BY `satuan_obat`");
										while($datakemasan = mysqli_fetch_assoc($query)){
											if($datakemasan['satuan_obat'] == $data['Kemasan']){
												echo "<option value='$datakemasan[satuan_obat]' SELECTED>$datakemasan[satuan_obat]</option>";
											}else{
												echo "<option value='$datakemasan[satuan_obat]'>$datakemasan[satuan_obat]</option>";
											}
										}
									?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td class="col-sm-2">Satuan</td>
							<td class="col-sm-10">
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
							<td class="col-sm-2">Golongan Fungsi</td>
							<td class="col-sm-10">
								<select name="golonganfungsi" class="form-control">
									<option value="0">--Pilih--</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbobatkelompok` order by `KelompokObat`");
										while($datagolongan = mysqli_fetch_assoc($query)){
											if($datagolongan['KelompokObat'] == $data['GolonganFungsi']){
												echo "<option value='$datagolongan[KelompokObat]' SELECTED>$datagolongan[KelompokObat]</option>";
											}else{
												echo "<option value='$datagolongan[KelompokObat]'>$datagolongan[KelompokObat]</option>";
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
									<option value="0">--Pilih--</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
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
							<td class="col-sm-2">Jenis Barang</td>
							<td class="col-sm-10">
								<select name="jenisbarang" class="form-control">
									<option>--Pilih--</option>
									<option value="GENERIK" <?php if($data['JenisBarang'] == 'GENERIK'){echo "SELECTED";}?>>GENERIK</option>
									<option value="GENERIK BERMERK" <?php if($data['JenisBarang'] == 'GENERIK BERMERK'){echo "SELECTED";}?>>GENERIK BERMERK</option>
									<option value="VAKSIN" <?php if($data['JenisBarang'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									<option value="LAINNYA" <?php if($data['JenisBarang'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Ruangan</td>
							<td class="col-sm-10">
								<select name="ruangan" class="form-control">
									<option>--Pilih--</option>
									<option value="GUDANG BESAR" <?php if($data['Ruangan'] == 'GUDANG BESAR'){echo "SELECTED";}?>>GUDANG BESAR</option>
									<option value="GUDANG PELAYANAN" <?php if($data['Ruangan'] == 'GUDANG PELAYANAN'){echo "SELECTED";}?>>GUDANG PELAYANAN</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Rak</td>
							<td class="col-sm-10">
								<select name="rak" class="form-control">
									<option>--Pilih--</option>
									<option value="-" <?php if($data['Rak'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="RAK 1" <?php if($data['Rak'] == 'RAK 1'){echo "SELECTED";}?>>RAK 1</option>
									<option value="RAK 2" <?php if($data['Rak'] == 'RAK 2'){echo "SELECTED";}?>>RAK 2</option>
									<option value="RAK 3" <?php if($data['Rak'] == 'RAK 3'){echo "SELECTED";}?>>RAK 3</option>
									<option value="RAK 4" <?php if($data['Rak'] == 'RAK 4'){echo "SELECTED";}?>>RAK 4</option>
									<option value="RAK 5" <?php if($data['Rak'] == 'RAK 5'){echo "SELECTED";}?>>RAK 5</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Stok</td>
							<td class="col-sm-10">
								<input type="text" name="stok" class="form-control" maxlength = "10" value="<?php echo $data['Stok'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Minimal Stok</td>
							<td class="col-sm-10">
								<input type="text" name="minimalstok" class="form-control" maxlength = "10" value="<?php echo $data['MinimalStok'];?>" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Harga Beli (Rp)</td>
							<td class="col-sm-10">
								<input type="text" name="hargabeli" class="form-control" maxlength = "10"  value="<?php echo $data['HargaBeli'];?>" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Barcode</td>
							<td class="col-sm-10">
								<input type="text" name="barcode" class="form-control" value="<?php echo $data['Barcode'];?>" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Expire</td>
							<td class="col-sm-10">
								<div class="input-group">
									<span class="input-group-addon">
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
							<td class="col-sm-2">Sumber Anggaran</td>
							<td class="col-sm-10">
								<?php 
									if($kota == "KABUPATEN BEKASI"){
								?>
								<select name="sumberanggaran" class="form-control">
									<option value="APBD OBAT PADAT" SELECTED>APBD OBAT PADAT</option>
									<option value="APBD OBAT CAIR">APBD OBAT CAIR</option>
									<option value="APBD OBAT GEL/SALEP">APBD OBAT GEL/SALEP</option>
									<option value="APBD BAHAN OBAT LAINNYA (BMHP)">APBD BAHAN OBAT LAINNYA (BMHP)</option>
									<option value="APBD BAHAN OBAT LAINNYA (COVID)">APBD BAHAN OBAT LAINNYA (COVID)</option>
									<option value="APBD PROV">APBN / APBD PROV</option>
									<option value="HIBAH">HIBAH</option>
									<option value="BTT/DINKES">BTT/DINKES</option>
								</select>
								<?php 
									}elseif($kota == "KABUPATEN BANDUNG"){
								?>
								<select name="sumberanggaran" class="form-control">
									<option>--Pilih--</option>
									<option value="APBD KAB/KOTA" <?php if($data['SumberAnggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD KAB/KOTA</option>
									<option value="APBD PROV" <?php if($data['SumberAnggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBD PROV</option>
									<option value="APBN" <?php if($data['SumberAnggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
									<option value="BLUD" <?php if($data['SumberAnggaran'] == 'BLUD'){echo "SELECTED";}?>>BLUD</option>
									<option value="DAK KAB/KOTA" <?php if($data['SumberAnggaran'] == 'DAK KAB/KOTA'){echo "SELECTED";}?>>DAK KAB/KOTA</option>
									<option value="DONASI" <?php if($data['SumberAnggaran'] == 'DONASI'){echo "SELECTED";}?>>DONASI</option>
									<option value="HIBAH" <?php if($data['SumberAnggaran'] == 'HIBAH'){echo "SELECTED";}?>>HIBAH</option>
									<option value="LAINNYA" <?php if($data['SumberAnggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
								</select>
								<?php 
									}else{
								?>
								<select name="sumberanggaran" class="form-control">
									<option value="APBD KAB/KOTA" <?php if($data['SumberAnggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD KAB/KOTA</option>
									<option value="APBD PROV" <?php if($data['SumberAnggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBD PROV</option>
									<option value="APBN" <?php if($data['SumberAnggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
									<option value="DAK KAB/KOTA" <?php if($data['SumberAnggaran'] == 'DAK KAB/KOTA'){echo "SELECTED";}?>>DAK KAB/KOTA</option>
									<option value="LAINNYA" <?php if($data['SumberAnggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
								</select>
								<?php 
									}
								?>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">Tahun Anggaran</td>
							<td class="col-sm-10">
								<select name="tahunanggaran" class="form-control">
									<?php
										for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
										?>
										<option value="<?php echo $tahun;?>" <?php if($data['TahunAnggaran'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
									<?php }?>
								</select>
							</td>
						</tr>
					</table><hr/>
					<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
</div>