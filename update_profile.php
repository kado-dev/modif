<?php
	$idpegawai = $_SESSION['idpegawai'];
	$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpegawai` WHERE `IdPegawai` ='$idpegawai'"));
	//echo  $_SESSION['foto_petugas'];
?>

<style>
	.imgcenter{
		display: block;
		margin-top: 15px;
		margin-left: auto;
		margin-right: auto;
		width: 50%;
	}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>DATA USER</b></h3>
			<div class="formbg">
				<form class="form-horizontal" action="update_profile_proses.php" method="post" enctype="multipart/form-data" role="form">
					<input type="hidden" name="fotolama" value="<?php echo $data['Foto'];?>">
					<div class="row">
						<div class="col-xl-4">
							<span class="profile-picture imgcenter">
								<?php
									$gambar = $_SESSION['foto_petugas'];
									if(!file_exists("image/pegawai/".$gambar)){
								?>		
									<img id="avatar" class="editable img-responsive editable-click editable-empty" src="assets/images/avatars/avatar6.png">
								<?php }else{ ?>
									<img id="avatar" class="editable img-responsive editable-click editable-empty" src="image/pegawai/<?php echo $_SESSION['foto_petugas'];?>" alt="Photo" width="175px;"/>
								<?php } ?>	
							</span>
							<span class="imgcenter">
								<input type="file" name="image" class="form-control">
							</span>	
						</div>
						<div class="col-xl-8">					
							<table class="table-judul">
								<tr>
									<td class="col-sm-3">Nip/Nrp</td>
									<td class="col-sm-9">
										<input type="text" name="nip" class="form-control" value="<?php echo $data['Nip'];?>" maxlength ="20">
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">SIP (Jika Dokter Isikan)</td>
									<td class="col-sm-9">
										<input type="text" name="sip" class="form-control" value="<?php echo $data['Sip'];?>" maxlength ="50">
									</td>
								</tr>
								<tr>
									<td>Nama Pegawai</td>
									<td>
										<input type="text" name="namapegawai" style="text-transform: uppercase;" value="<?php echo $data['NamaPegawai'];?>" class="form-control" maxlength ="50" required>
										<input type="hidden" name="namapegawailama" style="text-transform: uppercase;" value="<?php echo $data['NamaPegawai'];?>" class="form-control" maxlength ="50" required>
									</td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td>
										<input type="text" name="alamat" class="form-control" value="<?php echo $data['Alamat'];?>" maxlength ="200" required>
									</td>
								</tr>
								<tr>
									<td>Telepon</td>
									<td>
										<input type="text" name="telepon" class="form-control" value="<?php echo $data['Telepon'];?>" maxlength ="12" required>
									</td>
								</tr>
								<tr>
									<td>Password</td>
									<td>
										<input type="text" name="password" class="form-control" maxlength ="20" placeholder="Jika diisi password berubah">
									</td>
								</tr>
								<tr>
									<td>Lantai</td>
									<td>
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
									<td>Poli</td>
									<td>
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
								
							</table>
						</div>
					</div><hr/>
					<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>