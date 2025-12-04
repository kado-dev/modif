<?php
$tanggalso = date('Y-m-d', strtotime($_POST['tanggalso']));	
$bulan= date('m', strtotime($_POST['tanggalso']));
$tahun= date('Y', strtotime($_POST['tanggalso']));	
$keteranganso = $_POST['keteranganso'];	

// masuk ke tbstokbulanandinas
$strcek = "SELECT `KodeBarang` FROM `tbstokbulanandinas` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun'";
$cek = mysqli_num_rows(mysqli_query($koneksi, $strcek));
// echo $strcek;
// die();


if ($cek == 0){	
	$query1 = mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `SumberAnggaran` != 'BLUD' AND `Stok` > '0'");
	while($data = mysqli_fetch_assoc($query1)){
		$str = "INSERT INTO `tbstokbulanandinas`(`Bulan`,`Tahun`,`KodeBarang`,`NamaBarang`,`NamaProgram`,`NoBatch`,`StokAwalSistem`,`Keterangan`) 
		VALUES ('$bulan','$tahun','$data[KodeBarang]','$data[NamaBarang]','$data[NamaProgram]','$data[NoBatch]','$data[Stok]','$keteranganso')";
		// echo $str;
		// die();
		$query = mysqli_query($koneksi, $str);
	}
}

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=gudang_besar_opnam';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=gudang_besar_opnam_tambah';";
	echo "</script>";
} 
?>