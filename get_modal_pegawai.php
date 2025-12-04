<?php
	session_start();
	include "config/koneksi.php";
	$id = $_POST['id'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$str = "SELECT * FROM `tbpegawai` WHERE `Nip` = '$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
	error_reporting(0);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditpegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">EDIT DATA PEGAWAI</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
			<?php
				if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || $_SESSION['id_user'] == $data['Nip']){ 
			?>
				<form class="form-horizontal" action="master_pegawai_edit_proses.php" method="post" enctype="multipart/form-data" role="form">
					<input type="hidden" name="fotolama" value="<?php echo $data['Foto']?>">
					<table class="table-judul" width="100%">
						<tr>
							<td class="col-sm-3">Nip</td>
							<td class="col-sm-9">
								<input type="text" name="nip" class="form-control" value="<?php echo $data['Nip'];?>">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">SIP (Jika Dokter Isikan)</td>
							<td class="col-sm-9">
								<input type="text" name="sip" class="form-control" value="<?php echo $data['Sip'];?>">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Nama Pegawai</td>
							<td class="col-sm-9">
								<input type="text" name="namapegawai" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['NamaPegawai'];?>" maxlength ="50" required>
								<input type="hidden" name="namapegawailama" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['NamaPegawai'];?>" maxlength ="50" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Password</td>
							<td class="col-sm-9">
								<input type="text" name="password" class="form-control" placeholder="Jika diisi password akan terupadate">
							</td>
						</tr>
						<?php
						if(in_array("ADMINISTRATOR", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
						?>
						<tr>
							<td class="col-sm-3">Status</td>
							<td class="col-sm-9">
								<select name="status" class="form-control">
									<option value="AKUNTAN" <?php if($data['Status'] == 'AKUNTAN'){echo "SELECTED";}?>>AKUNTAN</option>
									<option value="ANALIS" <?php if($data['Status'] == 'ANALIS'){echo "SELECTED";}?>>ANALIS</option>
									<option value="APOTEKER" <?php if($data['Status'] == 'APOTEKER'){echo "SELECTED";}?>>APOTEKER</option>
									<option value="ASISTEN APOTEKER" <?php if($data['Status'] == 'ASISTEN APOTEKER'){echo "SELECTED";}?>>ASISTEN APOTEKER</option>
									<option value="AHLI TELNOLOGI LABORATORIUM MEDIK" <?php if($data['Status'] == 'AHLI TELNOLOGI LABORATORIUM MEDIK'){echo "SELECTED";}?>>AHLI TELNOLOGI LABORATORIUM MEDIK</option>
									<option value="BIDAN" <?php if($data['Status'] == 'BIDAN'){echo "SELECTED";}?>>BIDAN</option>
									<option value="DOKTER" <?php if($data['Status'] == 'DOKTER'){echo "SELECTED";}?>>DOKTER</option>
									<option value="IT" <?php if($data['Status'] == 'IT'){echo "SELECTED";}?>>IT</option>
									<option value="KESLING" <?php if($data['Status'] == 'KESLING'){echo "SELECTED";}?>>KESLING</option>
									<option value="KESMAS" <?php if($data['Status'] == 'KESMAS'){echo "SELECTED";}?>>KESMAS</option>
									<option value="LOKET" <?php if($data['Status'] == 'LOKET'){echo "SELECTED";}?>>LOKET</option>
									<option value="PERAWAT" <?php if($data['Status'] == 'PERAWAT'){echo "SELECTED";}?>>PERAWAT</option>
									<option value="NUTRISIONIST" <?php if($data['Status'] == 'NUTRISIONIST'){echo "SELECTED";}?>>NUTRISIONIST</option>
									<option value="REKAM MEDIS" <?php if($data['Status'] == 'REKAM MEDIS'){echo "SELECTED";}?>>REKAM MEDIS</option>
									<option value="TU" <?php if($data['Status'] == 'TATA USAHA'){echo "SELECTED";}?>>TATA USAHA</option>
								</select>
							</td>
						</tr>
						<?php		
							}
						?>	
						<tr>
							<td class="col-sm-3">Otoritas</td>
							<td class="col-sm-9">
							<?php
								$otoritas = explode(',',$data['Otoritas']);
							?>
								<input type="checkbox" name="otoritas[]" value="ADMINISTRATOR" <?php if(in_array('ADMINISTRATOR',$otoritas)){echo 'checked';}?>> ADMINISTRATOR<br/>
								<input type="checkbox" name="otoritas[]" value="APOTEK"  <?php if(in_array('APOTEK',$otoritas)){echo 'checked';}?>> APOTEK<br/>
								<input type="checkbox" name="otoritas[]" value="DINAS KESEHATAN" <?php if(in_array('DINAS KESEHATAN',$otoritas)){echo 'checked';}?>> DINAS KESEHATAN<br/>
								<input type="checkbox" name="otoritas[]" value="KEPALA PUSKESMAS" <?php if(in_array('KEPALA PUSKESMAS',$otoritas)){echo 'checked';}?>> KEPALA PUSKESMAS<br/>
								<input type="checkbox" name="otoritas[]" value="LOKET"  <?php if(in_array('LOKET',$otoritas)){echo 'checked';}?>> PENDAFTARAN<br/>
								<input type="checkbox" name="otoritas[]" value="POLI ANAK" <?php if(in_array('POLI ANAK',$otoritas)){echo 'checked';}?>> RUANG ANAK<br/>
								<input type="checkbox" name="otoritas[]" value="POLI GIGI" <?php if(in_array('POLI GIGI',$otoritas)){echo 'checked';}?>> RUANG GIGI<br/>
								<input type="checkbox" name="otoritas[]" value="POLI GIZI" <?php if(in_array('POLI GIZI',$otoritas)){echo 'checked';}?>> RUANG GIZI<br/>
								<input type="checkbox" name="otoritas[]" value="POLI IMUNISASI" <?php if(in_array('POLI IMUNISASI',$otoritas)){echo 'checked';}?>> RUANG IMUNISASI<br/>
								<input type="checkbox" name="otoritas[]" value="POLI ISOLASI" <?php if(in_array('POLI ISOLASI',$otoritas)){echo 'checked';}?>> RUANG ISOLASI<br/>
								<input type="checkbox" name="otoritas[]" value="POLI KB" <?php if(in_array('POLI KB',$otoritas)){echo 'checked';}?>> RUANG KB<br/>
								<input type="checkbox" name="otoritas[]" value="POLI KIA" <?php if(in_array('POLI KIA',$otoritas)){echo 'checked';}?>> RUANG KIA<br/>
								<input type="checkbox" name="otoritas[]" value="POLI LABORATORIUM" <?php if(in_array('POLI LABORATORIUM',$otoritas)){echo 'checked';}?>> RUANG LABORATORIUM<br/>
								<input type="checkbox" name="otoritas[]" value="POLI LANSIA" <?php if(in_array('POLI LANSIA',$otoritas)){echo 'checked';}?>> RUANG LANSIA<br/>
								<input type="checkbox" name="otoritas[]" value="POLI MTBS" <?php if(in_array('POLI MTBS',$otoritas)){echo 'checked';}?>> RUANG MTBS<br/>
								<input type="checkbox" name="otoritas[]" value="POLI TB" <?php if(in_array('POLI TB',$otoritas)){echo 'checked';}?>> RUANG TB<br/>
								<input type="checkbox" name="otoritas[]" value="POLI UGD" <?php if(in_array('POLI UGD',$otoritas)){echo 'checked';}?>> RUANG UGD / TINDAKAN<br/>
								<input type="checkbox" name="otoritas[]" value="POLI UMUM" <?php if(in_array('POLI UMUM',$otoritas)){echo 'checked';}?>> RUANG UMUM<br/>
								<input type="checkbox" name="otoritas[]" value="TATA USAHA" <?php if(in_array('TATA USAHA',$otoritas)){echo 'checked';}?>> TATA USAHA<br/>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Alamat</td>
							<td class="col-sm-9">
								<input type="text" name="alamat" class="form-control" value="<?php echo $data['Alamat'];?>" maxlength ="200" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Telepon</td>
							<td class="col-sm-9">
								<input type="text" name="telepon" class="form-control" value="<?php echo $data['Telepon'];?>" maxlength ="15" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Foto</td>
							<td class="col-sm-9">
								<input type="file" name="image" class="form-control">
							</td>
						</tr>
					</table><br/>

					<table class="table-judul">
						<h4 class="judul">
							<i class="icon-note"></i>
							Tanda Tangan Elektronik
						</h4>
						<tr>
							<td class="col-sm-3">Pin</td>
							<td class="col-sm-9">
								<input type="text" name="ttepin" class="form-control" maxlength ="10" placeholder="Isikan kembali PIN TTE" required>
							</td>
						</tr>	
					</table><br/>

					<table class="table-judul">
						<h4 class="judul">
							<i class="icon-user"></i>
							Display Antrian, abaikan jika menggunakan sis.antrian lainnya
						</h4>
						<tr>
							<td class="col-sm-3">Loket</td>
							<td class="col-sm-9">
								<select name="loket" class="form-control loketcls">
									<option value="loket 1" <?php if($data['Loket'] == 'loket 1'){echo "SELECTED";}?>>loket 1</option>
									<option value="loket 2" <?php if($data['Loket'] == 'loket 2'){echo "SELECTED";}?>>loket 2</option>
									<option value="loket 3" <?php if($data['Loket'] == 'loket 3'){echo "SELECTED";}?>>loket 3</option>
									<option value="loket 4" <?php if($data['Loket'] == 'loket 4'){echo "SELECTED";}?>>loket 4</option>
									<option value="-" <?php if($data['Loket'] == '-'){echo "SELECTED";}?>>-</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Lantai</td>
							<td class="col-sm-9">
								<select name="lantai" class="form-control">
									<option value="1" <?php if($data['Lantai'] == '1'){echo "SELECTED";}?>>Lantai 1</option>
									<option value="2" <?php if($data['Lantai'] == '2'){echo "SELECTED";}?>>Lantai 2</option>
									<option value="3" <?php if($data['Lantai'] == '3'){echo "SELECTED";}?>>Lantai 3</option>
									<option value="4" <?php if($data['Lantai'] == '4'){echo "SELECTED";}?>>Lantai 4</option>
									<option value="-" <?php if($data['Lantai'] == '-'){echo "SELECTED";}?>>-</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Poli</td>
							<td class="col-sm-9">
								<?php
								$arrpoli = json_decode($data['Poli']);
									$sqldttbapelayanan = mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` where `KodePuskesmas` = '$kodepuskesmas'");
									while($dttbapelayanan = mysqli_fetch_assoc($sqldttbapelayanan)){
										if($data['Poli'] == 'null'){
											$checked = '';
										}else{
											$checked = (in_array($dttbapelayanan['KodePelayanan'] , $arrpoli)) ? "checked" : "";
										}
										
								?>
									<label><input type="checkbox" name="poli[]" value="<?php echo $dttbapelayanan['KodePelayanan'];?>" <?php echo $checked;?>><?php echo $dttbapelayanan['Pelayanan'];?> </label>
								<?php		
									}
								?>	
							</td>
						</tr>
						<?php
						$statuspustu = json_decode($data['StatusPustu']);
						if($data['StatusPustu'] != 'null'){
							$checked1 = (in_array('puskesmas',$statuspustu)) ? 'checked' : '';
							$checked2 = (in_array('pustu',$statuspustu)) ? 'checked' : '';
						}else{
							$checked1 = '';
							$checked2 = '';
						}
						?>
						<tr>
							<td class="col-sm-3">Sts.Antrian</td>
							<td class="col-sm-10">
								<input type="checkbox" name="statuspustu[]" value="puskesmas" <?php echo $checked1;?>> PUSKESMAS 
								<input type="checkbox" name="statuspustu[]" value="pustu" <?php echo $checked2;?>> PUSTU
							</td>
						</tr>
					</table><hr/>
					<input type="hidden" name="idpegawai" class="form-control" value="<?php echo $data['IdPegawai'];?>">
					<input type="hidden" name="puskesmas" class="form-control" value="<?php echo $_SESSION['kodepuskesmas'];?>">
					<button type="submit" class="btnsimpan">SIMPAN</button>
				</form>
			<?php
				}else{
					echo "Maaf, otoritas anda belum bisa merubah data...";
				}
			?>	
			</div>
		</div>
	</div>
</div>