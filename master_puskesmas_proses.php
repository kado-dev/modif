<?php
	$kodepuskesmas = $_POST['kodepuskesmas'];
	$namapuskesmas = $_POST['namapuskesmas'];
	$alamat = $_POST['alamat'];
	$kelurahan = $_POST['kelurahan'];
	$kecamatan = $_POST['kecamatan'];
	$kota = $_POST['kota'];
	$provinsi = $_POST['provinsi'];
	$telepon = $_POST['telepon'];
	$kepalapuskesmas = $_POST['kepalapuskesmas'];
	$long = $_POST['long'];
	$lat = $_POST['lat'];
	
	//image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type = $var_file['type']; // type file
	$size = $var_file['size']; // ukuran file
	$tmp = $var_file['tmp_name']; // sumber file
	$namaimg = "imgpuskesmas_".$kodepuskesmas.".".$ext; // proses penamaan file foto	
	
	//--tbpuskesmas--//
	$str = "INSERT INTO `tbpuskesmas`(`KodePuskesmas`, `NamaPuskesmas`, `Alamat`, `Kelurahan`, `Kecamatan`, `Kota`, `Profinsi`, `Telepon`, `KepalaPuskesmas`, `Long`, `Lat`, `Img`) 
	VALUES ('$kodepuskesmas', '$namapuskesmas','$alamat','$kelurahan','$kecamatan ','$kota','$provinsi','$telepon','$kepalapuskesmas','$long','$lat','$namaimg')";
	$query=mysqli_query($koneksi,$str);
	
	// echo var_dump($str);
	// die();
	
	if($query){	
		copy($tmp,'image/'.$namaimg);//proses copy
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_puskesmas&id=$idpuskesmas';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_puskesmas&id=$idpuskesmas';";//tampilin model
		echo "</script>";
	} 	
?>