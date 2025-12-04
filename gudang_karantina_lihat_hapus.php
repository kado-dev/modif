<?php
	$idkarantina = $_GET['id'];
	$idbarang = $_GET['idbrg'];
	$nofaktur = $_GET['nf'];
	$stok = $_GET['stok'];

	// delete tbgfk_karantinadetail
	$str = "DELETE FROM `tbgfk_karantinadetail` WHERE `IdKarantinaDetail`='$idkarantina'";
	$query=mysqli_query($koneksi,$str);
	
	// kembalikan stok ke gudang besar
	$strstok = "SELECT `Stok` FROM `tbgfkstok` WHERE `IdBarang`='$idbarang'";
	$querystok = mysqli_query($koneksi, $strstok);
	$dtstok = mysqli_fetch_assoc($querystok);
	$stoks = $dtstok['Stok'] + $stok;
	
	$str1 = "UPDATE `tbgfkstok` SET `Stok`= '$stoks' WHERE `IdBarang`='$idbarang'";
	mysqli_query($koneksi,$str1);    
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_karantina_lihat&id=$nofaktur';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_karantina_lihat&id=$nofaktur';";
		echo "</script>";
	} 	
?>