<?php
include "config/koneksi.php";
$noresep = $_POST['noregistrasiclass'];
$kodebarang = $_POST['kodeobatlokal'];
$nobatch = $_POST['nobatch'];
$str = mysqli_query($koneksi,"SELECT KodeBarang FROM $tbresepdetail WHERE `NoResep`='$noresep' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'");
$cek = mysqli_num_rows($str);
echo $cek;
?>