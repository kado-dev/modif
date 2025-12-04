<div class="tableborderdiv">
	<a href="index.php?page=apotik_gudang_pengeluaran" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
	<h3 class="judul">PENGELUARAN BARANG <small>Gudang Obat Puskesmas</small></h3>
	<div class="formbg">
		<div class="row">	
			<div class="col-lg-12">
				<form action="?page=apotik_gudang_pengeluaran_tambah_proses" method="post">
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
										<?php
											$kota = $_SESSION['kota'];
										?>
										<input type="hidden" class="lokasikota" value="<?php echo $kota;?>">
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
									<td>Sumber Anggaran</td>
									<td>
										<select name="sumberanggaran" class="form-control" required>
											<option value="">--Pilih--</option>
											<option value="APBD">APBD</option>
											<option value="APBD PROVINSI">APBD PROVINSI</option>
											<option value="APBN">APBN</option>
											<option value="BLUD">BLUD</option>
											<option value="DAK">DAK</option>
											<option value="JKN">JKN</option>
											<option value="PROGRAM">PROGRAM</option>
											<option value="LAINNYA">LAINNYA</option>
										</select>								
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>
										<input  type="text" name="keterangan" class="form-control puyer" value="-">
									</td>
								</tr>
							</tbody>
						</table><hr>
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



