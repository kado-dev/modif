<?php
include "koneksi.php";
// include "helper_yankes.php";
include "helper_satusehat.php";
session_start();

$id = $_POST['id'];
$captcha = $_POST['captcha'];
$pass = md5($_POST['pass']);

// Daftar KodePuskesmas yang tidak boleh login
$blocked_kodepuskesmas = array('3204', 'P3204121202', 'P3204070202', 'P3204310201');
$blocked_list = "'" . implode("','", $blocked_kodepuskesmas) . "'";

$str = "SELECT * FROM `tbpegawai` WHERE Nip='$id' and Password='$pass' and KodePuskesmas NOT IN ($blocked_list)";
// echo $str;
// die();	

if($captcha == $_SESSION['captcha']){

	if(preg_match("/[']/",$id) || preg_match("/[']/",$pass)){
		echo "Error - SQL Inject Detected";
	}else{	
		$query = mysqli_query($koneksi,$str);	
		$cek = mysqli_num_rows($query); 
		$data= mysqli_fetch_array($query);	
		$kodepuskesmas = $data['KodePuskesmas'];
		
		if($cek>0){
		//set login status
		mysqli_query($koneksi, "UPDATE tbpegawai SET StatusLogin = '1' WHERE `Nip`='$id'");
		$puskesmas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'")); 
		$puskesmasdetail = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmasdetail` WHERE `KodePuskesmas` = '$kodepuskesmas'")); 

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
			$_SESSION['emailpuskesmas']=$puskesmas['email'];
			$_SESSION['tarifadministrasi']=$puskesmas['TarifAdministrasi'];
			$_SESSION['namaapoteker']=$puskesmas['Apoteker'];
			$_SESSION['nosipa']=$puskesmas['Sipa'];
			$_SESSION['kodeyankes'] = $puskesmas['KodeYankes'];
			$_SESSION['bridgingpcare'] = $puskesmas['BridgingV4'];
			$_SESSION['bridgingantrol'] = $puskesmas['BridgingAntrol'];
			$_SESSION['bridgingicare'] = $puskesmas['BridgingIcare'];
			$_SESSION['bridgingsatusehat'] = $puskesmas['SatuSehat'];
			$_SESSION['nomorsuratsehat'] = $puskesmas['NomorSuratSehat'];
			$_SESSION['nomorsuratsakit'] = $puskesmas['NomorSuratSakit'];
			$_SESSION['nomorsuratberobat'] = $puskesmas['NomorSuratBerobat'];
			$_SESSION['nomorsuratbutawarna'] = $puskesmas['NomorSuratButaWarna'];
			$_SESSION['nomorsurathaji'] = $puskesmas['NomorSuratHaji'];
			$_SESSION['nomorsuratcatin'] = $puskesmas['NomorSuratCatin'];
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
			
			// $_SESSION['kddokter_icare'] = $data['kddokter_icare'];
			// $_SESSION['username_icare'] = $data['username_icare'];
			// $_SESSION['password_icare'] = $data['password_icare'];
			
			$_SESSION['stsehat_orgid'] = $puskesmasdetail['stsehat_orgid'];
			$_SESSION['stsehat_clientid'] = $puskesmasdetail['stsehat_clientid'];
			$_SESSION['stsehat_clientsecret'] = $puskesmasdetail['stsehat_clientsecret'];
			$_SESSION['idpegawai_dokter'] = $puskesmasdetail['idpegawai_dokter'];

			// $log_yankes = json_decode(login_api_yankes($puskesmas['KodeYankes'],$puskesmas['PassYankes']),true);
			// if($log_yankes['access_token'] != ''){
			// 	$_SESSION['token_yankes'] = $log_yankes['access_token'];	
			// }

			// create token  satusehat
			$client_id 	= $puskesmasdetail['stsehat_clientid'];
			$client_secret = $puskesmasdetail['stsehat_clientsecret'];
			$getaccss = login_api_satusehat($client_id, $client_secret);
			if($getaccss){
				$dtaccstoken = json_decode($getaccss,true);
				if($dtaccstoken['status'] == 'approved'){
					$_SESSION['stsehat_access_token'] = $dtaccstoken['access_token'];
					$_SESSION['stsehat_application_name'] = $dtaccstoken['application_name'];
					$_SESSION['stsehat_expires_in'] = $dtaccstoken['expires_in'];
					$_SESSION['stsehat_refresh_count'] = $dtaccstoken['refresh_count'];
				}
			}

			// echo "stsehat_clientid : ".$puskesmasdetail['stsehat_clientid']."<br/>";
			// echo "stsehat_clientsecret : ".$puskesmasdetail['stsehat_clientsecret']."<br/>";
			// echo "token : ".$_SESSION['stsehat_access_token'];
			// echo "getaccss : ".$getaccss;
			// die();
			
			// include "import_pegawai_bpjs_jadwal_auto.php";
				

			echo "<script>";
			echo "window.location='dashboard_pilihlayanan.php';";
			// echo "window.location='index.php';";
			echo "</script>";
		}else{		
			setcookie("alert","<div class='alert alert-danger'>Data login anda salah...</div>",time()+5);
			header('location:indexawal.php');
			
		}	
	}
}else{		
	setcookie("alert","<div class='alert alert-danger'>Captcha login anda salah...</div>",time()+5);
	header('location:indexawal.php');	
}	
?>