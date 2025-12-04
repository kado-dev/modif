<?php
$id = $_GET['id'];
$datapenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpenerimaan` WHERE `IdPenerimaan`='$id'"));
?>
<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_besar_penerimaan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>EDIT PENERIMAAN </b><small>Gudang Besar</small></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<form action="?page=gudang_besar_penerimaan_edit_proses" method="post">
						<div class="table-judul" style="overflow-x: hidden;">
							<table class="table">
								<tr>
									<td class="col-sm-2">Tgl.Penerimaan</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												// $tgle = explode("-",date ('Y-m-d'));
												$tgle = explode("-",date ($datapenerimaan['TanggalPenerimaan']));
											?>
											<input type="text" name="tanggalpenerimaan" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly>
											<input type="hidden" name="tanggalpenerimaanawal" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly>
										</div>
									</td>
								</tr>
								<tr>
									<td>Tgl.Kontrak</td>
									<td>
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												// $tgle = explode("-",date ('Y-m-d'));
												$tgle2 = explode("-",date ($datapenerimaan['TanggalKontrak']));
											?>
											<input type="text" name="tanggalkontrak" class="form-control datepicker" value="<?php echo $tgle2[2]."-".$tgle2[1]."-".$tgle2[0];?>" readonly>
										</div>
									</td>
								</tr>
								<tr>
									<td>No.Kontrak</td>
									<td>
										<input  type="text" name="nomorkontrak" class="form-control puyer" maxlength ="50" value="<?php echo $datapenerimaan['NomorKontrak'];?>" required>
									</td>
								</tr>
								<tr>
									<td>Nama Pengadaan</td>
									<td>
										<input  type="text" name="namapengadaan" class="form-control puyer" maxlength ="100" value="<?php echo $datapenerimaan['NamaPengadaan'];?>" required>
									</td>
								</tr>
								<tr>
									<td>Sumber-Thn.Anggaran</td>
									<td>
										<div class="row">
											<div class="col-sm-8">
												<?php if($kota == "KABUPATEN BEKASI"){?>
												<select name="sumberanggaran" class="form-control">
													<option value="APBD OBAT PADAT" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD OBAT PADAT'){echo "SELECTED";}?>>APBD OBAT PADAT</option>
													<option value="APBD OBAT CAIR" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD OBAT CAIR'){echo "SELECTED";}?>>APBD OBAT CAIR</option>
													<option value="APBD OBAT GEL/SALEP" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD OBAT GEL/SALEP'){echo "SELECTED";}?>>APBD OBAT GEL/SALEP</option>
													<option value="APBD BAHAN OBAT LAINNYA (BMHP)" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD BAHAN OBAT LAINNYA (BMHP)'){echo "SELECTED";}?>>APBD BAHAN OBAT LAINNYA (BMHP)</option>
													<option value="APBD BAHAN OBAT LAINNYA (COVID)" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD BAHAN OBAT LAINNYA (COVID)'){echo "SELECTED";}?>>APBD BAHAN OBAT LAINNYA (COVID)</option>
													<option value="APBD PROV" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBN / APBD PROV</option>
													<option value="HIBAH" <?php if($datapenerimaan['SumberAnggaran'] == 'HIBAH'){echo "SELECTED";}?>>HIBAH</option>
													<option value="BTT/DINKES" <?php if($datapenerimaan['SumberAnggaran'] == 'BTT/DINKES'){echo "SELECTED";}?>>BTT/DINKES</option>
												</select>
												<?php }elseif($kota == "KABUPATEN BANDUNG"){ ?>
												<select name="sumberanggaran" class="form-control">
													<option value="APBD KAB/KOTA" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD KAB/KOTA</option>
													<option value="APBD PROV" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBD PROV</option>
													<option value="APBN" <?php if($datapenerimaan['SumberAnggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
													<option value="DAK KAB/KOTA" <?php if($datapenerimaan['SumberAnggaran'] == 'DAK KAB/KOTA'){echo "SELECTED";}?>>DAK KAB/KOTA</option>
													<option value="DONASI" <?php if($datapenerimaan['SumberAnggaran'] == 'DONASI'){echo "SELECTED";}?>>DONASI</option>
													<option value="HIBAH" <?php if($datapenerimaan['SumberAnggaran'] == 'HIBAH'){echo "SELECTED";}?>>HIBAH</option>
													<option value="LAINNYA" <?php if($datapenerimaan['SumberAnggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
												</select>	
												<?php }else{ ?>	
												<select name="sumberanggaran" class="form-control">
													<option value="APBD KAB/KOTA" <?php if($datapenerimaan['SumberAnggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD KAB/KOTA</option>
													<option value="APBD PROV" <?php if($datapenerimaan['SumberAnggaran'] == '"APBD PROV'){echo "SELECTED";}?>>APBD PROV</option>
													<option value="APBN" <?php if($datapenerimaan['SumberAnggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
													<option value="DAK KAB/KOTA" <?php if($datapenerimaan['SumberAnggaran'] == 'DAK KAB/KOTA'){echo "SELECTED";}?>>DAK KAB/KOTA</option>
													<option value="LAINNYA" <?php if($datapenerimaan['SumberAnggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
												</select>
												<?php } ?>														
											</div>
											<div class="col-sm-4">	
												<select name="tahunanggaran" class="form-control">
													<?php
														for($tahun = 2018 ; $tahun <= date('Y'); $tahun++){
														?>
														<option value="<?php echo $tahun;?>" <?php if($datapenerimaan['TahunAnggaran'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
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
													<option value="BTT 1" <?php if($datapenerimaan['StatusAnggaran'] == 'BTT 1'){echo "SELECTED";}?>>BTT 1</option>
													<option value="BTT 2" <?php if($datapenerimaan['StatusAnggaran'] == 'BTT 2'){echo "SELECTED";}?>>BTT 2</option>
													<option value="BTT 3" <?php if($datapenerimaan['StatusAnggaran'] == 'BTT 3'){echo "SELECTED";}?>>BTT 3</option>
													<option value="DAK" <?php if($datapenerimaan['StatusAnggaran'] == 'DAK'){echo "SELECTED";}?>>DAK</option>
													<option value="DAU" <?php if($datapenerimaan['StatusAnggaran'] == 'DAU'){echo "SELECTED";}?>>DAU</option>
													<option value="DID" <?php if($datapenerimaan['StatusAnggaran'] == 'DID'){echo "SELECTED";}?>>DID</option>
													<option value="DBHCHT" <?php if($datapenerimaan['StatusAnggaran'] == 'DBHCHT'){echo "SELECTED";}?>>DBHCHT</option>
													<option value="DONASI" <?php if($datapenerimaan['StatusAnggaran'] == 'DONASI'){echo "SELECTED";}?>>DONASI</option>
													<option value="PUSAT" <?php if($datapenerimaan['StatusAnggaran'] == 'PUSAT'){echo "SELECTED";}?>>PUSAT</option>
													<option value="PROVINSI" <?php if($datapenerimaan['StatusAnggaran'] == 'PROVINSI'){echo "SELECTED";}?>>PROVINSI</option>
													<option value="HIBAH" <?php if($datapenerimaan['StatusAnggaran'] == 'HIBAH'){echo "SELECTED";}?>>HIBAH</option>
													<option value="LAINNYA" <?php if($datapenerimaan['StatusAnggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
												</select>											
											</div>
										</div>					
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td>Supplier</td>
									<td>
										<?php
											$datasupplier = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `ref_pabrik` WHERE `id`='$datapenerimaan[KodeSupplier]'"));
										?>
										<div class="row">
											<div class="col-sm-8">
												<input type="text" name="supplier" class="form-control nama_produsen" value="<?php echo $datasupplier['nama_prod_obat'];?>" required>
											</div>
											<div class="col-sm-4">
												<input type="text" name="kodesupplier" class="form-control id" value="<?php echo $datasupplier['id'];?>" readonly>
											</div>
										</div>	
									</td>
								</tr>
							</table><hr>
						</div>
						<input type="hidden" name="idpenerimaan" class="form-control" value="<?php echo $datapenerimaan['IdPenerimaan'];?>">
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</form>	
				</div>
			</div>	
		</div>	
	</div>
</div>
