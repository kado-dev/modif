<?php		
//--variabel tbgfkpenerimaandetail--//
$kodepuskesmas = $_SESSION['kodepuskesmas'];	
$kodebarang = $_GET['kodebarang'];
$nofaktur = $_GET['nofaktur'];
$jumlah = $_GET['jumlah'];
$hargabeli = $_GET['hargabeli'];	
$total = $jumlah * $hargabeli;	
$totallama = $_GET['totallama'];	
$grandtotal = $totallama - $total;	

// tbgudanguptdpengadaan
$str_update = mysqli_query($koneksi,"UPDATE `tbgudanguptdpengadaan` SET GrandTotal=$grandtotal WHERE NoFaktur='$nofaktur'");

$stokpengadaan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Jumlah FROM `tbgudanguptdpengadaandetail` WHERE`KodeBarang` = '$kodebarang' AND KodePuskesmas = '$kodepuskesmas'"));

//pengurangan stok tbgudanguptdstok puskesmas
$stok_gudangpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `tbgudanguptdstok` WHERE`KodeBarang` = '$kodebarang' AND KodePuskesmas = '$kodepuskesmas'"));
$stok_gudangpuskesmas_tambah = $stok_gudangpuskesmas['Stok'] - $stokpengadaan['Jumlah'];
$str_gudangpuskesmasstok = "UPDATE `tbgudanguptdstok` SET `Stok`= '$stok_gudangpuskesmas_tambah' WHERE `KodeBarang`='$kodebarang' AND KodePuskesmas = '$kodepuskesmas'";
mysqli_query($koneksi,$str_gudangpuskesmasstok);

// pengurangan stok tbgfkstok dinas
// $stok_gudangbesar = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Stok FROM `tbgfkstok` WHERE`KodeBarang` = '$kodebarang'"));
// $stok_gudangbesar_tambah = $stok_gudangbesar['Stok'] - $stokpengadaan['Jumlah'];
// $str_gfkstok = "UPDATE `tbgfkstok` SET `Stok`= '$stok_gudangbesar_tambah' WHERE `KodeBarang`='$kodebarang'";
// mysqli_query($koneksi,$str_gfkstok);

//delete tbgudangpkmpengadaandetail
$str = "DELETE FROM `tbgudanguptdpengadaandetail` where KodeBarang = '$kodebarang' AND KodePuskesmas = '$kodepuskesmas' ";
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='index.php?page=uptd_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='index.php?page=uptd_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
} 
?>