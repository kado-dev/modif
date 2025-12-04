<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$ruangan = strtoupper($_POST['ruangan']);
	$perawatan = $_POST['perawatan'];
	$kelas = $_POST['kelas'];
	$tersedia = $_POST['tersedia'];
	$terpakai = $_POST['terpakai'];
	$belumsiap = $_POST['belumsiap'];
	$pasienpria = $_POST['pasienpria'];
	$pasienwanita = $_POST['pasienwanita'];
	
	// tbpelayanan_tempat_tidur
	$str = "INSERT INTO `tbpelayanan_tempat_tidur`(`KodePuskesmas`,`Ruangan`,`Perawatan`,`Kelas`,`Tersedia`,`Terpakai`,`BelumSiap`,`PasienPria`,`PasienWanita`)
	VALUES ('$kodepuskesmas','$ruangan','$perawatan','$kelas','$tersedia','$terpakai','$belumsiap','$pasienpria','$pasienwanita')";
	$query = mysqli_query($koneksi, $str);
	// echo $str;
	// die();
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=dashboard_ranap';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=dashboard_ranap';";
		echo "</script>";
	} 	
?>