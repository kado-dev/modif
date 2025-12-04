<?php
	$idpasienrj = $_GET['id'];
	$datanursingcenter = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolinursingcenter` WHERE `NoPemeriksaan` = '$noregistrasi'"));
?>

<div class = "row">
	<div class="col-sm-12">
		<table class="table-judul" width="100%">
			<tr>
				<td class="col-sm-2">Anamnesa</td>
				<td class="col-sm-10"><textarea name="anamnesa" class="anamnesa form-control"><?php echo $datanursingcenter['Anamnesa'];?></textarea></td>
			</tr>
			<tr>
				<td>Anjuran</td>
				<td><input type="text" name ="anjuran" class="form-control" value="<?php echo $datanursingcenter['Anjuran'];?>"></td>
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
					<input type="text" name ="pemeriksaanpenunjanglab" class="form-control" value="<?php echo $datanursingcenter['PemeriksaanHasilLab']."".$pem_lab;?>">
				</td>
			</tr>
			<tr>
				<td>Pemeriksaan Penunjang</td>
				<td>
					<?php
						$arrprkpenunjang = explode(",",$datanursingcenter['PemeriksaanPenunjang']);
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
</div><br/>	
<div class = "row">
	<div class="col-sm-12">
		<table class="table">	
			<div style="margin-left: 8px"><h4><b>Pemeriksaan Fisik</b></h4></div><hr>
			<tr>
				<td class="col-sm-2">Kelompok Disabilitas</td>
				<td class="col-sm-10">
					<?php
						$str_dsb = "SELECT `KelompokDisabilitas` FROM `tbpasiendisabilitas` WHERE `NoRegistrasi`='$noregistrasi'";
						$query_dsb = mysqli_query($koneksi,$str_dsb);
						$data_dsb = mysqli_fetch_assoc($query_dsb);
					?>
					<div class="input-group">
						<select name="disabilitas" class="form-control">
							<option value="">--Pilih--</option>
							<option value="Fisik" <?php if($data_dsb['KelompokDisabilitas'] == 'Fisik'){echo "SELECTED";}?>>Fisik</option>
							<option value="Intelektual" <?php if($data_dsb['KelompokDisabilitas'] == 'Intelektual'){echo "SELECTED";}?>>Intelektual</option>
							<option value="Sensorik Penglihatan" <?php if($data_dsb['KelompokDisabilitas'] == 'Sensorik Penglihatan'){echo "SELECTED";}?>>Sensorik Penglihatan</option>
							<option value="Sensorik Pendengaran" <?php if($data_dsb['KelompokDisabilitas'] == 'Sensorik Pendengaran'){echo "SELECTED";}?>>Sensorik Pendengaran</option>
							<option value="Mental" <?php if($data_dsb['KelompokDisabilitas'] == 'Mental'){echo "SELECTED";}?>>Mental</option>
						</select>
						<span class="input-group-addon">Lap.Disabilitas</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>Kepala</td>
				<td><input type ="text" name ="kepala" class="form-control" value="<?php if($datanursingcenter['Kepala'] == ''){echo 'DBN';}else{echo $datanursingcenter['Kepala'];}?>"></td>
			</tr>
			<tr>
				<td>Mata</td>
				<td><input type ="text" name ="mata" class="form-control" value="<?php if($datanursingcenter['Mata'] == ''){echo 'DBN';}else{echo $datanursingcenter['Mata'];}?>"></td>
			</tr>
			<tr>
				<td>Hidung</td>
				<td><input type ="text" name ="hidung" class="form-control" value="<?php if($datanursingcenter['Mata'] == ''){echo 'DBN';}else{echo $datanursingcenter['Hidung'];}?>"></td>
			</tr>
			<tr>
				<td>Telinga</td>
				<td><input type ="text" name ="telinga" class="form-control" value="<?php if($datanursingcenter['Telinga'] == ''){echo 'DBN';}else{echo $datanursingcenter['Telinga'];}?>"></td>
			</tr>
			<tr>
				<td>Mulut</td>
				<td><input type ="text" name ="mulut" class="form-control" value="<?php if($datanursingcenter['Mulut'] == ''){echo 'DBN';}else{echo $datanursingcenter['Mulut'];}?>"></td>
			</tr>
			<tr>
				<td>Leher</td>
				<td><input type ="text" name ="leher" class="form-control" value="<?php if($datanursingcenter['Leher'] == ''){echo 'DBN';}else{echo $datanursingcenter['Leher'];}?>"></td>
			</tr>
			<tr>
				<td>Dada</td>
				<td><input type ="text" name ="dada" class="form-control" value="<?php if($datanursingcenter['Dada'] == ''){echo 'DBN';}else{echo $datanursingcenter['Dada'];}?>"></td>
			</tr>
			<tr>
				<td>Punggung</td>
				<td><input type ="text" name ="punggung" class="form-control" value="<?php if($datanursingcenter['Punggung'] == ''){echo 'DBN';}else{echo $datanursingcenter['Punggung'];}?>"></td>
			</tr>
			<tr>
				<td>Cor/Pulmu</td>
				<td><input type ="text" name ="cp" class="form-control" value="<?php if($datanursingcenter['CP'] == ''){echo 'DBN';}else{echo $datanursingcenter['CP'];}?>"></td>
			</tr>
			<tr>
				<td>Perut</td>
				<td><input type ="text" name ="perut" class="form-control" value="<?php if($datanursingcenter['Perut'] == ''){echo 'DBN';}else{echo $datanursingcenter['Perut'];}?>"></td>
			</tr>
			<tr>
				<td>Hepar/Lien</td>
				<td><input type ="text" name ="hl" class="form-control" value="<?php if($datanursingcenter['HL'] == ''){echo 'DBN';}else{echo $datanursingcenter['HL'];}?>"></td>
			</tr>
			<tr>
				<td>Kelamin</td>
				<td><input type ="text" name ="kelamin" class="form-control" value="<?php if($datanursingcenter['Kelamin'] == ''){echo 'DBN';}else{echo $datanursingcenter['Kelamin'];}?>"></td>
			</tr>
			<tr>
				<td>Ex.Atas</td>
				<td><input type ="text" name ="exatas" class="form-control" value="<?php if($datanursingcenter['ExAtas'] == ''){echo 'DBN';}else{echo $datanursingcenter['ExAtas'];}?>"></td>
			</tr>
			<tr>
				<td>Ex.Bawah</td>
				<td><input type ="text" name ="exbawah" class="form-control" value="<?php if($datanursingcenter['ExBawah'] == ''){echo 'DBN';}else{echo $datanursingcenter['ExBawah'];}?>"></td>
			</tr>
			<tr>
				<td>Lokalis</td>
				<td><input type ="text" name ="lokalis" class="form-control" value="<?php if($datanursingcenter['Lokalis'] == ''){echo 'DBN';}else{echo $datanursingcenter['Lokalis'];}?>"></td>
			</tr>
			<tr>
				<td>Effloresensi</td>
				<td><input type ="text" name ="effloresensi" class="form-control" value="<?php if($datanursingcenter['Effloresensi'] == ''){echo 'DBN';}else{echo $datanursingcenter['Effloresensi'];}?>"></td>
			</tr>
		</table>
	</div>
</div>