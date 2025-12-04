<?php
	session_start();
	include "config/koneksi.php";
	$id = $_POST['no'];
	$noreg = $_POST['noreg'];
	$pel = $_POST['pel'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	
	// tbpasien
	// $tbpasien = "tbpasien_".substr($id,12,4);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	$str = "SELECT * FROM `$tbpasien` WHERE `NoCM`='$id'";
	$query = mysqli_query($koneksi,$str);
	$dtpasien = mysqli_fetch_assoc($query);
	
	// tbkk 
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex`='$dtpasien[NoIndex]'"));
?>

<div class="modal fade noprint" id="ModalPasien" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header noprint">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><b>EDIT DATA PASIEN</b></h4>
			</div>
			<div class="modal-body noprint" style="padding: 30px;">
				<div class="row noprint">						
					<div class="col-sm-12">
						<form class="form-horizontal" action="pasien_edit_proses.php" method="post" enctype="multipart/form-data" role="form">
						<table class="table-judul" width="100%">
							<tr>
								<td class="col-sm-2">No.Index</td>
								<td class="col-sm-10">
									<input type="text" name="noindex" class="form-control" value="<?php echo $dtpasien['NoIndex'];?>" readonly>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">NIK</td>
								<td class="col-sm-10">
									<input type="text" name="nik" class="form-control" value="<?php echo $dtpasien['Nik'];?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">No.BPJS</td>
								<td class="col-sm-10">
									<input type="number" name="nobpjs" class="form-control" value="<?php echo $dtpasien['NoAsuransi'];?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "15">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Nama Pasien</td>
								<td class="col-sm-10">
									<input type="text" name="namapasien" class="form-control" value="<?php echo $dtpasien['NamaPasien'];?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Tgl.Lahir</td>
								<td class="col-sm-10">
									<div class="input-group">
										<span class="input-group-addon tesdate">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" name="tanggallahir" class="form-control datepicker" value="<?php echo date('d-m-Y',strtotime($dtpasien['TanggalLahir']));?>">
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Jenis Kelamin</td>
								<td class="col-sm-10">
									<select name="jeniskelamin" class="form-control">
										<option value="L" <?php if($dtpasien['JenisKelamin'] == 'L'){echo "SELECTED";}?>>LAKI-LAKI</option>
										<option value="P" <?php if($dtpasien['JenisKelamin'] == 'P'){echo "SELECTED";}?>>PEREMPUAN</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Pekerjaan</td>
								<td class="col-sm-10">
									<select name="pekerjaan" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="BELUM BEKERJA" <?php if($dtpasien['Pekerjaan'] == 'BELUM BEKERJA'){echo "SELECTED";}?>>BELUM BEKERJA</option>
										<option value="BURUH" <?php if($dtpasien['Pekerjaan'] == 'BURUH'){echo "SELECTED";}?>>BURUH</option>
										<option value="GURU" <?php if($dtpasien['Pekerjaan'] == 'GURU'){echo "SELECTED";}?>>GURU</option>
										<option value="HONORER" <?php if($dtpasien['Pekerjaan'] == 'HONORER'){echo "SELECTED";}?>>HONORER</option>
										<option value="IRT" <?php if($dtpasien['Pekerjaan'] == 'IRT'){echo "SELECTED";}?>>IRT</option>
										<option value="MAHASISWA" <?php if($dtpasien['Pekerjaan'] == 'MAHASISWA'){echo "SELECTED";}?>>MAHASISWA</option>
										<option value="NELAYAN" <?php if($dtpasien['Pekerjaan'] == 'NELAYAN'){echo "SELECTED";}?>>NELAYAN</option>
										<option value="PEGAWAI SWASTA" <?php if($dtpasien['Pekerjaan'] == 'PEGAWAI SWASTA'){echo "SELECTED";}?>>PEGAWAI SWASTA</option>
										<option value="PELAJAR" <?php if($dtpasien['Pekerjaan'] == 'PELAJAR'){echo "SELECTED";}?>>PELAJAR</option>
										<option value="PENSIUN" <?php if($dtpasien['Pekerjaan'] == 'PENSIUN'){echo "SELECTED";}?>>PENSIUN</option>
										<option value="PETANI" <?php if($dtpasien['Pekerjaan'] == 'PETANI'){echo "SELECTED";}?>>PETANI</option>
										<option value="PNS" <?php if($dtpasien['Pekerjaan'] == 'PNS'){echo "SELECTED";}?>>PNS</option>
										<option value="POLRI" <?php if($dtpasien['Pekerjaan'] == 'POLRI'){echo "SELECTED";}?>>POLRI</option>
										<option value="TNI" <?php if($dtpasien['Pekerjaan'] == 'TNI'){echo "SELECTED";}?>>TNI</option>
										<option value="TKI" <?php if($dtpasien['Pekerjaan'] == 'TKI'){echo "SELECTED";}?>>TKI</option>
										<option value="WIRASWASTA" <?php if($dtpasien['Pekerjaan'] == 'WIRASWASTA'){echo "SELECTED";}?>>WIRASWASTA</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Alamat</td>
								<td class="col-sm-10">
									<input type="text" name="alamat" class="form-control" value="<?php echo strtoupper($dtkk['Alamat']);?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kelurahan</td>
								<td class="col-sm-10">
									<input type="text" name="kelurahan" class="form-control kelurahan" value="<?php echo strtoupper($dtkk['Kelurahan']);?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Kecamatan</td>
								<td class="col-sm-10">
									<input type="text" name="kecamatan" class="form-control" value="<?php echo strtoupper($dtkk['Kecamatan']);?>">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">No.Telp</td>
								<td class="col-sm-10">
									<input type="number" name="telepon" class="form-control" value="<?php echo $dtkk['Telepon'];?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "15">
								</td>
							</tr>
							<tr>
								<input type="hidden" name="nocm" class="form-control" value="<?php echo $dtpasien['NoCM'];?>">
								<input type="hidden" name="noreg" class="form-control" value="<?php echo $noreg;?>">
								<input type="hidden" name="pel" class="form-control" value="<?php echo $pel;?>">
							</tr>
						</table><hr/>
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).on("submit","form", function(event) {
	event.preventDefault();
	var urlaction = $(this).attr('action');
	var datak = $(this).serializeArray();
	$(this).html('Mengirim...');
	$.post(urlaction, datak).done(function(data) {
		// alert(data);
		if(data == 'sukses'){
			location.reload(true);
		}
	});
});
</script>
