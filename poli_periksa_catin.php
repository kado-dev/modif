<!--Catin-->
<div class="row catin_tmp">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-2">Tgl.Pemeriksaan</td>
				<td class="col-sm-10">
					<input type="text" name="catin_tanggal_pemeriksaan" class="form-control datepicker tglreg" value="<?php echo $hariini;?>" placeholder="Silahkan pilih tanggal" autofocus>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Tanda Vital</td>
				<td class="col-sm-10">
					<input type="text" name="catin_tandavital" class="form-control" value = "<?php echo $datacatin['TandaVital'];?>" placeholder="Isikan angka, misal : 90">
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Berat Badan</td>
				<td class="col-sm-10">
					<div class="input-group">
						<input type="text" name="catin_beratbadan" class="form-control" value = "<?php echo $datacatin['BeratBadan'];?>" placeholder="Isikan angka, misal : 90">
						<div class="input-group-append">
							<span class="input-group-text">Kg</span>
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Tinggi Badan</td>
				<td class="col-sm-10">
					<div class="input-group">
						<input type="text" name="catin_tinggibadan" class="form-control" value = "<?php echo $datavatin['TinggiBadan'];?>" placeholder="Isikan angka, misal : 90">
						<div class="input-group-append">
							<span class="input-group-text">Cm</span>
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Lila (Cm)</td>
				<td class="col-sm-10">
					<select name="catin_lila" class="form-control">
						<option value="KEK (<23.5)" <?php if($datakia['Lila'] == 'KEK (<23.5)'){echo "SELECTED";}?>>KEK (<23.5)</option>
						<option value="Tidak" <?php if($datakia['Lila'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Status T</td>
				<td class="col-sm-10">
					<select name="catin_status_t" class="form-control">
						<option value="T1" <?php if($datakia['StatusT'] == 'T1'){echo "SELECTED";}?>>T1</option>
						<option value="T2" <?php if($datakia['StatusT'] == 'T2'){echo "SELECTED";}?>>T2</option>
						<option value="T3" <?php if($datakia['StatusT'] == 'T3'){echo "SELECTED";}?>>T3</option>
						<option value="T4" <?php if($datakia['StatusT'] == 'T4'){echo "SELECTED";}?>>T4</option>
						<option value="T5" <?php if($datakia['StatusT'] == 'T5'){echo "SELECTED";}?>>T5</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Tanda Anemia</td>
				<td class="col-sm-10">
					<select name="catin_tanda_anemia" class="form-control">
						<option value="Ada" <?php if($datakia['TandaAnemia'] == 'Ada'){echo "SELECTED";}?>>Ada</option>
						<option value="Tidak" <?php if($datakia['TandaAnemia'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Golongan Darah</td>
				<td class="col-sm-10">
					<select name="catin_golongan_darah" class="form-control">
						<option value="A" <?php if($datakia['GolonganDarah'] == 'A'){echo "SELECTED";}?>>A</option>
						<option value="B" <?php if($datakia['GolonganDarah'] == 'B'){echo "SELECTED";}?>>B</option>
						<option value="AB" <?php if($datakia['GolonganDarah'] == 'AB'){echo "SELECTED";}?>>AB</option>
						<option value="O" <?php if($datakia['GolonganDarah'] == 'O'){echo "SELECTED";}?>>O</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Rhesus</td>
				<td class="col-sm-10">
					<select name="catin_rhesus" class="form-control">
						<option value="Positif" <?php if($datakia['Rhesus'] == 'Positif'){echo "SELECTED";}?>>Positif</option>
						<option value="Negatif" <?php if($datakia['Rhesus'] == 'Negatif'){echo "SELECTED";}?>>Negatif</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Lainnya</td>
				<td class="col-sm-10">
					<input type="text" name="catin_lainnya" class="form-control" value = "<?php echo $datakia['Lainnya'];?>" placeholder="Isikan angka, misal : 90">
				</td>
			</tr>
		</table>
	</div>	
</div>