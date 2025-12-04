<?php
	session_start();
	include "config/helper_report.php";	
	$id = $_GET['id'];
	$idds = $_GET['idds'];
	$nf = $_GET['nf'];
	$nofakturterima = $_GET['nft'];
	$kd = $_GET['kd'];
	$batch = $_GET['bt'];
	$jml = $_GET['jml'];
	$penerima = $_GET['penerima'];
	
	// cek stok
	$dtstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok` FROM `tbgfkstok` WHERE KodeBarang = '$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofakturterima'"));
	
	// kembaliin stok
	$stok = $dtstok['Stok'] + $jml;	
	$update = mysqli_query($koneksi, "UPDATE `tbgfkstok` SET `Stok`='$stok' WHERE `KodeBarang` = '$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nofakturterima'");
		
	// delete pengeluaran detail
	$str = "DELETE FROM `tbgfkpengeluarandetail` WHERE `Id`='$id'";
	$query = mysqli_query($koneksi,$str);
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus...');";
		if ($kota == "KABUPATEN BOGOR"){
			echo "document.location.href='?page=gudang_besar_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerima'";
		}else{
			echo "document.location.href='?page=gudang_besar_pengeluaran_lihat_manual&id=$idds&nf=$nf&penerima=$penerima'";
		}	
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus...');";
		if ($kota == "KABUPATEN BOGOR"){
			echo "document.location.href='?page=gudang_besar_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerima'";
		}else{
			echo "document.location.href='?page=gudang_besar_pengeluaran_lihat_manual&id=$idds&nf=$nf&penerima=$penerima'";
		}	
		echo "</script>";
	} 	
?>