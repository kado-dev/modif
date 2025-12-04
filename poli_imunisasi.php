<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];

	// tbpasienrj
	$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT TanggalRegistrasi FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));
	$tanggalregistrasi_puskesmas = $datapasienrj['TanggalRegistrasi'];

	// tbpoliimunisasi
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpoliimunisasi` where `NoPemeriksaan` = '$noregistrasi'"));

	// tbpoligizi
	$datagizi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpoligizi` WHERE `NoPemeriksaan` = '$noregistrasi'"));
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<?php  if($kota == "KOTA TARAKAN"){ ?>
				<div class="col-lg-12">
					<p><b>STATUS GIZI</b><br/>
					<?php 
						$datagizi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpoligizi` WHERE `NoPemeriksaan` = '$noregistrasi'"));
					?>
						<?php if($datagizi['Ntob']!=''){echo "NTOB : ".$datagizi['Ntob'];}else{echo "NTOB : Belum di Inputkan";}?><br/>
						<?php if($datagizi['Bbu']!=''){echo "BB/U : ".$datagizi['Bbu'];}else{echo "BB/U : Belum di Inputkan";}?><br/>
						<?php if($datagizi['Tbu']!=''){echo "TB/U : ".$datagizi['Tbu'];}else{echo "TB/U : Belum di Inputkan";}?><br/>
						<?php if($datagizi['Bbtb']!=''){echo "BB/TB : ".$datagizi['Bbtb'];}else{echo "BB/TB : Belum di Inputkan";}?><br/>
						<?php if($datagizi['Asi']!=''){if ($datagizi['Asi'] == "T"){echo "ASI : "."Tidak";}else{echo "ASI : "."Ya";}}else{echo "ASI : Belum di Inputkan";}?><br/>
						<?php if($datagizi['LingkarKepala']!=''){echo "Lingkar Kepala : ".$datagizi['LingkarKepala'];}else{echo "Lingkar Kepala : Belum di Inputkan";}?>
					</p>
				</div>
			<?php } ?>

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
				<td>Alergi imunisasi</td>
				<td><textarea name="alergi_imunisasi" class="form-control inputan"><?php echo $datapemeriksaan['AlergiImunisasi'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type ="text" name ="anjuran" class="form-control inputan" value="<?php echo $datapemeriksaan['Anjuran'];?>"></text></td>
			</tr>
			<tr>
				<td>Hasil Lab.</td>
				<td>
				<?php
				$str_gettbtindakandetail = mysqli_query($koneksi,"SELECT Keterangan from tbtindakanpasiendetail a join tbtindakan b on a.KodeTindakan = b.KodeTindakan where a.NoRegistrasi = '$noregistrasi'");
				if(mysqli_num_rows($str_gettbtindakandetail) > 0){
					while($dt_lab = mysqli_fetch_assoc($str_gettbtindakandetail)){
						$hasilsx []= $dt_lab['Keterangan'];
					}
					$pem_lab = " ".implode(", ",$hasilsx);
				}else{
					$pem_lab = "";
				}
				?>
					<input type="text" name ="pemeriksaanpenunjanglab" class="form-control inputan" value="<?php echo $datagizi['PemeriksaanHasilLab']."".$pem_lab;?>">
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
				
<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">	
				<h3 class="judul mt-4"><b>Pemeriksaan Imunisasi</b></h3>
				<tr>
					<td>Riwayat Imunisasi Sebelumnya</td>
					<td>
					<?php
					$arrImuniRwt = explode(",",$datapemeriksaan['RiwayatImunisasi']);
					?>
						<div class="row">
							<div class="col-md-3">
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="HBO" <?php if(in_array("HBO", $arrImuniRwt)){echo "CHECKED";}?>> HBO</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="BCG" <?php if(in_array("BCG", $arrImuniRwt)){echo "CHECKED";}?>> BCG</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="DPT HB HiB 1" <?php if(in_array("DPT HB HiB 1", $arrImuniRwt)){echo "CHECKED";}?>> DPT HB HiB 1</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="DPT HB HiB 2" <?php if(in_array("DPT HB HiB 2", $arrImuniRwt)){echo "CHECKED";}?>> DPT HB HiB 2</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="DPT HB HiB 3" <?php if(in_array("DPT HB HiB 3", $arrImuniRwt)){echo "CHECKED";}?>> DPT HB HiB 3</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Polio 1" <?php if(in_array("Polio 1", $arrImuniRwt)){echo "CHECKED";}?>> Polio 1</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Polio 2" <?php if(in_array("Polio 2", $arrImuniRwt)){echo "CHECKED";}?>> Polio 2</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Polio 3" <?php if(in_array("Polio 3", $arrImuniRwt)){echo "CHECKED";}?>> Polio 3</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Polio 4" <?php if(in_array("Polio 4", $arrImuniRwt)){echo "CHECKED";}?>> Polio 4</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="PCV 1" <?php if(in_array("PCV 1", $arrImuniRwt)){echo "CHECKED";}?>> PCV 1</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="PCV 2" <?php if(in_array("PCV 2", $arrImuniRwt)){echo "CHECKED";}?>> PCV 2</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="PCV 3" <?php if(in_array("PCV 3", $arrImuniRwt)){echo "CHECKED";}?>> PCV 3</label><br/>
							</div>
							<div class="col-md-9">
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="IPV" <?php if(in_array("IPV", $arrImuniRwt)){echo "CHECKED";}?>> IPV</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="IPV 2" <?php if(in_array("IPV 2", $arrImuniRwt)){echo "CHECKED";}?>> IPV 2</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="JE" <?php if(in_array("JE", $arrImuniRwt)){echo "CHECKED";}?>> Japanese Encephalitis</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Rotavirus 1" <?php if(in_array("Rotavirus 1", $arrImuniRwt)){echo "CHECKED";}?>> Rotavirus 1</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Rotavirus 2" <?php if(in_array("Rotavirus 2", $arrImuniRwt)){echo "CHECKED";}?>> Rotavirus 2</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Rotavirus 3" <?php if(in_array("Rotavirus 3", $arrImuniRwt)){echo "CHECKED";}?>> Rotavirus 3</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="CAMPAK RUBELLA" <?php if(in_array("CAMPAK RUBELLA", $arrImuniRwt)){echo "CHECKED";}?>> CAMPAK RUBELLA</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="BOOSTER CAMPAK RUBELLA" <?php if(in_array("BOOSTER CAMPAK RUBELLA", $arrImuniRwt)){echo "CHECKED";}?>> BOOSTER CAMPAK RUBELLA</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="BOOSTER DPT HB HiB" <?php if(in_array("BOOSTER DPT HB HiB", $arrImuniRwt)){echo "CHECKED";}?>> BOOSTER DPT HB HiB</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="DT" <?php if(in_array("DT", $arrImuniRwt)){echo "CHECKED";}?>> DT (BIAS)</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Td Kelas 2" <?php if(in_array("Td Kelas 2", $arrImuniRwt)){echo "CHECKED";}?>> Td Kelas 2 (BIAS)</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Td Kelas 5" <?php if(in_array("Td Kelas 5", $arrImuniRwt)){echo "CHECKED";}?>> Td Kelas 5 (BIAS)</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Td1" <?php if(in_array("Td1", $arrImuniRwt)){echo "CHECKED";}?>> Td1</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Td2" <?php if(in_array("Td2", $arrImuniRwt)){echo "CHECKED";}?>> Td2</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Td3" <?php if(in_array("Td3", $arrImuniRwt)){echo "CHECKED";}?>> Td3</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Td4" <?php if(in_array("Td4", $arrImuniRwt)){echo "CHECKED";}?>> Td4</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="Td5" <?php if(in_array("Td5", $arrImuniRwt)){echo "CHECKED";}?>> Td5</label><br/>
								<label><input type="checkbox" name="riwayat_imunisasi[]" value="VAR" <?php if(in_array("VAR", $arrImuniRwt)){echo "CHECKED";}?>> VAR</label>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">KIPI</td>
					<td class="col-sm-10">
					<?php
					$arrKipi = explode(",",$datapemeriksaan['Kipi']);
					?>
						<div class="row">
							<div class="col-md-4">
								<label><input type="checkbox" name="kipi[]" value="Demam" <?php if(in_array("Demam", $arrKipi)){echo "CHECKED";}?>> Demam</label><br/>
								<label><input type="checkbox" name="kipi[]" value="Bengkak dilokasi Penyuntikan" <?php if(in_array("Bengkak dilokasi Penyuntikan", $arrKipi)){echo "CHECKED";}?>> Bengkak dilokasi Penyuntikan</label><br/>
								<label><input type="checkbox" name="kipi[]" value="Kemerahan dilokasi penyuntikan" <?php if(in_array("Kemerahan dilokasi penyuntikan", $arrKipi)){echo "CHECKED";}?>> Kemerahan dilokasi penyuntikan</label><br/>
								<label><input type="checkbox" name="kipi[]" value="Muntah" <?php if(in_array("Muntah", $arrKipi)){echo "CHECKED";}?>> Muntah</label><br/>
								<label><input type="checkbox" name="kipi[]" value="Diare" <?php if(in_array("Diare", $arrKipi)){echo "CHECKED";}?>> Diare</label><br/>
								<label><input type="checkbox" name="kipi[]" value="Lainnya" <?php if(in_array("Lainnya", $arrKipi)){echo "CHECKED";}?>> Lainnya</label><br/>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">Jika lainnya, sebutkan</td>
					<td class="col-sm-9">
						<textarea name="kipilainnya" class="form-control inputan"><?php echo $datapemeriksaan['KipiLainnya'];?></textarea>
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">Imunisasi yang diBerikan Sekarang</td>
					<td class="col-sm-9">
					<?php
					$arrImuni = explode(",",$datapemeriksaan['ImunisasiSekarang']);
					?>
						<div class="row">
							<div class="col-md-3">
								<label><input type="checkbox" name="jenis_imunisasi[]" value="HBO" <?php if(in_array("HBO", $arrImuni)){echo "CHECKED";}?>> HBO</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="BCG" <?php if(in_array("BCG", $arrImuni)){echo "CHECKED";}?>> BCG</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="DPT HB HiB 1" <?php if(in_array("DPT HB HiB 1", $arrImuni)){echo "CHECKED";}?>> DPT HB HiB 1</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="DPT HB HiB 2" <?php if(in_array("DPT HB HiB 2", $arrImuni)){echo "CHECKED";}?>> DPT HB HiB 2</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="DPT HB HiB 3" <?php if(in_array("DPT HB HiB 3", $arrImuni)){echo "CHECKED";}?>> DPT HB HiB 3</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Polio 1" <?php if(in_array("Polio 1", $arrImuni)){echo "CHECKED";}?>> Polio 1</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Polio 2" <?php if(in_array("Polio 2", $arrImuni)){echo "CHECKED";}?>> Polio 2</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Polio 3" <?php if(in_array("Polio 3", $arrImuni)){echo "CHECKED";}?>> Polio 3</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Polio 4" <?php if(in_array("Polio 4", $arrImuni)){echo "CHECKED";}?>> Polio 4</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="PCV 1" <?php if(in_array("PCV 1", $arrImuni)){echo "CHECKED";}?>> PCV 1</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="PCV 2" <?php if(in_array("PCV 2", $arrImuni)){echo "CHECKED";}?>> PCV 2</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="PCV 3" <?php if(in_array("PCV 3", $arrImuni)){echo "CHECKED";}?>> PCV 3</label><br/>
							</div>
							<div class="col-md-6">
								<label><input type="checkbox" name="jenis_imunisasi[]" value="IPV" <?php if(in_array("IPV", $arrImuni)){echo "CHECKED";}?>> IPV</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="IPV 2" <?php if(in_array("IPV 2", $arrImuni)){echo "CHECKED";}?>> IPV 2</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="JE" <?php if(in_array("JE", $arrImuni)){echo "CHECKED";}?>> Japanese Encephalitis</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Rotavirus 1" <?php if(in_array("Rotavirus 1", $arrImuni)){echo "CHECKED";}?>> Rotavirus 1</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Rotavirus 2" <?php if(in_array("Rotavirus 2", $arrImuni)){echo "CHECKED";}?>> Rotavirus 2</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Rotavirus 3" <?php if(in_array("Rotavirus 3", $arrImuni)){echo "CHECKED";}?>> Rotavirus 3</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="CAMPAK RUBELLA" <?php if(in_array("CAMPAK RUBELLA", $arrImuni)){echo "CHECKED";}?>> CAMPAK RUBELLA</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="BOOSTER CAMPAK RUBELLA" <?php if(in_array("BOOSTER CAMPAK RUBELLA", $arrImuni)){echo "CHECKED";}?>> BOOSTER CAMPAK RUBELLA</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="BOOSTER DPT HB HiB" <?php if(in_array("BOOSTER DPT HB HiB", $arrImuni)){echo "CHECKED";}?>> BOOSTER DPT HB HiB</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="DT" <?php if(in_array("DT", $arrImuni)){echo "CHECKED";}?>> DT</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Td Kelas 2" <?php if(in_array("Td Kelas 2", $arrImuni)){echo "CHECKED";}?>> Td Kelas 2 (BIAS)</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Td Kelas 5" <?php if(in_array("Td Kelas 5", $arrImuni)){echo "CHECKED";}?>> Td Kelas 5 (BIAS)</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Td1" <?php if(in_array("Td1", $arrImuni)){echo "CHECKED";}?>> Td1</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Td2" <?php if(in_array("Td2", $arrImuni)){echo "CHECKED";}?>> Td2</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Td3" <?php if(in_array("Td3", $arrImuni)){echo "CHECKED";}?>> Td3</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Td4" <?php if(in_array("Td4", $arrImuni)){echo "CHECKED";}?>> Td4</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="Td5" <?php if(in_array("Td5", $arrImuni)){echo "CHECKED";}?>> Td5</label><br/>
								<label><input type="checkbox" name="jenis_imunisasi[]" value="VAR" <?php if(in_array("VAR", $arrImuni)){echo "CHECKED";}?>> VAR</label>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">Tgl.Imunisasi Selanjutnya</td>
					<td class="col-sm-9">
						<?php
							if($datapemeriksaan['TglImunSelanjutnya'] == null){
								$tims = date('Y-m-d');
							}else{
								$tims = date('Y-m-d', strtotime($datapemeriksaan['TglImunSelanjutnya']));
							}	
						?>
						<input type="text" name="tgl_imun_selanjutnya" class="form-control inputan datepicker2" value="<?php echo $tims;?>">
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">ADS 0.05 ml</td>
					<td class="col-sm-9">
						<div class="input-group">
							<input type="text" name="ads_005" class="form-control inputan" value="<?php if($datapemeriksaan['Ads005'] != ""){ echo $datapemeriksaan['Ads005'];}else{ echo "0";}?>" maxlength="2">
							<div class="input-group-append">
								<span class="input-group-text">Jumlah</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">ADS 0.5 ml</td>
					<td class="col-sm-9">
						<div class="input-group">
							<input type="text" name="ads_05" class="form-control inputan" value="<?php if($datapemeriksaan['Ads05'] != ""){ echo $datapemeriksaan['Ads05'];}else{ echo "0";}?>" maxlength="2">
							<div class="input-group-append">
								<span class="input-group-text">Jumlah</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-sm-3">ADS 5 ml</td>
					<td class="col-sm-9">
						<div class="input-group">
							<input type="text" name="ads_5" class="form-control inputan" value="<?php if($datapemeriksaan['Ads5'] != ""){ echo $datapemeriksaan['Ads5'];}else{ echo "0";}?>" maxlength="2">
							<div class="input-group-append">
								<span class="input-group-text">Jumlah</span>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>