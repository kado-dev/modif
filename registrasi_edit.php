<?php
	session_start();
	include "config/helper_pasienrj.php";
	$idpasienrj = $_GET['id'];
	$str = mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'");
	$dtreg = mysqli_fetch_assoc($str);
?>
<style>
	.radiopilihan input{
		visibility: hidden;
	}
	.radiopilihan{
		background:#fff;
		/* border-top:4px solid rgb(179, 179, 179); */
		color:#263330 !important;
		margin-right:15px;margin-bottom:20px;
		padding:15px 20px 15px 5px;		
		border-radius:6px;
		-webkit-box-shadow: 2px 2px 6px 2px rgba(179,179,179,1);
		-moz-box-shadow: 2px 2px 6px 2px rgba(179,179,179,1);
		box-shadow: 2px 2px 6px 2px rgba(179,179,179,1);
	}
	.radiopilihan.active{
		background:#54d3b6;color:#fff !important;
	}
	.iconpoli{
		margin-right:10px;
		filter: grayscale(100%);
	}

	.radiopilihan_dokter input{
		visibility: hidden;
	}
	.radiopilihan_dokter{
		background:#eee;
		/* border-top:4px solid rgb(179, 179, 179); */
		color:#263330 !important;
		margin-right:15px;margin-bottom:20px;
		padding:15px 20px 15px 5px;		
		border-radius:6px;
		-webkit-box-shadow: 2px 2px 6px 2px rgba(179,179,179,1);
		-moz-box-shadow: 2px 2px 6px 2px rgba(179,179,179,1);
		box-shadow: 2px 2px 6px 2px rgba(179,179,179,1);
	}
	.radiopilihan_dokter.active{
		background:#2B82E5;color:#fff !important;
	}
