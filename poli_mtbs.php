<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpolimtbs` WHERE `NoPemeriksaan` = '$noregistrasi'"));
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul">
			<tr>
				<td class="col-sm-3">Kunjungan</td>
				<td class="col-sm-9">
					<select name="kunjungan_mtbs" class="form-control inputan">
						<option value="PERTAMA" <?php if($datapemeriksaan['Kunjungan'] == 'PERTAMA'){echo "SELECTED";}?>>PERTAMA</option>
						<option value="ULANG" <?php if($datapemeriksaan['Kunjungan'] == 'ULANG'){echo "SELECTED";}?>>ULANG</option>
					</select>
				</td>
			</tr>
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
				<td class="col-sm-3">Anjuran</td>
				<td class="col-sm-9"><textarea name="anjuran" style="text-transform: uppercase;" class="form-control inputan" maxlength = "100"><?php echo $datapemeriksaan['Anjuran'];?></textarea></td>
			</tr>
			<tr>
				<td>Hasil Lab.</td>
				<td>
				<?php
				$str_gettbtindakandetail = mysqli_query($koneksi,"SELECT Keterangan FROM tbtindakanpasiendetail a JOIN tbtindakan b on a.KodeTindakan = b.KodeTindakan WHERE a.NoRegistrasi = '$noregistrasi'");
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
		</table>
	</div>	
</div>
<br/>
<div class = "row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<div id="accordion" class="accordion-style1 panel-group">
				<!--1. umum-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#umum">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;1. Tanda Bahaya Umum
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="umum">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-3">Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prkumum = explode(',',$datapemeriksaan['PemeriksaanUmum']);?>
										<label><input type="checkbox" name="prk_umum_mtbs[]" value="Tidak bisa minum" <?php if (in_array("Tidak bisa minum", $prkumum)) {echo "checked";}?>> Tidak bisa minum</label><br>
										<label><input type="checkbox" name="prk_umum_mtbs[]" value="Memuntahkan semuanya" <?php if (in_array("Memuntahkan semuanya", $prkumum)) {echo "checked";}?>> Memuntahkan semuanya</label><br>
										<label><input type="checkbox" name="prk_umum_mtbs[]" value="Kejang" <?php if (in_array("Kejang", $prkumum)) {echo "checked";}?>> Kejang</label><br>
										<label><input type="checkbox" name="prk_umum_mtbs[]" value="Letargis" <?php if (in_array("Letargis", $prkumum)) {echo "checked";}?>> Letargis</label>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Klasifikasi</td>
									<td class="col-sm-9">
										<select name="kls_umum_mtbs" class="form-control inputan">
											<option value="Ada" <?php if($datapemeriksaan['KlasifikasiUmum'] == 'Ada'){echo "SELECTED";}?>>Ada</option>
											<option value="Tidak Ada" <?php if($datapemeriksaan['KlasifikasiUmum'] == 'Tidak Ada'){echo "SELECTED";}?>>Tidak Ada</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Tindakan</td>
									<td class="col-sm-9">
										<input type="text" name="tind_umum_mtbs" style="text-transform: uppercase;" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan" value = "<?php echo $datapemeriksaan['TindakanUmum'];?>">
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--2. Pneumonia-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#Pneumonia">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;2. Pemeriksaan Pernafasan (Pneumonia)
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="Pneumonia">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-3">Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prkpneu = explode(',',$datapemeriksaan['PemeriksaanPneumonia']);?>
										<label><input type="checkbox" name="prk_pneu_mtbs[]" value="Anak batuk/Sukar bernafas" <?php if (in_array("Anak batuk/Sukar bernafas", $prkpneu)) {echo "checked";}?>> Anak batuk/Sukar bernafas</label><br>
										<label><input type="checkbox" name="prk_pneu_mtbs[]" value="Napas cepat" <?php if (in_array("Napas cepat", $prkpneu)) {echo "checked";}?>> Napas cepat</label><br>
										<label><input type="checkbox" name="prk_pneu_mtbs[]" value="Lihat tarikan dinding dada kedalam" <?php if (in_array("Lihat tarikan dinding dada kedalam", $prkpneu)) {echo "checked";}?>> Lihat tarikan dinding dada kedalam</label><br>
										<label><input type="checkbox" name="prk_pneu_mtbs[]" value="Dengar adanya stridor" <?php if (in_array("Dengar adanya stridor", $prkpneu)) {echo "checked";}?>> Dengar adanya stridor</label>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Berapa Lama</td>
									<td class="col-sm-9">
										<input type="text" name="bl_pneu_mtbs" class="form-control inputan" maxlength = "2" placeholder = "Hari" value = "<?php echo $datapemeriksaan['HariPneumonia'];?>"></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Napas cepat</td>
									<td class="col-sm-9">
										<input type="text" name="nc_pneu_mtbs" class="form-control inputan" maxlength = "2" placeholder = "Hitung Napas cepat dalam 1 menit" value = "<?php echo $datapemeriksaan['NapasPneumonia'];?>"></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Klasifikasi</td>
									<td class="col-sm-9">
										<select name="kls_pneu_mtbs" class="form-control inputan klasifikasi_mtbs_pneu">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiPneumonia'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Pneumonia Berat" <?php if($datapemeriksaan['KlasifikasiPneumonia'] == 'Pneumonia Berat'){echo "SELECTED";}?>>Pneumonia Berat</option>
											<option value="Pneumonia" <?php if($datapemeriksaan['KlasifikasiPneumonia'] == 'Pneumonia'){echo "SELECTED";}?>>Pneumonia</option>
											<option value="Batuk Bukan Pneumonia" <?php if($datapemeriksaan['KlasifikasiPneumonia'] == 'Batuk Bukan Pneumonia'){echo "SELECTED";}?> SELECTED>Batuk Bukan Pneumonia</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Tindakan</td>
									<td class="col-sm-9">
										<?php $tind_pneumonia = explode(',',$datapemeriksaan['TindakanPneumonia']);?>
										<label><input class="tindpneumonia tind_pneu_mtbs_1" type="checkbox" name="tind_pneu_mtbs[]" value="Beri dosis pertama antibiotik yang sesuai" <?php if (in_array("Beri dosis pertama antibiotik yang sesuai", $tind_pneumonia)) {echo "checked";}?>> Beri dosis pertama antibiotik yang sesuai</label><br>
										<label><input class="tindpneumonia tind_pneu_mtbs_2" type="checkbox" name="tind_pneu_mtbs[]" value="Rujuk segera" <?php if (in_array("Rujuk segera", $tind_pneumonia)) {echo "checked";}?>> Rujuk segera</label><br>
										<label><input class="tindpneumonia tind_pneu_mtbs_3" type="checkbox" name="tind_pneu_mtbs[]" value="Beri pelega tenggorokan dan pereda batuk yang aman" <?php if (in_array("Beri pelega tenggorokan dan pereda batuk yang aman", $tind_pneumonia)) {echo "checked";}?> CHECKED> Beri pelega tenggorokan dan pereda batuk yang aman</label><br>
										<label><input class="tindpneumonia tind_pneu_mtbs_4" type="checkbox" name="tind_pneu_mtbs[]" value="Rujuk untuk pemeriksaan lanjutan" <?php if (in_array("Rujuk untuk pemeriksaan lanjutan", $tind_pneumonia)) {echo "checked";}?> CHECKED> Rujuk untuk pemeriksaan lanjutan</label><br>
										<label><input class="tindpneumonia tind_pneu_mtbs_5" type="checkbox" name="tind_pneu_mtbs[]" value="Nasihati kapan kembali segera" <?php if (in_array("Nasihati kapan kembali segera", $tind_pneumonia)) {echo "checked";}?> CHECKED> Nasihati kapan kembali segera</label><br>
										<label><input class="tindpneumonia tind_pneu_mtbs_6" type="checkbox" name="tind_pneu_mtbs[]" value="Kunjungan ulang 2 hari" <?php if (in_array("Kunjungan ulang 2 hari", $tind_pneumonia)) {echo "checked";}?>> Kunjungan ulang 2 hari</label><br>
										<label><input class="tindpneumonia tind_pneu_mtbs_7" type="checkbox" name="tind_pneu_mtbs[]" value="Kunjungan ulang 5 hari jika tidak ada perbaikan" <?php if (in_array("Kunjungan ulang 5 hari jika tidak ada perbaikan", $tind_pneumonia)) {echo "checked";}?> CHECKED> Kunjungan ulang 5 hari jika tidak ada perbaikan</label><br>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--3. diare-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#diare">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;3. Pemeriksaan Diare
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="diare">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-3">Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prk_diare = explode(',',$datapemeriksaan['PemeriksaanDiare']);?>
										<label><input type="checkbox" name="prk_diare_mtbs[]" value="Anak terkena diare" <?php if (in_array("Anak terkena diare", $prk_diare)) {echo "checked";}?>> Anak terkena diare</label><br>
										<label><input type="checkbox" name="prk_diare_mtbs[]" value="Ada darah dalam tinja" <?php if (in_array("Ada darah dalam tinja", $prk_diare)) {echo "checked";}?>> Ada darah dalam tinja</label><br>
										<label><input type="checkbox" name="prk_diare_mtbs[]" value="Mata cekung" <?php if (in_array("Mata cekung", $prk_diare)) {echo "checked";}?>> Mata cekung</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Berapa Lama</td>
									<td class="col-sm-9">
										<input type="text" name="bl_diare_mtbs" class="form-control inputan" maxlength = "2" placeholder = "Hari" value = "<?php echo $datapemeriksaan['HariDiare'];?>"></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Keadaan Umum</td>
									<td class="col-sm-9">
										<?php $ku_diare = explode(',',$datapemeriksaan['KeadaanUmum']);?>
										<label><input type="checkbox" name="ku_diare_mtbs[]" value="Letargis" <?php if (in_array("Letargis", $ku_diare)) {echo "checked";}?>> Letargis</label><br>
										<label><input type="checkbox" name="ku_diare_mtbs[]" value="Gelisah" <?php if (in_array("Gelisah", $ku_diare)) {echo "checked";}?>> Gelisah</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Beri Anak Minum</td>
									<td class="col-sm-9">
										<?php $bam_diare = explode(',',$datapemeriksaan['BeriAnakMinum']);?>
										<label><input type="checkbox" name="bam_diare_mtbs[]" value="Tidak bisa minum" <?php if (in_array("Tidak bisa minum", $bam_diare)) {echo "checked";}?>> Tidak bisa minum</label><br>
										<label><input type="checkbox" name="bam_diare_mtbs[]" value="Haus minum dengan lahap" <?php if (in_array("Haus minum dengan lahap", $bam_diare)) {echo "checked";}?>> Haus minum dengan lahap</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Cubit Kulit Perut</td>
									<td class="col-sm-9">
										<?php $ckp_diare = explode(',',$datapemeriksaan['CubitPerut']);?>
										<label><input type="checkbox" name="ckp_diare_mtbs[]" value="Sangat lambat > 2 detik" <?php if (in_array("Sangat lambat > 2 detik", $ckp_diare)) {echo "checked";}?>> Sangat lambat > 2 detik</label><br>
										<label><input type="checkbox" name="ckp_diare_mtbs[]" value="Lambat" <?php if (in_array("Lambat", $ckp_diare)) {echo "checked";}?>> Lambat</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Klasifikasi <?php echo $datapemeriksaan['KlasifikasiDiare'];?></td>
									<td class="col-sm-9">
										<select name="kls_diare_mtbs" class="form-control inputan klasifikasi_mtbs_diare">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiDiare'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Dehidrasi Berat" <?php if($datapemeriksaan['KlasifikasiDiare'] == 'Dehidrasi Berat'){echo "SELECTED";}?>>Dehidrasi Berat</option>
											<option value="Dehidrasi Sedang atau Ringan" <?php if($datapemeriksaan['KlasifikasiDiare'] == 'Dehidrasi Sedang atau Ringan'){echo "SELECTED";}?>>Dehidrasi Sedang atau Ringan</option>
											<option value="Diare Tanpa Dehidrasi" <?php if($datapemeriksaan['KlasifikasiDiare'] == 'Diare Tanpa Dehidrasi'){echo "SELECTED";}?>>Diare Tanpa Dehidrasi</option>
											<option value="Diare Persisten Berat" <?php if($datapemeriksaan['KlasifikasiDiare'] == 'Diare Persisten Berat'){echo "SELECTED";}?>>Diare Persisten Berat</option>
											<option value="Diare Persisten" <?php if($datapemeriksaan['KlasifikasiDiare'] == 'Diare Persisten'){echo "SELECTED";}?>>Diare persisten</option>
											<option value="Disentri" <?php if($datapemeriksaan['KlasifikasiDiare'] == 'Disentri'){echo "SELECTED";}?>>Disentri</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Tindakan</td>
									<td class="col-sm-9">
										<?php $tind_diare = explode(',',$datapemeriksaan['TindakanDiare']);?>
										<label><input class="tinddiare tind_diare_mtbs_1" type="checkbox" name="tind_diare_mtbs[]" value="Beri cairan untuk diare berat & tab.zinc" <?php if (in_array("Beri cairan untuk diare berat & tab.zinc", $tind_diare)) {echo "checked";}?>> Beri cairan untuk diare berat & tab.zinc</label><br>
										<label><input class="tinddiare tind_diare_mtbs_2" type="checkbox" name="tind_diare_mtbs[]" value="Rujuk segera" <?php if (in_array("Rujuk segera", $tind_diare)) {echo "checked";}?>> Rujuk segera</label><br>
										<label><input class="tinddiare tind_diare_mtbs_3" type="checkbox" name="tind_diare_mtbs[]" value="Berikan asi & larutan oralit selama perjalanan" <?php if (in_array("Berikan asi & larutan oralit selama perjalanan", $tind_diare)) {echo "checked";}?>> Berikan asi & larutan oralit selama perjalanan</label><br>
										<label><input class="tinddiare tind_diare_mtbs_4" type="checkbox" name="tind_diare_mtbs[]" value="Berikan antibiotik untuk kolera" <?php if (in_array("Berikan antibiotik untuk kolera", $tind_diare)) {echo "checked";}?>> Berikan antibiotik untuk kolera</label><br>
										<label><input class="tinddiare tind_diare_mtbs_5" type="checkbox" name="tind_diare_mtbs[]" value="Beri cairan & makanan sesuai terapi B & tab.zinc" <?php if (in_array("Beri cairan & makanan sesuai terapi B & tab.zinc", $tind_diare)) {echo "checked";}?>> Beri cairan & makanan sesuai terapi B & tab.zinc</label><br>
										<label><input class="tinddiare tind_diare_mtbs_6" type="checkbox" name="tind_diare_mtbs[]" value="Nasihati kapan kembali segera" <?php if (in_array("Nasihati kapan kembali segera", $tind_diare)) {echo "checked";}?>> Nasihati kapan kembali segera</label><br>
										<label><input class="tinddiare tind_diare_mtbs_7" type="checkbox" name="tind_diare_mtbs[]" value="Kunjungan ulang 5 hari jika tidak ada perbaikan" <?php if (in_array("Kunjungan ulang 5 hari jika tidak ada perbaikan", $tind_diare)) {echo "checked";}?>> Kunjungan ulang 5 hari jika tidak ada perbaikan</label><br>
										<label><input class="tinddiare tind_diare_mtbs_8" type="checkbox" name="tind_diare_mtbs[]" value="Beri cairan & makanan sesuai terapi a & tab.zinc" <?php if (in_array("Beri cairan & makanan sesuai terapi a & tab.zinc", $tind_diare)) {echo "checked";}?>> Beri cairan & makanan sesuai terapi a & tab.zinc</label><br>
										<label><input class="tinddiare tind_diare_mtbs_9" type="checkbox" name="tind_diare_mtbs[]" value="Atasi dehidrasi sebelum rujuk kecuali ada klasifikasi berat" <?php if (in_array("Atasi dehidrasi sebelum rujuk kecuali ada klasifikasi berat", $tind_diare)) {echo "checked";}?>> Atasi dehidrasi sebelum rujuk kecuali ada klasifikasi berat</label><br>
										<label><input class="tinddiare tind_diare_mtbs_10" type="checkbox" name="tind_diare_mtbs[]" value="Nasihati pemberian makanan untuk diare persisten" <?php if (in_array("Nasihati pemberian makanan untuk diare persisten", $tind_diare)) {echo "checked";}?>> Nasihati pemberian makanan untuk diare persisten</label><br>
										<label><input class="tinddiare tind_diare_mtbs_11" type="checkbox" name="tind_diare_mtbs[]" value="Beri antibiotik yang sesuai" <?php if (in_array("Beri antibiotik yang sesuai", $tind_diare)) {echo "checked";}?>> Beri antibiotik yang sesuai</label><br>
										<label><input class="tinddiare tind_diare_mtbs_12" type="checkbox" name="tind_diare_mtbs[]" value="Kunjungan ulang 2 hari" <?php if (in_array("Kunjungan ulang 2 hari", $tind_diare)) {echo "checked";}?>> Kunjungan ulang 2 hari</label><br>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--4. demam/malaria-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#malaria">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;4. Pemeriksaan Demam (Malaria)
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="malaria">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-3">Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prk_malaria = explode(',',$datapemeriksaan['PemeriksaanDemam']);?>
										<label><input type="checkbox" name="prk_malaria_mtbs[]" value="Terkena demam" <?php if (in_array("Terkena demam", $prk_malaria)) {echo "checked";}?>> Terkena demam</label><br>
										<label><input type="checkbox" name="prk_malaria_mtbs[]" value="Lebih dari 7 hari demam setiap hari" <?php if (in_array("Lebih dari 7 hari demam setiap hari", $prk_malaria)) {echo "checked";}?>> Lebih dari 7 hari demam setiap hari</label><br>
										<label><input type="checkbox" name="prk_malaria_mtbs[]" value="Dapat anti malaria dalam 2 minggu terkhir" <?php if (in_array("Dapat anti malaria dalam 2 minggu terkhir", $prk_malaria)) {echo "checked";}?>> Dapat anti malaria dalam 2 minggu terkhir</label><br>
										<label><input type="checkbox" name="prk_malaria_mtbs[]" value="Menderita campak dalam 3 bulan terakhir" <?php if (in_array("Menderita campak dalam 3 bulan terakhir", $prk_malaria)) {echo "checked";}?>> Menderita campak dalam 3 bulan terakhir</label><br>
										<label><input type="checkbox" name="prk_malaria_mtbs[]" value="Kaku kuduk" <?php if (in_array("Kaku kuduk", $prk_malaria)) {echo "checked";}?>> Kaku kuduk</label><br>
										<label><input type="checkbox" name="prk_malaria_mtbs[]" value="Pilek" <?php if (in_array("Pilek", $prk_malaria)) {echo "checked";}?>> Pilek</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Daerah Resiko</td>
									<td class="col-sm-9">
										<select name="dr_malaria_mtbs" class="form-control inputan">
											<option value="Tinggi" <?php if($datapemeriksaan['DeteksiResiko'] == 'Tinggi'){echo "SELECTED";}?>>Tinggi</option>
											<option value="Rendah" <?php if($datapemeriksaan['DeteksiResiko'] == 'Rendah'){echo "SELECTED";}?>>Rendah</option>
											<option value="Tanpa Resiko" <?php if($datapemeriksaan['DeteksiResiko'] == 'Tanpa Resiko'){echo "SELECTED";}?>>Tanpa Resiko</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Berapa Lama</td>
									<td class="col-sm-9">
										<input type="text" name="bl_malaria_mtbs" class="form-control inputan" maxlength = "2" placeholder = "Hari" value = "<?php echo $datapemeriksaan['HariDemam'];?>"></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Tanda Campak</td>
									<td class="col-sm-9">
										<select name="tc_malaria_mtbs" class="form-control inputan">
											<option value="Ruam kemerahan di kulit yang menyeluruh" <?php if($datapemeriksaan['TandaCampak'] == 'Ruam kemerahan di kulit yang menyeluruh'){echo "SELECTED";}?>>Ruam kemerahan di kulit yang menyeluruh</option>
											<option value="Batuk pilek atau mata merah" <?php if($datapemeriksaan['TandaCampak'] == 'Batuk pilek atau mata merah'){echo "SELECTED";}?>>Batuk pilek atau mata merah</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Klasifikasi</td>
									<td class="col-sm-9">
										<select name="kls_malaria_mtbs" class="form-control inputan klasifikasi_mtbs_demam">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiDemam'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Penyakit Berat Dengan Demam" <?php if($datapemeriksaan['KlasifikasiDemam'] == 'Penyakit Berat Dengan Demam'){echo "SELECTED";}?>>Penyakit Berat Dengan Demam</option>
											<option value="Penyakit Malaria" <?php if($datapemeriksaan['KlasifikasiDemam'] == 'Penyakit Malaria'){echo "SELECTED";}?>>Penyakit Malaria</option>
											<option value="Demam Mungkin Bukan Malaria" <?php if($datapemeriksaan['KlasifikasiDemam'] == 'Demam Mungkin Bukan Malaria'){echo "SELECTED";}?>>Demam Mungkin Bukan Malaria</option>
											<option value="Demam Bukan Malaria" <?php if($datapemeriksaan['KlasifikasiDemam'] == 'Demam Bukan Malaria'){echo "SELECTED";}?> SELECTED>Demam Bukan Malaria</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Tindakan</td>
									<td class="col-sm-9">
										<?php $tind_malaria = explode(',',$datapemeriksaan['TindakanDemam']);?>
										<label><input class="tinddemam tind_demam_mtbs_1" type="checkbox" name="tind_malaria_mtbs[]" value="Beri dosis pertama suntikan Arthmeter" <?php if (in_array("Beri dosis pertama suntikan Arthmeter", $tind_malaria)) {echo "checked";}?>> Beri dosis pertama suntikan Arthmeter</label><br>
										<label><input class="tinddemam tind_demam_mtbs_2" type="checkbox" name="tind_malaria_mtbs[]" value="Beri dosis pertama suntikan Antibiotik" <?php if (in_array("Beri dosis pertama suntikan Antibiotik", $tind_malaria)) {echo "checked";}?>> Beri dosis pertama suntikan Antibiotik</label><br>
										<label><input class="tinddemam tind_demam_mtbs_3" type="checkbox" name="tind_malaria_mtbs[]" value="Beri dosis pertama parasetamol jk demam tinggi (38.5C)" <?php if (in_array("Beri dosis pertama parasetamol jk demam tinggi (38.5C)", $tind_malaria)) {echo "checked";}?> CHECKED> Beri dosis pertama parasetamol jk demam tinggi (38.5C)</label><br>
										<label><input class="tinddemam tind_demam_mtbs_4" type="checkbox" name="tind_malaria_mtbs[]" value="Cegah agar gula darah tdk turun" <?php if (in_array("Cegah agar gula darah tdk turun", $tind_malaria)) {echo "checked";}?>> Cegah agar gula darah tdk turun</label><br>
										<label><input class="tinddemam tind_demam_mtbs_5" type="checkbox" name="tind_malaria_mtbs[]" value="Rujuk segera" <?php if (in_array("Rujuk segera", $tind_malaria)) {echo "checked";}?>> Rujuk segera</label><br>
										<label><input class="tinddemam tind_demam_mtbs_6" type="checkbox" name="tind_malaria_mtbs[]" value="Beri antimalaria oral yg sesuai (lht bagan pengobatan)" <?php if (in_array("Beri antimalaria oral yg sesuai (lht bagan pengobatan)", $tind_malaria)) {echo "checked";}?>> Beri antimalaria oral yg sesuai (lht bagan pengobatan)</label><br>
										<label><input class="tinddemam tind_demam_mtbs_7" type="checkbox" name="tind_malaria_mtbs[]" value="Nasihati kapan kembali segera" <?php if (in_array("Nasihati kapan kembali segera", $tind_malaria)) {echo "checked";}?> CHECKED> Nasihati kapan kembali segera</label><br>
										<label><input class="tinddemam tind_demam_mtbs_8" type="checkbox" name="tind_malaria_mtbs[]" value="Kunjungan ulang 3 hari berturut-turut jika tetap demam" <?php if (in_array("Kunjungan ulang 3 hari berturut-turut jika tetap demam", $tind_malaria)) {echo "checked";}?>> Kunjungan ulang 3 hari berturut-turut jika tetap demam</label><br>
										<label><input class="tinddemam tind_demam_mtbs_9" type="checkbox" name="tind_malaria_mtbs[]" value="Obati penyebab lain dari demam" <?php if (in_array("Obati penyebab lain dari demam", $tind_malaria)) {echo "checked";}?> CHECKED> Obati penyebab lain dari demam</label><br>
										<label><input class="tinddemam tind_demam_mtbs_10" type="checkbox" name="tind_malaria_mtbs[]" value="Rujuk untuk pemeriksaan lebih lanjut" <?php if (in_array("Rujuk untuk pemeriksaan lebih lanjut", $tind_malaria)) {echo "checked";}?> CHECKED> Rujuk untuk pemeriksaan lebih lanjut</label><br>
										<label><input class="tinddemam tind_demam_mtbs_11" type="checkbox" name="tind_malaria_mtbs[]" value="Kunjungan ulang 2 hari jika tetap demam" <?php if (in_array("Kunjungan ulang 2 hari jika tetap demam", $tind_malaria)) {echo "checked";}?> CHECKED> Kunjungan ulang 2 hari jika tetap demam</label><br>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--5. campak-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#campak">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;5. Pemeriksaan Campak
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="campak">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-3">Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prk_campak = explode(',',$datapemeriksaan['PemeriksaanCampak']);?>
										<label><input type="checkbox" name="prk_campak_mtbs[]" value="Adanya luka dimulut" <?php if (in_array("Adanya luka dimulut", $prk_campak)) {echo "checked";}?>> Adanya luka dimulut</label><br>
										<label><input type="checkbox" name="prk_campak_mtbs[]" value="Luka dalam/luas" <?php if (in_array("Luka dalam/luas", $prk_campak)) {echo "checked";}?>> Luka dalam/luas</label><br>
										<label><input type="checkbox" name="prk_campak_mtbs[]" value="Adanya nanah dimata" <?php if (in_array("Adanya nanah dimata", $prk_campak)) {echo "checked";}?>> Adanya nanah dimata</label><br>
										<label><input type="checkbox" name="prk_campak_mtbs[]" value="Adanya keluhan dikornea" <?php if (in_array("Adanya keluhan dikornea", $prk_campak)) {echo "checked";}?>> Adanya keluhan dikornea</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Klasifikasi</td>
									<td class="col-sm-9">
										<select name="kls_campak_mtbs" class="form-control inputan klasifikasi_mtbs_campak">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiCampak'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Penyakit Campak Dengan Komplikasi Berat" <?php if($datapemeriksaan['KlasifikasiCampak'] == 'Penyakit Campak Dengan Komplikasi Berat'){echo "SELECTED";}?>>Penyakit Campak Dengan Komplikasi Berat</option>
											<option value="Penyakit Campak Komplikasi Pada Mata/Mulut" <?php if($datapemeriksaan['KlasifikasiCampak'] == 'Penyakit Campak Komplikasi Pada Mata/Mulut'){echo "SELECTED";}?>>Penyakit Campak Komplikasi Pada Mata/Mulut</option>
											<option value="Penyakit Campak" <?php if($datapemeriksaan['KlasifikasiCampak'] == 'Penyakit Campak'){echo "SELECTED";}?>>Penyakit Campak</option>
											<option value="Tidak Ada" <?php if($datapemeriksaan['KlasifikasiCampak'] == 'Tidak Ada'){echo "SELECTED";}?>>Tidak Ada</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Tindakan</td>
									<td class="col-sm-9">
										<?php $tind_campak = explode(',',$datapemeriksaan['TindakanCampak']);?>
										<label><input class="tindcampak tind_campak_mtbs_1" type="checkbox" name="tind_campak_mtbs[]" value="Beri vitamin A sesuai dosis" <?php if (in_array("Beri vitamin A sesuai dosis", $tind_campak)) {echo "checked";}?>> Beri vitamin A sesuai dosis</label><br>
										<label><input class="tindcampak tind_campak_mtbs_2" type="checkbox" name="tind_campak_mtbs[]" value="Beri dosis pertama antibiotik yg sesuai" <?php if (in_array("Beri dosis pertama antibiotik yg sesuai", $tind_campak)) {echo "checked";}?>> Beri dosis pertama antibiotik yg sesuai</label><br>
										<label><input class="tindcampak tind_campak_mtbs_3" type="checkbox" name="tind_campak_mtbs[]" value="Bubuhi tetes/salep mata kloramfenikol/tetrasiklin" <?php if (in_array("Bubuhi tetes/salep mata kloramfenikol/tetrasiklin", $tind_campak)) {echo "checked";}?>> Bubuhi tetes/salep mata kloramfenikol/tetrasiklin</label><br>
										<label><input class="tindcampak tind_campak_mtbs_4" type="checkbox" name="tind_campak_mtbs[]" value="Beri dosis pertama parasetamol" <?php if (in_array("Beri dosis pertama parasetamol", $tind_campak)) {echo "checked";}?>> Beri dosis pertama parasetamol</label><br>
										<label><input class="tindcampak tind_campak_mtbs_5" type="checkbox" name="tind_campak_mtbs[]" value="Rujuk segera" <?php if (in_array("Rujuk segera", $tind_campak)) {echo "checked";}?>> Rujuk segera</label><br>
										<label><input class="tindcampak tind_campak_mtbs_6" type="checkbox" name="tind_campak_mtbs[]" value="Ajari cara mengobati dgn gentian violet" <?php if (in_array("Ajari cara mengobati dgn gentian violet", $tind_campak)) {echo "checked";}?>> Ajari cara mengobati dgn gentian violet</label><br>
										<label><input class="tindcampak tind_campak_mtbs_7" type="checkbox" name="tind_campak_mtbs[]" value="Kunjungan ulang 2 hari" <?php if (in_array("Kunjungan ulang 2 hari", $tind_campak)) {echo "checked";}?>> Kunjungan ulang 2 hari</label><br>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--6. demam berdarah-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#demam_berdarah">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;6. Pemeriksaan Demam Berdarah (2-7 Hari)
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="demam_berdarah">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td class="col-sm-3">Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prk_dbd = explode(',',$datapemeriksaan['PemeriksaanCampak']);?>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Demam tinggi dan terus menerus" <?php if (in_array("Demam tinggi dan terus menerus", $prk_dbd)) {echo "checked";}?>> Demam tinggi dan terus menerus</label><br>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Ada pendarahan dihidung/gusi yang berat" <?php if (in_array("Ada pendarahan dihidung/gusi yang berat", $prk_dbd)) {echo "checked";}?>> Ada pendarahan dihidung/gusi yang berat</label><br>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Anak muntah" <?php if (in_array("Anak muntah", $prk_dbd)) {echo "checked";}?>> Anak muntah</label><br>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Muntah sering" <?php if (in_array("Muntah sering", $prk_dbd)) {echo "checked";}?>> Muntah sering</label><br>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Muntah berdarah/seperti kopi" <?php if (in_array("Muntah berdarah/seperti kopi", $prk_dbd)) {echo "checked";}?>> Muntah berdarah/seperti kopi</label><br>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Beraknya berwarna hitam" <?php if (in_array("Beraknya berwarna hitam", $prk_dbd)) {echo "checked";}?>> Beraknya berwarna hitam</label><br>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Nyeri ulu hati/gelisah" <?php if (in_array("Nyeri ulu hati/gelisah", $prk_dbd)) {echo "checked";}?>> Nyeri ulu hati/gelisah</label><br>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Syok dan nadi sangat lemah" <?php if (in_array("Syok dan nadi sangat lemah", $prk_dbd)) {echo "checked";}?>> Syok dan nadi sangat lemah</label><br>
										<label><input type="checkbox" name="prk_dbd_mtbs[]" value="Adanya bintik pendarahan dikulit (petekie)" <?php if (in_array("Adanya bintik pendarahan dikulit (petekie)", $prk_dbd)) {echo "checked";}?>> Adanya bintik pendarahan dikulit (petekie)</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Klasifikasi</td>
									<td class="col-sm-9">
										<select name="kls_dbd_mtbs" class="form-control inputan klasifikasi_mtbs_dbd">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiDBD'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Penyakit Demam Berdarah Dengue (DBD)" <?php if($datapemeriksaan['KlasifikasiDBD'] == 'Penyakit Demam Berdarah Dengue (DBD)'){echo "SELECTED";}?>>Penyakit Demam Berdarah Dengue (DBD)</option>
											<option value="Penyakit Demam Mungkin DBD" <?php if($datapemeriksaan['KlasifikasiDBD'] == 'Penyakit Demam Mungkin DBD'){echo "SELECTED";}?>>Penyakit Demam Mungkin DBD</option>
											<option value="Penyakit Demam Mungkin Bukan DBD" <?php if($datapemeriksaan['KlasifikasiDBD'] == 'Penyakit Demam Mungkin Bukan DBD'){echo "SELECTED";}?> SELECTED>Penyakit Demam Mungkin Bukan DBD</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Tindakan</td>
									<td class="col-sm-9">
										<?php $tind_dbd = explode(',',$datapemeriksaan['TindakanCampak']);?>
										<label><input class="tinddbd tind_dbd_mtbs_1" type="checkbox" name="tind_dbd_mtbs[]" value="Beri oksigen 2-4 liter/menit dan beri cairan intravena" <?php if (in_array("Beri oksigen 2-4 liter/menit dan beri cairan intravena", $tind_dbd)) {echo "checked";}?>> Beri oksigen 2-4 liter/menit dan beri cairan intravena</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_2" type="checkbox" name="tind_dbd_mtbs[]" value="Beri cairan infus Ringer Laktat/Asetat jml cairan rumatan" <?php if (in_array("Beri cairan infus Ringer Laktat/Asetat jml cairan rumatan", $tind_dbd)) {echo "checked";}?>> Beri cairan infus Ringer Laktat/Asetat jml cairan rumatan</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_3" type="checkbox" name="tind_dbd_mtbs[]" value="Beri oralit/cairan lain sebanyak mungkin dalam perjalanan ke RS" <?php if (in_array("Beri oralit/cairan lain sebanyak mungkin dalam perjalanan ke RS", $tind_dbd)) {echo "checked";}?>> Beri oralit/cairan lain sebanyak mungkin dalam perjalanan ke RS</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_4" type="checkbox" name="tind_dbd_mtbs[]" value="Beri dosis pertama parasetamol" <?php if (in_array("Beri dosis pertama parasetamol", $tind_dbd)) {echo "checked";}?> CHECKED> Beri dosis pertama parasetamol</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_5" type="checkbox" name="tind_dbd_mtbs[]" value="Rujuk segera" <?php if (in_array("Rujuk segera", $tind_dbd)) {echo "checked";}?>> Rujuk segera</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_6" type="checkbox" name="tind_dbd_mtbs[]" value="Nasihati untuk lebih banyak minum oralit/cairan lain" <?php if (in_array("Nasihati untuk lebih banyak minum oralit/cairan lain", $tind_dbd)) {echo "checked";}?>> Nasihati untuk lebih banyak minum oralit/cairan lain</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_7" type="checkbox" name="tind_dbd_mtbs[]" value="Nasihati kapan kembali segera" <?php if (in_array("Nasihati kapan kembali segera", $tind_dbd)) {echo "checked";}?> CHECKED> Nasihati kapan kembali segera</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_8" type="checkbox" name="tind_dbd_mtbs[]" value="Kunjungan ulang 1 hari jika tetap demam" <?php if (in_array("Kunjungan ulang 1 hari jika tetap demam", $tind_dbd)) {echo "checked";}?>> Kunjungan ulang 1 hari jika tetap demam</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_9" type="checkbox" name="tind_dbd_mtbs[]" value="Obati penyebab lain dari demam" <?php if (in_array("Obati penyebab lain dari demam", $tind_dbd)) {echo "checked";}?> CHECKED> Obati penyebab lain dari demam</label><br>
										<label><input class="tinddbd tind_dbd_mtbs_10" type="checkbox" name="tind_dbd_mtbs[]" value="Kunjungan ulang 2 hari jika tetap demam" <?php if (in_array("Kunjungan ulang 2 hari jika tetap demam", $tind_dbd)) {echo "checked";}?> CHECKED> Kunjungan ulang 2 hari jika tetap demam</label><br>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--7. Telinga-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#telinga">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;7. Pemeriksaan Telinga
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="telinga">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td colspan="3"><b>A. Penilaian</b></td>
								</tr>
								<tr>
									<td class="col-sm-3">Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prk_telinga = explode(',',$datapemeriksaan['PemeriksaanTelinga']);?>
										<label><input type="checkbox" name="prk_telinga_mtbs[]" value="Anak Mempunyai Masalah Telinga" <?php if (in_array("Anak Mempunyai Masalah Telinga", $prk_telinga)) {echo "checked";}?>> Anak Mempunyai Masalah Telinga</label><br>
										<label><input type="checkbox" name="prk_telinga_mtbs[]" value="Ada pendarahan dihidung/gusi yang berat" <?php if (in_array("Ada pendarahan dihidung/gusi yang berat", $prk_telinga)) {echo "checked";}?>> Ada pendarahan dihidung/gusi yang berat</label><br>
										<label><input type="checkbox" name="prk_telinga_mtbs[]" value="Anak muntah" <?php if (in_array("Anak muntah", $prk_telinga)) {echo "checked";}?>> Anak muntah</label><br>
										<label><input type="checkbox" name="prk_telinga_mtbs[]" value="Muntah sering" <?php if (in_array("Muntah sering", $prk_telinga)) {echo "checked";}?>> Muntah sering</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Berapa Lama</td>
									<td class="col-sm-9">
										<input type="text" name="bl_telinga_mtbs" class="form-control inputan" maxlength = "2" placeholder = "Hari" value = "<?php echo $datapemeriksaan['HariTelinga'];?>"></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"><b>B. Klasifikasi</b></td>
									<td class="col-sm-9">
										<select name="kls_telinga_mtbs" class="form-control inputan klasifikasi_mtbs_telinga">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiTelinga'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Mastoiditis" <?php if($datapemeriksaan['KlasifikasiTelinga'] == 'Mastoiditis'){echo "SELECTED";}?>>Mastoiditis</option>
											<option value="Infeksi Telinga Akut" <?php if($datapemeriksaan['KlasifikasiTelinga'] == 'Infeksi Telinga Akut'){echo "SELECTED";}?>>Infeksi Telinga Akut</option>
											<option value="Infeksi Telinga Kronis" <?php if($datapemeriksaan['KlasifikasiTelinga'] == 'Infeksi Telinga Kronis'){echo "SELECTED";}?>>Infeksi Telinga Kronis</option>
											<option value="Tidak Ada Infeksi Telinga" <?php if($datapemeriksaan['KlasifikasiTelinga'] == 'Tidak Ada Infeksi Telinga'){echo "SELECTED";}?> SELECTED>Tidak Ada Infeksi Telinga</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"><b>C. Tindakan</b></td>
									<td class="col-sm-9">
										<?php $tind_telinga = explode(',',$datapemeriksaan['TindakanTelinga']);?>
										<label><input class="tindtelinga tind_telinga_mtbs_1" type="checkbox" name="tind_telinga_mtbs[]" value="Beri dosis pertama antibiotik yg sesuai" <?php if (in_array("Beri dosis pertama antibiotik yg sesuai", $tind_telinga)) {echo "checked";}?>> Beri dosis pertama antibiotik yg sesuai</label><br>
										<label><input class="tindtelinga tind_telinga_mtbs_2" type="checkbox" name="tind_telinga_mtbs[]" value="Beri dosis pertama parasetamol untuk mengatasi nyeri" <?php if (in_array("Beri dosis pertama parasetamol untuk mengatasi nyeri", $tind_telinga)) {echo "checked";}?>> Beri dosis pertama parasetamol untuk mengatasi nyeri</label><br>
										<label><input class="tindtelinga tind_telinga_mtbs_3" type="checkbox" name="tind_telinga_mtbs[]" value="Rujuk segera" <?php if (in_array("Rujuk segera", $tind_telinga)) {echo "checked";}?>> Rujuk segera</label><br>
										<label><input class="tindtelinga tind_telinga_mtbs_4" type="checkbox" name="tind_telinga_mtbs[]" value="Beri parasetamol untuk mengatasi nyeri" <?php if (in_array("Beri parasetamol untuk mengatasi nyeri", $tind_telinga)) {echo "checked";}?>> Beri parasetamol untuk mengatasi nyeri</label><br>
										<label><input class="tindtelinga tind_telinga_mtbs_5" type="checkbox" name="tind_telinga_mtbs[]" value="Keringkan telinga dgn bahan penyerap" <?php if (in_array("Keringkan telinga dgn bahan penyerap", $tind_telinga)) {echo "checked";}?>> Keringkan telinga dgn bahan penyerap</label><br>
										<label><input class="tindtelinga tind_telinga_mtbs_6" type="checkbox" name="tind_telinga_mtbs[]" value="Kunjungan ulang 2 hari" <?php if (in_array("Kunjungan ulang 2 hari", $tind_telinga)) {echo "checked";}?>> Kunjungan ulang 2 hari</label><br>
										<label><input class="tindtelinga tind_telinga_mtbs_7" type="checkbox" name="tind_telinga_mtbs[]" value="Beri tetes telinga yg sesuai" <?php if (in_array("Beri tetes telinga yg sesuai", $tind_telinga)) {echo "checked";}?>> Beri tetes telinga yg sesuai</label><br>
										<label><input class="tindtelinga tind_telinga_mtbs_8" type="checkbox" name="tind_telinga_mtbs[]" value="Kunjungan ulang 5 hari" <?php if (in_array("Kunjungan ulang 5 hari", $tind_telinga)) {echo "checked";}?>> Kunjungan ulang 5 hari</label><br>
										<label><input class="tindtelinga tind_telinga_mtbs_9" type="checkbox" name="tind_telinga_mtbs[]" value="Tidak perlu tindakan tambahan" <?php if (in_array("Tidak perlu tindakan tambahan", $tind_telinga)) {echo "checked";}?> CHECKED> Tidak perlu tindakan tambahan</label><br>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--8. Gizi-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#gizi">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;8. Pemeriksaan Status Gizi
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="gizi">
						<div class="panel-body">
							<table class="table-judul">
								<tr>
									<td colspan="3"><b>A. Penilaian</b></td>
								</tr>
								<tr>
									<td class="col-sm-3">1. Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prk_gizi = explode(',',$datapemeriksaan['PemeriksaanGizi']);?>
										<label><input type="checkbox" name="prk_gizi_mtbs[]" value="Anak tampak sangat kurus" <?php if (in_array("Anak tampak sangat kurus", $prk_gizi)) {echo "checked";}?>> Anak tampak sangat kurus</label><br>
										<label><input type="checkbox" name="prk_gizi_mtbs[]" value="Adanya pembengkakan di kedua punggung kaki/tangan" <?php if (in_array("Adanya pembengkakan di kedua punggung kaki/tangan", $prk_gizi)) {echo "checked";}?>> Adanya pembengkakan di kedua punggung kaki/tangan</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">2. Tentukan BB menurut PB/TB</td>
									<td class="col-sm-9">
										<select name="bb_mtbs" class="form-control inputan">
											<option value="BB menurut PB/TB (< -3 SD)" <?php if($datapemeriksaan['KlasifikasiUmum'] == 'BB menurut PB/TB (< -3 SD)'){echo "SELECTED";}?>>BB menurut PB/TB (< -3 SD)</option>
											<option value="BB menurut PB/TB (-3 SD sampai -2 SD)" <?php if($datapemeriksaan['KlasifikasiUmum'] == 'BB menurut PB/TB (-3 SD sampai -2 SD)'){echo "SELECTED";}?>>BB menurut PB/TB (-3 SD sampai -2 SD)</option>
											<option value="BB menurut PB/TB (> -2 SD)" <?php if($datapemeriksaan['KlasifikasiUmum'] == 'BB menurut PB/TB (> -2 SD)'){echo "SELECTED";}?>>BB menurut PB/TB (> -2 SD)</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"></td>
									<td class="col-sm-9">
										<input type="text" name="bb_jelaskan_mtbs" class="form-control inputan" maxlength = "50" placeholder = "Jelaskan (Maks.50 digit)" value = ""></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">3. Lila, anak umur 6 bulan/lebih</td>
									<td class="col-sm-9">
										<select name="lila_mtbs" class="form-control inputan">
											<option value="LILA < 11,5cm" <?php if($datapemeriksaan['KlasifikasiUmum'] == 'LILA < 11,5cm'){echo "SELECTED";}?>>LILA < 11,5cm</option>
											<option value="LILA 11,5cm - 12,5cm" <?php if($datapemeriksaan['KlasifikasiUmum'] == 'LILA 11,5cm - 12,5cm'){echo "SELECTED";}?>>LILA 11,5cm - 12,5cm</option>
											<option value="LILA > 12,5cm" <?php if($datapemeriksaan['KlasifikasiUmum'] == 'LILA > 12,5cm'){echo "SELECTED";}?>>LILA > 12,5cm</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"></td>
									<td class="col-sm-9">
										<input type="text" name="lila_jelaskan_mtbs" class="form-control inputan" maxlength = "50" placeholder = "Jelaskan (Maks.50 digit)" value = ""></text>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="col-sm-3">Jika BB menurut PB atau TB <- 3 SD atau LILA <11,5cm maka periksa komplikasi medis</td>
								</tr>
								<tr>
									<td class="col-sm-3">4. Jelaskan tanda bahaya umum</td>
									<td class="col-sm-9">
										<input type="text" name="bahaya_umum_mtbs" class="form-control inputan" maxlength = "50" placeholder = "Jelaskan (Maks.50 digit)" value = ""></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">5. Klasifikasi berat</td>
									<td class="col-sm-9">
										<input type="text" name="klasifikasi_berat_mtbs" class="form-control inputan" maxlength = "50" placeholder = "Jelaskan (Maks.50 digit)" value = ""></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">6. Anak memiliki mslh pemberian ASI?</td>
									<td class="col-sm-9">
										<input type="text" name="asi_mtbs" class="form-control inputan" maxlength = "50" placeholder = "Jelaskan (Maks.50 digit)" value = ""></text>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"><b>B. Klasifikasi</b></td>
									<td class="col-sm-9">
										<select name="gizi_klasifikasi_mtbs" class="form-control inputan klasifikasi_mtbs_gizi">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiGizi'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Gizi Buruk Dengan Komplikasi" <?php if($datapemeriksaan['KlasifikasiGizi'] == 'Gizi Buruk Dengan Komplikasi'){echo "SELECTED";}?>>Gizi Buruk Dengan Komplikasi</option>
											<option value="Gizi Buruk Tanpa Komplikasi" <?php if($datapemeriksaan['KlasifikasiGizi'] == 'Gizi Buruk Tanpa Komplikasi'){echo "SELECTED";}?>>Gizi Buruk Tanpa Komplikasi</option>
											<option value="Gizi Kurang" <?php if($datapemeriksaan['KlasifikasiGizi'] == 'Gizi Kurang'){echo "SELECTED";}?>>Gizi Kurang</option>
											<option value="Gizi Baik" <?php if($datapemeriksaan['KlasifikasiGizi'] == 'Gizi Baik'){echo "SELECTED";}?>>Gizi Baik</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"><b>C. Tindakan</b></td>
									<td class="col-sm-9">
										<?php $tind_gizi = explode(',',$datapemeriksaan['TindakanGizi']);?>
										<label><input class="tindgizi tind_gizi_mtbs_1" type="checkbox" name="tind_gizi_mtbs[]" value="Beri dosis pertama antibiotik yg sesuai" <?php if (in_array("Beri dosis pertama antibiotik yg sesuai", $tind_gizi)) {echo "checked";}?>> Beri dosis pertama antibiotik yg sesuai</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_2" type="checkbox" name="tind_gizi_mtbs[]" value="Beri Vit A dosis pertama" <?php if (in_array("Beri Vit A dosis pertama", $tind_gizi)) {echo "checked";}?>> Beri Vit A dosis pertama</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_3" type="checkbox" name="tind_gizi_mtbs[]" value="Cegah gula darah tidak turun" <?php if (in_array("Cegah gula darah tidak turun", $tind_gizi)) {echo "checked";}?>> Cegah gula darah tidak turun</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_4" type="checkbox" name="tind_gizi_mtbs[]" value="Hangatkan badan" <?php if (in_array("Hangatkan badan", $tind_gizi)) {echo "checked";}?>> Hangatkan badan</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_5" type="checkbox" name="tind_gizi_mtbs[]" value="Rujuk segera" <?php if (in_array("Rujuk segera", $tind_gizi)) {echo "checked";}?>> Rujuk segera</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_6" type="checkbox" name="tind_gizi_mtbs[]" value="Beri antibiotik yang sesuai selama 5 hari" <?php if (in_array("Beri antibiotik yang sesuai selama 5 hari", $tind_gizi)) {echo "checked";}?>> Beri antibiotik yang sesuai selama 5 hari</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_7" type="checkbox" name="tind_gizi_mtbs[]" value="Rujuk untuk penaganan gizi buruk termasuk kemungkinan adanya penyakit penyerta (Infeksi TB, dll)" <?php if (in_array("Rujuk untuk penaganan gizi buruk termasuk kemungkinan adanya penyakit penyerta (Infeksi TB, dll)", $tind_gizi)) {echo "checked";}?>> Rujuk untuk penaganan gizi buruk termasuk kemungkinan adanya penyakit penyerta (Infeksi TB, dll)</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_8" type="checkbox" name="tind_gizi_mtbs[]" value="Nasihati kapan kembali segera" <?php if (in_array("Nasihati kapan kembali segera", $tind_gizi)) {echo "checked";}?>> Nasihati kapan kembali segera</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_9" type="checkbox" name="tind_gizi_mtbs[]" value="Kunjungan ulang 7 hari" <?php if (in_array("Kunjungan ulang 7 hari", $tind_gizi)) {echo "checked";}?>> Kunjungan ulang 7 hari</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_10" type="checkbox" name="tind_gizi_mtbs[]" value="Kunjungan ulang 30 hari" <?php if (in_array("Kunjungan ulang 30 hari", $tind_gizi)) {echo "checked";}?>> Kunjungan ulang 30 hari</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_11" type="checkbox" name="tind_gizi_mtbs[]" value="Lakukan penilaian pemberian makan & nasihati sesuai anjuran makan" <?php if (in_array("Lakukan penilaian pemberian makan & nasihati sesuai anjuran makan", $tind_gizi)) {echo "checked";}?>> Lakukan penilaian pemberian makan & nasihati sesuai anjuran makan</label><br>
										<label><input class="tindgizi tind_gizi_mtbs_12" type="checkbox" name="tind_gizi_mtbs[]" value="Anjurkan untuk menimbang berat badan anak setiap bulan" <?php if (in_array("Anjurkan untuk menimbang berat badan anak setiap bulan", $tind_gizi)) {echo "checked";}?>> Anjurkan untuk menimbang berat badan anak setiap bulan</label><br>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--9. Anemia-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#anemia">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;9. Pemeriksaan Anemia
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="anemia">
						<div class="panel-body">
							<table class="table-judul">
								<tr>
									<td colspan="3"><b>A. Penilaian</b></td>
								</tr>
								<tr>
									<td class="col-sm-3">1. Kepucatan pada telapak tangan</td>
									<td class="col-sm-9">
										<select name="anemia_mtbs" class="form-control inputan">
											<option value="-" <?php if($datapemeriksaan['PemeriksaanAnemia'] == '-'){echo "SELECTED";}?>>-Pilih-</option>
											<option value="Sangat Pucat" <?php if($datapemeriksaan['PemeriksaanAnemia'] == 'Sangat Pucat'){echo "SELECTED";}?>>Sangat Pucat</option>
											<option value="Agak Pucat" <?php if($datapemeriksaan['PemeriksaanAnemia'] == 'Agak Pucat'){echo "SELECTED";}?>>Agak Pucat</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"><b>B. Klasifikasi</b></td>
									<td class="col-sm-9">
										<select name="anemia_klasifikasi_mtbs" class="form-control inputan klasifikasi_mtbs_anemia">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiAnemia'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Anemia Berat" <?php if($datapemeriksaan['KlasifikasiAnemia'] == 'Anemia Berat'){echo "SELECTED";}?>>Anemia Berat</option>
											<option value="Anemia" <?php if($datapemeriksaan['KlasifikasiAnemia'] == 'Anemia'){echo "SELECTED";}?>>Anemia</option>
											<option value="Tidak Anemia" <?php if($datapemeriksaan['KlasifikasiAnemia'] == 'Tidak Anemia'){echo "SELECTED";}?>>Tidak Anemia</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"><b>C. Tindakan</b></td>
									<td class="col-sm-9">
										<?php $tind_anemia = explode(',',$datapemeriksaan['TindakanAnemia']);?>
										<label><input class="tindanemia tind_anemia_mtbs_1" type="checkbox" name="tind_anemia_mtbs[]" value="Bila masih menyusu teruskan pemberian ASI" <?php if (in_array("Bila masih menyusu teruskan pemberian ASI", $tind_anemia)) {echo "checked";}?>> Bila masih menyusu teruskan pemberian ASI</label><br>
										<label><input class="tindanemia tind_anemia_mtbs_2" type="checkbox" name="tind_anemia_mtbs[]" value="Rujuk Segera" <?php if (in_array("Rujuk Segera", $tind_anemia)) {echo "checked";}?>> Rujuk Segera</label><br>
										<label><input class="tindanemia tind_anemia_mtbs_3" type="checkbox" name="tind_anemia_mtbs[]" value="Lakukan penilaian pemberian makan pada anak. Bila ada masalah berikan konseling" <?php if (in_array("Lakukan penilaian pemberian makan pada anak. Bila ada masalah berikan konseling", $tind_anemia)) {echo "checked";}?>> Lakukan penilaian pemberian makan pada anak. Bila ada masalah berikan konseling</label><br>
										<label><input class="tindanemia tind_anemia_mtbs_4" type="checkbox" name="tind_anemia_mtbs[]" value="Beri zat besi" <?php if (in_array("Beri zat besi", $tind_anemia)) {echo "checked";}?>> Beri zat besi</label><br>
										<label><input class="tindanemia tind_anemia_mtbs_5" type="checkbox" name="tind_anemia_mtbs[]" value="Beri obat cacingan jika anak > 1 thn dan belum mendapatkan obat dlm 6 bln terakhir" <?php if (in_array("Beri obat cacingan jika anak > 1 thn dan belum mendapatkan obat dlm 6 bln terakhir", $tind_anemia)) {echo "checked";}?>> Beri obat cacingan jika anak > 1 thn dan belum mendapatkan obat dlm 6 bln terakhir</label><br>
										<label><input class="tindanemia tind_anemia_mtbs_6" type="checkbox" name="tind_anemia_mtbs[]" value="Jika daerah epidermis tinggi malaria periksa dan obati malaria terlebih dahulu jika positif" <?php if (in_array("Jika daerah epidermis tinggi malaria periksa dan obati malaria terlebih dahulu jika positif", $tind_anemia)) {echo "checked";}?>> Jika daerah epidermis tinggi malaria periksa dan obati malaria terlebih dahulu jika positif</label><br>
										<label><input class="tindanemia tind_anemia_mtbs_7" type="checkbox" name="tind_anemia_mtbs[]" value="Nasihati kapan kembali segera" <?php if (in_array("Nasihati kapan kembali segera", $tind_anemia)) {echo "checked";}?>> Nasihati kapan kembali segera</label><br>
										<label><input class="tindanemia tind_anemia_mtbs_8" type="checkbox" name="tind_anemia_mtbs[]" value="Kunjungan ulang 14 hari" <?php if (in_array("Kunjungan ulang 14 hari", $tind_anemia)) {echo "checked";}?>> Kunjungan ulang 14 hari</label><br>
										<label><input class="tindanemia tind_anemia_mtbs_9" type="checkbox" name="tind_anemia_mtbs[]" value="Jika anak < 2 tahun nilai pemberian makanan pada anak" <?php if (in_array("Jika anak < 2 tahun nilai pemberian makanan pada anak", $tind_anemia)) {echo "checked";}?>> Jika anak < 2 tahun nilai pemberian makanan pada anak</label><br>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--10. HIV-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#hiv">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;10. Pemeriksaan HIV
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="hiv">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td colspan="3"><b>A. Penilaian</b></td>
								</tr>
								<tr>
									<td class="col-sm-3">Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prk_hiv = explode(',',$datapemeriksaan['PemeriksaanHiv']);?>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Apakah ibu pernah diperiksa HIV" <?php if (in_array("Apakah ibu pernah diperiksa HIV", $prk_hiv)) {echo "checked";}?>> Apakah ibu pernah diperiksa HIV</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Jika Ya apakah (ibu) hasilnya Positif" <?php if (in_array("Jika Ya apakah (ibu) hasilnya Positif", $prk_hiv)) {echo "checked";}?>> Jika Ya apakah (ibu) hasilnya Positif</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Jika Positif apakah ibu sudah minum ARV" <?php if (in_array("Jika Positif apakah ibu sudah minum ARV", $prk_hiv)) {echo "checked";}?>> Jika Positif apakah ibu sudah minum ARV</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Apakah ARV sudah diminum minimal 6 bulan" <?php if (in_array("Apakah ARV sudah diminum minimal 6 bulan", $prk_hiv)) {echo "checked";}?>> Apakah ARV sudah diminum minimal 6 bulan</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Ibu patuh minum ARV" <?php if (in_array("Ibu patuh minum ARV", $prk_hiv)) {echo "checked";}?>> Ibu patuh minum ARV</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Anak pernah tes HIV pada usia 6 minggu atau lebih" <?php if (in_array("Anak pernah tes HIV pada usia 6 minggu atau lebih", $prk_hiv)) {echo "checked";}?>> Anak pernah tes HIV pada usia 6 minggu atau lebih</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Jika Ya apakah dianjurkan untuk diulangi 4 minggu kemudian" <?php if (in_array("Jika Ya apakah dianjurkan untuk diulangi 4 minggu kemudian", $prk_hiv)) {echo "checked";}?>> Jika Ya apakah dianjurkan untuk diulangi 4 minggu kemudian</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Anak lebih dari 18 bulan apakah pernah dilakukan tes HIV" <?php if (in_array("Anak lebih dari 18 bulan apakah pernah dilakukan tes HIV", $prk_hiv)) {echo "checked";}?>> Anak lebih dari 18 bulan apakah pernah dilakukan tes HIV</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="jika Ya apakah (anak) hasilnya positif" <?php if (in_array("jika Ya apakah (anak) hasilnya positif", $prk_hiv)) {echo "checked";}?>> jika Ya apakah (anak) hasilnya positif</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Apakah anak masih mendapatkan ASI" <?php if (in_array("Apakah anak masih mendapatkan ASI", $prk_hiv)) {echo "checked";}?>> Apakah anak masih mendapatkan ASI</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Jika Ya apakah anak sudah mendapatkan ARV Profilaksis" <?php if (in_array("Jika Ya apakah anak sudah mendapatkan ARV Profilaksis", $prk_hiv)) {echo "checked";}?>> Jika Ya apakah anak sudah mendapatkan ARV Profilaksis</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Baru berhenti < dari 6 minggu pada saat dilakukan tes" <?php if (in_array("Baru berhenti < dari 6 minggu pada saat dilakukan tes", $prk_hiv)) {echo "checked";}?>> Baru berhenti < dari 6 minggu pada saat dilakukan tes</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Apakah anak ada riwayat pengobatan OAT dalam 1 tahun terakhir" <?php if (in_array("Apakah anak ada riwayat pengobatan OAT dalam 1 tahun terakhir", $prk_hiv)) {echo "checked";}?>> Apakah anak ada riwayat pengobatan OAT dalam 1 tahun terakhir</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Apakah anak memiliki orang tua kandung/saudara yang terdiagnosa HIV" <?php if (in_array("Apakah anak memiliki orang tua kandung/saudara yang terdiagnosa HIV", $prk_hiv)) {echo "checked";}?>> Apakah anak memiliki orang tua kandung/saudara yang terdiagnosa HIV</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Apakah terdapat bercak putih dimulut" <?php if (in_array("Apakah terdapat bercak putih dimulut", $prk_hiv)) {echo "checked";}?>> Apakah terdapat bercak putih dimulut</label><br>
										<label><input type="checkbox" name="prk_hiv_mtbs[]" value="Lakukan tes HIV serologis pada ibu dan anak" <?php if (in_array("Lakukan tes HIV serologis pada ibu dan anak", $prk_hiv)) {echo "checked";}?>>Lakukan tes HIV serologis pada ibu dan anak </label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"><b>B. Klasifikasi</b></td>
									<td class="col-sm-9">
										<select name="hiv_klasifikasi_mtbs" class="form-control inputan klasifikasi_mtbs_hiv">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiHiv'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Infeksi HIV Terkonfirmasi" <?php if($datapemeriksaan['KlasifikasiHiv'] == 'Infeksi HIV Terkonfirmasi'){echo "SELECTED";}?>>Infeksi HIV Terkonfirmasi</option>
											<option value="Diduga Terinfeksi HIV" <?php if($datapemeriksaan['KlasifikasiHiv'] == 'Diduga Terinfeksi HIV'){echo "SELECTED";}?>>Diduga Terinfeksi HIV</option>
											<option value="Terpajan HIV" <?php if($datapemeriksaan['KlasifikasiHiv'] == 'Terpajan HIV'){echo "SELECTED";}?>>Terpajan HIV</option>
											<option value="Kemungkinan Bukan Inveksi HIV" <?php if($datapemeriksaan['KlasifikasiHiv'] == 'Kemungkinan Bukan Inveksi HIV'){echo "SELECTED";}?>>Kemungkinan Bukan Inveksi HIV</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3"><b>C. Tindakan</b></td>
									<td class="col-sm-9">
										<?php $tind_hiv = explode(',',$datapemeriksaan['TindakanHiv']);?>
										<label><input class="tindhiv tind_hiv_mtbs_1" type="checkbox" name="tind_hiv_mtbs[]" value="Rujuk ke puskesmas/RS" <?php if (in_array("Rujuk ke puskesmas/RS", $tind_hiv)) {echo "checked";}?>> Rujuk ke puskesmas/RS</label><br>
										<label><input class="tindhiv tind_hiv_mtbs_2" type="checkbox" name="tind_hiv_mtbs[]" value="Rujukan ARV untuk mendapatkan terapi ARV dan Kotrimoksasol profilaksis" <?php if (in_array("Rujukan ARV untuk mendapatkan terapi ARV dan Kotrimoksasol profilaksis", $tind_hiv)) {echo "checked";}?>> Rujukan ARV untuk mendapatkan terapi ARV dan Kotrimoksasol profilaksis</label><br>
										<label><input class="tindhiv tind_hiv_mtbs_3" type="checkbox" name="tind_hiv_mtbs[]" value="Tangani infeksi yang ada" <?php if (in_array("Tangani infeksi yang ada", $tind_hiv)) {echo "checked";}?>> Tangani infeksi yang ada</label><br>
										
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--11. Status Imunisasi-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#imunisasi">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;11. Pemeriksaan Status Imunisasi
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="imunisasi">
						<div class="panel-body">
							<table class="table-judul">	
								<tr>
									<td colspan="3"><b>A. Penilaian</b></td>
								</tr>
								<tr>
									<td class="col-sm-3">Imunisasi yang diberikan sekarang</td>
									<td class="col-sm-2">
										<?php $prk_imunisasi_sekarang = explode(',',$datapemeriksaan['ImunisasiDiberikan']);?>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="BCG" <?php if (in_array("BCG", $prk_imunisasi_sekarang)) {echo "checked";}?>> BCG</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="HB 0" <?php if (in_array("HB 0", $prk_imunisasi_sekarang)) {echo "checked";}?>> HB 0</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="Polio 1" <?php if (in_array("Polio 1", $prk_imunisasi_sekarang)) {echo "checked";}?>> Polio 1</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="Polio 2" <?php if (in_array("Polio 2", $prk_imunisasi_sekarang)) {echo "checked";}?>> Polio 2</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="Polio 3" <?php if (in_array("Polio 3", $prk_imunisasi_sekarang)) {echo "checked";}?>> Polio 3</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="Polio 4" <?php if (in_array("Polio 4", $prk_imunisasi_sekarang)) {echo "checked";}?>> Polio 4</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="DPT-HB-Hib 1" <?php if (in_array("DPT-HB-Hib 1", $prk_imunisasi_sekarang)) {echo "checked";}?>> DPT-HB-Hib 1</label><br>
									</td>
									<td class="col-sm-12">
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="DPT-HB-Hib 2" <?php if (in_array("DPT-HB-Hib 2", $prk_imunisasi_sekarang)) {echo "checked";}?>> DPT-HB-Hib 2</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="DPT-HB-Hib 3" <?php if (in_array("DPT-HB-Hib 3", $prk_imunisasi_sekarang)) {echo "checked";}?>> DPT-HB-Hib 3</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="IPV" <?php if (in_array("IPV", $prk_imunisasi_sekarang)) {echo "checked";}?>> IPV</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="Campak" <?php if (in_array("Campak", $prk_imunisasi_sekarang)) {echo "checked";}?>> Campak</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="DPT-HB-Hib (Lanjutan)" <?php if (in_array("DPT-HB-Hib (Lanjutan)", $prk_imunisasi_sekarang)) {echo "checked";}?>> DPT-HB-Hib (Lanjutan)</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sekarang_mtbs[]" value="Campak (Lanjutan)" <?php if (in_array("Campak (Lanjutan)", $prk_imunisasi_sekarang)) {echo "checked";}?>> Campak (Lanjutan)</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Imunisasi yang sudah diberikan</td>
									<td class="col-sm-2">
										<?php $prk_imunisasi_sudah = explode(',',$datapemeriksaan['ImunisasiDibutuhkan']);?>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="BCG" <?php if (in_array("BCG", $prk_imunisasi_sudah)) {echo "checked";}?>> BCG</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="HB 0" <?php if (in_array("HB 0", $prk_imunisasi_sudah)) {echo "checked";}?>> HB 0</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="Polio 1" <?php if (in_array("Polio 1", $prk_imunisasi_sudah)) {echo "checked";}?>> Polio 1</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="Polio 2" <?php if (in_array("Polio 2", $prk_imunisasi_sudah)) {echo "checked";}?>> Polio 2</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="Polio 3" <?php if (in_array("Polio 3", $prk_imunisasi_sudah)) {echo "checked";}?>> Polio 3</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="Polio 4" <?php if (in_array("Polio 4", $prk_imunisasi_sudah)) {echo "checked";}?>> Polio 4</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="DPT-HB-Hib 1" <?php if (in_array("DPT-HB-Hib 1", $prk_imunisasi_sudah)) {echo "checked";}?>> DPT-HB-Hib 1</label><br>
									</td>
									<td class="col-sm-12">
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="DPT-HB-Hib 2" <?php if (in_array("DPT-HB-Hib 2", $prk_imunisasi_sudah)) {echo "checked";}?>> DPT-HB-Hib 2</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="DPT-HB-Hib 3" <?php if (in_array("DPT-HB-Hib 3", $prk_imunisasi_sudah)) {echo "checked";}?>> DPT-HB-Hib 3</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="IPV" <?php if (in_array("IPV", $prk_imunisasi_sudah)) {echo "checked";}?>> IPV</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="Campak" <?php if (in_array("Campak", $prk_imunisasi_sudah)) {echo "checked";}?>> Campak</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="DPT-HB-Hib (Lanjutan)" <?php if (in_array("DPT-HB-Hib (Lanjutan)", $prk_imunisasi_sudah)) {echo "checked";}?>> DPT-HB-Hib (Lanjutan)</label><br>
										<label><input type="checkbox" name="prk_imunisasi_sudah_mtbs[]" value="Campak (Lanjutan)" <?php if (in_array("Campak (Lanjutan)", $prk_imunisasi_sudah)) {echo "checked";}?>> Campak (Lanjutan)</label><br>
									</td>
								</tr>
								<tr>
									<td><b>B. Klasifikasi</b></td>
									<td colspan="2">
										<select name="imunisasi_klasifikasi_mtbs" class="form-control inputan klasifikasi_mtbs_imunisasi">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiImunisasi'] == '-'){echo "SELECTED";}?>>-</option>
											<option value="Pelayanan Mtbs Seharusnya di Imunisasi" <?php if($datapemeriksaan['KlasifikasiImunisasi'] == 'Pelayanan Mtbs Seharusnya di Imunisasi'){echo "SELECTED";}?>>Pelayanan Mtbs Seharusnya di Imunisasi</option>
											<option value="Patuh Untuk di Imunisasi" <?php if($datapemeriksaan['KlasifikasiImunisasi'] == 'Patuh Untuk di Imunisasi'){echo "SELECTED";}?>>Patuh Untuk di Imunisasi</option>
											<option value="Menolak Untuk di Imunisasi" <?php if($datapemeriksaan['KlasifikasiImunisasi'] == 'Menolak Untuk di Imunisasi'){echo "SELECTED";}?>>Menolak Untuk di Imunisasi</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><b>C. Tindakan</b></td>
									<td colspan="2">
										<input type="text" name="imunisasi_tindakan_mtbs" class="form-control inputan" maxlength = "50" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['TindakanImunisasi'];?>"></text>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--12. Vit.A & Keluhan Lain-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#vita">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;12. Pemberian Vit.A & Keluhan Lain
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="vita">
						<div class="panel-body">
							<table class="table-judul">
								<tr>
									<td colspan="3"><b>A. Penilaian</b></td>
								</tr>
								<tr>
									<td class="col-sm-3">1. Pemeriksaan</td>
									<td class="col-sm-9">
										<?php $prk_vita = explode(',',$datapemeriksaan['PemeriksaanVitA']);?>
										<label><input type="checkbox" name="prk_vita_mtbs[]" value="Dibutuhkan suplemen viamin A" <?php if (in_array("Dibutuhkan suplemen viamin A", $prk_vita)) {echo "checked";}?>> Dibutuhkan suplemen viamin A</label><br>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">2. Masalah atau keluhan lain</td>
									<td class="col-sm-9">
										<input type="text" name="keluhanlain_mtbs" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['MasalahVitA'];?>">
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--13. Pemberian makan-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#makan">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;13. Penilaian Pemberian Makan
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="makan">
						<div class="panel-body">
							<table class="table-judul">
								<tr>
									<td colspan="3"><b>A. Penilaian</b></td>
								</tr>
								<tr>
									<td class="col-sm-3">1. Apakah ibu menyusui anak ini</td>
									<td class="col-sm-9">
										<select name="makan_mtbs_1" class="form-control inputan">
											<option value="-" <?php if($datapemeriksaan['IbuMenyusui'] == '-'){echo "SELECTED";}?>>-Pilih-</option>
											<option value="Ya" <?php if($datapemeriksaan['IbuMenyusui'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
											<option value="Tidak" <?php if($datapemeriksaan['IbuMenyusui'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">2. Jika ya, berapa kali sehari</td>
									<td class="col-sm-9">
										<input type="text" name="makan_mtbs_2" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['BerapaKaliMenyusu'];?>">
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">3. Apakah menyusui dimalam hari</td>
									<td class="col-sm-9">
										<select name="makan_mtbs_3" class="form-control inputan">
											<option value="-" <?php if($datapemeriksaan['AnakMenyusuMalam'] == '-'){echo "SELECTED";}?>>-Pilih-</option>
											<option value="Ya" <?php if($datapemeriksaan['AnakMenyusuMalam'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
											<option value="Tidak" <?php if($datapemeriksaan['AnakMenyusuMalam'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">4. Anak mendapat makan/minum lain</td>
									<td class="col-sm-9">
										<select name="makan_mtbs_4" class="form-control inputan">
											<option value="-" <?php if($datapemeriksaan['AnakDapatMakananLain'] == '-'){echo "SELECTED";}?>>-Pilih-</option>
											<option value="Ya" <?php if($datapemeriksaan['AnakDapatMakananLain'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
											<option value="Tidak" <?php if($datapemeriksaan['AnakDapatMakananLain'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">5. Jika ya, makan/minum apa</td>
									<td class="col-sm-9">
										<input type="text" name="makan_mtbs_5" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['MakananApa'];?>">
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">6. Berapa kali sehari</td>
									<td class="col-sm-9">
										<input type="text" name="makan_mtbs_6" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['BerapaKaliMakan'];?>">
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">7. Alat yang digunakan</td>
									<td class="col-sm-9">
										<input type="text" name="makan_mtbs_7" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['AlatDigunakan'];?>">
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">8. Berapa banyak makan yg diberikan</td>
									<td class="col-sm-9">
										<input type="text" name="makan_mtbs_8" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['BerapaBanyakMakan'];?>">
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">9. Anak mendapatkan makanan tersendiri</td>
									<td class="col-sm-9">
										<select name="makan_mtbs_9" class="form-control inputan">
											<option value="-" <?php if($datapemeriksaan['AnakDapatMakanSendiri'] == '-'){echo "SELECTED";}?>>-Pilih-</option>
											<option value="Ya" <?php if($datapemeriksaan['AnakDapatMakanSendiri'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
											<option value="Tidak" <?php if($datapemeriksaan['AnakDapatMakanSendiri'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">10. Siapa yang meberi makan, caranya?</td>
									<td class="col-sm-9">
										<input type="text" name="makan_mtbs_10" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['SiapaMemberiMakan'];?>">
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">11. Ada perubahan pemberian makan</td>
									<td class="col-sm-9">
										<select name="makan_mtbs_11" class="form-control inputan">
											<option value="-" <?php if($datapemeriksaan['PerubahanMakan'] == '-'){echo "SELECTED";}?>>-Pilih-</option>
											<option value="Ya" <?php if($datapemeriksaan['PerubahanMakan'] == 'Ya'){echo "SELECTED";}?>>Ya</option>
											<option value="Tidak" <?php if($datapemeriksaan['PerubahanMakan'] == 'Tidak'){echo "SELECTED";}?>>Tidak</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">12. Jika ya, bagaimana?</td>
									<td class="col-sm-9">
										<input type="text" name="makan_mtbs_12" class="form-control inputan" maxlength ="100" placeholder = "Jelaskan (Maks.50 digit)" value = "<?php echo $datapemeriksaan['BagaimanaMakan'];?>">
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!--14. Rujukan dan Kunjungan Ulang-->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#rujukan">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;14. Rujukan dan Kunjungan Ulang
							</a>
						</h4>
					</div>
					<div class="panel-collapse collapse" id="rujukan">
						<div class="panel-body">
							<table class="table-judul">
								<tr>
									<td class="col-sm-3">1. Tempat di rujuk</td>
									<td class="col-sm-9">
										<select name="tempat_rujuk" class="form-control inputan">
											<option value="-" <?php if($datapemeriksaan['TempatRujuk'] == '-'){echo "SELECTED";}?>>-Pilih-</option>
											<option value="Balita Sakit Dengan Pelayanan Mtbs" <?php if($datapemeriksaan['TempatRujuk'] == 'Balita Sakit Dengan Pelayanan Mtbs'){echo "SELECTED";}?>>Balita Sakit Dengan Pelayanan Mtbs</option>
											<option value="Balita Sakit Dengan Pelayanan Mtbs ke RS" <?php if($datapemeriksaan['TempatRujuk'] == 'Balita Sakit Dengan Pelayanan Mtbs ke RS'){echo "SELECTED";}?>>Balita Sakit Dengan Pelayanan Mtbs ke RS</option>
											<option value="Balita Sakit Dengan Pelayanan Mtbs ke Ka Puskesmas" <?php if($datapemeriksaan['TempatRujuk'] == 'Balita Sakit Dengan Pelayanan Mtbs ke Ka Puskesmas'){echo "SELECTED";}?>>Balita Sakit Dengan Pelayanan Mtbs ke Ka Puskesmas</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">2. Tanggal Kunj.Ulang</td>
									<td class="col-sm-9">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												$hariini = date('Y-m-d');
											?>
											<input type="text" name="tanggalkunjulang" class="form-control inputan datepicker" value="<?php echo $hariini;?>">
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">3. Klasifikasi</td>
									<td class="col-sm-9">
										<select name="rujukan_klasifikasi_mtbs" class="form-control inputan">
											<option value="-" <?php if($datapemeriksaan['KlasifikasiRujuk'] == '-'){echo "SELECTED";}?>>-Pilih-</option>
											<option value="Datang Tepat Untuk Kunjungan Ulang" <?php if($datapemeriksaan['KlasifikasiRujuk'] == 'Datang Tepat Untuk Kunjungan Ulang'){echo "SELECTED";}?>>Datang Tepat Untuk Kunjungan Ulang</option>
											<option value="Tidak Tepat Datang Untuk Kunjungan Ulang" <?php if($datapemeriksaan['KlasifikasiRujuk'] == 'Tidak Tepat Datang Untuk Kunjungan Ulang'){echo "SELECTED";}?>>Tidak Tepat Datang Untuk Kunjungan Ulang</option>
											<option value="Tidak Datang Untuk Kunjungan Ulang" <?php if($datapemeriksaan['KlasifikasiRujuk'] == 'Tidak Datang Untuk Kunjungan Ulang'){echo "SELECTED";}?>>Tidak Datang Untuk Kunjungan Ulang</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>