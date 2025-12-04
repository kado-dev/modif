<?php
$nofaktur = $_GET['no'];
$idbrg = $_GET['idbrg'];
$idbrgpkm = $_GET['idbrgpkm'];

// tbgudangpkmvaksinpengeluarandetail
$getstok1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Jumlah` FROM `tbgudangpkmvaksinpengeluarandetail` WHERE `Id` = '$idbrg'"));

// tbgudangpkmvaksinstok
$getstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Stok` FROM `tbgudangpkmvaksinstok` WHERE `IdBarangGdgPkm`='$idbrgpkm'"));
$stok = $getstok['Stok'] + $getstok1['Jumlah'];
$update = mysqli_query($koneksi,"UPDATE `tbgudangpkmvaksinstok` SET `Stok`='$stok' WHERE `IdBarangGdgPkm`='$idbrgpkm'");

$str = "DELETE FROM `tbgudangpkmvaksinpengeluarandetail` WHERE `Id` = '$idbrg'";
$query=mysqli_query($koneksi,$str);

if($query){
	echo "<script>";
	echo "alert('Data berhasil dihapus...');";
	echo "document.location.href='?page=apotik_vaksin_gudang_pengeluaran_lihat&nf=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus...');";
	echo "document.location.href='?page=apotik_vaksin_gudang_pengeluaran_lihat&nf=$nofaktur';";
	echo "</script>";
} 	
?>