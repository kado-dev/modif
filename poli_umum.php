<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoliumum` WHERE `IdPasienrj` = '$idpasienrj'"));	

	// vital sign
	$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
	$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
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
				<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan onfocusoutvalidation"><?php echo $dtvs['Keluhan'];?></textarea></td>
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
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $dtvs['Anamnesa'];?></textarea></td>
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
				<?php if($datapemeriksaan['RiwayatPenyakitSekarang'] != ''){ $riwayatsekarang = $datapemeriksaan['RiwayatPenyakitSekarang']; }else{ $riwayatsekarang = "Tidak Ada"; } ?>
				<td><textarea name="riwayatpenyakitsekarang" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $riwayatsekarang;?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Terdahulu</td>
				<?php if($datapemeriksaan['RiwayatPenyakitDulu'] != ''){ $riwayatterdahulu = $datapemeriksaan['RiwayatPenyakitDulu']; }else{ $riwayatterdahulu = "Tidak Ada"; } ?>
				<td><textarea name="riwayatpenyakitdulu" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $riwayatterdahulu;?></textarea></td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<?php if($datapemeriksaan['RiwayatPenyakitKeluarga'] != ''){ $riwayatkeluarga = $datapemeriksaan['RiwayatPenyakitKeluarga']; }else{ $riwayatkeluarga = "Tidak Ada"; } ?>
				<td><textarea name="riwayatpenyakitkeluarga" class="anamnesa form-control inputan onfocusoutvalidation"><?php echo $riwayatkeluarga;?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<?php if($datapemeriksaan['Anjuran'] != ''){ $anjuran = $datapemeriksaan['Anjuran']; }else{ $anjuran = "Tidak Ada"; } ?>
				<td><input type="text" name ="anjuran" class="form-control inputan onfocusoutvalidation" value="<?php echo $anjuran;?>"></td>
			</tr>
			<tr>
				<td>Hasil Lab.</td>
				<td>
					<?php
					$str_gettbtindakandetail = mysqli_query($koneksi, "SELECT b.Tindakan, a.Keterangan FROM $tbtindakanpasien a join tbtindakan b on a.IdTindakan = b.IdTindakan where a.IdPasienrj = '$idpasienrj'");
					if(mysqli_num_rows($str_gettbtindakandetail) > 0){
						while($dt_lab = mysqli_fetch_assoc($str_gettbtindakandetail)){
							$hasilsx []= $dt_lab['Tindakan'].": ".$dt_lab['Keterangan'];
						}
						$pem_lab = "".implode(", ",$hasilsx);
					}else{
						$pem_lab = "Tidak Ada";
					}
					?>
					<input type="text" name ="pemeriksaanpenunjanglab" class="form-control inputan onfocusoutvalidation" value="<?php echo $pem_lab;?>"> <?php //echo $datapemeriksaan['PemeriksaanHasilLab']."".$pem_lab;?>
				</td>
			</tr>
			<tr>
				<td>Faktor Resiko Lainnya</td>
				<td>
					<?php
						$arrfaktoresikolain = explode(",",$datapemeriksaan['FaktorResikoLainnya']);
					?>
					<div class="row">
						<div class="col-md-4">
							<label><input type="checkbox" name="faktoresikolain[]" value="Apakah Merokok" <?php if(in_array("Apakah Merokok", $arrfaktoresikolain)){echo "CHECKED";}?>> Apakah Merokok</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Riwayat Alergi Obat" <?php if(in_array("Riwayat Alergi Obat", $arrfaktoresikolain)){echo "CHECKED";}?>> Riwayat Alergi Obat</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Riwayat Asma" <?php if(in_array("Riwayat Asma", $arrfaktoresikolain)){echo "CHECKED";}?>> Riwayat Asma</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Makan Sayur & Buah" <?php if(in_array("Makan Sayur & Buah", $arrfaktoresikolain)){echo "CHECKED";}?>> Makan Sayur & Buah</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Minum Alkohol" <?php if(in_array("Minum Alkohol", $arrfaktoresikolain)){echo "CHECKED";}?>> Minum Alkohol</label><br/>
							<label><input type="checkbox" name="faktoresikolain[]" value="Aktifitas Fisik" <?php if(in_array("Aktifitas Fisik", $arrfaktoresikolain)){echo "CHECKED";}?>> Aktifitas Fisik</label><br/>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>	
</div>