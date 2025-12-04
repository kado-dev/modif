<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Master Barang <small>Gudang Obat UPTD</small></h1>
		</div>
	</div>
</div>

<?php
	$kodebarang = $_GET['id'];
	$str = "SELECT * FROM tbgudanguptdstok WHERE KodeBarang = '$kodebarang'";
	$dt_brg = mysqli_fetch_assoc(mysqli_query($koneksi,$str));
	
	$dt_brg_gfk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NamaBarang, Barcode, Kemasan, IsiKemasan, Satuan, KelasTherapy, GolonganFungsi, JenisBarang, 
	MinimalStok, HargaBeli, NoBatch, Expire, SumberAnggaran, TahunAnggaran, KodeSupplier
	FROM `tbgfkstok` WHERE `Kodebarang` = '$dt_brg[KodeBarang]'")); 
?>
<!--Kolom Entry-->
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-bars"></i> Edit Barang</h4>
			</div>
			<div class="box-body">
				<form class="form-horizontal" action="index.php?page=uptd_gudang_stok_edit_proses" method="post" role="form">
					<div class="table-responsive" style="font-size:12px">
						<table class="table table-striped table-condensed">
							<tr>
								<td class="col-sm-2">Nama Barang</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="namabarang" class="form-control namaobat_gop nbr" value="<?php echo $dt_brg_gfk['NamaBarang'];?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kode Barang</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="kodebarang" class="form-control kodebarang" value="<?php echo $dt_brg['KodeBarang'];?>" readonly>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Barcode</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="barcode" class="form-control" maxlength = "13" value="<?php echo $dt_brg_gfk['Barcode'];?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kemasan</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="kemasan" class="form-control">
										<option>--Pilih--</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `tbapotiksatuan`");
											while($datakemasan = mysqli_fetch_assoc($query)){
												if($datakemasan['Satuan'] == $dt_brg_gfk['Kemasan']){
													echo "<option value='$datakemasan[Satuan]' SELECTED>$datakemasan[Satuan]</option>";
												}else{
													echo "<option value='$datakemasan[Satuan]'>$datakemasan[Satuan]</option>";
												}
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Isi Kemasan</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="isikemasan" class="form-control isikemasan" maxlength = "3" value="<?php echo $dt_brg_gfk['IsiKemasan'];?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Satuan</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="satuan" class="form-control">
										<option>--Pilih--</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `tbapotiksatuan` order by `Satuan`");
											while($datasatuan = mysqli_fetch_assoc($query)){
												if($datasatuan['Satuan'] == $dt_brg_gfk['Satuan']){
													echo "<option value='$datasatuan[Satuan]' SELECTED>$datasatuan[Satuan]</option>";
												}else{
													echo "<option value='$datasatuan[Satuan]'>$datasatuan[Satuan]</option>";
												}
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kelas Therapy</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="kelastherapy" class="form-control">
										<option>--Pilih--</option>
										<option value="OBAT" <?php if($dt_brg_gfk['KelasTherapy'] == 'OBAT'){echo "SELECTED";}?>>OBAT</option>
										<option value="BMHP" <?php if($dt_brg_gfk['KelasTherapy'] == 'BMHP'){echo "SELECTED";}?>>BMHP</option>
										<option value="VAKSIN" <?php if($dt_brg_gfk['KelasTherapy'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
										<option value="LABORATORIUM" <?php if($dt_brg_gfk['KelasTherapy'] == 'LABORATORIUM'){echo "SELECTED";}?>>LABORATORIUM</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Golongan Fungsi</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="golonganfungsi" class="form-control golonganfungsi">
										<option value="0">--Pilih--</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `tbobatkelompok` order by `KelompokObat`");
											while($datagolongan = mysqli_fetch_assoc($query)){
												if($datagolongan['KelompokObat'] == $dt_brg_gfk['GolonganFungsi']){
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
								<td class="col-sm-2">Jenis Barang</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="jenisbarang" class="form-control">
										<option>--Pilih--</option>
										<option value="GENERIK" <?php if($dt_brg_gfk['JenisBarang'] == 'GENERIK'){echo "SELECTED";}?>>GENERIK</option>
										<option value="GENERIK BERMERK" <?php if($dt_brg_gfk['JenisBarang'] == 'GENERIK BERMERK'){echo "SELECTED";}?>>GENERIK BERMERK</option>
										<option value="VAKSIN" <?php if($dt_brg_gfk['JenisBarang'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
										<option value="LAINNYA" <?php if($dt_brg_gfk['JenisBarang'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Stok</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="number" name="stok" class="form-control" maxlength = "10" value="<?php echo $dt_brg['Stok'];?>" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Minimal Stok</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="number" name="minimalstok" class="form-control minimalstok" maxlength = "10" value="<?php echo $dt_brg_gfk['IsiKemasan'];?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Harga Beli</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="number" name="hargabeli" class="form-control hargabeli" maxlength = "10" value="<?php echo $dt_brg_gfk['HargaBeli'];?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Batch</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="nobatch" class="form-control nobatch" maxlength = "30" value="<?php echo $dt_brg_gfk['NoBatch'];?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Expire</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<span class="input-group-addon tesdate">
											<span class="fa fa-calendar"></span>
										</span>
										<?php
											$tgle = explode("-",$dt_brg_gfk['Expire']);
										?>
										<input type="text" name="expire" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>">
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Sumber Anggaran</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="sumberanggaran" class="form-control">
										<option>--Pilih--</option>
										<option value="APBD PROV" <?php if($dt_brg_gfk['SumberAnggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBD PROV</option>
										<option value="APBD KAB" <?php if($dt_brg_gfk['SumberAnggaran'] == 'APBD KAB'){echo "SELECTED";}?>>APBD KAB</option>
										<option value="APBN" <?php if($dt_brg_gfk['SumberAnggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
										<option value="BLUD" <?php if($dt_brg_gfk['SumberAnggaran'] == 'BLUD'){echo "SELECTED";}?>>BLUD</option>
										<option value="LAINNYA" <?php if($dt_brg_gfk['SumberAnggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Tahun Anggaran</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="tahunanggaran" class="form-control tahunanggaran" required>
										<option>--Pilih--</option>
										<option value="2015" <?php if($dt_brg_gfk['TahunAnggaran'] == '2015'){echo "SELECTED";}?>>2015</option>
										<option value="2016" <?php if($dt_brg_gfk['TahunAnggaran'] == '2016'){echo "SELECTED";}?>>2016</option>
										<option value="2017" <?php if($dt_brg_gfk['TahunAnggaran'] == '2017'){echo "SELECTED";}?>>2017</option>
										<option value="2018" <?php if($dt_brg_gfk['TahunAnggaran'] == '2018'){echo "SELECTED";}?>>2018</option>
										<option value="2019" <?php if($dt_brg_gfk['TahunAnggaran'] == '2019'){echo "SELECTED";}?>>2019</option>
										<option value="2020" <?php if($dt_brg_gfk['TahunAnggaran'] == '2020'){echo "SELECTED";}?>>2020</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Produsen</td>
								<td>:</td>
								<td class="col-sm-10">
									<!--<select name="kodesupplier" class="form-control supplier">
										<option value="0">--Pilih--</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM ref_pabrik order by `nama_prod_obat` ASC");
											while($datasupplier = mysqli_fetch_assoc($query)){
												if($datasupplier['id'] == $dt_brg_gfk['KodeSupplier']){
													echo "<option value='$datasupplier[id]' SELECTED>$datasupplier[nama_prod_obat]</option>";
												}else{
													echo "<option value='$datasupplier[id]'>$datasupplier[nama_prod_obat]</option>";
												}
											}
										?>
									</select>-->
									<div class="input-group">
										<?php 
											$kodesuppp = $dt_brg_gfk['KodeSupplier'];
											$datasupplier = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT nama_prod_obat FROM `ref_pabrik` WHERE `id` = '$kodesuppp'"))
										?>
										<input type="text" name="produsen" class="form-control nama_produsen" value="<?php echo $datasupplier['nama_prod_obat'];?>" required>
										<input type="hidden" name="kodeprodusen" class="form-control id">
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">
								<td></td>
								<td class="col-sm-10"><button type="submit" class="btn btn-md btn-success">Simpan</button></td>
								</td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>