<?php
if($_POST['btn'] == 'simpan'){
	$poligigi = $_POST['jmlpoligigi'];
	$poliumum = $_POST['jmlpoliumum'];
	$waktupelayanan = $_POST['waktupelayanan'];
	$statusslide = $_POST['statusslide'];
	$versi = $_POST['versi'];
	mysqli_query($koneksi,"UPDATE tbantrian_setting SET PoliGigi = '$poligigi', PoliUmum = '$poliumum', WaktuPelayanan = '$waktupelayanan', StatusSlide = '$statusslide', versi_antrian = '$versi' WHERE KodePuskesmas = '$kodepuskesmas'");

	$img1 = $_FILES['gambar1'];
	$nama_img1 = $img1['name']; // nama file asli
	if($nama_img1 != ''){
		$ext = pathinfo($nama_img1, PATHINFO_EXTENSION); // proses mendapatkan extensi file
		$tmp = $img1['tmp_name']; // tmp file
		$image1 = "slide1".date('ymdgis').".".$ext; // proses penamaan file foto
		copy($tmp,"image/".$image1);
		$namafoto1 = $_POST['namegambar1'];
		if($namafoto1 != ''){
			if(file_exists("image/".$namafoto1)){
			unlink("image/".$namafoto1);
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
		copy($tmp,"image/".$image2);
		$namafoto2 = $_POST['namegambar2'];
		if($namafoto2 != ''){
			if(file_exists("image/".$namafoto2)){
			unlink("image/".$namafoto2);
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
		copy($tmp,"image/".$image3);
		$namafoto3 = $_POST['namegambar3'];
		if($namafoto3 != ''){
			if(file_exists("image/".$namafoto3)){
			unlink("image/".$namafoto3);
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
		copy($tmp,"image/".$image4);
		$namafoto4 = $_POST['namegambar4'];
		if($namafoto4 != ''){
			if(file_exists("image/".$namafoto4)){
			unlink("image/".$namafoto4);
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
		copy($tmp,"image/".$image5);
		$namafoto5 = $_POST['namegambar5'];
		if($namafoto5 != ''){
			if(file_exists("image/".$namafoto5)){
			unlink("image/".$namafoto5);
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
		copy($tmp,"image/".$image6);
		$namafoto6 = $_POST['namegambar6'];
		if($namafoto6 != ''){
			if(file_exists("image/".$namafoto6)){
			unlink("image/".$namafoto6);
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
		copy($tmp,"image/".$image7);
		$namafoto7 = $_POST['namegambar7'];
		if($namafoto7 != ''){
			if(file_exists("image/".$namafoto7)){
			unlink("image/".$namafoto7);
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
		copy($tmp,"image/".$image8);
		$namafoto8 = $_POST['namegambar8'];
		if($namafoto8 != ''){
			if(file_exists("image/".$namafoto8)){
			unlink("image/".$namafoto8);
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
		copy($tmp,"image/".$image9);
		$namafoto9 = $_POST['namegambar9'];
		if($namafoto9 != ''){
			if(file_exists("image/".$namafoto9)){
			unlink("image/".$namafoto9);
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
		copy($tmp,"image/".$image10);
		$namafoto10 = $_POST['namegambar10'];
		if($namafoto10 != ''){
			if(file_exists("image/".$namafoto10)){
			unlink("image/".$namafoto10);
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
			copy($tmp,"video/".$videoname);
			$namavideo = $_POST['namevideo'];
			if($namavideo != ''){
				if(file_exists("image/".$namavideo)){
				unlink("video/".$namavideo);
				}
			}
			//echo "UPDATE tbantrian_setting SET Video1 = '$videoname' WHERE KodePuskesmas = '$kodepuskesmas'";
			//die();
			mysqli_query($koneksi,"UPDATE tbantrian_setting SET Video1 = '$videoname' WHERE KodePuskesmas = '$kodepuskesmas'");
		}
	}

	//header("location:'index.php'");
	echo "<script>";
	echo "window.location='index.php';";
	echo "</script>";
}

$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbantrian_setting WHERE KodePuskesmas = '$kodepuskesmas'"));
$cek_tbview_antrianfarmasi = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbantrian_farmasi_view where KodePuskesmas = '$kodepuskesmas'"));						
?>
<style>
	.radio a{
		display:block;
		text-align:center;
		padding-top:0px;
		padding-bottom: 15px;
		font-family: Poppins;
		font-size: 15px;
		text-decoration: none;
		color: #507257;
	}
	.radio a:hover{
		text-decoration:none;
		color: #26a543;
	}
	.btnsimpan{
		display: block;
		width: 100%;
		background-color: #08c999;
		border: none;
		color: #fff;
		padding: 12px 30px;
		cursor: pointer;
		font-size: 18px;
		font-family: "Poppins", sans-serif;
		border-radius: 5px;
		transition: all 0.2s;
		text-align: center;
	}
	.btnsimpan:hover{
		color:#fff;
		background-color:#3ceabc;
	}
	.customntf{
		color: #fff;
		background: red;
		border-radius: 7px;
		font-size: 12px;
		position: absolute;top:10px;right: 20px;padding:1px 6px;
	}
</style>
<div class="antrianshtml">
	<div class="col-md-12" style="padding-top:25px;">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">	
				<div class="row">
					<!-- <div class="col-sm-6">
						<div class="menubawah">
							<label id="btnmenupustu" class="radio alert alertmenu">
								<a href="#">
								Antrian Pustu
								</a>
							</label>
						</div>
					</div> -->
					<div class="col-sm-12">
						<div class="menubawah">
							<label id="btnmenu" class="radio alert alertmenu">
								<a href="#">
								Antrian Puskesmas
								</a>
							</label>
						</div>	
					</div>
					<!-- <div class="col-sm-3">
						<div class="menubawah">
							<label class="radio alert alertmenu">
								<a href="../anjunganpasien" target="_blank">
								Daftar Mandiri
								</a>
							</label>
						</div>	
					</div>
					<div class="col-sm-3">
						<div class="menubawah">
							<label class="radio alert alertmenu">
								<a href="index.php?page=kuesioner" target="_blank">
								SKM Online
								</a>
							</label>
						</div>	
					</div> -->
				</div>	
			</div>		
		</div>
		<div class="row menu" style="display: none;">
			<div class="col-sm-offset-1 col-sm-10">
				<div class='menubawah'>
					<div class="row">
						<div class="col-sm-12">
							<label class="radio alert alertsubmenu">
								<a href="index.php" target="_blank">
								Antrian Pasien
								</a>
							</label>				
						</div>	
						<div class="col-sm-3">
							<label class="radio alert alertsubmenu">
								<a href="view_antrian_pendaftaran.php" target="_blank">
								View Antrian Pendaftaran
								</a>
							</label>
						</div>
						<div class="col-sm-3">
							<label class="radio alert alertsubmenu">
								<a href="view_antrian_pendaftaran_v2.php" target="_blank">
								View Antrian Pendaftaran V2
								</a>
							</label>
						</div>
						<div class="col-sm-3">
							<label class="radio alert alertsubmenu">
								<a href="view_antrian_poli.php" target="_blank">
								View Antrian Pelayanan
								</a>
							</label>
						</div>
						<div class="col-sm-3">
							<label class="radio alert alertsubmenu">
								<a href="view_antrian_poli_v2.php" target="_blank">
								View Antrian Pelayanan V2
								</a>
							</label>
						</div>
						<div class="col-sm-12">
							<label class="radio alert alertsubmenu">
								<?php
									if($cek_tbview_antrianfarmasi > 0){
								?>
								<a href="index.php?page=antrian_farmasi" target="_blank">
								Antrian Farmasi
								<span class="customntf">custom</span>
								</a>
								<?php
									}else{
								?>
									<a href="#" onclick="alert('Silahkan upgrade ke layanan custom')">
									Antrian Farmasi
									<span class="customntf">custom</span>
									</a>
								<?php
									}
								?>
							</label>
						</div>	
						<div class="col-sm-12">
							<label class="radio alert alertsubmenu">
								<?php
									if($cek_tbview_antrianfarmasi > 0){
								?>
								<a href="view_antrian_farmasi.php" target="_blank">
								View Antrian Farmasi
								<span class="customntf">custom</span>
								</a>
								<?php
									}else{
								?>
									<a href="#" onclick="alert('Silahkan upgrade ke layanan custom')">
									View Antrian Farmasi
									<span class="customntf">custom</span>
									</a>
								<?php
									}
								?>
							</label>
						</div>
						
					</div>
				</div>	
			</div>
		</div>	
		<div class="row menupustu" style="display: none;">
			<div class="col-sm-offset-1 col-sm-10">
				<div class='menubawah'>
					<div class="row">
						<div class="col-sm-6">
							<label class="radio alert alertsubmenu">
								<a href="index.php?page=pilih_poli_pustu" target="_blank">
								Antrian Pasien
								</a>
							</label>				
						</div>			
						<div class="col-sm-6">
							<label class="radio alert alertsubmenu">
								<a href="view_antrian_pendaftaran_pustu.php" target="_blank">
								View Antrian Pendaftaran
								</a>
							</label>

						</div>
						
					</div>
				</div>	
			</div>
		</div>
		<div class="row">	
			<div class="col-sm-offset-1 col-sm-10" style="padding-top: 15px">
				<?php
				if($kodepuskesmas != null){
				?>
				<a href="logout.php" class="btnsimpan" style="text-decoration:none;"> Logout</a>
				<?php
				}
				?>
			
			</div>	
		</div>
	</div>
</div>

<script src="../assets/js/jquery.js"></script>
<script type="text/javascript">
	$("#btnmenu").click(function(){
		$(".menupustu").hide();
		$(".menu").slideToggle();
	});
	$("#btnmenupustu").click(function(){
		$(".menu").hide();
		$(".menupustu").slideToggle();
	});
</script>