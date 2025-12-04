<?php
	$judul = $_POST['judul'];
	$isi = $_POST['isi'];
	$tgl = date('Y-m-d');

	//--tbpuskesmas--//
	$str = "INSERT INTO `tbflashnews`(`Judul`, `Isi`, `TglPosting`) VALUES ('$judul','$isi','$tgl')";
	$query=mysqli_query($koneksi,$str);
	$id = mysqli_insert_id();
	$strupdate = "UPDATE `tbflashnewsimg` SET `IdFlashnews` = '$id' where IdFlashnews = '0'";
	mysqli_query($koneksi,$strupdate);
	// echo var_dump($str);
	// die();
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=flash_news';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=flash_news';";//tampilin model
		echo "</script>";
	} 	
?>