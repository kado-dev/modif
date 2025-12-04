<?php		
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$idpengadaan = $_GET['id'];
$idpengadaandetail = $_GET['iddetail'];
$idbarang = $_GET['idbarang'];
$jumlah = $_GET['jml'];

// delete tbasetpengadaandetail
$str = "DELETE FROM `tbasetpengadaandetail` WHERE `IdPengadaanDetail`='$idpengadaandetail'";
$query=mysqli_query($koneksi,$str);

// cek stok dan kembalikan
$cekstok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbasetstok` WHERE `IdAset` = '$idbarang' AND KodePuskesmas = '$kodepuskesmas'"));
$stok_tambah = $cekstok['Stok'] - $jumlah;
$strstok = "UPDATE `tbasetstok` SET `Stok`='$stok_tambah' WHERE `IdAset`='$idbarang' AND KodePuskesmas = '$kodepuskesmas'";
mysqli_query($koneksi,$strstok);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil dihapus...');";
	echo "document.location.href='index.php?page=aset_pengadaan_lihat&id=$idpengadaan';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus...');";
	echo "document.location.href='index.php?page=aset_pengadaan_lihat&id=$idpengadaan';";
	echo "</script>";
} 
?>