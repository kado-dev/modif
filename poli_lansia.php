<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"select * from `$tbpolilansia` where `NoPemeriksaan` = '$noregistrasi'"));

	// vital sign
	$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
	$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul">
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
				<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan onfocusoutvalidation"><?php echo $dtvs['Keluhan'];?></textarea></td>
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
				<td class="col-sm-9"><textarea name="anamnesa" class="form-control inputan onfocusoutvalidation anamnesa"><?php echo $dtvs['Anamnesa'];?></textarea></td>
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
						<option value="00" <?php if($dataumum['RiwayatAlergiMakanan'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($dataumum['RiwayatAlergiMakanan'] == '01'){echo "SELECTED";}?>>Seafood</option>
						<option value="02" <?php if($dataumum['RiwayatAlergiMakanan'] == '02'){echo "SELECTED";}?>>Gandum</option>
						<option value="03" <?php if($dataumum['RiwayatAlergiMakanan'] == '03'){echo "SELECTED";}?>>Susu Sapi</option>
						<option value="04" <?php if($dataumum['RiwayatAlergiMakanan'] == '04'){echo "SELECTED";}?>>Kacang-Kacangan</option>
						<option value="05" <?php if($dataumum['RiwayatAlergiMakanan'] == '05'){echo "SELECTED";}?>>Makanan Lain</option>
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
						<option value="00" <?php if($dataumum['RiwayatAlergiUdara'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($dataumum['RiwayatAlergiUdara'] == '01'){echo "SELECTED";}?>>Udara Panas</option>
						<option value="02" <?php if($dataumum['RiwayatAlergiUdara'] == '02'){echo "SELECTED";}?>>Udara Dingin</option>
						<option value="03" <?php if($dataumum['RiwayatAlergiUdara'] == '03'){echo "SELECTED";}?>>Udara Kotor</option>
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
						<option value="00" <?php if($dataumum['RiwayatAlergiObat'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($dataumum['RiwayatAlergiObat'] == '01'){echo "SELECTED";}?>>Antibiotik</option>
						<option value="02" <?php if($dataumum['RiwayatAlergiObat'] == '02'){echo "SELECTED";}?>>Antiinflamasi</option>
						<option value="03" <?php if($dataumum['RiwayatAlergiObat'] == '03'){echo "SELECTED";}?>>Non Steroid</option>
						<option value="04" <?php if($dataumum['RiwayatAlergiObat'] == '04'){echo "SELECTED";}?>>Aspirin</option>
						<option value="05" <?php if($dataumum['RiwayatAlergiObat'] == '05'){echo "SELECTED";}?>>Kortikosteroid</option>
						<option value="06" <?php if($dataumum['RiwayatAlergiObat'] == '06'){echo "SELECTED";}?>>Insulin</option>
						<option value="07" <?php if($dataumum['RiwayatAlergiObat'] == '07'){echo "SELECTED";}?>>Obat-Obatan Lain</option>
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
						<option value="01" <?php if($dataumum['Prognosa'] == '01'){echo "SELECTED";}?>>Sanam (Sembuh)</option>
						<option value="02" <?php if($dataumum['Prognosa'] == '02'){echo "SELECTED";}?>>Bonam (Baik)</option>
						<option value="03" <?php if($dataumum['Prognosa'] == '03'){echo "SELECTED";}?>>Malam (Buruk/Jelek)</option>
						<option value="04" <?php if($dataumum['Prognosa'] == '04'){echo "SELECTED";}?>>Dubia Ad Sanam/Bolam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
						<option value="05" <?php if($dataumum['Prognosa'] == '05'){echo "SELECTED";}?>>Dubia Ad Malam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Sekarang</td>
				<?php if($datapemeriksaan['RiwayatPenyakitSekarang'] != ''){ $riwayatsekarang = $datapemeriksaan['RiwayatPenyakitSekarang']; }else{ $riwayatsekarang = "Tidak Ada"; } ?>
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $riwayatsekarang;?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<?php if($datapemeriksaan['RiwayatPenyakitDulu'] != ''){ $riwayatterdahulu = $datapemeriksaan['RiwayatPenyakitDulu']; }else{ $riwayatterdahulu = "Tidak Ada"; } ?>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $riwayatterdahulu;?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<?php if($datapemeriksaan['RiwayatPenyakitKeluarga'] != ''){ $riwayatkeluarga = $datapemeriksaan['RiwayatPenyakitKeluarga']; }else{ $riwayatkeluarga = "Tidak Ada"; } ?>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $riwayatkeluarga;?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<?php if($datapemeriksaan['Anjuran'] != ''){ $anjuran = $datapemeriksaan['Anjuran']; }else{ $anjuran = "Tidak Ada"; } ?>
				<td><input type="text" name ="anjuran" class="form-control inputan onfocusoutvalidation" value="<?php echo $anjuran;?>"></td>
			</tr>
			<tr>
				<td>Faktor Resiko Lainnya</td>
				<td>
					<?php
						$arrfaktoresikolain = explode(",",$datapemeriksaan['PemeriksaanPenunjang']);
					?>
					<div class="row">
						<div class="col-md-4">
							<label><input type="checkbox" name="faktoresikolain[]" value="Apakah Merokok" <?php if(in_array("Apakah Merokok", $arrfaktoresikolain)){echo "CHECKED";}?>> Apakah Merokok</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Riwayat Alergi Obat" <?php if(in_array("Riwayat Alergi Obat", $arrfaktoresikolain)){echo "CHECKED";}?>> Riwayat Alergi Obat</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Riwayat Asma" <?php if(in_array("Riwayat Asma", $arrfaktoresikolain)){echo "CHECKED";}?>> Riwayat Asma</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Makan Sayur & Buah" <?php if(in_array("Makan Sayur & Buah", $arrfaktoresikolain)){echo "CHECKED";}?>> Makan Sayur & Buah</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Minum Alkohol" <?php if(in_array("Minum Alkohol", $arrfaktoresikolain)){echo "CHECKED";}?>> Minum Alkohol</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Aktifitas Fisik" <?php if(in_array("Aktifitas Fisik", $arrfaktoresikolain)){echo "CHECKED";}?>> Aktifitas Fisik</label><br/>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>	
</div><br/>
<div class = "row mt-3">
	<div class="col-sm-12">
		<div class="table-responsive">			
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">Pemeriksaan Lansia</p>
				<tr>
					<td class="col-sm-2">Mempunyai KMS</td>
					<td class="col-sm-10">
						<select name="kms" class="form-control inputan">
							<option value="YA" <?php if($datapemeriksaan['MempunyaiKms'] == 'YA'){echo "SELECTED";}?>>YA</option>
							<option value="TIDAK" <?php if($datapemeriksaan['MempunyaiKms'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Kemandirian</td>
					<td>
						<div class="input-group">
							<select name="kemandirian" class="form-control inputan">
								<option value="A" <?php if($datapemeriksaan['Kemandirian'] == 'A'){echo "SELECTED";}?>>ADL</option>
								<option value="B" <?php if($datapemeriksaan['Kemandirian'] == 'B'){echo "SELECTED";}?>>BALT</option>
								<option value="C" <?php if($datapemeriksaan['Kemandirian'] == 'C'){echo "SELECTED";}?>>CONG</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Gangguan Emosional</td>
					<td>
						<div class="input-group">
							<select name="emosional" class="form-control inputan">
								<option value="N" <?php if($datapemeriksaan['GangguanEmosional'] == 'N'){echo "SELECTED";}?>>NORMAL</option>
								<option value="R" <?php if($datapemeriksaan['GangguanEmosional'] == 'R'){echo "SELECTED";}?>>RINGAN</option>
								<option value="S" <?php if($datapemeriksaan['GangguanEmosional'] == 'S'){echo "SELECTED";}?>>SEDANG</option>
								<option value="B" <?php if($datapemeriksaan['GangguanEmosional'] == 'B'){echo "SELECTED";}?>>BERAT</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>IMT</td>
					<td>
						<div class="input-group">
							<select name="statusimt" class="form-control inputan statusimt">
								<option value="N" <?php if($datapemeriksaan['IMT'] == 'N'){echo "SELECTED";}?>>NORMAL</option>
								<option value="L" <?php if($datapemeriksaan['IMT'] == 'L'){echo "SELECTED";}?>>LEBIH</option>
								<option value="K" <?php if($datapemeriksaan['IMT'] == 'K'){echo "SELECTED";}?>>KURANG</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Tekanan Darah</td>
					<td>
						<div class="input-group">
							<select name="tekanandarahlansia" class="form-control inputan">
								<option value="N" <?php if($datapemeriksaan['StatusTekananDarah'] == 'N'){echo "SELECTED";}?>>NORMAL</option>
								<option value="T" <?php if($datapemeriksaan['StatusTekananDarah'] == 'T'){echo "SELECTED";}?>>TINGGI</option>
								<option value="R" <?php if($datapemeriksaan['StatusTekananDarah'] == 'R'){echo "SELECTED";}?>>RENDAH</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Faktor Resiko</td>
					<td>
						<select name="faktorresiko" class="form-control inputan">
							<option value="N" <?php if($datapemeriksaan['FaktorResiko'] == 'N'){echo "SELECTED";}?>>NORMAL</option>
							<option value="R" <?php if($datapemeriksaan['FaktorResiko'] == 'R'){echo "SELECTED";}?>>RINGAN</option>
							<option value="S" <?php if($datapemeriksaan['FaktorResiko'] == 'S'){echo "SELECTED";}?>>SEDANG</option>
							<option value="B" <?php if($datapemeriksaan['FaktorResiko'] == 'B'){echo "SELECTED";}?>>BERAT</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Riwayat Penyakit (LB)</td>
					<td>
						<?php $riwayat = explode(',',$datapemeriksaan['RiwayatPenyakit']);?>
						<label><input type="checkbox" name="riwayat_penyakit[]" value="Hb Kurang" <?php if (in_array("Hb Kurang", $riwayat)) {echo "checked";}?>> Hb Kurang</label><br/>
						<label><input type="checkbox" name="riwayat_penyakit[]" value="Kolesterol Tinggi" <?php if (in_array("Kolesterol Tinggi", $riwayat)) {echo "checked";}?>> Kolesterol Tinggi</label><br/>
						<label><input type="checkbox" name="riwayat_penyakit[]" value="DM" <?php if (in_array("DM", $riwayat)) {echo "checked";}?>> DM</label><br/>
						<label><input type="checkbox" name="riwayat_penyakit[]" value="As.Urat Tinggi" <?php if (in_array("As.Urat Tinggi", $riwayat)) {echo "checked";}?>> As.Urat Tinggi</label><br/>
						<label><input type="checkbox" name="riwayat_penyakit[]" value="Ggn.Ginjal" <?php if (in_array("Ggn.Ginjal", $riwayat)) {echo "checked";}?>> Ggn.Ginjal</label><br/>
						<label><input type="checkbox" name="riwayat_penyakit[]" value="Ggn.Kognitif" <?php if (in_array("Ggn.Kognitif", $riwayat)) {echo "checked";}?>> Ggn.Kognitif</label><br/>
						<label><input type="checkbox" name="riwayat_penyakit[]" value="Ggn.Penglihatan" <?php if (in_array("Ggn.Penglihatan", $riwayat)) {echo "checked";}?>> Ggn.Penglihatan</label><br/>
						<label><input type="checkbox" name="riwayat_penyakit[]" value="Ggn.Pendengaran" <?php if (in_array("Ggn.Pendengaran", $riwayat)) {echo "checked";}?>> Ggn.Pendengaran</label><br/>
					</td>
				</tr>
				<tr>
					<td>Kelainan</td>
					<td>
						<div class="input-group">
							<select name="kelainan" class="form-control inputan">
								<option value="YA" <?php if($datapemeriksaan['Kelainan'] == 'YA'){echo "SELECTED";}?>>YA</option>
								<option value="TIDAK" <?php if($datapemeriksaan['Kelainan'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Pengobatan</td>
					<td>
						<div class="input-group">
							<select name="pengobatan" class="form-control inputan">
								<option value="Diobati" <?php if($datapemeriksaan['Pengobatan'] == 'Diobati'){echo "SELECTED";}?>>Diobati</option>
								<option value="Dirujuk" <?php if($datapemeriksaan['Pengobatan'] == 'Dirujuk'){echo "SELECTED";}?>>Dirujuk</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Konseling</td>
					<td>
						<div class="input-group">
							<select name="konseling" class="form-control inputan">
								<option value="B" <?php if($datapemeriksaan['Konseling'] == 'B'){echo "SELECTED";}?>>B</option>
								<option value="L" <?php if($datapemeriksaan['Pengobatan'] == 'L'){echo "SELECTED";}?>>L</option>
								<option value="S" <?php if($datapemeriksaan['Pengobatan'] == 'S'){echo "SELECTED";}?>>S</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Penyuluhan</td>
					<td>
						<div class="input-group">
							<select name="penyuluhan" class="form-control inputan">
								<option value="YA" <?php if($datapemeriksaan['Penyuluhan'] == 'YA'){echo "SELECTED";}?>>YA</option>
								<option value="TIDAK" <?php if($datapemeriksaan['Penyuluhan'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Pemberdayaan Lansia</td>
					<td>
						<div class="input-group">
							<select name="pemberdayaan" class="form-control inputan">
								<option value="YA" <?php if($datapemeriksaan['Pemberdayaan'] == 'YA'){echo "SELECTED";}?>>YA</option>
								<option value="TIDAK" <?php if($datapemeriksaan['Pemberdayaan'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Panti Wredha dibina</td>
					<td>
						<div class="input-group">
							<select name="panti" class="form-control inputan">
								<option value="YA" <?php if($datapemeriksaan['Panti'] == 'YA'){echo "SELECTED";}?>>YA</option>
								<option value="TIDAK" <?php if($datapemeriksaan['Panti'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Kunjungan Rumah</td>
					<td>
						<div class="input-group">
							<select name="kunjrumah" class="form-control inputan">
								<option value="YA" <?php if($datapemeriksaan['KunjunganRumah'] == 'YA'){echo "SELECTED";}?>>YA</option>
								<option value="TIDAK" <?php if($datapemeriksaan['KunjunganRumah'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">	
						<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">P3G</p>
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">Skrining (P3G)</td>
					<td class="col-sm-10">
						<div class="input-group">
							<select name="skrining" class="form-control inputan">
								<option value="YA" <?php if($datapemeriksaan['Skrining'] == 'YA'){echo "SELECTED";}?>>YA</option>
								<option value="TIDAK" <?php if($datapemeriksaan['Skrining'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
							</select>
							<span class="input-group-addon">LB</span>
						</div>
					</td>
				</tr>	
				<tr>
					<td>ADL</td>
					<td>
						<select name="adl" class="form-control inputan">
							<option value="A" <?php if($datapemeriksaan['Adl'] == 'A'){echo "SELECTED";}?>>A</option>
							<option value="B" <?php if($datapemeriksaan['Adl'] == 'B'){echo "SELECTED";}?>>B</option>
							<option value="C" <?php if($datapemeriksaan['Adl'] == 'C'){echo "SELECTED";}?>>C</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Resiko Jatuh</td>
					<td>
						<select name="resikojatuh" class="form-control inputan">
							<option value="N" <?php if($datapemeriksaan['ResikoJatuh'] == 'N'){echo "SELECTED";}?>>Normal</option>
							<option value="R" <?php if($datapemeriksaan['ResikoJatuh'] == 'R'){echo "SELECTED";}?>>Ringan</option>
							<option value="S" <?php if($datapemeriksaan['ResikoJatuh'] == 'S'){echo "SELECTED";}?>>Sedang</option>
							<option value="B" <?php if($datapemeriksaan['ResikoJatuh'] == 'B'){echo "SELECTED";}?>>Berat</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>GDS</td>
					<td>
						<select name="gds" class="form-control inputan">
							<option value="N" <?php if($datapemeriksaan['Gds'] == 'N'){echo "SELECTED";}?>>Normal</option>
							<option value="R" <?php if($datapemeriksaan['Gds'] == 'R'){echo "SELECTED";}?>>Ringan</option>
							<option value="S" <?php if($datapemeriksaan['Gds'] == 'S'){echo "SELECTED";}?>>Sedang</option>
							<option value="B" <?php if($datapemeriksaan['Gds'] == 'B'){echo "SELECTED";}?>>Berat</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>MME</td>
					<td>
						<select name="mme" class="form-control inputan">
							<option value="N" <?php if($datapemeriksaan['Mme'] == 'N'){echo "SELECTED";}?>>Normal</option>
							<option value="R" <?php if($datapemeriksaan['Mme'] == 'R'){echo "SELECTED";}?>>Ringan</option>
							<option value="S" <?php if($datapemeriksaan['Mme'] == 'S'){echo "SELECTED";}?>>Sedang</option>
							<option value="B" <?php if($datapemeriksaan['Mme'] == 'B'){echo "SELECTED";}?>>Berat</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>MNA</td>
					<td>
						<select name="mna" class="form-control inputan">
							<option value="N" <?php if($datapemeriksaan['Mna'] == 'N'){echo "SELECTED";}?>>Normal</option>
							<option value="R" <?php if($datapemeriksaan['Mna'] == 'R'){echo "SELECTED";}?>>Ringan</option>
							<option value="S" <?php if($datapemeriksaan['Mna'] == 'S'){echo "SELECTED";}?>>Sedang</option>
							<option value="B" <?php if($datapemeriksaan['Mna'] == 'B'){echo "SELECTED";}?>>Berat</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">Hasil Lab</p>
					</td>
				</tr>
				<tr>
					<td>Gdp (>126)</td>
					<td><input type ="text" name ="gdp_lab" class="form-control inputan" value="<?php if($datapemeriksaan['GdpLab'] != null){echo $datapemeriksaan['GdpLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Gds (>200)</td>
					<td><input type ="text" name ="gds_lab" class="form-control inputan" value="<?php if($datapemeriksaan['GdsLab'] != null){echo $datapemeriksaan['GdsLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Koles (>200)</td>
					<td><input type ="text" name ="koles_lab" class="form-control inputan" value="<?php if($datapemeriksaan['KolesLab'] != null){echo $datapemeriksaan['KolesLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Au (>7)</td>
					<td><input type ="text" name ="au_lab" class="form-control inputan" value="<?php if($datapemeriksaan['AuLab'] != null){echo $datapemeriksaan['AuLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Hb (<11)</td>
					<td><input type ="text" name ="hb_lab" class="form-control inputan" value="<?php if($datapemeriksaan['HbLab'] != null){echo $datapemeriksaan['HbLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Prot</td>
					<td><input type ="text" name ="prot_lab" class="form-control inputan" value="<?php if($datapemeriksaan['ProtLab'] != null){echo $datapemeriksaan['ProtLab'];}else{echo "0";}?>"></td>
				</tr>
			</table>
		</div>
	</div>
</div>
