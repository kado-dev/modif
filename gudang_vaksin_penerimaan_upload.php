<?php
	include "config/koneksi.php";
	$id = $_POST['id'];

	//image
	$var_file = $_FILES['foto'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type = $var_file['type']; // type file
	$size = $var_file['size']; // ukuran file
	$tmp = $var_file['tmp_name']; // sumber file
	$namaimg = time()."-".$id.".".$ext; // proses penamaan file foto		
	
	$str = "UPDATE `tbgfk_vaksin_penerimaan` SET `ImageDok`='$namaimg' WHERE `IdPenerimaan`='$id'";
	$query=mysqli_query($koneksi,$str);
	// echo var_dump($str);
	// die();
	if($_POST['namalama'] != ''){
		unlink("image/dokumen_penerimaan_vaksin/".$_POST['namalama']);
	}
	if($query){	
		if($nama_file != ''){
		copy($tmp,'image/dokumen_penerimaan_vaksin/'.$namaimg);//proses copy
		}
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_vaksin_penerimaan';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_vaksin_penerimaan';";
		echo "</script>";
	} 	
?>