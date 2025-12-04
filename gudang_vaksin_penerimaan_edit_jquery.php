<?php
	include "config/koneksi.php";
	$kode = $_POST['kode'];
	$batch = $_POST['batch'];
	$nofaktur = $_POST['nofaktur'];
	$idbarang = $_POST['idbarang'];
	$kolom = $_POST['type'];
	$value = $_POST['value'];
	
	// if($ceknobat == 0){
		// tbgfk_vaksin_stok
		$str_detail1 = "UPDATE `tbgfk_vaksin_stok` SET `HargaBeli` = '$value' WHERE `KodeBarang` = '$kode' and `NoBatch` = '$batch' and `NoFakturTerima` = '$nofaktur'";
		mysqli_query($koneksi, $str_detail1);
		
		// tbgfk_vaksin_penerimaandetail (berdasarkan IdPenerimaan aja)
		$str_detail2 = "UPDATE `tbgfk_vaksin_penerimaandetail` SET $kolom = '$value' WHERE `IdPenerimaan`='$idbarang'";
		mysqli_query($koneksi, $str_detail2);
			
		// tbgfk_vaksin_pengeluarandetail
		$str_detail3 = "UPDATE `tbgfk_vaksin_pengeluarandetail` SET $kolom = '$value' WHERE `KodeBarang` = '$kode' and `NoBatch` = '$batch' and `NoFakturTerima` = '$nofaktur'";
		mysqli_query($koneksi, $str_detail3);
		
		// tbstokbulanandinas
		$str_detail4 = "UPDATE `tbstokbulanandinas` SET `HargaBeli` = '$value' WHERE `KodeBarang` = '$kode' and NoBatch = '$batch'";
		mysqli_query($koneksi, $str_detail4);
		
		echo "Data berhasil di edit...";
	// }else{
		// echo "Data gagal di edit...";
	// }
?>