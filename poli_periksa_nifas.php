<!--Nifas-->
<div class="row nifas_tmp">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-2">Tgl.Pemeriksaan</td>
				<td class="col-sm-10">
					<input type="text" name="nifas_tanggal_pemeriksaan" class="form-control datepicker tglreg" value="<?php echo $hariini;?>" placeholder="Silahkan pilih tanggal" autofocus>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Hari ke</td>
				<td class="col-sm-10">
					<div class="input-group">
						<input type="text" name="nifas_hari" class="form-control" value = "<?php echo $datakia['NifasHari'];?>" placeholder="Isikan angka, misal : 90">
						<div class="input-group-append">
							<span class="input-group-text">Hari</span>
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Pelayanan</td>
				<td class="col-sm-10">
					<select name="nifas_tanda_vital" class="form-control">
						<option value="Vit A" <?php if($datakia['NifasPelayanan'] == 'Vit A'){echo "SELECTED";}?>>Vit A</option>
						<option value="FE (Tab/Botol)" <?php if($datakia['NifasPelayanan'] == 'FE (Tab/Botol)'){echo "SELECTED";}?>>FE (Tab/Botol)</option>
						<option value="Catat di Buku KIA" <?php if($datakia['NifasPelayanan'] == 'Catat di Buku KIA'){echo "SELECTED";}?>>Catat di Buku KIA</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Integrasi Program</td>
				<td class="col-sm-10">
					<select name="nifas_integrasi_program" class="form-control">
						<option value="ART" <?php if($datakia['NifasIntegrasiProgram'] == 'ART'){echo "SELECTED";}?>>ART</option>
						<option value="Obat Anti Malaria" <?php if($datakia['NifasIntegrasiProgram'] == 'Obat Anti Malaria'){echo "SELECTED";}?>>Obat Anti Malaria</option>
						<option value="Obat Anti TB" <?php if($datakia['NifasIntegrasiProgram'] == 'Obat Anti TB'){echo "SELECTED";}?>>Obat Anti TB</option>
						<option value="Folio Thorax" <?php if($datakia['NifasIntegrasiProgram'] == 'Folio Thorax'){echo "SELECTED";}?>>Folio Thorax</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Komplikasi</td>
				<td class="col-sm-10">
					<select name="nifas_komplikasi" class="form-control">
						<option value="PPP" <?php if($datakia['NifasKomplikasi'] == 'PPP'){echo "SELECTED";}?>>PPP</option>
						<option value="Infeksi" <?php if($datakia['NifasKomplikasi'] == 'Infeksi'){echo "SELECTED";}?>>Infeksi</option>
						<option value="HDK" <?php if($datakia['NifasKomplikasi'] == 'HDK'){echo "SELECTED";}?>>HDK</option>
						<option value="Lainnya" <?php if($datakia['NifasKomplikasi'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Dirujuk ke</td>
				<td class="col-sm-10">
					<select name="nifas_rujuk" class="form-control">
						<option value="Puskesmas" <?php if($datakia['NifasRujuk'] == 'Puskesmas'){echo "SELECTED";}?>>Puskesmas</option>
						<option value="RB" <?php if($datakia['NifasRujuk'] == 'RB'){echo "SELECTED";}?>>RB</option>
						<option value="RSIA" <?php if($datakia['NifasRujuk'] == 'RSIA'){echo "SELECTED";}?>>RSIA</option>
						<option value="RS" <?php if($datakia['NifasRujuk'] == 'RS'){echo "SELECTED";}?>>RS</option>
						<option value="Lainnya" <?php if($datakia['NifasRujuk'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Keadaan Tiba</td>
				<td class="col-sm-10">
					<select name="nifas_keadaan_tiba" class="form-control">
						<option value="Hidup" <?php if($datakia['NifasKeadaanTiba'] == 'Hidup'){echo "SELECTED";}?>>Hidup</option>
						<option value="Meninggal" <?php if($datakia['NifasKeadaanTiba'] == 'Meninggal'){echo "SELECTED";}?>>Meninggal</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Keadaan Pulang</td>
				<td class="col-sm-10">
					<select name="nifas_keadaan_pulang" class="form-control">
						<option value="Hidup" <?php if($datakia['NifasKeadaanPulang'] == 'Hidup'){echo "SELECTED";}?>>Hidup</option>
						<option value="Meninggal" <?php if($datakia['NifasKeadaanPulang'] == 'Meninggal'){echo "SELECTED";}?>>Meninggal</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Kunjungan Nifas</td>
				<td class="col-sm-10">
					<select name="nifas_kunjungan" class="form-control">
						<option value="KF 1" <?php if($datakia['NifasKunjungan'] == 'KF 1'){echo "SELECTED";}?>>KF 1 (6 Jam - 3 Hari)</option>
						<option value="KF 2" <?php if($datakia['NifasKunjungan'] == 'KF 2'){echo "SELECTED";}?>>KF 2 (4 - 28 Hari)</option>
						<option value="KF 3" <?php if($datakia['NifasKunjungan'] == 'KF 3'){echo "SELECTED";}?>>KF 3 (29 - 42 Hari)</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Rencana Kontrasepsi</td>
				<td class="col-sm-10">
					<select name="nifas_kontrasepsi_rencana" class="form-control">
						<option value="MAL" <?php if($datakia['NifasKontrasepsiRencana'] == 'MAL'){echo "SELECTED";}?>>MAL</option>
						<option value="KONDOM" <?php if($datakia['NifasKontrasepsiRencana'] == 'KONDOM'){echo "SELECTED";}?>>KONDOM</option>
						<option value="PIL" <?php if($datakia['NifasKontrasepsiRencana'] == 'PIL'){echo "SELECTED";}?>>PIL</option>
						<option value="SUNTIK" <?php if($datakia['NifasKontrasepsiRencana'] == 'SUNTIK'){echo "SELECTED";}?>>SUNTIK</option>
						<option value="AKDR" <?php if($datakia['NifasKontrasepsiRencana'] == 'AKDR'){echo "SELECTED";}?>>AKDR</option>
						<option value="IMPLANT" <?php if($datakia['NifasKontrasepsiRencana'] == 'IMPLANT'){echo "SELECTED";}?>>IMPLANT</option>
						<option value="MOW" <?php if($datakia['NifasKontrasepsiRencana'] == 'MOW'){echo "SELECTED";}?>>MOW</option>
						<option value="MOP" <?php if($datakia['NifasKontrasepsiRencana'] == 'MOP'){echo "SELECTED";}?>>MOP</option>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="col-sm-2">Pelaksanaan Kontrasepsi</td>
				<td class="col-sm-10">
					<select name="nifas_kontrasepsi_rencana" class="form-control">
						<option value="MAL" <?php if($datakia['NifasKontrasepsiPelaksanaan'] == 'MAL'){echo "SELECTED";}?>>MAL</option>
						<option value="KONDOM" <?php if($datakia['NifasKontrasepsiPelaksanaan'] == 'KONDOM'){echo "SELECTED";}?>>KONDOM</option>
						<option value="PIL" <?php if($datakia['NifasKontrasepsiPelaksanaan'] == 'PIL'){echo "SELECTED";}?>>PIL</option>
						<option value="SUNTIK" <?php if($datakia['NifasKontrasepsiPelaksanaan'] == 'SUNTIK'){echo "SELECTED";}?>>SUNTIK</option>
						<option value="AKDR" <?php if($datakia['NifasKontrasepsiPelaksanaan'] == 'AKDR'){echo "SELECTED";}?>>AKDR</option>
						<option value="IMPLANT" <?php if($datakia['NifasKontrasepsiPelaksanaan'] == 'IMPLANT'){echo "SELECTED";}?>>IMPLANT</option>
						<option value="MOW" <?php if($datakia['NifasKontrasepsiPelaksanaan'] == 'MOW'){echo "SELECTED";}?>>MOW</option>
						<option value="MOP" <?php if($datakia['NifasKontrasepsiPelaksanaan'] == 'MOP'){echo "SELECTED";}?>>MOP</option>
					</select>	
				</td>
			</tr>
		</table>
	</div>	
</div>