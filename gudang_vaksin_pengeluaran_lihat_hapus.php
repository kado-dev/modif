<?php
	$idds = $_GET['idds'];
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$kd = $_GET['kd'];
	$batch = $_GET['bt'];
	$jml = $_GET['jml'];
	$penerima = $_GET['penerima'];
	$grandtotal = $_GET['grand'] - $_GET['ttl']; 
	$nfterima = $_GET['nfterima'];
	
	// cek stok
	$dtstok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfk_vaksin_stok` WHERE `KodeBarang` = '$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nfterima'"));
	
	// kembaliin stok
	$stok = $dtstok['Stok'] + $jml;	
	$update = mysqli_query($koneksi,"UPDATE `tbgfk_vaksin_stok` SET `Stok`='$stok' WHERE `KodeBarang` = '$kd' AND `NoBatch`='$batch' AND `NoFakturTerima`='$nfterima'");
	
	// delete pengeluaran detail
	$str = "DELETE FROM `tbgfk_vaksin_pengeluarandetail` WHERE `Id`='$id'";
	$query = mysqli_query($koneksi,$str);

	// delete gudang puskesmas penerimaan detail, berdasarkan kode obat
	$str_gop ="DELETE FROM `tbgudangpkmpenerimaandetail` WHERE `IdDistribusi`='$idds' AND `NoFaktur`='$nf' AND `KodeBarang` = '$kd' AND `NoBatch`='$batch'";
	mysqli_query($koneksi,$str_gop);
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_vaksin_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerima';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_vaksin_pengeluaran_lihat&id=$idds&nf=$nf&penerima=$penerima';";
		echo "</script>";
	} 	
?>