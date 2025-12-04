<?php
    // vital sign
	$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
	$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
	$dtsistole = $dtvs['Sistole'];
	$dtdiastole = $dtvs['Diastole'];
	$dtsuhutubuh = $dtvs['SuhuTubuh'];
	$dttinggiBadan = $dtvs['TinggiBadan'];
	$dtberatBadan = $dtvs['BeratBadan'];
	$dtheartRate = $dtvs['HeartRate'];
	$dtrespRate = $dtvs['RespiratoryRate'];
	$dtLingkarPerut = $dtvs['LingkarPerut'];
	$imt = $dtvs['IMT'];
?>

<h3 class="judul"><b>Tanda Vital & Pemeriksaan Fisik (Objektive)</b></h3>
<div class = "row mt-4">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<tr>
					<td class="col-sm-3">Sistole</td>
					<td class="col-sm-9">
						<div class="input-group">
							<?php if(substr($asuransi,0,4) == 'BPJS'){?>
								<span class="badge badge-primary" style='padding: 6px;'>
									<img src='image/logo_bpjs_bulet.png' width="30px"/>
								</span>&nbsp
							<?php } ?>
							<input type ="text" name ="sistole" class="sistole form-control inputan onfocusoutvalidation" maxlength="10" value="<?php if($dtsistole == ''){echo '0';}else{echo $dtsistole;}?>">
							<div class="input-group-append">
								<span class="input-group-text">mmHg</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Diastole</td>
					<td>
						<div class="input-group">
							<?php if(substr($asuransi,0,4) == 'BPJS'){?>
								<span class="badge badge-primary" style='padding: 6px;'>
									<img src='image/logo_bpjs_bulet.png' width="30px"/>
								</span>&nbsp
							<?php } ?>
							<input type ="text" name ="diastole" class="diastole form-control inputan onfocusoutvalidation" value="<?php if($dtdiastole == ''){echo '0';}else{echo $dtdiastole;}?>">
							<div class="input-group-append">
								<span class="input-group-text">mmHg</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Suhu Tubuh</td>
					<td>
						<div class="input-group">
							<?php if(substr($asuransi,0,4) == 'BPJS'){?>
								<span class="badge badge-primary" style='padding: 6px;'>
									<img src='image/logo_bpjs_bulet.png' width="30px"/>
								</span>&nbsp
							<?php } ?>
							<input type ="text" name ="suhutubuh" class="suhutubuh form-control inputan onfocusoutvalidation" maxlength="5" value="<?php if($dtsuhutubuh == ''){echo '0';}else{echo $dtsuhutubuh;}?>">
							<div class="input-group-append">
								<span class="input-group-text">c</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Tinggi Badan</td>
					<td>
						<div class="input-group">
							<?php if(substr($asuransi,0,4) == 'BPJS'){?>
								<span class="badge badge-primary" style='padding: 6px;'>
									<img src='image/logo_bpjs_bulet.png' width="30px"/>
								</span>&nbsp
							<?php } ?>
							<input type ="text" name ="tinggibadan" class="tinggibadan form-control inputan onfocusoutvalidation tinggibadancls" maxlength="5" value="<?php if($dttinggiBadan == ''){echo '0';}else{echo $dttinggiBadan;}?>">
							<div class="input-group-append">
								<span class="input-group-text">cm</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Berat Badan</td>
					<td>
						<div class="input-group">
							<?php if(substr($asuransi,0,4) == 'BPJS'){?>
								<span class="badge badge-primary" style='padding: 6px;'>
									<img src='image/logo_bpjs_bulet.png' width="30px"/>
								</span>&nbsp
							<?php } ?>
							<input type ="text" name ="beratbadan" class="beratbadan form-control inputan onfocusoutvalidation beratbadancls" maxlength="5" value="<?php if($dtberatBadan == ''){echo '0';}else{echo $dtberatBadan;}?>">
							<div class="input-group-append">
								<span class="input-group-text">kg</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Heart Rate</td>
					<td>
						<div class="input-group">
							<?php if(substr($asuransi,0,4) == 'BPJS'){?>
								<span class="badge badge-primary" style='padding: 6px;'>
									<img src='image/logo_bpjs_bulet.png' width="30px"/>
								</span>&nbsp
							<?php } ?>
							<input type ="text" name ="heartrate" class="heartrate form-control inputan onfocusoutvalidation" maxlength="10" value="<?php if($dtheartRate == ''){echo '0';}else{echo $dtheartRate;}?>">
							<div class="input-group-append">
								<span class="input-group-text">bpm</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Respiratory Rate</td>
					<td>
						<div class="input-group">
							<?php if(substr($asuransi,0,4) == 'BPJS'){?>
								<span class="badge badge-primary" style='padding: 6px;'>
									<img src='image/logo_bpjs_bulet.png' width="30px"/>
								</span>&nbsp
							<?php } ?>
							<input type ="text" name ="resprate" class="resprate form-control inputan onfocusoutvalidation" maxlength="10" value="<?php if($dtrespRate == ''){echo '0';}else{echo $dtrespRate;}?>">
							<div class="input-group-append">
								<span class="input-group-text">per minute</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Lingkar Perut</td>
					<td>
						<div class="input-group">
							<?php if(substr($asuransi,0,4) == 'BPJS'){?>
								<span class="badge badge-primary" style='padding: 6px;'>
									<img src='image/logo_bpjs_bulet.png' width="30px"/>
								</span>&nbsp
							<?php } ?>
							<input type ="text" name ="lingkarperut" class="form-control inputan onfocusoutvalidation" maxlength="10" value="<?php if($dtLingkarPerut == ''){echo '0';}else{echo $dtLingkarPerut;}?>">
							<div class="input-group-append">
								<span class="input-group-text">cm (Lap.PTM)</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>IMT</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="imt" class="form-control inputan imtcls" maxlength="10" value="<?php if($imt == ''){echo '0';}else{echo $imt;}?>">
							<div class="input-group-append">
								<span class="input-group-text">(Lap.PTM)</span>
							</div>
						</div>
					</td>
				</tr>
			</table>			
		</div>
	</div>
