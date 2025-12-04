<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpoligizi` WHERE `IdPasienrj` = '$idpasienrj'"));
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
				<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan onfocusoutvalidation"><?php echo $datapemeriksaan['Keluhan'];?></textarea></td>
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
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $datapemeriksaan['Anamnesa'];?></textarea></td>
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
						<option value="00" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '01'){echo "SELECTED";}?>>Seafood</option>
						<option value="02" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '02'){echo "SELECTED";}?>>Gandum</option>
						<option value="03" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '03'){echo "SELECTED";}?>>Susu Sapi</option>
						<option value="04" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '04'){echo "SELECTED";}?>>Kacang-Kacangan</option>
						<option value="05" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '05'){echo "SELECTED";}?>>Makanan Lain</option>
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
						<option value="00" <?php if($datapemeriksaan['RiwayatAlergiUdara'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datapemeriksaan['RiwayatAlergiUdara'] == '01'){echo "SELECTED";}?>>Udara Panas</option>
						<option value="02" <?php if($datapemeriksaan['RiwayatAlergiUdara'] == '02'){echo "SELECTED";}?>>Udara Dingin</option>
						<option value="03" <?php if($datapemeriksaan['RiwayatAlergiUdara'] == '03'){echo "SELECTED";}?>>Udara Kotor</option>
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
						<option value="00" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '01'){echo "SELECTED";}?>>Antibiotik</option>
						<option value="02" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '02'){echo "SELECTED";}?>>Antiinflamasi</option>
						<option value="03" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '03'){echo "SELECTED";}?>>Non Steroid</option>
						<option value="04" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '04'){echo "SELECTED";}?>>Aspirin</option>
						<option value="05" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '05'){echo "SELECTED";}?>>Kortikosteroid</option>
						<option value="06" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '06'){echo "SELECTED";}?>>Insulin</option>
						<option value="07" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '07'){echo "SELECTED";}?>>Obat-Obatan Lain</option>
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
						<option value="01" <?php if($datapemeriksaan['Prognosa'] == '01'){echo "SELECTED";}?>>Sanam (Sembuh)</option>
						<option value="02" <?php if($datapemeriksaan['Prognosa'] == '02'){echo "SELECTED";}?>>Bonam (Baik)</option>
						<option value="03" <?php if($datapemeriksaan['Prognosa'] == '03'){echo "SELECTED";}?>>Malam (Buruk/Jelek)</option>
						<option value="04" <?php if($datapemeriksaan['Prognosa'] == '04'){echo "SELECTED";}?>>Dubia Ad Sanam/Bolam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
						<option value="05" <?php if($datapemeriksaan['Prognosa'] == '05'){echo "SELECTED";}?>>Dubia Ad Malam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Sekarang</td>
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $datapemeriksaan['RiwayatPenyakitSekarang'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $datapemeriksaan['RiwayatPenyakitDulu'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $datapemeriksaan['RiwayatPenyakitKeluarga'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type="text" name ="anjuran" class="form-control inputan onfocusoutvalidation" value="<?php echo $datapemeriksaan['Anjuran'];?>"></td>
			</tr>
			<tr>
				<td>Hasil Lab.</td>
				<td>
				<?php
				$str_gettbtindakandetail = mysqli_query($koneksi,"SELECT Keterangan from tbtindakanpasiendetail a join tbtindakan b on a.KodeTindakan = b.KodeTindakan where a.NoRegistrasi = '$noregistrasi'");
				if(mysqli_num_rows($str_gettbtindakandetail) > 0){
					while($dt_lab = mysqli_fetch_assoc($str_gettbtindakandetail)){
						$hasilsx []= $dt_lab['Keterangan'];
					}
					$pem_lab = " ".implode(", ",$hasilsx);
				}else{
					$pem_lab = "";
				}
				?>
					<input type="text" name ="pemeriksaanpenunjanglab" class="form-control inputan onfocusoutvalidation" value="<?php echo $datapemeriksaan['PemeriksaanHasilLab']."".$pem_lab;?>">
				</td>
			</tr>
		</table>
	</div>	
</div><br/>	
			
<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Tanda Vital & Pemeriksaan Fisik (Objektive)
				</p>
				<tr>
					<td class="col-sm-3">Keadaan Umum</td>
					<td class="col-sm-9">
						<select name="keadaanumum" class="form-control inputan">
							<option value="Baik" <?php if($datapemeriksaan['KeadaanUmum'] == 'Baik'){echo "SELECTED";}?>>Baik</option>
							<option value="Sangat Ringan" <?php if($datapemeriksaan['KeadaanUmum'] == 'Sangat Ringan'){echo "SELECTED";}?>>Sangat Ringan</option>
							<option value="Sakit Sedang" <?php if($datapemeriksaan['KeadaanUmum'] == 'Sakit Sedang'){echo "SELECTED";}?>>Sakit Sedang</option>
							<option value="Sakit Berat" <?php if($datapemeriksaan['KeadaanUmum'] == 'Sensorik Pendengaran'){echo "SELECTED";}?>>Sensorik Pendengaran</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Status Gizi</td>
					<td>
						<select name="statusgizi" class="form-control inputan" required>
							<option value="Baik" <?php if($datapemeriksaan['StatusGizi'] == 'Baik'){echo "SELECTED";}?>>Baik</option>
							<option value="Kurang" <?php if($datapemeriksaan['StatusGizi'] == 'Kurang'){echo "SELECTED";}?>>Kurang</option>
							<option value="Buruk" <?php if($datapemeriksaan['StatusGizi'] == 'Buruk'){echo "SELECTED";}?>>Buruk</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Pemeriksaan Penunjang</td>
					<td>
						<textarea type="text" name ="pemeriksaanpenunjangobj" class="form-control inputan"><?php echo strtoupper($datapemeriksaan['PemeriksaanPenunjang']);?></textarea>
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
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Antopometri
				</p>
				<tr>
					<td class="col-sm-3">Tanggal Penimbangan</td>
					<td class="col-sm-9">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TanggalPenimbangan'] == null){
									$tglpnb = date('Y-m-d');
								}else{
									$tglpnb = date('Y-m-d', strtotime($datapemeriksaan['TanggalPenimbangan']));
								}	
							?>
							<input type="text" name="tanggalpenimbangan" class="form-control inputan datepicker2" value="<?php echo $tglpnb;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Berat Badan Lahir</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="bblahir" class="form-control inputan" value="<?php if($datapemeriksaan['BeratBadanLahir'] == ''){echo '0';}else{echo $datapemeriksaan['BeratBadanLahir'];}?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">gram</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Tinggi Badan Lahir</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="pblahir" class="form-control inputan" value="<?php if($datapemeriksaan['PanjangBadanLahir'] == ''){echo '0';}else{echo $datapemeriksaan['PanjangBadanLahir'];}?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">cm</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>BBI</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="bbi" class="form-control inputan" value="<?php if($datapemeriksaan['BBI'] == ''){echo '0';}else{echo $datapemeriksaan['BBI'];}?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">gram</span>
							</div>
						</div>
					</td>
				</tr>
			</table>	

			<table class="table-judul">		
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Status Gizi
				</p>
				<tr>
					<td class="col-sm-3">BB/U</td>
					<td class="col-sm-9">
						<select name="bbu" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Bbu'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Berat Badan Sangat Kurang" <?php if($datapemeriksaan['Bbu'] == 'Berat Badan Sangat Kurang'){echo "SELECTED";}?>>Berat Badan Sangat Kurang</option>
							<option value="Berat Badan Kurang" <?php if($datapemeriksaan['Bbu'] == 'Berat Badan Kurang'){echo "SELECTED";}?>>Berat Badan Kurang</option>
							<option value="Berat Badan Normal" <?php if($datapemeriksaan['Bbu'] == 'Berat Badan Normal'){echo "SELECTED";}?>>Berat Badan Normal</option>
							<option value="Resiko Berat Badan Lebih" <?php if($datapemeriksaan['Bbu'] == 'Resiko Berat Badan Lebih'){echo "SELECTED";}?>>Resiko Berat Badan Lebih</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>TB/U</td>
					<td>
						<select name="tbu" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Tbu'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Normal" <?php if($datapemeriksaan['Tbu'] == 'Normal'){echo "SELECTED";}?>>Normal</option>
							<option value="Pendek" <?php if($datapemeriksaan['Tbu'] == 'Pendek'){echo "SELECTED";}?>>Pendek</option>
							<option value="Sangat Pendek" <?php if($datapemeriksaan['Tbu'] == 'Sangat Pendek'){echo "SELECTED";}?>>Sangat Pendek</option>
							<option value="Tinggi" <?php if($datapemeriksaan['Tbu'] == 'Tinggi'){echo "SELECTED";}?>>Tinggi</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>BB/TB</td>
					<td>
						<select name="bbtb" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Bbtb'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Gizi Buruk" <?php if($datapemeriksaan['Bbtb'] == 'Gizi Buruk'){echo "SELECTED";}?>>Gizi Buruk</option>
							<option value="Gizi Kurang" <?php if($datapemeriksaan['Bbtb'] == 'Gizi Kurang'){echo "SELECTED";}?>>Gizi Kurang</option>
							<option value="Gizi Baik" <?php if($datapemeriksaan['Bbtb'] == 'Gizi Baik'){echo "SELECTED";}?>>Gizi Baik</option>
							<option value="Beresiko Gizi Lebih" <?php if($datapemeriksaan['Bbtb'] == 'Beresiko Gizi Lebih'){echo "SELECTED";}?>>Beresiko Gizi Lebih</option>
							<option value="Gizi Lebih" <?php if($datapemeriksaan['Bbtb'] == 'Gizi Lebih'){echo "SELECTED";}?>>Gizi Lebih</option>
							<option value="Obesitas" <?php if($datapemeriksaan['Bbtb'] == 'Obesitas'){echo "SELECTED";}?>>Obesitas</option>
							
						</select>
					</td>
				</tr>
				<tr>
					<td>IMT/U</td>
					<td>
						<select name="imtu" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Imtu'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Gizi Buruk" <?php if($datapemeriksaan['Imtu'] == 'Gizi Buruk'){echo "SELECTED";}?>>Gizi Buruk</option>
							<option value="Gizi Kurang" <?php if($datapemeriksaan['Imtu'] == 'Gizi Kurang'){echo "SELECTED";}?>>Gizi Kurang</option>
							<option value="Gizi Baik" <?php if($datapemeriksaan['Imtu'] == 'Gizi Baik'){echo "SELECTED";}?>>Gizi Baik</option>
							<option value="Gizi Lebih" <?php if($datapemeriksaan['Imtu'] == 'Gizi Lebih'){echo "SELECTED";}?>>Gizi Lebih</option>
							<option value="Obesitas" <?php if($datapemeriksaan['Imtu'] == 'Obesitas'){echo "SELECTED";}?>>Obesitas</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>IMT</td>
					<td>
						<select name="imt" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Imt'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Normal" <?php if($datapemeriksaan['Imt'] == 'Normal'){echo "SELECTED";}?>>Normal</option>
							<option value="Gemuk Tingkat Ringan" <?php if($datapemeriksaan['Imt'] == 'Gemuk Tingkat Ringan'){echo "SELECTED";}?>>Gemuk Tingkat Ringan</option>
							<option value="Gemuk Tingkat Berat" <?php if($datapemeriksaan['Imt'] == 'Gemuk Tingkat Berat'){echo "SELECTED";}?>>Gemuk Tingkat Berat</option>
							<option value="Kurus Tingkat Ringan" <?php if($datapemeriksaan['Imt'] == 'Kurus Tingkat Ringan'){echo "SELECTED";}?>>Kurus Tingkat Ringan</option>
							<option value="Kurus Tingkat Berat" <?php if($datapemeriksaan['Imt'] == 'Kurus Tingkat Berat'){echo "SELECTED";}?>>Kurus Tingkat Berat</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>BGM</td>
					<td>
						<select name="bgm" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Bgm'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Ya" <?php if($datapemeriksaan['Bgm'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							<option value="Tidak" <?php if($datapemeriksaan['Bgm'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</select>
					</td>
				</tr>
				<!--<tr>
					<td>Status Gizi</td>
					<td>
						<select name="statusgizi" class="form-control inputan">
							<option value="Normal" <?php //if($datapemeriksaan['StatusGizi'] == 'Normal'){echo "SELECTED";}?>>Normal</option>
							<option value="Kurang" <?php //if($datapemeriksaan['StatusGizi'] == 'Kurang'){echo "SELECTED";}?>>Kurang</option>
							<option value="Lebih" <?php //if($datapemeriksaan['StatusGizi'] == 'Lebih'){echo "SELECTED";}?>>Lebih</option>
						</select>
					</td>
				</tr>-->
				<tr>
					<td>Tindakan</td>
					<td>
						<select name="tindakangizi" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['TindakanGizi'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Konsultasi" <?php if($datapemeriksaan['TindakanGizi'] == 'Konsultasi'){echo "SELECTED";}?>>Konsultasi</option>
							<option value="Penimbangan" <?php if($datapemeriksaan['TindakanGizi'] == 'Penimbangan'){echo "SELECTED";}?>>Penimbangan</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Asi</td>
					<td>
						<select name="asi" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Asi'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Y" <?php if($datapemeriksaan['Asi'] == 'Y'){echo "SELECTED";}?>>Ya</option>
							<option value="T" <?php if($datapemeriksaan['Asi'] == 'T'){echo "SELECTED";}?>>Tidak</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Imd</td>
					<td>
						<select name="imd" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Imd'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Ya" <?php if($datapemeriksaan['Imd'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							<option value="Tidak" <?php if($datapemeriksaan['Imd'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">NTOB</td>
					<td class="col-sm-9">
						<select name="ntob" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Ntob'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="N" <?php if($datapemeriksaan['Ntob'] == 'N'){echo "SELECTED";}?>>N</option>
							<option value="T" <?php if($datapemeriksaan['Ntob'] == 'T'){echo "SELECTED";}?>>T</option>
							<option value="O" <?php if($datapemeriksaan['Ntob'] == 'O'){echo "SELECTED";}?>>O</option>
							<option value="B" <?php if($datapemeriksaan['Ntob'] == 'B'){echo "SELECTED";}?>>B</option>
							<option value="D" <?php if($datapemeriksaan['Ntob'] == 'D'){echo "SELECTED";}?>>D</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td>
						<textarea type="text" name="keterangangizi" style="text-transform: uppercase;" class="form-control inputan" placeholder="Misal : Anak ke 1"><?php echo $datapemeriksaan['TerapiDiet'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>LILA/LIKA</td>
					<td>
						<input type ="text" name ="lilalika" class="form-control inputan" value="<?php echo $datapemeriksaan['LilaLika'];?>" placeholder="Misal: Nilai < 23.5cm (KEK)"></text>
					</td>
				</tr>
				<tr>
					<td>Usia Kehamilan</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="usiakehamilan" class="form-control inputan" value="<?php echo $datapemeriksaan['UsiaKehamilan'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">Minggu</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Lab (HB)</td>
					<td>
						<input type="text" name="labhb" style="text-transform: uppercase;" class="form-control inputan" value="<?php echo $datapemeriksaan['LabHb'];?>">
					</td>
				</tr>
				<tr>
					<td>Riwayat Gizi</td>
					<td>
						<textarea type="text" name="riwayatgizi" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['RiwayatGizi'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Dianosa Gizi</td>
					<td>
						<textarea type="text" name="diagnosagizi" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['DiagnosaGizi'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Terapi Diet</td>
					<td>
						<textarea type="text" name="terapidiet" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['TerapiDiet'];?></textarea>
					</td>
				</tr>
			</table><br/>
			
			<table class="table-judul">		
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Kebiasaan Makan Utama
				</p>
				<tr>
					<td class="col-sm-3">Makan Pagi</td>
					<td class="col-sm-9">
						<div class="radio">
							<label><input type="radio" name="makanpagi" value="false" checked>Ya</label>
							<label> <input type="radio" name="makanpagi" value="true">Tidak</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>Makan Siang</td>
					<td>
						<div class="radio">
							<label><input type="radio" name="makansiang" value="false" checked>Ya</label>
							<label> <input type="radio" name="makansiang" value="true">Tidak</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>Makan Malam</td>
					<td>
						<div class="radio">
							<label><input type="radio" name="makanmalam" value="false" checked>Ya</label>
							<label> <input type="radio" name="makanmalam" value="true">Tidak</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>Sering Ngemil</td>
					<td>
						<div class="radio">
							<label><input type="radio" name="seringngemil" value="false" checked>Ya</label>
							<label> <input type="radio" name="seringngemil" value="true">Tidak</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>Jika Ya, berapa kali sehari</td>
					<td>
						<input type="text" name="jikangemil" style="text-transform: uppercase;" class="form-control inputan" value="<?php echo $datapemeriksaan['BerapaKali'];?>">
					</td>
				</tr>
				<tr>
					<td>Alergi Makanan</td>
					<td>
						<textarea type="text" name="alergimakanan" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['AlergiMakanan'];?></textarea>
					</td>
				</tr>
			</table>
			
			<table class="table-judul">		
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Bahan Makanan yang Biasa di Konsumsi
				</p>
				<tr>
					<td class="col-sm-3">Makanan Pokok</td>
					<td class="col-sm-9">
						<textarea type="text" name="makananpokok" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['MakananPokok'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Lauk Hewani</td>
					<td>
						<textarea type="text" name="laukhewani" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['LaukHewani'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Lauk Nabati</td>
					<td>
						<textarea type="text" name="lauknabati" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['LaukNabati'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Sayur Sayuran</td>
					<td>
						<textarea type="text" name="sayur" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['Sayuran'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Buah Buahan</td>
					<td>
						<textarea type="text" name="buah" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['Buahan'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Minuman</td>
					<td>
						<textarea type="text" name="minuman" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['Munuman'];?></textarea>
					</td>
				</tr>
			</table><br/>
			
			<table class="table-judul">		
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Total Kebutuhan Pasien Perhari
				</p>
				<tr>
					<td class="col-sm-3">Energi</td>
					<td class="col-sm-9">
						<div class="input-group">
							<input type ="text" name ="energi" class="form-control inputan" value="<?php echo $datapemeriksaan['Energi'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">Kkal</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Protein</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="protein" class="form-control inputan" value="<?php echo $datapemeriksaan['Protein'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">gram</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Lemak</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="lemak" class="form-control inputan" value="<?php echo $datapemeriksaan['Lemak'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">gram</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Karbohidrat</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="karbohidrat" class="form-control inputan" value="<?php echo $datapemeriksaan['Karbohidrat'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">gram</span>
							</div>
						</div>
					</td>
				</tr>
			</table><br/>
			
			<table class="table-judul">		
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Recall 24 Jam
				</p>
				<tr>
					<td class="col-sm-3">Makan Pagi</td>
					<td class="col-sm-9">
						<textarea type="text" name="makanpagirecall" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['MakanPagiRecall'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Snack Pagi</td>
					<td>
						<textarea type="text" name="snackpagirecall" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['SnackPagiRecall'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Makan Siang</td>
					<td>
						<textarea type="text" name="makansiangrecall" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['MakanSiangRecall'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Snack Sore</td>
					<td>
						<textarea type="text" name="snacksorerecall" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['SnackSoreRecall'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Makan Sore/Malam</td>
					<td>
						<textarea type="text" name="makansoremalamrecall" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['MakanSoreRecall'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>Snack Malam</td>
					<td>
						<textarea type="text" name="snackmalamrecall" style="text-transform: uppercase;" class="form-control inputan"><?php echo $datapemeriksaan['SnackMalamRecall'];?></textarea>
					</td>
				</tr>
			</table><br/>
			
			<table class="table-judul">		
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Hasil Recall 24 Jam
				</p>
				<tr>
					<td class="col-sm-3">Energi</td>
					<td class="col-sm-9">
						<div class="input-group">
							<input type ="text" name ="energirecall" class="form-control inputan" value="<?php echo $datapemeriksaan['EnergiRecall'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">Kkal</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Protein</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="proteinrecall" class="form-control inputan" value="<?php echo $datapemeriksaan['ProteinRecall'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">gram</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Lemak</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="lemakrecall" class="form-control inputan" value="<?php echo $datapemeriksaan['LemakRecall'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">gram</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Karbohidrat</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="karbohidratrecall" class="form-control inputan" value="<?php echo $datapemeriksaan['KarbohidratRecall'];?>"></text>
							<div class="input-group-append">
								<span class="input-group-text">gram</span>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>