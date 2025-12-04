<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$nofaktur = $_GET['nf'];
$idbrg = $_GET['idbrg'];
$idbrgpkm = $_GET['idbrgpkm'];

// tbgudangpkmpengeluarandetail
$getstok1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Jumlah` FROM `tbgudangpkmpengeluarandetail` WHERE `Id` = '$idbrg'"));

// tbgudangpkmstok
$getstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok` FROM `tbgudangpkmstok` WHERE `IdBarangGdgPkm`='$idbrgpkm'"));
$stok = $getstok['Stok'] + $getstok1['Jumlah'];
$update = mysqli_query($koneksi,"UPDATE `tbgudangpkmstok` SET `Stok`='$stok' WHERE `IdBarangGdgPkm`='$idbrgpkm'");

$str = "DELETE FROM `tbgudangpkmpengeluarandetail` WHERE `Id` = '$idbrg'";
$query=mysqli_query($koneksi,$str);

if($query){
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='?page=apotik_permintaan_depot_lihat&nf=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='?page=apotik_permintaan_depot_lihat&nf=$nofaktur';";
	echo "</script>";
} 	
?>