</div>
<br/>
<h3 class="judul"><b>Pemeriksaan Fisik (Objektive)</b></h3>
<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
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
						<?php if($datapemeriksaan['PemeriksaanPenunjang'] != ''){ $penunjang = $datapemeriksaan['PemeriksaanPenunjang']; }else{ $penunjang = "Tidak Ada"; } ?>
						<textarea type="text" name ="pemeriksaanpenunjangobj" class="form-control inputan"><?php echo strtoupper($penunjang);?></textarea>
					</td>
				</tr>
				<tr>
					<td>Kepala</td>
					<td><input type ="text" name ="kepala" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Kepala'] == ''){echo 'MESO SEPHAL';}else{echo $datapemeriksaan['Kepala'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Mata</td>
					<td><input type ="text" name ="mata" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Mata'] == ''){echo 'CONJ AN -/-, ICT -/-';}else{echo $datapemeriksaan['Mata'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Hidung</td>
					<td><input type ="text" name ="hidung" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Hidung'] == ''){echo 'SEKRET-, HIPEREMIS-, SEPTUM N';}else{echo $datapemeriksaan['Hidung'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Telinga</td>
					<td><input type ="text" name ="telinga" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Telinga'] == ''){echo 'MAE DBN, GENDANG TELINGA +/+ INTAK, CERUMEN-';}else{echo $datapemeriksaan['Telinga'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Mulut</td>
					<td><input type ="text" name ="mulut" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Mulut'] == ''){echo 'FARING N, TONSIL N';}else{echo $datapemeriksaan['Mulut'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Leher</td>
					<td><input type ="text" name ="leher" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Leher'] == ''){echo 'PEMBESARAN KGB-';}else{echo $datapemeriksaan['Leher'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Dada</td>
					<td><input type ="text" name ="dada" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Dada'] == ''){echo 'GERAK NAFAS SIMETRIS, ICTUS CARDIS-';}else{echo $datapemeriksaan['Dada'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Punggung</td>
					<td><input type ="text" name ="punggung" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Punggung'] == ''){echo 'SIKATRIK-';}else{echo $datapemeriksaan['Punggung'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Cor/Pulmu</td>
					<td><input type ="text" name ="cp" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['CP'] == ''){echo 'S1S2 TUNGGAL REGULER, RH -/- EH -/-';}else{echo $datapemeriksaan['CP'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Perut</td>
					<td><input type ="text" name ="perut" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Perut'] == ''){echo 'BU+, METEORISMUS-, SUPEL, NT-';}else{echo $datapemeriksaan['Perut'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Hepar/Lien</td>
					<td><input type ="text" name ="hl" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['HL'] == ''){echo 'TIDAK TERABA';}else{echo $datapemeriksaan['HL'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Kelamin</td>
					<td><input type ="text" name ="kelamin" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Kelamin'] == ''){echo 'DBN';}else{echo $datapemeriksaan['Kelamin'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Ex Atas</td>
					<td><input type ="text" name ="exatas" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['ExAtas'] == ''){echo 'DBN';}else{echo $datapemeriksaan['ExAtas'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Ex Bawah</td>
					<td><input type ="text" name ="exbawah" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['ExBawah'] == ''){echo 'DBN';}else{echo $datapemeriksaan['ExBawah'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Lokalis</td>
					<td><input type ="text" name ="lokalis" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Lokalis'] == ''){echo '-';}else{echo $datapemeriksaan['Lokalis'];}?>"></textarea></td>
				</tr>
				<tr>
					<td>Effloresensi</td>
					<td><input type ="text" name ="effloresensi" class="form-control inputan onfocusoutvalidation" value="<?php if($datapemeriksaan['Effloresensi'] == ''){echo '-';}else{echo $datapemeriksaan['Effloresensi'];}?>"></textarea></td>
				</tr>
			</table>
		</div>
	</div>
</div>

