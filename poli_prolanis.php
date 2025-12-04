<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$dataprolanis = mysqli_fetch_assoc(mysqli_query($koneksi,"select * from `tbpoliprolanis` where `IdPasienrj` = '$idpasienrj'"));

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
				<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan"><?php echo $dtvs['Keluhan'];?></textarea></td>
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
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan"><?php echo $dtvs['Anamnesa'];?></textarea></td>
			</tr>
			<tr>
				<td class="col-sm-3">
				Riwayat Alergi Makanan
					<?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 3 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergimakanan" class="form-control inputan" required>
						<option value="00" <?php if($dataprolanis['RiwayatAlergiMakanan'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($dataprolanis['RiwayatAlergiMakanan'] == '01'){echo "SELECTED";}?>>Seafood</option>
						<option value="02" <?php if($dataprolanis['RiwayatAlergiMakanan'] == '02'){echo "SELECTED";}?>>Gandum</option>
						<option value="03" <?php if($dataprolanis['RiwayatAlergiMakanan'] == '03'){echo "SELECTED";}?>>Susu Sapi</option>
						<option value="04" <?php if($dataprolanis['RiwayatAlergiMakanan'] == '04'){echo "SELECTED";}?>>Kacang-Kacangan</option>
						<option value="05" <?php if($dataprolanis['RiwayatAlergiMakanan'] == '05'){echo "SELECTED";}?>>Makanan Lain</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
				Riwayat Alergi Udara
					<?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 4 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergiudara" class="form-control inputan" required>
						<option value="00" <?php if($dataprolanis['RiwayatAlergiUdara'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($dataprolanis['RiwayatAlergiUdara'] == '01'){echo "SELECTED";}?>>Udara Panas</option>
						<option value="02" <?php if($dataprolanis['RiwayatAlergiUdara'] == '02'){echo "SELECTED";}?>>Udara Dingin</option>
						<option value="03" <?php if($dataprolanis['RiwayatAlergiUdara'] == '03'){echo "SELECTED";}?>>Udara Kotor</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
				Riwayat Alergi Obat
					<?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 5 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergiobat" class="form-control inputan" required>
						<option value="00" <?php if($dataprolanis['RiwayatAlergiObat'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($dataprolanis['RiwayatAlergiObat'] == '01'){echo "SELECTED";}?>>Antibiotik</option>
						<option value="02" <?php if($dataprolanis['RiwayatAlergiObat'] == '02'){echo "SELECTED";}?>>Antiinflamasi</option>
						<option value="03" <?php if($dataprolanis['RiwayatAlergiObat'] == '03'){echo "SELECTED";}?>>Non Steroid</option>
						<option value="04" <?php if($dataprolanis['RiwayatAlergiObat'] == '04'){echo "SELECTED";}?>>Aspirin</option>
						<option value="05" <?php if($dataprolanis['RiwayatAlergiObat'] == '05'){echo "SELECTED";}?>>Kortikosteroid</option>
						<option value="06" <?php if($dataprolanis['RiwayatAlergiObat'] == '06'){echo "SELECTED";}?>>Insulin</option>
						<option value="07" <?php if($dataprolanis['RiwayatAlergiObat'] == '07'){echo "SELECTED";}?>>Obat-Obatan Lain</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
				Prognosa
					<?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 6 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="prognosa" class="form-control inputan" required>
						<option value="01" <?php if($dataprolanis['Prognosa'] == '01'){echo "SELECTED";}?>>Sanam (Sembuh)</option>
						<option value="02" <?php if($dataprolanis['Prognosa'] == '02'){echo "SELECTED";}?>>Bonam (Baik)</option>
						<option value="03" <?php if($dataprolanis['Prognosa'] == '03'){echo "SELECTED";}?>>Malam (Buruk/Jelek)</option>
						<option value="04" <?php if($dataprolanis['Prognosa'] == '04'){echo "SELECTED";}?>>Dubia Ad Sanam/Bolam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
						<option value="05" <?php if($dataprolanis['Prognosa'] == '05'){echo "SELECTED";}?>>Dubia Ad Malam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Sekarang</td>
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control inputan"><?php echo $dataprolanis['RiwayatPenyakitSekarang'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control inputan"><?php echo $dataprolanis['RiwayatPenyakitDulu'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control inputan"><?php echo $dataprolanis['RiwayatPenyakitKeluarga'];?></textarea></td>
			</tr>	
			<tr>
				<td>Anjuran</td>
				<td><input type ="text" name ="anjuran" class="form-control" value="<?php echo $dataprolanis['Anjuran'];?>"></text></td>
			</tr>
			<tr>
				<td>Pemeriksaan Penunjang</td>
				<td>
					<?php
						$arrprkpenunjang = explode(",",$dataprolanis['PemeriksaanPenunjang']);
					?>
					<div class="row">
						<div class="col-md-4">
							<label><input type="checkbox" name="prkpenunjang[]" value="Apakah Merokok" <?php if(in_array("Apakah Merokok", $arrprkpenunjang)){echo "CHECKED";}?>> Apakah Merokok</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Riwayat Alergi Obat" <?php if(in_array("Riwayat Alergi Obat", $arrprkpenunjang)){echo "CHECKED";}?>> Riwayat Alergi Obat</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Riwayat Asma" <?php if(in_array("Riwayat Asma", $arrprkpenunjang)){echo "CHECKED";}?>> Riwayat Asma</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Makan Sayur & Buah" <?php if(in_array("Makan Sayur & Buah", $arrprkpenunjang)){echo "CHECKED";}?>> Makan Sayur & Buah</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Minum Alkohol" <?php if(in_array("Minum Alkohol", $arrprkpenunjang)){echo "CHECKED";}?>> Minum Alkohol</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Aktifitas Fisik" <?php if(in_array("Aktifitas Fisik", $arrprkpenunjang)){echo "CHECKED";}?>> Aktifitas Fisik</label><br/>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>	
</div>
<br/>	
<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">				
				<tr>
					<td colspan="2">	
						<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">Pemeriksaan Fisik</p>
					</td>
				</tr>
				<tr>
					<td>Kelompok Disabilitas</td>
					<td>
						<?php
							$str_dsb = "SELECT `KelompokDisabilitas` FROM `tbpasiendisabilitas` WHERE `NoRegistrasi`='$noregistrasi'";
							$query_dsb = mysqli_query($koneksi,$str_dsb);
							$data_dsb = mysqli_fetch_assoc($query_dsb);
						?>
						<div class="input-group">
							<select name="disabilitas" class="form-control">
								<option value="">--Pilih--</option>
								<option value="Fisik" <?php if($data_dsb['KelompokDisabilitas'] == 'Fisik'){echo "SELECTED";}?>>Fisik</option>
								<option value="Intelektual" <?php if($data_dsb['KelompokDisabilitas'] == 'Intelektual'){echo "SELECTED";}?>>Intelektual</option>
								<option value="Sensorik Penglihatan" <?php if($data_dsb['KelompokDisabilitas'] == 'Sensorik Penglihatan'){echo "SELECTED";}?>>Sensorik Penglihatan</option>
								<option value="Sensorik Pendengaran" <?php if($data_dsb['KelompokDisabilitas'] == 'Sensorik Pendengaran'){echo "SELECTED";}?>>Sensorik Pendengaran</option>
								<option value="Mental" <?php if($data_dsb['KelompokDisabilitas'] == 'Mental'){echo "SELECTED";}?>>Mental</option>
								<option value="Tidak Ada" <?php if($data_dsb['KelompokDisabilitas'] == 'Tidak Ada'){echo "SELECTED";}?>>Tidak Ada</option>
							</select>
							<span class="input-group-addon">Laporan Disabilitas</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Kepala</td>
					<td><input type ="text" name ="kepala" class="form-control" value="<?php if($dataprolanis['Kepala'] == ''){echo 'MESO SEPHAL';}else{echo $dataprolanis['Kepala'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Mata</td>
					<td><input type ="text" name ="mata" class="form-control" value="<?php if($dataprolanis['Mata'] == ''){echo 'CONJ AN -/-, ICT -/-';}else{echo $dataprolanis['Mata'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Hidung</td>
					<td><input type ="text" name ="hidung" class="form-control" value="<?php if($dataprolanis['Hidung'] == ''){echo 'SEKRET-, HIPEREMIS-, SEPTUM N';}else{echo $dataprolanis['Hidung'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Telinga</td>
					<td><input type ="text" name ="telinga" class="form-control" value="<?php if($dataprolanis['Telinga'] == ''){echo 'MAE DBN, GENDANG TELINGA +/+ INTAK, CERUMEN-';}else{echo $dataprolanis['Telinga'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Mulut</td>
					<td><input type ="text" name ="mulut" class="form-control" value="<?php if($dataprolanis['Mulut'] == ''){echo 'FARING N, TONSIL N';}else{echo $dataprolanis['Mulut'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Leher</td>
					<td><input type ="text" name ="leher" class="form-control" value="<?php if($dataprolanis['Leher'] == ''){echo 'PEMBESARAN KGB-';}else{echo $dataprolanis['Leher'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Dada</td>
					<td><input type ="text" name ="dada" class="form-control" value="<?php if($dataprolanis['Dada'] == ''){echo 'GERAK NAFAS SIMETRIS, ICTUS CARDIS-';}else{echo $dataprolanis['Dada'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Punggung</td>
					<td><input type ="text" name ="punggung" class="form-control" value="<?php if($dataprolanis['Punggung'] == ''){echo 'SIKATRIK-';}else{echo $dataprolanis['Punggung'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Cor/Pulmu</td>
					<td><input type ="text" name ="cp" class="form-control" value="<?php if($dataprolanis['CP'] == ''){echo 'S1S2 TUNGGAL REGULER, RH -/- EH -/-';}else{echo $dataprolanis['CP'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Perut</td>
					<td><input type ="text" name ="perut" class="form-control" value="<?php if($dataprolanis['Perut'] == ''){echo 'BU+, METEORISMUS-, SUPEL, NT-';}else{echo $dataprolanis['Perut'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Hepar/Lien</td>
					<td><input type ="text" name ="hl" class="form-control" value="<?php if($dataprolanis['HL'] == ''){echo 'TIDAK TERABA';}else{echo $dataprolanis['HL'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Kelamin</td>
					<td><input type ="text" name ="kelamin" class="form-control" value="<?php if($dataprolanis['Kelamin'] == ''){echo 'DBN';}else{echo $dataprolanis['Kelamin'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Ex Atas</td>
					<td><input type ="text" name ="exatas" class="form-control" value="<?php if($dataprolanis['ExAtas'] == ''){echo 'DBN';}else{echo $dataprolanis['ExAtas'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Ex Bawah</td>
					<td><input type ="text" name ="exbawah" class="form-control" value="<?php if($dataprolanis['ExBawah'] == ''){echo 'DBN';}else{echo $dataprolanis['ExBawah'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Lokalis</td>
					<td><input type ="text" name ="lokalis" class="form-control" value="<?php if($dataprolanis['StatusLokalis'] == ''){echo '-';}else{echo $dataprolanis['StatusLokalis'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Effloresensi</td>
					<td><input type ="text" name ="effloresensi" class="form-control" value="<?php if($dataprolanis['Effloresensi'] == ''){echo '-';}else{echo $dataprolanis['Effloresensi'];}?>"></textarea></td>
				</tr>
				<tr>
					<td colspan="2">
						<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">Hasil Lab</p>
					</td>
				</tr>
				<tr>
					<td>Gdp (>126)</td>
					<td><input type ="text" name ="gdp_lab" class="form-control" value="<?php if($dataprolanis['GdpLab'] != null){echo $dataprolanis['GdpLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Gds (>200)</td>
					<td><input type ="text" name ="gds_lab" class="form-control" value="<?php if($dataprolanis['GdsLab'] != null){echo $dataprolanis['GdsLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Koles (>200)</td>
					<td><input type ="text" name ="koles_lab" class="form-control" value="<?php if($dataprolanis['KolesLab'] != null){echo $dataprolanis['KolesLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Au (>7)</td>
					<td><input type ="text" name ="au_lab" class="form-control" value="<?php if($dataprolanis['AuLab'] != null){echo $dataprolanis['AuLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Hb (< 11)</td>
					<td><input type ="text" name ="hb_lab" class="form-control" value="<?php if($dataprolanis['HbLab'] != null){echo $dataprolanis['HbLab'];}else{echo "0";}?>"></td>
				</tr>
				<tr>
					<td>Prot</td>
					<td><input type ="text" name ="prot_lab" class="form-control" value="<?php if($dataprolanis['ProtLab'] != null){echo $dataprolanis['ProtLab'];}else{echo "0";}?>"></td>
				</tr>
			</table>
		</div>
	</div>
</div>
