<?php
	$noresep = $_GET['id'];
	$statusdilayani = $_GET['statusdilayani'];
	$statusloket = $_GET['statusloket'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	
	$str = "DELETE FROM `$tbresep` WHERE `NoResep`='$noresep'";
	$query=mysqli_query($koneksi,$str);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		echo "document.location.href='?page=apotik_pelayanan_resep&status=&tgl=&key=&loketobat=semua&statusdilayani=$statusdilayani&statusloket=$statusloket'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		echo "document.location.href='?page=apotik_pelayanan_resep&status=&tgl=&key=&loketobat=semua&statusdilayani=$statusdilayani&statusloket=$statusloket'";
		echo "</script>";
	} 
?>