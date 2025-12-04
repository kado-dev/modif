<?php
	$idupdate = $_POST['idupdate'];
	$tanggalupdate = date(('Y-m-d'), strtotime($_POST['tanggalupdate']))." ".date('G:i:s');
	$judul = strtoupper($_POST['judul']);
	$deskripsi = strtoupper($_POST['deskripsi']);
	$kategori = strtoupper($_POST['kategori']);
	$versi = strtoupper($_POST['versi']);
	
	$str = "UPDATE `tbupdatesimpus` SET `TanggalUpdate`='$tanggalupdate',`Judul`='$judul',`Deskripsi`='$deskripsi',`Kategori`='$kategori',`Versi`='$versi' WHERE `IdUpdate`='$idupdate'";
	$query=mysqli_query($koneksi,$str);
	// echo var_dump($str);
	// die();
	
	if($query){	
		if($nama_file != ''){
		copy($tmp,'image/pegawai/'.$namaimg);//proses copy
		}
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=adm_update_simpus';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=adm_update_simpus';";
		echo "</script>";
	} 	
?>