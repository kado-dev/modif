<div class="tableborderdiv">	
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=gudang_besar_pengeluaran" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul mt-2"><b>TAMBAH PENGELUARAN </b><small>Gudang Besar</small></h3>
			<?php
				// cek sudah kirim data elog apa blm
				$bln = date('m');
				$thn = date('Y');
				
				if($bln == '01'){
					$bulans = '12';
					$tahuns = $thn - 1;
				}else{
					$bulans = $bln;
					$tahuns = $thn;
				}	
				
				// $cekdata = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Id` FROM `tbelogistikkemkes` WHERE `Bulan`='$bulans' AND `Tahun`='$tahuns'"));
				// if($cekdata['Id'] == 0){
			?>	
				<!--<div class="row noprint">
					<div class="col-sm-12">
						<div class="alert alert-block alert-danger fade in">
							<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
							<p>
								<b>Perhatian :</b><br/>
								Silahkan kirim data Elogistik dulu, <a href="?page=elog_indikator_kirim" style="color: #994040; font-weight: bold;"> Klik disini!</a>
							</p>
						</div>
					</div>
				</div>-->
			<?php //}else{ ?>		
				<div class="formbg">
					<form action="?page=gudang_besar_pengeluaran_tambah_proses" method="post">	
						<div class = "row">
							<div class="table-responsive" style="overflow-x: hidden;">
								<table class="table-judul" width="100%">
									<?php
										if($kota == "KABUPATEN BEKASI"){
									?>				
									<tr>
										<td class="col-sm-2">Tgl.Entry</td>
										<td class="col-sm-10">
											<div class="input-group">
												<span class="input-group-addon tesdate"><span class="fa fa-calendar"></span></span>
												<?php $tgls = explode("-",date ('Y-m-d')); ?>
												<input type="text" name="tanggalentry" class="form-control datepicker" value="<?php echo $tgls[2]."-".$tgls[1]."-".$tgls[0];?>">
											</div>
										</td>
									</tr>
									<?php
										}
									?>
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
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalpengeluaran" class="form-control datepicker tglpengeluarangb" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>"><!--panggil clas dari halaman index.php-->
										</td>
									</tr>
									<?php
										// nama program tampil hanya kabupaten bogor
										if($kota == "KABUPATEN BOGOR"){
									?>
									<tr>
										<td>Program</td>
										<td>
											<select name="namaprogram" class="form-control golonganfungsi" required>
												<option value="">--Pilih--</option>
												<?php
												$query = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` ORDER BY nama_program");
												while($data = mysqli_fetch_assoc($query)){
													if($dtstok['nama_program'] == $data['nama_program']){
														echo "<option value='$data[nama_program]' SELECTED>$data[nama_program]</option>";
													}else{
														echo "<option value='$data[nama_program]'>$data[nama_program]</option>";
													}
												}
												?>
											</select>	
										</td>		
									</tr>
									<?php
										}
									?>	
									<tr>
										<td>Status Pengeluaran</td>
										<td>
											<select name="statuspengeluaran" class="form-control statuspengeluaran_gb" required>
												<option value="">--Pilih--</option>
												<option value="DEPO FARMASI">DEPO FARMASI</option>
												<option value="PUSKESMAS">PUSKESMAS</option>
												<option value="RUMAH SAKIT">RUMAH SAKIT</option>
												<option value="LAINNYA">LAINNYA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Unit Penerima</td>
										<td class="col-sm-10 penerima_gb">
											<select name="penerima" class="form-control penerimacls" required>
												<option value="">--Pilih--</option>
												<option value="DEPO FARMASI">DEPO FARMASI</option>
											</select>	
										</td>
									</tr>
									<tr>
										<td>Petugas Penerima</td>
										<td class="col-sm-10 petugasform">
											<?php 
												if(($dtpengeluaran['StatusPengeluaran'] == 'RUMAH SAKIT' || $dtpengeluaran['StatusPengeluaran'] == 'PUSKESMAS') AND $kota != 'KABUPATEN BOGOR'){ 
											?>
												<select name="petugas" class="form-control">
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
											<input  type="text" name="keterangan" style="text-transform: uppercase;" class="form-control" placeholder="Penjelasan">
										</td>
									</tr>
								</table><hr>
								<button type="submit" class="btnsimpan">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			<?php //} ?>		
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