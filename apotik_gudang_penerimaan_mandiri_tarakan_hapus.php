<?php
	session_start();
	include "config/helper_report.php";	
	
	$id = $_GET['id'];
	$tbgudangpkmpenerimaan = "tbgudangpkmpenerimaan_".str_replace(' ', '', $namapuskesmas);
	
	$str = "DELETE FROM `$tbgudangpkmpenerimaan` WHERE `IdGudangPenerimaan` = '$id'";
	$query=mysqli_query($koneksi,$str);

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=apotik_gudang_penerimaan_mandiri_tarakan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=apotik_gudang_penerimaan_mandiri_tarakan';";
		echo "</script>";
	} 
?>