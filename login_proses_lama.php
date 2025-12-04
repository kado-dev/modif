<?php
error_reporting(0);
include "config/koneksi.php";
include "config/helper_yankes.php";
session_start();

$id = $_POST['id'];
$pass = md5($_POST['pass']);
$str = "SELECT * FROM `tbpegawai` WHERE Nip='$id' and Password='$pass'";
// echo $str;
// die();	

if(preg_match("/[']/",$id) || preg_match("/[']/",$pass)){
	echo "Error - SQL Inject Detected";
}else{	
	$query = mysqli_query($koneksi,$str);	
	$cek = mysqli_num_rows($query); 
	$data= mysqli_fetch_array($query);	
	$kodepuskesmas = $data['KodePuskesmas'];
	
	if($cek>0){
	//set login status
	mysqli_query($koneksi,"UPDATE tbpegawai SET StatusLogin = '1' WHERE `Nip`='$id'");
	$puskesmas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$puskesmasdetail = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmasdetail` WHERE `KodePuskesmas` = '$kodepuskesmas'")); 

		$_SESSION['idpegawai']=$data['IdPegawai'];
		$_SESSION['id_user']=$data['Nip'];
		$_SESSION['nama_petugas']=$data['NamaPegawai'];
		$_SESSION['username']=$data['Username'];
		$_SESSION['email']=$data['Email'];
		$_SESSION['status']=$data['Status'];	
		$_SESSION['otoritas']=$data['Otoritas'];	
		$_SESSION['pinsessionpegawai']=$data['TtePin'];	
		$_SESSION['sipsession']=$data['Sip'];	
		$_SESSION['kodepuskesmas']=$puskesmas['KodePuskesmas'];
		$_SESSION['namapuskesmas']=$puskesmas['NamaPuskesmas'];
		$_SESSION['kelurahan']=$puskesmas['Kelurahan'];
		$_SESSION['kecamatan']=$puskesmas['Kecamatan'];
		$_SESSION['kota']=$puskesmas['Kota'];
		$_SESSION['provinsi']=$puskesmas['Provinsi'];
		$_SESSION['kapus']=$puskesmas['KepalaPuskesmas'];
		$_SESSION['kapusnip']=$puskesmas['Nip'];
		$_SESSION['alamat']=$puskesmas['Alamat'];
		$_SESSION['telepon']=$puskesmas['Telepon'];
		$_SESSION['fax']=$puskesmas['no_fax'];
		$_SESSION['tarifadministrasi']=$puskesmas['TarifAdministrasi'];
		$_SESSION['namaapoteker']=$puskesmas['Apoteker'];
		$_SESSION['nosipa']=$puskesmas['Sipa'];
		$_SESSION['bridgingpcare'] = $puskesmas['BridgingV4'];
		$_SESSION['bridgingantrol'] = $puskesmas['BridgingAntrol'];
		$_SESSION['bridgingicare'] = $puskesmas['BridgingIcare'];
		$_SESSION['bridgingsatusehat'] = $puskesmas['SatuSehat'];
		$_SESSION['kodeppk']=$puskesmasdetail['KodePPK'];
		$_SESSION['foto_petugas']=$data['Foto'];	
		$_SESSION['PoliPanggil'] = $data['Poli'];	
		$_SESSION['lantai'] = $data['Lantai'];	
		$_SESSION['LoketPanggil'] = $data['Loket'];	
		$_SESSION['statuspustu'] = $data['StatusPustu'];		
		$_SESSION['anak-ck'] = 'anak-ck';
		$_SESSION['gigi-ck'] = 'gigi-ck';
		$_SESSION['umum-ck'] = 'umum-ck';
		$_SESSION['igd-ck'] = 'igd-ck';
		$_SESSION['kia-ck'] = 'kia-ck';
		$_SESSION['tb-ck'] = 'tb-ck';	
		$_SESSION['KodeYankes'] = $puskesmas['KodeYankes'];
		
		

		$log_yankes = json_decode(login_api_yankes($puskesmas['KodeYankes'],$puskesmas['PassYankes']),true);
		if($log_yankes['access_token'] != ''){
			$_SESSION['token_yankes'] = $log_yankes['access_token'];	
		}
			
		echo "<script>";
		echo "window.location='index.php';";
		echo "</script>";
	}else{		
		setcookie("alert","<div class='alert alert-danger'>Data login anda salah...</div>",time()+5);
		header('location:indexawal.php');
		
	}	
}
?>