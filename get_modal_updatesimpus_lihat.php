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
<div class="modal fade" id="modallihatupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">UPDATE SIMPUS</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<table class="table-judul" width="100%">
					<tr>
						<td class="col-sm-3">Tanggal Update</td>
						<td class="col-sm-9">
							<input type="text" name="tanggalupdate" class="form-control datepicker" value="<?php echo date("d-m-Y");?>" readonly>
						</td>
					</tr>
					<tr>
						<td>Judul</td>
						<td>
							<input type="text" name="judul" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Judul'];?>" readonly>
						</td>
					</tr>
					<tr>
						<td>Deskripsi</td>
						<td>
							<textarea name="deskripsi" class="form-control" style="text-transform: uppercase; height: 150px !important;" maxlength="150" readonly><?php echo $data['Deskripsi'];?></textarea>
						</td>
					</tr>
					<tr>
						<td>Kategori</td>
						<td>
							<input type="text" name="kategori" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Kategori'];?>" readonly>
						</td>
					</tr>
					<tr>
						<td>Versi</td>
						<td>
							<input type="text" name="versi" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Versi'];?>" readonly>
						</td>
					</tr>
				</table><hr/>
			</div>
		</div>
	</div>
</div>