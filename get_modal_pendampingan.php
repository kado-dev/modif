<?php
	session_start();
	include "config/koneksi.php";
	$nofaktur = $_POST['nofaktur'];
	$str = "SELECT * FROM `tbadm_pendampingan` WHERE `NoFaktur`='$nofaktur'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
?>
	<form action="?page=adm_pendampingan_edit_proses" method="post" enctype="multipart/form-data">
		<div class="modal-body">
			<input type="hidden" name="nofaktur" value="<?php echo $data['NoFaktur'];?>">
			<div class="row">
				<?php
					$i = 0;
					$imgs = json_decode($data['Foto']);
					foreach($imgs as $img){
						$i = $i + 1;
				?>		
					<div class="col-sm-6">
						<img src='image/pendampingan/<?php echo $img;?>' class="img img-responsive" style='height:220px;margin:auto;margin-bottom: 5px'/>
						<input type="file" name="image<?php echo $i;?>" class="form-control">
						<input type="hidden" name="imglama<?php echo $i;?>" value="<?php echo $img;?>" class="form-control">
					</div>	
				<?php		
					}
				?>
			</div>	
			<hr/>
			<table class="table">
				<tr>
					<td class="col-sm-3">Tanggal</td>
					<td class="col-sm-9">
						<input type="date" name="tanggal" class="form-control" value="<?php echo $data['Tanggal'];?>">
					</td>
				</tr>
				<tr>
					<td>Bersedia</td>
					<td>
						<select name="bersedia" class="form-control"><!--belum bisa-->
							<option>--Pilih--</option>
							<option value="YA" <?php if($data['Bersedia'] == 'YA'){echo "SELECTED";}?>>YA</option>
							<option value="TIDAK" <?php if($data['Bersedia'] == 'TIDAK'){echo "SELECTED";}?>>TIDAK</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Sdm</td>
					<td><input type="text" name="sdm" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Sdm'];?>"></td>
				</tr>
				<tr>
					<td>Komputer</td>
					<td><input type="text" name="komputer" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Komputer'];?>"></td>
				</tr>
				<tr>
					<td>Printer</td>
					<td><input type="text" name="printer" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Printer'];?>"></td>
				</tr>
				<tr>
					<td>Internet</td>
					<td><input type="text" name="internet" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Internet'];?>"></td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td><input type="text" name="keterangan" style="text-transform: uppercase;" class="form-control" value="<?php echo $data['Keterangan'];?>"></td>
				</tr>
			</table>			
		</div>
		<div class="modal-footer">
			<div class="row">
				<div class="col-sm-6">
					<button type="submit" class="btnsimpan">Update</button>
				</div>
				<div class="col-sm-6">
					<button type="button" class="btndanger" data-dismiss="modal">Close</button>
				</div>
			</div>	
		</div>
	</form>