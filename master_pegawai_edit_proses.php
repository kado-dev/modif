<?php
	error_reporting(1);
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$idpegawai = $_POST['idpegawai'];
	$nip = $_POST['nip'];
	$sip = $_POST['sip'];
	$namadokter1 = mysqli_real_escape_string($koneksi, $_POST['namapegawai']);
	$namapegawai = strtoupper($namadokter1);
	$namapegawailama = strtoupper($_POST['namapegawailama']);
	$passwordlama = ($_POST['password']);
	$password = md5($_POST['password']);
	$ttepin = md5($_POST['ttepin']);
	$otoritas_session = explode(',',$_SESSION['otoritas']);	
	if(in_array("OPERATOR", $otoritas_session) || in_array("PROGRAMMER", $otoritas_session) || in_array("ADMINISTRATOR", $otoritas_session)){
		$status = $_POST['status'];
		$otoritas = $_POST['otoritas'];
		if($otoritas == null){
			$otr = ""; 
		}else{
			$otr = implode(",",$otoritas); 
		}
	}

	$alamat = strtoupper($_POST['alamat']);
	$telepon = $_POST['telepon'];
	$kodepuskesmas = $_POST['puskesmas'];
	$loket = $_POST['loket'];
	$lantai = $_POST['lantai'];
	$poli = json_encode($_POST['poli']);
	$statuspustu = json_encode($_POST['statuspustu']);

	// image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	if($nama_file != null){
		$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
		$type = $var_file['type']; // type file
		$size = $var_file['size']; // ukuran file
		$tmp = $var_file['tmp_name']; // sumber file
		$namaimg = date('Ymdgis').".".$ext; // proses penamaan file foto
	}else{
		$namaimg = $_POST['fotolama'];
	}
	
	// tahap 1, update tbpegawai
	if(in_array("OPERATOR", $otoritas_session) || in_array("PROGRAMMER", $otoritas_session) || in_array("ADMINISTRATOR", $otoritas_session)){
		if($passwordlama == ''){
			$str = "UPDATE `tbpegawai` SET `Nip`='$nip',`Sip`='$sip',`NamaPegawai`='$namapegawai',`Status`='$status',`Otoritas`='$otr',
			`Alamat`='$alamat',`Telepon`='$telepon',`KodePuskesmas`='$kodepuskesmas',`Foto`='$namaimg', `Loket` = '$loket', `Poli` = '$poli', `Lantai` = '$lantai', `StatusPustu` = '$statuspustu', `TtePin`='$ttepin' WHERE `IdPegawai`='$idpegawai'";
		}else{
			$str = "UPDATE `tbpegawai` SET `Nip`='$nip',`Sip`='$sip',`NamaPegawai`='$namapegawai',`Status`='$status',`Otoritas`='$otr',
			`Alamat`='$alamat',`Telepon`='$telepon',`KodePuskesmas`='$kodepuskesmas', `Password` = '$password',`Foto`='$namaimg', `Loket` = '$loket', `Poli` = '$poli', `Lantai` = '$lantai', `StatusPustu` = '$statuspustu', `TtePin`='$ttepin'  WHERE `IdPegawai`='$idpegawai'";
		}
	}else{
		if($passwordlama == ''){
			$str = "UPDATE `tbpegawai` SET `Nip`='$nip',`Sip`='$sip',`NamaPegawai`='$namapegawai',`Status`='$status',
			`Alamat`='$alamat',`Telepon`='$telepon',`KodePuskesmas`='$kodepuskesmas',`Foto`='$namaimg', `Loket` = '$loket', `Poli` = '$poli', `Lantai` = '$lantai', `StatusPustu` = '$statuspustu', `TtePin`='$ttepin' WHERE `IdPegawai`='$idpegawai'";
		}else{
			$str = "UPDATE `tbpegawai` SET `Nip`='$nip',`Sip`='$sip',`NamaPegawai`='$namapegawai',`Status`='$status',
			`Alamat`='$alamat',`Telepon`='$telepon',`KodePuskesmas`='$kodepuskesmas', `Password` = '$password',`Foto`='$namaimg', `Loket` = '$loket', `Poli` = '$poli', `Lantai` = '$lantai', `StatusPustu` = '$statuspustu', `TtePin`='$ttepin'  WHERE `IdPegawai`='$idpegawai'";
		}

	}
	// echo $str;
	// die();
	$query = mysqli_query($koneksi,$str);
	
	
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
		if($nama_file != null){
		copy($tmp,'image/pegawai/'.$namaimg); //proses copy
		}
		alert_swal('sukses','Data berhasil disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=master_pegawai&nip=$nip';";
		echo "</script>";
	}else{
		alert_swal('gagal','Data gagal disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=master_pegawai&nip=$nip';";
		echo "</script>";
	} 	
?>