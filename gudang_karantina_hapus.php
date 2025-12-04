<?php
	$nofaktur = $_GET['nf'];

	$str = "DELETE FROM `tbgfk_karantina` WHERE `NoFaktur` = '$nofaktur'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_karantina';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_karantina';";
		echo "</script>";
	} 	
?>