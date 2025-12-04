<?php		
$nofaktur = $_GET['nf'];	
$kodebarang = $_GET['kd'];	
$nobatch = $_GET['bt'];
$jumlah = $_GET['jml'];

// tbgudangpkmreturdetail, update status approve 
mysqli_query($koneksi,"UPDATE `tbgudangpkmreturdetail` SET `StatusApprove`='Y' WHERE `NoFaktur`='$nofaktur' AND `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'");

// kurangin stok gudang puskesmas (kodebarang dan batch)
$cekstok = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `Stok` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'"));
$hasil = $cekstok['Stok'] - $jumlah;
$str = "UPDATE `tbgudangpkmstok` SET `Stok`= '$hasil' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
$query = mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil di Approve...');";
	echo "document.location.href='index.php?page=gudang_besar_retur_lihat&nf=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal di Approve...');";
	echo "document.location.href='index.php?page=gudang_besar_retur_lihat&nf=$nofaktur';";
	echo "</script>";
} 
?>