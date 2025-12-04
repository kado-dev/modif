<?php
	//$sts = 1;
	$namasiswa =  $_POST['namasiswa'];
	$namasekolah =  $_POST['namasekolah'];
	
	$tgllahir = $_POST['tgllahir'];
	$tgllahir1 = explode("-",$tgllahir);
	$tanggallahir = $tgllahir1[2]."-".$tgllahir1[1]."-".$tgllahir1[0];
	
	$str = "INSERT INTO `tbqrcode`(`NamaSiswa`,`TanggalLahir`,`NamaSekolah`)
	VALUES('$namasiswa','$tanggallahir','$namasekolah')";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_qrcode';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_qrcode';";
		echo "</script>";
	} 	
?>