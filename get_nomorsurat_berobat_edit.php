<?php
    include "config/koneksi.php";
    $kodepuskesmas = $_POST['kodepuskesmas'];
    $nomorsurat = $_POST['nomorsurat'];
    $idrj = $_POST['idrj'];    
	
	// tahap 1, update tbpasienrj
    $str = "UPDATE `tbpuskesmas` SET `NomorSuratBerobat`='$nomorsurat' WHERE `KodePuskesmas`='$kodepuskesmas'";
    $query = mysqli_query($koneksi, $str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=pemeriksaan_surat_berobat&idrj=$idrj';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=pemeriksaan_surat_berobat&idrj=$idrj';";
		echo "</script>";
	} 	
?>