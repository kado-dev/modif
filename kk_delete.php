<?php
$id = $_GET['id'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);

// delete tbkk
$strkk = "DELETE FROM `$tbkk` WHERE `NoIndex` = '$id'";
$querykk=mysqli_query($koneksi,$strkk);
	
// delete tbpasien
$strpasien = "DELETE FROM `$tbpasien` WHERE `NoIndex` = '$id'";
mysqli_query($koneksi,$strpasien);
	
// delete tbpasienrj
$strpasienrj = "DELETE FROM `tbpasienrj` WHERE `NoIndex` = '$id'";
$strpasienrj2 = "DELETE FROM `$tbpasienrj` WHERE `NoIndex` = '$id'";
$querypasienrj=mysqli_query($koneksi, $strpasienrj2);
	
// hapus by bulan belum
	if($querykk){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=registrasi_form';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=registrasi_form';";
		echo "</script>";
	} 	
?>