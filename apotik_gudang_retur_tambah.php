<div class="tableborderdiv">
	<div class="col-xs-12">
		<a href="index.php?page=apotik_gudang_retur" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
		<h3 class="judul">RETUR BARANG <small>GUDANG OBAT PUSKESMAS</small></h3>
		<div class="formbg">
			<div class="row">	
				<div class="col-lg-12">
					<form action="?page=apotik_gudang_retur_tambah_proses" method="post">
						<div class="table-responsive">
							<table class="table-judul">
								<tbody>		
									<tr>
										<td class="col-sm-2">Tanggal Retur</td>
										<td class="col-sm-10">
											<div class="input-group">
												<span class="input-group-addon tesdate"><span class="glyphicon glyphicon-calendar"></span></span>
												<input type="text" name="tanggalretur" class="form-control datepicker" placeholder="Pilih Tanggal">
											</div>
										</td>
									</tr>
									<tr>
										<td>Nomor SBBK</td>
										<td>
											<select name="nomorfaktur" class="form-control" required>
												<?php
												$kodepuskesmas = $_SESSION['kodepuskesmas'];
												$tahun = date('Y');
												$strsbbk = "SELECT `NoFaktur` FROM `tbgfkpengeluaran` WHERE `KodePenerima` = '$kodepuskesmas' AND YEAR(`TanggalPengeluaran`)='$tahun' ORDER BY `IdDistribusi` DESC";
												$query = mysqli_query($koneksi, $strsbbk);
													while($data = mysqli_fetch_assoc($query)){
														if($data['Pelayanan'] == $_SESSION['poliantrian']){
															echo "<option value='$data[NoFaktur]' SELECTED>$data[NoFaktur]</option>";
														}else{
															echo "<option value='$data[NoFaktur]'>$data[NoFaktur]</option>";
														}
													}
												?>
											</select>	
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
</div>



