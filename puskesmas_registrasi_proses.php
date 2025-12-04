<?php
include "config/koneksi.php";
	$kodepuskesmas = $_POST['kodepuskesmas'];
	$namapuskesmas = $_POST['namapuskesmas'];
	$alamat = $_POST['alamat'];
	$telepon = $_POST['telepon'];
	$hp = $_POST['hp'];
	$email = $_POST['email'];
	$kepalapuskesmas = $_POST['kepalapuskesmas'];
	$nip = $_POST['nip'];
	$long = "-";
	$lat = "-";
	
	//image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type = $var_file['type']; // type file
	$size = $var_file['size']; // ukuran file
	$tmp = $var_file['tmp_name']; // sumber file
	$namaimg = "imgpuskesmas_".$kodepuskesmas.".".$ext; // proses penamaan file foto	
	
	//--tbpuskesmasregistrasi--//
	$str = "INSERT INTO `tbpuskesmasregistrasi`(`KodePuskesmas`, `NamaPuskesmas`, `Alamat`, `Telepon`, `HP`, `email`, `KepalaPuskesmas`, `Nip`, `Long`, `Lat`, `Img`)
	VALUES ('$kodepuskesmas','$namapuskesmas','$alamat','$telepon','$hp','$email','$kepalapuskesmas','$nip','$long','$lat','$namaimg')";
	$query=mysqli_query($koneksi,$str);
	
	// echo var_dump($str);
	// die();
	
	if($query){	
		copy($tmp,'image/'.$namaimg);//proses copy
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		// echo "document.location.href='index.php?page=master_puskesmas&id=$idpuskesmas';";
		echo "document.location.href='puskesmas_registrasi_lihat.php?id=$kodepuskesmas';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='puskesmas_registrasi.php';";
		echo "</script>";
	} 	
?>