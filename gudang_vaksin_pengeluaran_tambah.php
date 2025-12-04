<div class="tableborderdiv">	
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=gudang_vaksin_pengeluaran" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul mt-2"><b>TAMBAH PENGELUARAN </b><small>Gudang Vaksin</small></h3>
			<div class="formbg">
				<form action="?page=gudang_vaksin_pengeluaran_tambah_proses" method="post" class="forms" enctype="multipart/form-data">	
					<div class = "row">
						<div class="table-responsive">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-2">Tgl.Pengeluaran</td>
									<td class="col-sm-10">
										<?php $tgle = explode("-",date ('Y-m-d')); ?>
										<input type="text" name="tanggalpengeluaran" class="form-control datepicker tglpengeluarangb" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
									</td>
								</tr>
								<tr>
									<td>Program</td>
									<td>
										<select name="namaprogram" class="form-control golonganfungsi" required>
											<?php if($kota == "KABUPATEN BOGOR"){?>
												<option value="VAKSIN">VAKSIN</option>
											<?php }elseif($kota == "KABUPATEN BANDUNG" || $kota == "KOTA BANDUNG" || $kota == "KABUPATEN BULUNGAN" || $kota == "KABUPATEN KUTAI KARTANEGARA" || $kota == "KOTA TARAKAN" || $kota == "KABUPATEN BEKASI"){?>
												<option value="IMUNISASI">IMUNISASI</option>
											<?php }?>
										</select>	
									</td>		
								</tr>
								<tr>
									<td>Status Pengeluaran</td>
									<td>
										<select name="statuspengeluaran" class="form-control statuspengeluaran_gb" required>
											<option value="">--Pilih--</option>
											<option value="PUSKESMAS">PUSKESMAS</option>
											<option value="RUMAH SAKIT">RUMAH SAKIT</option>
											<option value="SENTRA VAKSINASI">SENTRA VAKSINASI</option>
											<option value="LAINNYA">LAINNYA</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Unit Penerima</td>
									<td class="col-sm-10 penerima_gb">
										<select name="penerima" class="form-control penerimacls" required>
											<option value="">--Pilih--</option>
											<option value="GUDANG PELAYANAN">GUDANG PELAYANAN</option>
										</select>	
									</td>
								</tr>
								<?php
									if($kota == "KABUPATEN BOGOR" OR $kota == "KABUPATEN BEKASI"){
								?>
								<tr>
									<td>Petugas Penerima</td>
									<td class="col-sm-10 petugasform">
										<?php if(($dtpengeluaran['StatusPengeluaran'] == 'RUMAH SAKIT' || $dtpengeluaran['StatusPengeluaran'] == 'PUSKESMAS') && $kota != 'KABUPATEN BOGOR'){ ?>
											<select name="petugas" class="form-control" required>
											<option value="">--Pilih--</option>
											<?php
												$query = mysqli_query($koneksi,"SELECT * FROM `tb_user_profil_sbbk_penerima` WHERE KodePuskesmas = '$kdplc'");
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
								<?php
									}else{
								?>	
									<tr>
										<td>Petugas Penerima</td>
										<td class="col-sm-10">
											<input type="text" name="petugas" style="text-transform: uppercase;" class="form-control pegawaifarmasi" placeholder="Ketikan Nama Petugas">
										</td>
									</tr>
								<?php
									}
								?>	
								<tr>
									<td>Keterangan</td>
									<td class="col-sm-4">
										<input  type="text" name="keterangan" style="text-transform: uppercase;" class="form-control" placeholder="Penerimaan Bulan, misal : Januari">
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
							<button type="submit" class="btnsimpan">SIMPAN</button>
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
		
		if($kota != "KABUPATEN BOGOR"){
			if(stspengeluaran == 'PUSKESMAS' || stspengeluaran == 'RUMAH SAKIT'){			
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
		}	
	});
</script>
