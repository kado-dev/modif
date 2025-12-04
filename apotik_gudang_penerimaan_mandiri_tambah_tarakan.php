<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<div class="tableborderdiv">	
	<div class="col-xs-12">
		<a href="index.php?page=apotik_gudang_penerimaan_mandiri_tarakan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
		<h3 class="judul">PENERIMAAN BARANG</h3>
		<div class="formbg">
			<div class="row">
				<div class="col-lg-12">
					<form action="?page=apotik_gudang_penerimaan_mandiri_tambah_tarakan_proses" method="post">
						<div class="table-responsive">
							<table class="table-judul" width="100%">
								<tbody>
									<tr>
										<td class="col-sm-2">Tgl.Penerimaan</td>
										<td class="col-sm-10">
											<div class="input-group">
												<span class="input-group-addon tesdate">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
												<?php
													$tgle = explode("-",date ('Y-m-d'));
												?>
												<input type="text" name="tanggalpenerimaan" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>">
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Nomor Sbbk</td>
										<td class="col-sm-10">
											<input type="text" name="nosbbk" class="form-control" style="text-transform: uppercase;" placeholder="Misal : SBBK/DINKES/01/2022">
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Keterangan</td>
										<td class="col-sm-10">
											<select name="keterangan" style="text-transform: uppercase;" class="form-control" required>
												<option value="RUTIN" SELECTED>RUTIN</option>
												<option value="KEKOSONGAN">KEKOSONGAN</option>
											</select>
										</td>
									</tr>
								</tbody>
							</table><hr/>
							<button type="submit" class="btnsimpan">Simpan</button>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>



