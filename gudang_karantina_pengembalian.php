<?php
	$kodebarang = $_GET['kd'];
    $nobatch = $_GET['batch'];
    $nofakturterima = $_GET['faktur'];
	$idkarantina = $_GET['idkr'];

    // tahap 1, update tbgfkstok StatusKarantina jika tnggal 1 baru update status N
	$cekitem = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang`FROM `tbgfk_karantinadetail` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NofakturTerima`='$nofakturterima'"));
	if($cekitem == '1'){
		$str1 = "UPDATE `tbgfkstok` SET `StatusKarantina`= 'N' WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `NoFakturTerima`='$nofakturterima'";
		mysqli_query($koneksi, $str1);
	}
	
	$str2 = "DELETE FROM `tbgfk_karantinadetail` WHERE `IdKarantinaDetail`='$idkarantina'";
	$query1 =  mysqli_query($koneksi, $str2);
	
	if($query1){	
		echo "<script>";
		echo "alert('Data berhasil dikembalikan...');";
		echo "document.location.href='?page=gudang_karantina_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dikembalikan...');";
		echo "document.location.href='?page=gudang_karantina_stok';";
		echo "</script>";
	} 	
?>