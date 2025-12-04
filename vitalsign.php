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
<div class = "row mt-4">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Tanda Vital
					<?php if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 7 
						</span>
					<?php } ?>
				</p>
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