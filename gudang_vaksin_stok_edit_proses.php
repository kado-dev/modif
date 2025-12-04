<?php
	$kodebarang =  $_POST['kodebarang'];
	$namaprogram =  $_POST['namaprogram'];
	$satuan =  $_POST['satuan'];
	$nobatch = $_POST['nobatch'];	
	$nobatchedit = $_POST['nobatchedit'];
	$hargabeli = $_POST['hargabeli'];
	$stok = $_POST['stok'];
	$expire = date('Y-m-d',strtotime($_POST['expire']));
	
	// ref_obatprogram
	$dtprogram = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_obatprogram` WHERE `nama_program`='$namaprogram'"));
	$idprogram = $dtprogram['id_program'];

	// tahap1, update stok
	$str = "UPDATE `tbgfk_vaksin_stok` 
	SET `Satuan`='$satuan',
	`HargaBeli`='$hargabeli',
	`Expire`='$expire',
	`IdProgram`='$idprogram',
	`NamaProgram`='$namaprogram',
	`NoBatch`='$nobatchedit'
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
	// echo $str;
	// die();
	$query = mysqli_query($koneksi,$str);
	
	// tahap2, update penerimaan 
	$str2 = "UPDATE `tbgfk_vaksin_penerimaandetail` 
	SET	`Expire`='$expire',`NoBatch`='$nobatchedit'
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
	$query2 = mysqli_query($koneksi,$str2);
	
	// tahap3, update Pengeluaran 
	$str2 = "UPDATE `tbgfk_vaksin_pengeluarandetail` 
	SET	`NoBatch`='$nobatchedit'
	WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch'";
	$query2 = mysqli_query($koneksi,$str2);
		
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_vaksin_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_vaksin_stok_edit&kd=$kodebarang&batch=$nobatch';";
		echo "</script>";
	} 	
?>