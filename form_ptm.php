<div  id="formptmhidden">
<input type="hidden" class="ket_formptmhidden" name="ket_form_diagnosa" value="ptm">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><b> Form PTM</b></h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-3 control-label">Gol.Darah</label>
					<div class="col-sm-3">
						<input type="text" name="ptm_darah" class="form-control" value="<?php echo $dataptm['Darah'];?>"><label>Kalau tidak tahu diisi "-"</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Merokok</label>
					<div class="col-sm-9">
						<div class="radio">
						  <label><input type="radio" name="ptm_merokok" value="Y" <?php if($dataptm['Merokok'] == 'Y'){echo 'CHECKED';}?>>Ya </label>						
						  <label style="margin-left:20px;"><input type="radio" name="ptm_merokok" value="N" <?php if($dataptm['Merokok'] == 'N'){echo 'CHECKED';}?>>Tidak</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Kurang Aktivitas Fisik</label>
					<div class="col-sm-9">
						<div class="radio">
						  <label><input type="radio" name="ptm_fisik" value="Y" <?php if($dataptm['AktifitasFisik'] == 'Y'){echo 'CHECKED';}?>>Ya</label>
						  <label style="margin-left:20px;"><input type="radio" name="ptm_fisik" value="N" <?php if($dataptm['AktifitasFisik'] == 'N'){echo 'CHECKED';}?>>Tidak</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Kurang Makan Sayur</label>
					<div class="col-sm-9">
						<div class="radio">
						  <label><input type="radio" name="ptm_makan_sayur" value="Y" <?php if($dataptm['KuranMakanSayur'] == 'Y'){echo 'CHECKED';}?>>Ya</label>
						  <label style="margin-left:20px;"><input type="radio" name="ptm_makan_sayur" value="N" <?php if($dataptm['KuranMakanSayur'] == 'N'){echo 'CHECKED';}?>>Tidak</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Konsumsi Alkohol</label>
					<div class="col-sm-9">
						<div class="radio">
						  <label><input type="radio" name="ptm_alkohol" value="Y" <?php if($dataptm['KonsumsiAlkohol'] == 'Y'){echo 'CHECKED';}?>>Ya</label>
						  <label style="margin-left:20px;"><input type="radio" name="ptm_alkohol" value="N" <?php if($dataptm['KonsumsiAlkohol'] == 'N'){echo 'CHECKED';}?>>Tidak</label>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>