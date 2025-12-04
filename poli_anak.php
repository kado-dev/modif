<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolianak` WHERE `NoPemeriksaan` = '$noregistrasi'"));
?>

<div class = "row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-lg-12">
				<?php 
					if($kota == "KABUPATEN BULUNGAN"){
						if($cekgizi > 0){	
				?>
				<div class="alert alert-block alert-success fade in">
					<p><b>Status Gizi</b></p>	
					<table class="table-judul" style="height:20px;">
						<tr>
							<td class="col-sm-2">NTOB</td>
							<td class="col-sm-10"><?php echo $datapemeriksaan['Ntob'];?></td>
						</tr>
						<tr>
							<td>BB/U</td>
							<td><?php echo $datapemeriksaan['Bbu'];?></td>
						</tr>
						<tr>
							<td>TB/U</td>
							<td><?php echo $datapemeriksaan['Tbu'];?></td>
						</tr>
						<tr>
							<td>BB/TB</td>
							<td><?php echo $datapemeriksaan['Bbtb'];?></td>
						</tr>
						<tr>
							<td>ASI</td>
							<td><?php if ($datapemeriksaan['Asi'] == "T"){echo "Tidak";}else{echo "Ya";}?></td>
						</tr>
						<tr>
							<td>Lingkar Kepala</td>
							<td><?php echo $datapemeriksaan['LingkarKepala'];?></td>
						</tr>
					</table>
				</div>
				<?php 
						}
					}
				?>
			</div>
		</div>

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
				<td class="col-sm-9"><textarea name="keluhan" class="keluhan form-control inputan"><?php echo $datapemeriksaan['Keluhan'];?></textarea></td>
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
				<td class="col-sm-9"><textarea name="anamnesa" class="anamnesa form-control inputan"><?php echo $datapemeriksaan['Anamnesa'];?></textarea></td>
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
						$pem_lab = "";
					}
					?>
					<input type="text" name ="pemeriksaanpenunjanglab" class="form-control inputan" value="<?php echo $pem_lab;?>"> <?php //echo $datapemeriksaan['PemeriksaanHasilLab']."".$pem_lab;?>
				</td>
			</tr>
		</table>
	</div>	
</div><br/>

<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">
					Tanda Vital & Pemeriksaan Fisik (Objektive)
				</p>
				<tr>
					<td class="col-sm-3">Keadaan Umum</td>
					<td class="col-sm-9">
						<select name="keadaanumum" class="form-control inputan">
							<option value="Baik" <?php if($datapemeriksaan['KeadaanUmum'] == 'Baik'){echo "SELECTED";}?>>Baik</option>
							<option value="Sangat Ringan" <?php if($datapemeriksaan['KeadaanUmum'] == 'Sangat Ringan'){echo "SELECTED";}?>>Sangat Ringan</option>
							<option value="Sakit Sedang" <?php if($datapemeriksaan['KeadaanUmum'] == 'Sakit Sedang'){echo "SELECTED";}?>>Sakit Sedang</option>
							<option value="Sakit Berat" <?php if($datapemeriksaan['KeadaanUmum'] == 'Sensorik Pendengaran'){echo "SELECTED";}?>>Sensorik Pendengaran</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Status Gizi</td>
					<td>
						<select name="statusgizi" class="form-control inputan" required>
							<option value="Baik" <?php if($datapemeriksaan['StatusGizi'] == 'Baik'){echo "SELECTED";}?>>Baik</option>
							<option value="Kurang" <?php if($datapemeriksaan['StatusGizi'] == 'Kurang'){echo "SELECTED";}?>>Kurang</option>
							<option value="Buruk" <?php if($datapemeriksaan['StatusGizi'] == 'Buruk'){echo "SELECTED";}?>>Buruk</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Pemeriksaan Penunjang</td>
					<td>
						<textarea type="text" name ="pemeriksaanpenunjangobj" class="form-control inputan"><?php echo strtoupper($datapemeriksaan['PemeriksaanPenunjang']);?></textarea>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
