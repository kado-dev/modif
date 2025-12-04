<div class = "row mt-4">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">Pemeriksaan Fisik</p>
				<tr>
					<td class="col-sm-3">Kelompok Disabilitas</td>
					<td class="col-sm-9">
						<?php
							$str_dsb = "SELECT `KelompokDisabilitas` FROM `tbpasiendisabilitas` WHERE `NoRegistrasi`='$noregistrasi'";
							$query_dsb = mysqli_query($koneksi,$str_dsb);
							$data_dsb = mysqli_fetch_assoc($query_dsb);
						?>
						<div class="input-group">
							<select name="disabilitas" class="form-control inputan">
								<option value="">--Pilih--</option>
								<option value="Fisik" <?php if($data_dsb['KelompokDisabilitas'] == 'Fisik'){echo "SELECTED";}?>>Fisik</option>
								<option value="Intelektual" <?php if($data_dsb['KelompokDisabilitas'] == 'Intelektual'){echo "SELECTED";}?>>Intelektual</option>
								<option value="Sensorik Penglihatan" <?php if($data_dsb['KelompokDisabilitas'] == 'Sensorik Penglihatan'){echo "SELECTED";}?>>Sensorik Penglihatan</option>
								<option value="Sensorik Pendengaran" <?php if($data_dsb['KelompokDisabilitas'] == 'Sensorik Pendengaran'){echo "SELECTED";}?>>Sensorik Pendengaran</option>
								<option value="Mental" <?php if($data_dsb['KelompokDisabilitas'] == 'Mental'){echo "SELECTED";}?>>Mental</option>
							</select>
							<div class="input-group-append">
								<span class="input-group-text">Lap.Disabilitas</span>
							</div>
						</div>
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