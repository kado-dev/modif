<?php
	include "config/koneksi.php";
	session_start();
	$idkonsul = $_POST['idkonsul'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$str = "SELECT * FROM `tbadm_konsultasi` WHERE `IdKonsultasi`='$idkonsul'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
?>

<style>
.zoom {
  padding: 10px;
  transition: transform .2s; /* Animation */
  width: 100%;
  height: 100%;
  margin: 0 auto;
}

.zoom:hover {
  transform: scale(3.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>

<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="?page=adm_konsultasi_edit_proses" method="post" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><b>EDIT DATA KONSULTASI</b></h4>
				</div>			  
				<div class="modal-body">
					<input type="hidden" name="idkonsul" value="<?php echo $data['IdKonsultasi'];?>">
					<table class="table">
						<tr>
							<td class="col-sm-3">Modul Aplikasi</td>
							<td class="col-sm-9">
								<select name="modulaplikasi" class="form-control">
									<option value="Atrian Online" <?php if($data['Modul'] == 'Atrian Online'){echo "SELECTED";}?>>Atrian Online</option>
									<option value="Daftar Online" <?php if($data['Modul'] == 'Daftar Online'){echo "SELECTED";}?>>Daftar Online</option>
									<option value="Pendaftaran" <?php if($data['Modul'] == 'Pendaftaran'){echo "SELECTED";}?>>Pendaftaran</option>
									<option value="Pemeriksaan" <?php if($data['Modul'] == 'Pemeriksaan'){echo "SELECTED";}?>>Pemeriksaan</option>
									<option value="Farmasi" <?php if($data['Modul'] == 'Farmasi'){echo "SELECTED";}?>>Farmasi</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Pertanyaan</td>
							<td>
								<textarea name="pertanyaan" class="form-control" rows="5" placeholder="Jelaskan secara detail" maxlength="500"><?php echo strtoupper($data['Pertanyaan']);?></textarea>
							</td>
						</tr>
						<tr>
							<td>Jawaban</td>
							<td>
								<?php if(in_array("PROGRAMMER", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ ?>
									<textarea name="jawaban" class="form-control" rows="5" placeholder="Jelaskan secara detail" maxlength="500"><?php echo strtoupper($data['Jawaban']);?></textarea>
								<?php }else{?>
									<textarea name="jawaban" class="form-control" rows="5" placeholder="Jelaskan secara detail" maxlength="500" readonly><?php echo strtoupper($data['Jawaban']);?></textarea>
								<?php }?>
							</td>
						</tr>
						<tr>
							<td>Sertakan Gambar</td>
							<td>
								<?php
									$i = 0;
									$imgs = json_decode($data['Gambar']);
									$img = $imgs[0];
								?>		
								<div class="col-sm-6">
									<?php 
										if(!file_exists("image/konsultasi/".$img) || $img == ''){
									?>
									
									<div class="zoom"><img src='image/konsultasi/addimage.jpg' class="img img-responsive" style='width:100%;margin-left:16px;margin-bottom:5px'/></div>
									<?php }else{ ?>		
									<div class="zoom"><img src='image/konsultasi/<?php echo $img;?>' class="img img-responsive" style='width:100%;margin-left:16px;margin-bottom:5px'/></div>
									<?php } ?>	
								</div>
								<input type="file" name="image" class="form-control">
								<input type="hidden" name="imglama" value="<?php echo $img;?>" class="form-control">								
							</td>
						</tr>
					</table>
				</div><br/><br/><hr/>
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
		</div>
	</div>
</div>	