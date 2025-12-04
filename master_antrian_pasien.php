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
	$pel_aa = $_POST['pelayanan_aa'];
	$pel_b = $_POST['pelayanan_b'];
	$pel_c = $_POST['pelayanan_c'];
	$pel_d = $_POST['pelayanan_d'];
	$pel_e = $_POST['pelayanan_e'];
	$pel_f = $_POST['pelayanan_f'];
	$pel_g = $_POST['pelayanan_g'];
	$pel_h = $_POST['pelayanan_h'];
	$pel_i = $_POST['pelayanan_i'];
	$pel_j = $_POST['pelayanan_j'];
	$pel_k = $_POST['pelayanan_k'];
	$pel_l = $_POST['pelayanan_l'];
	$jml_pel_a = $_POST['jml_pel_a'];
	$jml_pel_aa = $_POST['jml_pel_aa'];
	$jml_pel_b = $_POST['jml_pel_b'];
	$jml_pel_c = $_POST['jml_pel_c'];
	$jml_pel_d = $_POST['jml_pel_d'];
	$jml_pel_e = $_POST['jml_pel_e'];
	$jml_pel_f = $_POST['jml_pel_f'];
	$jml_pel_g = $_POST['jml_pel_g'];
	$jml_pel_h = $_POST['jml_pel_h'];
	$jml_pel_i = $_POST['jml_pel_i'];
	$jml_pel_j = $_POST['jml_pel_j'];
	$jml_pel_k = $_POST['jml_pel_k'];
	$jml_pel_l = $_POST['jml_pel_l'];
	$ket_a = $_POST['ket_a'];
	$ket_aa = $_POST['ket_aa'];
	$ket_b = $_POST['ket_b'];
	$ket_c = $_POST['ket_c'];
	$ket_d = $_POST['ket_d'];
	$ket_e = $_POST['ket_e'];
	$ket_f = $_POST['ket_f'];
	$ket_g = $_POST['ket_g'];
	$ket_h = $_POST['ket_h'];
	$ket_i = $_POST['ket_i'];
	$ket_j = $_POST['ket_j'];
	$ket_k = $_POST['ket_k'];
	$ket_l = $_POST['ket_l'];
	$pel_pustu_a = $_POST['pelayanan_pustu_a'];
	$pel_pustu_b = $_POST['pelayanan_pustu_b'];
	$pel_pustu_c = $_POST['pelayanan_pustu_c'];
	$pel_pustu_d = $_POST['pelayanan_pustu_d'];
	$pel_pustu_e = $_POST['pelayanan_pustu_e'];
	$pel_pustu_f = $_POST['pelayanan_pustu_f'];
	$jml_pel_pustu_a = $_POST['jml_pel_pustu_a'];
	$jml_pel_pustu_b = $_POST['jml_pel_pustu_b'];
	$jml_pel_pustu_c = $_POST['jml_pel_pustu_c'];
	$jml_pel_pustu_d = $_POST['jml_pel_pustu_d'];
	$jml_pel_pustu_e = $_POST['jml_pel_pustu_e'];
	$jml_pel_pustu_f = $_POST['jml_pel_pustu_f'];
	$waktupelayananbuka = $_POST['waktupelayananbuka'];
	$waktupelayanantutup = $_POST['waktupelayanantutup'];
	$statusslide = $_POST['statusslide'];
	$runningtext = $_POST['runningtext'];
	$prolanis = implode(",", $_POST['prolanis']);
	$imunisasi = implode(",", $_POST['imunisasi']);
	$vaksin = implode(",", $_POST['vaksin']);
	$versi = $_POST['versi'];
	$password =  md5($_POST['pass']);
	$tampilnoantrian = $_POST['tampilnoantrian'];
	
	if($_POST['pass'] != ''){
		// antrian login
		mysqli_query($koneksi,"UPDATE tbantrian_login SET 
		Password = '$password' WHERE KodePuskesmas = '$kodepuskesmas'");
	}

	// tbantrian_setting
	$waktu = date('Y-m-d G:i:s');
	$strantrian = "UPDATE tbantrian_setting SET `WaktuPelayananBuka`='$waktupelayananbuka',`WaktuPelayananTutup`='$waktupelayanantutup',StatusSlide = '$statusslide', RunningText = '$runningtext',Prolanis='$prolanis',Imunisasi='$imunisasi',Vaksin='$vaksin', versi_antrian = '$versi', Waktu = '$waktu', TampilNoAntrian = '$tampilnoantrian' WHERE KodePuskesmas = '$kodepuskesmas'";
	// echo $strantrian;
	// die();
	mysqli_query($koneksi, $strantrian);

	// tbantrian_pelayanan
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_a', KodePelayanan = 'A',`Jumlah`='$jml_pel_a', `Keterangan`='$ket_a' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A' AND `Klaster`='Klaster 2'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_aa', KodePelayanan = 'A',`Jumlah`='$jml_pel_aa', `Keterangan`='$ket_aa' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A' AND `Klaster`='Klaster 3'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_b', KodePelayanan = 'B', `Jumlah`='$jml_pel_b', `Keterangan`='$ket_b' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_c', KodePelayanan = 'C', `Jumlah`='$jml_pel_c', `Keterangan`='$ket_c' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_d', KodePelayanan = 'D', `Jumlah`='$jml_pel_d', `Keterangan`='$ket_d' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_e', KodePelayanan = 'E', `Jumlah`='$jml_pel_e', `Keterangan`='$ket_e' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='E'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_f', KodePelayanan = 'F', `Jumlah`='$jml_pel_f', `Keterangan`='$ket_f' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_g', KodePelayanan = 'G', `Jumlah`='$jml_pel_g', `Keterangan`='$ket_g' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_h', KodePelayanan = 'H', `Jumlah`='$jml_pel_h', `Keterangan`='$ket_h' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='H'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_i', KodePelayanan = 'I', `Jumlah`='$jml_pel_i', `Keterangan`='$ket_i' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='I'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_j', KodePelayanan = 'J', `Jumlah`='$jml_pel_j', `Keterangan`='$ket_j' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='J'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_k', KodePelayanan = 'K', `Jumlah`='$jml_pel_k', `Keterangan`='$ket_k' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='K'");
	mysqli_query($koneksi, "UPDATE `tbantrian_pelayanan` SET `Pelayanan`='$pel_l', KodePelayanan = 'L', `Jumlah`='$jml_pel_l', `Keterangan`='$ket_l' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='L'");

	// pustu
	// mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_a', KodePelayanan = 'A',`Jumlah`='$jml_pel_pustu_a' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'");
	// mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_b', KodePelayanan = 'B', `Jumlah`='$jml_pel_pustu_b' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'");
	// mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_c', KodePelayanan = 'C', `Jumlah`='$jml_pel_pustu_c' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'");
	// mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_d', KodePelayanan = 'D', `Jumlah`='$jml_pel_pustu_d' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'");
	// mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_e', KodePelayanan = 'E', `Jumlah`='$jml_pel_pustu_e' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='E'");
	// mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan_pustu` SET `Pelayanan`='$pel_pustu_f', KodePelayanan = 'F', `Jumlah`='$jml_pel_pustu_f' WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'");

	// image pendaftaran
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
	
	// image farmasi
	$img1 = $_FILES['gambar1_farmasi'];
	$nama_img1 = $img1['name']; // nama file asli
	if($nama_img1 != ''){
		$ext = pathinfo($nama_img1, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img1['tmp_name']; // tmp file
		$image1_farmasi = "slide1_farmasi".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image1_farmasi);
		$namafoto1 = $_POST['namegambar1_farmasi'];
		if($namafoto1 != ''){
			if(file_exists("antrian/image/".$namafoto1)){
			unlink("antrian/image/".$namafoto1);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image1_Farmasi = '$image1_farmasi' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img2 = $_FILES['gambar2_farmasi'];
	$nama_img2 = $img2['name']; // nama file asli
	if($nama_img2 != ''){
		$ext = pathinfo($nama_img2, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img2['tmp_name']; // tmp file
		$image2_farmasi = "slide2_farmasi".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image2_farmasi);
		$namafoto2 = $_POST['namegambar2_farmasi'];
		if($namafoto2 != ''){
			if(file_exists("antrian/image/".$namafoto2)){
			unlink("antrian/image/".$namafoto2);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image2_Farmasi = '$image2_farmasi' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img3 = $_FILES['gambar3_farmasi'];
	$nama_img3 = $img3['name']; // nama file asli
	if($nama_img3 != ''){
		$ext = pathinfo($nama_img3, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img3['tmp_name']; // tmp file
		$image3_farmasi = "slide3_farmasi".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image3_farmasi);
		$namafoto3 = $_POST['namegambar3_farmasi'];
		if($namafoto3 != ''){
			if(file_exists("antrian/image/".$namafoto3)){
			unlink("antrian/image/".$namafoto3);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image3_Farmasi = '$image3_farmasi' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img4 = $_FILES['gambar4_farmasi'];
	$nama_img4 = $img4['name']; // nama file asli
	if($nama_img4 != ''){
		$ext = pathinfo($nama_img4, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img4['tmp_name']; // tmp file
		$image4_farmasi = "slide3_farmasi".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image4_farmasi);
		$namafoto4 = $_POST['namegambar4_farmasi'];
		if($namafoto4 != ''){
			if(file_exists("antrian/image/".$namafoto4)){
			unlink("antrian/image/".$namafoto4);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image4_Farmasi = '$image4_farmasi' WHERE KodePuskesmas = '$kodepuskesmas'");
	}
	
	$img5 = $_FILES['gambar5_farmasi'];
	$nama_img5 = $img5['name']; // nama file asli
	if($nama_img5 != ''){
		$ext = pathinfo($nama_img5, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img5['tmp_name']; // tmp file
		$image5_farmasi = "slide3_farmasi".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"antrian/image/".$image5_farmasi);
		$namafoto5 = $_POST['namegambar5_farmasi'];
		if($namafoto5 != ''){
			if(file_exists("antrian/image/".$namafoto5)){
			unlink("antrian/image/".$namafoto5);
			}
		}
		mysqli_query($koneksi,"UPDATE tbantrian_setting SET Image5_Farmasi = '$image5_farmasi' WHERE KodePuskesmas = '$kodepuskesmas'");
	}

	$video = $_FILES['video'];
	$nama_video = $video['name']; // nama file asli
	if($nama_video != ''){
		$ext = pathinfo($nama_video, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		if($ext == 'mp4'){
			$tmp = $video['tmp_name']; // tmp file
			$videoname = $_SESSION['namapuskesmas']." video".date('ymdgis').".".$ext; // proses penamaan file foto
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
	echo "document.location.href='index.php?page=master_antrian_pasien';";
	echo "</script>";
}

$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbantrian_setting WHERE `KodePuskesmas`='$kodepuskesmas'"));

?>

<style>
	.input-group{
		padding: 5px;
	}
	.gmbrinput{
		width: 100px
	}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>ANTRIAN PASIEN</b></h3>
			<div class="formbg" style="padding: 30px 30px 30px 30px">
				<form class="form-signin" method="post" enctype="multipart/form-data">
					<input type="hidden" name="page" value="master_antrian_pasien">
					<h4>Versi</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-dashboard"></span></span>
						<select name="versi" class="form-control inputan">
							<option value="">---Pilih Versi Antrian---</option>
							<option value="versi1" <?php if($datasetting['versi_antrian'] == 'versi1'){echo 'SELECTED';}?>>Versi 1</option>
							<option value="versi2" <?php if($datasetting['versi_antrian'] == 'versi2'){echo 'SELECTED';}?>>Versi 2</option>
							<option value="versi3" <?php if($datasetting['versi_antrian'] == 'versi3'){echo 'SELECTED';}?>>Versi 3</option>
						</select>
					</div>
					<hr/>
					<h4>Password</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" name="pass" class="form-control inputan" placeholder="Password, maks.15 digit" maxlength="15">
					</div>
					<hr/>
					<h4>Pelayanan Puskesmas</h4>
						<!--A-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">A</span>
									</div>
									<select name="pelayanan_a" class="form-control pel_a inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>	
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_a" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<span class="label_a" style="color:red;"></span>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_a" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<!--AA-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A' AND `Klaster`='Klaster 3'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">A</span>
									</div>
									<select name="pelayanan_aa" class="form-control pel_aa inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>	
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_aa" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<span class="label_a" style="color:red;"></span>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_aa" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<!--B-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">B</span>
									</div>
									<select name="pelayanan_b" class="form-control pel_b inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_b" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_b" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_b" style="color:red;"></span>
						<!--C-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">C</span>
									</div>
									<select name="pelayanan_c" class="form-control pel_c inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_c" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_c" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_c" style="color:red;"></span>
						<!--D-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">D</span>
									</div>
									<select name="pelayanan_d" class="form-control pel_d inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_d" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_d" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_d" style="color:red;"></span>
						<!--E-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='E'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">E</span>
									</div>
									<select name="pelayanan_e" class="form-control pel_e inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_e" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_e" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_e" style="color:red;"></span>
						<!--F-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">F</span>
									</div>
									<select name="pelayanan_f" class="form-control pel_f inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_f" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_f" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_f" style="color:red;"></span>
						<!--G-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">G</span>
									</div>
									<select name="pelayanan_g" class="form-control pel_g inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_g" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_g" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_g" style="color:red;"></span>
						<!--H-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='H'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">H</span>
									</div>
									<select name="pelayanan_h" class="form-control pel_h inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_h" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_h" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_h" style="color:red;"></span>
						<!--I-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='I'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">I</span>
									</div>
									<select name="pelayanan_i" class="form-control pel_i inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_i" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_i" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_j" style="color:red;"></span>
						<!--J-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='J'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">J</span>
									</div>
									<select name="pelayanan_j" class="form-control pel_j inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_j" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>	
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_j" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_j" style="color:red;"></span>
						<!--K-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='K'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">K</span>
									</div>
									<select name="pelayanan_k" class="form-control pel_k inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_k" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_k" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_k" style="color:red;"></span>
						<!--L-->
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group">
									<?php
										$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='L'"));
									?>
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">L</span>
									</div>
									<select name="pelayanan_l" class="form-control pel_l inputan">
										<option value="">Pilih Layanan</option>
										<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
										<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
										<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
										<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
										<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
										<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
										<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
										<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
										<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
										<option value="KHUSUS 1" <?php if($dtpel['Pelayanan'] == 'KHUSUS 1'){echo "SELECTED";}?>>KHUSUS 1</option>
										<option value="KHUSUS 2" <?php if($dtpel['Pelayanan'] == 'KHUSUS 2'){echo "SELECTED";}?>>KHUSUS 2</option>
										<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
										<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
										<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
										<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
										<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
										<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
										<option value="PKG" <?php if($dtpel['Pelayanan'] == 'PKG'){echo "SELECTED";}?>>PKG</option>
										<option value="PRIORITAS" <?php if($dtpel['Pelayanan'] == 'PRIORITAS'){echo "SELECTED";}?>>PRIORITAS</option>
										<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
										<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
										<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
										<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
										<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
										<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
										<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_l" class="form-control inputan" placeholder="Jumlah Antrian" maxlength="3">
								</div>	
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Klaster'];?>" class="form-control inputan" readonly>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" value="<?php echo $dtpel['Keterangan'];?>" name="ket_l" class="form-control inputan" placeholder="Keterangan" maxlength="40">
								</div>
							</div>
						</div>
						<span class="label_l" style="color:red;"></span><hr/>
					
					<h4>Pelayanan Pustu</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											//$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='A'"));
										?>
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon3">A</span>
										</div>
										<select name="pelayanan_pustu_a" class="form-control pel_pustu_a">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
											<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
											<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
											<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
											<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
											<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
											<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
											<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
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
											//$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='B'"));
										?>
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon3">B</span>
										</div>
										<select name="pelayanan_pustu_b" class="form-control pel_pustu_b">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
											<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
											<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
											<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
											<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
											<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
											<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
											<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
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
											//$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='C'"));
										?>
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon3">C</span>
										</div>
										<select name="pelayanan_pustu_c" class="form-control pel_pustu_c">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
											<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
											<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
											<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
											<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
											<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
											<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
											<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
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
										<?php
											//$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='D'"));
										?>
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon3">D</span>
										</div>
										<select name="pelayanan_pustu_d" class="form-control pel_pustu_d">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
											<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
											<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
											<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
											<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
											<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
											<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
											<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
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
										<?php
											//$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='F'"));
										?>
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon3">E</span>
										</div>
										<select name="pelayanan_pustu_e" class="form-control pel_pustu_e">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
											<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
											<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
											<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
											<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
											<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
											<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
											<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_pustu_e" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
									</div>	
								</div>	
							</div>
							<span class="label_pustu_f" style="color:red;"></span>
							<div class="row">
								<div class="col-sm-8">
									<div class="input-group">
										<?php
											//$dtpel = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan_pustu` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodePelayanan`='G'"));
										?>
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon3">F</span>
										</div>
										<select name="pelayanan_pustu_f" class="form-control pel_pustu_f">
											<option value="">Pilih Layanan</option>
											<option value="ANAK" <?php if($dtpel['Pelayanan'] == 'ANAK'){echo "SELECTED";}?>>ANAK</option>
											<option value="BERSALIN" <?php if($dtpel['Pelayanan'] == 'BERSALIN'){echo "SELECTED";}?>>BERSALIN</option>
											<option value="CATIN" <?php if($dtpel['Pelayanan'] == 'CATIN'){echo "SELECTED";}?>>CATIN</option>
											<option value="CKG" <?php if($dtpel['Pelayanan'] == 'CKG'){echo "SELECTED";}?>>CKG</option>
											<option value="GIGI" <?php if($dtpel['Pelayanan'] == 'GIGI'){echo "SELECTED";}?>>GIGI</option>
											<option value="IMUNISASI" <?php if($dtpel['Pelayanan'] == 'IMUNISASI'){echo "SELECTED";}?>>IMUNISASI</option>
											<option value="INFEKSIUS" <?php if($dtpel['Pelayanan'] == 'INFEKSIUS'){echo "SELECTED";}?>>INFEKSIUS</option>
											<option value="KIA" <?php if($dtpel['Pelayanan'] == 'KIA'){echo "SELECTED";}?>>KIA</option>
											<option value="KB" <?php if($dtpel['Pelayanan'] == 'KB'){echo "SELECTED";}?>>KB</option>
											<option value="KIR SEHAT" <?php if($dtpel['Pelayanan'] == 'KIR SEHAT'){echo "SELECTED";}?>>KIR SEHAT</option>
											<option value="KONSELING" <?php if($dtpel['Pelayanan'] == 'KONSELING'){echo "SELECTED";}?>>KONSELING</option>
											<option value="KONTRI" <?php if($dtpel['Pelayanan'] == 'KONTRI'){echo "SELECTED";}?>>KONTRI</option>
											<option value="LANSIA" <?php if($dtpel['Pelayanan'] == 'LANSIA'){echo "SELECTED";}?>>LANSIA</option>	
											<option value="MTBS" <?php if($dtpel['Pelayanan'] == 'MTBS'){echo "SELECTED";}?>>MTBS</option>
											<option value="PDP" <?php if($dtpel['Pelayanan'] == 'PDP'){echo "SELECTED";}?>>PDP</option>
											<option value="PROLANIS" <?php if($dtpel['Pelayanan'] == 'PROLANIS'){echo "SELECTED";}?>>PROLANIS</option>
											<option value="RUJUKAN LANJUT" <?php if($dtpel['Pelayanan'] == 'RUJUKAN LANJUT'){echo "SELECTED";}?>>RUJUKAN LANJUT</option>
											<option value="TB DOTS" <?php if($dtpel['Pelayanan'] == 'TB DOTS'){echo "SELECTED";}?>>TB DOTS</option>
											<option value="UMUM" <?php if($dtpel['Pelayanan'] == 'UMUM'){echo "SELECTED";}?>>UMUM</option>
											<option value="UGD" <?php if($dtpel['Pelayanan'] == 'UGD'){echo "SELECTED";}?>>UGD</option>
											<option value="USG" <?php if($dtpel['Pelayanan'] == 'USG'){echo "SELECTED";}?>>USG</option>
											<option value="VAKSIN" <?php if($dtpel['Pelayanan'] == 'VAKSIN'){echo "SELECTED";}?>>VAKSIN</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<input type="text" value="<?php echo $dtpel['Jumlah'];?>" name="jml_pel_pustu_f" class="form-control" placeholder="Jumlah Antrian" maxlength="3">
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
					<h4>Vaksin</h4>
						<?php
							$arr_vaksin = explode(",",$datasetting['Vaksin']);
						?>
						<label class="form-check-label"><input type="checkbox" name="vaksin[]" value="1" <?php if(in_array("1", $arr_vaksin)){echo "CHECKED";}?>>Senin</label>
						<label class="form-check-label"><input type="checkbox" name="vaksin[]" value="2" <?php if(in_array("2", $arr_vaksin)){echo "CHECKED";}?>>Selasa</label>
						<label class="form-check-label"><input type="checkbox" name="vaksin[]" value="3" <?php if(in_array("3", $arr_vaksin)){echo "CHECKED";}?>>Rabu</label>
						<label class="form-check-label"><input type="checkbox" name="vaksin[]" value="4" <?php if(in_array("4", $arr_vaksin)){echo "CHECKED";}?>>Kamis</label>
						<label class="form-check-label"><input type="checkbox" name="vaksin[]" value="5" <?php if(in_array("5", $arr_vaksin)){echo "CHECKED";}?>>Jumat</label>
						<label class="form-check-label"><input type="checkbox" name="vaksin[]" value="6" <?php if(in_array("6", $arr_vaksin)){echo "CHECKED";}?>>Sabtu</label>
					<hr/>						
					<h4>Waktu Pelayanan</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-time"></span></span>
						<select name="waktupelayananbuka" class="form-control">
							<option value="">Pilih</option>
							<option value="05.00" <?php if($datasetting['WaktuPelayananBuka'] == '05.00'){echo 'SELECTED';}?>>05.00</option>
							<option value="05.30" <?php if($datasetting['WaktuPelayananBuka'] == '05.30'){echo 'SELECTED';}?>>05.30</option>
							<option value="06.00" <?php if($datasetting['WaktuPelayananBuka'] == '06.00'){echo 'SELECTED';}?>>06.00</option>
							<option value="06.30" <?php if($datasetting['WaktuPelayananBuka'] == '06.30'){echo 'SELECTED';}?>>06.30</option>
							<option value="06.45" <?php if($datasetting['WaktuPelayananBuka'] == '06.45'){echo 'SELECTED';}?>>06.45</option>
							<option value="07.00" <?php if($datasetting['WaktuPelayananBuka'] == '07.00'){echo 'SELECTED';}?>>07.00</option>
							<option value="07.15" <?php if($datasetting['WaktuPelayananBuka'] == '07.15'){echo 'SELECTED';}?>>07.15</option>
							<option value="07.30" <?php if($datasetting['WaktuPelayananBuka'] == '07.30'){echo 'SELECTED';}?>>07.30</option>
							<option value="08.00" <?php if($datasetting['WaktuPelayananBuka'] == '08.00'){echo 'SELECTED';}?>>08.00</option>
						</select>
						<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Jam Buka</span></div>
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
							<option value="13.00" <?php if($datasetting['WaktuPelayananTutup'] == '13.00'){echo 'SELECTED';}?>>13.00</option>
							<option value="23.00" <?php if($datasetting['WaktuPelayananTutup'] == '23.00'){echo 'SELECTED';}?>>23.00</option>
							<option value="23.59" <?php if($datasetting['WaktuPelayananTutup'] == '23.59'){echo 'SELECTED';}?>>23.59</option>
						</select>
						<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Jam Tutup</span></div>
					</div>
					<hr/>
					<h4>Tampilkan Antrian Pendaftaran (Etiket)</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-time"></span></span>
						<select name="tampilnoantrian" class="form-control">
							<option value="N" <?php if($datasetting['TampilNoAntrian'] == 'N'){echo 'SELECTED';}?>>TIDAK</option>
							<option value="Y" <?php if($datasetting['TampilNoAntrian'] == 'Y'){echo 'SELECTED';}?>>YA</option>
						</select>
						<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Antrian Pendaftaran</span></div>
					</div>
					<hr/>
					<h4>Running Text</h4>
					<div class="input-group">
							<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-pencil"></span></span>
							<textarea name="runningtext" class="form-control" placeholder="Silahkan ketikan informasi running text maks.150 digit" maxlength="200"><?php echo $datasetting['RunningText'];?></textarea>
							<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Running Text</span></div>
					</div>
					<hr/>
					<h4>Option Slide</h4>
					<div class="input-group">
						<span class="input-group-addon" style="background:#f5f5f5;border-color:#ddd;color:#444"><span class="glyphicon glyphicon-film"></span></span>
						<select name="statusslide" class="form-control">
							<option value="">Status Slide</option>
							<option value="gambar" <?php if($datasetting['StatusSlide'] == 'gambar'){echo 'SELECTED';}?>>Gambar</option>
							<option value="video" <?php if($datasetting['StatusSlide'] == 'video'){echo 'SELECTED';}?>>Video</option>
						</select>
					</div>
					<hr/>
					<h4>Image Slide (Pendaftaran)</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 1</span></div>
								<input type="file" name="gambar1" class="form-control gmbrinput">
								<input type="hidden" name="namegambar1" value="<?php echo $datasetting['Image1'];?>">
								<?php if($datasetting['Image1'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image1'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 2</span></div>
								<input type="file"  name="gambar2" class="form-control gmbrinput">
								<input type="hidden" name="namegambar2" value="<?php echo $datasetting['Image2'];?>">
								<?php if($datasetting['Image2'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image2'];?>" width="150px">
								<?php } ?>
							</div>	
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 3</span></div>
								<input type="file"  name="gambar3" class="form-control">
								<input type="hidden" name="namegambar3" value="<?php echo $datasetting['Image3'];?>">
								<?php if($datasetting['Image3'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image3'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 4</span></div>
								<input type="file"  name="gambar4" class="form-control">
								<input type="hidden" name="namegambar4" value="<?php echo $datasetting['Image4'];?>">
								<?php if($datasetting['Image4'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image4'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 5</span></div>
								<input type="file"  name="gambar5" class="form-control">
								<input type="hidden" name="namegambar5" value="<?php echo $datasetting['Image5'];?>">
								<?php if($datasetting['Image5'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image5'];?>" width="150px">
								<?php } ?>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 6</span></div>
								<input type="file"  name="gambar6" class="form-control">
								<input type="hidden" name="namegambar6" value="<?php echo $datasetting['Image6'];?>">
								<?php if($datasetting['Image6'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image6'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 7</span></div>
								<input type="file"  name="gambar7" class="form-control">
								<input type="hidden" name="namegambar7" value="<?php echo $datasetting['Image7'];?>">
								<?php if($datasetting['Image7'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image7'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 8</span></div>
								<input type="file"  name="gambar8" class="form-control">
								<input type="hidden" name="namegambar8" value="<?php echo $datasetting['Image8'];?>">
								<?php if($datasetting['Image8'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image8'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 9</span></div>
								<input type="file"  name="gambar8" class="form-control">
								<input type="hidden" name="namegambar9" value="<?php echo $datasetting['Image9'];?>">
								<?php if($datasetting['Image9'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image9'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 10</span></div>
								<input type="file"  name="gambar10" class="form-control">
								<input type="hidden" name="namegambar10" value="<?php echo $datasetting['Image10'];?>">
								<?php if($datasetting['Image10'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image10'];?>" width="150px">
								<?php } ?>
							</div>
						</div>
					</div>
					<hr/>
					<h4>Image Slide (Farmasi)</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 1</span></div>
								<input type="file" name="gambar1_farmasi" class="form-control gmbrinput">
								<input type="hidden" name="namegambar1_farmasi" value="<?php echo $datasetting['Image1_Farmasi'];?>">
								<?php if($datasetting['Image1_Farmasi'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image1_Farmasi'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 2</span></div>
								<input type="file"  name="gambar2_farmasi" class="form-control gmbrinput">
								<input type="hidden" name="namegambar2_farmasi" value="<?php echo $datasetting['Image2_Farmasi'];?>">
								<?php if($datasetting['Image2_Farmasi'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image2_Farmasi'];?>" width="150px">
								<?php } ?>
							</div>	
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 3</span></div>
								<input type="file"  name="gambar3_farmasi" class="form-control">
								<input type="hidden" name="namegambar3_farmasi" value="<?php echo $datasetting['Image3_Farmasi'];?>">
								<?php if($datasetting['Image3_Farmasi'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image3_Farmasi'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 4</span></div>
								<input type="file"  name="gambar4_farmasi" class="form-control">
								<input type="hidden" name="namegambar4_farmasi" value="<?php echo $datasetting['Image4_Farmasi'];?>">
								<?php if($datasetting['Image4_Farmasi'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image4_Farmasi'];?>" width="150px">
								<?php } ?>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Img 5</span></div>
								<input type="file"  name="gambar5_farmasi" class="form-control">
								<input type="hidden" name="namegambar5_farmasi" value="<?php echo $datasetting['Image5_Farmasi'];?>">
								<?php if($datasetting['Image5_Farmasi'] != ''){?>
								<img src="antrian/image/<?php echo $datasetting['Image5_Farmasi'];?>" width="150px">
								<?php } ?>
							</div>
						</div>
					</div>					
					<hr/>
					<h4>Video</h4>
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">Video</span></div>
						<input type="file"  name="video" class="form-control">
						<input type="hidden" name="namevideo" value="<?php echo $datasetting['Video1'];?>">
						<video width="180px" loop="true" controls="controls">
							<source src="antrian/video/<?php echo $datasetting['Video1'];?>" type="video/mp4">
						</video>
					</div><hr/>
					<button class="btn btn-round btn-success btnsimpan" name="btn" value="simpan" type="submit">SIMPAN</button>
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
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_k = $(".pel_l").val();
	if(pel_a == pel_b || pel_a == pel_c || pel_a == pel_d || pel_a == pel_e || pel_a == pel_f || pel_a == pel_g || pel_a == pel_h || pel_a == pel_i || pel_a == pel_j || pel_a == pel_k || pel_a == pel_l){
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
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_b == pel_a || pel_b == pel_c || pel_b == pel_d || pel_b == pel_e || pel_b == pel_f || pel_b == pel_g || pel_b == pel_h || pel_b == pel_i || pel_b == pel_j || pel_b == pel_k || pel_a == pel_l){
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
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_c == pel_a || pel_c == pel_b || pel_c == pel_d || pel_c == pel_e || pel_c == pel_f || pel_c == pel_g || pel_c == pel_h || pel_c == pel_i || pel_c == pel_j || pel_c == pel_k || pel_a == pel_l){
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
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_d == pel_a || pel_d == pel_b || pel_d == pel_c || pel_d == pel_e || pel_d == pel_f || pel_d == pel_g || pel_d == pel_h || pel_d == pel_i || pel_d == pel_j || pel_d == pel_k || pel_a == pel_l){
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
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_e == pel_a || pel_e == pel_b || pel_e == pel_c || pel_e == pel_d || pel_e == pel_f || pel_e == pel_g || pel_e == pel_h || pel_e == pel_i || pel_e == pel_j || pel_e == pel_k || pel_a == pel_l){
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
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_f == pel_a || pel_f == pel_b || pel_f == pel_c || pel_f == pel_d || pel_f == pel_e || pel_f == pel_g || pel_f == pel_h || pel_f == pel_i || pel_f == pel_j || pel_f == pel_k || pel_a == pel_l){
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
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_g == pel_a || pel_g == pel_b || pel_g == pel_c || pel_g == pel_d || pel_g == pel_e || pel_g == pel_f || pel_g == pel_h || pel_g == pel_i || pel_g == pel_j || pel_g == pel_k || pel_a == pel_l){
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
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_h == pel_a || pel_h == pel_b || pel_h == pel_c || pel_h == pel_d || pel_h == pel_e || pel_h == pel_f || pel_h == pel_g || pel_h == pel_i || pel_h == pel_j || pel_h == pel_k || pel_a == pel_l){
		$(".label_h").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_h").html("");
	}
});
$(".pel_i").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	var pel_i = $(this).val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_i == pel_a || pel_i == pel_b || pel_i == pel_c || pel_i == pel_d || pel_i == pel_e || pel_i == pel_f || pel_i == pel_g || pel_i == pel_h || pel_i == pel_j || pel_i == pel_k || pel_a == pel_l){
		$(".label_i").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_i").html("");
	}
});
$(".pel_j").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	var pel_i = $(".pel_i").val();
	var pel_j = $(this).val();	
	var pel_k = $(".pel_k").val();
	var pel_l = $(".pel_l").val();
	if(pel_j == pel_a || pel_j == pel_b || pel_j == pel_c || pel_j == pel_d || pel_j == pel_e || pel_j == pel_f || pel_j == pel_g || pel_j == pel_h || pel_j == pel_i || pel_j == pel_k || pel_a == pel_l){
		$(".label_j").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_j").html("");
	}
});
$(".pel_k").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(this).val();
	var pel_l = $(".pel_l").val();
	if(pel_k == pel_a || pel_k == pel_b || pel_k == pel_c || pel_k == pel_d || pel_k == pel_e || pel_k == pel_f || pel_k == pel_g || pel_k == pel_h || pel_k == pel_i || pel_k == pel_j || pel_a == pel_l){
		$(".label_k").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_k").html("");
	}
});
$(".pel_l").change(function(){
	var pel_a = $(".pel_a").val();
	var pel_b = $(".pel_b").val();
	var pel_c = $(".pel_c").val();
	var pel_d = $(".pel_d").val();
	var pel_e = $(".pel_e").val();
	var pel_f = $(".pel_f").val();
	var pel_g = $(".pel_g").val();
	var pel_h = $(".pel_h").val();
	var pel_i = $(".pel_i").val();
	var pel_j = $(".pel_j").val();
	var pel_k = $(".pel_k").val();
	var pel_l = $(this).val();
	if(pel_l == pel_a || pel_l == pel_b || pel_l == pel_c || pel_l == pel_d || pel_l == pel_e || pel_l == pel_f || pel_l == pel_g || pel_l == pel_h || pel_l == pel_i || pel_l == pel_j || pel_l == pel_k){
		$(".label_l").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_l").html("");
	}
});
$(".pel_pustu_a").change(function(){
	var pel_pustu_a = $(this).val();
	var pel_pustu_b = $(".pel_pustu_b").val();
	var pel_pustu_c = $(".pel_pustu_c").val();
	var pel_pustu_d = $(".pel_pustu_d").val();
	var pel_pustu_e = $(".pel_pustu_e").val();
	var pel_pustu_f = $(".pel_pustu_f").val();
	if(pel_pustu_a == pel_pustu_b || pel_pustu_a == pel_pustu_c || pel_pustu_a == pel_pustu_d || pel_pustu_a == pel_pustu_e || pel_pustu_a == pel_pustu_f){
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
	if(pel_pustu_b == pel_pustu_a || pel_pustu_b == pel_pustu_c || pel_pustu_b == pel_pustu_d || pel_pustu_b == pel_pustu_e || pel_pustu_b == pel_pustu_f){
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
	if(pel_pustu_c == pel_pustu_a || pel_pustu_c == pel_pustu_b || pel_pustu_c == pel_pustu_d || pel_pustu_c == pel_pustu_e || pel_pustu_c == pel_pustu_f){
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
	if(pel_pustu_d == pel_pustu_a || pel_pustu_d == pel_pustu_b || pel_pustu_d == pel_pustu_c || pel_pustu_d == pel_pustu_e || pel_pustu_d == pel_pustu_f){
		$(".label_pustu_d").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_d").html("");
	}
});
$(".pel_pustu_e").change(function(){
	var pel_pustu_a = $(".pel_pustu_a").val();
	var pel_pustu_b = $(".pel_pustu_b").val();
	var pel_pustu_c = $(".pel_pustu_c").val();
	var pel_pustu_d = $(".pel_pustu_d").val();
	var pel_pustu_e = $(this).val();
	var pel_pustu_f = $(".pel_pustu_f").val();
	if(pel_pustu_e == pel_pustu_a || pel_pustu_e == pel_pustu_b || pel_pustu_e == pel_pustu_c || pel_pustu_e == pel_pustu_d || pel_pustu_e == pel_pustu_f){
		$(".label_pustu_e").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_e").html("");
	}
});
$(".pel_pustu_f").change(function(){
	var pel_pustu_a = $(".pel_pustu_a").val();
	var pel_pustu_b = $(".pel_pustu_b").val();
	var pel_pustu_c = $(".pel_pustu_c").val();
	var pel_pustu_d = $(".pel_pustu_d").val();
	var pel_pustu_e = $(".pel_pustu_e").val();
	var pel_pustu_f = $(this).val();
	if(pel_pustu_f == pel_pustu_a || pel_pustu_f == pel_pustu_b || pel_pustu_f == pel_pustu_c || pel_pustu_f == pel_pustu_d || pel_pustu_f == pel_pustu_e){
		$(".label_pustu_f").html("Pelayanan sudah ada...");
		$(this).val("");
	}else{
		$(".label_pustu_f").html("");
	}
});
</script>