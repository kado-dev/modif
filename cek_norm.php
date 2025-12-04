<?php
session_start();
include "config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$norm = $kodepuskesmas.$_POST['norm'];
$sql_cek=mysqli_query($koneksi,"SELECT `NoRM` FROM `tbpasien` WHERE `NoRM` = '$norm'");
$query_cek=mysqli_num_rows($sql_cek);
if($query_cek > 0){
	echo "false";
}else{
	echo "true";
}
?>