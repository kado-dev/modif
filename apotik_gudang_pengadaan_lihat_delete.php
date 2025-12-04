<?php		
$id = $_SESSION['id'];	
$kodebarang = $_GET['kodebarang'];
$nobatch = $_GET['nobatch'];
$nofaktur = $_GET['nofaktur'];

// delete stok tbgudangpkmstok
$str_gudangpuskesmasstok = "DELETE FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `NoFakturPengadaan`='$nofaktur'";
mysqli_query($koneksi,$str_gudangpuskesmasstok);

// delete tbgudangpkmpengadaandetail
$str = "DELETE FROM `tbgudangpkmpengadaandetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND SUBSTRING(NoFaktur,1,11)='$kodepuskesmas'";
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil dihapus');";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal dihapus');";
	echo "document.location.href='index.php?page=apotik_gudang_pengadaan_lihat&id=$nofaktur';";
	echo "</script>";
} 
?>