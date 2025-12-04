<?php
	session_start();
	include "config/koneksi.php";
	$id = $_POST['id'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$str = "SELECT * FROM `tbpelayanan_tempat_tidur` WHERE `IdBed` = '$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
	error_reporting(0);
?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">EDIT TEMPAT TIDUR</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=dashboard_ranap_edit_proses" method="post" enctype="multipart/form-data" role="form">
					<table class="table-judul" width="100%">
						<tr>
							<td class="col-sm-3">Ruangan</td>
							<td class="col-sm-9">
								<input type="text" name="ruangan" class="form-control" maxlength ="20" value="<?php echo $data['Ruangan'];?>" required>
							</td>
						</tr>
						<tr>
							<td>Perawatan</td>
							<td>
								<select name="perawatan" class="form-control">
									<option value="ANAK" value="AKUNTAN" <?php if($data['Perawatan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
									<option value="UMUM" value="AKUNTAN" <?php if($data['Perawatan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
									<option value="BEDAH" value="AKUNTAN" <?php if($data['Perawatan'] == 'BEDAH'){echo "SELECTED";}?>>BEDAH</option>
									<option value="JIWA" value="AKUNTAN" <?php if($data['Perawatan'] == 'JIWA'){echo "SELECTED";}?>>JIWA</option>
									<option value="HCU" value="AKUNTAN" <?php if($data['Perawatan'] == 'HCU'){echo "SELECTED";}?>>HCU</option>
									<option value="NICU" value="AKUNTAN" <?php if($data['Perawatan'] == 'NICU'){echo "SELECTED";}?>>NICU</option>
									<option value="ICU" value="AKUNTAN" <?php if($data['Perawatan'] == 'ICU'){echo "SELECTED";}?>>ICU</option>
									<option value="PICU" value="AKUNTAN" <?php if($data['Perawatan'] == 'PICU'){echo "SELECTED";}?>>PICU</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>
								<select name="kelas" class="form-control">
									<option value="VVIP" value="AKUNTAN" <?php if($data['Kelas'] == 'VVIP'){echo "SELECTED";}?>>VVIP</option>
									<option value="VIP" value="AKUNTAN" <?php if($data['Kelas'] == 'VIP'){echo "SELECTED";}?>>VIP</option>
									<option value="KELAS 1" value="AKUNTAN" <?php if($data['Kelas'] == 'KELAS 1'){echo "SELECTED";}?>>KELAS 1</option>
									<option value="KELAS 2" value="AKUNTAN" <?php if($data['Kelas'] == 'KELAS 2'){echo "SELECTED";}?>>KELAS 2</option>
									<option value="KELAS 3" value="AKUNTAN" <?php if($data['Kelas'] == 'KELAS 3'){echo "SELECTED";}?>>KELAS 3</option>
									<option value="ISOLASI" value="AKUNTAN" <?php if($data['Kelas'] == 'ISOLASI'){echo "SELECTED";}?>>ISOLASI</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Teredia</td>
							<td>
								<input type="text" name="tersedia" class="form-control" value="<?php echo $data['Tersedia'];?>" maxlength ="5" required>
							</td>
						</tr>
						<tr>
							<td>Terpakai</td>
							<td>
								<input type="text" name="terpakai" class="form-control" value="<?php echo $data['Terpakai'];?>" maxlength ="5" required>
							</td>
						</tr>
						<tr>
							<td>Belum Siap</td>
							<td>
								<input type="text" name="belumsiap" class="form-control" value="<?php echo $data['BelumSiap'];?>" maxlength ="5" required>
							</td>
						</tr>
						<tr>
							<td>Pasien Pria</td>
							<td>
								<input type="text" name="pasienpria" class="form-control" value="<?php echo $data['PasienPria'];?>" maxlength ="5" required>
							</td>
						</tr>
						<tr>
							<td>Pasien Wanita</td>
							<td>
								<input type="text" name="pasienwanita" class="form-control" value="<?php echo $data['PasienWanita'];?>" maxlength ="5" required>
							</td>
						</tr>
					</table><hr/>
					<input type="hidden" name="idbed" class="form-control" value="<?php echo $data['IdBed'];?>">
					<button type="submit" class="btnsimpan">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
</div>