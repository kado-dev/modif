<?php
		session_start();
	include "config/koneksi.php";
	$idpegawai = $_SESSION['idpegawai'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$nip = $_POST['nip'];
	$sip = $_POST['sip'];
	$fotolama = $_POST['fotolama'];
	$namapegawai = strtoupper($_POST['namapegawai']);
	$namapegawailama = strtoupper($_POST['namapegawailama']);
	$passwordlama = ($_POST['password']);
	$password = md5($_POST['password']);
	$alamat = strtoupper($_POST['alamat']);
	$telepon = $_POST['telepon'];
	$lantai = $_POST['lantai'];
	$poli = json_encode($_POST['poli']);
	
	// image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type = $var_file['type']; // type file
	$size = $var_file['size']; // ukuran file
	$tmp = $var_file['tmp_name']; // sumber file
	$namaimg = date('Ymdgis').".".$ext; // proses penamaan file foto		
	
	// tahap 1, update tbpegawai
	if($passwordlama == ''){
		$str = "UPDATE `tbpegawai` 
		SET `Nip`='$nip',`Sip`='$sip',`NamaPegawai`='$namapegawai',`Alamat`='$alamat',`Telepon`='$telepon',`Poli`='$poli',`Lantai`='$lantai',`Foto`='$namaimg'
		WHERE `IdPegawai`='$idpegawai'";
	}else{
		$str = "UPDATE `tbpegawai` 
		SET `Nip`='$nip',`Sip`='$sip',`NamaPegawai`='$namapegawai',`Alamat`='$alamat',`Telepon`='$telepon',`Poli`='$poli',`Lantai`='$lantai',`Password` = '$password',`Foto`='$namaimg'
		WHERE `IdPegawai`='$idpegawai'";
	}
	$query = mysqli_query($koneksi,$str);
	// echo $str;
	// die();
	
	// tahap 2, update tbpasienperpegawai
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	$str_pendaftaran = "UPDATE `$tbpasienperpegawai` SET `Pendaftaran`='$namapegawai' WHERE `Pendaftaran`='$namapegawailama'";
	mysqli_query($koneksi,$str_pendaftaran);
	
	$str_namapegawai1 = "UPDATE `$tbpasienperpegawai` SET `NamaPegawai1`='$namapegawai' WHERE `NamaPegawai1`='$namapegawailama'";
	mysqli_query($koneksi,$str_namapegawai1);
	
	$str_namapegawai2 = "UPDATE `$tbpasienperpegawai` SET `NamaPegawai2`='$namapegawai' WHERE `NamaPegawai2`='$namapegawailama'";
	mysqli_query($koneksi,$str_namapegawai2);
	
	$str_namapegawai3 = "UPDATE `$tbpasienperpegawai` SET `NamaPegawai3`='$namapegawai' WHERE `NamaPegawai3`='$namapegawailama'";
	mysqli_query($koneksi,$str_namapegawai3);
	
	$str_namapegawai4 = "UPDATE `$tbpasienperpegawai` SET `NamaPegawai4`='$namapegawai' WHERE `NamaPegawai4`='$namapegawailama'";
	mysqli_query($koneksi,$str_namapegawai4);
	
	$str_namapegawai5 = "UPDATE `$tbpasienperpegawai` SET `NamaPegawai5`='$namapegawai' WHERE `NamaPegawai5`='$namapegawailama'";
	mysqli_query($koneksi,$str_namapegawai5);
	
	
	if($query){	
		if($nama_file != ''){
			copy($tmp,'image/pegawai/'.$namaimg);
			$_SESSION['foto_petugas']=$namaimg;
			unlink('./image/pegawai/'.$fotolama);
		}
		// die();
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=update_profile';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=update_profile';";
		echo "</script>";
	} 	
?>