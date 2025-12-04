<?php
	$nf = $_GET['nf'];
	
	// delete tbgfkstok
	$str = "DELETE FROM `tbgfkstok_opnam` WHERE `NoFaktur`='$nf'";
	$query = mysqli_query($koneksi, $str);
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_besar_opnam';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_besar_opnam';";
		echo "</script>";
	} 	
?>


