<?php
	$nofaktur = $_GET['nf'];
	$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nofaktur'"));
	// echo "SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nofaktur'";
?>

<div class="tableborderdiv">	
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=gudang_besar_pengeluaran" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul mt-2"><b>EDIT PENGELUARAN </b><small>Gudang Besar</small></h3>
			<div class="formbg">
				<form action="?page=gudang_besar_pengeluaran_edit_proses" method="post">	
					<div class = "row">
						<div class="table-responsive">
							<table class="table-judul" width="100%">
								<tr>
									<td class="col-sm-2">
										<?php
											if($kota == "KABUPATEN BEKASI"){
												echo "Tgl.Diserahkan";
											}else{
												echo "Tgl.Pengeluaran";
											}
										?>	
									</td>
									<td class="col-sm-10">
										<input type="text" name="tanggalpengeluaran" class="form-control datepicker" value="<?php echo date('d-m-Y', strtotime($dtpengeluaran['TanggalPengeluaran']));?>">
									</td>
								</tr>
								<tr>
									<td>Status Pengeluaran</td>
									<td>
										<select name="statuspengeluaran" class="form-control statuspengeluaran_gb" required>
											<option value="">--Pilih--</option>
											<?php if($_SESSION['kota'] == 'KABUPATEN BANDUNG'){?>
											<option value="GUDANG PELAYANAN" <?php if($dtpengeluaran['StatusPengeluaran'] == 'GUDANG PELAYANAN'){echo "SELECTED";}?>>GUDANG PELAYANAN</option>
											<option value="RUMAH SAKIT" <?php if($dtpengeluaran['StatusPengeluaran'] == 'RUMAH SAKIT'){echo "SELECTED";}?>>RUMAH SAKIT</option>
											<option value="PUSKESMAS" <?php if($dtpengeluaran['StatusPengeluaran'] == 'PUSKESMAS'){echo "SELECTED";}?>>PUSKESMAS</option>
											<?php }else{?>
											<option value="PUSKESMAS" <?php if($dtpengeluaran['StatusPengeluaran'] == 'PUSKESMAS'){echo "SELECTED";}?>>PUSKESMAS</option>
											<option value="RUMAH SAKIT" <?php if($dtpengeluaran['StatusPengeluaran'] == 'RUMAH SAKIT'){echo "SELECTED";}?>>RUMAH SAKIT</option>
											<option value="LAINNYA" <?php if($dtpengeluaran['StatusPengeluaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
											<?php }?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Unit Penerima</td>
									<td class="col-sm-10 penerima_gb">
										<?php if($dtpengeluaran['StatusPengeluaran'] == 'RUMAH SAKIT'){ ?>
										<select name="penerima" class="form-control penerimacls" required>
											<option value="">--Pilih--</option>
											<?php
												$query = mysqli_query($koneksi,"SELECT * FROM `ref_rumahsakit` ORDER BY `NamaRs` ASC");
												while($data = mysqli_fetch_assoc($query)){
													if($data['NamaRs'] == $dtpengeluaran['Penerima']){
														$kdplc = $data['IdRs'];
													echo "<option value='$data[IdRs]' SELECTED>$data[NamaRs]</option>";
													}else{
													echo "<option value='$data[IdRs]'>$data[NamaRs]</option>";
													}
												}
											?>
										</select>
										<?php }else if($dtpengeluaran['StatusPengeluaran'] == 'PUSKESMAS'){ ?>
										<select name="penerima" class="form-control penerimacls" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas` ASC");
											while($data = mysqli_fetch_assoc($query)){
												if($data['NamaPuskesmas'] == $dtpengeluaran['Penerima']){
													$kdplc = $data['KodePuskesmas'];
													echo "<option value='$data[KodePuskesmas]' SELECTED>$data[NamaPuskesmas]</option>";
												}else{
													echo "<option value='$data[KodePuskesmas]'>$data[NamaPuskesmas]</option>";
												}
											}
											?>
										</select>
										<?php }else{?>
										<input name="penerima" value="<?php echo $dtpengeluaran['Penerima']?>" class="form-control penerimacls" required>
										<?php }?>		
									</td>
								</tr>
								<tr>
									<td>Petugas Penerima</td>
									<td class="col-sm-10 petugasform">
										<?php if(($dtpengeluaran['StatusPengeluaran'] == 'RUMAH SAKIT' || $dtpengeluaran['StatusPengeluaran'] == 'PUSKESMAS') && $kota != 'KABUPATEN BOGOR'){ ?>
											<select name="petugas" class="form-control" required>
											<option value="">--Pilih--</option>
											<?php
												$query = mysqli_query($koneksi,"select * from `tb_user_profil_sbbk_penerima` where KodePuskesmas = '$kdplc'");
												while($data = mysqli_fetch_assoc($query))
												{
													if($dtpengeluaran['PetugasPenerima'] == $data['NamaPegawai']){
														echo "<option value='".$data['NamaPegawai']."' SELECTED>".$data['NamaPegawai']."</option>";
													}else{
														echo "<option value='".$data['NamaPegawai']."'>".$data['NamaPegawai']."</option>";	
													}
												}
											?>
										</select>
										<?php }else{?>	
											<input type="text" name="petugas" style="text-transform: uppercase;" class="form-control penerimabarang" value="<?php echo $dtpengeluaran['PetugasPenerima'];?>">
										<?php }?>
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td class="col-sm-4">
										<input  type="text" name="keterangan" style="text-transform: uppercase;" class="form-control" value="<?php echo $dtpengeluaran['Keterangan'];?>">
									</td>
								</tr>
							</table><hr>
							<input  type="hidden" name="nofaktur" class="form-control" value="<?php echo $nofaktur;?>">
							<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
						</div>
					</div>
				</form>	
				
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>		
	$(document).on("change", ".penerimacls", function () {
		var kdpuskesmas = $(".penerimacls").val();
		var stspengeluaran = $(".statuspengeluaran_gb").val();
		var kota = '<?php echo $kota;?>';
		
			if((stspengeluaran == 'PUSKESMAS' || stspengeluaran == 'RUMAH SAKIT') && kota != "KABUPATEN BOGOR"){			
				$.post( "get_pegawai_puskesmas_selectform.php", { kdpuskesmas: kdpuskesmas })
					.done(function( data ) {
						if(kdpuskesmas != ''){
							$(".petugasform").html("<select name='petugas' class='form-control'>"+data+"</select>");
						}else{
							$(".petugasform").html("<select name='petugas' class='form-control'><option value=''>--Pilih--</option></select>");
						}				
				});
			}else{
				$(".petugasform").html('<input type="text" name="petugas" style="text-transform: uppercase;" class="form-control penerimabarang" placeholder="Ketikan Nama Petugas">');
			}
		
	});
</script>