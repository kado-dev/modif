<?php
	include "config/koneksi.php";
	$id = $_POST['id'];
	$query = mysqli_query($koneksi,"select * from `tbpuskesmasdetail` where `KodePuskesmas` = '$id'");
	$data = mysqli_fetch_assoc($query);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditpuskesmas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Edit Password PCare</h4>
			</div>

			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=master_pcare_edit_proses" method="post" role="form">
					<table class="table">
						<tr>
							<td class="col-sm-3">Kode Puskesmas</td>
							<td class="col-sm-9">
								<input type="text" name="kodepuskesmas" class="form-control" value="<?php echo $data['KodePuskesmas'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Puskesmas</td>
							<td class="col-sm-9">
								<input type="text" name="namapuskesmas" class="form-control" value="<?php echo $data['NamaPPK'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Username</td>
							<td class="col-sm-9">
								<input type="text" name="username" class="form-control" value="<?php echo $data['Username'];?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Password</td>
							<td class="col-sm-9">
								<input type="text" name="password" class="form-control nama_kelurahan" value="<?php echo $data['Password'];?>" required>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2">
							<td class="col-sm-10"><button type="submit" class="btn btn-success">Submit</button></td>
							</td>
						</tr>	
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
