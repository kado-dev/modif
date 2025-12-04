<?php
$tanggalso = date('Y-m-d', strtotime($_POST['tanggalso']));	
$bulan= date('m', strtotime($_POST['tanggalso']));
$tahun= date('Y', strtotime($_POST['tanggalso']));	
$keteranganso = $_POST['keteranganso'];	

// masuk ke tbstokbulananvaksindinas
$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbstokbulananvaksindinas` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun'"));
if ($cek == 0){				
	$query = mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `Stok` > 0");
	while($data = mysqli_fetch_assoc($query)){
		$str1 = "INSERT INTO `tbstokbulananvaksindinas`(`Bulan`,`Tahun`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaBeli`,`TahunAnggaran`,`StokAwalSistem`,`Keterangan`) 
		VALUES ('$bulan','$tahun','$data[KodeBarang]','$data[NamaBarang]','$data[Satuan]','$data[NoBatch]','$data[Expire]','$data[HargaBeli]','$data[TahunAnggaran]','$data[Stok]','$keteranganso')";
		$query1=mysqli_query($koneksi,$str1);
	}	
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan, faktur sudah dibuat bulan ini...');";
	echo "document.location.href='index.php?page=gudang_vaksin_opnam';";
	echo "</script>";
}	

if($query1){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_vaksin_opnam';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_vaksin_opnam_tambah';";
	echo "</script>";
} 
?>