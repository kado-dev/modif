<style>
	h4{
		font-weight: bold;	
	}	
	.form-check-label{
		margin-right: 12px;
	}
	.form-check-label input{
		position: relative;
		top:2px;
		margin-right: 5px;
	}
</style>
<?php
if($_POST['btn'] == 'simpan'){
	$pel_a = $_POST['pelayanan_a'];
	$pel_b = $_POST['pelayanan_b'];
	$pel_c = $_POST['pelayanan_c'];
	$pel_d = $_POST['pelayanan_d'];
	$pel_e = $_POST['pelayanan_e'];
	$pel_f = $_POST['pelayanan_f'];
	$pel_g = $_POST['pelayanan_g'];
	$pel_h = $_POST['pelayanan_h'];
	$jml_pel_a = $_POST['jml_pel_a'];
	$jml_pel_b = $_POST['jml_pel_b'];
	$jml_pel_c = $_POST['jml_pel_c'];
	$jml_pel_d = $_POST['jml_pel_d'];
	$jml_pel_e = $_POST['jml_pel_e'];
	$jml_pel_f = $_POST['jml_pel_f'];
	$jml_pel_g = $_POST['jml_pel_g'];
	$jml_pel_h = $_POST['jml_pel_h'];
	$pel_pustu_a = $_POST['pelayanan_pustu_a'];
	$pel_pustu_b = $_POST['pelayanan_pustu_b'];
	$pel_pustu_c = $_POST['pelayanan_pustu_c'];
	$pel_pustu_d = $_POST['pelayanan_pustu_d'];
	$pel_pustu_f = $_POST['pelayanan_pustu_f'];
	$pel_pustu_g = $_POST['pelayanan_pustu_g'];
	$jml_pel_pustu_a = $_POST['jml_pel_pustu_a'];
	$jml_pel_pustu_b = $_POST['jml_pel_pustu_b'];
	$jml_pel_pustu_c = $_POST['jml_pel_pustu_c'];
	$jml_pel_pustu_d = $_POST['jml_pel_pustu_d'];
	$jml_pel_pustu_f = $_POST['jml_pel_pustu_f'];
	$jml_pel_pustu_g = $_POST['jml_pel_pustu_g'];
	$waktupelayananbuka = $_POST['waktupelayananbuka'];
	$waktupelayanantutup = $_POST['waktupelayanantutup'];
	$statusslide = $_POST['statusslide'];
	$runningtext = $_POST['runningtext'];
	$prolanis = implode(",", $_POST['prolanis']);
	$imunisasi = implode(",", $_POST['imunisasi']);
	$versi = $_POST['versi'];
	$password =  md5($_POST['pass']);
	
	if($_POST['pass'] != ''){
		// antrian login
		mysqli_query($koneksi,"UPDATE tbantrian_login SET 
		Password = '$password' WHERE KodePuskesmas = '$kodepuskesmas'");
	}

	// tbantrian_setting
	$waktu = date('Y-m-d G:i:s');
	mysqli_query($koneksi,"UPDATE tbantrian_setting SET 
	`WaktuPelayananBuka`='$waktupelayananbuka',`WaktuPelayananTutup`='$waktupelayanantutup',StatusSlide = '$statusslide', RunningText = '$runningtext',Prolanis='$prolanis',Imunisasi='$imunisasi', versi_antrian = '$versi', Waktu = '$waktu' WHERE KodePuskesmas = '$kodepuskesmas'");

	// tbantrian_pelayanan
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_a', KodePelayanan = 'A',`Jumlah`='$jml_pel_a' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_b', KodePelayanan = 'B', `Jumlah`='$jml_pel_b' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_c', KodePelayanan = 'C', `Jumlah`='$jml_pel_c' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_d', KodePelayanan = 'D', `Jumlah`='$jml_pel_d' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_e', KodePelayanan = 'E', `Jumlah`='$jml_pel_e' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='E'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_f', KodePelayanan = 'F', `Jumlah`='$jml_pel_f' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_g', KodePelayanan = 'G', `Jumlah`='$jml_pel_g' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_h', KodePelayanan = 'H', `Jumlah`='$jml_pel_h' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='H'");

	//pustu
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_a', KodePelayanan = 'A',`Jumlah`='$jml_pel_pustu_a' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_b', KodePelayanan = 'B', `Jumlah`='$jml_pel_pustu_b' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_c', KodePelayanan = 'C', `Jumlah`='$jml_pel_pustu_c' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_d', KodePelayanan = 'D', `Jumlah`='$jml_pel_pustu_d' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_f', KodePelayanan = 'F', `Jumlah`='$jml_pel_pustu_f' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'");
	mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_g', KodePelayanan = 'G', `Jumlah`='$jml_pel_pustu_g' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'");

	$img1 = $_FILES['gambar1'];
	$nama_img1 = $img1['name']; // nama file asli
	if($nama_img1 != ''){
		$ext = pathinfo($nama_img1, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img1['tmp_name']; // tmp file
		$image1 = "slide1".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image1);
		$namafoto1 = $_POST['namegambar1'];
		if($namafoto1 != ''){
			if(file_exists("antrian/image/".$namafoto1)){
			unlink("antrian/image/".$namafoto1);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image1 = '$image1' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img2 = $_FILES['gambar2'];
	$nama_img2 = $img2['name']; // nama file asli
	if($nama_img2 != ''){
		$ext = pathinfo($nama_img2, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img2['tmp_name']; // tmp file
		$image2 = "slide2".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image2);
		$namafoto2 = $_POST['namegambar2'];
		if($namafoto2 != ''){
			if(file_exists("antrian/image/".$namafoto2)){
			unlink("antrian/image/".$namafoto2);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image2 = '$image2' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img3 = $_FILES['gambar3'];
	$nama_img3 = $img3['name']; // nama file asli
	if($nama_img3 != ''){
		$ext = pathinfo($nama_img3, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img3['tmp_name']; // tmp file
		$image3 = "slide3".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image3);
		$namafoto3 = $_POST['namegambar3'];
		if($namafoto3 != ''){
			if(file_exists("antrian/image/".$namafoto3)){
			unlink("antrian/image/".$namafoto3);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image3 = '$image3' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img4 = $_FILES['gambar4'];
	$nama_img4 = $img4['name']; // nama file asli
	if($nama_img4 != ''){
		$ext = pathinfo($nama_img4, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img4['tmp_name']; // tmp file
		$image4 = "slide4".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image4);
		$namafoto4 = $_POST['namegambar4'];
		if($namafoto4 != ''){
			if(file_exists("antrian/image/".$namafoto4)){
			unlink("antrian/image/".$namafoto4);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image4 = '$image4' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img5 = $_FILES['gambar5'];
	$nama_img5 = $img5['name']; // nama file asli
	if($nama_img5 != ''){
		$ext = pathinfo($nama_img5, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img5['tmp_name']; // tmp file
		$image5 = "slide5".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image5);
		$namafoto5 = $_POST['namegambar5'];
		if($namafoto5 != ''){
			if(file_exists("antrian/image/".$namafoto5)){
			unlink("antrian/image/".$namafoto5);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image5 = '$image5' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img6 = $_FILES['gambar6'];
	$nama_img6 = $img6['name']; // nama file asli
	if($nama_img6 != ''){
		$ext = pathinfo($nama_img6, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img6['tmp_name']; // tmp file
		$image6 = "slide6".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image6);
		$namafoto6 = $_POST['namegambar6'];
		if($namafoto6 != ''){
			if(file_exists("antrian/image/".$namafoto6)){
			unlink("antrian/image/".$namafoto6);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image6 = '$image6' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img7 = $_FILES['gambar7'];
	$nama_img7 = $img7['name']; // nama file asli
	if($nama_img7 != ''){
		$ext = pathinfo($nama_img7, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img7['tmp_name']; // tmp file
		$image7 = "slide7".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image7);
		$namafoto7 = $_POST['namegambar7'];
		if($namafoto7 != ''){
			if(file_exists("antrian/image/".$namafoto7)){
			unlink("antrian/image/".$namafoto7);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image7 = '$image7' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img8 = $_FILES['gambar8'];
	$nama_img8 = $img8['name']; // nama file asli
	if($nama_img8 != ''){
		$ext = pathinfo($nama_img8, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img8['tmp_name']; // tmp file
		$image8 = "slide8".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image8);
		$namafoto8 = $_POST['namegambar8'];
		if($namafoto8 != ''){
			if(file_exists("antrian/image/".$namafoto8)){
			unlink("antrian/image/".$namafoto8);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image8 = '$image8' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img9 = $_FILES['gambar9'];
	$nama_img9 = $img9['name']; // nama file asli
	if($nama_img9 != ''){
		$ext = pathinfo($nama_img9, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img9['tmp_name']; // tmp file
		$image9 = "slide9".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image9);
		$namafoto9 = $_POST['namegambar9'];
		if($namafoto9 != ''){
			if(file_exists("antrian/image/".$namafoto9)){
			unlink("antrian/image/".$namafoto9);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image9 = '$image9' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img10 = $_FILES['gambar10'];
	$nama_img10 = $img10['name']; // nama file asli
	if($nama_img10 != ''){
		$ext = pathinfo($nama_img10, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img10['tmp_name']; // tmp file
		$image10 = "slide10".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image10);
		$namafoto10 = $_POST['namegambar10'];
		if($namafoto10 != ''){
			if(file_exists("antrian/image/".$namafoto10)){
			unlink("antrian/image/".$namafoto10);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image10 = '$image10' WHERE KodePuskesmas = '$kodepuskesmas'");
	}

	$video = $_FILES['video'];
	$nama_video = $video['name']; // nama file asli
	if($nama_video != ''){
		$ext = pathinfo($nama_video, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		if($ext == 'mp4'){
			$tmp = $video['tmp_name']; // tmp file
			$videoname = "video".date('ymdgis').".".$ext; // proses penamaan file foto
			copy($tmp,"antrian/video/".$videoname);
			$namavideo = $_POST['namevideo'];
			if($namavideo != ''){
				if(file_exists("antrian/video/".$namavideo)){
				unlink("antrian/video/".$namavideo);
				}
			}
			//echo "UPDATE tbantrian_setting SET Video1 = '$videoname' WHERE KodePuskesmas = '$kodepuskesmas'";
			//die();
			mysqli_query($koneksi,"UPDATE tbantrian_setting SET Video1 = '$videoname' WHERE KodePuskesmas = '$kodepuskesmas'");
		}
	}

	//header("location:'index.php'");
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=master_antrian_pasien_bulungan';";
	echo "</script>";
}

$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting WHERE `KodePuskesmas`='$kodepuskesmas'"));

?>

<style>
	.input-group{
		padding: 5px;
	}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive" style="font-size:12px">
			<h3 class="judul"><b>ANTRIAN PASIEN</b></h3>
			<div class="formbg" style="padding: 30px 30px 30px 30px">
				<form class="form-signin" method="post" enctype="multipart/form-data">
					<input type="hidden" name="page" value="master_antrian_pasien_bulungan">
					<h4>Versi</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-dashboard"></span></span>
						<select name="versi" class="form-control">
							<option value="">---Pilih Versi Antrian---</option>
							<option value="versi1" <?php if($datasetting['versi_antrian'] == 'versi1'){echo 'SELECTED';}?>>Versi 1</option>
							<option value="versi2" <?php if($datasetting['versi_antrian'] == 'versi2'){echo 'SELECTED';}?>>Versi 2</option>
						</select>
					</div>
					<hr/>
					<h4>Password</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" name="pass" class="form-control" placeholder="Password, maks.15 digit" maxlength="15">
					</div>
					<hr/>
					<h4>Pelayanan Puskesmas</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">A</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'"));
										?>
										<select name="pelayanan_a" class="form-control pel_a" required>
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="GIZI IMUNISASI" <?php if($dtpel['Pelayanan'] == 'GIZI IMUNISASI'){echo "SELECTED";}?>>GIZI IMUNISASI</option>
											<option value="SKD" <?php if($dtpel['Pelayanan'] == 'SKD'){echo "SELECTED";}?>>SKD</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>	
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_a" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>	
							<span class="label_a" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'"));
										?>
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">B</span>
										<select name="pelayanan_b" class="form-control pel_b">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="GIZI IMUNISASI" <?php if($dtpel['Pelayanan'] == 'GIZI IMUNISASI'){echo "SELECTED";}?>>GIZI IMUNISASI</option>
											<option value="SKD" <?php if($dtpel['Pelayanan'] == 'SKD'){echo "SELECTED";}?>>SKD</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_b" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>			
							</div>
							<span class="label_b" style="color:red;"></span>	
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">C</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'"));
										?>
										<select name="pelayanan_c" class="form-control pel_c">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="GIZI IMUNISASI" <?php if($dtpel['Pelayanan'] == 'GIZI IMUNISASI'){echo "SELECTED";}?>>GIZI IMUNISASI</option>
											<option value="SKD" <?php if($dtpel['Pelayanan'] == 'SKD'){echo "SELECTED";}?>>SKD</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_c" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_c" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">D</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'"));
										?>
										<select name="pelayanan_d" class="form-control pel_d">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="GIZI IMUNISASI" <?php if($dtpel['Pelayanan'] == 'GIZI IMUNISASI'){echo "SELECTED";}?>>GIZI IMUNISASI</option>
											<option value="SKD" <?php if($dtpel['Pelayanan'] == 'SKD'){echo "SELECTED";}?>>SKD</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_d" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_d" style="color:red;"></span>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">E</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='E'"));
										?>
										<select name="pelayanan_e" class="form-control pel_e">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="GIZI IMUNISASI" <?php if($dtpel['Pelayanan'] == 'GIZI IMUNISASI'){echo "SELECTED";}?>>GIZI IMUNISASI</option>
											<option value="SKD" <?php if($dtpel['Pelayanan'] == 'SKD'){echo "SELECTED";}?>>SKD</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_e" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_e" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">F</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'"));
										?>
										<select name="pelayanan_f" class="form-control pel_f">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="GIZI IMUNISASI" <?php if($dtpel['Pelayanan'] == 'GIZI IMUNISASI'){echo "SELECTED";}?>>GIZI IMUNISASI</option>
											<option value="SKD" <?php if($dtpel['Pelayanan'] == 'SKD'){echo "SELECTED";}?>>SKD</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_f" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_f" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">G</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'"));
										?>
										<select name="pelayanan_g" class="form-control pel_g">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="GIZI IMUNISASI" <?php if($dtpel['Pelayanan'] == 'GIZI IMUNISASI'){echo "SELECTED";}?>>GIZI IMUNISASI</option>
											<option value="SKD" <?php if($dtpel['Pelayanan'] == 'SKD'){echo "SELECTED";}?>>SKD</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_g" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_g" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">H</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='H'"));
										?>
										<select name="pelayanan_h" class="form-control pel_h">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="GIZI IMUNISASI" <?php if($dtpel['Pelayanan'] == 'GIZI IMUNISASI'){echo "SELECTED";}?>>GIZI IMUNISASI</option>
											<option value="SKD" <?php if($dtpel['Pelayanan'] == 'SKD'){echo "SELECTED";}?>>SKD</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_h" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_h" style="color:red;"></span>
						</div>
					</div>	
					<!--
					<div class="input-group">
						<span class="input-group-addon tesdate"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="text" name="tanggalprolanis" class="form-control datepicker" placeholder="Pilih Tanggal">
						<span class="input-group-addon" style="background:#f9f9f9;border-color:#ddd;color:#444">Prolanis</span>
					</div>
					-->
					<h4>Pelayanan Pustu</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">A</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'"));
										?>
										<select name="pelayanan_pustu_a" class="form-control pel_pustu_a">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KIA KB" <?php if($dtpel['Pelayanan'] == 'KIA KB'){echo "SELECTED";}?>>KIA KB</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>	
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_pustu_a" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>	
							<span class="label_pustu_a" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'"));
										?>
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">B</span>
										<select name="pelayanan_pustu_b" class="form-control pel_pustu_b">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KIA KB" <?php if($dtpel['Pelayanan'] == 'KIA KB'){echo "SELECTED";}?>>KIA KB</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_pustu_b" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>			
							</div>
							<span class="label_pustu_b" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'"));
										?>
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">C</span>
										<select name="pelayanan_pustu_c" class="form-control pel_pustu_c">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KIA KB" <?php if($dtpel['Pelayanan'] == 'KIA KB'){echo "SELECTED";}?>>KIA KB</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_pustu_c" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>			
							</div>
							<span class="label_pustu_c" style="color:red;"></span>							
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">D</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'"));
										?>
										<select name="pelayanan_pustu_d" class="form-control pel_pustu_d">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KIA KB" <?php if($dtpel['Pelayanan'] == 'KIA KB'){echo "SELECTED";}?>>KIA KB</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_pustu_d" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_pustu_d" style="color:red;"></span>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">F</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'"));
										?>
										<select name="pelayanan_pustu_f" class="form-control pel_pustu_f">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KIA KB" <?php if($dtpel['Pelayanan'] == 'KIA KB'){echo "SELECTED";}?>>KIA KB</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_pustu_f" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_pustu_f" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">G</span>
										<?php
											$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'"));
										?>
										<select name="pelayanan_pustu_g" class="form-control pel_pustu_g">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="KIA KB" <?php if($dtpel['Pelayanan'] == 'KIA KB'){echo "SELECTED";}?>>KIA KB</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_pustu_g" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_pustu_g" style="color:red;"></span>
						</div>						
					</div>
					<hr/>
					<h4>Imunisasi</h4>
						<?php
							$arr_imunisasi = explode(",",$datasetting['Imunisasi']);
						?>
						<label class="form-check-label"><input type="checkbox" name="imunisasi[]" value="1" <?php if(in_array("1", $arr_imunisasi)){echo "CHECKED";}?>>Senin</label>
						<label class="form-check-label"><input type="checkbox" name="imunisasi[]" value="2" <?php if(in_array("2", $arr_imunisasi)){echo "CHECKED";}?>>Selasa</label>
						<label class="form-check-label"><input type="checkbox" name="imunisasi[]" value="3" <?php if(in_array("3", $arr_imunisasi)){echo "CHECKED";}?>>Rabu</label>
						<label class="form-check-label"><input type="checkbox" name="imunisasi[]" value="4" <?php if(in_array("4", $arr_imunisasi)){echo "CHECKED";}?>>Kamis</label>
						<label class="form-check-label"><input type="checkbox" name="imunisasi[]" value="5" <?php if(in_array("5", $arr_imunisasi)){echo "CHECKED";}?>>Jumat</label>
						<label class="form-check-label"><input type="checkbox" name="imunisasi[]" value="6" <?php if(in_array("6", $arr_imunisasi)){echo "CHECKED";}?>>Sabtu</label>
		
					<hr/>
					<h4>Prolanis</h4>
						<?php
							$arr_prolanis = explode(",",$datasetting['Prolanis']);
						?>
						<label class="form-check-label"><input type="checkbox" name="prolanis[]" value="1" <?php if(in_array("1", $arr_prolanis)){echo "CHECKED";}?>>Senin</label>
						<label class="form-check-label"><input type="checkbox" name="prolanis[]" value="2" <?php if(in_array("2", $arr_prolanis)){echo "CHECKED";}?>>Selasa</label>
						<label class="form-check-label"><input type="checkbox" name="prolanis[]" value="3" <?php if(in_array("3", $arr_prolanis)){echo "CHECKED";}?>>Rabu</label>
						<label class="form-check-label"><input type="checkbox" name="prolanis[]" value="4" <?php if(in_array("4", $arr_prolanis)){echo "CHECKED";}?>>Kamis</label>
						<label class="form-check-label"><input type="checkbox" name="prolanis[]" value="5" <?php if(in_array("5", $arr_prolanis)){echo "CHECKED";}?>>Jumat</label>
						<label class="form-check-label"><input type="checkbox" name="prolanis[]" value="6" <?php if(in_array("6", $arr_prolanis)){echo "CHECKED";}?>>Sabtu</label>
		
					<hr/>					
					<h4>Waktu Pelayanan</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-time"></span></span>
						<select name="waktupelayananbuka" class="form-control">
							<option value="">Pilih</option>
							<option value="07.00" <?php if($datasetting['WaktuPelayananBuka'] == '07.00'){echo 'SELECTED';}?>>07.00</option>
							<option value="07.30" <?php if($datasetting['WaktuPelayananBuka'] == '07.30'){echo 'SELECTED';}?>>07.30</option>
							<option value="08.00" <?php if($datasetting['WaktuPelayananBuka'] == '08.00'){echo 'SELECTED';}?>>08.00</option>
						</select>
						<span class="input-group-addon" style="background:#f9f9f9;border-color:#ddd;color:#444">Jam Buka</span>
					</div>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-time"></span></span>
						<select name="waktupelayanantutup" class="form-control">
							<option value="">Pilih</option>
							<option value="09.30" <?php if($datasetting['WaktuPelayananTutup'] == '09.30'){echo 'SELECTED';}?>>09.30</option>
							<option value="10.00" <?php if($datasetting['WaktuPelayananTutup'] == '10.00'){echo 'SELECTED';}?>>10.00</option>
							<option value="10.30" <?php if($datasetting['WaktuPelayananTutup'] == '10.30'){echo 'SELECTED';}?>>10.30</option>
							<option value="11.00" <?php if($datasetting['WaktuPelayananTutup'] == '11.00'){echo 'SELECTED';}?>>11.00</option>
							<option value="11.30" <?php if($datasetting['WaktuPelayananTutup'] == '11.30'){echo 'SELECTED';}?>>11.30</option>
							<option value="12.00" <?php if($datasetting['WaktuPelayananTutup'] == '12.00'){echo 'SELECTED';}?>>12.00</option>
							<option value="23.00" <?php if($datasetting['WaktuPelayananTutup'] == '23.00'){echo 'SELECTED';}?>>23.00</option>
						</select>
						<span class="input-group-addon" style="background:#f9f9f9;border-color:#ddd;color:#444">Jam Tutup</span>
					</div>
					<hr/>
					<h4>Running Text</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-pencil"></span></span>
							<textarea name="runningtext" class="form-control" placeholder="Silahkan ketikan informasi running text maks.150 digit" maxlength="200"><?php echo $datasetting['RunningText'];?></textarea>
						<span class="input-group-addon" style="background:#f9f9f9;border-color:#ddd;color:#444">Running Text</span>
					</div>
					<hr/>
					<h4>Opsion Slide</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-film"></span></span>
						<select name="statusslide" class="form-control">
							<option value="">Status Slide</option>
							<option value="gambar" <?php if($datasetting['StatusSlide'] == 'gambar'){echo 'SELECTED';}?>>Gambar</option>
							<option value="video" <?php if($datasetting['StatusSlide'] == 'video'){echo 'SELECTED';}?>>Video</option>
						</select>
					</div>
					<hr/>
					<h4>Image</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 1</span>
								<input type="file" name="gambar1" class="form-control">
								<input type="hidden" name="namegambar1" value="<?php echo $datasetting['Image1'];?>">
								<img src="image/<?php echo $datasetting['Image1'];?>" width="150px">
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 2</span>
								<input type="file"  name="gambar2" class="form-control">
								<input type="hidden" name="namegambar2" value="<?php echo $datasetting['Image2'];?>">
								<img src="image/<?php echo $datasetting['Image2'];?>" width="150px">
							</div>	
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 3</span>
								<input type="file"  name="gambar3" class="form-control">
								<input type="hidden" name="namegambar3" value="<?php echo $datasetting['Image3'];?>">
								<img src="image/<?php echo $datasetting['Image3'];?>" width="150px">
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 4</span>
								<input type="file"  name="gambar4" class="form-control">
								<input type="hidden" name="namegambar4" value="<?php echo $datasetting['Image4'];?>">
								<img src="image/<?php echo $datasetting['Image4'];?>" width="150px">
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 5</span>
								<input type="file"  name="gambar5" class="form-control">
								<input type="hidden" name="namegambar5" value="<?php echo $datasetting['Image5'];?>">
								<img src="image/<?php echo $datasetting['Image5'];?>" width="150px">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 6</span>
								<input type="file"  name="gambar6" class="form-control">
								<input type="hidden" name="namegambar6" value="<?php echo $datasetting['Image6'];?>">
								<img src="image/<?php echo $datasetting['Image6'];?>" width="150px">
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 7</span>
								<input type="file"  name="gambar7" class="form-control">
								<input type="hidden" name="namegambar7" value="<?php echo $datasetting['Image7'];?>">
								<img src="image/<?php echo $datasetting['Image7'];?>" width="150px">
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 8</span>
								<input type="file"  name="gambar8" class="form-control">
								<input type="hidden" name="namegambar8" value="<?php echo $datasetting['Image8'];?>">
								<img src="image/<?php echo $datasetting['Image8'];?>" width="150px">
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 9</span>
								<input type="file"  name="gambar8" class="form-control">
								<input type="hidden" name="namegambar9" value="<?php echo $datasetting['Image9'];?>">
								<img src="image/<?php echo $datasetting['Image9'];?>" width="150px">
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Img 10</span>
								<input type="file"  name="gambar10" class="form-control">
								<input type="hidden" name="namegambar10" value="<?php echo $datasetting['Image10'];?>">
								<img src="image/<?php echo $datasetting['Image10'];?>" width="150px">
							</div>
						</div>
					</div>	
					<hr/>
					<h4>Video</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444">Video</span>
						<input type="file"  name="video" class="form-control">
						<input type="hidden" name="namevideo" value="<?php echo $datasetting['Video1'];?>">
						<video width="180px" loop="true" controls="controls">
							<source src="video/<?php echo $datasetting['Video1'];?>" type="video/mp4">
						</video>
					</div><hr/>
					<button class="btnsimpan" name="btn" value="simpan" type="submit">Simpan</button>
				</form>
			</div>	
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">

$(".pel_a").change(function(){
	var pel_a = $(this).val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	if(pel_a == pel_b || pel_a == pel_c || pel_a == pel_d || pel_a == pel_e || pel_a == pel_f || pel_a == pel_g || pel_a == pel_h){
		$(".label_a").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_a").html("");
	}
});
$(".pel_b").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(this).val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	if(pel_b == pel_a || pel_b == pel_c || pel_b == pel_d || pel_b == pel_e || pel_b == pel_f || pel_b == pel_g || pel_b == pel_h){
		$(".label_b").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_b").html("");
	}
});
$(".pel_c").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(this).val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	if(pel_c == pel_a || pel_c == pel_b || pel_c == pel_d || pel_c == pel_e || pel_c == pel_f || pel_c == pel_g || pel_c == pel_h){
		$(".label_c").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_c").html("");
	}
});
$(".pel_d").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(this).val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	if(pel_d == pel_a || pel_d == pel_b || pel_d == pel_c || pel_d == pel_e || pel_d == pel_f || pel_d == pel_g || pel_d == pel_h){
		$(".label_d").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_d").html("");
	}
});
$(".pel_e").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(this).val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	if(pel_e == pel_a || pel_e == pel_b || pel_e == pel_c || pel_e == pel_d || pel_e == pel_f || pel_e == pel_g || pel_e == pel_h){
		$(".label_e").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_e").html("");
	}
});
$(".pel_f").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(this).val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	if(pel_f == pel_a || pel_f == pel_b || pel_f == pel_c || pel_f == pel_d || pel_f == pel_e || pel_f == pel_g || pel_f == pel_h){
		$(".label_f").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_f").html("");
	}
});
$(".pel_g").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(this).val();
	var pel_h = $(".pel_h").val();
	if(pel_g == pel_a || pel_g == pel_b || pel_g == pel_c || pel_g == pel_d || pel_g == pel_e || pel_g == pel_f || pel_g == pel_h){
		$(".label_g").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_g").html("");
	}
});
$(".pel_h").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(this).val();
	if(pel_h == pel_a || pel_h == pel_b || pel_h == pel_c || pel_h == pel_d || pel_h == pel_e || pel_h == pel_f || pel_h == pel_g){
		$(".label_h").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_h").html("");
	}
});
$(".pel_pustu_a").change(function(){
	var pel_pustu_a = $(this).val();
	var pel_pustu_b = $(".pel_pustu_b").val();
	var pel_pustu_c = $(".pel_pustu_c").val();
	var pel_pustu_d = $(".pel_pustu_d").val();
	var pel_pustu_e = $(".pel_pustu_e").val();
	var pel_pustu_f = $(".pel_pustu_f").val();
	var pel_pustu_g = $(".pel_pustu_g").val();
	var pel_pustu_h = $(".pel_pustu_h").val();
	if(pel_pustu_a == pel_pustu_b || pel_pustu_a == pel_pustu_c || pel_pustu_a == pel_pustu_d || pel_pustu_a == pel_pustu_e || pel_pustu_a == pel_pustu_f || pel_pustu_a == pel_pustu_g || pel_pustu_a == pel_pustu_h){
		$(".label_pustu_a").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_a").html("");
	}
});
$(".pel_pustu_b").change(function(){
	var pel_pustu_a = $(".pel_pustu_a").val();
	var pel_pustu_b = $(this).val();
	var pel_pustu_c = $(".pel_pustu_c").val();
	var pel_pustu_d = $(".pel_pustu_d").val();
	var pel_pustu_e = $(".pel_pustu_e").val();
	var pel_pustu_f = $(".pel_pustu_f").val();
	var pel_pustu_g = $(".pel_pustu_g").val();
	var pel_pustu_h = $(".pel_pustu_h").val();
	if(pel_pustu_b == pel_pustu_a || pel_pustu_b == pel_pustu_c || pel_pustu_b == pel_pustu_d || pel_pustu_b == pel_pustu_e || pel_pustu_b == pel_pustu_f || pel_pustu_b == pel_pustu_g || pel_pustu_b == pel_pustu_h){
		$(".label_pustu_b").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_b").html("");
	}
});
$(".pel_pustu_c").change(function(){
	var pel_pustu_a = $(".pel_pustu_a").val();
	var pel_pustu_b = $(".pel_pustu_b").val();
	var pel_pustu_c = $(this).val();
	var pel_pustu_d = $(".pel_pustu_d").val();
	var pel_pustu_e = $(".pel_pustu_e").val();
	var pel_pustu_f = $(".pel_pustu_f").val();
	var pel_pustu_g = $(".pel_pustu_g").val();
	var pel_pustu_h = $(".pel_pustu_h").val();
	if(pel_pustu_c == pel_pustu_a || pel_pustu_c == pel_pustu_b || pel_pustu_c == pel_pustu_d || pel_pustu_c == pel_pustu_e || pel_pustu_c == pel_pustu_f || pel_pustu_c == pel_pustu_g || pel_pustu_c == pel_pustu_h){
		$(".label_pustu_c").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_c").html("");
	}
});
$(".pel_pustu_d").change(function(){
	var pel_pustu_a = $(".pel_pustu_a").val();
	var pel_pustu_b = $(".pel_pustu_b").val();
	var pel_pustu_c = $(".pel_pustu_c").val();
	var pel_pustu_d = $(this).val();
	var pel_pustu_e = $(".pel_pustu_e").val();
	var pel_pustu_f = $(".pel_pustu_f").val();
	var pel_pustu_g = $(".pel_pustu_g").val();
	var pel_pustu_h = $(".pel_pustu_h").val();
	if(pel_pustu_d == pel_pustu_a || pel_pustu_d == pel_pustu_b || pel_pustu_d == pel_pustu_c || pel_pustu_d == pel_pustu_e || pel_pustu_d == pel_pustu_f || pel_pustu_d == pel_pustu_g || pel_pustu_d == pel_pustu_h){
		$(".label_pustu_d").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_d").html("");
	}
});
$(".pel_pustu_f").change(function(){
	var pel_pustu_a = $(".pel_pustu_a").val();
	var pel_pustu_b = $(".pel_pustu_b").val();
	var pel_pustu_c = $(".pel_pustu_c").val();
	var pel_pustu_d = $(".pel_pustu_d").val();
	var pel_pustu_e = $(".pel_pustu_e").val();
	var pel_pustu_f = $(this).val();
	var pel_pustu_g = $(".pel_pustu_g").val();
	var pel_pustu_h = $(".pel_pustu_h").val();
	if(pel_pustu_f == pel_pustu_a || pel_pustu_f == pel_pustu_b || pel_pustu_f == pel_pustu_c || pel_pustu_f == pel_pustu_d || pel_pustu_f == pel_pustu_e || pel_pustu_f == pel_pustu_g || pel_pustu_f == pel_pustu_h){
		$(".label_pustu_f").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_f").html("");
	}
});
$(".pel_pustu_g").change(function(){
	var pel_pustu_a = $(".pel_pustu_a").val();
	var pel_pustu_b = $(".pel_pustu_b").val();
	var pel_pustu_c = $(".pel_pustu_c").val();
	var pel_pustu_d = $(".pel_pustu_d").val();
	var pel_pustu_e = $(".pel_pustu_e").val();
	var pel_pustu_f = $(".pel_pustu_e").val();
	var pel_pustu_g = $(this).val();
	var pel_pustu_h = $(".pel_pustu_h").val();
	if(pel_pustu_g == pel_pustu_a || pel_pustu_g == pel_pustu_b || pel_pustu_g == pel_pustu_c || pel_pustu_g == pel_pustu_d || pel_pustu_g == pel_pustu_e || pel_pustu_g == pel_pustu_f || pel_pustu_g == pel_pustu_h){
		$(".label_pustu_g").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_g").html("");
	}
});
</script>