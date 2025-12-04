<?php
	$idpasienrj = $_GET['id'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'"));

	// vital sign
	$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
	$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
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
					<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan"><?php echo $dtvs['Keluhan'];?></textarea></td>
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
					<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan"><?php echo $dtvs['Anamnesa'];?></textarea></td>
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
					<td><input type ="text" name ="anjuran" class="form-control inputan" style="text-transform: uppercase;" value="<?php echo $datapemeriksaan['Anjuran'];?>"></text></td>
				</tr>
				<tr>
					<td>Hasil Lab.</td>
					<td>
						<?php
						$str_gettbtindakandetail = mysqli_query($koneksi,"SELECT Keterangan FROM tbtindakanpasiendetail a join tbtindakan b on a.KodeTindakan = b.KodeTindakan where a.NoRegistrasi = '$noregistrasi'");
						if(mysqli_num_rows($str_gettbtindakandetail) > 0){
							while($dt_lab = mysqli_fetch_assoc($str_gettbtindakandetail)){
								$hasilsx []= $dt_lab['Keterangan'];
							}
							$pem_lab = " ".implode(", ",$hasilsx);
						}else{
							$pem_lab = "";
						}
						?>
						<input type="text" name ="pemeriksaanpenunjanglab" class="form-control inputan" value="<?php echo $datapemeriksaan['PemeriksaanHasilLab']."".$pem_lab;?>">
					</td>
				</tr>
				<tr>
					<td>Pemeriksaan Penunjang</td>
					<td>
						<?php
							$arrprkpenunjang = explode(",",$datapemeriksaan['PemeriksaanPenunjang']);
						?>
						<div class="row">
							<div class="col-md-4">
								<label><input type="checkbox" name="prkpenunjang[]" value="Apakah Merokok" <?php if(in_array("Apakah Merokok", $arrprkpenunjang)){echo "CHECKED";}?>> Apakah Merokok</label><br/>
								<label><input type="checkbox" name="prkpenunjang[]" value="Riwayat Alergi Obat" <?php if(in_array("Riwayat Alergi Obat", $arrprkpenunjang)){echo "CHECKED";}?>> Riwayat Alergi Obat</label><br/>
								<label><input type="checkbox" name="prkpenunjang[]" value="Riwayat Asma" <?php if(in_array("Riwayat Asma", $arrprkpenunjang)){echo "CHECKED";}?>> Riwayat Asma</label><br/>
								<label><input type="checkbox" name="prkpenunjang[]" value="Makan Sayur & Buah" <?php if(in_array("Makan Sayur & Buah", $arrprkpenunjang)){echo "CHECKED";}?>> Makan Sayur & Buah</label><br/>
								<label><input type="checkbox" name="prkpenunjang[]" value="Minum Alkohol" <?php if(in_array("Minum Alkohol", $arrprkpenunjang)){echo "CHECKED";}?>> Minum Alkohol</label><br/>
								<label><input type="checkbox" name="prkpenunjang[]" value="Aktifitas Fisik" <?php if(in_array("Aktifitas Fisik", $arrprkpenunjang)){echo "CHECKED";}?>> Aktifitas Fisik</label><br/>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>	
	</div>
