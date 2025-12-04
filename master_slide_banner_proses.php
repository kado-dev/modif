<?php
	include "config/koneksi.php";
	
	// image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type = $var_file['type']; // type file
	$size = $var_file['size']; // ukuran file
	$tmp = $var_file['tmp_name']; // sumber file
	$namaimg = date('Ymdgis').".".$ext; // proses penamaan file foto	
	
	$str = "INSERT INTO `tbbanner` (`Banner`) VALUES ('$namaimg')";
	$query=mysqli_query($koneksi,$str);	
	// echo var_dump($str);
	// die();	
	
	if($query){	
		if($nama_file != ''){
			copy($tmp,'image/banner/'.$namaimg);
			unlink('./image/banner/'.$fotolama);
		}
		// die();
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_slide_banner';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_slide_banner';";
		echo "</script>";
	} 	
?>