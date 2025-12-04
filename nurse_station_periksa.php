<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $data['Asuransi'];

	// tbpasienrj
	$query = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'");
	$pelayanan = $data['PoliPertama'];

	// tbvitalsign
	$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
	$cekvitaslsign = mysqli_num_rows(mysqli_query($koneksi, $strvs));
	$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));

	
	if($pelayanan == 'POLI UMUM'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoliumum` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI ANAK'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolianak` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI GIGI'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoligigi` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI INFEKSIUS'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpoliinfeksius` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI KIR'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikir` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI KIA'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpolikia` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI KB'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikb` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI LANSIA'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpolilansia` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI PROLANIS'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpoliprolanis` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI SCREENING'){
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpoliscreening` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}else if($pelayanan == 'POLI TB DOTS' OR $pelayanan == 'POLI TB'){
		if($kota == 'KOTA TARAKAN'){
			$polis = 'tbpolitb';
		}else{
			$polis = 'tbpolitbdots';
		}
		$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$polis` WHERE `IdPasienrj` = '$idpasienrj'"));	
	}

	// keluhan
	if($dtvs['Keluhan'] != ''){
		$keluhan = $dtvs['Keluhan'];
	}else{
		$keluhan = $datapemeriksaan['Keluhan'];
	}

	// anamnesa
	if($dtvs['Anamnesa'] != ''){
		$anamnesa = $dtvs['Anamnesa'];
	}else{
		$anamnesa = $datapemeriksaan['Anamnesa'];
	}
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-3">
					Keluhan
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 1 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan"><?php echo $keluhan;?></textarea></td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Anamnesa
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 2 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan"><?php echo $anamnesa;?></textarea></td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Riwayat Alergi Makanan
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 3 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergimakanan" class="form-control inputan" required>
						<option value="00" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '01'){echo "SELECTED";}?>>Seafood</option>
						<option value="02" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '02'){echo "SELECTED";}?>>Gandum</option>
						<option value="03" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '03'){echo "SELECTED";}?>>Susu Sapi</option>
						<option value="04" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '04'){echo "SELECTED";}?>>Kacang-Kacangan</option>
						<option value="05" <?php if($datapemeriksaan['RiwayatAlergiMakanan'] == '05'){echo "SELECTED";}?>>Makanan Lain</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Riwayat Alergi Udara
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 4 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergiudara" class="form-control inputan" required>
						<option value="00" <?php if($datapemeriksaan['RiwayatAlergiUdara'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datapemeriksaan['RiwayatAlergiUdara'] == '01'){echo "SELECTED";}?>>Udara Panas</option>
						<option value="02" <?php if($datapemeriksaan['RiwayatAlergiUdara'] == '02'){echo "SELECTED";}?>>Udara Dingin</option>
						<option value="03" <?php if($datapemeriksaan['RiwayatAlergiUdara'] == '03'){echo "SELECTED";}?>>Udara Kotor</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Riwayat Alergi Obat
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 5 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="riwayatalergiobat" class="form-control inputan" required>
						<option value="00" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '00'){echo "SELECTED";}?>>Tidak Ada</option>
						<option value="01" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '01'){echo "SELECTED";}?>>Antibiotik</option>
						<option value="02" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '02'){echo "SELECTED";}?>>Antiinflamasi</option>
						<option value="03" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '03'){echo "SELECTED";}?>>Non Steroid</option>
						<option value="04" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '04'){echo "SELECTED";}?>>Aspirin</option>
						<option value="05" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '05'){echo "SELECTED";}?>>Kortikosteroid</option>
						<option value="06" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '06'){echo "SELECTED";}?>>Insulin</option>
						<option value="07" <?php if($datapemeriksaan['RiwayatAlergiObat'] == '07'){echo "SELECTED";}?>>Obat-Obatan Lain</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-sm-3">
					Prognosa
					<?php 
						if(substr($asuransi,0,4) == 'BPJS'){?>
						<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
							<img src='image/logo_bpjs_bulet.png' width="30px"/> 6 
						</span>
					<?php } ?>
				</td>
				<td class="col-sm-9">
					<select name="prognosa" class="form-control inputan" required>
						<option value="01" <?php if($datapemeriksaan['Prognosa'] == '01'){echo "SELECTED";}?>>Sanam (Sembuh)</option>
						<option value="02" <?php if($datapemeriksaan['Prognosa'] == '02'){echo "SELECTED";}?>>Bonam (Baik)</option>
						<option value="03" <?php if($datapemeriksaan['Prognosa'] == '03'){echo "SELECTED";}?>>Malam (Buruk/Jelek)</option>
						<option value="04" <?php if($datapemeriksaan['Prognosa'] == '04'){echo "SELECTED";}?>>Dubia Ad Sanam/Bolam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
						<option value="05" <?php if($datapemeriksaan['Prognosa'] == '05'){echo "SELECTED";}?>>Dubia Ad Malam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Sekarang</td>
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control inputan"><?php echo $datapemeriksaan['RiwayatPenyakitSekarang'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control inputan"><?php echo $datapemeriksaan['RiwayatPenyakitDulu'];?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control inputan"><?php echo $datapemeriksaan['RiwayatPenyakitKeluarga'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type="text" name ="anjuran" class="form-control inputan" value="<?php echo $datapemeriksaan['Anjuran'];?>"></td>
			</tr>
		</table>
	</div>	
</div><br/>	

<?php
// vitalsign
include "vitalsign.php";
?>
