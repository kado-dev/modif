<?php
	session_start();
	include "config/koneksi.php";
	$kodedesa = $_POST['kodedesa'];
	$koderm = $_POST['koderm']; 
	$statusnomerrm = $_POST['statusnomerrm']; 
	
	foreach($kodedesa as $kdb){
		$query = mysqli_query($koneksi,"UPDATE `tbkelurahan` SET `KodeRM`='$koderm[$kdb]' WHERE `Kode`='$kdb'");
	}	
	
	// update status rm
	mysqli_query($koneksi, "UPDATE `tbstatusnomerrm` SET `StatusIndex`='$statusnomerrm'");
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan...');";
		echo "document.location.href='index.php?page=master_nomerrm';";
		echo "</script>";
	}
?>	