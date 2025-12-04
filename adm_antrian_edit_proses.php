<?php
	$tanggalpasang =  date('Y-m-d', strtotime($_POST['tanggalpasang']));
	$tanggalpelatihan =  date('Y-m-d', strtotime($_POST['tanggalpelatihan']));
	$puskesmas = $_POST['puskesmas'];
	$ppk = $_POST['ppk'];
	$penyedia = $_POST['penyedia'];
	$spesifikasi = $_POST['spesifikasi'];
	$spek = implode(",",$spesifikasi); 
	$teknisipasang = $_POST['teknisipasang'];
	$pelatihan = $_POST['pelatihan'];
	$idantrian = $_POST['idantrian'];
	
	//image
	$var_file = $_FILES['image'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$type = $var_file['type']; // type file
	$size = $var_file['size']; // ukuran file
	$tmp = $var_file['tmp_name']; // sumber file
	$namaimg = date('Ymdgis').".".$ext; // proses penamaan file foto		
	
	$str = "UPDATE `tbadm_antrian` SET `TanggalPasang`='$tanggalpasang',`TanggalPelatihan`='$tanggalpelatihan',`Puskesmas`='$puskesmas',`PPK`='$ppk',
	`PenyediaHardware`='$penyedia',`SpesifikasiHardware`='$spek',`TeknisiPasang`='$teknisipasang',`Pelatihan`='$pelatihan',`Foto`='$namaimg' 
	WHERE `IdAntrian`='$idantrian'";		
	$query=mysqli_query($koneksi,$str);
	// echo $str;
	// die();
	
	if($query){	
		if($nama_file != ''){
		copy($tmp,'image/pegawai/'.$namaimg);//proses copy
		}
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=adm_antrian';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=adm_antrian';";
		echo "</script>";
	} 	
?>