<?php
	$idpasienrj = $_GET['id'];
	$datalansia = mysqli_fetch_assoc(mysqli_query($koneksi,"select * from `$tbpolilansia` where `NoPemeriksaan` = '$noregistrasi'"));
?>
<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul">
			<tr>
				<td class="col-sm-2">
					Anamnesa
					<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
						<span class="badge badge-success" style='padding: 6px; font-size: 14px;'>
							<img src='image/bpjsputih.png'/> 1 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-10"><textarea name="anamnesa" class="form-control anamnesa"><?php echo $datalansia['Anamnesa'];?></textarea></td>
			</tr>
		</table>
	</div>	
</div><br/>	
<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
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
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Vital Sign
					<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
						<span class="badge badge-success" style='padding: 6px; font-size: 14px;'>
							<img src='image/bpjsputih.png'/> 2 
						</span>
					<?php } ?>
				</p>
				<tr>
					<td class="col-sm-2">
						Sistole
						<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
							<span class="badge badge-success" style='padding: 6px;'>
								<img src='image/bpjsputih.png' width="70%"/>
							</span>
						<?php } ?>
					</td>
					<td class="col-sm-10">
						<div class="input-group">
							<input type ="text" name ="sistole" class="sistole form-control" maxlength="10" value="<?php if($dtsistole == ''){echo '0';}else{echo $dtsistole;}?>">
							<span class="input-group-addon">mmHg</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						Diastole
						<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
							<span class="badge badge-success" style='padding: 6px;'>
								<img src='image/bpjsputih.png' width="70%"/>
							</span>
						<?php } ?>
					</td>
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
							<input type ="text" name ="suhutubuh" class="suhutubuh form-control" maxlength="5" value="<?php if($dtsuhutubuh == ''){echo '0';}else{echo $dtsuhutubuh;}?>">
							<span class="input-group-addon">c</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						Tinggi Badan
						<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
							<span class="badge badge-success" style='padding: 6px;'>
								<img src='image/bpjsputih.png' width="70%"/>
							</span>
						<?php } ?>
					</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="tinggibadan" class="tinggibadan form-control tinggibadancls" maxlength="5" value="<?php if($dttinggiBadan == ''){echo '0';}else{echo $dttinggiBadan;}?>">
							<span class="input-group-addon">cm</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						Berat Badan
						<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
							<span class="badge badge-success" style='padding: 6px;'>
								<img src='image/bpjsputih.png' width="70%"/>
							</span>
						<?php } ?>
					</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="beratbadan" class="beratbadan form-control beratbadancls" maxlength="5" value="<?php if($dtberatBadan == ''){echo '0';}else{echo $dtberatBadan;}?>">
							<span class="input-group-addon">kg</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						Heart Rate
						<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
							<span class="badge badge-success" style='padding: 6px;'>
								<img src='image/bpjsputih.png' width="70%"/>
							</span>
						<?php } ?>
					</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="heartrate" class="heartrate form-control" maxlength="10" value="<?php if($dtheartRate == ''){echo '0';}else{echo $dtheartRate;}?>">
							<span class="input-group-addon">bpm</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						Respiratory Rate
						<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
							<span class="badge badge-success" style='padding: 6px;'>
								<img src='image/bpjsputih.png' width="70%"/>
							</span>
						<?php } ?>
					</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="resprate" class="resprate form-control" maxlength="10" value="<?php if($dtrespRate == ''){echo '0';}else{echo $dtrespRate;}?>">
							<span class="input-group-addon">per minute</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						Lingkar Perut
						<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
							<span class="badge badge-success" style='padding: 6px;'>
								<img src='image/bpjsputih.png' width="70%"/>
							</span>
						<?php } ?>
					</td>
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
			</table>
		</div>
	</div>
</div>
