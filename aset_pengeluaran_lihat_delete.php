<?php		
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$iddistribusi = $_GET['id'];
$idbarang = $_GET['idbrg'];
$jumlah = $_GET['jml'];

// delete tbasetpengeluarandetail
$str = "DELETE FROM `tbasetpengeluarandetail` WHERE `IdDistribusiDetail`='$iddistribusi'";
$query=mysqli_query($koneksi,$str);

// cek stok dan kembalikan
$cekstok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbasetstok` WHERE `IdBarang` = '$idbarang' AND KodePuskesmas = '$kodepuskesmas'"));
$stok_tambah = $cekstok['Stok'] + $jumlah;
$strstok = "UPDATE `tbasetstok` SET `Stok`='$stok_tambah' WHERE `IdBarang`='$idbarang' AND KodePuskesmas = '$kodepuskesmas'";
mysqli_query($koneksi,$strstok);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil dihapus...');";
	echo "document.location.href='index.php?page=aset_pengeluaran_lihat&id=$iddistribusi';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus...');";
	echo "document.location.href='index.php?page=aset_pengeluaran_lihat&id=$iddistribusi';";
	echo "</script>";
} 
?>