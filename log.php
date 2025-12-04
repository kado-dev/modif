<?php
include('config/koneksi.php');
session_start();
$tanggal = date("d-m-Y");
$jam = date("h:i:s");
$userLog = $_POST['userlog'];
$nip = $_SESSION['id_user'];
$namapegawai = $_SESSION['username'];
if($userLog=="online"){
	//update status
	mysqli_query($koneksi,"UPDATE `tbpegawai` SET `StatusLogin`='1' WHERE `Nip`='$nip'");
}else if($userLog=="offline"){
	//update status
	mysqli_query($koneksi,"UPDATE `tbpegawai` SET `StatusLogin`='0' WHERE `Nip`='$nip'");
}
file_put_contents("userlog.txt", $userLog." ".$namapegawai." ".$tanggal." ".$jam."\n", FILE_APPEND );
?>