<?php
$id = $_GET['id'];

// hapus
$str = "DELETE FROM `tbpelayanan_tempat_tidur` WHERE `IdBed` = '$id'";
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='?page=dashboard_ranap';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='?page=dashboard_ranap';";
	echo "</script>";
}
?>