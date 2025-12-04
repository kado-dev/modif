<div class="tableborderdiv">	
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=puskesmas_gemacermat" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>TAMBAH KEGIATAN GEMA CERMAT</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<form action="?page=puskesmas_gemacermat_tambah_proses" method="post" enctype="multipart/form-data">	
						<div class="table-responsive">
							<table class="table">
											
								<tr>
									<td class="col-sm-2">Tgl.Kegiatan</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												$tgls = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalkegiatan" class="form-control datepicker" value="<?php echo $tgls[2]."-".$tgls[1]."-".$tgls[0];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td>Penyelenggara</td>
									<td>
										<input type="text" name="penyelenggara" style="text-transform: uppercase;" class="form-control" value="<?php echo $_SESSION['namapuskesmas'];?>" readonly>									
									</td>		
								</tr>
								<tr>
									<td>Sumber Dana</td>
									<td>
										<select name="sumberdana" class="form-control">
											<option value="APBD KAB/KOTA" SELECTED>APBD KAB/KOTA</option>
											<option value="APBD PROVINSI" SELECTED>APBD PROVINSI</option>
											<option value="JKN" SELECTED>JKN</option>
											<option value="PROGRAM">PROGRAM</option>
											<option value="LAINNYA">LAINNYA</option>
										</select>									
									</td>		
								</tr>
								<tr>
									<td>Tempat</td>
									<td>
										<input type="text" name="tempat" style="text-transform: uppercase;" class="form-control" placeholder="Misal: Posyandu Mawar">
									</td>
								</tr>
								<tr>
									<td>Peserta</td>
									<td>
										<input type="text" name="peserta" style="text-transform: uppercase;" class="form-control" placeholder="Misal: Warga Desa Sukasirna, Ibu (Hamil & KB) dan Anak">
									</td>
								</tr>
								<tr>
									<td>Jumlah Peserta</td>
									<td>
										<div class="row">
											<div class="col-sm-3">
												<input type="text" name="peserta_apoteker" style="text-transform: uppercase;" class="form-control" placeholder="Apoteker">
											</div>
											<div class="col-sm-3">
												<input type="text" name="peserta_tenagakesehatan" style="text-transform: uppercase;" class="form-control" placeholder="Tenaga Kesehatan Lainnya">
											</div>
											<div class="col-sm-3">
												<input type="text" name="peserta_kader" style="text-transform: uppercase;" class="form-control" placeholder="Kader">
											</div>
											<div class="col-sm-3">
												<input type="text" name="peserta_masyarakat" style="text-transform: uppercase;" class="form-control" placeholder="Masyarakat Umum">
											</div>
										</div>
										
									</td>
								</tr>
								<tr>
									<td>Hasil Pelaksanaan Kegiatan</td>
									<td>
										<textarea name="hasilkegiatan" style="text-transform: uppercase;" class="form-control" placeholder="Misal: Penyuluhan Gema Cermat"></textarea>
									</td>
								</tr>
								<tr>
									<td>Rencana Tindak Lanjut</td>
									<td>
										<textarea name="rencana" style="text-transform: uppercase;" class="form-control penerimabarang" placeholder="Misal : Melaksanakan Gema Cermat Selanjutnya"></textarea>
									</td>
								</tr>
								<tr>
									<td>Nama AOC / POC</td>
									<td>
										<input type="text" name="namaaoc" style="text-transform: uppercase;" class="form-control" placeholder="Petugas yang melaksanakan">
									</td>
								</tr>
								<tr>
									<td>Foto Pelaksanaan (1)</td>
									<td>
										<input type="file" name="image1" class="form-control">
									</td>
								</tr>
								<tr>
									<td>Foto Materi (2)</td>
									<td>
										<input type="file" name="image2" class="form-control">
									</td>
								</tr>
								<tr>
									<td>Foto Absen (3)</td>
									<td>
										<input type="file" name="image3" class="form-control">
									</td>
								</tr>
							</table><hr>
							<button type="submit" class="btnsimpan">Simpan</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(document).on("change", ".penerimacls", function () {
		var selectedText = $(".penerimacls option:selected").text();
		$(".penerimabarang").val(selectedText);
	});
</script>