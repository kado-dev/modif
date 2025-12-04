<!--riwayat persalinan-->
<div class="table-responsive">
	<table class="table-judul" width="100%">
		<tr>
			<td class="col-sm-2">Tgl.Persalinan</td>
			<td class="col-sm-10">
				<input type="text" name="rb_tanggal_persalinan" class="form-control datepicker tglreg" value="<?php echo $hariini;?>" placeholder="Silahkan pilih tanggal" autofocus>
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Jam Persalinan</td>
			<td class="col-sm-10">
				<div class="input-group">
					<input type="text" name="rb_jam_persalinan" class="form-control" value = "<?php echo $datakia['JamPersalinan'];?>" placeholder="Misal : 07.30"></text>
					<div class="input-group-append">
						<span class="input-group-text">Jam</span>
					</span>
				</div>
			</td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td>
				<select name="rb_jeniskelamin" class="form-control">
					<option value="L" <?php if($datakia['JenisKelamin'] == 'L'){echo "SELECTED";}?>>Laki-laki</option>
					<option value="P" <?php if($datakia['JenisKelamin'] == 'P'){echo "SELECTED";}?>>Perempuan</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Berat Badan</td>
			<td class="col-sm-10">
				<div class="input-group">
					<input type="text" name="rb_beratbadan" class="form-control" maxlength = "10" value = "<?php echo $datakia['BeratBadan'];?>" placeholder="Misal : 3200"></text>
					<div class="input-group-append">
						<span class="input-group-text">Gram</span>
					</span>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Panjang Badan</td>
			<td class="col-sm-10">
				<div class="input-group">
					<input type="text" name="rb_panjangbadan" class="form-control" maxlength = "10" value = "<?php echo $datakia['PanjangBadan'];?>" placeholder="Misal : 3200"></text>
					<div class="input-group-append">
						<span class="input-group-text">Cm</span>
					</span>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Golongan Darah</td>
			<td class="col-sm-10">
				<select name="rb_golongandarah" class="form-control">
					<option value="A" <?php if($datakia['GolonganDarah'] == 'A'){echo "SELECTED";}?>>A</option>
					<option value="B" <?php if($datakia['GolonganDarah'] == 'B'){echo "SELECTED";}?>>B</option>
					<option value="AB" <?php if($datakia['GolonganDarah'] == 'AB'){echo "SELECTED";}?>>AB</option>
					<option value="O" <?php if($datakia['GolonganDarah'] == 'O'){echo "SELECTED";}?>>O</option>
				</select>	
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Buku KIA/KMS</td>
			<td class="col-sm-10">
				<select name="rb_bukukia" class="form-control">
					<option value="Memiliki" <?php if($datakia['BukuKia'] == 'Memiliki'){echo "SELECTED";}?>>Memiliki</option>
					<option value="Tidak Memiliki" <?php if($datakia['BukuKia'] == 'Tidak Memiliki'){echo "SELECTED";}?>>Tidak Memiliki</option>
				</select>	
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Keadaan Lahir</td>
			<td class="col-sm-10">
				<select name="rb_keadaanlahir" class="form-control">
					<option value="Hidup" <?php if($datakia['KeadaanLahir'] == 'Hidup'){echo "SELECTED";}?>>Hidup</option>
					<option value="Meninggal" <?php if($datakia['KeadaanLahir'] == 'Meninggal'){echo "SELECTED";}?>>Meninggal</option>
				</select>	
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Komplikasi</td>
			<td class="col-sm-10">
				<select name="rb_komplikasi" class="form-control">
					<option value="Asfiksi" <?php if($datakia['Komplikasi'] == 'Asfiksi'){echo "SELECTED";}?>>Asfiksi</option>
					<option value="Hipotermi" <?php if($datakia['Komplikasi'] == 'Hipotermi'){echo "SELECTED";}?>>Hipotermi</option>
					<option value="Infeksi" <?php if($datakia['Komplikasi'] == 'Infeksi'){echo "SELECTED";}?>>Infeksi</option>
					<option value="Tetanus" <?php if($datakia['Komplikasi'] == 'Tetanus'){echo "SELECTED";}?>>Tetanus</option>
					<option value="BBLR" <?php if($datakia['Komplikasi'] == 'BBLR'){echo "SELECTED";}?>>BBLR</option>
					<option value="Lainnya" <?php if($datakia['Komplikasi'] == 'Lainnya'){echo "SELECTED";}?>>Lainnya</option>
				</select>	
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Resusitasi</td>
			<td class="col-sm-10">
				<select name="rb_resusitasi" class="form-control">
					<option value="Ya" <?php if($datakia['Resusitasi'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
					<option value="Tidak" <?php if($datakia['Resusitasi'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
				</select>	
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">IMD</td>
			<td class="col-sm-10">
				<select name="rb_imd" class="form-control">
					<option value="< 1 Jam" <?php if($datakia['Resusitasi'] == '< 1 Jam'){echo "SELECTED";}?>>< 1 Jam</option>
					<option value="> 1 Jam" <?php if($datakia['Resusitasi'] == '> 1 Jam'){echo "SELECTED";}?>>> 1 Jam</option>
				</select>	
			</td>
		</tr>
		<tr>
			<td class="col-sm-2">Pencegahan</td>
			<td class="col-sm-10">
				<select name="rb_pencegahan" class="form-control">
					<option value="Vit. K1" <?php if($datakia['Pencegahan'] == 'Vit. K1'){echo "SELECTED";}?>>Vit. K1</option>
					<option value="Hep.80" <?php if($datakia['Pencegahan'] == 'Hep.80'){echo "SELECTED";}?>>Hep.80</option>
					<option value="Salep Mata" <?php if($datakia['Pencegahan'] == 'Salep Mata'){echo "SELECTED";}?>>Salep Mata</option>
				</select>	
			</td>
		</tr>
	</table><hr/>
	<a type="button" class="btnsimpan">SIMPAN</a><br/>
	<div class="table-responsive">
		<table class="table-judul">
			<thead>
				<tr>
					<th width="15%">TGL.PERSALINAN</th>
					<th width="10%">JAM</th>
					<th width="5%">L/P</th>
					<th width="10%">BB</th>
					<th width="10%">PB</th>
					<th width="5%">GOL.DARAH</th>
					<th width="10%">#</th>
				</tr>
			</thead>	
			<tbody>	
				<tr class="master-table" style="display:none">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<a class="btn btn-xs btn-danger">HAPUS</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>	