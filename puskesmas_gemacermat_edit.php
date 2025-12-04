<div class="tableborderdiv">	
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=puskesmas_gemacermat" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>EDIT KEGIATAN GEMA CERMAT</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<form action="?page=puskesmas_gemacermat_edit_proses" method="post" enctype="multipart/form-data">	
						<div class="table-responsive">
							<?php
								$idkegiatan = $_GET['id'];
								$nofaktur = $_GET['nf'];
								$strgc = "SELECT * FROM `tbgfkgemacermat` WHERE `IdKegiatan`='$idkegiatan'";
								// echo $strgc;
								$querygc = mysqli_query($koneksi, $strgc);
								$datagc = mysqli_fetch_assoc($querygc);
							?>
							<table class="table">
								<tr>
									<td class="col-sm-2">Tgl.Kegiatan</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<input type="text" name="tanggalkegiatan" class="form-control datepicker" value="<?php echo date('d-m-Y',strtotime($datagc['TanggalKegiatan']));?>">
										</div>
									</td>
								</tr>
								<tr>
									<td>Penyelenggara</td>
									<td>
										<select name="penyelenggara" class="form-control golonganfungsi" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` ORDER BY NamaPuskesmas");
											while($data = mysqli_fetch_assoc($query)){
												if($data['NamaPuskesmas'] == $datagc['Penyelenggara']){
													echo "<option value='$data[NamaPuskesmas]' SELECTED>$data[NamaPuskesmas]</option>";
												}else{
													echo "<option value='$data[NamaPuskesmas]'>$data[NamaPuskesmas]</option>";
												}
											}
											?>
										</select>	
									</td>		
								</tr>
								<tr>
									<td>Tempat</td>
									<td>
										<input type="text" name="tempat" style="text-transform: uppercase;" class="form-control" value="<?php echo $datagc['Tempat'];?>">
									</td>
								</tr>
								<tr>
									<td>Peserta</td>
									<td>
										<input type="text" name="peserta" style="text-transform: uppercase;" class="form-control" value="<?php echo $datagc['Peserta'];?>">
									</td>
								</tr>
								<tr>
									<td>Jumlah Peserta</td>
									<td>
										<div class="row">
											<div class="col-sm-3">
												<input type="text" name="peserta_apoteker" style="text-transform: uppercase;" class="form-control" value="<?php echo $datagc['JumlahApoteker'];?>">
											</div>
											<div class="col-sm-3">
												<input type="text" name="peserta_tenagakesehatan" style="text-transform: uppercase;" class="form-control" value="<?php echo $datagc['JumlahNakesLain'];?>">
											</div>
											<div class="col-sm-3">
												<input type="text" name="peserta_kader" style="text-transform: uppercase;" class="form-control" value="<?php echo $datagc['JumlahKader'];?>">
											</div>
											<div class="col-sm-3">
												<input type="text" name="peserta_masyarakat" style="text-transform: uppercase;" class="form-control" value="<?php echo $datagc['JumlahMasyarakat'];?>">
											</div>
										</div>
										
									</td>
								</tr>
								<tr>
									<td>Hasil Pelaksanaan Kegiatan</td>
									<td>
										<textarea name="hasilkegiatan" style="text-transform: uppercase;" class="form-control"><?php echo $datagc['HasilKegiatan'];?></textarea>
									</td>
								</tr>
								<tr>
									<td>Rencana Tindak Lanjut</td>
									<td>
										<textarea name="rencana" style="text-transform: uppercase;" class="form-control penerimabarang"><?php echo $datagc['RencanaTindakLanjut'];?></textarea>
									</td>
								</tr>
								<tr>
									<td>Foto Kegiatan (1)</td>
									<td>
										<input type="file" name="image1" class="form-control">
									</td>
								</tr>
								<tr>
									<td>Foto Kegiatan (2)</td>
									<td>
										<input type="file" name="image2" class="form-control">
									</td>
								</tr>
								<tr>
									<td>Foto Kegiatan (3)</td>
									<td>
										<input type="file" name="image3" class="form-control">
									</td>
								</tr>
							</table><hr>
							<input type="hidden" name="idkegiatan" class="form-control" value="<?php echo $idkegiatan;?>">
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