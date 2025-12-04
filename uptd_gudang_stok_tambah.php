<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Master Barang <small>Gudang Obat UPTD</small></h1>
		</div>
	</div>
</div>

<!--Kolom Entry-->
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-pencil"></i> Entry Barang</h4>
			</div>
			<div class="box-body">
				<form class="form-horizontal" action="index.php?page=uptd_gudang_stok_tambah_proses" method="post" role="form">
					<div class="table-responsive" style="font-size:12px">
						<table class="table table-striped table-condensed">
							<tr>
								<td class="col-sm-2">Nama Barang</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="namabarang" class="form-control namaobat_gop nbr" placeholder="Ketikan Nama Barang" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kode Barang</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="kodebarang" class="form-control kodebarang" readonly>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Barcode</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="barcode" class="form-control" maxlength = "13" placeholder="Ketikan Barcode" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Isi Kemasan</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="isikemasan" class="form-control isikemasan" maxlength = "3" >
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kelas Therapy</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="kelastherapy" class="form-control kelastherapy">
										<option>--Pilih--</option>
										<option value="OBAT">OBAT</option>
										<option value="BMHP">BMHP</option>
										<option value="VAKSIN">VAKSIN</option>
										<option value="LABORATORIUM">LABORATORIUM</option>
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
											while($data = mysqli_fetch_assoc($query)){
												echo "<option value='$data[KelompokObat]'>$data[KelompokObat]</option>";
											}
										?>
									</select>	
								</td>		
							</tr>
							<tr>
								<td class="col-sm-2">Jenis Barang</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="jenisbarang" class="form-control jenisbarang">
										<option>--Pilih--</option>
										<option value="GENERIK">GENERIK</option>
										<option value="GENERIK BERMERK">GENERIK BERMERK</option>
										<option value="VAKSIN">VAKSIN</option>
										<option value="LAINNYA">LAINNYA</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Minimal Stok</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="number" name="minimalstok" class="form-control minimalstok" maxlength = "10">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Harga Beli</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="number" name="hargabeli" class="form-control hargabeli" maxlength = "10">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Batch</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="nobatch" class="form-control nobatch" maxlength = "30">
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
										<input type="text" name="expire" class="form-control datepicker" placeholder="Pilih Tanggal" required>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Sumber Anggaran</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="sumberanggaran" class="form-control sumberanggaran" required>
										<option value="BLUD">--Pilih--</option>
										<option value="APBD PROV">APBD PROV</option>
										<option value="APBD KAB/KOTA">APBD KAB/KOTA</option>
										<option value="APBN">APBN</option>
										<option value="BLUD">BLUD</option>
										<option value="PROGRAM">PROGRAM</option>
										<option value="LAINNYA">LAINNYA</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Tahun Anggaran</td>
								<td>:</td>
								<td class="col-sm-10">
									<select name="tahunanggaran" class="form-control tahunanggaran" required>
										<option value="">--Pilih--</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
									</select>
								</td>
							</tr>
						</table><hr>
			
						<table class="row">
							<tr>
								<td class="col-sm-2"><b>e-logistik</b></td>
							</tr>
						</table><p>
			
						<table class="table table-striped table-condensed"">
							<tr>
								<td class="col-sm-2">Nama INN</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<input type="text" name="namabaranginn" class="form-control namabaranginn" placeholder="Ketikan Nama INN" required>
										<input type="hidden" name="kodebaranginn" class="form-control kodebaranginn" required>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kekuatan</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<input type="text" name="kekuatan" class="form-control kekuatan kekuatannbr" value = "0" required>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Bentuk Sediaan</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<input type="text" name="sediaan" class="form-control sediaan sediaannbr" placeholder="Ketikan Sediaan" required>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Nama Lengkap</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<input type="text" name="namalengkap" class="form-control namalengkap hasilnbr" readonly>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Detail Kemasan</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<input type="text" name="detailkemasan" class="form-control detailkemasan" value="-" required>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kemasan Unit</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<select name="kemasan" class="form-control kemasan" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
												while($data = mysqli_fetch_assoc($query)){
													echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
												}
											?>
										</select>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Satuan Besar</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<select name="satuan" class="form-control satuan" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
												while($data = mysqli_fetch_assoc($query)){
													echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
												}
											?>
										</select>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Golongan</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<select name="golongan" class="form-control golongan" required>
											<option value="">--Pilih--</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="B">B</option>
											<option value="H">H</option>
											<option value="K">K</option>
											<option value="O">O</option>
											<option value="P">P</option>
											<option value="T">T</option>
											<option value="pem">pem</option>
											<option value="put">put</option>
										</select>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Jenis Obat</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<select name="jenisbarangelog" class="form-control jenisbarangelog" required>
											<option value="">--Pilih--</option>
											<option value="TUNGGAL">TUNGGAL</option>
											<option value="CAMPURAN">CAMPURAN</option>
										</select>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Status</td>
								<td>:</td>
								<td class="col-sm-10">
									<div class="input-group">
										<select name="statusapproveelog" class="form-control statusapproveelog" required>
											<option value="">--Pilih--</option>
											<option value="APPROVED">APPROVED</option>
											<option value="PENDING">PENDING</option>
											<option value="OFF">OFF</option>
										</select>
										<span class="input-group-addon">Elogistik</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Produsen</td>
								<td>:</td>
								<td class="col-sm-10">
									<!--<select name="kodesupplier" class="form-control supplier">
										<option value="0">--Pilih--</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `tbgfksupplier` order by `Supplier` ASC");
											while($datasupplier = mysqli_fetch_assoc($query)){
												echo "<option value='".$datasupplier['KodeSupplier']."'>".$datasupplier['Supplier']."</option>";
											}
										?>
									</select>-->
									<div class="input-group">
										<input type="text" name="produsen" class="form-control nama_produsen" placeholder="Ketikan Nama Produsen" required>
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