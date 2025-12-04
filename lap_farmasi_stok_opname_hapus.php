<?php
	$nf = $_GET['nf'];
	
	// delete tbgfkstok
	$str = "DELETE FROM `tbgudangpkmstok_opnam` WHERE `NoFaktur`='$nf'";
	$query = mysqli_query($koneksi, $str);
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=lap_farmasi_stok_opname';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=lap_farmasi_stok_opname';";
		echo "</script>";
	} 	
?>


