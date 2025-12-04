<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kd = $_POST['kd'];
	$jml_baru = $_POST['jumlah'];
	$nobatch = $_POST['nobatch'];
	
	if($kota == "KOTA TARAKAN"){
		$tbgudangpkmvaksinstok = "tbgudangpkmvaksinstok_".str_replace(' ', '', $namapuskesmas);
	}else{
		$tbgudangpkmvaksinstok = "tbgudangpkmvaksinstok";
	}
	
	$str = "UPDATE `$tbgudangpkmvaksinstok` SET `Stok`='$jml_baru' WHERE `KodeBarang` = '$kd' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas'";
	$update = mysqli_query($koneksi, $str);
	
	if($update){	
		echo "<script>";
		echo "alert('Data berhasil diedit...');";
		echo "document.location.href='index.php?page=apotik_vaksin_gudang_stok';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan...');";
		echo "document.location.href='index.php?page=apotik_vaksin_gudang_stok';";
		echo "</script>";
	} 	
?>