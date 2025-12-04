<?php
	$idspj = $_GET['idspj'];	
    $fotokodrek = $_GET['fotolama_kodrek'];
	$str = "DELETE FROM `tbadmspj` Where `IdSpj` = '$idspj'";
	$query = mysqli_query($koneksi, $str);
	
	if($query){	
        unlink('spjsimpus/'.$fotokodrek);
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=adm_spj_simpus_tambah';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=adm_spj_simpus_tambah';";
		echo "</script>";
	} 
?>