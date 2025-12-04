<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_vaksin_penerimaan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>PENERIMAAN </b><small>Gudang Vaksin</small></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<form action="?page=gudang_vaksin_penerimaan_tambah_proses" method="post" class="forms" enctype="multipart/form-data">
						<div class="table-responsive" style="overflow-x: hidden;">
							<table class="table-judul">
								<tr>
									<td class="col-sm-2">Tgl.Penerimaan</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalpenerimaan" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
										</div>
									</td>
								</tr>
								<tr>
									<td>Tgl.Kontrak</td>
									<td>
										<div class="input-group">
											<span class="input-group-addon tesdate"><!--saat diklik tampil panggil class diindex.php-->
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalkontrak" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
										</div>
									</td>
								</tr>
								<tr>
									<td>No.Kontrak</td>
									<td>
										<input  type="text" name="nomorkontrak" class="form-control puyer" maxlength ="50" placeholder="Silahkan isi nomer kontrak" required>
									</td>
								</tr>
								<tr>
									<td>Nama Pengadaan</td>
									<td>
										<input  type="text" name="namapengadaan" class="form-control puyer" maxlength ="100" placeholder="Silahkan isi nama pengadaan" required>
									</td>
								</tr>
								<tr>
									<td>Sumber Anggaran</td>
									<td>
										<div class="row">
											<div class="col-sm-8">
												<select name="sumberanggaran" class="form-control">
													<option value="APBD PROV">APBN / APBD PROV</option>
													<option value="APBD KAB/KOTA" SELECTED>APBD KAB/KOTA</option>
													<option value="DAK KAB/KOTA">DAK KAB/KOTA</option>
													<option value="DONASI">DONASI</option>
													<option value="HIBAH">HIBAH</option>
													<option value="LAINNYA">LAINNYA</option>
												</select>	
											</div>
											<div class="col-sm-4">
												<select name="tahunanggaran" class="form-control">
													<?php
														for($tahun = 2018 ; $tahun <= date('Y'); $tahun++){
														?>
														<option value="<?php echo $tahun;?>" <?php if($_GET['tahunanggaran'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
													<?php }?>
												</select>
											</div>
										</div>					
									</td>
								</tr>
								<tr>
									<td>Supplier</td>
									<td>
										<div class="row">
											<div class="col-sm-8">
												<input type="text" name="supplier" class="form-control nama_produsen" placeholder="Ketikan Nama Supplier" required>
											</div>
											<div class="col-sm-4">
												<input type="text" name="kodesupplier" class="form-control id" readonly>
											</div>
										</div>	
									</td>
								</tr>
								<tr>
									<td>Foto</td>
									<td>
										<div class="row">
											<div class="col-sm-12">
												<input name="image" type="file" class="form-control">
											</div>
										</div>	
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
