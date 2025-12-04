<?php
	$iddtl = $_GET['iddtl'];
	$iddkh = $_GET['iddkh'];
	$status = $_GET['status'];
	
	$str = "DELETE FROM `tbgudangpkmdkhdetail` WHERE `IdDkhDetail`='$iddtl'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=lap_farmasi_dkh_detail&iddkh=$iddkh&status=$status';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=lap_farmasi_dkh_detail&iddkh=$iddkh&status=$status';";
		echo "</script>";
	} 
?>