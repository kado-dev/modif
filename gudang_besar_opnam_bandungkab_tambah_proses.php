<?php
$tanggalso = date('Y-m-d', strtotime($_POST['tanggalso']));	
$bulan= date('m', strtotime($_POST['tanggalso']));
$tahun= date('Y', strtotime($_POST['tanggalso']));	
$keteranganso = $_POST['keteranganso'];	

// cek faktur dibulan yang sama
$cekbulan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbstokbulanandinas_bandungkab` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun'"));
if ($cekbulan > 0) {
	echo "<script>";
	echo "document.location.href='?page=gudang_besar_opnam_bandungkab_tambah&stsvalidasi=Data gagal disimpan, Stok opname sudah pernah dientry bulan ini....'";
	echo "</script>";
	die();
}

// masuk ke tbstokbulanandinas_bandungkab
$query_so = mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `SumberAnggaran` != 'BLUD' GROUP BY KodeBarang, NoBatch");
while($data_so = mysqli_fetch_assoc($query_so)){
	// stok gudang besar & pelayanan
	$dtgudangbesar= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfkstok` WHERE `KodeBarang`='$data_so[KodeBarang]' AND `NoBatch`='$data_so[NoBatch]'"));
	$dtgudangpelayanan= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$data_so[KodeBarang]' AND `NoBatch`='$data_so[NoBatch]'"));
	// insert
	$str_so = "INSERT INTO `tbstokbulanandinas_bandungkab`(`Bulan`,`Tahun`,`KodeBarang`,`NamaBarang`,`NoBatch`,`Expire`,`HargaBeli`,`TahunAnggaran`,`StokGudangBesar_Sistem`,`StokGudangPelayanan_Sistem`,`Keterangan`) 
	VALUES ('$bulan','$tahun','$data_so[KodeBarang]','$data_so[NamaBarang]','$data_so[NoBatch]','$data_so[Expire]','$data_so[HargaBeli]','$data_so[TahunAnggaran]','$dtgudangbesar[Stok]','$dtgudangpelayanan[Stok]','$keteranganso')";
	mysqli_query($koneksi, $str_so);
}

if($query_so){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_opnam_bandungkab';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=gudang_besar_opnam_bandungkab_tambah';";
	echo "</script>";
} 
?>