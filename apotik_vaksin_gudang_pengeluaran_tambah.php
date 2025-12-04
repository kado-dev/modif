<div class="tableborderdiv">
	<a href="index.php?page=apotik_vaksin_gudang_pengeluaran" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
	<h3 class="judul">PENGELUARAN VAKSIN</h3>
	<div class="formbg">
		<div class="row">	
			<div class="col-lg-12">
				<form action="?page=apotik_vaksin_gudang_pengeluaran_tambah_proses" method="post">
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
									<td>Penerima</td>
									<td>
										<input type="text" name="penerima" class="form-control" required>							
									</td>
								</tr>
							</tbody>
						</table><hr>
						<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



