<?php
	session_start();
	include "config/koneksi.php";
	$id = $_POST['id'];
	$str = "SELECT * FROM `tbpelayanankesehatan` WHERE `KodePelayanan` = '$id'";
	//echo $str;
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
	//error_reporting(0);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditlocation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">EDIT DATA LOCATION</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="satusehat_location_proses.php" method="post" enctype="multipart/form-data" role="form">
					
					<table class="table-judul" width="100%">
						<tr>
							<td class="col-sm-3">Pelayanan</td>
							<td class="col-sm-9">
								<input type="text" name="pelayanan" class="form-control" value="<?php echo $data['Pelayanan'];?>">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Deskripsi</td>
							<td class="col-sm-9">
								<input type="text" name="description" class="form-control" value="<?php echo $data['description'];?>">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Phone</td>
							<td class="col-sm-9">
								<input type="text" name="phone" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Fax</td>
							<td class="col-sm-9">
								<input type="text" name="fax" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Email</td>
							<td class="col-sm-9">
								<input type="text" name="email" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Alamat</td>
							<td class="col-sm-9">
								<input type="text" name="alamat" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Kode Pos</td>
							<td class="col-sm-9">
								<input type="text" name="postalCode" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Negara</td>
							<td class="col-sm-9">
								<input type="text" name="country" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Provinsi</td>
							<td class="col-sm-9">
								<input type="text" name="province" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">City</td>
							<td class="col-sm-9">
								<input type="text" name="city" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Kecamatan</td>
							<td class="col-sm-9">
								<input type="text" name="district" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Kel/Desa</td>
							<td class="col-sm-9">
								<input type="text" name="village" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">RT</td>
							<td class="col-sm-9">
								<input type="text" name="rt" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">RW</td>
							<td class="col-sm-9">
								<input type="text" name="rw" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Longtitude</td>
							<td class="col-sm-9">
								<input type="text" name="longitude" class="form-control">
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Latitude</td>
							<td class="col-sm-9">
								<input type="text" name="latitude" class="form-control">
							</td>
						</tr>						
					</table><hr/>
					<input type="hidden" name="idpelayanan" class="form-control" value="<?php echo $data['KodePelayanan'];?>">
					<button type="submit" class="btnsimpanmodal btn btn-round btn-success btnsimpan">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
</div>