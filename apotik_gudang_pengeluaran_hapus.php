<?php
	$nofaktur = $_GET['id'];	
	
	$str = "DELETE FROM `tbgudangpkmpengeluaran` Where `NoFaktur` = '$nofaktur'";
	$query=mysqli_query($koneksi,$str);		
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=apotik_gudang_pengeluaran'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=apotik_gudang_pengeluaran'";
		echo "</script>";
	} 
?>