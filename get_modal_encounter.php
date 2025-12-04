<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_satusehat.php";
	$id = $_POST['id'];
	$idencounter = $_POST['idencounter'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$str = "SELECT * FROM `tbpegawai` WHERE `Nip` = '$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
	$stsehat_access_token = $_SESSION['stsehat_access_token'];
	$getencounter = get_satusehat($stsehat_access_token,"Encounter/".$idencounter);

	$dtencounter = json_decode($getencounter,true);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modalencounter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">GET ENCOUNTER</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<!--  -->
					<table class="table-judul" width="100%">
						<tr>
							<td class="col-sm-3">Id Encounter</td>
							<td class="col-sm-9">
								<?php echo $idencounter;?>
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Patient</td>
							<td class="col-sm-9">
								<?php echo $dtencounter['subject']['display'];?>
								
							</td>
						</tr>
						<tr>
							<td class="col-sm-3">Practitioner</td>
							<td class="col-sm-9">
								<?php echo $dtencounter['participant'][0]['individual']['display'];?>
							</td>
						</tr>
					</table>
					
			</div>
		</div>
	</div>
</div>