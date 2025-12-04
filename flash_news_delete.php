<?php
	$id = $_GET['id'];

	//--tbpuskesmas--//
	$str = "DELETE From tbflashnews where IdFlashnews = '$id'";
	$query=mysqli_query($koneksi,$str);

	$imgflasnews = mysqli_query($koneksi,"SELECT * from `tbflashnewsimg` where IdFlashnews = '$id'");
	while($img = mysqli_fetch_assoc($imgflasnews)){
		unlink('image/flashnews/'.$img['NamaImg']);
	}
	if($query){	
		$str2 = "DELETE From tbflashnewsimg where IdFlashnews = '$id'";
		mysqli_query($koneksi,$str2);
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='index.php?page=flash_news';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='index.php?page=flash_news';";//tampilin model
		echo "</script>";
	} 	
?>