<?php
$dataumum = mysqli_fetch_assoc(mysqli_query($koneksi,"select * from `tbpoliumum` where `NoPemeriksaan` = '$noregistrasi'"));
//--bpjs--//
$bpjs = get_data_peserta_bpjs($data['NoIndex']);
$data_bpjs = json_decode($bpjs,True);
$nokartubpjs = $data_bpjs['response']['noKartu'];
?>

<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<td class="col-sm-2">Anamnesa</td>
					<td>:</td>
					<td class="col-sm-10"><textarea name="anamnesa" class="form-control"><?php echo $dataumum['Anamnesa'];?></textarea></td>
				</tr>
				<tr>
					<td>Anjuran</td>
					<td>:</td>
					<td><input type ="text" name ="anjuran" class="form-control" value="<?php echo $dataumum['Anjuran'];?>"></text></td>
				</tr>
				<tr>
					<td>Pemerikasan Penunjang</td>
					<td>:</td>
					<td><input type ="text" name ="pemeriksaanpenunjang" class="form-control" value="<?php echo $dataumum['PemeriksaanPenunjang'];?>"></text></td>
				</tr>
				<tr>
					<td><b>Vital Sign</b></td>
					<td></td>
					<td></td>
				</tr>
				<?php
					$data_kunjungan_bpjs = get_kunjungan_edit($nokartubpjs);
					$dtkunbpjs = json_decode($data_kunjungan_bpjs,true);
					//echo $data_kunjungan_bpjs;
					$dtsistole = $dtkunbpjs['response']['list'][0]['sistole'];
					$dtdiastole = $dtkunbpjs['response']['list'][0]['diastole'];
					$dtberatBadan = $dtkunbpjs['response']['list'][0]['beratBadan'];
					$dttinggiBadan = $dtkunbpjs['response']['list'][0]['tinggiBadan'];
					$dtrespRate = $dtkunbpjs['response']['list'][0]['respRate'];
					$dtheartRate = $dtkunbpjs['response']['list'][0]['heartRate'];
					$data_kesadaran = get_data_kesadaran();
					$dkesadaran = json_decode($data_kesadaran,True);
					//echo $dkesadaran;
				?>
				<tr>
					<td>Sistole</td>
					<td>:</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="sistole" class="form-control" maxlength="10" value="<?php echo $dtsistole ?>">
							<span class="input-group-addon">mmHg</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Diastole*</td>
					<td>:</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="diastole" class="form-control" maxlength="10" value="<?php echo $dtdiastole ?>">
							<span class="input-group-addon">mmHg</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Suhu Tubuh</td>
					<td>:</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="suhutubuh" class="form-control" maxlength="5" value="<?php echo $dataumum['SuhuTubuh'];?>">
							<span class="input-group-addon">c</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Tinggi Badan*</td>
					<td>:</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="tinggibadan" class="form-control" maxlength="5" value="<?php echo $dttinggiBadan ?>">
							<span class="input-group-addon">cm</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Berat Badan*</td>
					<td>:</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="beratbadan" class="form-control" maxlength="5" value="<?php echo $dtberatBadan ?>">
							<span class="input-group-addon">kg</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Heart Rate*</td>
					<td>:</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="heartrate" class="form-control" maxlength="10" value="<?php echo $dtheartRate ?>">
							<span class="input-group-addon">bpm</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Respiratory Rate*</td>
					<td>:</td>
					<td>
						<div class="input-group">
							<input type ="text" name ="resprate" class="form-control" maxlength="10" value="<?php echo $dtrespRate ?>">
							<span class="input-group-addon">per minute</span>
						</div>
					</td>
				</tr>
				<tr>
					<td><b>Pemeriksaan  Fisik</b></td>
					<td></td>
					<td></td>
				</tr>
				
				<tr>
					<td>Kepala</td>
					<td>:</td>
					<td><input type ="text" name ="kepala" class="form-control" value="MESO SEPHAL"></textarea></td>
				</tr>
				<tr>
					<td>Mata</td>
					<td>:</td>
					<td><input type ="text" name ="mata" class="form-control" value="CONJ AN -/-, ICT -/-"></textarea></td>
				</tr>
				<tr>
					<td>Hidung</td>
					<td>:</td>
					<td><input type ="text" name ="hidung" class="form-control" value="SEKRET-, HIPEREMIS-, SEPTUM N"></textarea></td>
				</tr>
				<tr>
					<td>Telinga</td>
					<td>:</td>
					<td><input type ="text" name ="telinga" class="form-control" value="MAE DBN, GENDANG TELINGA +/+ INTAK, CERUMEN-"></textarea></td>
				</tr>
				<tr>
					<td>Mulut</td>
					<td>:</td>
					<td><input type ="text" name ="mulut" class="form-control" value="FARING N, TONSIL N"></textarea></td>
				</tr>
				<tr>
					<td>Leher</td>
					<td>:</td>
					<td><input type ="text" name ="leher" class="form-control" value="PEMBESARAN KGB-"></textarea></td>
				</tr>
				<tr>
					<td>Dada</td>
					<td>:</td>
					<td><input type ="text" name ="dada" class="form-control" value="GERAK NAFAS SIMETRIS, ICTUS CARDIS-"></textarea></td>
				</tr>
				<tr>
					<td>Punggung</td>
					<td>:</td>
					<td><input type ="text" name ="punggung" class="form-control" value="SIKATRIK-"></textarea></td>
				</tr>
				<tr>
					<td>Cor/Pulmu</td>
					<td>:</td>
					<td><input type ="text" name ="cp" class="form-control" value="S1S2 TUNGGAL REGULER, RH -/- EH -/-"></textarea></td>
				</tr>
				<tr>
					<td>Perut</td>
					<td>:</td>
					<td><input type ="text" name ="perut" class="form-control" value="BU+, METEORISMUS-, SUPEL, NT-"></textarea></td>
				</tr>
				<tr>
					<td>Hepar/Lien</td>
					<td>:</td>
					<td><input type ="text" name ="hl" class="form-control" value="TIDAK TERABA"></textarea></td>
				</tr>
				<tr>
					<td>Kelamin</td>
					<td>:</td>
					<td><input type ="text" name ="kelamin" class="form-control" value="DBN"></textarea></td>
				</tr>
				<tr>
					<td>Ex Atas</td>
					<td>:</td>
					<td><input type ="text" name ="exatas" class="form-control" value="DBN"></textarea></td>
				</tr>
				<tr>
					<td>Ex Bawah</td>
					<td>:</td>
					<td><input type ="text" name ="exbawah" class="form-control" value="DBN"></textarea></td>
				</tr>
				<tr>
					<td>Lokalis</td>
					<td>:</td>
					<td><input type ="text" name ="lokalis" class="form-control" value="-"></textarea></td>
				</tr>
				<tr>
					<td>Effloresensi</td>
					<td>:</td>
					<td><input type ="text" name ="effloresensi" class="form-control" value="-"></textarea></td>
				</tr>
			</table>
		</div>
	</div>
</div>