<?php
	$nip = $_POST['nip'];
	$namapegawai = strtoupper($_POST['namapegawai']);
	$password = md5($_POST['password']);
	$status = $_POST['status'];
	$otoritas = $_POST['otoritas'];
	$alamat = strtoupper($_POST['alamat']);
	$telepon = $_POST['telepon'];
	$kodepuskesmas = $_POST['kodepuskesmas'];
	
	// image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type = $var_file['type']; // type file
	$size = $var_file['size']; // ukuran file
	$tmp = $var_file['tmp_name']; // sumber file
	$namaimg = date('Ymdgis').".".$ext; // proses penamaan file foto	
	
	$otr = implode(",",$otoritas); 

	//--cek jika sudah ada hapus--//
	$str_pegawai = "select `Nip` from `tbpegawai` where `Nip` ='$nip'";
	$query_pegawai = mysqli_query($koneksi,$str_pegawai);
	$data_pegawai = mysqli_fetch_assoc($query_pegawai);
	
	if ($data_pegawai['Nip'] == "$nip"){
		$str1 = "DELETE FROM `tbpegawai` WHERE `Nip` = '$nip'";
		$query1 = mysqli_query($koneksi,$str1);
	}
	
	$loket = $_POST['loket'];
	$poli = json_encode($_POST['poli']);
	$statuspustu = json_encode($_POST['statuspustu']);
	//--tbpegawai--//
	$str = "INSERT INTO `tbpegawai`(`Nip`, `NamaPegawai`, `Password`, `Status`, `Otoritas`, `Alamat`, `Telepon`, `KodePuskesmas`, `Foto`, `Loket`, `Poli`,`StatusPustu`)
	VALUES ('$nip','$namapegawai','$password','$status','$otr','$alamat','$telepon','$kodepuskesmas','$namaimg','$loket','$poli','$statuspustu')";
	$query=mysqli_query($koneksi,$str);
	
	// echo var_dump($str);
	// die();
	
	if($query){	
	copy($tmp,'image/'.$namaimg);//proses copy
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_pegawai&id=$nip';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_pegawai&id=$nip';";
		echo "</script>";
	} 	
?>