<?php
include "config/koneksi.php";
$jenis = $_POST['kir'];
$query = mysqli_query($koneksi,"SELECT * FROM `tbkir` where `JenisKir`='$jenis'");
$data = mysqli_fetch_assoc($query);
echo $data['Tarif'];
?>