<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpolikia` WHERE `NoPemeriksaan` = '$noregistrasi'"));
?>

<div class="row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-2">Status Pemeriksaan</td>
				<td class="col-sm-10">
					<select name="sts_pemeriksaan_kia" class="form-control inputan sts_pemeriksaan_kia">
						<option value="Kehamilan" <?php if($datapemeriksaan['StatusPemeriksaanKia'] == 'Kehamilan'){echo "SELECTED";}?>>Kehamilan</option>
						<option value="Non Kehamilan" <?php if($datapemeriksaan['StatusPemeriksaanKia'] == 'Non Kehamilan'){echo "SELECTED";}?>>Non Kehamilan</option>
						<!-- <option value="Nifas" <?php if($datapemeriksaan['StatusPemeriksaanKia'] == 'Nifas'){echo "SELECTED";}?>>Nifas</option>
						<option value="Catin" <?php if($datapemeriksaan['StatusPemeriksaanKia'] == 'Catin'){echo "SELECTED";}?>>Catin</option>
						<option value="Persalinan" <?php if($datapemeriksaan['StatusPemeriksaanKia'] == 'Persalinan'){echo "SELECTED";}?>>Persalinan</option> -->
					</select>
				</td>
			</tr>
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
				<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan"><?php echo $datapemeriksaan['Keluhan'];?></textarea></td>
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
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan"><?php echo $datapemeriksaan['Anamnesa'];?></textarea></td>
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
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control inputan"><?php echo $datapemeriksaan['RiwayatPenyakitSekarang'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control inputan"><?php echo $datapemeriksaan['RiwayatPenyakitDulu'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control inputan"><?php echo $datapemeriksaan['RiwayatPenyakitKeluarga'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type ="text" name ="anjuran" style="text-transform: uppercase;" class="form-control inputan" maxlength = "50" value = "<?php echo $datapemeriksaan['Anjuran'];?>" ></text></td>
			</tr>
			<tr>
				<td>Hasil Lab.</td>
				<td>
				<?php
				$str_gettbtindakandetail = mysqli_query($koneksi,"SELECT Keterangan from $tbtindakanpasien a join tbtindakan b on a.IdTindakan = b.IdTindakan where a.NoRegistrasi = '$noregistrasi'");
				if(mysqli_num_rows($str_gettbtindakandetail) > 0){
					while($dt_lab = mysqli_fetch_assoc($str_gettbtindakandetail)){
						$hasilsx []= $dt_lab['Keterangan'];
					}
					$pem_lab = " ".implode(", ",$hasilsx);
				}else{
					$pem_lab = "";
				}
				?>
					<input type="text" name ="pemeriksaanpenunjanglab" class="form-control inputan" value="<?php echo $datagizi['PemeriksaanHasilLab']."".$pem_lab;?>">
				</td>
			</tr>
		</table>
	</div>	
</div>
<br/>
<div class="row nonkehamilan_tmp">
	<div class="col-sm-12">
		<table class="table">
			<div style="margin-left: 8px"><h4><b>FUNGSI REPRODUKSI</b></h4></div><hr>
			<tr>
				<td class="col-sm-2">G-P-A</td>
				<td class="col-sm-10">
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
				<td>HPHT</td>
				<td>
					<?php
						if($datapemeriksaan['Hpht'] == null){
							$hphts = date('Y-m-d');
						}else{
							$hphts = date('Y-m-d', strtotime($datapemeriksaan['Hpht']));
						}	
					?>
					<input type ="text" name ="hpht_kia" style="text-transform: uppercase;" class="form-control inputan datepicker2" maxlength = "50" value = "<?php echo $hphts;?>" ></text>
				</td>
			</tr>
			<tr>
				<td>Faktor Resiko</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="faktorresiko_kia" class="form-control inputan">
								<option value="Normal" <?php if($datapemeriksaan['FaktorResiko'] == 'Normal'){echo "SELECTED";}?>>Normal</option>
								<option value="Faktor Resiko" <?php if($datapemeriksaan['FaktorResiko'] == 'Faktor Resiko'){echo "SELECTED";}?>>Faktor Resiko</option>
								<option value="Resiko Tinggi" <?php if($datapemeriksaan['FaktorResiko'] == 'Resiko Tinggi'){echo "SELECTED";}?>>Resiko Tinggi</option>
							</select>
							<span class="input-group-text">Pilih</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Jelaskan</td>
				<td class="col-sm-10"><textarea name="faktorresikodesc_kia" style="text-transform: uppercase;" class="form-control inputan anamnesa" maxlength = "50" placeholder="Jelaskan jika faktor resiko"><?php echo $datapemeriksaan['FaktorResikoDesc'];?></textarea></td>
			</tr>
		</table>
	</div>
</div><br/>
<div class="row nonkehamilan_tmp">
	<div class="col-sm-12">
		<table class="table">
			<div style="margin-left: 8px"><h4><b>PEMERIKSAAN KEHAMILAN</b></h4></div><hr>
			<tr>
				<td >Nomor Kohort</td>
				<td class="col-sm-10">
					<div class="input-group">
						<input type="text" name="nokohort_kia" class="form-control inputan" maxlength = "30" value = "<?php echo $datapemeriksaan['NoKohort'];?>" placeholder="Maks. 30 Digit"></text>
						<div class="input-group-append">
							<span class="input-group-text">Wajib diisi</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Nomor Resti</td>
				<td class="col-sm-10">
					<div class="input-group">
						<input type="text" name="noresti_kia" class="form-control inputan" maxlength = "30" value = "<?php echo $datapemeriksaan['NoResti'];?>" placeholder="Maks. 30 Digit"></text>
						<div class="input-group-append">
							<span class="input-group-text">Wajib diisi</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Usia Kehamilan</td>
				<td class="col-sm-10">
					<div class="input-group">
						<input type="text" name="usiakehamilan_kia" class="form-control inputan" maxlength = "2" value = "<?php echo $datapemeriksaan['UsiaKehamilan'];?>" placeholder="Maks. 2 Digit"></text>
						<div class="input-group-append">
							<span class="input-group-text">Minggu</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Trimester ke</td>
				<td>
					<select name="trimester_kia" class="form-control inputan">
						<option value="1" <?php if($datapemeriksaan['Trimester'] == '1'){echo "SELECTED";}?>>Satu</option>
						<option value="2" <?php if($datapemeriksaan['Trimester'] == '2'){echo "SELECTED";}?>>Dua</option>
						<option value="3" <?php if($datapemeriksaan['Trimester'] == '3'){echo "SELECTED";}?>>Tiga</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>TFU</td>
				<td>
					<div class="input-group">
						<input type="text" name="tfu_kia" class="form-control inputan" maxlength = "5" value = "<?php echo $datapemeriksaan['Tfu'];?>" placeholder="Maks. 5 Digit"></text>
						<div class="input-group-append">
							<span class="input-group-text">Cm</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>LILA</td>
				<td>
					<div class="input-group">
						<input type="text" name="lila_kia" class="form-control inputan" maxlength = "5" value = "<?php echo $datapemeriksaan['Lila'];?>" placeholder="Maks. 5 Digit"></text>
						<div class="input-group-append">
							<span class="input-group-text">Cm</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Status Gizi</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="statusgizi_kia" class="form-control inputan">
								<option value="N" <?php if($datapemeriksaan['StatusGizi'] == 'N'){echo "SELECTED";}?>>Normal</option>
								<option value="M" <?php if($datapemeriksaan['StatusGizi'] == 'M'){echo "SELECTED";}?>>Malnutrisi</option>
								<option value="KEK" <?php if($datapemeriksaan['StatusGizi'] == 'KEK'){echo "SELECTED";}?>>KEK</option>
							</select>
							<span class="input-group-text">Pilih</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Refleks Patella</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="reflekspatella_kia" class="form-control inputan">
								<option value="Positif" <?php if($datapemeriksaan['RefleksPatella'] == 'Positif'){echo "SELECTED";}?>>Positif</option>
								<option value="Negatif" <?php if($datapemeriksaan['RefleksPatella'] == 'Negatif'){echo "SELECTED";}?>>Negatif</option>
							</select>
							<span class="input-group-text">Pilih</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Riwayat SC</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="riwayatsc_kia" class="form-control inputan">
								<option value="Tidak" <?php if($datapemeriksaan['RiwayatSc'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
								<option value="Ya" <?php if($datapemeriksaan['RiwayatSc'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							</select>
							<span class="input-group-text">Pilih</span>
						</div>	
					</div>	
				</td>
			</tr>
			<tr>
				<td>TT</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="tt_kia" class="form-control inputan tt_kia">
								<option value="">--Pilih--</option>
								<option value="TT1" <?php if($datapemeriksaan['TT'] == 'TT1'){echo "SELECTED";}?>>TT1</option>
								<option value="BW TT2" <?php if($datapemeriksaan['TT'] == 'BW TT2'){echo "SELECTED";}?>>BW TT2</option>
								<option value="TT2" <?php if($datapemeriksaan['TT'] == 'TT2'){echo "SELECTED";}?>>TT2</option>
								<option value="BW TT3" <?php if($datapemeriksaan['TT'] == 'BW TT3'){echo "SELECTED";}?>>BW TT3</option>
								<option value="TT3" <?php if($datapemeriksaan['TT'] == 'TT3'){echo "SELECTED";}?>>TT3</option>
								<option value="BW TT4" <?php if($datapemeriksaan['TT'] == 'BW TT4'){echo "SELECTED";}?>>BW TT4</option>
								<option value="TT4" <?php if($datapemeriksaan['TT'] == 'TT4'){echo "SELECTED";}?>>TT4</option>
								<option value="BW TT5" <?php if($datapemeriksaan['TT'] == 'BW TT5'){echo "SELECTED";}?>>BW TT5</option>
								<option value="TT5" <?php if($datapemeriksaan['TT'] == 'TT5'){echo "SELECTED";}?>>TT5</option>
								<option value="TT LENGKAP" <?php if($datapemeriksaan['TT'] == 'TT LENGKAP'){echo "SELECTED";}?>>TT LENGKAP</option>
								<option value="TT BOOSTER" <?php if($datapemeriksaan['TT'] == 'TT BOOSTER'){echo "SELECTED";}?>>TT BOOSTER</option>
							</select>
							<span class="input-group-text">LB-3</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>FE</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="fe_kia" class="form-control inputan fe_kia">
								<option value="">--Pilih--</option>
								<option value="FE 1" <?php if($datapemeriksaan['FE'] == 'FE 1'){echo "SELECTED";}?>>FE 1</option>
								<option value="FE 2" <?php if($datapemeriksaan['FE'] == 'FE 2'){echo "SELECTED";}?>>FE 2</option>
								<option value="FE 3" <?php if($datapemeriksaan['FE'] == 'FE 3'){echo "SELECTED";}?>>FE 3</option>
								<option value="FE 4" <?php if($datapemeriksaan['FE'] == 'FE 4'){echo "SELECTED";}?>>FE 4</option>
								<option value="FE 5" <?php if($datapemeriksaan['FE'] == 'FE 5'){echo "SELECTED";}?>>FE 5</option>
								<option value="FE BOOSTER" <?php if($datapemeriksaan['FE'] == 'FE BOOSTER'){echo "SELECTED";}?>>FE BOOSTER</option>
								<option value="BELUM" <?php if($datapemeriksaan['FE'] == 'BELUM'){echo "SELECTED";}?>>BELUM</option>
							</select>
							<span class="input-group-text">LB-3</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Kunj.Kehamilan</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="kunjungan_kehamilan" class="form-control inputan kunjungan_kehamilan">
								<option value="">--Pilih--</option>
								<option value="K1 Akses" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'K1 Akses'){echo "SELECTED";}?>>K1 Akses</option>
								<option value="K1 Murni" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'K1 Murni'){echo "SELECTED";}?>>K1 Murni</option>
								<option value="KU K1" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'KU K1'){echo "SELECTED";}?>>KU K1</option>
								<option value="K2" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'K2'){echo "SELECTED";}?>>K2</option>								
								<option value="KU K2" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'KU K2'){echo "SELECTED";}?>>KU K2</option>								
								<option value="K3" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'K3'){echo "SELECTED";}?>>K3</option>								
								<option value="K4" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'K4'){echo "SELECTED";}?>>K4</option>
								<option value="K4 Akses" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'K4 Akses'){echo "SELECTED";}?>>K4 Akses</option>
								<option value="KU K4" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'KU K4'){echo "SELECTED";}?>>KU K4</option>
								<option value="K1/K4" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'K1/K4'){echo "SELECTED";}?>>K1/K4</option>
								<option value="K6" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'K6'){echo "SELECTED";}?>>K6</option>
								<option value="Kontrol Ulang" <?php if($datapemeriksaan['KunjunganKehamilan'] == 'Kontrol Ulang'){echo "SELECTED";}?>>Kontrol Ulang</option>
								<option value="-" <?php if($datapemeriksaan['KunjunganKehamilan'] == '-'){echo "SELECTED";}?>>-</option>
							</select>
							<span class="input-group-text">LB-3</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Deteksi Resiko</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="deteksi_resiko" class="form-control inputan">
								<option value="-">--Pilih--</option>
								<option value="Tenaga Kesehatan" <?php if($datapemeriksaan['DeteksiResiko'] == 'Tenaga Kesehatan'){echo "SELECTED";}?>>Tenaga Kesehatan</option>
								<option value="Masyarakat" <?php if($datapemeriksaan['DeteksiResiko'] == 'Masyarakat'){echo "SELECTED";}?>>Masyarakat</option>
								<option value="-" <?php if($datapemeriksaan['DeteksiResiko'] == '-'){echo "SELECTED";}?>>-</option>
							</select>
							<span class="input-group-text">LB-3</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Komplikasi di Tangani</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="komplikasi_kia" class="form-control inputan">
								<option value="-">--Pilih--</option>
								<option value="Tertangani/Selamat" <?php if($datapemeriksaan['KomplikasiDitanganiIbuHamil'] == 'Tertangani/Selamat'){echo "SELECTED";}?>>Tertangani/Selamat</option>
								<option value="Meninggal" <?php if($datapemeriksaan['KomplikasiDitanganiIbuHamil'] == 'Meninggal'){echo "SELECTED";}?>>Meninggal</option>
								<option value="Rujuk" <?php if($datapemeriksaan['KomplikasiDitanganiIbuHamil'] == 'Rujuk'){echo "SELECTED";}?>>Rujuk</option>
							</select>
							<span class="input-group-text">LB-3</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Jika rujuk, sebutkan</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="rujuk_komplikasi" class="form-control inputan">
								<option value="-">--Pilih--</option>
								<option value="Rumah Sakit Umum" <?php if($datapemeriksaan['JikaRujuk'] == 'Rumah Sakit Umum'){echo "SELECTED";}?>>Rumah Sakit Umum</option>
								<option value="Rumah Sakit Bersalin" <?php if($datapemeriksaan['JikaRujuk'] == 'Rumah Sakit Bersalin'){echo "SELECTED";}?>>Rumah Sakit Bersalin</option>
								<option value="Puskesmas Bersalin" <?php if($datapemeriksaan['JikaRujuk'] == 'Puskesmas Bersalin'){echo "SELECTED";}?>>Puskesmas Bersalin</option>
							</select>
							<span class="input-group-text">LB-3</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>P4K</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="p4k" class="form-control inputan">
								<option value="-">--Pilih--</option>
								<option value="Ya" <?php if($datapemeriksaan['P4K'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
								<option value="Tidak" <?php if($datapemeriksaan['P4K'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
							</select>
							<span class="input-group-text">LB-3</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>USG TM 1</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="usgtm1" class="form-control inputan">
								<option value="-">--Pilih--</option>
								<option value="Ya" <?php if($datapemeriksaan['P4K'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
								<option value="Tidak" <?php if($datapemeriksaan['P4K'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
							</select>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>USG TM 3</td>
				<td>
					<div class="row" style="margin-top:-10px">
						<div class="col-sm-12 input-group" style="padding:10px 0px 0px 15px">
							<select name="usgtm3" class="form-control inputan">
								<option value="-">--Pilih--</option>
								<option value="Ya" <?php if($datapemeriksaan['P4K'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
								<option value="Tidak" <?php if($datapemeriksaan['P4K'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
							</select>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="row nonkehamilan_tmp">
	<div class="col-sm-12">
		<table class="table">
			<div style="margin-left: 8px"><h4><b>PEMERIKSAAN BAYI</b></h4><div><hr>
			<tr>
				<td class="col-sm-2">Kepala thd PAP</td>
				<td class="col-sm-10">
					<div class="col-sm-12" style="padding:10px 0px 0px 0px; margin-top:-10px">
						<select name="kepalathd_kia" class="form-control inputan">
							<option value="M" <?php if($datapemeriksaan['KepThd'] == 'M'){echo "SELECTED";}?>>Masuk</option>
							<option value="BM" <?php if($datapemeriksaan['KepThd'] == 'BM'){echo "SELECTED";}?>>Belum Masuk</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>TBJ</td>
				<td>
					<div class="input-group">
						<input type ="text" name ="tbj_kia" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Tbj'];?>" placeholder="Maks. 5 Digit">
						<span class="input-group-text">Gr</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Jumlah Janin</td>
				<td>
					<div class="col-sm-12" style="padding:10px 0px 0px 0px; margin-top:-10px">
						<select name="jumlahjanin_kia" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['JumlahJanin'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="Tungal" <?php if($datapemeriksaan['JumlahJanin'] == 'Tungal'){echo "SELECTED";}?>>Tungal</option>
							<option value="Ganda" <?php if($datapemeriksaan['JumlahJanin'] == 'Ganda'){echo "SELECTED";}?>>Ganda</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>DJJ Tunngal</td>
				<td>
					<div class="input-group">
						<input type ="text" name ="djj_kia" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['Djj'];?>" placeholder="Maks. 5 Digit">
						<span class="input-group-text">x/Menit</span>
					</div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">DJJ Ganda</td>
				<td class="col-sm-10">
					<div class="input-group">
						<input type ="text" name ="djj_kia_ganda" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['DjjGanda'];?>" placeholder="Maks. 5 Digit">
						<span class="input-group-text">x/Menit</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Presentasi</td>
				<td>
					<div class="col-sm-12" style="padding:10px 0px 0px 0px; margin-top:-10px">
						<select name="presentasi_kia" class="form-control inputan">
							<option value="Kepala" <?php if($datapemeriksaan['Presentasi'] == 'Kepala'){echo "SELECTED";}?>>Kepala</option>
							<option value="Bokong" <?php if($datapemeriksaan['Presentasi'] == 'Bokong'){echo "SELECTED";}?>>Bokong</option>
							<option value="Lintang" <?php if($datapemeriksaan['Presentasi'] == 'Lintang'){echo "SELECTED";}?>>Lintang</option>
							<option value="Balotemen" <?php if($datapemeriksaan['Presentasi'] == 'Balotemen'){echo "SELECTED";}?>>Balotemen</option>
							<option value="Belum Teraba" <?php if($datapemeriksaan['Presentasi'] == 'Belum Teraba'){echo "SELECTED";}?>>Belum Teraba</option>
							<option value="Oblig" <?php if($datapemeriksaan['Presentasi'] == 'Oblig'){echo "SELECTED";}?>>Oblig</option>
						</select>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div><br/>
<div class="row nonkehamilan_tmp">
	<div class="col-sm-12">
		<table class="table">
			<div style="margin-left: 8px"><h4><b>PELAYANAN</b></h4></div><hr>
			<tr>
				<td class="col-sm-2">Injeksi TT</td>
				<td class="col-sm-10">
					<div class="col-sm-12" style="padding:10px 0px 0px 0px; margin-top:-10px">
						<select name="injeksitt_kia" class="form-control inputan">
							<option value="Ya" <?php if($datapemeriksaan['InjeksiTT'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							<option value="Tidak" <?php if($datapemeriksaan['InjeksiTT'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>Catat di Buku KIA</td>
				<td>
					<div class="col-sm-12" style="padding:10px 0px 0px 0px; margin-top:-10px">
						<select name="buku_kia" class="form-control inputan">
							<option value="Ya" <?php if($datapemeriksaan['CatatBukuKia'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							<option value="Tidak" <?php if($datapemeriksaan['CatatBukuKia'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>Fe (tab/botol)</td>
				<td><input type ="text" name ="fetab_kia" style="text-transform: uppercase;" class="form-control inputan" maxlength = "50" value = "<?php echo $datapemeriksaan['FeTab'];?>" ></text></td>
			</tr>
		</table>	
	</div>	
</div>

<div class="row nonkehamilan_tmp">
	<div class="col-sm-12">
		<table class="table">
			<div style="margin-left: 8px"><h4><b>LABORATORIUM</b></h4></div><hr>
			<tr>
				<td class="col-sm-2">K1 Hb</td>
				<td class="col-sm-10">
					<div class="input-group">
						<input type ="text" name ="k1hb_kia" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['K1Hb'];?>" placeholder="Maks. 5 Digit">
						<span class="input-group-text">(+/-)</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>K4 Hb</td>
				<td>
					<div class="input-group">
						<input type="text" name="k4hb_kia" class="form-control inputan" maxlength = "5" value = "<?php echo $datapemeriksaan['K4Hb'];?>" placeholder="Maks. 20 Digit"></text>
						<span class="input-group-text">(+/-)</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Kunjungan Ulang Hb</td>
				<td>
					<div class="input-group">
						<input type ="text" name ="k3hb_kia" class="form-control inputan" maxlength="10" value="<?php echo $datapemeriksaan['K1Hb'];?>" placeholder="Maks. 5 Digit (Diluar K1 dan K4)">
						<span class="input-group-text">(+/-)</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Gula Darah</td>
				<td>
					<div class="input-group">
						<input type="text" name="guladarah_kia" class="form-control inputan" maxlength = "5" value = "<?php echo $datapemeriksaan['GulaDarah'];?>" placeholder="Maks. 20 Digit"></text>
						<span class="input-group-text">mg/dl</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Gula Darah Sewaktu</td>
				<td>
					<div class="input-group">
						<input type="text" name="gds_kia" class="form-control inputan" maxlength = "5" value = "<?php echo $datapemeriksaan['GulaDarahSewaktu'];?>" placeholder="Maks. 20 Digit"></text>
						<span class="input-group-text">mg/dl</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Asam Urat</td>
				<td>
					<div class="input-group">
						<input type="text" name="asamurat_kia" class="form-control inputan" maxlength = "5" value = "<?php echo $datapemeriksaan['AsamUrat'];?>" placeholder="Maks. 20 Digit"></text>
						<span class="input-group-text">mg/dl</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Gol.Darah</td>
				<td>
					<div class="input-group">
						<select name="goldarah_kia" class="form-control inputan">
							<option value="O" <?php if($datapemeriksaan['GolonganDarah'] == 'O'){echo "SELECTED";}?>>O</option>
							<option value="A" <?php if($datapemeriksaan['GolonganDarah'] == 'A'){echo "SELECTED";}?>>A</option>
							<option value="B" <?php if($datapemeriksaan['GolonganDarah'] == 'B'){echo "SELECTED";}?>>B</option>
							<option value="AB" <?php if($datapemeriksaan['GolonganDarah'] == 'AB'){echo "SELECTED";}?>>AB</option>
							<option value="-" <?php if($datapemeriksaan['GolonganDarah'] == '-'){echo "SELECTED";}?>>-</option>
						</select>
						<span class="input-group-text">Pilih</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>PP Test</td>
				<td>
					<div class="input-group">
						<select name="pptest_kia" class="form-control inputan">
							<option value="Negatif" <?php if($datapemeriksaan['PPTest'] == 'Negatif'){echo "SELECTED";}?>>Negatif</option>
							<option value="Positif" <?php if($datapemeriksaan['PPTest'] == 'Positif'){echo "SELECTED";}?>>Positif</option>
						</select>
						<span class="input-group-text">Pilih</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Malaria</td>
				<td>
					<div class="input-group">
						<select name="malaria_kia" class="form-control inputan">
							<option value="Negatif" <?php if($datapemeriksaan['Malaria'] == 'Negatif'){echo "SELECTED";}?>>Negatif</option>
							<option value="Positif" <?php if($datapemeriksaan['Malaria'] == 'Positif'){echo "SELECTED";}?>>Positif</option>
						</select>
						<span class="input-group-text">Pilih</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Protein Urin</td>
				<td>
					<div class="input-group">
						<select name="proturine_kia" class="form-control inputan">
							<option value="Negatif" <?php if($datapemeriksaan['ProteinUrin'] == 'Negatif'){echo "SELECTED";}?>>Negatif</option>
							<option value="Positif" <?php if($datapemeriksaan['ProteinUrin'] == 'Positif'){echo "SELECTED";}?>>Positif</option>
						</select>
						<span class="input-group-text">Pilih</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>HBsAg</td>
				<td>
					<div class="input-group">
						<select name="hbsag_kia" class="form-control inputan">
							<option value="Non Reaktif" <?php if($datapemeriksaan['Hbsag'] == 'Non Reaktif'){echo "SELECTED";}?>>Non Reaktif</option>
							<option value="Reaktif" <?php if($datapemeriksaan['Hbsag'] == 'Reaktif'){echo "SELECTED";}?>>Reaktif</option>
						</select>
						<span class="input-group-text">Pilih</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Sifilis</td>
				<td>
					<div class="input-group">
						<select name="sifilis_kia" class="form-control inputan">
							<option value="Non Reaktif" <?php if($datapemeriksaan['Sifilis'] == 'Non Reaktif'){echo "SELECTED";}?>>Non Reaktif</option>
							<option value="Reaktif" <?php if($datapemeriksaan['Sifilis'] == 'Reaktif'){echo "SELECTED";}?>>Reaktif</option>
						</select>
						<span class="input-group-text">Pilih</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>HIV</td>
				<td>
					<div class="input-group">
						<select name="hiv_kia" class="form-control inputan">
							<option value="Non Reaktif" <?php if($datapemeriksaan['Hiv'] == 'Non Reaktif'){echo "SELECTED";}?>>Non Reaktif</option>
							<option value="Reaktif" <?php if($datapemeriksaan['Hiv'] == 'Reaktif'){echo "SELECTED";}?>>Reaktif</option>
						</select>
						<span class="input-group-text">Pilih</span>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
