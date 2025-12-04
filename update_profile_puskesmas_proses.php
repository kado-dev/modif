<?php
	session_start();
	include "config/koneksi.php";
	$kodepuskesmas = $_POST['kodepuskesmas'];
	$namapuskesmas = strtoupper($_POST['namapuskesmas']);
	$alamat = strtoupper($_POST['alamat']);
	$kelurahan =strtoupper( $_POST['kelurahan']);
	$kecamatan = strtoupper($_POST['kecamatan']);
	$telepon = $_POST['telepon'];
	$kepalapuskesmas = strtoupper($_POST['kepalapuskesmas']);
	$apoteker = strtoupper($_POST['apoteker']);
	$sipa = strtoupper($_POST['sipa']);
	$long = $_POST['long'];
	$lat = $_POST['lat'];
	$fotolama = $_POST['fotolama'];
		
	//image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type = $var_file['type']; // type file
	$size = $var_file['size']; // ukuran file
	$tmp = $var_file['tmp_name']; // sumber file
	$namaimg = date('Ymdgis').".".$ext; // proses penamaan file foto		
	

	// update tbpuskesmas
	$str = "UPDATE `tbpuskesmas` SET `NamaPuskesmas`='$namapuskesmas',`Alamat`='$alamat',`Kelurahan`='$kelurahan',`Kecamatan`='$kecamatan',`Telepon`='$telepon',`KepalaPuskesmas`='$kepalapuskesmas',`Apoteker`='$apoteker',`Sipa`='$sipa',`Long` ='$long',`Lat`='$lat',`Img`='$namaimg' WHERE `KodePuskesmas`='$kodepuskesmas'";
	// echo $str;
	// die();	
	$query=mysqli_query($koneksi,$str);	
	
	if($query){	
		if($nama_file != ''){
			copy($tmp,'image/puskesmas/'.$namaimg);
			$_SESSION['foto_puskesmas']=$namaimg;
			unlink('./image/puskesmas/'.$fotolama);
		}
		// die();
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=update_profile_puskesmas';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=update_profile_puskesmas';";
		echo "</script>";
	} 	
?>