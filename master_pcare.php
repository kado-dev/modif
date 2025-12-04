<?php
	$kota = $_SESSION['kota'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PCARE BPJS</b></h3>
			<table class="table-judul">
				<thead>
					<tr>
						<th>ID PUSKESMAS</th>
						<th>NAMA PUSKESMAS</th>
						<th>USERNAME</th>
						<th>PASSWORD</th>
						<?php
							if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("REKAM MEDIS", $otoritas)){
						?>
						<th>Aksi</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
					$str = "SELECT * FROM `tbpuskesmasdetail` WHERE `KodePuskesmas` = '$kodepuskesmas' order by NamaPPK";
					$query = mysqli_query($koneksi,$str);
					while($data = mysqli_fetch_assoc($query)){
					?>
						<tr>
							<?php 
								$ckabdescr = "-";
								$kodekab = $data['KodeKab'];
								$qrydatapkm = mysqli_query($koneksi,"select `CKabDescr` from `ref_kabupaten` where `CKabID` = '$kodekab'");
								if(mysqli_num_rows($qrydatapkm) > 0){
									$datapkm = mysqli_fetch_assoc($qrydatapkm);
									$ckabdescr = $datapkm['CKabDescr'];
								}
							?>
							<td class="kodepuskesmas" style="text-align:center;"><?php echo $data['KodePuskesmas'];?></td>
							<td class="nama"><?php echo $data['NamaPPK'];?></td>
							<td style="text-align:center;"><?php echo $data['Username'];?></td>
							<td style="text-align:center;"><?php echo $data['Password'];?></td>
							<?php
								if(in_array("OPERATOR", $otoritas) || in_array("PROGRAMMER", $otoritas) || in_array("REKAM MEDIS", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
							?>
							<td style="text-align:center;">
								<a href="#" class="btn btn-round btn-success btnmodalpcareedit">EDIT</a>
								<!--<button type="submit" class="btn btn-xs btn-primary btnmodalpcareedit">Edit</a></button>-->
							</td>
							<?php } ?>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div><br/>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<b>Perhatikan :</b><br/>
					Update password PCare tiap 2 bulan sekali<br/>
					Jika lupa password PCare silahkan hubungi BPJS Divre kab/kota.
				</p>
			</div>
		</div>
	</div>
</div>
<div class="hasilmodal"></div>
	
