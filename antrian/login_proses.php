<?php
session_start();
include "../config/koneksi.php";
//session_start();
$kodepuskesmas = $_POST['kodepuskesmas'];
$pass = md5($_POST['pass']);

$str = "SELECT * FROM tbantrian_login WHERE `Password` = '$pass'";	

if(preg_match("/[']/",$user) || preg_match("/[']/",$pass)){
	echo "Error - SQL Inject Detected";
}else{	
	$query = mysqli_query($koneksi,$str);	
	$rst = mysqli_num_rows($query); 
	
	if($rst>0){
		$data = mysqli_fetch_array($query);
		$puskesmas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$data[KodePuskesmas]'"));
			
		mysqli_query($koneksi, "UPDATE `tbantrian_view1` SET `DisplayUtama` = '' WHERE `KodePuskesmas`='$kodepuskesmas'");		
		mysqli_query($koneksi,"UPDATE `tbantrian_pelayanan` SET `Display` = '' WHERE `KodePuskesmas`='$kodepuskesmas'");
		$_SESSION['kodepuskesmas']=$puskesmas['KodePuskesmas'];
		// $_SESSION['namapuskesmas2']=$puskesmas['NamaPuskesmas'];
		// $_SESSION['kota2']=$puskesmas['Kota'];
		// $_SESSION['alamat2']=$puskesmas['Alamat'];

		setcookie('kodepuskesmas2', $puskesmas['KodePuskesmas'], time() + (86400 * 30), "/");
		setcookie('namapuskesmas2', $puskesmas['NamaPuskesmas'], time() + (86400 * 30), "/");
		setcookie('kota2', $puskesmas['Kota'], time() + (86400 * 30), "/");
		setcookie('alamat2', $puskesmas['Alamat'], time() + (86400 * 30), "/");
		setcookie('passloginantrian', $data['Password'], time() + (86400 * 30), "/");

		echo "<script>";
		echo "window.location='index.php?page=dashboard';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('data login anda salah');";
		echo "window.location='index.php';";
		echo "</script>";
	}	
}

?>