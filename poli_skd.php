<?php
	$idpasienrj = $_GET['id'];
	$asuransi = $_GET['cb'];
	$datapemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpoliskd` WHERE `IdPasienrj` = '$idpasienrj'"));	

?>

<input type="hidden" value="-">
<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-3">Tujuan Untuk</td>
				<td class="col-sm-9">
					<select name="tujuankir" class="form-control inputan">
						<option value="1" <?php if($datapemeriksaan['TujuanKir'] == '1'){echo "SELECTED";}?>>Perpanjang Kontrak Kerja</option>
						<option value="2" <?php if($datapemeriksaan['TujuanKir'] == '2'){echo "SELECTED";}?>>Melamar Pekerjaan</option>
						<option value="3" <?php if($datapemeriksaan['TujuanKir'] == '3'){echo "SELECTED";}?>>Mengikuti Tes TNI/POLRI</option>
						<option value="4" <?php if($datapemeriksaan['TujuanKir'] == '4'){echo "SELECTED";}?>>Membuat/Perpanjang SIM</option>
						<option value="5" <?php if($datapemeriksaan['TujuanKir'] == '5'){echo "SELECTED";}?>>Keterangan Catin</option>
						<option value="6" <?php if($datapemeriksaan['TujuanKir'] == '6'){echo "SELECTED";}?>>Melanjutkan Pendidikan</option>
						<option value="7" <?php if($datapemeriksaan['TujuanKir'] == '7'){echo "SELECTED";}?>>Mengikuti Lomba</option>
						<option value="8" <?php if($datapemeriksaan['TujuanKir'] == '8'){echo "SELECTED";}?>>Surat Tanda Registrasi</option>
						<option value="9" <?php if($datapemeriksaan['TujuanKir'] == '9'){echo "SELECTED";}?>>Surat Ijin Usaha</option>
						<option value="10" <?php if($datapemeriksaan['TujuanKir'] == '10'){echo "SELECTED";}?>>Lainnya</option>
					<select>
				</td>
			</tr>
			<tr>
				<td>Sebutkan, jika lainnya</td>
				<td><input type="text" name ="tujuankirlainnya" class="form-control inputan" value="<?php echo $datapemeriksaan['TujuanKirLainnya'];?>" placeholder="Maks. 20 Digit"></td>
			</tr>
			<tr>
				<td>Pemerikasan Lab</td>
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
					<input type="text" name ="pemeriksaanlab_skd" class="form-control inputan" value="<?php echo $datapemeriksaan['PemeriksaanLab']."".$pem_lab;?>" placeholder="Maks. 20 Digit">
				</td>
			</tr>
			<tr>
				<td>Pemeriksaan Lain</td>
				<td>
					<?php
					$prklain = explode(",",$datapemeriksaan['PemeriksaanLainnya']);
					?>
					<label><input type="checkbox" name="pemeriksaanlain_skd[]" value="Tidak Buta Warna" <?php if(in_array("Tidak Buta Warna", $prklain)){echo "CHECKED";}?>> Tidak Buta Warna</label><br/>
					<label><input type="checkbox" name="pemeriksaanlain_skd[]" value="Buta Warna Parsial" <?php if(in_array("Buta Warna Parsial", $prklain)){echo "CHECKED";}?>> Buta Warna Parsial</label><br/>
					<label><input type="checkbox" name="pemeriksaanlain_skd[]" value="Varisses" <?php if(in_array("Varisses", $prklain)){echo "CHECKED";}?>> Varisses</label><br/>
					<label><input type="checkbox" name="pemeriksaanlain_skd[]" value="Varicocel" <?php if(in_array("Varicocel", $prklain)){echo "CHECKED";}?>> Varicocel</label><br/>
					<label><input type="checkbox" name="pemeriksaanlain_skd[]" value="Hernia" <?php if(in_array("Hernia", $prklain)){echo "CHECKED";}?>> Hernia</label><br/>
					<label><input type="checkbox" name="pemeriksaanlain_skd[]" value="Hemoroid" <?php if(in_array("Hemoroid", $prklain)){echo "CHECKED";}?>> Hemoroid</label><br/>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class = "row mt-4">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">Organ Utama</p>
				<tr>
					<td class="col-sm-3">Jantung</td>
					<td class="col-sm-9">
						<input type ="text" name ="jantung_skd" class="resprate form-control inputan" maxlength="10" value="<?php if($datapemeriksaan['Jantung'] != null){echo $datapemeriksaan['Jantung'];}else{echo "DBN";}?>">
					</td>
				</tr>
				<tr>
					<td>Lympa</td>
					<td>
						<input type ="text" name ="lympa_skd" class="form-control inputan" maxlength="20" value="<?php if($datapemeriksaan['Lympa'] != null){echo $datapemeriksaan['Lympa'];}else{echo "DBN";}?>" placeholder="Maks. 20 Digit">
					</td>
				</tr>
				<tr>
					<td>Hati</td>
					<td>
						<input type ="text" name ="hati_skd" class="form-control inputan" maxlength="20" value="<?php if($datapemeriksaan['Hati'] != null){echo $datapemeriksaan['Hati'];}else{echo "DBN";}?>" placeholder="Maks. 20 Digit">
					</td>
				</tr>
				<tr>
					<td>Paru</td>
					<td>
						<input type ="text" name ="paru_skd" class="form-control inputan" maxlength="20" value="<?php if($datapemeriksaan['Paru'] != null){echo $datapemeriksaan['Paru'];}else{echo "DBN";}?>" placeholder="Maks. 20 Digit">
					</td>
				</tr>
				<tr>
					<td>Saraf</td>
					<td>
						<input type ="text" name ="saraf_skd" class="form-control inputan" maxlength="20" value="<?php if($datapemeriksaan['Saraf'] != null){echo $datapemeriksaan['Saraf'];}else{echo "DBN";}?>" placeholder="Maks. 20 Digit">
					</td>
				</tr>
				<tr>
					<td>Kejiwaan</td>
					<td>
						<input type ="text" name ="kejiwaan_skd" class="form-control inputan" maxlength="20" value="<?php if($datapemeriksaan['Kejiwaan'] != null){echo $datapemeriksaan['Kejiwaan'];}else{echo "DBN";}?>" placeholder="Maks. 20 Digit">
					</td>
				</tr>
				<tr>
					<td>Visus Mata (OD)</td>
					<td>
						<input type ="text" name ="visusmata_od_skd" class="form-control inputan" maxlength="20" value="<?php if($datapemeriksaan['VisusMataOD'] != null){echo $datapemeriksaan['VisusMataOD'];}else{echo "6/6";}?>" placeholder="Maks. 20 Digit">
					</td>
				</tr>
				<tr>
					<td>Visus Mata (OS)</td>
					<td>
						<input type ="text" name ="visusmata_os_skd" class="form-control inputan" maxlength="20" value="<?php if($datapemeriksaan['VisusMataOS'] != null){echo $datapemeriksaan['VisusMataOD'];}else{echo "6/6";}?>" placeholder="Maks. 20 Digit">
					</td>
				</tr>
			</table>
		</div>
	</div>
</div><br/>
<div class="row">
	<div class="col-sm-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<p style="font-size: 20px; font-weight: bold;" class="judul">Status Pemeriksaan</p>
				<tr>
					<td class="col-sm-3">Pasien dinyatakan</td>
					<td class="col-sm-9">
						<select name="statuskesehatan" class="form-control inputan">
							<option value="Sehat" <?php if($datapemeriksaan['StatusKesehatan'] == 'Sehat'){echo "SELECTED";}?>>Sehat</option>
							<option value="Sehat Terkontrol" <?php if($datapemeriksaan['StatusKesehatan'] == 'Sehat Terkontrol'){echo "SELECTED";}?>>Sehat Terkontrol</option>
							<option value="Sakit" <?php if($datapemeriksaan['StatusKesehatan'] == 'Sakit'){echo "SELECTED";}?>>Sakit</option>
						<select>
					</td>
				</tr>
				<tr>
					<td>Nomor Surat</td>
					<td>
						<input type ="text" name ="nomorsurat_skd" class="form-control inputan" maxlength="30" value="<?php echo $datapemeriksaan['NoSurat'];?>" placeholder="Maks. 30 Digit">
					</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td>
						<textarea name="keterangan_skd" class="form-control inputan" maxlength="100" placeholder="Maks. 100 Digit"><?php echo $datapemeriksaan['KeteranganTambahan'];?></textarea>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>