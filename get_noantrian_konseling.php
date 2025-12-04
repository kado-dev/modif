<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";

$data_antrian = mysqli_query($koneksi, "SELECT MAX(NoAntrianPoli) as `No` from $tbpasienrj WHERE `StatusPasien` = '2' AND DATE(`TanggalRegistrasi`) = CURDATE()");
if(mysqli_num_rows($data_antrian) == 0){
    $nomor_antrian = 1;
}else{
    $dta = mysqli_fetch_assoc($data_antrian);
    $nomor_antrian = $dta['No'] + 1;
}
$no = sprintf("%03d", $nomor_antrian);
echo $no;
?>