<?php
	$kodepkm = $_SESSION['kodepuskesmas'];
	$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepkm'"));
?>

<style>
	.imgcenter{
		display: block; 
		margin-top: 15px; 
		margin-left: auto; 
		margin-right: auto;
		width: 65%;
	}
</style>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PUSKESMAS</b></h3>
			<div class = "formbg">
				<form class="form-horizontal" action="update_profile_puskesmas_proses.php" method="post" enctype="multipart/form-data" role="form">
					<input type="hidden" name="fotolama" value="<?php echo $data['Img'];?>">
					<div class="row">
						<div class="col-sm-4">
							<div>
								<span class="profile-picture imgcenter">
									<?php
										$gambar = $_SESSION['foto_puskesmas'];
										if(!file_exists("image/puskesmas/".$gambar)){
									?>		
										<img id="avatar" class="editable img-responsive editable-click editable-empty" src="assets/images/avatars/avatar6.png">
									<?php }else{ ?>
										<img id="avatar" class="editable img-responsive editable-click editable-empty" src="image/puskesmas/<?php echo $_SESSION['foto_puskesmas'];?>" alt="Photo" />
									<?php } ?>	
								</span>
								<span class="imgcenter">
									<input type="file" name="image" class="form-control" value="<?php echo $data['Img'];?>">
								</span>	
							</div>
						</div>
						<div class="col-sm-8">					
							<table class="table-judul">
								<tr>
									<td class="col-sm-3">Puskesmas</td>
									<td class="col-sm-9">
										<input type="text" name="namapuskesmas" class="form-control" value="<?php echo $data['NamaPuskesmas'];?>" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Alamat</td>
									<td class="col-sm-9">
										<input type="text" name="alamat" class="form-control" value="<?php echo $data['Alamat'];?>" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Kelurahan</td>
									<td class="col-sm-9">
										<div class="input-group">
											<input type="text" name="kelurahan" class="form-control nama_kelurahan" value="<?php echo $data['Kelurahan'];?>" required>
											<div class="input-group-append">
												<span class="input-group-text">Auto</span>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Kecamatan</td>
									<td class="col-sm-9">
										<div class="input-group">
											<input type="text" name="kecamatan" class="form-control nama_kecamatan" value="<?php echo $data['Kecamatan'];?>" required>
											<div class="input-group-append">
												<span class="input-group-text">Auto</span>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Telpon</td>
									<td class="col-sm-9">
										<input type="text" name="telepon" class="form-control" value="<?php echo $data['Telepon'];?>" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Kepala Puskesmas</td>
									<td class="col-sm-9">
										<input type="text" name="kepalapuskesmas" class="form-control" value="<?php echo $data['KepalaPuskesmas'];?>" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Apoteker</td>
									<td class="col-sm-9">
										<input type="text" name="apoteker" class="form-control" value="<?php echo $data['Apoteker'];?>" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">SIPA</td>
									<td class="col-sm-9">
										<input type="text" name="sipa" class="form-control" value="<?php echo $data['Sipa'];?>" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Longitude</td>
									<td class="col-sm-9">
										<input type="text" name="long" class="form-control" value="<?php echo $data['Long'];?>" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-3">Latitude</td>
									<td class="col-sm-9">
										<input type="text" name="lat" class="form-control" value="<?php echo $data['Lat'];?>" required>
									</td>
								</tr>
							</table>
							<input type="hidden" name="kodepuskesmas" class="form-control" value="<?php echo $data['KodePuskesmas'];?>" readonly>
							<input type="hidden" name="kota" class="form-control" value="<?php echo $data['Kota'];?>" required>
							<input type="hidden" name="provinsi" class="form-control" value="<?php echo $data['Profinsi'];?>" required>						
							<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button><br/><br/>
						</div>
					</div>	
				</form>
				
				<h3 class="judul"><b>WILAYAH KERJA</b></h3>
				<!--data-->
				<div class = "row">
					<div class="col-sm-12 table-responsive">
						<table class="table-judul">
							<thead>
								<tr>
									<th width="3%">No.</th>
									<th width="5%">Kode</th>
									<th width="92%">Kelurahan</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$str = "select * from `tbkelurahan` where `KodePuskesmas` = '$kodepuskesmas'";
								$str2 = $str." order by Kelurahan";
								
								$query = mysqli_query($koneksi,$str2);
								while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								?>
									<tr>
										<td align="center"><?php echo $no;?></td>
										<td align="center" class="nip"><?php echo $data['Kode'];?></td>
										<td align="left" class="nip"><?php echo $data['Kelurahan'];?></td>								
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script>
$(document).ready(function() {
	$('.nama_kelurahan').autocomplete({
		serviceUrl: 'get_kelurahan.php',
	});	
	$('.nama_kecamatan').autocomplete({
		serviceUrl: 'get_kecamatan.php',
	});	
});
</script>