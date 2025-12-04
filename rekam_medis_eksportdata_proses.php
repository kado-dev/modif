<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];

	$tblopsi = $_POST['tblopsi'];
	$tahun_arr = $_POST['tahun'];

	
	$str = array();
	$tbtujuan = $tblopsi.'_'.str_replace(' ', '', $namapuskesmas);

	if($tblopsi == 'tbpasien'){
		foreach($tahun_arr as $thn){
			$tbasaltahun = $tblopsi."_".$thn;
			if(mysqli_num_rows(mysqli_query($koneksi,"SHOW TABLES LIKE '$tbasaltahun'")) > 0){
				$str[]= "INSERT INTO `$tbtujuan`( `TanggalDaftar`, `NoIndex`, `NoCM`, `Nik`, `NoRM`, `NewNoRM`, `NamaPasien`, `StatusKeluarga`, `TanggalLahir`, `JenisKelamin`, `Agama`, `StatusNikah`, `Pendidikan`, `Pekerjaan`, `Asuransi`, `StatusAsuransi`, `NoAsuransi`, `kdprovider`) SELECT  `TanggalDaftar`, `NoIndex`, `NoCM`, `Nik`, `NoRM`, `NewNoRM`, `NamaPasien`, `StatusKeluarga`, `TanggalLahir`, `JenisKelamin`, `Agama`, `StatusNikah`, `Pendidikan`, `Pekerjaan`, `Asuransi`, `StatusAsuransi`, `NoAsuransi`, `kdprovider` FROM `$tbasaltahun` WHERE SUBSTRING(`NoCM`,1,11) = '$kodepuskesmas' AND `NoCM` NOT IN (SELECT NoCM FROM $tbtujuan);";
			}		
		}
	}else{
		$tbasaltahun = $tblopsi;//tbkk aja
		$str[]= "INSERT INTO `$tbtujuan`(`TanggalDaftar`, `NoIndex`, `NoKK`, `NoRM`, `NamaKK`, `Daerah`, `Wilayah`, `Alamat`, `RT`, `RW`, `No`, `Kelurahan`, `Kecamatan`, `Kota`, `Provinsi`, `Telepon`, `NamaPegawaiSimpan`, `TanggalSimpan`, `NamaPegawaiEdit`, `TanggalEdit`) 
		SELECT `TanggalDaftar`, `NoIndex`, `NoKK`, `NoRM`, `NamaKK`, `Daerah`, `Wilayah`, `Alamat`, `RT`, `RW`, `No`, `Kelurahan`, `Kecamatan`, `Kota`, `Provinsi`, `Telepon`, `NamaPegawaiSimpan`, `TanggalSimpan`, `NamaPegawaiEdit`, `TanggalEdit` FROM `$tbasaltahun` WHERE SUBSTRING(`NoIndex`,3,11) = '$kodepuskesmas' AND `NoIndex` NOT IN (SELECT NoIndex FROM $tbtujuan);";
	}
	
	if(count($str) == 0){	
		alert('gagal','Data gagal disimpan, tidak ada data asal ('.$tblopsi.' )');
		echo "<script>";
		echo "document.location.href='index.php?page=rekam_medis_eksportdata';";
		echo "</script>";
		die();
	}
	
	if(count($str) > 1){
		foreach($str as $str_x){
			if($str_x != ''){
				$query = mysqli_query($koneksi,$str_x);
			}
		}
	}else{
		$query = mysqli_query($koneksi,$str[0]);
	}
	
	if($query){	
		alert_swal('sukses','Data berhasil disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=rekam_medis_eksportdata';";
		echo "</script>";
	}else{
		alert_swal('gagal','Data gagal disimpan');
		echo "<script>";
		echo "document.location.href='index.php?page=rekam_medis_eksportdata';";
		echo "</script>";
	}
?>
