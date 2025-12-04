<?php
    session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$notelpseluler = $_POST['notelpseluler'];
	$idpasien = $_POST['idpasien'];
	$str = "UPDATE `$tbpasien` SET `Telpon` = '$notelpseluler' WHERE `IdPasien` = '$idpasien'";
    // echo $str;
    // die();
	mysqli_query($koneksi,$str);
?>