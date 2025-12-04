<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";

	if(strlen($_POST['norm']) == 17){
		$norm = $_POST['norm'];
	}else{
		$norm = $_SESSION['kodepuskesmas'].$_POST['norm'];
	}
	
	$nocm = $_POST['nocm'];
	$noindex = $_POST['noindex'];	

	if($_SESSION['kota'] == "KABUPATEN BANDUNG" || $_SESSION['kota'] == "KABUPATEN BULUNGAN" || $_SESSION['kota'] == "KABUPATEN KUTAI KARTANEGARA"){
		$ceknorm = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRM` FROM `$tbpasien` WHERE `NoRM` = '$norm'"));
			if($ceknorm == 0){
			$str = "UPDATE `$tbpasien` SET NoRM = '$norm' WHERE NoCM = '$nocm'";
			$strkk = "UPDATE `$tbkk` SET NoRM = '$norm' WHERE NoIndex = '$noindex'";
			$query = mysqli_query($koneksi,$str);
			$query2 = mysqli_query($koneksi,$strkk);
			if($query AND $query2){
				echo "Sukses...";
			}else{
				echo "No.RM gagal disimpan...";
			}
		}else{
			echo "No.RM sudah pernah diinputkan...";
		}
	}elseif($_SESSION['kota'] == "KABUPATEN GARUT"){
		$str = "UPDATE `$tbpasien` SET NoRM = '$norm' WHERE NoCM = '$nocm'";
		$str1 = "UPDATE `$tbkk` SET NoRM = '$norm' WHERE NoIndex = '$noindex'";
		$query = mysqli_query($koneksi,$str);
		$query2 = mysqli_query($koneksi,$str1);
		if($query AND $query2){
			echo "Sukses...";
		}else{
			echo "No.RM gagal disimpan...";
		}
	}	
	
?>