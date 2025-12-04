<?php
	include "config/koneksi.php";
	$id = $_POST['id'];
	$query = mysqli_query($koneksi, "SELECT * FROM `tbtindakan` where `IdTindakan` = '$id'");
	$data = mysqli_fetch_assoc($query);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaledittdk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Edit Data Tindakan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=master_tindakan_proses&stssimpan=edit" method="post" enctype="multipart/form-data" role="form">
					<table class="table-judul">
						<tr>
							<td width="20%">Kelompok Tindakan</td>
							<td width="80%">
								<input type="text" name="kelompoktindakan" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['KelompokTindakan'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td>Nama Tindakan*</td>
							<td>
								<input type="text" name="namatindakan" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Tindakan'];?>" maxlength ="50" required>
							</td>
						</tr>
						<tr>
							<td>Tarif*</td>
							<td>
								<input type="text" name="tarif" class="form-control" value="<?php echo $data['Tarif'];?>" maxlength ="50" required>
							</td>
						</tr>						
					</table><hr/>
					<input type="hidden" name="kodetindakan" style="text-transform: uppercase;" class="form-control" value="<?php echo $id;?>">
					<button type="submit" class="btnsimpan">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>