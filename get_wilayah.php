<?php
include 'config/koneksi.php';
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kelurahan = $_POST['kelurahan'];

$cekwil = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbkelurahan WHERE KodePuskesmas = '$kodepuskesmas' AND Kelurahan = '$kelurahan'"));

echo $cekwil;
?>