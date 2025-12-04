<?php
$namapuskesmas = $_SESSION['namapuskesmas'];
$kd = $_POST['kodebarang'];
$nobatch = $_POST['nobatch'];
$sts = $_POST['statusbarang'];
$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);

$jml_baru = $_POST['jumlah'];
$str = "UPDATE `$tbapotikstok` SET `Stok`='$jml_baru' WHERE `KodeBarang`='$kd' AND `NoBatch`='$nobatch' AND `StatusBarang`='$sts'";
// echo var_dump($str);
// die();
$update = mysqli_query($koneksi, $str);

if($update){
	echo "<script>";
	echo "alert('Data berhasil diedit');";
	echo "document.location.href='?page=apotik_stok_tarakan&status=$sts';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal diedit');";
	echo "document.location.href='?page=apotik_stok_tarakan&status=$sts';";
	echo "</script>";
} 	
?>