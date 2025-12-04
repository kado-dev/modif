<?php
	error_reporting(1);
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$nip = $_POST['nip'];
	$namadokter1 = mysqli_real_escape_string($koneksi, $_POST['namapegawai']);
	$namapegawai = strtoupper($namadokter1);
	$password = md5($_POST['password']);
	$ttepin = md5($_POST['ttepin']);
	$status = $_POST['status'];
	$otoritas = $_POST['otoritas'];
	$alamat = strtoupper($_POST['alamat']);
	$telepon = $_POST['telepon'];
	$kodepuskesmas = $_POST['puskesmas'];
	
	// image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name'];
	if($nama_file != null){
		 // nama file asli
		$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
		$type = $var_file['type']; // type file
		$size = $var_file['size']; // ukuran file
		$tmp = $var_file['tmp_name']; // sumber file
		$namaimg = date('Ymdgis').".".$ext; 
	}else{
		$namaimg = '';
	}	
	
	if($otoritas == null){
		$otr = ""; 
	}else{
		$otr = implode(",",$otoritas); 
	}
	

	//--cek jika sudah ada hapus--//
	$str_pegawai = "select `Nip` from `tbpegawai` where `Nip` ='$nip'";
	$query_pegawai = mysqli_query($koneksi,$str_pegawai);
	$data_pegawai = mysqli_fetch_assoc($query_pegawai);
	
	if ($data_pegawai['Nip'] == "$nip"){
		$str1 = "DELETE FROM `tbpegawai` WHERE `Nip` = '$nip'";
		$query1 = mysqli_query($koneksi,$str1);
	}
	
	$loket = $_POST['loket'];
	$lantai = $_POST['lantai'];
	$poli = json_encode($_POST['poli']);
	$statuspustu = json_encode($_POST['statuspustu']);
	// tbpegawai
	$str = "INSERT INTO `tbpegawai`(`Nip`, `NamaPegawai`, `Password`, `Status`, `Otoritas`, `Alamat`, `Telepon`, `KodePuskesmas`, `Foto`, `Loket`, `Poli`, `Lantai`,`StatusPustu`,`TtePin`)
	VALUES ('$nip','$namapegawai','$password','$status','$otr','$alamat','$telepon','$kodepuskesmas','$namaimg','$loket','$poli','$lantai','$statuspustu','$ttepin')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);
	
	
	if($query){	
		if($nama_file != null){
			copy($tmp,'image/'.$namaimg);//proses copy
		}
		alert_swal('sukses','Data berhasil disimpan');
		echo "<script>";
		//echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_pegawai&id=$nip';";
		echo "</script>";
	}else{
		alert_swal('gagal','Data gagal disimpan');
		echo "<script>";
		//echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_pegawai&id=$nip';";
		echo "</script>";
	} 	
?>