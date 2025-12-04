<div class="tableborderdiv">
	<a href="index.php?page=aset_pengeluaran_tambah" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
	<h3 class="judul">PENGELUARAN BARANG <small>(Aset)</small></h3>
	<div class="formbg">
		<div class="row">	
			<div class="col-lg-12">
				<form action="?page=aset_pengeluaran_tambah_proses" method="post">
					<div class="table-responsive">
						<table class="table-judul">
							<tbody>		
								<tr>
									<td class="col-sm-2">Tgl.Pengeluaran</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalpengeluaran" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td>Status Pengeluaran</td>
									<td>
										<select name="statuspengeluaran" class="form-control statuspengeluaran" required>
											<option value="">--Pilih--</option>
											<option value="DALAM GEDUNG">DALAM GEDUNG</option>
											<option value="LUAR GEDUNG">LUAR GEDUNG</option>
											<option value="PROGRAM">PROGRAM</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Penerima</td>
									<td>
										<select name="penerima" class="form-control penerima" required>
											<option value="">--Pilih--</option>
										</select>								
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>
										<input type="text" name="keterangan" class="form-control" value="-">
									</td>
								</tr>
							</tbody>
						</table><hr>
						<button type="submit" class="btnsimpan">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



