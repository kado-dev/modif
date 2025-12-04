<?php
include "config/koneksi.php";
$IdSiklusHidup = $_POST['IdSiklusHidup'];
$list = $_POST['list'];

mysqli_query($koneksi, "DELETE FROM `siklushidup_skrining` WHERE `IdSiklusHidup` = '$IdSiklusHidup'");
foreach($list as $IdSkrining){
    mysqli_query($koneksi,"INSERT INTO `siklushidup_skrining`(`IdSiklusHidupSkrining`, `IdSiklusHidup`, `IdSkrining`) VALUES (null,'$IdSiklusHidup','$IdSkrining')");
}

echo 'sukses';
?>