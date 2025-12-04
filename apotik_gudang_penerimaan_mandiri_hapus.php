<?php
	$id = $_GET['id'];
	$str = "DELETE FROM `tbgudangpkmpenerimaan` WHERE `IdTerima` = '$id'";
	$query=mysqli_query($koneksi,$str);

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=apotik_gudang_penerimaan_mandiri';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=apotik_gudang_penerimaan_mandiri';";
		echo "</script>";
	} 
?>