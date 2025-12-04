<?php
	$id = $_GET['id'];	
	$str = "DELETE FROM `tbgfk_vaksin_penerimaan` WHERE `IdPenerimaan`='$id'";
	$query = mysqli_query($koneksi,$str);
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_vaksin_penerimaan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_vaksin_penerimaan';";
		echo "</script>";
	} 	
?>