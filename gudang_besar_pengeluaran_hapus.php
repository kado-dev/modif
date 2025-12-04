<?php
	$nf = $_GET['nf'];

	$str = "DELETE FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nf'";
	$query = mysqli_query($koneksi,$str);	
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_besar_pengeluaran';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_besar_pengeluaran';";
		echo "</script>";
	} 	
?>