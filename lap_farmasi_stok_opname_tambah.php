<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=lap_farmasi_stok_opname" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>CEK FISIK</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<?php
						if($_GET['stsvalidasi'] != ''){
							echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
						}
					?>
					<form action="?page=lap_farmasi_stok_opname_tambah_proses" method="post">
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
									<td>Bulan - Tahun</td>
									<td>
										<div class="row">
											<div class="col-sm-4">
												<select name="bulan" class="form-control">
													<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
													<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
													<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
													<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
													<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
													<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
													<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
													<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
													<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
													<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
													<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
													<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
												</select>
											</div>
											<div class="col-sm-2">
												<select name="tahun" class="form-control">
													<?php
														for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
														?>
														<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
													<?php }?>
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
