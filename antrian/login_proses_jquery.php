<?php
include "../config/koneksi.php";
//session_start();
$kodepuskesmas = $_POST['kd'];
$pass = md5($_POST['pass']);
$str = "SELECT * FROM `tbantrian_login` WHERE `KodePuskesmas` = '$kodepuskesmas' AND `Password`='$pass'";
if(preg_match("/[']/",$kodepuskesmas) || preg_match("/[']/",$pass)){
	echo "Error - SQL Inject Detected";
}else{	
	$query = mysqli_query($koneksi,$str);	
	$rst = mysqli_num_rows($query); 
	
	if($rst>0){
		echo "1";
	}else{
		echo "0";
	}	
}
?>