<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	
	$kota = $_SESSION['kota'];
	$namatindakan = strtoupper($_POST['namatindakan']);
	$kelompoktindakan = $_POST['kelompoktindakan'];
	$tarif = $_POST['tarif'];
	$stssimpan = $_GET['stssimpan'];
	$kdtindakan = $_POST['kodetindakan'];
	
	if($stssimpan == 'edit'){
		$str = "UPDATE `tbtindakan` SET `Tindakan`='$namatindakan', `Tarif`='$tarif' WHERE `IdTindakan`='$kdtindakan'";
	}else{	
		$str = "INSERT INTO `tbtindakan`(`Tindakan`,`KelompokTindakan`,`Satuan`,`Tarif`,`Status`,`Kota`) 
		VALUES ('$namatindakan','$kelompoktindakan','Per Tindakan','$tarif','Perda','$kota')";
	}
	$query=mysqli_query($koneksi,$str);
		
	if($query){	
		alert_swal('sukses','Data berhasil disimpan');
		echo "<script>";
		//echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_tindakan';";
		echo "</script>";
	}else{
		alert_swal('gagal','Data gagal disimpan');
		echo "<script>";
		//echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_tindakan';";
		echo "</script>";
	} 	
?>