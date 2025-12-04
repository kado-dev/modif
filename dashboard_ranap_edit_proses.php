<?php
	$idbed = $_POST['idbed'];
	$ruangan = strtoupper($_POST['ruangan']);
	$perawatan = $_POST['perawatan'];
	$kelas = $_POST['kelas'];
	$tersedia = $_POST['tersedia'];
	$terpakai = $_POST['terpakai'];
	$belumsiap = $_POST['belumsiap'];
	$pasienpria = $_POST['pasienpria'];
	$pasienwanita = $_POST['pasienwanita'];
	
	
	// tbpelayanan_tempat_tidur
	$str = "UPDATE `tbpelayanan_tempat_tidur` SET `Ruangan`='$ruangan',`Perawatan`='$perawatan',`Kelas`='$kelas',`Tersedia`='$tersedia',
	`Terpakai`='$terpakai',`BelumSiap`='$belumsiap',`PasienPria`='$pasienpria',`PasienWanita`='$pasienwanita' WHERE `IdBed`='$idbed'";
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