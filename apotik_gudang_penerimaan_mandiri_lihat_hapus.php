<?php
include "config/helper_pasienrj.php";
$nofaktur = $_GET['no'];
$kodebarang = $_GET['kd'];
$nobatch = $_GET['bat'];
	
// sebelum obat dihapus, cek dulu apakah obat ini sudah pernah didistribusikan. Jika sudah maka obat tidak bisa dihapus
$dtdistribusi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(KodeBarang) AS KodeBarang FROM `tbgudangpkmpengeluarandetail` 
WHERE substring(NoFaktur,1,11)='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));

if($dtdistribusi['KodeBarang'] != '0'){
	echo "<script>";
	echo "alert('Data tidak dapat dihapus, dikarenakan barang sudah pernah di distribusikan...');";
	echo "document.location.href='?page=apotik_gudang_penerimaan_mandiri_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	// tbgudangpkmpenerimaandetail
	$str1 = "DELETE FROM `$tbgudangpkmpenerimaandetail` WHERE `NoFaktur`='$nofaktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
	$query=mysqli_query($koneksi, $str1);
	// tbgudangpkmstok
	$str2 = "DELETE FROM `$tbgudangpkmstok` WHERE KodeBarang = '$kodebarang' AND `NoBatch`='$nobatch'";
	mysqli_query($koneksi,$str2);
}

if($query){
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='?page=apotik_gudang_penerimaan_mandiri_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='?page=apotik_gudang_penerimaan_mandiri_lihat&id=$nofaktur';";
	echo "</script>";
} 	
?>