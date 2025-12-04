<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$id = $_GET['id'];
$nofaktur = $_GET['no'];
$kodebarang = $_GET['kd'];
$nobatch = $_GET['nb'];

$str = "DELETE FROM `tbgudangpkmreturdetail` WHERE `NoFaktur` = '$nofaktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
$query=mysqli_query($koneksi,$str);

if($query){
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='?page=apotik_gudang_retur_lihat&id=$id';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='?page=apotik_gudang_retur_lihat&id=$id';";
	echo "</script>";
} 	
?>