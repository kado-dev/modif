<?php
	$nf = $_GET['nf'];
	
	// delete tbgfkstok
	mysqli_query($koneksi, "DELETE FROM `tbgfkretur` WHERE `NoFaktur`='$nf'");
	
	// delete tbgudangpkmretur
	mysqli_query($koneksi, "DELETE FROM `tbgudangpkmretur` WHERE `NoFaktur`='$nf'");
	$query = mysqli_query($koneksi, "DELETE FROM `tbgudangpkmretur` WHERE `NoFaktur`='$nf'");
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_besar_retur';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_besar_retur';";
		echo "</script>";
	} 	
?>


