<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=gudang_besar_penerimaan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>PENERIMAAN </b><small>Gudang Besar</small></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<form action="?page=gudang_besar_penerimaan_tambah_proses" method="post" class="forms" enctype="multipart/form-data">
					<div class = "row">	
						<div class="table-responsive" style="overflow-x: hidden;">
							<table class="table-judul" width="100%">
								<tr>
									<td class="col-sm-2">Tgl.Penerimaan</td>
									<td class="col-sm-10">
										<?php
											$tgle = explode("-",date ('Y-m-d'));
										?>
										<input type="text" name="tanggalpenerimaan" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
									</td>
								</tr>
								<tr>
									<td>Tgl.Kontrak</td>
									<td>
										<?php
											$tgle = explode("-",date ('Y-m-d'));
										?>
										<input type="text" name="tanggalkontrak" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
									</td>
								</tr>
								<tr>
									<td>No.Kontrak</td>
									<td>
										<input  type="text" name="nomorkontrak" class="form-control puyer" maxlength ="75" placeholder="Silahkan isi nomer kontrak" required>
									</td>
								</tr>
								<tr>
									<td>Nama Pengadaan</td>
									<td>
										<input  type="text" name="namapengadaan" class="form-control puyer" maxlength ="100" placeholder="Silahkan isi nama pengadaan" required>
									</td>
								</tr>
								<tr>
									<td>Sumber-Thn.Anggaran</td>
									<td>
										<div class="row">
											<div class="col-sm-8">
												<?php if($kota == "KABUPATEN BEKASI"){?>
												<select name="sumberanggaran" class="form-control">
													<option value="APBD OBAT PADAT" SELECTED>APBD OBAT PADAT</option>
													<option value="APBD OBAT CAIR">APBD OBAT CAIR</option>
													<option value="APBD OBAT GEL/SALEP">APBD OBAT GEL/SALEP</option>
													<option value="APBD BAHAN OBAT LAINNYA (BMHP)">APBD BAHAN OBAT LAINNYA (BMHP)</option>
													<option value="APBD BAHAN OBAT LAINNYA (COVID)">APBD BAHAN OBAT LAINNYA (COVID)</option>
													<option value="APBD PROV">APBN / APBD PROV</option>
													<option value="HIBAH">HIBAH</option>
													<option value="BTT/DINKES">BTT/DINKES</option>
												</select>
												<?php }elseif($kota == "KABUPATEN BANDUNG"){ ?>
												<select name="sumberanggaran" class="form-control">
													<option value="APBD KAB/KOTA" SELECTED>APBD KAB/KOTA</option>
													<option value="APBD PROV">APBD PROV</option>
													<option value="APBN">APBN</option>
													<option value="DAK KAB/KOTA">DAK KAB/KOTA</option>
													<option value="DONASI">DONASI</option>
													<option value="HIBAH">HIBAH</option>
													<option value="LAINNYA">LAINNYA</option>
												</select>	
												<?php }else{ ?>	
												<select name="sumberanggaran" class="form-control">
													<option value="APBD KAB/KOTA" SELECTED>APBD KAB/KOTA</option>
													<option value="APBD PROV">APBD PROV</option>
													<option value="APBN">APBN</option>
													<option value="DAK KAB/KOTA">DAK KAB/KOTA</option>
													<option value="LAINNYA">LAINNYA</option>
												</select>
												<?php } ?>														
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
								<?php if($kota == "KABUPATEN BANDUNG"){ ?>
								<tr>
									<td>Status Anggaran</td>
									<td>
										<div class="row">
											<div class="col-sm-12">
												<select name="statusanggaran" class="form-control">
													<option value="BTT 1">BTT 1</option>
													<option value="BTT 2">BTT 2</option>
													<option value="BTT 3">BTT 3</option>
													<option value="DAK">DAK</option>
													<option value="DAU">DAU</option>
													<option value="DID">DID</option>
													<option value="DBHCHT">DBHCHT</option>
													<option value="DONASI">DONASI</option>
													<option value="PUSAT">PUSAT</option>
													<option value="PROVINSI">PROVINSI</option>
													<option value="HIBAH">HIBAH</option>
													<option value="LAINNYA">LAINNYA</option>
												</select>											
											</div>
										</div>					
									</td>
								</tr>
								<?php } ?>
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
												<input name="image" type="file" class="form-control" required>
											</div>
										</div>	
									</td>
								</tr>
							</table><hr>
						</div>
						<button type="submit" class="btnsimpan">Simpan</button>
					</div>
				</form>	
			</div>	
		</div>	
	</div>
</div>
