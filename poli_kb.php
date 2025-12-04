<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datakb = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolikb_kunjunganulang` WHERE `NoPemeriksaan` = '$noregistrasi'"));
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolikb` WHERE `NoCM` = '$nocm'"));
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-3">
					Keluhan
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 1 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan"><?php echo $datakb['Keluhan'];?></textarea></td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Anamnesa
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 2 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan"><?php echo $datakb['Anamnesa'];?></textarea></td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Riwayat Alergi Makanan
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 3 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergimakanan" class="form-control inputan" required>
						<option value="00" <?php if($datakb['RiwayatAlergiMakanan'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datakb['RiwayatAlergiMakanan'] == '01'){echo "SELECTED";}?>>Seafood</option>
						<option value="02" <?php if($datakb['RiwayatAlergiMakanan'] == '02'){echo "SELECTED";}?>>Gandum</option>
						<option value="03" <?php if($datakb['RiwayatAlergiMakanan'] == '03'){echo "SELECTED";}?>>Susu Sapi</option>
						<option value="04" <?php if($datakb['RiwayatAlergiMakanan'] == '04'){echo "SELECTED";}?>>Kacang-Kacangan</option>
						<option value="05" <?php if($datakb['RiwayatAlergiMakanan'] == '05'){echo "SELECTED";}?>>Makanan Lain</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Riwayat Alergi Udara
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 4 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergiudara" class="form-control inputan" required>
						<option value="00" <?php if($datakb['RiwayatAlergiUdara'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datakb['RiwayatAlergiUdara'] == '01'){echo "SELECTED";}?>>Udara Panas</option>
						<option value="02" <?php if($datakb['RiwayatAlergiUdara'] == '02'){echo "SELECTED";}?>>Udara Dingin</option>
						<option value="03" <?php if($datakb['RiwayatAlergiUdara'] == '03'){echo "SELECTED";}?>>Udara Kotor</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Riwayat Alergi Obat
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 5 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergiobat" class="form-control inputan" required>
						<option value="00" <?php if($datakb['RiwayatAlergiObat'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datakb['RiwayatAlergiObat'] == '01'){echo "SELECTED";}?>>Antibiotik</option>
						<option value="02" <?php if($datakb['RiwayatAlergiObat'] == '02'){echo "SELECTED";}?>>Antiinflamasi</option>
						<option value="03" <?php if($datakb['RiwayatAlergiObat'] == '03'){echo "SELECTED";}?>>Non Steroid</option>
						<option value="04" <?php if($datakb['RiwayatAlergiObat'] == '04'){echo "SELECTED";}?>>Aspirin</option>
						<option value="05" <?php if($datakb['RiwayatAlergiObat'] == '05'){echo "SELECTED";}?>>Kortikosteroid</option>
						<option value="06" <?php if($datakb['RiwayatAlergiObat'] == '06'){echo "SELECTED";}?>>Insulin</option>
						<option value="07" <?php if($datakb['RiwayatAlergiObat'] == '07'){echo "SELECTED";}?>>Obat-Obatan Lain</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Prognosa
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 6 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="prognosa" class="form-control inputan" required>
						<option value="01" <?php if($datakb['Prognosa'] == '01'){echo "SELECTED";}?>>Sanam (Sembuh)</option>
						<option value="02" <?php if($datakb['Prognosa'] == '02'){echo "SELECTED";}?>>Bonam (Baik)</option>
						<option value="03" <?php if($datakb['Prognosa'] == '03'){echo "SELECTED";}?>>Malam (Buruk/Jelek)</option>
						<option value="04" <?php if($datakb['Prognosa'] == '04'){echo "SELECTED";}?>>Dubia Ad Sanam/Bolam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
						<option value="05" <?php if($datakb['Prognosa'] == '05'){echo "SELECTED";}?>>Dubia Ad Malam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Sekarang</td>
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control inputan"><?php echo $datakb['RiwayatPenyakitSekarang'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control inputan"><?php echo $datakb['RiwayatPenyakitDulu'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control inputan"><?php echo $datakb['RiwayatPenyakitKeluarga'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type ="text" name ="anjuran" style="text-transform: uppercase;" class="form-control inputan" maxlength = "100" value = "<?php echo $datakb['Anjuran'];?>" ></td>
			</tr>
			<tr>
				<?php
					$cek_catin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Catin_Hiv`,`Catin_Hbsag`,`Catin_Ppt` FROM `tbpolilaboratorium` WHERE `NoPemeriksaan`='$noregistrasi'"));
					if($cek_catin != ""){
						$hasilpenunjang = "Hiv : ".$cek_catin['Catin_Hiv'].", Hbsag : ".$cek_catin['Catin_Hbsag'].", PPT : ".$cek_catin['Catin_Ppt'];
					}else{
						$hasilpenunjang = $datakb['PemeriksaanPenunjang'];
					}	
				?>	
				<td>Pemeriksaan Penunjang</td>
				<td><textarea name="pemeriksaanpenunjang" style="text-transform: uppercase;" class="anamnesa form-control inputan" maxlength = "100"><?php echo $hasilpenunjang;?></textarea></td>
			</tr>
		</table>	
	</div>	
</div>

<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<h3 class="judul mt-4"><b>Pemeriksaan Penunjang (cukup diisi saat kunjungan pertama)</b></h3>
				<tr>
					<td class="col-sm-2">Tanggal Haid Terakhir</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TanggalHaidTerakhir'] == null){
									$tglhaidterakhir = date('Y-m-d');
								}else{
									$tglhaidterakhir = date('Y-m-d', strtotime($datapemeriksaan['TanggalHaidTerakhir']));
								}
							?>
							<input type="text" name="tgl_haid_terakhir" class="form-control inputan datepicker2" value="<?php echo $tglhaidterakhir;?>" >
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Jumlah Anak Hidup</td>
					<td>
						<input type="text" name="anak_hidup" style="text-transform: uppercase;" class="form-control inputan" maxlength ="10" placeholder = "Sebutkan" value = "<?php echo $datapemeriksaan['AnakHidup'];?>">
					</td>
				</tr>
				<tr>
					<td>Umur Anak Terkecil</td>
					<td>
						<input type="text" name="umur_terkecil" style="text-transform: uppercase;" class="form-control inputan" maxlength ="10" placeholder = "Sebutkan" value = "<?php echo $datapemeriksaan['UmurTerkcil'];?>">
					</td>
				</tr>
				<tr>
					<td>Status Peserta KB</td>
					<td>
						<SELECT name="status_kb" class="form-control inputan">
							<option value="Pasca Salin" <?php if($datapemeriksaan['StatusKB'] == 'Pasca Salin'){echo "SELECTED";}?>>Pasca Salin</option>
							<option value="Baru Pertama Kali" <?php if($datapemeriksaan['StatusKB'] == 'Baru Pertama Kali'){echo "SELECTED";}?>>Baru Pertama Kali</option>
							<option value="Kunjungan Ulang" <?php if($datapemeriksaan['StatusKB'] == 'Kunjungan Ulang'){echo "SELECTED";}?>>Kunjungan Ulang</option>
							<option value="Pernah Pakai Alat KB Berhenti Sesudah Persalinan/Keguguran" <?php if($datapemeriksaan['StatusKB'] == 'Pernah Pakai Alat KB Berhenti Sesudah Persalinan/Keguguran'){echo "SELECTED";}?>>Pernah Pakai Alat KB Berhenti Sesudah Persalinan/Keguguran</option>
							<option value="Pindah Tempat" <?php if($datapemeriksaan['StatusKB'] == 'Pindah Tempat'){echo "SELECTED";}?>>Pindah Tempat</option>
							<option value="-" <?php if($datapemeriksaan['StatusKB'] == '-'){echo "SELECTED";}?>>-</option>
						</SELECT>
					</td>
				</tr>
				<tr>
					<td>Cara KB Terakhir</td>
					<td>
						<SELECT name="kb_terakhir" class="form-control inputan">
							<option value="Iud" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
							<option value="Mow" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
							<option value="Mop" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
							<option value="Kondom" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
							<option value="Implan" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Implan'){echo "SELECTED";}?>>Implan</option>
							<option value="Implanon" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Implanon'){echo "SELECTED";}?>>Implanon</option>
							<option value="Suntik" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
							<option value="Pil" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
							<option value="Tidak" <?php if($datapemeriksaan['CaraKBTerakhir'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</SELECT>
					</td>
				</tr>
				<tr>
					<td>Hamil/Diduga Hamil</td>
					<td>
						<SELECT name="hamil_diduga" class="form-control inputan">
							<option value="Ya" <?php if($datapemeriksaan['Hamil'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							<option value="Tidak" <?php if($datapemeriksaan['Hamil'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</SELECT>
					</td>
				</tr>
				<tr>
					<td>Menyusui</td>
					<td>
						<SELECT name="menyusui" class="form-control inputan">
							<option value="Ya" <?php if($datapemeriksaan['Menyusui'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							<option value="Tidak" <?php if($datapemeriksaan['Menyusui'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</SELECT>
					</td>
				</tr>
				<tr>
					<td>Metode Alkon Yang di Pilih</td>
					<td>
						<SELECT name="metode_alkon" class="form-control inputan">
							<option value="Iud" <?php if($datapemeriksaan['AlKonDipilih'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
							<option value="Mow" <?php if($datapemeriksaan['AlKonDipilih'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
							<option value="Mop" <?php if($datapemeriksaan['AlKonDipilih'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
							<option value="Kondom" <?php if($datapemeriksaan['AlKonDipilih'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
							<option value="Kontrol Iud" <?php if($datapemeriksaan['AlKonDipilih'] == 'Kontrol Iud'){echo "SELECTED";}?>>Kontrol Iud</option>
							<option value="Implant" <?php if($datapemeriksaan['AlKonDipilih'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
							<option value="Implanon" <?php if($datapemeriksaan['AlKonDipilih'] == 'Implanon'){echo "SELECTED";}?>>Implanon</option>
							<option value="Suntikan 1 Bln" <?php if($datapemeriksaan['AlKonDipilih'] == 'Suntikan 1 Bln'){echo "SELECTED";}?>>Suntikan 1 Bln</option>
							<option value="Suntikan 3 Bln" <?php if($datapemeriksaan['AlKonDipilih'] == 'Suntikan 3 Bln'){echo "SELECTED";}?>>Suntikan 3 Bln</option>
							<option value="-" <?php if($datapemeriksaan['AlKonDipilih'] == '-'){echo "SELECTED";}?>>-</option>
						</SELECT>
					</td>
				</tr>
				<tr>
					<td>G-P-A</td>
					<td>
						<div class="row" style="margin-top:-10px">
							<div class="col-sm-2" style="padding:10px 15px 0px 15px">
								<input type="number" name="gravida" class="form-control inputan" maxlength ="2" placeholder = "Gravida" value = "<?php echo $datapemeriksaan['Gravida'];?>">						
							</div>
							<div class="col-sm-2" style="padding:10px 15px 0px 15px">
								<input type="number" name="partus" class="form-control inputan" maxlength ="2" placeholder = "Partus" value = "<?php echo $datapemeriksaan['Partus'];?>">
							</div>
							<div class="col-sm-2" style="padding:10px 15px 0px 15px">
								<input type="text" name="abortus" class="form-control inputan" maxlength ="5" placeholder = "Abortus" value = "<?php echo $datapemeriksaan['Abortus'];?>">									
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Ganti Cara</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<SELECT name="ganti_cara" class="form-control inputan">
									<option value="-" <?php if($datapemeriksaan['GantiCara'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="Iud" <?php if($datapemeriksaan['GantiCara'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
									<option value="Suntik" <?php if($datapemeriksaan['GantiCara'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
									<option value="Pil" <?php if($datapemeriksaan['GantiCara'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
									<option value="Implant" <?php if($datapemeriksaan['GantiCara'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
									<option value="Mow" <?php if($datapemeriksaan['GantiCara'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
									<option value="Mop" <?php if($datapemeriksaan['GantiCara'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
									<option value="Kondom" <?php if($datapemeriksaan['GantiCara'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
									<option value="Lainnya" <?php if($datapemeriksaan['GantiCara'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
								</SELECT>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Aseptor Baru-Aktif</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<SELECT name="aseptor_baru" class="form-control inputan">
									<option value="-" <?php if($datapemeriksaan['AseptorBaru'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="Iud" <?php if($datapemeriksaan['AseptorBaru'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
									<option value="Suntik" <?php if($datapemeriksaan['AseptorBaru'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
									<option value="Pil" <?php if($datapemeriksaan['AseptorBaru'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
									<option value="Implant" <?php if($datapemeriksaan['AseptorBaru'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
									<option value="Mow" <?php if($datapemeriksaan['AseptorBaru'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
									<option value="Mop" <?php if($datapemeriksaan['AseptorBaru'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
									<option value="Kondom" <?php if($datapemeriksaan['AseptorBaru'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
									<option value="Lainnya" <?php if($datapemeriksaan['AseptorBaru'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
								</SELECT>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Aseptor Aktif</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<SELECT name="aseptor_aktif" class="form-control inputan">
									<option value="-" <?php if($datapemeriksaan['AseptorAktif'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="Iud" <?php if($datapemeriksaan['AseptorAktif'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
									<option value="Suntik" <?php if($datapemeriksaan['AseptorAktif'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
									<option value="Pil" <?php if($datapemeriksaan['AseptorAktif'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
									<option value="Implant" <?php if($datapemeriksaan['AseptorAktif'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
									<option value="Mow" <?php if($datapemeriksaan['AseptorAktif'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
									<option value="Mop" <?php if($datapemeriksaan['AseptorAktif'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
									<option value="Kondom" <?php if($datapemeriksaan['AseptorAktif'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
									<option value="Lainnya" <?php if($datapemeriksaan['AseptorAktif'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
								</SELECT>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Efek Samping KB</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<SELECT name="efek_samping_kb" class="form-control inputan">
									<option value="-" <?php if($datapemeriksaan['EfekSampingKB'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="Iud" <?php if($datapemeriksaan['EfekSampingKB'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
									<option value="Suntik" <?php if($datapemeriksaan['EfekSampingKB'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
									<option value="Pil" <?php if($datapemeriksaan['EfekSampingKB'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
									<option value="Implant" <?php if($datapemeriksaan['EfekSampingKB'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
									<option value="Mow" <?php if($datapemeriksaan['EfekSampingKB'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
									<option value="Mop" <?php if($datapemeriksaan['EfekSampingKB'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
									<option value="Kondom" <?php if($datapemeriksaan['EfekSampingKB'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
									<option value="Lainnya" <?php if($datapemeriksaan['EfekSampingKB'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
								</SELECT>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Komplikasi KB</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<SELECT name="komplikasi_kb" class="form-control inputan">
									<option value="-" <?php if($datapemeriksaan['KomplikasiKB'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="Iud" <?php if($datapemeriksaan['KomplikasiKB'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
									<option value="Suntik" <?php if($datapemeriksaan['KomplikasiKB'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
									<option value="Pil" <?php if($datapemeriksaan['KomplikasiKB'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
									<option value="Implant" <?php if($datapemeriksaan['KomplikasiKB'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
									<option value="Mow" <?php if($datapemeriksaan['KomplikasiKB'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
									<option value="Mop" <?php if($datapemeriksaan['KomplikasiKB'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
									<option value="Kondom" <?php if($datapemeriksaan['KomplikasiKB'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
									<option value="Lainnya" <?php if($datapemeriksaan['KomplikasiKB'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
								</SELECT>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Kegagalan KB</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<SELECT name="kegagalan_kb" class="form-control inputan">
									<option value="-" <?php if($datapemeriksaan['KegagalanKB'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="Iud" <?php if($datapemeriksaan['KegagalanKB'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
									<option value="Suntik" <?php if($datapemeriksaan['KegagalanKB'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
									<option value="Pil" <?php if($datapemeriksaan['KegagalanKB'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
									<option value="Implant" <?php if($datapemeriksaan['KegagalanKB'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
									<option value="Mow" <?php if($datapemeriksaan['KegagalanKB'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
									<option value="Mop" <?php if($datapemeriksaan['KegagalanKB'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
									<option value="Kondom" <?php if($datapemeriksaan['KegagalanKB'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
									<option value="Lainnya" <?php if($datapemeriksaan['KegagalanKB'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
								</SELECT>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Riwayat Penyakit</td>
					<td>
						<?php $riwayat = explode(',',$datapemeriksaan['RiwayatPenyakit']);?>
						<label><input type="checkbox" name="riwayat_penyakit_kb[]" value="Sakit Kuning" <?php if (in_array("Sakit Kuning", $riwayat)) {echo "checked";}?>> Sakit Kuning</label><br>
						<label><input type="checkbox" name="riwayat_penyakit_kb[]" value="Pendarahan" <?php if (in_array("Pendarahan", $riwayat)) {echo "checked";}?>> Pendarahan</label><br>
						<label><input type="checkbox" name="riwayat_penyakit_kb[]" value="Keputihan" <?php if (in_array("Keputihan", $riwayat)) {echo "checked";}?>> Keputihan</label><br>
						<label><input type="checkbox" name="riwayat_penyakit_kb[]" value="Tumor Payudara" <?php if (in_array("Tumor Payudara", $riwayat)) {echo "checked";}?>> Tumor Payudara</label><br>
						<label><input type="checkbox" name="riwayat_penyakit_kb[]" value="Tumor Rahim" <?php if (in_array("Tumor Rahim", $riwayat)) {echo "checked";}?>> Tumor Rahim</label><br>
						<label><input type="checkbox" name="riwayat_penyakit_kb[]" value="Tumor Indung Telur" <?php if (in_array("Tumor Indung Telur", $riwayat)) {echo "checked";}?>> Tumor Indung Telur</label>
					</td>
				</tr>
				<tr>
					<td>Pemeriksaan Dalam</td>
					<td>
						<?php $prk_dalam = explode(',',$datapemeriksaan['PemeriksaanDalam']);?>
						<label><input type="checkbox" name="pemeriksaan_dalam[]" value="Retrofleksi" <?php if (in_array("Retrofleksi", $prk_dalam)) {echo "checked";}?>> Retrofleksi</label><br>
						<label><input type="checkbox" name="pemeriksaan_dalam[]" value="Antefleksi" <?php if (in_array("Antefleksi", $prk_dalam)) {echo "checked";}?>> Antefleksi</label><br>
						<label><input type="checkbox" name="pemeriksaan_dalam[]" value="Tanda Radang" <?php if (in_array("Tanda Radang", $prk_dalam)) {echo "checked";}?>> Tanda Radang</label><br>
						<label><input type="checkbox" name="pemeriksaan_dalam[]" value="Tumor/Keg.Ginekologi" <?php if (in_array("Tumor/Keg.Ginekologi", $prk_dalam)) {echo "checked";}?>> Tumor/Keg.Ginekologi</label><br>
					</td>
				</tr>
				<tr>
					<td>Pemeriksaan Tambahan</td>
					<td>
						<?php $prk_tambahan = explode(',',$datapemeriksaan['PemeriksaanTambahan']);?>
						<label><input type="checkbox" name="pemeriksaan_tambahan[]" value="Tanda Diabetes" <?php if (in_array("Tanda Diabetes", $prk_tambahan)) {echo "checked";}?>> Tanda Diabetes</label><br>
						<label><input type="checkbox" name="pemeriksaan_tambahan[]" value="Pembekuan Darah" <?php if (in_array("Pembekuan Darah", $prk_tambahan)) {echo "checked";}?>> Pembekuan Darah</label><br>
						<label><input type="checkbox" name="pemeriksaan_tambahan[]" value="Radang Orchitis" <?php if (in_array("Radang Orchitis", $prk_tambahan)) {echo "checked";}?>> Radang Orchitis</label><br>
						<label><input type="checkbox" name="pemeriksaan_tambahan[]" value="Tumor/Keg.Ginekologi" <?php if (in_array("Tumor/Keg.Ginekologi", $prk_tambahan)) {echo "checked";}?>> Tumor/Keg.Ginekologi</label><br>
					</td>
				</tr>
				<tr>
					<td>Alkon Yang Boleh Digunakan</td>
					<td>
						<?php $alkon = explode(',',$datapemeriksaan['AlkonBolehDigunakan']);?>
						<label><input type="checkbox" name="alkon_boleh[]" value="Iud" <?php if (in_array("Iud", $alkon)) {echo "checked";}?>> Iud</label><br>
						<label><input type="checkbox" name="alkon_boleh[]" value="Mow" <?php if (in_array("Mow", $alkon)) {echo "checked";}?>> Mow</label><br>
						<label><input type="checkbox" name="alkon_boleh[]" value="Mop" <?php if (in_array("Mop", $alkon)) {echo "checked";}?>> Mop</label><br>
						<label><input type="checkbox" name="alkon_boleh[]" value="Kondom" <?php if (in_array("Kondom", $alkon)) {echo "checked";}?>> Kondom</label><br>
						<label><input type="checkbox" name="alkon_boleh[]" value="Implant" <?php if (in_array("Implant", $alkon)) {echo "checked";}?>> Implant</label><br>
						<label><input type="checkbox" name="alkon_boleh[]" value="Implanon" <?php if (in_array("Implanon", $alkon)) {echo "checked";}?>> Implanon</label><br>
						<label><input type="checkbox" name="alkon_boleh[]" value="Suntikan" <?php if (in_array("Suntikan", $alkon)) {echo "checked";}?>> Suntikan</label><br>
						<label><input type="checkbox" name="alkon_boleh[]" value="Pil" <?php if (in_array("Pil", $alkon)) {echo "checked";}?>> Pil</label><br>
					</td>
				</tr>
			</table>	
		</div>
	</div>
</div>

<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<h3 class="judul mt-4"><b>Pemeriksaan Status KB</b></h3>
				<tr>
					<td>Tanggal Haid Terakhir</td>
					<td>
						<div class="input-group">
							<?php
								if($datakb['TanggalHaidTerakhir'] == null){
									$tglhaidterakhir = date('Y-m-d');
								}else{
									$tglhaidterakhir = date('Y-m-d', strtotime($datakb['TanggalHaidTerakhir']));
								}	
							?>
							<input type="text" name="tgl_haid_akhir" class="form-control inputan datepicker" value="<?php echo $tglhaidterakhir;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Kegagalan KB</td>
					<td><input type="text" name="kegagalan_kb" style="text-transform: uppercase;" class="form-control inputan" maxlength = "100" value = "<?php echo $datakb['Kegagalan'];?>"></text></td>
				</tr>
				<tr>
					<td>Komplikasi Berat</td>
					<td><input type="text" name="komplikasi_berat" style="text-transform: uppercase;" class="form-control inputan" maxlength = "100" value = "<?php echo $datakb['KomplikasiBerat'];?>"></text></td>
				</tr>
				<tr>
					<td>Informed Consent</td>
					<td>
						<SELECT name="ic" class="form-control inputan">
							<option value="Ya" <?php if($datakb['InformedConsent'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							<option value="Tidak" <?php if($datakb['InformedConsent'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</SELECT>
					</td>
				</tr>
				<tr>
					<td>Ganti cara</td>
					<td>
						<div class="row" style="margin-top:-10px">
							<div class="col-sm-2" style="padding:10px 15px 0px 12px">
								<SELECT name="ganticara" class="form-control inputan">
									<option value="-" <?php if($datakb['GantiCara'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="Iud" <?php if($datakb['GantiCara'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
									<option value="Suntik" <?php if($datakb['GantiCara'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
									<option value="Pil" <?php if($datakb['GantiCara'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
									<option value="Implant" <?php if($datakb['GantiCara'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
									<option value="Mow" <?php if($datakb['GantiCara'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
									<option value="Mop" <?php if($datakb['GantiCara'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
									<option value="Kondom" <?php if($datakb['GantiCara'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
									<option value="Lainnya" <?php if($datakb['GantiCara'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
								</SELECT>
							</div>
							<div class="col-sm-10" style="padding:10px 15px 0px 12px">
								<div class="input-group">
									<?php
										if($datakb['TanggalGanti'] == null){
											$tglganti = date('Y-m-d');
										}else{
											$tglganti = date('Y-m-d', strtotime($datakb['TanggalGanti']));
										}	
									?>
									<input type="text" name="tgl_ganti" class="form-control inputan datepicker2" value="<?php echo $tglganti;?>">
									<div class="input-group-append">
										<span class="input-group-text"><span class="fa fa-calendar"></span></span>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Pencabutan Kotrasepsi</td>
					<td>
						<div class="row" style="margin-top:-10px">
							<div class="col-sm-2" style="padding:10px 15px 0px 12px">
								<SELECT name="pencabutan" class="form-control inputan">
									<option value="-" <?php if($datakb['PencabutanKontrasepsi'] == '-'){echo "SELECTED";}?>>-</option>
									<option value="Iud" <?php if($datakb['PencabutanKontrasepsi'] == 'Iud'){echo "SELECTED";}?>>Iud</option>
									<option value="Suntik" <?php if($datakb['PencabutanKontrasepsi'] == 'Suntik'){echo "SELECTED";}?>>Suntik</option>
									<option value="Pil" <?php if($datakb['PencabutanKontrasepsi'] == 'Pil'){echo "SELECTED";}?>>Pil</option>
									<option value="Implant" <?php if($datakb['PencabutanKontrasepsi'] == 'Implant'){echo "SELECTED";}?>>Implant</option>
									<option value="Mow" <?php if($datakb['PencabutanKontrasepsi'] == 'Mow'){echo "SELECTED";}?>>Mow</option>
									<option value="Mop" <?php if($datakb['PencabutanKontrasepsi'] == 'Mop'){echo "SELECTED";}?>>Mop</option>
									<option value="Kondom" <?php if($datakb['PencabutanKontrasepsi'] == 'Kondom'){echo "SELECTED";}?>>Kondom</option>
									<option value="Lainnya" <?php if($datakb['PencabutanKontrasepsi'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
								</SELECT>
							</div>
							<div class="col-sm-10" style="padding:10px 15px 0px 12px">
								<div class="input-group">
									<?php
										if($datakb['TanggalPencabutan'] == null){
											$tglcabut = date('Y-m-d');
										}else{
											$tglcabut = date('Y-m-d', strtotime($datakb['TanggalPencabutan']));
										}	
									?>
									<input type="text" name="tgl_cabut" class="form-control inputan datepicker2" value="<?php echo $tglcabut;?>">
									<div class="input-group-append">
										<span class="input-group-text"><span class="fa fa-calendar"></span></span>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Tanggal Kembali</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datakb['TanggalKembali'] == null){
									$tglkembali = date('Y-m-d');
								}else{
									$tglkembali = date('Y-m-d', strtotime($datakb['TanggalKembali']));
								}	
							?>
							<input type="text" name="tgl_kembali" class="form-control inputan datepicker2" value="<?php echo $tglkembali;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
			</table>	
		</div>
	</div>
</div>