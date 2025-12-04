<?php
	$id = $_GET['id'];
	$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tb_user_profil_sbbk_penerima where IdPenerima = '$id'"));
?>
<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DATA PENERIMA (SBBK)</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<form action="index.php?page=master_penerima_lplpo_edit_proses" method="post" class="forms">
						<input type="hidden" name="id" value="<?php echo $data['IdPenerima'];?>">
						<div class="form-row">
							<div class="form-group col-md-12">
								<div class="row">
									<div class="form-group col-md-6">
										<label>Status</label>
										<select name="status" class="form-control statuspengeluaran_gb" required>
											<option value="">--Pilih--</option>
											<?php if($_SESSION['kota'] == 'KABUPATEN BANDUNG'){?>
											<option value="GUDANG PELAYANAN" <?php if($data['StatusPenerima'] == 'GUDANG PELAYANAN'){echo 'SELECTED';}?>>GUDANG PELAYANAN</option>
											<option value="RUMAH SAKIT" <?php if($data['StatusPenerima'] == 'RUMAH SAKIT'){echo 'SELECTED';}?>>RUMAH SAKIT</option>
											<option value="PUSKESMAS" <?php if($data['StatusPenerima'] == 'PUSKESMAS'){echo 'SELECTED';}?>>PUSKESMAS</option>
											<?php }else{?>
											<option value="PUSKESMAS" <?php if($data['StatusPenerima'] == 'PUSKESMAS'){echo 'SELECTED';}?>>PUSKESMAS</option>
											<option value="RUMAH SAKIT" <?php if($data['StatusPenerima'] == 'RUMAH SAKIT'){echo 'SELECTED';}?>>RUMAH SAKIT</option>
											<option value="LAINNYA" <?php if($data['StatusPenerima'] == 'LAINNYA'){echo 'SELECTED';}?>>LAINNYA</option>
											<?php }?>
										</select>
									</div>
									<div class="form-group col-md-6">
										<label>Unit Penerima</label>
										<div class="penerima_gb">
											<?php
												if($data['StatusPenerima'] == 'GUDANG PELAYANAN'){
											?>
												<select name="penerima" class="form-control penerimacls" required>
													<option value="GUDANG PELAYANAN">GUDANG PELAYANAN</option>
												</select>
											<?php
												}else if($data['StatusPenerima'] == 'PUSKESMAS'){
												$datapuskesmas = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas` ASC");
											?>
												<select name="penerima" class="form-control penerimacls" required>
													<?php
														while($dtpus = mysqli_fetch_assoc($datapuskesmas)){
															if($dtpus['KodePuskesmas'] == $data['KodePuskesmas']){
																echo "<option value='$dtpus[KodePuskesmas]' SELECTED>$dtpus[NamaPuskesmas]</option>";
															}else{
																echo "<option value='$dtpus[KodePuskesmas]'>$dtpus[NamaPuskesmas]</option>";
															}	
															
														}
													?>
												</select>
											<?php
											}else if($data['StatusPenerima'] == 'RUMAH SAKIT'){
												$datarumahsakit = mysqli_query($koneksi,"SELECT * FROM `ref_rumahsakit` ORDER BY `NamaRs` ASC");
											?>
												<select name="penerima" class="form-control penerimacls" required>
													<option value="">--Pilih--</option>
													<?php
														while($dtruh = mysqli_fetch_assoc($datarumahsakit)){
															if($dtruh['IdRs'] == $data['KodePuskesmas']){
																echo "<option value='$dtruh[IdRs]' SELECTED>$dtruh[NamaRs]</option>";
															}else{
																echo "<option value='$dtruh[IdRs]'>$dtruh[NamaRs]</option>";
															}
														}
													?>
												</select>
											<?php
											}else{
											?>
												<input type="text" value="<?php echo $data['KodePuskesmas'];?>" class="form-control penerimacls" name="penerima" style="text-transform: uppercase;" value="-">
											<?php
												}
											?>
										</div>
										<input type="hidden" value="<?php echo $data['NamaPuskesmas'];?>" name="namapenerima" class="namapenerima">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-4">
										<label>Nama Penerima Barang</label>
										<input name="namapegawai" type="text" value="<?php echo $data['NamaPegawai'];?>" class="form-control form-control-sm" placeholder="Nama Lengkap" required>
									</div>
									<div class="form-group col-md-4">
										<label>Jabatan</label>
										<input name="jabatan" type="text" value="<?php echo $data['Jabatan'];?>" class="form-control form-control-sm" placeholder="Jabatan" required>
									</div>
									<div class="form-group col-md-4">
										<label>Nip</label>
										<input name="nip" type="text" value="<?php echo $data['Nip'];?>" class="form-control form-control-sm" placeholder="Nip" maxlength="20" required>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btnsimpan">Simpan</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>	
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>		
	$(document).on("change", ".penerimacls", function () {
		
		var text = $(".penerimacls option:selected").text();
		$(".namapenerima").val(text);
	});
	

</script>	