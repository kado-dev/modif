<?php
	include "../config/koneksi.php";
	$nofaktur = $_POST['id'];
	$query = mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$nofaktur'");
	$data = mysqli_fetch_assoc($query);
?>
<div class="modal fade" id="modallihatdistribusi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Edit Data Puskesmas</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=master_puskesmas_edit_proses" method="post" role="form">
					<table class="table">
						<tr>
							<td class="col-sm-3">No.Faktur</td>
							<td class="col-sm-9">
								<input type="text" name="kodepuskesmas" class="form-control" value="<?php echo $data['NoFaktur'];?>" readonly>
							</td>
						</tr>
					</table><hr/>
					<button type="submit" class="btnsimpan">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
