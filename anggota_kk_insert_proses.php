
<?php
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	
	//--variabel tbkk--//
	$tanggaldaftar = date('Y-m-d');
	$noindex = $_POST['noindex'];
	$nokk = $_POST['nokk'];
	$namakk = $_POST['namakk'];
	$daerah = $_POST['daerah'];
	$wilayah = $_POST['wilayah'];
	$alamat = $_POST['alamat'];
	$rt = $_POST['rt'];
	$rw = $_POST['rw'];
	$no = $_POST['no'];
	$provinsi = $_POST['provinsi'];
	$kota = $_POST['kota'];
	$kecamatan = $_POST['kecamatan'];
	$kelurahan = $_POST['kelurahan'];
	$telepon = $_POST['telepon'];
	$namapegawai = $_SESSION['username'];
	
	//--variabel tbpasien--//
	$nocm = $_POST['nocm'];
	$nik = $_POST['nik'];
	$statuskeluarga = $_POST['statuskeluarga'];
	$tempatlahir = $_POST['tempatlahir'];
	$tanggallahir = $_POST['tanggallahir'];
	$tglla=explode("-",$tanggallahir);
	$tgllahir=$tglla[2]."-".$tglla[1]."-".$tglla[0];
	$jeniskelamin = $_POST['jeniskelamin'];
	$agama = "-";
	$statusnikah = $_POST['statusnikah'];
	$golongandarah = "-";
	$pendidikan = $_POST['pendidikan'];
	$pekerjaan = $_POST['pekerjaan'];
	$asuransi = $_POST['asuransi'];
	$statusasuransi = $_POST['statusasuransi'];
	$noasuransi = $_POST['noasuransi'];
	
	// tbkk
	$str = "INSERT INTO `$tbkk`(`TanggalDaftar`, `NoIndex`, `NoKK`, `NamaKK`, `Daerah`, `Wilayah`, `Alamat`,`RT`, `RW`, `No`, `Provinsi`, `Kota`, `Kecamatan`, `Kelurahan`, `Telepon`, `NamaPegawaiSimpan`) 
	VALUES ('$tanggaldaftar','$noindex','$nokk','$namakk','$daerah','$wilayah','$alamat','$rt','$rw','$no','$provinsi','$kota','$kecamatan','$kelurahan','$telepon','$namapegawai')";
	$query=mysqli_query($koneksi, $str);
	// echo var_dump($str);
	// die();
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=anggota_kk_insert';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=anggota_kk_insert';";
		echo "</script>";
	} 	
?>