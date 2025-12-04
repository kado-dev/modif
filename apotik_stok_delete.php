<?php
	$idbarang = $_GET['id'];
	$sts = $_GET['sts'];
	$str = "UPDATE `tbapotikstok` SET `Stok`='0' WHERE IdBarang = '$idbarang'";
	
	$q = mysqli_query($koneksi, $str);
	if($q){
		echo "<script>";
		echo "alert('Data berhasil diupdate...');";
		echo "document.location.href='index.php?page=apotik_stok&status=$sts';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate...');";
		echo "document.location.href='index.php?page=apotik_stok&status=$sts';";
		echo "</script>";
	}	
?>
