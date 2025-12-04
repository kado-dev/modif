<?php
	$id = $_GET['id'];
	$fotolama = $_GET['img'];
	$str = "DELETE FROM `tbbanner` WHERE md5(IdBanner) = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		if($nama_file != ''){
			unlink('./image/banner/'.$fotolama);
		}
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=master_slide_banner';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=master_slide_banner';";
		echo "</script>";
	} 	
?>