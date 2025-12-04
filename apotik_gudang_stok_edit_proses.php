<?php
	include "config/helper_pasienrj.php";
	$kd = $_POST['kd'];
	$jml_baru = $_POST['jumlah'];
	$nobatch = $_POST['nobatch'];
	$h = $_POST['h'];
	
	$str = "UPDATE `$tbgudangpkmstok` SET `Stok`='$jml_baru' WHERE `KodeBarang` = '$kd' AND `NoBatch`='$nobatch'";
	$update = mysqli_query($koneksi, $str);
	
	if($update){	
		echo "<script>";
		echo "alert('Data berhasil diedit...');";
		echo "document.location.href='index.php?page=apotik_gudang_stok&h=$h';";		
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=apotik_gudang_stok_edit&kd=$kd';";
		echo "</script>";
	} 	
?>