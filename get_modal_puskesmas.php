<?php
	include "config/koneksi.php";
	$id = $_POST['id'];
	$query = mysqli_query($koneksi, "select * from `tbpuskesmas` where `KodePuskesmas` = '$id'");
	$data = mysqli_fetch_assoc($query);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditpuskesmas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Edit Data Puskesmas</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=master_puskesmas_edit_proses" method="post" role="form">
					<table class="table-judul" width="100%">
						<tr>
							<td class="col-sm-3">Kode Puskesmas</td>
							<td class="col-sm-9">
								<input type="text" name="kodepuskesmas" class="form-control" value="<?php echo $data['KodePuskesmas'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td >Puskesmas</td>
							<td>
								<input type="text" name="namapuskesmas" class="form-control" value="<?php echo $data['NamaPuskesmas'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Alamat</td>
							<td>
								<input type="text" name="alamat" class="form-control" value="<?php echo $data['Alamat'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Kelurahan</td>
							<td>
								<input type="text" name="kelurahan" class="form-control nama_kelurahan" value="<?php echo $data['Kelurahan'];?>" required>
								<input type="hidden" name="kodekelurahan" class="form-control kodekelurahan">
							</td>
						</tr>
						<tr>
							<td >Kecamatan</td>
							<td>
								<input type="text" name="kecamatan" class="form-control" value="<?php echo $data['Kecamatan'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Kota</td>
							<td>
								<input type="text" name="kota" class="form-control" value="<?php echo $data['Kota'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Provinsi</td>
							<td>
								<input type="text" name="provinsi" class="form-control" value="<?php echo $data['Profinsi'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Telepon</td>
							<td>
								<input type="text" name="telepon" class="form-control" value="<?php echo $data['Telepon'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Kepala Puskesmas</td>
							<td>
								<input type="text" name="kepalapuskesmas" class="form-control" value="<?php echo $data['KepalaPuskesmas'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Longitude</td>
							<td>
								<input type="text" name="long" class="form-control" value="<?php echo $data['Long'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Latitude</td>
							<td>
								<input type="text" name="lat" class="form-control" value="<?php echo $data['Lat'];?>" required>
							</td>
						</tr>
						<tr>
							<td >Image</td>
							<td>
								<input type="file" name="image" class="form-control" value="<?php echo $data['Img'];?>">
							</td>
						</tr>
					</table><hr/>
					<button type="submit" class="btnsimpan">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
</div>
