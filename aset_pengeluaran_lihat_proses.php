<?php		
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$nofaktur = $_POST['nofaktur'];	
$id = $_POST['id'];	
$idbarang = $_POST['idbarang'];
$namabarang = $_POST['namabarang'];
$satuan = $_POST['satuanbrg'];
$jumlah = $_POST['jumlah'];

// tahap1, cek barang sama dalam 1 faktur
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoFaktur` FROM `tbasetpengeluarandetail` WHERE `IdBarang` = '$idbarang' AND `NoFaktur` = '$nofaktur'"));
if($cekobat > 0){
	echo "<script>";
	echo "document.location.href='index.php?page=aset_pengeluaran_lihat&id=$id&sts=2';";
	echo "</script>";
	die();
}

// tahap2, insert tbasetpengeluarandetail
$str = "INSERT INTO `tbasetpengeluarandetail`(`NoFaktur`,`IdBarang`,`Jumlah`)VALUES ('$nofaktur','$idbarang','$jumlah')";
$query = mysqli_query($koneksi,$str);

// tahap3, cek stok barang lalu insert
$stok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `tbasetstok` WHERE `IdBarang` = '$idbarang' AND KodePuskesmas = '$kodepuskesmas'"));
$stok_tambah = $stok['Stok'] - $jumlah;
$str_gudangpuskesmasstok = "UPDATE `tbasetstok` SET `Stok`='$stok_tambah' WHERE `IdBarang`='$idbarang' AND KodePuskesmas = '$kodepuskesmas'";
mysqli_query($koneksi,$str_gudangpuskesmasstok);


	
if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=aset_pengeluaran_lihat&id=$id';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=aset_pengeluaran_lihat&id=$id';";
	echo "</script>";
} 
?>