<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpoligigi` WHERE `NoPemeriksaan` = '$noregistrasi'"));

	// vital sign
	$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
	$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
?>	
<style type="text/css">
	.siodogram, .siodogram:hover{
		color:#000;text-decoration: none;
	}	
</style>
<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul">
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
				<td><textarea type="text" name ="anjuran" class="form-control inputan"><?php echo $datapemeriksaan['Anjuran'];?></textarea></td>
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
					<textarea type="text" name ="pemeriksaanpenunjanglab" class="form-control inputan"><?php echo $pem_lab;?></textarea>
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
				<h3 class="judul mt-4"><b>Pemeriksaan Penunjang</b></h3>
				<tr>
					<td class="col-sm-3">Rencana Therapy</td>
					<td class="col-sm-9"><textarea name ="rencanaterapi" class="form-control inputan" placeholder="Misal : EXO 36"><?php echo $datapemeriksaan['RencanaTerapi'];?></textarea></td>
				</tr>
				<tr>
					<td>Tindakan</td>
					<td><textarea name ="tindakangigi" class="form-control inputan" placeholder="Misal : EXO INFILT 36, 1 XYLESTESIN, 1 JARUM CYTOJECT"><?php echo $datapemeriksaan['Tindakan'];?></textarea></td>
				</tr>
				<tr>
					<td>Informed Consent</td>
					<td>
						<select name="ic" class="form-control inputan">
							<option value="YA" <?php if($datapemeriksaan['InformedConsent'] == 'YA'){echo "SELECTED";}?>>YA</option>
							<option value="TIDAK" <?php if($datapemeriksaan['InformedConsent'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Tindak Lanjut ke-1</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<select name="tindaklanjut1" class="form-control inputan">
									<option value="-">--Pilih--</option>
									<option value="PENAMBALAN GIGI SULUNG (LC/KOMPOSIT)" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENAMBALAN GIGI SULUNG (LC/KOMPOSIT)'){echo "SELECTED";}?>>PENAMBALAN GIGI SULUNG (LC/KOMPOSIT)</option>
									<option value="PENAMBALAN GIGI SULUNG (GIC)" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENAMBALAN GIGI SULUNG (GIC)'){echo "SELECTED";}?>>PENAMBALAN GIGI SULUNG (GIC)</option>
									<option value="PENAMBALAN GIGI TETAP (LC/KOMPOSIT)" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENAMBALAN GIGI TETAP (LC/KOMPOSIT)'){echo "SELECTED";}?>>PENAMBALAN GIGI TETAP (LC/KOMPOSIT)</option>
									<option value="PENAMBALAN GIGI TETAP (GIC)" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENAMBALAN GIGI TETAP (GIC)'){echo "SELECTED";}?>>PENAMBALAN GIGI TETAP (GIC)</option>
									<option value="PENAMBALAN SEMENTARA GIGI SULUNG" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENAMBALAN SEMENTARA GIGI SULUNG'){echo "SELECTED";}?>>PENAMBALAN SEMENTARA GIGI SULUNG</option>
									<option value="PENAMBALAN SEMENTARA GIGI TETAP" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENAMBALAN SEMENTARA GIGI TETAP'){echo "SELECTED";}?>>PENAMBALAN SEMENTARA GIGI TETAP</option>
									<option value="PENCABUTAN GIGI SULUNG" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENCABUTAN GIGI SULUNG'){echo "SELECTED";}?>>PENCABUTAN GIGI SULUNG</option>
									<option value="PENCABUTAN GIGI TETAP" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENCABUTAN GIGI TETAP'){echo "SELECTED";}?>>PENCABUTAN GIGI TETAP</option>
									<option value="PENGOBATAN PULPA" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENGOBATAN PULPA'){echo "SELECTED";}?>>PENGOBATAN PULPA</option>
									<option value="PENGOBATAN PERIODONTAL" <?php if($datapemeriksaan['TindakLanjut1'] == 'PENGOBATAN PERIODONTAL'){echo "SELECTED";}?>>PENGOBATAN PERIODONTAL</option>
									<option value="PREMEDIKASI" <?php if($datapemeriksaan['TindakLanjut1'] == 'PREMEDIKASI'){echo "SELECTED";}?>>PREMEDIKASI</option>
									<option value="SCALLING" <?php if($datapemeriksaan['TindakLanjut1'] == 'SCALLING'){echo "SELECTED";}?>>SCALLING</option>
									<option value="RUJUK" <?php if($datapemeriksaan['TindakLanjut1'] == 'RUJUK'){echo "SELECTED";}?>>RUJUK</option>
									<option value="LAINNYA" <?php if($datapemeriksaan['TindakLanjut1'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
								</select>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Tindak Lanjut ke-2</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<select name="tindaklanjut2" class="form-control inputan">
									<option value="-">--Pilih--</option>
									<option value="PENAMBALAN GIGI SULUNG (LC/KOMPOSIT)" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENAMBALAN GIGI SULUNG (LC/KOMPOSIT)'){echo "SELECTED";}?>>PENAMBALAN GIGI SULUNG (LC/KOMPOSIT)</option>
									<option value="PENAMBALAN GIGI SULUNG (GIC)" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENAMBALAN GIGI SULUNG (GIC)'){echo "SELECTED";}?>>PENAMBALAN GIGI SULUNG (GIC)</option>
									<option value="PENAMBALAN GIGI TETAP (LC/KOMPOSIT)" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENAMBALAN GIGI TETAP (LC/KOMPOSIT)'){echo "SELECTED";}?>>PENAMBALAN GIGI TETAP (LC/KOMPOSIT)</option>
									<option value="PENAMBALAN GIGI TETAP (GIC)" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENAMBALAN GIGI TETAP (GIC)'){echo "SELECTED";}?>>PENAMBALAN GIGI TETAP (GIC)</option>
									<option value="PENAMBALAN GIGI SULUNG (SEMENTARA)" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENAMBALAN SEMENTARA GIGI SULUNG'){echo "SELECTED";}?>>PENAMBALAN SEMENTARA GIGI SULUNG</option>
									<option value="PENAMBALAN GIGI TETAP (SEMENTARA)" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENAMBALAN SEMENTARA GIGI TETAP'){echo "SELECTED";}?>>PENAMBALAN SEMENTARA GIGI TETAP</option>
									<option value="PENCABUTAN GIGI SULUNG" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENCABUTAN GIGI SULUNG'){echo "SELECTED";}?>>PENCABUTAN GIGI SULUNG</option>
									<option value="PENCABUTAN GIGI TETAP" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENCABUTAN GIGI TETAP'){echo "SELECTED";}?>>PENCABUTAN GIGI TETAP</option>
									<option value="PENGOBATAN PULPA" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENGOBATAN PULPA'){echo "SELECTED";}?>>PENGOBATAN PULPA</option>
									<option value="PENGOBATAN PERIODONTAL" <?php if($datapemeriksaan['TindakLanjut2'] == 'PENGOBATAN PERIODONTAL'){echo "SELECTED";}?>>PENGOBATAN PERIODONTAL</option>
									<option value="PREMEDIKASI" <?php if($datapemeriksaan['TindakLanjut2'] == 'PREMEDIKASI'){echo "SELECTED";}?>>PREMEDIKASI</option>
									<option value="SCALLING" <?php if($datapemeriksaan['TindakLanjut2'] == 'SCALLING'){echo "SELECTED";}?>>SCALLING</option>
									<option value="RUJUK" <?php if($datapemeriksaan['TindakLanjut2'] == 'RUJUK'){echo "SELECTED";}?>>RUJUK</option>
									<option value="LAINNYA" <?php if($datapemeriksaan['TindakLanjut2'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
								</select>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Anjuran Kunj.Ulang</td>
					<td>
						<select name="anjurankunj" class="form-control inputan">
							<option value="-">--Pilih--</option>
							<option value="3 HARI" <?php if($datapemeriksaan['KunjunganUlang'] == '3 HARI'){echo "SELECTED";}?>>3 HARI</option>
							<option value="4 HARI" <?php if($datapemeriksaan['KunjunganUlang'] == '4 HARI'){echo "SELECTED";}?>>4 HARI</option>
							<option value="5 HARI" <?php if($datapemeriksaan['KunjunganUlang'] == '5 HARI'){echo "SELECTED";}?>>5 HARI</option>
							<option value="7 HARI" <?php if($datapemeriksaan['KunjunganUlang'] == '7 HARI'){echo "SELECTED";}?>>7 HARI</option>
							<option value="10 HARI" <?php if($datapemeriksaan['KunjunganUlang'] == '10 HARI'){echo "SELECTED";}?>>10 HARI</option>
							<option value="14 HARI" <?php if($datapemeriksaan['KunjunganUlang'] == '14 HARI'){echo "SELECTED";}?>>14 HARI</option>
							<option value="1 Bulan" <?php if($datapemeriksaan['KunjunganUlang'] == '1 Bulan'){echo "SELECTED";}?>>1 Bulan</option>
							<option value="3 Bulan" <?php if($datapemeriksaan['KunjunganUlang'] == '3 Bulan'){echo "SELECTED";}?>>3 Bulan</option>
							<option value="6 Bulan" <?php if($datapemeriksaan['KunjunganUlang'] == '6 Bulan'){echo "SELECTED";}?>>6 Bulan</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Jika Rujuk ke</td>
					<td>
						<select name="jikarujuk" class="form-control inputan">
							<option value="-">--Pilih--</option>
							<option value="RUMAH SAKIT" <?php if($datapemeriksaan['TindakLanjutRujuk'] == 'RUMAH SAKIT'){echo "SELECTED";}?>>RUMAH SAKIT</option>
							<option value="UNIT KESEHATAN LAIN" <?php if($datapemeriksaan['TindakLanjutRujuk'] == 'UNIT KESEHATAN LAIN'){echo "SELECTED";}?>>UNIT KESEHATAN LAIN</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Kunjungan Gigi</td>
					<td>
						<div class="row" style="margin:-10px 0px 0px -15px">
							<div class="input-group" style="padding:10px 0px 0px 15px">
								<select name="kunjungangigi" class="kunjungangigi form-control inputan" required>
									<option value="MASYARAKAT UMUM" <?php if($datapemeriksaan['KunjunganGigi'] == 'MASYARAKAT UMUM'){echo "SELECTED";}?>>MASYARAKAT UMUM</option>
									<option value="ANAK PRASEKOLAH" <?php if($datapemeriksaan['KunjunganGigi'] == 'ANAK PRASEKOLAH'){echo "SELECTED";}?>>ANAK PRASEKOLAH</option>
									<option value="ANAK SEKOLAH" <?php if($datapemeriksaan['KunjunganGigi'] == 'ANAK SEKOLAH'){echo "SELECTED";}?>>ANAK SEKOLAH</option>
									<option value="IBU HAMIL" <?php if($datapemeriksaan['KunjunganGigi'] == 'IBU HAMIL'){echo "SELECTED";}?>>IBU HAMIL</option>
									<option value="UKGS" <?php if($datapemeriksaan['KunjunganGigi'] == 'UKGS'){echo "SELECTED";}?>>UKGS</option>
									<option value="UKGMD" <?php if($datapemeriksaan['KunjunganGigi'] == 'UKGMD'){echo "SELECTED";}?>>UKGMD</option>
									<option value="ANAK SD/MI" <?php if($datapemeriksaan['KunjunganGigi'] == 'ANAK SD/MI'){echo "SELECTED";}?>>ANAK SD/MI</option>
								</select>
								<div class="input-group-append">
									<span class="input-group-text">LB</span>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Terima Rujukan</td>
					<td>
						<select name="terimarujukan" class="form-control inputan">
							<option value="-">--Pilih--</option>
							<option value="RUMAH SAKIT" <?php if($datapemeriksaan['TerimaRujukan'] == 'RUMAH SAKIT'){echo "SELECTED";}?>>RUMAH SAKIT</option>
							<option value="UNIT KESEHATAN LAIN" <?php if($datapemeriksaan['TerimaRujukan'] == 'UNIT KESEHATAN LAIN'){echo "SELECTED";}?>>UNIT KESEHATAN LAIN</option>
							<option value="UKGS" <?php if($datapemeriksaan['TerimaRujukan'] == 'UKGS'){echo "SELECTED";}?>>UKGS</option>
							<option value="POSYANDU/UKGM" <?php if($datapemeriksaan['TerimaRujukan'] == 'POSYANDU/UKGM'){echo "SELECTED";}?>>POSYANDU/UKGM</option>
							<option value="LAINNYA" <?php if($datapemeriksaan['TerimaRujukan'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
						</select>
					</td>
				</tr>
			</table>
			<table class="table-judul" width="100%">
				<h3 class="judul mt-5"><b>Pemeriksaan Ekstra Oral</b></h3>
				<tr>
					<td class="col-sm-3">Palpasi</td>
					<td class="col-sm-9">
						<select name="palpasi" class="form-control inputan">
							<option value="KENYAL" <?php if($datapemeriksaan['Palpasi'] == 'KENYAL'){echo "SELECTED";}?>>KENYAL</option>
							<option value="KERAS" <?php if($datapemeriksaan['Palpasi'] == 'KERAS'){echo "SELECTED";}?>>KERAS</option
							<option value="LUNAK" <?php if($datapemeriksaan['Palpasi'] == 'LUNAK'){echo "SELECTED";}?>>LUNAK</option>
							<option value="-" <?php if($datapemeriksaan['Palpasi'] == '-'){echo "SELECTED";}?>>-</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Suhu Kulit</td>
					<td>
						<input type ="text" name ="suhukulit" class="form-control inputan" maxlength="10" value="<?php if($datapemeriksaan == ''){echo 'NORMAL';}else{echo $datapemeriksaan['SuhuKulit'];}?>">
					</td>
				</tr>
				<tr>
					<td>Bibir</td>
					<td>
						<input type ="text" name ="bibirgigi" class="form-control inputan" maxlength="10" value="<?php if($datapemeriksaan == ''){echo 'NORMAL';}else{echo $datapemeriksaan['Bibir'];}?>">
					</td>
				</tr>
				<tr>
					<td>Kelenjar Linfe</td>
					<td>
						<select name="kelenjarlinfe" class="form-control inputan">
							<option value="NORMAL" <?php if($datapemeriksaan['KelenjarLinfe'] == 'NORMAL'){echo "SELECTED";}?>>NORMAL</option>
							<option value="KERAS" <?php if($datapemeriksaan['KelenjarLinfe'] == 'KERAS'){echo "SELECTED";}?>>KERAS</option>
							<option value="KENYAL" <?php if($datapemeriksaan['KelenjarLinfe'] == 'KENYAL'){echo "SELECTED";}?>>KENYAL</option>
							<option value="LUNAK" <?php if($datapemeriksaan['KelenjarLinfe'] == 'LUNAK'){echo "SELECTED";}?>>LUNAK</option>
							<option value="-" <?php if($datapemeriksaan['KelenjarLinfe'] == '-'){echo "SELECTED";}?>>-</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>TMJ</td>
					<td>
						<select name="tmj" class="form-control inputan">
							<option value="NORMAL" <?php if($datapemeriksaan['Tmj'] == 'NORMAL'){echo "SELECTED";}?>>NORMAL</option>
							<option value="CLIKING" <?php if($datapemeriksaan['Tmj'] == 'CLIKING'){echo "SELECTED";}?>>CLIKING</option>
							<option value="LAINNYA" <?php if($datapemeriksaan['Tmj'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Trismus</td>
					<td>
						<select name="trismus" class="form-control inputan">
							<option value="TIDAK" <?php if($datapemeriksaan['Trismus'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
							<option value="1 JARI" <?php if($datapemeriksaan['Trismus'] == '1 JARI'){echo "SELECTED";}?>>1 JARI</option>
							<option value="2 JARI" <?php if($datapemeriksaan['Trismus'] == '2 JARI'){echo "SELECTED";}?>>2 JARI</option>
							<option value="3 JARI" <?php if($datapemeriksaan['Trismus'] == '3 JARI'){echo "SELECTED";}?>>3 JARI</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Keterangan Tambahan</td>
					<td><textarea name ="kettambahanekstra" class="form-control inputan" style="height: 150px;"><?php echo $datapemeriksaan['KeteranganTambahanEkstra'];?></textarea></td>
				</tr>
			</table>
			<table class="table-judul" width="100%">
				<h3 class="judul mt-5"><b>Pemeriksaan Intra Oral</b></h3>
				<tr>
					<td class="col-sm-3">Karies Gigi</td>
					<td class="col-sm-9">
						<select name="kariesgigi" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['KariesGigi'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="SUPERFISIALIS" <?php if($datapemeriksaan['KariesGigi'] == 'SUPERFISIALIS'){echo "SELECTED";}?>>SUPERFISIALIS</option>
							<option value="MEDIA" <?php if($datapemeriksaan['KariesGigi'] == 'MEDIA'){echo "SELECTED";}?>>MEDIA</option>
							<option value="PROFUNDA" <?php if($datapemeriksaan['KariesGigi'] == 'PROFUNDA'){echo "SELECTED";}?>>PROFUNDA</option>
							<option value="PROFUNDA PERFORASI" <?php if($datapemeriksaan['KariesGigi'] == 'PROFUNDA PERFORASI'){echo "SELECTED";}?>>PROFUNDA PERFORASI</option>
							<option value="SISA AKAR" <?php if($datapemeriksaan['KariesGigi'] == 'SISA AKAR'){echo "SELECTED";}?>>SISA AKAR</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Sondase</td>
					<td>
						<select name="sondase" class="form-control inputan">
						<option value="NEGATIF" <?php if($datapemeriksaan['Sondase'] == 'NEGATIF'){echo "SELECTED";}?>>NEGATIF</option>
							<option value="POSITIF" <?php if($datapemeriksaan['Sondase'] == 'POSITIF'){echo "SELECTED";}?>>POSITIF</option>
							<option value="-" <?php if($datapemeriksaan['Sondase'] == '-'){echo "SELECTED";}?>>-</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Perkusi</td>
					<td>
						<select name="perkusi" class="form-control inputan">
							<option value="NEGATIF" <?php if($datapemeriksaan['Perkusi'] == 'NEGATIF'){echo "SELECTED";}?>>NEGATIF</option>
							<option value="POSITIF" <?php if($datapemeriksaan['Perkusi'] == 'POSITIF'){echo "SELECTED";}?>>POSITIF</option>
							<option value="-" <?php if($datapemeriksaan['Perkusi'] == '-'){echo "SELECTED";}?>>-</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Tekanan</td>
					<td>
						<select name="tekananintraoral" class="form-control inputan">
						<option value="NEGATIF" <?php if($datapemeriksaan['Tekanan'] == 'NEGATIF'){echo "SELECTED";}?>>NEGATIF</option>
							<option value="POSITIF" <?php if($datapemeriksaan['Tekanan'] == 'POSITIF'){echo "SELECTED";}?>>POSITIF</option>
							<option value="-" <?php if($datapemeriksaan['Tekanan'] == '-'){echo "SELECTED";}?>>-</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Goyang</td>
					<td>
						<select name="goyangintraoral" class="form-control inputan">
							<option value="-" <?php if($datapemeriksaan['Goyang'] == '-'){echo "SELECTED";}?>>-</option>
							<option value="GRADE 1" <?php if($datapemeriksaan['Goyang'] == 'GRADE 1'){echo "SELECTED";}?>>GRADE 1</option>
							<option value="GRADE 2" <?php if($datapemeriksaan['Goyang'] == 'GRADE 2'){echo "SELECTED";}?>>GRADE 2</option>
							<option value="GRADE 3" <?php if($datapemeriksaan['Goyang'] == 'GRADE 3'){echo "SELECTED";}?>>GRADE 3</option>
							<option value="PERSISTENSI" <?php if($datapemeriksaan['Goyang'] == 'PERSISTENSI'){echo "SELECTED";}?>>PERSISTENSI</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Warna Gusi</td>
					<td>
						<select name="warnagusi" class="form-control inputan">
							<option value="MERAH MUDA" <?php if($datapemeriksaan['WarnaGusi'] == 'MERAH MUDA'){echo "SELECTED";}?>>MERAH MUDA</option>
							<option value="MERAH TUA" <?php if($datapemeriksaan['WarnaGusi'] == 'MERAH TUA'){echo "SELECTED";}?>>MERAH TUA</option>
							<option value="KEHITAMAN" <?php if($datapemeriksaan['WarnaGusi'] == 'KEHITAMAN'){echo "SELECTED";}?>>KEHITAMAN</option>
							<option value="PUTIH" <?php if($datapemeriksaan['WarnaGusi'] == 'PUTIH'){echo "SELECTED";}?>>PUTIH</option>
							<option value="-" <?php if($datapemeriksaan['WarnaGusi'] == '-'){echo "SELECTED";}?>>-</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Konstensi</td>
					<td>
						<select name="konstensi" class="form-control inputan">
							<option value="KENYAL" <?php if($datapemeriksaan['Konstensi'] == 'KENYAL'){echo "SELECTED";}?>>KENYAL</option>
							<option value="KERAS" <?php if($datapemeriksaan['Konstensi'] == 'KERAS'){echo "SELECTED";}?>>KERAS</option>
							<option value="LUNAK" <?php if($datapemeriksaan['Konstensi'] == 'LUNAK'){echo "SELECTED";}?>>LUNAK</option>
							<option value="-" <?php if($datapemeriksaan['Konstensi'] == '-'){echo "SELECTED";}?>>-</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Bengkak</td>
					<td>
						<select name="bengkakgigi" class="form-control inputan">
							<option value="NEGATIF" <?php if($datapemeriksaan['Bengkak'] == 'NEGATIF'){echo "SELECTED";}?>>NEGATIF</option>
							<option value="POSITIF" <?php if($datapemeriksaan['Bengkak'] == 'POSITIF'){echo "SELECTED";}?>>POSITIF</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Keterangan Tambahan</td>
					<td><textarea name ="kettambahanintra" class="form-control inputan" style="height: 150px;"><?php echo $datapemeriksaan['KeteranganTambahanIntra'];?></textarea></td>
				</tr>
			</table>
			<table class="table-judul" width="100%">
				<h3 class="judul mt-5"><b>Odontogram</b></h3>
				<tr>
					<td>
						<style>
							.tblmapsgigi{
								width:825px;text-align:center;
							}
							.tblmapsgigi td{
								padding:5px;
							}
						</style>
						<table class="tblmapsgigi" style="margin-left: auto; margin-right: auto;">
							<?php
							$idpasien = $_GET['idps'];
							$dtpodontogram = array();
								$getdtodontogrampasien = mysqli_query($koneksi, "SELECT * FROM tbpoligigi_odontogram a JOIN ref_odontogram b on a.IdOdontogram = b.IdOdontogram WHERE a.IdPasien = '$idpasien'");
								if(mysqli_num_rows($getdtodontogrampasien) > 0){
									while($doo = mysqli_fetch_assoc($getdtodontogrampasien)){
										$dtpodontogram[$doo['NoGigi']] = $doo['KodeOdontogram'];
										$dtpodontogram_keterangan[$doo['NoGigi']] = $doo['Keterangan'];
									}
								}
							?>
							<tr>
								<td>18<a href="#" class="atblmapsgigi" data-no="18" data-keterangan="<?php echo $dtpodontogram_keterangan[18];?>"><img src="<?php echo (!array_key_exists("18",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['18'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>17<a href="#" class="atblmapsgigi" data-no="17" data-keterangan="<?php echo $dtpodontogram_keterangan[17];?>"><img src="<?php echo (!array_key_exists("17",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['17'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>16<a href="#" class="atblmapsgigi" data-no="16" data-keterangan="<?php echo $dtpodontogram_keterangan[16];?>"><img src="<?php echo (!array_key_exists("16",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['16'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>15<a href="#" class="atblmapsgigi" data-no="15" data-keterangan="<?php echo $dtpodontogram_keterangan[15];?>"><img src="<?php echo (!array_key_exists("15",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['15'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>14<a href="#" class="atblmapsgigi" data-no="14" data-keterangan="<?php echo $dtpodontogram_keterangan[14];?>"><img src="<?php echo (!array_key_exists("14",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['14'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>13<a href="#" class="atblmapsgigi" data-no="13" data-keterangan="<?php echo $dtpodontogram_keterangan[13];?>"><img src="<?php echo (!array_key_exists("13",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['13'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>12<a href="#" class="atblmapsgigi" data-no="12" data-keterangan="<?php echo $dtpodontogram_keterangan[12];?>"><img src="<?php echo (!array_key_exists("12",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['12'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>11<a href="#" class="atblmapsgigi" data-no="11" data-keterangan="<?php echo $dtpodontogram_keterangan[11];?>"><img src="<?php echo (!array_key_exists("11",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['11'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>

								<td width="30px"></td>

								<td>21<a href="#" class="atblmapsgigi" data-no="21" data-keterangan="<?php echo $dtpodontogram_keterangan[21];?>"><img src="<?php echo (!array_key_exists("21",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['21'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>22<a href="#" class="atblmapsgigi" data-no="22" data-keterangan="<?php echo $dtpodontogram_keterangan[22];?>"><img src="<?php echo (!array_key_exists("22",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['22'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>23<a href="#" class="atblmapsgigi" data-no="23" data-keterangan="<?php echo $dtpodontogram_keterangan[23];?>"><img src="<?php echo (!array_key_exists("23",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['23'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>24<a href="#" class="atblmapsgigi" data-no="24" data-keterangan="<?php echo $dtpodontogram_keterangan[24];?>"><img src="<?php echo (!array_key_exists("24",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['24'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>25<a href="#" class="atblmapsgigi" data-no="25" data-keterangan="<?php echo $dtpodontogram_keterangan[25];?>"><img src="<?php echo (!array_key_exists("25",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['25'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>26<a href="#" class="atblmapsgigi" data-no="26" data-keterangan="<?php echo $dtpodontogram_keterangan[26];?>"><img src="<?php echo (!array_key_exists("26",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['26'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>27<a href="#" class="atblmapsgigi" data-no="27" data-keterangan="<?php echo $dtpodontogram_keterangan[27];?>"><img src="<?php echo (!array_key_exists("27",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['27'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
								<td>28<a href="#" class="atblmapsgigi" data-no="28" data-keterangan="<?php echo $dtpodontogram_keterangan[28];?>"><img src="<?php echo (!array_key_exists("28",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['26'].'.png';?>" width="40px" style="margin-bottom:20px"/></a></td>
							</tr>

							<tr>
								<td colspan="3" rowspan="2">KANAN / <i>RIGHT</i></td>							
								<td>55<a href="#" class="atblmapsgigi" data-no="55" data-keterangan="<?php echo $dtpodontogram_keterangan[55];?>"><img src="<?php echo (!array_key_exists("55",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['55'].'.png';?>" width="40px"></a></td>
								<td>54<a href="#" class="atblmapsgigi" data-no="54" data-keterangan="<?php echo $dtpodontogram_keterangan[54];?>"><img src="<?php echo (!array_key_exists("54",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['54'].'.png';?>" width="40px"></a></td>
								<td>53<a href="#" class="atblmapsgigi" data-no="53" data-keterangan="<?php echo $dtpodontogram_keterangan[53];?>"><img src="<?php echo (!array_key_exists("53",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['53'].'.png';?>" width="40px"></a></td>
								<td>52<a href="#" class="atblmapsgigi" data-no="52" data-keterangan="<?php echo $dtpodontogram_keterangan[52];?>"><img src="<?php echo (!array_key_exists("52",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['52'].'.png';?>" width="40px"></a></td>
								<td>51<a href="#" class="atblmapsgigi" data-no="51" data-keterangan="<?php echo $dtpodontogram_keterangan[51];?>"><img src="<?php echo (!array_key_exists("51",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['51'].'.png';?>" width="40px"></a></td>

								<td></td>

								<td>61<a href="#" class="atblmapsgigi" data-no="61" data-keterangan="<?php echo $dtpodontogram_keterangan[61];?>"><img src="<?php echo (!array_key_exists("61",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['61'].'.png';?>" width="40px"></a></td>
								<td>62<a href="#" class="atblmapsgigi" data-no="62" data-keterangan="<?php echo $dtpodontogram_keterangan[62];?>"><img src="<?php echo (!array_key_exists("62",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['62'].'.png';?>" width="40px"></a></td>
								<td>63<a href="#" class="atblmapsgigi" data-no="63" data-keterangan="<?php echo $dtpodontogram_keterangan[63];?>"><img src="<?php echo (!array_key_exists("63",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['63'].'.png';?>" width="40px"></a></td>
								<td>64<a href="#" class="atblmapsgigi" data-no="64" data-keterangan="<?php echo $dtpodontogram_keterangan[64];?>"><img src="<?php echo (!array_key_exists("64",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['64'].'.png';?>" width="40px"></a></td>
								<td>65<a href="#" class="atblmapsgigi" data-no="65" data-keterangan="<?php echo $dtpodontogram_keterangan[65];?>"><img src="<?php echo (!array_key_exists("65",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['65'].'.png';?>" width="40px"></a></td>
								<td colspan="3" rowspan="2">KIRI / <i>LEFT</i></td>
							</tr>
							<tr>
								<td><a href="#" class="atblmapsgigi" data-no="85" data-keterangan="<?php echo $dtpodontogram_keterangan[85];?>"><img src="<?php echo (!array_key_exists("85",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['85'].'.png';?>" width="40px"></a>85</td>
								<td><a href="#" class="atblmapsgigi" data-no="84" data-keterangan="<?php echo $dtpodontogram_keterangan[84];?>"><img src="<?php echo (!array_key_exists("84",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['84'].'.png';?>" width="40px"></a>84</td>
								<td><a href="#" class="atblmapsgigi" data-no="83" data-keterangan="<?php echo $dtpodontogram_keterangan[83];?>"><img src="<?php echo (!array_key_exists("83",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['83'].'.png';?>" width="40px"></a>83</td>
								<td><a href="#" class="atblmapsgigi" data-no="82" data-keterangan="<?php echo $dtpodontogram_keterangan[82];?>"><img src="<?php echo (!array_key_exists("82",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['82'].'.png';?>" width="40px"></a>82</td>
								<td><a href="#" class="atblmapsgigi" data-no="81" data-keterangan="<?php echo $dtpodontogram_keterangan[81];?>"><img src="<?php echo (!array_key_exists("81",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['81'].'.png';?>" width="40px"></a>81</td>

								<td></td>

								<td><a href="#" class="atblmapsgigi" data-no="71" data-keterangan="<?php echo $dtpodontogram_keterangan[71];?>"><img src="<?php echo (!array_key_exists("71",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['71'].'.png';?>" width="40px"></a>71</td>
								<td><a href="#" class="atblmapsgigi" data-no="72" data-keterangan="<?php echo $dtpodontogram_keterangan[72];?>"><img src="<?php echo (!array_key_exists("72",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['72'].'.png';?>" width="40px"></a>72</td>
								<td><a href="#" class="atblmapsgigi" data-no="73" data-keterangan="<?php echo $dtpodontogram_keterangan[73];?>"><img src="<?php echo (!array_key_exists("73",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['73'].'.png';?>" width="40px"></a>73</td>
								<td><a href="#" class="atblmapsgigi" data-no="74" data-keterangan="<?php echo $dtpodontogram_keterangan[74];?>"><img src="<?php echo (!array_key_exists("74",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['74'].'.png';?>" width="40px"></a>74</td>
								<td><a href="#" class="atblmapsgigi" data-no="75" data-keterangan="<?php echo $dtpodontogram_keterangan[75];?>"><img src="<?php echo (!array_key_exists("75",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['75'].'.png';?>" width="40px"></a>75</td>
							</tr>

							<tr>
								<td><a href="#" class="atblmapsgigi" data-no="48" data-keterangan="<?php echo $dtpodontogram_keterangan[48];?>"><img src="<?php echo (!array_key_exists("48",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['48'].'.png';?>" width="40px" style="margin-top:20px"/></a>48</td>
								<td><a href="#" class="atblmapsgigi" data-no="47" data-keterangan="<?php echo $dtpodontogram_keterangan[47];?>"><img src="<?php echo (!array_key_exists("47",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['47'].'.png';?>" width="40px" style="margin-top:20px"/></a>47</td>
								<td><a href="#" class="atblmapsgigi" data-no="46" data-keterangan="<?php echo $dtpodontogram_keterangan[46];?>"><img src="<?php echo (!array_key_exists("46",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['46'].'.png';?>" width="40px" style="margin-top:20px"/></a>46</td>
								<td><a href="#" class="atblmapsgigi" data-no="45" data-keterangan="<?php echo $dtpodontogram_keterangan[45];?>"><img src="<?php echo (!array_key_exists("45",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['45'].'.png';?>" width="40px" style="margin-top:20px"/></a>45</td>
								<td><a href="#" class="atblmapsgigi" data-no="44" data-keterangan="<?php echo $dtpodontogram_keterangan[44];?>"><img src="<?php echo (!array_key_exists("44",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['44'].'.png';?>" width="40px" style="margin-top:20px"/></a>44</td>
								<td><a href="#" class="atblmapsgigi" data-no="43" data-keterangan="<?php echo $dtpodontogram_keterangan[43];?>"><img src="<?php echo (!array_key_exists("43",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['43'].'.png';?>" width="40px" style="margin-top:20px"/></a>43</td>
								<td><a href="#" class="atblmapsgigi" data-no="42" data-keterangan="<?php echo $dtpodontogram_keterangan[42];?>"><img src="<?php echo (!array_key_exists("42",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['42'].'.png';?>" width="40px" style="margin-top:20px"/></a>42</td>
								<td><a href="#" class="atblmapsgigi" data-no="41" data-keterangan="<?php echo $dtpodontogram_keterangan[41];?>"><img src="<?php echo (!array_key_exists("41",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['41'].'.png';?>" width="40px" style="margin-top:20px"/></a>41</td>

								<td></td>

								<td><a href="#" class="atblmapsgigi" data-no="31" data-keterangan="<?php echo $dtpodontogram_keterangan[31];?>"><img src="<?php echo (!array_key_exists("31",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['31'].'.png';?>" width="40px" style="margin-top:20px"/></a>31</td>
								<td><a href="#" class="atblmapsgigi" data-no="32" data-keterangan="<?php echo $dtpodontogram_keterangan[32];?>"><img src="<?php echo (!array_key_exists("32",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['32'].'.png';?>" width="40px" style="margin-top:20px"/></a>32</td>
								<td><a href="#" class="atblmapsgigi" data-no="33" data-keterangan="<?php echo $dtpodontogram_keterangan[33];?>"><img src="<?php echo (!array_key_exists("33",$dtpodontogram)) ? 'image/gbpg1.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['33'].'.png';?>" width="40px" style="margin-top:20px"/></a>33</td>
								<td><a href="#" class="atblmapsgigi" data-no="34" data-keterangan="<?php echo $dtpodontogram_keterangan[34];?>"><img src="<?php echo (!array_key_exists("34",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['34'].'.png';?>" width="40px" style="margin-top:20px"/></a>34</td>
								<td><a href="#" class="atblmapsgigi" data-no="35" data-keterangan="<?php echo $dtpodontogram_keterangan[35];?>"><img src="<?php echo (!array_key_exists("35",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['35'].'.png';?>" width="40px" style="margin-top:20px"/></a>35</td>
								<td><a href="#" class="atblmapsgigi" data-no="36" data-keterangan="<?php echo $dtpodontogram_keterangan[36];?>"><img src="<?php echo (!array_key_exists("36",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['36'].'.png';?>" width="40px" style="margin-top:20px"/></a>36</td>
								<td><a href="#" class="atblmapsgigi" data-no="37" data-keterangan="<?php echo $dtpodontogram_keterangan[37];?>"><img src="<?php echo (!array_key_exists("37",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['37'].'.png';?>" width="40px" style="margin-top:20px"/></a>37</td>
								<td><a href="#" class="atblmapsgigi" data-no="38" data-keterangan="<?php echo $dtpodontogram_keterangan[38];?>"><img src="<?php echo (!array_key_exists("38",$dtpodontogram)) ? 'image/gbpg2.jpg' : 'assets/simbol_odontogram/'.$dtpodontogram['38'].'.png';?>" width="40px" style="margin-top:20px"/></a>38</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="myModalpoligigi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Poli GIGI</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table-judul">
					<?php
						$getdtodontogram = mysqli_query($koneksi,"SELECT * FROM `ref_odontogram` ORDER By IdOdontogram ASC");
						if(mysqli_num_rows($getdtodontogram) > 0){
							while($doo = mysqli_fetch_assoc($getdtodontogram)){
					?>
						<tr class="" >
							<td width="100px"><img src="assets/simbol_odontogram/<?php echo $doo['KodeOdontogram']?>.png" width="40px"></td>
							<td><?php echo $doo['Odontogram']?> (<?php echo $doo['KodeOdontogram']?>)</td>
							<td class="col-md-5"><input type="text" class="form-control keterangan_val"/></td>
							<td><input type="button" class="btn btn-info btn-sm siodogram" value="pilih" data-val="<?php echo $doo['IdOdontogram']?>"/></td>
						</tr>
					<?php
							}
						}
					?>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModalpoligigi_lihat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Poli GIGI</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				as
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
		// $(document).on('click', '.atblmapsgigi', function(e){
		// 	e.preventDefault();
		// 	$(this).addClass('tmpterpilih');
		// 	$("#myModalpoligigi").modal('show');

		// 	$(".siodogram").click(function(){
		// 		var keterangan = $(this).parent().parent().find(".keterangan_val").val();
		// 		var srcimg = $(this).parent().parent().find("img").attr('src');
		// 		$(".tmpterpilih").find("img").attr('src',srcimg);
		// 		var valodo = $(this).data('val');
		// 		var nogigi = $(".tmpterpilih").data('no');
		// 		$(".tmpterpilih").append("<input type='hidden' name='nogigi_odontogram["+nogigi+"]' value='"+valodo+"'><input type='hidden' name='nogigi_odontogram_keterangan["+nogigi+"]' value='"+keterangan+"'>");

		// 		$("#myModalpoligigi").modal('hide');

		// 		$(".atblmapsgigi").removeClass('tmpterpilih');
		// 	});
		// });

		$('.atblmapsgigi').mousedown(function(event) {
			switch (event.which) {
				case 1:
					//ketika klik kiri
					event.preventDefault();
					$(".atblmapsgigi").removeClass('tmpterpilih');
					$(this).addClass('tmpterpilih');
					$("#myModalpoligigi").modal('show');

					$(".siodogram").click(function(){
						var keterangan = $(this).parent().parent().find(".keterangan_val").val();
						var srcimg = $(this).parent().parent().find("img").attr('src');
						$(".tmpterpilih").find("img").attr('src',srcimg);
						$(".tmpterpilih").data('keterangan',keterangan);
						var valodo = $(this).data('val');
						var nogigi = $(".tmpterpilih").data('no');
						$(".tmpterpilih").append("<input type='hidden' name='nogigi_odontogram["+nogigi+"]' value='"+valodo+"'><input type='hidden' name='nogigi_odontogram_keterangan["+nogigi+"]' value='"+keterangan+"'>");
						$("#myModalpoligigi").modal('hide');
						$(".atblmapsgigi").removeClass('tmpterpilih');
						$(".keterangan_val").val("");
					});
					break;
				case 2:
					//alert('Middle Mouse button pressed.');
					break;
				case 3:
					//$("#myModalpoligigi_lihat").modal('show');
					var ket = $(this).data('keterangan');
					if(ket == ''){
						alert('Tidak ada keterangan');
					}else{
						alert('Keterangan: '+ket);
					}
					
					break;
				default:
					alert('You have a strange Mouse!');
			}
		});
</script>