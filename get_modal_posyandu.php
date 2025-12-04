<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$id = $_POST['id'];
	$str = "SELECT * FROM `ref_posyandu` WHERE `IdPosyandu` = '$id'";
	$query = mysqli_query($koneksi, $str);
	$data = mysqli_fetch_assoc($query);
?>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Edit Data Posyandu</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="master_posyandu_proses.php" method="post" enctype="multipart/form-data" role="form">
					<input type="hidden" name="stssimpan" value="edit">
					<table class="table-konten" width="100%">
						<tr>
							<td class="col-sm-3">Nama Posyandu</td>
							<td class="col-sm-9">
								<input type="text" name="namaposyandu" class="form-control" value="<?php echo $data['NamaPosyandu'];?>">
							</td>
						</tr>
						<tr>
							<td>Alamat Posyandu</td>
							<td>
								<input type="text" name="alamatposyandu" class="form-control" value="<?php echo $data['AlamatPosyandu'];?>">
							</td>
						</tr>
					</table><hr/>
					<input type="hidden" name="idposyandu" class="form-control" value="<?php echo $data['IdPosyandu'];?>">
					<button type="submit" class="btnsimpan">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>