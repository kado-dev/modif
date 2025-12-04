<?php
date_default_timezone_set('Asia/Jakarta');
//session_start();
include "../config/koneksi.php";
include "../config/helper.php";
$kodepuskesmas = $_COOKIE['kodepuskesmas2'];

$q = mysqli_query($koneksi,"UPDATE `tbantrian_view1` SET DisplayUtama = '' where `KodePuskesmas`='$kodepuskesmas'");
?>