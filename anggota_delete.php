<?php
	$idpasien = $_GET['idps'];
	$noindex = $_GET['noindex'];
	
	// delete tbpasien
	mysqli_query($koneksi, "DELETE FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'");
	
	// delete tbpasienrj
	$strpasienrj = "DELETE FROM `$tbpasienrj` WHERE `IdPasien` = '$idpasien'";
	$query = mysqli_query($koneksi, $strpasienrj);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=kk_detail&id=$noindex'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=kk_detail&id=$noindex";
		echo "</script>";
	} 	
?>