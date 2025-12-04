<?php
$nofaktur = $_POST['nofaktur'];
$kodebarang = $_POST['kodebarang'];		
$jumlah = $_POST['jumlah'];
$kdpuskesmas = $_POST['kodepuskesmas'];	//untuk ngambil puskesmas berdasar faktur		
$kodepuskesmas = $_SESSION['kodepuskesmas'];			

//cek barang
$cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` from `tbgudanguptdpengeluarandetail` where NoFaktur = '$nofaktur' AND KodeBarang='$kodebarang'"));
if($cek > 0){
	echo "<script>";
	echo "alert('maaf, Barang sudah diinputkan...');";
	echo "document.location.href='index.php?page=apotik_gudang_pengeluaran_lihat&id=$nofaktur';";
	echo "</script>";
	die();
}

//ngecek stok gudang uptd
$datastok_uptd = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `Stok` FROM `tbgudanguptdstok` WHERE `KodeBarang` = '$kodebarang' and `KodePuskesmas` = '$kodepuskesmas'"));
$stok_uptd = $datastok_uptd['Stok'];

if ($stok_uptd < $jumlah){
	echo "<script>";
	echo "alert('maaf, stok kurang dari jumlah pengeluaran...');";
	echo "document.location.href='index.php?page=uptd_gudang_pengeluaran_lihat&id=$nofaktur';";
	echo "</script>";
	echo $datastok_uptd;
	die();
}

//insert ke tbgudanguptdpengeluarandetail
$str1 = "INSERT INTO `tbgudanguptdpengeluarandetail`(`NoFaktur`,`KodePuskesmas`,`KodeBarang`, `Jumlah`, `StatusValidasi`)
VALUES ('$nofaktur','$kdpuskesmas','$kodebarang','$jumlah','Belum')";
// echo $str1;
$query1=mysqli_query($koneksi,$str1);


//insert ke tbgudangpkmpenerimaandetail
$str2 = "INSERT INTO `tbgudangpkmpenerimaandetail`(`NoFaktur`,`KodePuskesmas`,`KodeBarang`, `Jumlah`, `StatusValidasi`)
VALUES ('$nofaktur','$kdpuskesmas','$kodebarang','$jumlah','Belum')";
// echo $str2;
// die();
$query1=mysqli_query($koneksi,$str2);

//ngurangin stok tbgudanguptdstok
$stok_uptd = $datastok_uptd['Stok'] - $jumlah;
$str4 = "UPDATE `tbgudanguptdstok` SET `Stok`= '$stok_uptd' WHERE `KodeBarang`='$kodebarang' and `KodePuskesmas` = '$kodepuskesmas'";
mysqli_query($koneksi,$str4);

//menambahkan stok diloket obat
// $cek_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang` = '$kodebarang' and `KodePuskesmas` = '$kodepuskesmas'"));
	
// if($cek_barang == 0){
	// $str_input_brg = "INSERT INTO `tbapotikstok`(`KodePuskesmas`,`KodeBarang`,`Stok`,`StatusBarang`) VALUES ('$kodepuskesmas','$kodebarang','$jumlah','$penerima')";
	// $query = mysqli_query($koneksi,$str_input_brg);
// }else{
	// $cek_stok_gop = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT Stok FROM `tbapotikstok` WHERE `KodeBarang` = '$kodebarang' and `KodePuskesmas` = '$kodepuskesmas'"));
	// $data_stok_gop = $cek_stok_gop['Stok'];

	// $stok_apotik = $data_stok_gop + $jumlah;
	// $str7 = "UPDATE `tbapotikstok` SET `Stok`= '$stok_apotik' WHERE `KodeBarang`='$kodebarang' and `KodePuskesmas` = '$kodepuskesmas'";
	// mysqli_query($koneksi,$str7);
// }

if($query1){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=uptd_gudang_pengeluaran_lihat&id=$nofaktur';";
	echo "</script>";
}else{
	// echo $query1;
	// die();
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=uptd_gudang_pengeluaran_lihat&id=$nofaktur';";
	echo "</script>";
} 
?>