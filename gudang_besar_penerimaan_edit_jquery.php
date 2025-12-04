<?php
	include "config/koneksi.php";
	$kode = $_POST['kode'];
	$batch = $_POST['batch'];
	$nofaktur = $_POST['nofaktur'];
	$idbarang = $_POST['idbarang'];
	$id_distribusi = $_POST['id_distribusi'];
	$kolom = $_POST['type'];
	$value = $_POST['value'];
	
	// $ceknobat = 0;
	// if($kolom == 'nobatch'){
		// $ceknobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT NoBatch FROM `tbgfkpenerimaandetail` WHERE `NomorPembukuan` = '$nofaktur' AND `KodeBarang` = '$kode' and `NoBatch` = '$batch'"));
	// }
	
	// if($ceknobat == 0){
		// tbgfkstok
		$str_detail1 = "UPDATE `tbgfkstok` SET `HargaBeli` = '$value' WHERE `KodeBarang` = '$kode' and `NoBatch` = '$batch' and `NoFakturTerima` = '$nofaktur'";
		mysqli_query($koneksi, $str_detail1);
		
		// tbgfkpenerimaandetail (berdasarkan IdPenerimaan aja)
		$str_detail2 = "UPDATE `tbgfkpenerimaandetail` SET $kolom = '$value' WHERE `IdPenerimaan`='$idbarang'";
		mysqli_query($koneksi, $str_detail2);
			
		// tbgfkpengeluarandetail
		$str_detail3 = "UPDATE `tbgfkpengeluarandetail` SET $kolom = '$value' WHERE `KodeBarang` = '$kode' and `NoBatch` = '$batch' and `NoFakturTerima` = '$nofaktur'";
		mysqli_query($koneksi, $str_detail3);
		
		// tbstokbulanandinas
		$str_detail4 = "UPDATE `tbstokbulanandinas` SET `HargaBeli` = '$value' WHERE `KodeBarang` = '$kode' and NoBatch = '$batch'";
		mysqli_query($koneksi, $str_detail4);
		
		// tbgudangpkmpenerimaandetail
		$str_detail4 = "UPDATE `tbgudangpkmpenerimaandetail` SET `HargaBeli` = '$value' WHERE `KodeBarang` = '$kode' and NoBatch = '$batch'";
		mysqli_query($koneksi, $str_detail4);
		
		// tbgudangpkmstok
		$str_detail4 = "UPDATE `tbgudangpkmstok` SET `HargaSatuan` = '$value' WHERE `KodeBarang` = '$kode' and NoBatch = '$batch'";
		mysqli_query($koneksi, $str_detail4);
		
		// tbapotikstok
		$str_detail4 = "UPDATE `tbapotikstok` SET `HargaSatuan` = '$value' WHERE `KodeBarang` = '$kode' and NoBatch = '$batch'";
		mysqli_query($koneksi, $str_detail4);
		
		echo "Data berhasil di edit...";
	// }else{
		// echo "Data gagal di edit...";
	// }
?>