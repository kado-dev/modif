<?php
	$namakasie = $_POST['namakasie'];
	$nipkasie = $_POST['nipkasie'];
	$pangkatkasie = $_POST['pangkatkasie'];
	$namapemberi = $_POST['namapemberi'];
	$nippemberi = $_POST['nippemberi'];
	$pangkatpemberi = $_POST['pangkatpemberi'];

	// cek data
	// echo "SELECT COUNT(nip_kasie)AS Jml FROM `tb_user_profil_sbbk` WHERE `nip_kasie` = '$nipkasie'";
	// die();
	
	$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk` WHERE `nip_kasie` = '$nipkasie'"));
	if($cek > 0){
		echo "<script>";
		echo "alert('maaf, Data sudah diinputkan...');";
		echo "document.location.href='index.php?page=master_pemberi_lplpo';";
		echo "</script>";
		die();
	}
	
	//--tbpuskesmas--//
	$str = "INSERT INTO `tb_user_profil_sbbk`(`nip_kasie`, `nama_kasie`, `jabatan_kasie`, `nip_pemberi`, `nama_pemberi`, `jabatan_pemberi`)
	VALUES ('$nipkasie','$namakasie','$pangkatkasie','$nippemberi','$namapemberi','$pangkatpemberi')";
	$query=mysqli_query($koneksi,$str);
	
	// echo var_dump($str);
	// die();
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_pemberi_lplpo';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_pemberi_lplpo';";
		echo "</script>";
	} 	
?>