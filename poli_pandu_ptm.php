<?php
	$get_dataptm = mysqli_query($koneksi,"SELECT * FROM `tbpolipanduptm` WHERE `NoPemeriksaan` = '$noregistrasi'");
	$dataptm = mysqli_fetch_assoc($get_dataptm);
	$dtsistole = $dataptm['Sistole'];
	$dtdiastole = $dataptm['Diastole'];
	$dtsuhutubuh = $dataptm['SuhuTubuh'];
	$dtberatBadan = $dataptm['BeratBadan'];
	$dttinggiBadan = $dataptm['TinggiBadan'];
	$dtheartRate = $dataptm['DetakNadi'];
	$dtrespRate = $dataptm['RR'];
	$dtLingkarPerut = $dataptm['LingkarPerut'];
	$imt = $dataptm['Imt'];
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-2">Anamnesa</td>
				<td class="col-sm-10"><textarea name="anamnesa" class="anamnesa form-control"><?php echo $dataptm['Anamnesa'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type="text" name ="anjuran" class="form-control" value="<?php echo $dataptm['Anjuran'];?>"></td>
			</tr>
			<tr>
				<td>Hasil Lab (GDS/GDP)</td>
				<td>
					<input type="text" name ="pemeriksaanpenunjanglab_gds" class="form-control" value="<?php echo $dataptm['PemeriksaanHasilLabGds'];?>">
				</td>
			</tr>
			<tr>
				<td>Hasil Lab (Kolesterol)</td>
				<td>
					<input type="text" name ="pemeriksaanpenunjanglab_kolesterol" class="form-control" value="<?php echo $dataptm['PemeriksaanHasilLabKolesterol'];?>">
				</td>
			</tr>
			<tr>
				<td>Hasil Lab (Asam Urat)</td>
				<td>
					<input type="text" name ="pemeriksaanpenunjanglab_asamurat" class="form-control" value="<?php echo $dataptm['PemeriksaanHasilLabAsamUrat'];?>">
				</td>
			</tr>
			<tr>
				<td>Faktor Resiko</td>
				<td>
					<?php
						$arrprkpenunjang = explode(",",$dataptm['PemeriksaanPenunjang']);
					?>
					<div class="row">
						<div class="col-md-4">
							<label><input type="checkbox" name="prkpenunjang[]" value="Merokok" <?php if(in_array("Merokok", $arrprkpenunjang)){echo "CHECKED";}?>> Merokok</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Kurang Aktifitas Fisik" <?php if(in_array("Kurang Aktifitas Fisik", $arrprkpenunjang)){echo "CHECKED";}?>> Kurang Aktifitas Fisik</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Gula Berlebihan" <?php if(in_array("Gula Berlebihan", $arrprkpenunjang)){echo "CHECKED";}?>> Gula Berlebihan</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Garam Berlebihan" <?php if(in_array("Garam Berlebihan", $arrprkpenunjang)){echo "CHECKED";}?>> Garam Berlebihan</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Lemak Berlebihan" <?php if(in_array("Lemak Berlebihan", $arrprkpenunjang)){echo "CHECKED";}?>> Lemak Berlebihan</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Kurang Sayur Buah" <?php if(in_array("Kurang Sayur Buah", $arrprkpenunjang)){echo "CHECKED";}?>> Kurang Sayur Buah</label><br/>
							<label><input type="checkbox" name="prkpenunjang[]" value="Konsumsi Alkohol" <?php if(in_array("Konsumsi Alkohol", $arrprkpenunjang)){echo "CHECKED";}?>> Konsumsi Alkohol</label><br/>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Riwayat PTM Keluarga</td>
				<td>
					<select name="riwayatptmkeluarga" class="form-control">
						<option value="-" <?php if($dataptm['RiwayatPtmKeluarga'] == '-'){echo "SELECTED";}?>>-</option>
						<option value="DM" <?php if($dataptm['RiwayatPtmKeluarga'] == 'DM'){echo "SELECTED";}?>>DM</option>
						<option value="HT" <?php if($dataptm['RiwayatPtmKeluarga'] == 'HT'){echo "SELECTED";}?>>HT</option>
						<option value="Jantung" <?php if($dataptm['RiwayatPtmKeluarga'] == 'Jantung'){echo "SELECTED";}?>>Jantung</option>
						<option value="Stroke" <?php if($dataptm['RiwayatPtmKeluarga'] == 'Stroke'){echo "SELECTED";}?>>Stroke</option>
						<option value="Asma" <?php if($dataptm['RiwayatPtmKeluarga'] == 'Asma'){echo "SELECTED";}?>>Asma</option>
						<option value="Kanker" <?php if($dataptm['RiwayatPtmKeluarga'] == 'Kanker'){echo "SELECTED";}?>>Kanker</option>
						<option value="Kolesterol" <?php if($dataptm['RiwayatPtmKeluarga'] == 'Kolesterol'){echo "SELECTED";}?>>Kolesterol</option>
						<option value="Benjolan Payudara" <?php if($dataptm['RiwayatPtmKeluarga'] == 'Benjolan Payudara'){echo "SELECTED";}?>>Benjolan Payudara</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Riwayat PTM Pribadi</td>
				<td>
					<select name="riwayatptmpribadi" class="form-control">
						<option value="-" <?php if($dataptm['RiwayatPtmPribadi'] == '-'){echo "SELECTED";}?>>-</option>
						<option value="DM" <?php if($dataptm['RiwayatPtmPribadi'] == 'DM'){echo "SELECTED";}?>>DM</option>
						<option value="HT" <?php if($dataptm['RiwayatPtmPribadi'] == 'HT'){echo "SELECTED";}?>>HT</option>
						<option value="Jantung" <?php if($dataptm['RiwayatPtmPribadi'] == 'Jantung'){echo "SELECTED";}?>>Jantung</option>
						<option value="Stroke" <?php if($dataptm['RiwayatPtmPribadi'] == 'Stroke'){echo "SELECTED";}?>>Stroke</option>
						<option value="Asma" <?php if($dataptm['RiwayatPtmPribadi'] == 'Asma'){echo "SELECTED";}?>>Asma</option>
						<option value="Kanker" <?php if($dataptm['RiwayatPtmPribadi'] == 'Kanker'){echo "SELECTED";}?>>Kanker</option>
						<option value="Kolesterol" <?php if($dataptm['RiwayatPtmPribadi'] == 'Kolesterol'){echo "SELECTED";}?>>Kolesterol</option>
						<option value="Benjolan Payudara" <?php if($dataptm['RiwayatPtmPribadi'] == 'Benjolan Payudara'){echo "SELECTED";}?>>Benjolan Payudara</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">	
					<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">Gangguan Mata</p>
				</td>
			</tr>
			<tr>
				<td>Lokasi</td>
				<td>
					<select name="matalokasi" class="form-control">
						<option value="-" <?php if($dataptm['MataLokasi'] == '-'){echo "SELECTED";}?>>-</option>
						<option value="MATA KANAN" <?php if($dataptm['MataLokasi'] == 'MATA KANAN'){echo "SELECTED";}?>>MATA KANAN</option>
						<option value="MATA KIRI" <?php if($dataptm['MataLokasi'] == 'MATA KIRI'){echo "SELECTED";}?>>MATA KIRI</option>
						<option value="RUJUK RS" <?php if($dataptm['MataLokasi'] == 'RUJUK RS'){echo "SELECTED";}?>>RUJUK RS</option>
						<option value="ADA RIWAYAT" <?php if($dataptm['MataLokasi'] == 'ADA RIWAYAT'){echo "SELECTED";}?>>ADA RIWAYAT</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Katarak</td>
				<td>
					<input type="text" name ="matakatarak" class="form-control" value="<?php echo $dataptm['MataKatarak'];?>">
				</td>
			</tr>
			<tr>
				<td>Gangguan Refraksi</td>
				<td>
					<input type="text" name ="matarefraksi" class="form-control" value="<?php echo $dataptm['MataRefraksi'];?>">
				</td>
			</tr>
			<tr>
				<td colspan="2">	
					<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">Gangguan Telinga</p>
				</td>
			</tr>
			<tr>
				<td>Lokasi</td>
				<td>
					<select name="telingalokasi" class="form-control">
						<option value="-" <?php if($dataptm['TelingaLokasi'] == '-'){echo "SELECTED";}?>>-</option>
						<option value="MATA KANAN" <?php if($dataptm['TelingaLokasi'] == 'MATA KANAN'){echo "SELECTED";}?>>MATA KANAN</option>
						<option value="MATA KIRI" <?php if($dataptm['TelingaLokasi'] == 'MATA KIRI'){echo "SELECTED";}?>>MATA KIRI</option>
						<option value="RUJUK RS" <?php if($dataptm['TelingaLokasi'] == 'RUJUK RS'){echo "SELECTED";}?>>RUJUK RS</option>
						<option value="ADA RIWAYAT" <?php if($dataptm['TelingaLokasi'] == 'ADA RIWAYAT'){echo "SELECTED";}?>>ADA RIWAYAT</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Tuli</td>
				<td>
					<input type="text" name ="telingatuli" class="form-control" value="<?php echo $dataptm['TelingaTuli'];?>">
				</td>
			</tr>
			<tr>
				<td>Omsk/Congek</td>
				<td>
					<input type="text" name ="telingacongek" class="form-control" value="<?php echo $dataptm['TelingaCongek'];?>">
				</td>
			</tr>
			<tr>
				<td>Serumen</td>
				<td>
					<input type="text" name ="telingaserumen" class="form-control" value="<?php echo $dataptm['TelingaSerumen'];?>">
				</td>
			</tr>
			<tr>
				<td colspan="2">	
					<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">IVA & Sadanis</p>
				</td>
			</tr>
			<tr>
				<td>Iva</td>
				<td>
					<select name="ptmiva" class="form-control">
						<option value="-" <?php if($dataptm['Iva'] == '-'){echo "SELECTED";}?>>-</option>
						<option value="BELUM" <?php if($dataptm['Iva'] == 'BELUM'){echo "SELECTED";}?>>BELUM</option>
						<option value="PERNAH" <?php if($dataptm['Iva'] == 'PERNAH'){echo "SELECTED";}?>>PERNAH</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Sadanis</td>
				<td>
					<select name="ptmsadanis" class="form-control">
						<option value="-" <?php if($dataptm['Sadanis'] == '-'){echo "SELECTED";}?>>-</option>
						<option value="BELUM" <?php if($dataptm['Sadanis'] == 'BELUM'){echo "SELECTED";}?>>BELUM</option>
						<option value="PERNAH" <?php if($dataptm['Sadanis'] == 'PERNAH'){echo "SELECTED";}?>>PERNAH</option>
					</select>
				</td>
			</tr>
		</table>
	</div>	
</div><br/>	
<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<tr>
					<td colspan="2">	
						<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">Vital Sign</p>
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">Sistole</td>
					<td class="col-sm-10">
						<div class="input-group">
							<input type ="text" name ="sistole" class="sistole form-control" maxlength="10" value="<?php if($dtsistole == ''){echo '0';}else{echo $dtsistole;}?>">
							<span class="input-group-addon">mmHg</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Diastole</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="diastole" class="diastole form-control" value="<?php if($dtdiastole == ''){echo '0';}else{echo $dtdiastole;}?>">
							<span class="input-group-addon">mmHg</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Suhu Tubuh</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="suhutubuh" class="suhutubuh form-control" maxlength="5" value="<?php if($datatindakan['SuhuTubuh'] == ''){echo '0';}else{echo $datatindakan['SuhuTubuh'];}?>">
							<span class="input-group-addon">c</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Tinggi Badan</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="tinggibadan" class="tinggibadan form-control tinggibadancls" maxlength="5" value="<?php if($dttinggiBadan == ''){echo '0';}else{echo $dttinggiBadan;}?>">
							<span class="input-group-addon">cm</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Berat Badan</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="beratbadan" class="beratbadan form-control beratbadancls" maxlength="5" value="<?php if($dtberatBadan == ''){echo '0';}else{echo $dtberatBadan;}?>">
							<span class="input-group-addon">kg</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Heart Rate</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="heartrate" class="heartrate form-control" maxlength="10" value="<?php if($dtheartRate == ''){echo '0';}else{echo $dtheartRate;}?>">
							<span class="input-group-addon">bpm</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Respiratory Rate</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="resprate" class="resprate form-control" maxlength="10" value="<?php if($dtrespRate == ''){echo '0';}else{echo $dtrespRate;}?>">
							<span class="input-group-addon">per minute</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Lingkar Perut</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="lingkarperut" class="form-control" maxlength="10" value="<?php if($dtLingkarPerut == ''){echo '0';}else{echo $dtLingkarPerut;}?>">
							<span class="input-group-addon">cm (Lap.PTM)</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>IMT</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="imt" class="form-control imtcls" maxlength="10" value="<?php if($imt == ''){echo '0';}else{echo $imt;}?>">
							<span class="input-group-addon">(Lap.PTM)</span>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">	
						<p style="font-size: 20px; font-weight: bold; border-bottom: 1px solid #D5D5D5;">Pemeriksaan Fisik</p>
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">Kelompok Disabilitas</td>
					<td class="col-sm-10">
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
							</select>
							<span class="input-group-addon">Lap.Disabilitas</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Kepala</td>
					<td><input type ="text" name ="kepala" class="form-control" value="<?php if($dataptm['Kepala'] == ''){echo 'MESO SEPHAL';}else{echo $dataptm['Kepala'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Mata</td>
					<td><input type ="text" name ="mata" class="form-control" value="<?php if($dataptm['Mata'] == ''){echo 'CONJ AN -/-, ICT -/-';}else{echo $dataptm['Mata'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Hidung</td>
					<td><input type ="text" name ="hidung" class="form-control" value="<?php if($dataptm['Hidung'] == ''){echo 'SEKRET-, HIPEREMIS-, SEPTUM N';}else{echo $dataptm['Hidung'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Telinga</td>
					<td><input type ="text" name ="telinga" class="form-control" value="<?php if($dataptm['Telinga'] == ''){echo 'MAE DBN, GENDANG TELINGA +/+ INTAK, CERUMEN-';}else{echo $dataptm['Telinga'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Mulut</td>
					<td><input type ="text" name ="mulut" class="form-control" value="<?php if($dataptm['Mulut'] == ''){echo 'FARING N, TONSIL N';}else{echo $dataptm['Mulut'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Leher</td>
					<td><input type ="text" name ="leher" class="form-control" value="<?php if($dataptm['Leher'] == ''){echo 'PEMBESARAN KGB-';}else{echo $dataptm['Leher'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Dada</td>
					<td><input type ="text" name ="dada" class="form-control" value="<?php if($dataptm['Dada'] == ''){echo 'GERAK NAFAS SIMETRIS, ICTUS CARDIS-';}else{echo $dataptm['Dada'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Punggung</td>
					<td><input type ="text" name ="punggung" class="form-control" value="<?php if($dataptm['Punggung'] == ''){echo 'SIKATRIK-';}else{echo $dataptm['Punggung'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Cor/Pulmu</td>
					<td><input type ="text" name ="cp" class="form-control" value="<?php if($dataptm['CP'] == ''){echo 'S1S2 TUNGGAL REGULER, RH -/- EH -/-';}else{echo $dataptm['CP'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Perut</td>
					<td><input type ="text" name ="perut" class="form-control" value="<?php if($dataptm['Perut'] == ''){echo 'BU+, METEORISMUS-, SUPEL, NT-';}else{echo $dataptm['Perut'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Hepar/Lien</td>
					<td><input type ="text" name ="hl" class="form-control" value="<?php if($dataptm['HL'] == ''){echo 'TIDAK TERABA';}else{echo $dataptm['HL'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Kelamin</td>
					<td><input type ="text" name ="kelamin" class="form-control" value="<?php if($dataptm['Kelamin'] == ''){echo 'DBN';}else{echo $dataptm['Kelamin'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Ex Atas</td>
					<td><input type ="text" name ="exatas" class="form-control" value="<?php if($dataptm['ExAtas'] == ''){echo 'DBN';}else{echo $dataptm['ExAtas'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Ex Bawah</td>
					<td><input type ="text" name ="exbawah" class="form-control" value="<?php if($dataptm['ExBawah'] == ''){echo 'DBN';}else{echo $dataptm['ExBawah'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Lokalis</td>
					<td><input type ="text" name ="lokalis" class="form-control" value="<?php if($dataptm['StatusLokalis'] == ''){echo '-';}else{echo $dataptm['StatusLokalis'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Effloresensi</td>
					<td><input type ="text" name ="effloresensi" class="form-control" value="<?php if($dataptm['Effloresensi'] == ''){echo '-';}else{echo $dataptm['Effloresensi'];}?>"></textarea></td>
				</tr>
			</table>
		</div>
	</div>
</div>