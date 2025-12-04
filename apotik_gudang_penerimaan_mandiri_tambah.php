<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<div class="tableborderdiv">	
	<div class="col-xs-12">
		<a href="index.php?page=apotik_gudang_penerimaan_mandiri" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
		<h3 class="judul">PENERIMAAN BARANG</h3>
		<div class="formbg">
			<div class="row">
				<div class="col-lg-12">
					<form action="?page=apotik_gudang_penerimaan_mandiri_tambah_proses" method="post">
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
											<input type="text" name="nosbbk" class="form-control" placeholder="Misal : SBBK/DINKES/01/2022">
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Keterangan</td>
										<td class="col-sm-10">
											<select name="keterangan" class="form-control" required>
												<option value="RUTIN" SELECTED>RUTIN</option>
												<option value="KEKOSONGAN">KEKOSONGAN</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Sumber Anggaran</td>
										<td class="col-sm-10">
											<select name="sumberanggaran" class="form-control sumberanggaran" required>
												<option value="-">--Pilih--</option>
												<option value="APBD KAB/KOTA" SELECTED>APBD KAB/KOTA</option>
												<option value="APBD PROV">APBD PROV</option>
												<option value="APBN">APBN</option>
												<option value="DAK KAB/KOTA">DAK KAB/KOTA</option>
												<option value="DONASI">DONASI</option>
												<option value="HIBAH">HIBAH</option>
												<option value="JKN">JKN</option>
												<option value="LAINNYA">LAINNYA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">Tahun Anggaran</td>
										<td class="col-sm-10">
											<input type="text" name="tahunanggaran" class="form-control" placeholder="Misal : 2022">
										</td>
									</tr>
								</tbody>
							</table><hr/>
							<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>



