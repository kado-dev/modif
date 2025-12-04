<div  id="formdiarehidden">

<input type="hidden" class="ket_formdiarehidden" name="ket_form_diagnosa" value="diare">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><b> PEMERIKSAAN DIARE</b></h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">Tanda Bahaya</label>
					<div class="col-sm-9">
						<input type="text" value="<?php echo $datadiare['TandaBahaya'];?>" class="form-control" name="tandabahaya_diare">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Lama Diare</label>
					<div class="col-sm-2">
						<div class="input-group">
							<input type="text" value="<?php echo $datadiare['LamaDiare'];?>" class="form-control" name="lamadiare_diare" maxlength="2">
							<span class="input-group-addon">Hari</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Klasifikasi</label>
					<div class="col-sm-9">
						<select name="klasifikasi_diare" class="form-control">
							<option value="Diare Tanpa Dehidrasi" <?php if($datadiare['Klasifikasi'] == 'Diare Tanpa Dehidrasi'){echo "SELECTED";}?>>Diare Tanpa Dehidrasi</option>
							<option value="Dehidrasi Berat" <?php if($datadiare['Klasifikasi'] == 'Dehidrasi Berat'){echo "SELECTED";}?>>Dehidrasi Berat</option>
							<option value="Dehidrasi Sedang atau Ringan" <?php if($datadiare['Klasifikasi'] == 'Dehidrasi Sedang atau Ringan'){echo "SELECTED";}?>>Dehidrasi Sedang atau Ringan</option>
							<option value="Diare Persisten Berat" <?php if($datadiare['Klasifikasi'] == 'Diare Persisten Berat'){echo "SELECTED";}?>>Diare Persisten Berat</option>
							<option value="Diare Persisten" <?php if($datadiare['Klasifikasi'] == 'Diare Persisten'){echo "SELECTED";}?>>Diare Persisten</option>
							<option value="Disentri" <?php if($datadiare['Klasifikasi'] == 'Disentri'){echo "SELECTED";}?>>Disentri</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Rujuk</label>
					<div class="col-sm-2">
						<select name="rujuk_diare" class="form-control">
							<option value="Ya" <?php if($datadiare['Rujuk'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
							<option value="Tidak" <?php if($datadiare['Rujuk'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Tindakan Pengobatan</label>
					<div class="col-sm-2">
						<div class="input-group">
							<input type="text" value="<?php echo $datadiare['Oralit'];?>" class="form-control" name="diareoralit" maxlength="2" placeholder="Jumlah">
							<span class="input-group-addon">Oralit</span>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<input type="text" value="<?php echo $datadiare['Infus'];?>" class="form-control" name="diareinfus" maxlength="2" placeholder="Jumlah">
							<span class="input-group-addon">Infus</span>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<input type="text" value="<?php echo $datadiare['Zinc'];?>" class="form-control" name="diarezinc" maxlength="2" placeholder="Jumlah">
							<span class="input-group-addon">Zinc</span>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<input type="text" value="<?php echo $datadiare['Zinc'];?>" class="form-control" name="diarezincsyr" maxlength="2" placeholder="Jumlah">
							<span class="input-group-addon">ZincSyr</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Antibotik</label>
					<div class="col-sm-2">
						<select name="diareantibiotik" class="form-control">
							<option value="Tidak" <?php if($datadiare['Antibiotik'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
							<option value="Ya" <?php if($datadiare['Antibiotik'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Jika ya, sebutkan</label>
					<div class="col-sm-9">
						<input type="text" value="<?php echo $datadiare['ObatLain'];?>" class="form-control" name="obatlain_diare" placeholder="Sebutkan Nama Obat Antibiotik">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Keterangan</label>
					<div class="col-sm-9">
						<input type="text" value="<?php echo $datadiare['Keterangan'];?>" class="form-control" name="keterangan_diare">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Nakes</label>
					<div class="col-sm-9">
						<select name="nakes" class="form-control">
							<option value="Sarana Kesehatan" <?php if($datadiare['Nakes'] == 'Sarana Kesehatan'){echo "SELECTED";}?>>Sarana Kesehatan</option>
							<option value="Kader" <?php if($datadiare['Nakes'] == 'Kader'){echo "SELECTED";}?>>Kader</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatikan :</b><br>
				Form Diare wajib diisi karena terkait dengan pelaporan Program Diare<br/>
				Jika kesulitan hubungi pemegang program P2P di Puskesmas/Dinkes.
				</p>
			</div>
		</div>
	</div>
</div>
