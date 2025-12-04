<?php
	if($kota == 'KOTA TARAKAN'){
		$tbpolitb = 'tbpolitb';
	}else{
		$tbpolitb = 'tbpolitbdots';
	}

	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpolitb` WHERE `NoPemeriksaan` = '$noregistrasi'"));

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
				<td><input type="text" name ="anjuran" class="form-control inputan" value="<?php echo $datapemeriksaan['Anjuran'];?>"></td>
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
</div><br/>		

<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">Pemeriksaan Terduga TB</p>
				<tr>
					<td class="col-sm-3">Asal Rujukan Terduga TB</td>
					<td class="col-sm-9">
						<select name="asalrujukan" class="form-control inputan">
							<option value="IP" <?php if($datapemeriksaan['AsalRujukan'] == 'IP'){echo "SELECTED";}?>>Inisiatif Pasien</option>
							<option value="AM" <?php if($datapemeriksaan['AsalRujukan'] == 'AM'){echo "SELECTED";}?>>Anggota Masyarakat</option>
							<option value="FK" <?php if($datapemeriksaan['AsalRujukan'] == 'FK'){echo "SELECTED";}?>>Fasilitas Kesehatan</option>
							<option value="DPM" <?php if($datapemeriksaan['AsalRujukan'] == 'DPM'){echo "SELECTED";}?>>Dokter Praktik Mandiri</option>
							<option value="K" <?php if($datapemeriksaan['AsalRujukan'] == 'K'){echo "SELECTED";}?>>Kader</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Riwayat Pengobatan</td>
					<td>
						<select name="riwayatpengobatan" class="form-control inputan">
							<option value="P" <?php if($datapemeriksaan['RiwayatPengobatan'] == 'P'){echo "SELECTED";}?>>Pernah</option>
							<option value="TP" <?php if($datapemeriksaan['RiwayatPengobatan'] == 'TP'){echo "SELECTED";}?>>Tidak Pernah</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Diduga TB Ekstra Paru</td>
					<td>
						<select name="didugatb" class="form-control inputan">
							<option value="YA" <?php if($datapemeriksaan['DidugaTB'] == 'YA'){echo "SELECTED";}?>>YA</option>
							<option value="TIDAK" <?php if($datapemeriksaan['DidugaTB'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Total Skoring TB ANAK</td>
					<td>
						<select name="totalskoring" class="form-control inputan">
							<option value="0" <?php if($datapemeriksaan['TotalSkoring'] == '0'){echo "SELECTED";}?>>0</option>
							<option value="1" <?php if($datapemeriksaan['TotalSkoring'] == '1'){echo "SELECTED";}?>>1</option>
							<option value="2" <?php if($datapemeriksaan['TotalSkoring'] == '2'){echo "SELECTED";}?>>2</option>
							<option value="3" <?php if($datapemeriksaan['TotalSkoring'] == '3'){echo "SELECTED";}?>>3</option>
							<option value="4" <?php if($datapemeriksaan['TotalSkoring'] == '4'){echo "SELECTED";}?>>4</option>
							<option value="5" <?php if($datapemeriksaan['TotalSkoring'] == '5'){echo "SELECTED";}?>>5</option>
							<option value="6" <?php if($datapemeriksaan['TotalSkoring'] == '6'){echo "SELECTED";}?>>6</option>
							<option value="7" <?php if($datapemeriksaan['TotalSkoring'] == '7'){echo "SELECTED";}?>>7</option>
							<option value="8" <?php if($datapemeriksaan['TotalSkoring'] == '8'){echo "SELECTED";}?>>8</option>
							<option value="9" <?php if($datapemeriksaan['TotalSkoring'] == '9'){echo "SELECTED";}?>>9</option>
							<option value="10" <?php if($datapemeriksaan['TotalSkoring'] == '10'){echo "SELECTED";}?>>10</option>
							<option value="11" <?php if($datapemeriksaan['TotalSkoring'] == '11'){echo "SELECTED";}?>>11</option>
							<option value="12" <?php if($datapemeriksaan['TotalSkoring'] == '12'){echo "SELECTED";}?>>12</option>
							<option value="13" <?php if($datapemeriksaan['TotalSkoring'] == '13'){echo "SELECTED";}?>>13</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Tgl.Pengambilan Dahak</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TglDahak'] == null){
									$tgldahak = date('Y-m-d');
								}else{
									$tgldahak = date('Y-m-d', strtotime($datapemeriksaan['TglDahak']));
								}	
							?>
							<input type="text" name="tgl_dahak" class="form-control inputan datepicker2" value="<?php echo $tgldahak;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3"><b>Mikroskopis</b></td>
				</tr>
				<tr>
					<td>Tgl.Hasil Diperoleh</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TglMikoskopis'] == null){
									$tglmikroskopis = date('Y-m-d');
								}else{
									$tglmikroskopis = date('Y-m-d', strtotime($datapemeriksaan['TglMikoskopis']));
								}	
							?>
							<input type="text" name="tgl_mikroskopis" class="form-control inputan datepicker2" value="<?php echo $tglmikroskopis;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Hasil A</td>
					<td class="col-sm-10">
						<input type ="text" name ="hasil_a" class="form-control inputan" maxlength="20" value="<?php echo $datapemeriksaan['HasilA'];?>">
					</td>
				</tr>
				<tr>
					<td>Hasil B</td>
					<td class="col-sm-10">
						<input type ="text" name ="hasil_b" class="form-control inputan" maxlength="20" value="<?php echo $datapemeriksaan['HasilB'];?>">
					</td>
				</tr>
				<tr>
					<td>Hasil C</td>
					<td class="col-sm-10">
						<input type ="text" name ="hasil_c" class="form-control inputan" maxlength="20" value="<?php echo $datapemeriksaan['HasilC'];?>">
					</td>
				</tr>
				<tr>
					<td colspan="3"><b>Biakan</b></td>
				</tr>
				<tr>
					<td>Tgl.Hasil Diperoleh</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TglBiakan'] == null){
									$tglbiakan = date('Y-m-d');
								}else{
									$tglbiakan = date('Y-m-d', strtotime($datapemeriksaan['TglBiakan']));
								}	
							?>
							<input type="text" name="tgl_biakan" class="form-control inputan datepicker2" value="<?php echo $tglbiakan;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Hasil</td>
					<td class="col-sm-10">
						<input type ="text" name ="hasil_biakan" class="form-control inputan" maxlength="20" value="<?php echo $datapemeriksaan['HasilBiakan'];?>">
					</td>
				</tr>
				<tr>
					<td colspan="3"><b>Uji Kepekaan</b></td>
				</tr>
				<tr>
					<td>Tgl.Hasil Diperoleh</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TglKepekaan'] == null){
									$tglkepekaan = date('Y-m-d');
								}else{
									$tglkepekaan = date('Y-m-d', strtotime($datapemeriksaan['TglKepekaan']));
								}	
							?>
							<input type="text" name="tgl_kepekaan" class="form-control inputan datepicker2" value="<?php echo $tglkepekaan;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Hasil (H)</td>
					<td class="col-sm-10">
						<select name="hasil_kepekaan_h" class="form-control inputan">
							<option value="S" <?php if($datapemeriksaan['HasilH'] == 'S'){echo "SELECTED";}?>>Sensitif</option>
							<option value="R" <?php if($datapemeriksaan['HasilH'] == 'R'){echo "SELECTED";}?>>Resisten</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Hasil (R)</td>
					<td class="col-sm-10">
						<select name="hasil_kepekaan_r" class="form-control inputan">
							<option value="S" <?php if($datapemeriksaan['HasilR'] == 'S'){echo "SELECTED";}?>>Sensitif</option>
							<option value="R" <?php if($datapemeriksaan['HasilR'] == 'R'){echo "SELECTED";}?>>Resisten</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Hasil (Z)</td>
					<td class="col-sm-10">
						<select name="hasil_kepekaan_z" class="form-control inputan">
							<option value="S" <?php if($datapemeriksaan['HasilZ'] == 'S'){echo "SELECTED";}?>>Sensitif</option>
							<option value="R" <?php if($datapemeriksaan['HasilZ'] == 'R'){echo "SELECTED";}?>>Resisten</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Hasil (E)</td>
					<td class="col-sm-10">
						<select name="hasil_kepekaan_e" class="form-control inputan">
							<option value="S" <?php if($datapemeriksaan['HasilE'] == 'S'){echo "SELECTED";}?>>Sensitif</option>
							<option value="R" <?php if($datapemeriksaan['HasilE'] == 'R'){echo "SELECTED";}?>>Resisten</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Hasil (S)</td>
					<td class="col-sm-10">
						<select name="hasil_kepekaan_s" class="form-control inputan">
							<option value="S" <?php if($datapemeriksaan['HasilS'] == 'S'){echo "SELECTED";}?>>Sensitif</option>
							<option value="R" <?php if($datapemeriksaan['HasilS'] == 'R'){echo "SELECTED";}?>>Resisten</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Hasil (Km)</td>
					<td class="col-sm-10">
						<select name="hasil_kepekaan_km" class="form-control inputan">
							<option value="S" <?php if($datapemeriksaan['HasilKm'] == 'S'){echo "SELECTED";}?>>Sensitif</option>
							<option value="R" <?php if($datapemeriksaan['HasilKm'] == 'R'){echo "SELECTED";}?>>Resisten</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Hasil (Amk)</td>
					<td class="col-sm-10">
						<select name="hasil_kepekaan_amk" class="form-control inputan">
							<option value="S" <?php if($datapemeriksaan['HasilAmk'] == 'S'){echo "SELECTED";}?>>Sensitif</option>
							<option value="R" <?php if($datapemeriksaan['HasilAmk'] == 'R'){echo "SELECTED";}?>>Resisten</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Hasil (Ofx)</td>
					<td class="col-sm-10">
						<select name="hasil_kepekaan_ofx" class="form-control inputan">
							<option value="S" <?php if($datapemeriksaan['HasilOfx'] == 'S'){echo "SELECTED";}?>>Sensitif</option>
							<option value="R" <?php if($datapemeriksaan['HasilOfx'] == 'R'){echo "SELECTED";}?>>Resisten</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="3"><b>Xpert MTB/RIF</b></td>
				</tr>
				<tr>
					<td>Tgl.Hasil Diperoleh</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TglXpert'] == null){
									$tglexpert = date('Y-m-d');
								}else{
									$tglexpert = date('Y-m-d', strtotime($datapemeriksaan['TglXpert']));
								}	
							?>
							<input type="text" name="tgl_xpert" class="form-control inputan datepicker2" value="<?php echo $tglexpert;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Hasil</td>
					<td class="col-sm-10">
						<select name="hasil_xpert" class="form-control inputan">
							<option value="Neg" <?php if($datapemeriksaan['HasilXpert'] == 'S'){echo "SELECTED";}?>>MTB Not Detected</option>
							<option value="Rif Sen" <?php if($datapemeriksaan['HasilXpert'] == 'Rif Sen'){echo "SELECTED";}?>>MTB Detected, Rif Resistance Not Detected</option>
							<option value="Rif Res" <?php if($datapemeriksaan['HasilXpert'] == 'Rif Res'){echo "SELECTED";}?>>MTB Detected, Rif Resistance Detected</option>
							<option value="Rif Indet" <?php if($datapemeriksaan['HasilXpert'] == 'Rif Indet'){echo "SELECTED";}?>>MTB Detected, Rif Resistance Indeterminated</option>
							<option value="Invalid" <?php if($datapemeriksaan['HasilXpert'] == 'Invalid'){echo "SELECTED";}?>>Invalid</option>
							<option value="Error" <?php if($datapemeriksaan['HasilXpert'] == 'Error'){echo "SELECTED";}?>>Error</option>
							<option value="No Result" <?php if($datapemeriksaan['HasilXpert'] == 'No Result'){echo "SELECTED";}?>>No Result</option>
							<option value="Sensitif" <?php if($datapemeriksaan['HasilXpert'] == 'Sensitif'){echo "SELECTED";}?>>Sensitif</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="3"><b>LPA (Line Probe Assay)</b></td>
				</tr>
				<tr>
					<td>Tgl.Hasil Diperoleh</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TglLpa'] == null){
									$tgllpa = date('Y-m-d');
								}else{
									$tgllpa = date('Y-m-d', strtotime($datapemeriksaan['TglLpa']));
								}	
							?>
							<input type="text" name="tgl_lpa" class="form-control inputan datepicker2" value="<?php echo $tgllpa;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Hasil</td>
					<td class="col-sm-10">
						<select name="hasil_lpa" class="form-control inputan">
							<option value="MTB Neg" <?php if($datapemeriksaan['HasilLpa'] == 'MTB Neg'){echo "SELECTED";}?>>MTB Neg</option>
							<option value="INH Sen Rif Sen" <?php if($datapemeriksaan['HasilLpa'] == 'INH Sen Rif Sen'){echo "SELECTED";}?>>INH Sen, Rif Sen</option>
							<option value="INH Sen Rif Res" <?php if($datapemeriksaan['HasilLpa'] == 'INH Sen Rif Res'){echo "SELECTED";}?>>INH Sen, Rif Res</option>
							<option value="INH Res Rif Res" <?php if($datapemeriksaan['HasilLpa'] == 'INH Res Rif Res'){echo "SELECTED";}?>>INH Res, Rif Res</option>
							<option value="INH Res Rif Sen" <?php if($datapemeriksaan['HasilLpa'] == 'INH Res Rif Sen'){echo "SELECTED";}?>>INH Res, Rif Sen</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>No.Reg Lab (TB.04)</td>
					<td class="col-sm-10">
						<input type ="text" name ="noreg_tb04" class="form-control inputan" maxlength="20" value="<?php echo $datapemeriksaan['NoRegTB04'];?>">
					</td>
				</tr>
				<tr>
					<td>Hsl.Pemeriksaan Foto Toraks</td>
					<td class="col-sm-10">
						<input type ="text" name ="hasil_toraks" class="form-control inputan" maxlength="20" value="<?php echo $datapemeriksaan['HasilToraks'];?>">
					</td>
				</tr>
				<tr>
					<td>Kriteria Suspek MDR</td>
					<td class="col-sm-10">
						<select name="kriteria_mdr" class="form-control inputan">
							<option value="1" <?php if($datapemeriksaan['KriteriaMdr'] == '1'){echo "SELECTED";}?>>Pasien TB yang Gagal Pengobatan Kategori 2</option>
							<option value="2" <?php if($datapemeriksaan['KriteriaMdr'] == '2'){echo "SELECTED";}?>>Pasien TB Tidak Konversi Pada Pengobatan Kategori 2</option>
							<option value="3" <?php if($datapemeriksaan['KriteriaMdr'] == '3'){echo "SELECTED";}?>>Pasien TB Dengan Riwayat Pengobatan TB di Faskes Non DOTS</option>
							<option value="4" <?php if($datapemeriksaan['KriteriaMdr'] == '4'){echo "SELECTED";}?>>Pasien TB Gagal Pengobatan Kategori 1</option>
							<option value="5" <?php if($datapemeriksaan['KriteriaMdr'] == '5'){echo "SELECTED";}?>>Pasien TB Tidak Konversi Setelah 3 Bulan Kategori 1</option>
							<option value="6" <?php if($datapemeriksaan['KriteriaMdr'] == '6'){echo "SELECTED";}?>>Pasien TB Kambuh</option>
							<option value="7" <?php if($datapemeriksaan['KriteriaMdr'] == '7'){echo "SELECTED";}?>>Pasien TB yang Kembali Berobat Setelah Lalai/Default</option>
							<option value="8" <?php if($datapemeriksaan['KriteriaMdr'] == '8'){echo "SELECTED";}?>>Pasien TB Dengan Riwayat Kontak Erat Pasien TB MDR</option>
							<option value="9" <?php if($datapemeriksaan['KriteriaMdr'] == '9'){echo "SELECTED";}?>>Pasien Ko-Infeksi TB-HIV yang Tidak Respon Terhadap Pemberian OAT</option>
							<option value="10" <?php if($datapemeriksaan['KriteriaMdr'] == '10'){echo "SELECTED";}?>>Tidak Ada</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Status HIV</td>
					<td class="col-sm-10">
						<select name="status_hiv" class="form-control inputan">
							<option value="R" <?php if($datapemeriksaan['StatusHIV'] == 'R'){echo "SELECTED";}?>>Reaktif</option>
							<option value="NR" <?php if($datapemeriksaan['StatusHIV'] == 'NR'){echo "SELECTED";}?>>Non Reaktif</option>
							<option value="I" <?php if($datapemeriksaan['StatusHIV'] == 'I'){echo "SELECTED";}?>>Indeterminate</option>
							<option value="TD" <?php if($datapemeriksaan['StatusHIV'] == 'TD'){echo "SELECTED";}?>>Tidak Diketahui</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Rujukan Pengobatan TB/TB MDR</td>
					<td class="col-sm-10">
						<select name="rujukan_tb" class="form-control inputan">
							<option value="Y" <?php if($datapemeriksaan['RujukanTB'] == 'Y'){echo "SELECTED";}?>>Ya</option>
							<option value="T" <?php if($datapemeriksaan['RujukanTB'] == 'T'){echo "SELECTED";}?>>Tidak</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Tgl.Mulai Pengobatan TB</td>
					<td class="col-sm-10">
						<div class="input-group">
							<?php
								if($datapemeriksaan['TglPengobatanTB'] == null){
									$tglpengobatan = date('Y-m-d');
								}else{
									$tglpengobatan = date('Y-m-d', strtotime($datapemeriksaan['TglPengobatanTB']));
								}	
							?>
							<input type="text" name="tgl_pengobatan_tb" class="form-control inputan datepicker2" value="<?php echo $tglpengobatan;?>">
							<div class="input-group-append">
								<span class="input-group-text"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					</td>
				</tr>			
			</table>
		</div>
	</div>
</div><br/><br/>