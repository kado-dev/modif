<?php
	session_start();
	include 'config/koneksi.php';
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$id = $_POST['id'];	
	$idgdgpkm = $_POST['idgdgpkm'];	
	$nf = $_POST['nf'];		
	$jumlah = $_POST['jumlah'];	
		
	// tahap1, tbgudangpkmpengeluarandetail
	$str = "UPDATE `tbgudangpkmpengeluarandetail` SET `Jumlah`= '$jumlah' WHERE `Id`='$id'";
	mysqli_query($koneksi,$str);
		
	// tahap2, tbgudangpkmpengeluaran
	$str2 = "UPDATE `tbgudangpkmpengeluaran` SET `StatusPermintaan`= 'Y' WHERE `NoFaktur`='$nf'";
	mysqli_query($koneksi,$str2);
	
	// tahap3, update tbgudangpkmstok
	$cekstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok` FROM `$tbgudangpkmstok` WHERE `IdBarangGdgPkm`='$idgdgpkm'"));
	$stok = $cekstok['Stok'] - $jumlah;
	$str3 = "UPDATE `$tbgudangpkmstok` SET `Stok`= '$stok' WHERE `IdBarangGdgPkm`='$idgdgpkm'";
	mysqli_query($koneksi,$str3);
	
	echo 'sukses';
?>