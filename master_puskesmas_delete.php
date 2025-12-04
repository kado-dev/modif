<?php
$id = $_GET['id'];

	$str = "DELETE FROM tbpuskesmas Where `IdPuskesmas` = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=master_puskesmas';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=master_puskesmas';";
		echo "</script>";
	} 	
?>