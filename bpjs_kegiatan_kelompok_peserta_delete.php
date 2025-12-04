<?php
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$id = $_GET['id'];
	$eduid = $_GET['eduid'];
	$nokartu = $_GET['noka'];
	
	// tahap1, delete tbbpjs_kegiatan_kelompok_addanggota
	$tes = delete_kegiatan_kelompok_peserta($eduid,$nokartu);
	// echo $tes;
	// die();
	
	// tahap2, delete tbbpjs_kegiatan_kelompok_addanggota
	// $str = "DELETE FROM `tbbpjs_kegiatan_kelompok_addanggota` WHERE `IdInput` = '$id'";
	// $query = mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=bpjs_kegiatan_kelompok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=bpjs_kegiatan_kelompok...';";
		echo "</script>";
	} 
?>