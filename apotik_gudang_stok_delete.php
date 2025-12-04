<?php
	$id = $_GET['id']; 
	$key = $_GET['key']; 
	$h = $_GET['h']; 
	$str = "UPDATE `tbgudangpkmstok` SET `Stok`='0' WHERE `IdBarangPkm`='$id'";
	$query=mysqli_query($koneksi, $str);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diupdate');";
		echo "document.location.href='?page=apotik_gudang_stok&kategori=&key=$key&h=$h';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate');";
		echo "document.location.href='?page=apotik_gudang_stok';";
		echo "</script>";
	} 	
?>