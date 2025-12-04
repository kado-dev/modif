<?php
	include "master_menu.php";
?>
<?php
	$id = $_GET['id'];
	$query = mysqli_query($koneksi,"select * from `tbpuskesmas` where `IdPuskesmas` = '$id'");
	$data = mysqli_fetch_assoc($query);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modalpuskesmas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Entry Data Puskesmas</h4>
			</div>
			  
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=master_puskesmas_proses" method="post" role="form">
					<table class="table">
						<tr>
							<td class="col-sm-3">Kode</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="kodepuskesmas" class="form-control" maxlength ="3" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Id Puskesmas</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="idpuskesmas" class="form-control" maxlength ="15" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Puskesmas</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="namapuskesmas" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Alamat</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="alamat" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Kelurahan</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="kelurahan" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Kecamatan</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="kecamatan" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Kota</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="kota" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Provinsi</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="provinsi" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Telepon</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="telepon" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Kepala Puskesmas</td>
							<td>:</td>
							<td class="col-sm-9">
								<input type="text" name="kepalapuskesmas" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">
							<td></td>
							<td class="col-sm-10"><button type="submit" class="btn btn-success">Submit</button></td>
							</td>
						</tr>	
					</table>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!--akhir modal-->
				
