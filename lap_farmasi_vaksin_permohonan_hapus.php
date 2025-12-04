<?php
	$id = $_GET['id'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	$namabrg = $_GET['namabrg'];
	$dosis = $_GET['dosis'];
	$str = "DELETE FROM `tbgfk_vaksin_usulan` WHERE `IdUsulan` = '$id'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=lap_farmasi_vaksin_permohonan&tanggal_awal=01-09-2021&tanggal_akhir=30-09-2021&namavaksin=$namabrg&dosis=$dosis';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=lap_farmasi_vaksin_permohonan&tanggal_awal=$tgl1&tanggal_akhir=$tgl2&namavaksin=$namabrg&dosis=$dosis';";
		echo "</script>";
	} 	
?>