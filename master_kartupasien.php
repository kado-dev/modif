<?php
	$kota = $_SESSION['kota'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$img1 = $_FILES['gambar1'];
		$nama_img1 = $img1['name']; // nama file asli
		if($nama_img1 != ''){
			$namafoto1 = $_POST['namegambar1'];
			if($namafoto1 != ''){
				unlink("image/kartupasien/".$namafoto1);
			}
			
			$ext = pathinfo($nama_img1, PATHINFO_EXTENSION); // proses mendapatkan extensi file
			$tmp = $img1['tmp_name']; // tmp file
			$image1 = "kartu-".$kodepuskesmas."_depan.".$ext; // proses penamaan file foto
			copy($tmp,"image/kartupasien/".$image1);
			mysqli_query($koneksi,"UPDATE `tbkartupasien` SET Image = '$image1' WHERE `KodePuskesmas` = '$kodepuskesmas'");
		}
		
		
		$img2 = $_FILES['gambar2'];
		$nama_img2 = $img2['name']; // nama file asli
		if($nama_img2 != ''){
			$namafoto2 = $_POST['namegambar2'];
			if($namafoto2 != ''){
				unlink("image/kartupasien/".$namafoto2);
			}
			
			$ext2 = pathinfo($nama_img2, PATHINFO_EXTENSION); // proses mendapatkan extensi file
			$tmp2 = $img2['tmp_name']; // tmp file
			$image2 = "kartu-".$kodepuskesmas."_belakang.".$ext2; // proses penamaan file foto
			copy($tmp2,"image/kartupasien/".$image2);
			mysqli_query($koneksi,"UPDATE `tbkartupasien` SET Belakang = '$image2' WHERE `KodePuskesmas` = '$kodepuskesmas'");
		}
	}
	$kartu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbkartupasien` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
?>

<style>
	.kartu{
		// padding:20px 30px;
		width:487px;
		height:310px;
	}
	.clsbgkartu{
		position:absolute;
		top:0px;
		z-index:1;
		width:487px;
		height:310px;
	}	
	.tbnama{
		position:absolute;
		top:200px;
		left:50px;
		z-index:10000;
		font-weight:bold;
		font-size:16px;
		color:#000;
		font-family: "Roboto Condensed", Arial, sans-serif;
		margin-top: -3px;
		line-height: 17px;
	}
	.tbbarcode{
		background:#fff;
		position:absolute;
		top:230px;
		left:60px;
		z-index:10000;
		font-weight:bold;
		font-size:15px;
		color:#000;
		font-family:century gothic;
	}
	@media print{
		body{
			visibility: hidden;
			width: 100%;
		}
		.kartu{
			visibility: visible;
			position: fixed;
			top: -10px;
			left: -10px;
			width: 487px;
			height: 305px;
		}
		.clsbgkartu{
			// visibility:hidden;
			width: 487px;
			height: 305px;
		}
		.tbnama{
			position: fixed;
			top:190px;
			left:30px;
			font-size : 16px;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.tbbarcode{
			position: fixed;
			top:225px;
			left:35px;
		}
	}
</style>


<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive" style="font-size:12px">
			<h3 class="judul"><b>KARTU PASIEN</b></h3>
			<div class="formbg" style="padding: 30px 30px 30px 30px;">
				<form class="form-signin" method="post" enctype="multipart/form-data">
					<input type="hidden" name="page" value="master_kartupasien">
					<div class = "row">
						<div class="col-sm-6">
							<h3 class="judul" style="text-align: center;"><b>Depan</b></h3>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-picture"></span></span>
								<input type="file" name="gambar1" class="form-control">
								<input type="hidden" name="namegambar1" value="<?php echo $kartu['Image'];?>">
								<?php if($kartu['Image'] != ''){?>
								<img src="image/kartupasien/<?php echo $kartu['Image'];?>" width="350px" alt="Photo" />
								<?php }?>
							</div>
						</div>
						<div class="col-sm-6">
							<h3 class="judul" style="text-align: center;"><b>Belakang</b></h3>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-picture"></span></span>
								<input type="file" name="gambar2" class="form-control">
								<input type="hidden" name="namegambar2" value="<?php echo $kartu['Belakang'];?>">
								<?php if($kartu['Belakang'] != ''){?>
								<img src="image/kartupasien/<?php echo $kartu['Belakang'];?>" width="350px" alt="Photo" />
								<?php }?>
							</div><br/>
							<button type="button" class="btn btn-round btn-success btnsimpan btnmodalkartubelakang">Print</button>
						</div>
					</div><hr>
					<button class="btn btn-round btn-success btnsimpan" name="btn" value="simpan" type="submit">Simpan</button>
				</form>
			</div>	
		</div>
	</div>
</div>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modalkartubelakang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Kartu Pasien (Belakang)</h4>
			</div>
			<div class="modal-body">
				<div class="kartu">
					<?php if($kartu['Belakang'] != ''){?>
						<img src="image/kartupasien/<?php echo $kartu['Belakang'];?>" class="clsbgkartu">
					<?php }?>
				</div>
			</div>
			<div class="modal-footer">
				<a href="javascript:print()" type="button" class="btn btn-info">Print</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="hasilmodal"></div>	