</style>
<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=registrasi_data" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>EDIT DATA REGISRASI</b></h3>
			<div class="formbg">
				<form class="form-horizontal" action="registrasi_edit_proses.php" method="post" role="form">
				<input type="hidden" name="idpasienrj" value="<?php echo $dtreg['IdPasienrj']?>">
					<input type="hidden" name="noregistrasi" value="<?php echo $_GET['noregistrasi'];?>">	
					<input type="hidden" name="nourutlama" value="<?php echo $dtreg['NoUrutBpjs']?>">
					<input type="hidden" name="tglregbpjs" value="<?php echo $dtreg['TanggalRegistrasi']?>">
					<input type="hidden" name="kodeprovider" value="<?php echo $dtreg['kdprovider']?>">
					<input type="hidden" name="nokartubpjs" value="<?php echo $dtreg['nokartu']?>">
					<input type="hidden" name="kdpoli" value="<?php echo $dtreg['kdpoli']?>">
					<table class="table-judul">
						<tr>
							<td width="20%">Nama</td>
							<td width="80%">
								<input type="text" name="nama" class="form-control" required="required"  value="<?php echo $dtreg['NamaPasien'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td>Perawatan</td>
							<td>
								<div class="radio">
								<label>
									<input type="radio" name="perawatan" value="false" <?php if($dtreg['JenisKunjungan'] == '1'){echo "checked";}?>>Rawat Jalan
								</label>
								<label style="margin-left:50px;">
									<input type="radio" name="perawatan" value="true" <?php if($dtreg['JenisKunjungan'] == '2'){echo "checked";}?>>Rawat Inap
								</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Kunjungan</td>
							<td>
								<div class="radio">
								<label>
									<input type="radio" name="kunjungan" class="kunjungan statuskunjunganpoli" value="true"  <?php if($dtreg['StatusPasien'] == '1'){echo "checked";}?>>Kunjungan Sakit
								</label>
								<label style="margin-left:25px;">
									<input type="radio" name="kunjungan" class="kunjungan statuskunjunganpoli" value="false"  <?php if($dtreg['StatusPasien'] == '2'){echo "checked";}?>>Kunjungan Sehat
								</label>
								</div>	
							</td>
						</tr>
					
					
						

						<tr>
							<td>Cara Bayar</td>
							<td>
								<select name="asuransi" class="form-control asuransichange" required>
									<option value="">--Pilih--</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` order by `Asuransi`");
										while($data = mysqli_fetch_assoc($query)){
											if($dtreg['Asuransi'] == $data['Asuransi']){
												echo "<option value='$data[Asuransi]' selected>$data[Asuransi]</option>";
											}else{
												echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
											}
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>KIR</span></td>
							<td class="parentkir">
								<?php
									$arr_kir = explode(",",$dtreg['Kir']);
									$query = mysqli_query($koneksi,"SELECT * FROM `tbkir` order by `JenisKir`");
									while($dtkir = mysqli_fetch_assoc($query)){
										if(in_array($dtkir['JenisKir'], $arr_kir)){
											echo "<label style='margin-right:20px;'><input type='checkbox' name='kir[]' class='kircls' value='$dtkir[JenisKir]' checked> $dtkir[JenisKir] </label>";
										}else{
											echo "<label style='margin-right:20px;'><input type='checkbox' name='kir[]' class='kircls' value='$dtkir[JenisKir]'> $dtkir[JenisKir] </label>";
										}
									}
								?>
							</td>
						</tr>
						<tr>
							<td>Pelayanan</span></td>
							<td>
								<div class=" pilihan_pelayanan">
									<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' order by `Pelayanan`");
										while($data = mysqli_fetch_assoc($query)){
											if($data['Pelayanan'] == $dtreg['PoliPertama']){
												$stschecked = 'checked';
											}else{
												$stschecked = '';
											}
											?>
												<label class="radiopilihan ">
													<input type="radio" class="opsipolipertama" name="polipertama" value="<?php echo $data['Pelayanan'];?>" <?php echo $stschecked;?>/>
													<img src="image/satusehat.png" width="15px" class="iconpoli"> <?php echo str_replace('POLI ','', $data['Pelayanan']);?>
												</label>
											<?php
										}
									?>
								</div>
							</td>
						</tr>
						<tr>
							<td>Jadwal Dokter <span style="color:red">*</span></td>
							<td>
								<div class="dokterbpjs">
									<!-- <select name="dokterbpjs" class="form-control inputan dokterbpjs">
										<option value="">--Plih Jadwal Dokter--</option>
									</select> -->
								</div>
							</td>
						</tr>
						<tr>
							<td>Status Pemeriksaan</td>
							<td>
								<select name="statuspemeriksaan" class="form-control">
									<option value="Antri" <?php if($dtreg['StatusPelayanan'] == 'Antri'){echo "SELECTED";}?>>Antri</option>
									<option value="Sudah" <?php if($dtreg['StatusPelayanan'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
								</select>
							</td>
						</tr>
				
			
						<tr>
							<td>Klaster</td>
							<td>
								<select name="klaster" class="form-control inputan klaster" required>
									<option value="Klaster 2" <?php if($dtreg['Klaster'] == 'Klaster 2'){echo "SELECTED";}?>>Klaster 2 (Ibu dan Anak)</option>
									<option value="Klaster 3" <?php if($dtreg['Klaster'] == 'Klaster 3'){echo "SELECTED";}?>>Klaster 3 (Usia Dewasa dan Lansia)</option>
									<option value="Klaster 4" <?php if($dtreg['Klaster'] == 'Klaster 4'){echo "SELECTED";}?>>Klaster 4 (Penanggulangan Penyakit Menular)</option>
									<option value="Klaster 5" <?php if($dtreg['Klaster'] == 'Klaster 5'){echo "SELECTED";}?>>Klaster 5 (Lintas Klaster)</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Siklus Hidup</td>
							<td>
								<select name="siklushidup" class="form-control inputan siklus_hidup" required>
									<option value="Ibu Hamil, Bersalin, dan Nifas" <?php if($dtreg['SiklusHidup'] == 'Ibu Hamil, Bersalin, dan Nifas'){echo "SELECTED";}?>>Ibu Hamil, Bersalin, dan Nifas</option>
									<option value="Balita dan Anak Pra Sekolah" <?php if($dtreg['SiklusHidup'] == 'Balita dan Anak Pra Sekolah'){echo "SELECTED";}?>>Balita dan Anak Pra Sekolah</option>
									<option value="Anak Usia Sekolah dan Remaja" <?php if($dtreg['SiklusHidup'] == 'Anak Usia Sekolah dan Remaja'){echo "SELECTED";}?>>Anak Usia Sekolah dan Remaja</option>
									<option value="Usia Dewasa" <?php if($dtreg['SiklusHidup'] == 'Usia Dewasa'){echo "SELECTED";}?>>Usia Dewasa</option>
									<option value="Lanjut Usia" <?php if($dtreg['SiklusHidup'] == 'Lanjut Usia'){echo "SELECTED";}?>>Lanjut Usia</option>
									<option value="-" <?php if($dtreg['SiklusHidup'] == '-'){echo "SELECTED";}?>>-</option>
								</select>
							</td>
						</tr>
					</table><hr/>	
					<input type="hidden" name="noregistrasi" class="form-control" required="required"  value="<?php echo $_GET['noregistrasi'];?>" readonly>
					<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
				</form>
			</div>
		</div>	
	</div>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(document).ready(function() {	
		
		$('input[name="polipertama"]:checked').parent().addClass('active');
		$(document).on("click",".radiopilihan",function() {
			$(".radiopilihan").removeClass('active');
			$(this).addClass('active');
		});
		
		$('input[name="dokterbpjs"]:checked').parent().addClass('active');
		$(document).on("click",".radiopilihan_dokter",function() {
			$(".radiopilihan_dokter").removeClass('active');
			$(this).addClass('active');
		});

		// komen dulu
		var polipertama = $('input[name="polipertama"]:checked').val();//$(".polipertama").val();
		$.post( "get_dokter_bpjs_bypelayanan.php", { kodepoli:polipertama})
			.done(function( data ) {
			// alert(data);
			$( ".dokterbpjs" ).html( data );
		});
		
		$(".opsipolipertama").click(function(){		
			var ini = $(this).val();
			var ses = '<?php echo $_SESSION['poliantrian']?>';			
				if(ses != ''){
					if(ini != "POLI KIA" && ini != "POLI KB" && ini != "POLI TB"){
						if(ini != ses){
							alert('Poli tidak sesuai dengan nomor antrian...');
							//$(this).val(ses);
						}
					}			
				}

			var kota = '<?php echo $kota;?>';
			if(kota == "KOTA TARAKAN"){	
				var umur_lengkap = $(".tgllahir-perkiraan-umur").text();
				var umur = umur_lengkap.split(" ")[0];
				if(parseInt(umur) >= 45){
					if(ini == "POLI UMUM"){
						alert('Silahkan registrasi ke Pelayanan Lansia...');
						$(this).val('POLI LANSIA');
					}
				}
			}
			
			if(ini == 'POLI LABORATORIUM'){
				$(".formlab").show();
			}else{
				$(".formlab").hide();
			}	

			if(ini == 'POLI GIZI'){
				$(".tmpelpecare").show();
			}else{
				$(".tmpelpecare").hide();
			}

			// komen dulu
			$.post( "get_dokter_bpjs_bypelayanan.php", { kodepoli:ini})
					.done(function( data ) {
						$( ".dokterbpjs" ).html( data );
			});
		});	

		$(".klaster").change(function(){
			var ini = $(this).val();
			if(ini == 'Klaster 2'){
				$(".siklus_hidup").html('<option value="Ibu Hamil, Bersalin, dan Nifas" >Ibu Hamil, Bersalin, dan Nifas</option><option value="Balita dan Anak Pra Sekolah" >Balita dan Anak Pra Sekolah</option><option value="Anak Usia Sekolah dan Remaja" >Anak Usia Sekolah dan Remaja</option>');
			}else if(ini == 'Klaster 3'){
				$(".siklus_hidup").html('<option value="Usia Dewasa" >Usia Dewasa</option><option value="Lanjut Usia" >Lanjut Usia</option>');
			}else if(ini == 'Klaster 4'){
				$(".siklus_hidup").html('<option value="Kesehatan lingkungan" >Kesehatan lingkungan</option><option value="Surveilans" >Surveilans</option>');
			}
		});
	});	
</script>