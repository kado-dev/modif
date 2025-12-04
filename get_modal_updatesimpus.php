<?php
	include "config/koneksi.php";
	session_start();
	$id = $_POST['id'];
	$str = "SELECT * FROM `tbupdatesimpus` WHERE `IdUpdate` = '$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
	error_reporting(0);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditsimpus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">EDIT DATA</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=adm_update_simpus_edit_proses" method="post" enctype="multipart/form-data" role="form">
					<table class="table-judul" width="100%">
						<tr>
							<td class="col-sm-3">Tanggal Update</td>
							<td class="col-sm-9">
								<input type="date" name="tanggalupdate" class="form-control datepicker" value="<?php echo date('Y-m-d', strtotime($data['TanggalUpdate']));?>" autofocus>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Judul</td>
							<td class="col-sm-9">
								<input type="text" name="judul" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Judul'];?>" maxlength ="50" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Deskripsi</td>
							<td class="col-sm-9">
								<textarea name="deskripsi" class="form-control" style="text-transform: uppercase; height: 150px !important;" maxlength="300" required><?php echo $data['Deskripsi'];?></textarea>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Kategori</td>
							<td class="col-sm-10">
								<select name="kategori" class="form-control" required>
									<option value="">--Pilih--</option>
									<option value="ANTRIAN" <?php if($data['Kategori'] == 'ANTRIAN'){echo "SELECTED";}?>>ANTRIAN</option>
									<option value="ANJUNGAN DAFTAR MANDIRI" <?php if($data['Kategori'] == 'ANJUNGAN DAFTAR MANDIRI'){echo "SELECTED";}?>>ANJUNGAN DAFTAR MANDIRI</option>
									<option value="DAFTAR ONLINE" <?php if($data['Kategori'] == 'DAFTAR ONLINE'){echo "SELECTED";}?>>DAFTAR ONLINE</option>
									<option value="MASTER DATA" <?php if($data['Kategori'] == 'MASTER DATA'){echo "SELECTED";}?>>MASTER DATA</option>
									<option value="PENDAFTARAN" <?php if($data['Kategori'] == 'PENDAFTARAN'){echo "SELECTED";}?>>PENDAFTARAN</option>
									<option value="PEMERIKSAAN" <?php if($data['Kategori'] == 'PEMERIKSAAN'){echo "SELECTED";}?>>PEMERIKSAAN</option>
									<option value="FARMASI" <?php if($data['Kategori'] == 'FARMASI'){echo "SELECTED";}?>>FARMASI</option>
									<option value="PELAPORAN" <?php if($data['Kategori'] == 'PELAPORAN'){echo "SELECTED";}?>>PELAPORAN</option>
									<option value="WEB SERVICE" <?php if($data['Kategori'] == 'WEB SERVICE'){echo "SELECTED";}?>>WEB SERVICE</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Versi</td>
							<td class="col-sm-10">
								<select name="versi" class="form-control" required>
									<option value="">--Pilih--</option>
									<option value="2.1" <?php if($data['Versi'] == '2.1'){echo "SELECTED";}?>>2.1</option>
									<option value="2.2" <?php if($data['Versi'] == '2.2'){echo "SELECTED";}?>>2.2</option>
									<option value="2.3" <?php if($data['Versi'] == '2.3'){echo "SELECTED";}?>>2.3</option>
									<option value="2.4" <?php if($data['Versi'] == '2.4'){echo "SELECTED";}?>>2.4</option>
									<option value="2.5" <?php if($data['Versi'] == '2.5'){echo "SELECTED";}?>>2.5</option>
								</select>
							</td>
						</tr>
					</table><hr/>
					<input type="hidden" name="idupdate" class="form-control" value="<?php echo $data['IdUpdate'];?>">
					<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
</div>