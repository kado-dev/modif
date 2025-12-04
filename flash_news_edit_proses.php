<?php
	$id = $_POST['id'];
	$judul = $_POST['judul'];
	$isi = $_POST['isi'];

	//--tbpuskesmas--//
	$str = "UPDATE `tbflashnews` SET `Judul`='$judul', `Isi` = '$isi' where `IdFlashnews` = '$id'";
	$query=mysqli_query($koneksi,$str);

	if($query){	
		echo "<script>";
		echo "alert('Data berhasil diupdate');";
		echo "document.location.href='index.php?page=flash_news';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal diupdate');";
		echo "document.location.href='index.php?page=flash_news';";//tampilin model
		echo "</script>";
	} 	
?>