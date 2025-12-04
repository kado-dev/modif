<div class="tableborderdiv">	
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_besar_stok" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>TAMBAH BARANG </b><small>Gudang Vaksin</small></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<?php
						if($_GET['stsvalidasi'] != ''){
							echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
						}
					?>
					<form class="form-horizontal" action="index.php?page=gudang_vaksin_stok_tambah_proses" method="post" role="form">
						<div class="table-responsive" style="font-size:12px">
							<table class="table table-striped table-condensed">
								<tr>
									<td class="col-sm-2">Nama Barang (LPLPO)</td>
									<td class="col-sm-10">
										<input type="text" name="namabarang" class="form-control nama_barang_lplpo" placeholder="Ketikan Nama Barang" required>
										<input type="text" name="kodebarang" class="form-control kodeobat" style="margin-top:10px" readonly>
									</td>
								</tr>
								<tr>
									<td>Isi Kemasan</td>
									<td>
										<input type="text" name="isikemasan" class="form-control" maxlength = "5" value="0" required>
									</td>
								</tr>
								<tr>
									<td>Kemasan</td>
									<td>
										<select name="kemasan" class="form-control kemasan">
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
												while($data = mysqli_fetch_assoc($query)){
													echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Satuan</td>
									<td>
										<select name="satuan" class="form-control satuan" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
												while($data = mysqli_fetch_assoc($query)){
													echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Kelas Therapy</td>
									<td>
										<select name="kelastherapy" class="form-control kelastherapy" required>
											<option value="">--Pilih--</option>
											<option value="BMHP">BMHP</option>
											<option value="VAKSIN">VAKSIN</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Nama Program</td>
									<td>
										<select name="namaprogram" class="form-control golonganfungsi" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` ORDER BY nama_program");
											while($data = mysqli_fetch_assoc($query)){
												if($dtstok['nama_program'] == $data['nama_program']){
													echo "<option value='$data[nama_program]' SELECTED>$data[nama_program]</option>";
												}else{
													echo "<option value='$data[nama_program]'>$data[nama_program]</option>";
												}
											}
											?>
										</select>	
									</td>		
								</tr>
								<tr>
									<td>Minimal Stok</td>
									<td>
										<input type="text" name="minimalstok" class="form-control minimalstok" maxlength = "10" value="100" required>
									</td>
								</tr>
								<tr>
									<td>Harga Beli (Rp)</td>
									<td>
										<input type="text" name="hargabeli" class="form-control hargabeli" maxlength = "10" value="0" required>
									</td>
								</tr>
								<tr>
									<td>Barcode</td>
									<td>
										<input type="text" name="barcode" class="form-control" maxlength = "13"value="0"  placeholder="Ketikan Barcode" required>
									</td>
								</tr>
								<tr>
									<td>Batch</td>
									<td>
										<input type="text" name="nobatch" class="form-control nobatch" maxlength = "30" value="0" value="0" required>
									</td>
								</tr>
								<tr>
									<td>Expire</td>
									<td>
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" name="expire" class="form-control datepicker" placeholder="Pilih Tanggal" required>
										</div>
									</td>
								</tr>
								<tr>
									<td>Sumber Anggaran</td>
									<td>
										<select name="sumberanggaran" class="form-control sumberanggaran" required>
											<option value="-">--Pilih--</option>
											<option value="APBD KAB/KOTA" SELECTED>APBD KAB/KOTA</option>
											<option value="APBD PROV">APBD PROV</option>
											<option value="APBN">APBN</option>
											<option value="BLUD">BLUD</option>
											<option value="DAK KAB/KOTA">DAK KAB/KOTA</option>
											<option value="LAINNYA">LAINNYA</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Tahun Anggaran</td>
									<td>
										<select name="tahunanggaran" class="form-control tahunanggaran" required>
											<option value="">--Pilih--</option>
											<option value="2014">2014</option>
											<option value="2015">2015</option>
											<option value="2016">2016</option>
											<option value="2017">2017</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020" SELECTED>2020</option>
										</select>
									</td>
								</tr>	
							</table><hr>
							<button type="submit" class="btnsimpan">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>