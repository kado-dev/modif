<?php
	$id = $_GET['id'];
	$str = "DELETE FROM `tbupdatesimpus` Where `IdUpdate` = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=adm_update_simpus';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=adm_update_simpus';";
		echo "</script>";
	} 
?>