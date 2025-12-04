<div class="row">	
	<div class="col-lg-12">
		<div class="tableborderdiv">
			<div class = "formbg row" style="padding: 30px 30px 30px 30px;">
				<div class = "tableborder">
					<form class="form-horizontal" action="?page=sarpras_pirt_tambah_proses" method="post" role="form">	
						<div class="table-responsive" style="font-size:13px">
							<h4><b>DATA SPPIRT</b></h4><hr/>
							<table class="table table-striped table-condensed">
								<tr>
									<td class="col-sm-2">No.SPPIRT</td>
									<td class="col-sm-10"><input type="text" name="no_sppirt" class="form-control" required></td>
								</tr>
								<tr>
									<td>Masa Berlaku SPPIRT</td>
									<td>
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" name="masaberlaku_sppirt" class="form-control datepicker" placeholder="Pilih Tanggal" required>
										</div>
									</td>
								</tr>
								<tr>
									<td>Nama Industri Rumah Tangga</td>
									<td>
										<input type="text" name="nama_sppirt" class="form-control" required>
									</td>
								</tr>
								<tr>
									<td>Nama Pemilik</td>
									<td>
										<input type="text" name="nama_pemilik_sppirt" class="form-control" required>
									</td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td>
										<textarea name="alamat_sppirt" class="form-control" placeholder="Isi alamat lengkap" required></textarea>
									</td>
								</tr>
								<tr>
									<td>Jenis Pangan</td>
									<td>
										<input type="text" name="pangan_sppirt" class="form-control" required>
									</td>
								</tr>
								<tr>
									<td>Kemasan Primer</td>
									<td>
										<select name="kemasan_sppirt" class="form-control" required>
											<option value="">--Pilih--</option>
											<option value="Aluminium Foil">Aluminium Foil</option>
											<option value="Botol">Botol</option>
											<option value="Dus">Dus</option>
											<option value="Dus & Plastik">Dus & Plastik</option>
											<option value="Kertas">Kertas</option>
											<option value="Plastik">Plastik</option>
											<option value="LAINNYA">LAINNYA</option>
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
