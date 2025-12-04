<?php
	$kode_obat = $_GET['ko'];
	$nobatch = $_GET['nb'];
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$grand_total = $_GET['grand'] - $_GET['ttl']; 
	
	// delete tbgfkstok
	$str = "DELETE FROM `tbgfkstok` WHERE `KodeBarang`='$kode_obat' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nf'";
	$query = mysqli_query($koneksi, $str);
	
	// delete tbgfkpenerimaandetail	
	$str2 = "DELETE FROM `tbgfkpenerimaandetail` WHERE `IdPenerimaan` = '$id'";
	mysqli_query($koneksi,$str2);
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_besar_penerimaan_lihat&id=$nf';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_besar_penerimaan_lihat&id=$nf';";
		echo "</script>";
	} 	
?>


