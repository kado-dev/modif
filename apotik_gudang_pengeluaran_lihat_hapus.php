<?php
include "config/helper_pasienrj.php";
$nofaktur = $_GET['no'];
$idbrg = $_GET['idbrg'];
$idbrgpkm = $_GET['idbrgpkm'];
if($kota == "KOTA TARAKAN"){
	$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
}else{
	$tbapotikstok = "tbapotikstok";
	$tbgudangpkmstok = "tbgudangpkmstok";
}

// tbgudangpkmpengeluarandetail
$getstok_gop = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Jumlah` FROM `tbgudangpkmpengeluarandetail` WHERE `Id` = '$idbrg'"));

// tbgudangpkmstok (bertambah)
$getstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok` FROM `$tbgudangpkmstok` WHERE `IdBarangGdgPkm`='$idbrgpkm'"));
$stok = $getstok['Stok'] + $getstok_gop['Jumlah'];
$update = mysqli_query($koneksi, "UPDATE `$tbgudangpkmstok` SET `Stok`='$stok' WHERE `IdBarangGdgPkm`='$idbrgpkm'");

// tbapotikstok (berkurang), jangan didelete
$getstok_depo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok` FROM `$tbapotikstok` WHERE `IdBarangGdgPkm`='$idbrgpkm'"));
if($getstok_depo['Stok'] != "0" OR $getstok_depo['Stok'] < 0){
	$stok_depo = $getstok_depo['Stok'] - $getstok_gop['Jumlah'];
}else{
	$stok_depo = 0;
}
$stok_depo = $getstok_depo['Stok'] - $getstok_gop['Jumlah'];
$update = mysqli_query($koneksi,"UPDATE `$tbapotikstok` SET `Stok`='$stok_depo' WHERE `IdBarangGdgPkm`='$idbrgpkm'");

// hapus tbgudangpkmpengeluarandetail
$str = "DELETE FROM `tbgudangpkmpengeluarandetail` WHERE `Id` = '$idbrg'";
$query=mysqli_query($koneksi,$str);

if($query){
	echo "<script>";
	echo "alert('Data berhasil dihapus...');";
	echo "document.location.href='?page=apotik_gudang_pengeluaran_lihat&nf=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus...');";
	echo "document.location.href='?page=apotik_gudang_pengeluaran_lihat&nf=$nofaktur';";
	echo "</script>";
} 	
?>