<?php
$idresep = $_GET['id'];
$noresep = $_GET['nr'];
$kodebarang = $_GET['kb'];
$nobatch = $_GET['bt'];
$jumlah = $_GET['jml'];
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	
if(in_array("PROGRAMMER", $otoritas) || in_array("APOTEK", $otoritas)){
	$str = "DELETE FROM `$tbresepdetail` WHERE `IdResepDetail`='$idresep'";
	$query=mysqli_query($koneksi,$str);
	
	// update stok tbapotikstok
	$get_stok_lama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas'"));
	$stok_baru = $get_stok_lama['Stok'] + $jumlah;			
	$str_obat_update = "UPDATE `tbapotikstok` SET `Stok`='$stok_baru' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas'";
	mysqli_query($koneksi,$str_obat_update);
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=apotik_pelayanan_resep_manual_lihat_garutkab&status=&norsp=$noresep'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=apotik_pelayanan_resep_manual_lihat_garutkab&status=&norsp=$noresep'";
		echo "</script>";
	} 
}else{
		echo "<script>";
		echo "alert('Maaf anda tidak bisa menghapus data');";
		echo "document.location.href='?page=apotik_pelayanan_resep_manual_lihat_garutkab&status=&norsp=$noresep'";
		echo "</script>";
}	
?>