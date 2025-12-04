<div class="row">	
	<div class="col-lg-12">
		<div class="tableborderdiv">
			<a href="index.php?page=adm_pendampingan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>PENDAMPINGAN SIMPUS</b></h3>
			<div class = "formbg row" style="padding: 30px 30px 30px 30px;">
				<div class="tableborder">
					<form action="?page=adm_pendampingan_tambah_proses" method="post" enctype="multipart/form-data">
						<div class="table-responsive" style="font-size:13px">
							<table class="table table-striped table-condensed">	

								<tbody>	
									<tr>
										<td class="col-sm-2">Tgl.Pendampingan</td>
										<td class="col-sm-10">
											<div class="input-group">
												<span class="input-group-addon tesdate">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<?php
													$tgle = explode("-",date ('Y-m-d'));
												?>
												<input type="text" name="tanggalpendampingan" class="form-control datepicker"  value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>">
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Puskesmas</td>
										<td class="col-sm-10">
											<div class="input-group">
												<input  type="text" name="puskesmas" style="text-transform: uppercase;" class="form-control puskesmas" Placeholder="Ketikan Nama Puskesmas">								
												<span class="input-group-addon">Auto</span>	
											</div>	
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Bersedia Melaksanakan</td>
										<td class="col-sm-10">
											<select name="bersedia" class="form-control" required>
												<option value="YA">YA</option>
												<option value="TIDAK">TIDAK</option>
											</select>							
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">SDM</td>
										<td class="col-sm-10">
											<input  type="text" name="sdm" style="text-transform: uppercase;" class="form-control">
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Komputer</td>
										<td class="col-sm-10">
											<div class="input-group">
												<input  type="text" name="komputer" style="text-transform: uppercase;" class="form-control">	
												<span class="input-group-addon">Unit</span>	
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Printer</td>
										<td class="col-sm-10">
											<div class="input-group">
												<input  type="text" name="printer" style="text-transform: uppercase;" class="form-control">	
												<span class="input-group-addon">Unit</span>	
											</div>	
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Kecepatan Internet</td>
										<td class="col-sm-10">
											<div class="input-group">
												<input  type="text" name="internet" style="text-transform: uppercase;" class="form-control">
												<span class="input-group-addon">Mbps</span>
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Keterangan</td>
										<td class="col-sm-4">
											<textarea name="keterangan" style="text-transform: uppercase;" class="form-control"></textarea>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Upload Kegiatan (1)</td>
										<td class="col-sm-4">
											<input type="file" name="image" class="form-control">
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Upload Absen (2)</td>
										<td class="col-sm-4">
											<input type="file" name="image2" class="form-control">
										</td>
									</tr>
									<tr>
										<td class="col-sm-2"></td>
										<td></td>
										<td class="col-sm-4">
											<input type="submit" value="Simpan" class="btn btn-info">
										</td>
									</tr>
								</tbody>
							</table>
							<button type="submit" class="btnsimpan">Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



