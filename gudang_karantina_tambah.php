<div class="tableborderdiv">
	<div class="row">	
		<div class="col-xs-12">
			<a href="index.php?page=gudang_karantina" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>KARANTINA</b></h3>	
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<form action="?page=gudang_karantina_tambah_proses" method="post">	
						<div class="table-responsive" style="overflow-x: hidden;">
							<table class="table">
								<tr>
									<td class="col-sm-2">Tgl.Karantina</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<input type="text" name="tanggalkarantina" class="form-control datepicker" placeholder="Pilih Tanggal" required>
										</div>
									</td>
								</tr>
								<tr>
									<td>Gudang</td>
									<td>
										<select name="statusgudang" class="form-control">
											<option value="Gudang Besar">Gudang Besar</option>
											<option value="Gudang Vaksin">Gudang Vaksin</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Status Karantina</td>
									<td>
										<select name="statuskarantina" class="form-control">
											<option value="Rusak">Rusak</option>
											<option value="Expire">Expire</option>
											<option value="Lainnya">Lainnya</option>
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
