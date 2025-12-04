<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_puskesmas_opnam" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>STOK OPNAME</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<?php
						if($_GET['stsvalidasi'] != ''){
							echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
						}
					?>
					<form action="?page=gudang_puskesmas_opnam_tambah_proses" method="post">
						<div class="table-responsive" style="overflow-x: hidden;">
							<table class="table">
								<tr>
									<td class="col-sm-2">Tgl.Stok Opnam</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalso" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
										</div>
									</td>
								</tr>
								<tr>
									<td>No.Faktur</td>
									<td>
										<input  type="text" name="nofakturso" class="form-control puyer" maxlength ="30" placeholder="Silahkan isi nomer faktur" required>
									</td>
								</tr>
								<tr>
									<td>Sumber Anggaran</td>
									<td>
										<div class="row">
											<div class="col-sm-12">
												<select name="sumberanggaran" class="form-control">
													<option value="APBD PROV">APBD PROV</option>
													<option value="APBD KAB/KOTA" SELECTED>APBD KAB/KOTA</option>
													<option value="APBN">APBN</option>
													<option value="LAINNYA">LAINNYA</option>
												</select>	
											</div>
										</div>					
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>
										<textarea name="keteranganso" class="form-control puyer" maxlength ="100" placeholder="Silahkan isi keterangan tambahan atau catatan" required></textarea>
									</td>
								</tr>
							</table><hr>
						</div>
						<button type="submit" class="btnsimpan">Simpan</button>
					</form>	
				</div>
			</div>	
		</div>	
	</div>
</div>
