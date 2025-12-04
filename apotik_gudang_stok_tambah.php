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

<div class="row">	
	<div class="col-lg-12">
		<div class="tableborderdiv">
			<h3 class="judul"><b>MASTER BARANG <small>Gudang Obat Puskesmas</small></b></h3>
			<div class = "formbg row" style="padding: 30px 30px 30px 30px;">
				<div class="tableborder">
					<form class="form-horizontal" action="index.php?page=apotik_gudang_stok_tambah_proses" method="post" role="form">
						<div class="table-responsive" style="font-size:13px">
							<table class="table table-striped table-condensed">
								<tr>
									<td class="col-sm-2">Nama Barang (LPLPO)</td>
									<td>
										<div class="row">
											<div class="col-sm-8">
												<input type="text" name="namabarang" class="form-control nama_barang_lplpo" placeholder="Ketikan Nama Barang" required>
											</div>
											<div class="col-sm-2">
												<input type="text" name="kodebarang" class="form-control kodeobat" readonly>
											</div>
											<div class="col-sm-2">
												<input type="text" name="satuan" class="form-control satuanobat" readonly>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Sumber & Tahun Anggaran</td>
									<td>
										<div class="row">
												<div class="col-sm-10">
												<select name="sumberanggaran" class="form-control" required>
													<option value="">--Pilih--</option>
													<option value="BLUD">BLUD</option>
													<option value="APBD KAB/KOTA">PKD</option>
													<option value="PROGRAM">PROGRAM</option>
													<option value="LAINNYA">LAINNYA</option>
												</select>	
											</div>
												<div class="col-sm-2">
												<select name="tahunanggaran" class="form-control">
													<option value="-">--Pilih--</option>
													<option value="2017">2017</option>
													<option value="2018">2018</option>
													<option value="2019">2019</option>
													<option value="2020">2020</option>
												</select>	
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Batch - Expire</td>
									<td>
										<div class="row">
											<div class="col-sm-9">
												<input type="text" name="nobatch" class="form-control jarak" maxlength = "70" placeholder="Batch" required>
											</div>
											<div class="col-sm-3">
												<div class="input-group jarak">
													<span class="input-group-addon tesdate">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" name="expire" class="form-control datepicker" placeholder="Pilih Tanggal" required>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Harga Beli (Rp)</td>
									<td>
										<input type="number" name="hargabeli" class="form-control hargabeli" maxlength = "10" placeholder="Maks. 10 digit" required>
									</td>
								</tr>
								<tr>
									<td>Stok</td>
									<td>
										<input type="text" name="stok" class="form-control" maxlength = "6" placeholder="Maks. 6 digit" required>
									</td>
								</tr>	
							</table><hr/>
							<button type="submit" class="btnsimpan">Simpan</button>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>