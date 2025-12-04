<?php
session_start();
include "config/koneksi.php";

$text = 'waktu: '.date('Y-m-d H:i:s')." session".$_SESSION['namapuskesmas'];
mysqli_query($koneksi, "INSERT INTO `testcronjob`(`id`, `keterangan`) VALUES (null,'$text')");
?>