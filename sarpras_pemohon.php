<div class="row">	
	<div class="col-lg-12">
		<div class="tableborderdiv">
			<div class = "formbg row" style="padding: 30px 30px 30px 30px;">
				<div class = "tableborder">
					<form class="form-horizontal" action="?page=sarpras_pemohon_proses" method="post" role="form">	
						<div class="table-responsive" style="font-size:13px">
							<h4><b>DATA PEMOHON</b></h4><hr/>
							<table class="table table-striped table-condensed">
								<tr>
									<td class="col-sm-2">Tgl.SK</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<input type="text" name="tanggalsk" class="form-control datepicker" placeholder="Pilih Tanggal" required>
										</div>
									</td>
								</tr>
								<tr>
									<td>Nomor SK</td>
									<td>
										<input type="text" name="nomorsk" class="form-control" required>
									</td>
								</tr>
								<tr>
									<td>NIK</td>
									<td>
										<input type="text" name="nik" class="form-control" placeholder="Sesuai E-KTP" required>
									</td>
								</tr>
								<tr>
									<td>Nama Pemohon</td>
									<td>
										<input type="text" name="nama_pemohon" class="form-control" required>
									</td>
								</tr>
								<tr>
									<td>Alamat Pemohon</td>
									<td>
										<textarea name="alamat_pemohon" class="form-control" placeholder="Isi alamat lengkap" required></textarea>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div class="row">
											<div class="col-sm-3">
												<input type="text" name="provinsi_pemohon" class="form-control nama_provinsi" placeholder="Provinsi">
											</div>
											<div class="col-sm-3">
												<input type="text" name="kota_pemohon" class="form-control nama_kotakk" placeholder="Kab./Kota">
											</div>
											<div class="col-sm-3">
												<input type="text" name="kecamatan_pemohon" class="form-control nama_provinsi" placeholder="Kecamatan">
											</div>
											<div class="col-sm-3">
												<input type="text" name="kelurahan_pemohon" class="form-control nama_kotakk" placeholder="Desa/Kelurahan">
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Nomor Handphone</td>
									<td>
										<input type="text" name="nomorhp_pemohon" class="form-control">
									</td>
								</tr>
							</table><br/>
							
							<h4><b>DATA PERUSAHAAN</b></h4><hr/>
							<table class="table table-striped table-condensed">
								
								<tr>
									<td class="col-sm-2">Nama Perusahaan</td>
									<td class="col-sm-10">
										<input type="text" name="nama_perusahaan" class="form-control" required>
									</td>
								</tr>
								<tr>
									<td>Alamat Perusahaan</td>
									<td>
										<textarea name="alamat_perusahaan" class="form-control" placeholder="Isi alamat lengkap" required></textarea>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div class="row">
											<div class="col-sm-3">
												<input type="text" name="provinsi_perusahaan" class="form-control nama_provinsi" placeholder="Provinsi" required>
											</div>
											<div class="col-sm-3">
												<input type="text" name="kota_perusahaan" class="form-control nama_kotakk" placeholder="Kab./Kota" required>
											</div>
											<div class="col-sm-3">
												<input type="text" name="kecamatan_perusahaan" class="form-control nama_provinsi" placeholder="Kecamatan" required>
											</div>
											<div class="col-sm-3">
												<input type="text" name="kelurahan_perusahaan" class="form-control nama_kotakk" placeholder="Desa/Kelurahan" required>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Telp.Perusahaan</td>
									<td>
										<input type="text" name="telp_perusahaan" class="form-control">
									</td>
								</tr>
							</table><br/><hr/>
							<button type="submit" class="btnsimpan">Simpan</button>
						</div>
					</form>	
				</div>		
			</div>		
		</div>	
	</div>
</div>
