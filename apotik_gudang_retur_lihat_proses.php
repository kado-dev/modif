<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$id = $_POST['id'];
$nofaktur = $_POST['nofaktur'];
$kodebarang = $_POST['kodebarang'];		
$namabarang = $_POST['namabarang'];		
// $satuan = $_POST['satuan'];		
$nobatch = $_POST['nobatch'];		
$jumlah = $_POST['jumlah'];
$penerima = $_POST['penerima'];			
$sumberanggaran = $_POST['sumberanggaran'];			
$tahunanggaran = $_POST['tahunanggaran'];			
$keterangan = $_POST['keterangan'];			

//cek barang
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `tbgudangpkmreturdetail`
WHERE `KodeBarang` = '$kodebarang' AND `Nobatch` = '$nobatch' AND `NoFaktur` = '$nofaktur'"));
if($cekobat > 0){
	echo "<script>";
	echo "alert('Obat sudah diinputkan di faktur yang sama...');";
	echo "document.location.href='index.php?page=apotik_gudang_retur_lihat&id=$id';";
	echo "</script>";
	die();
}

// ngecek stok gudang puskesmas
$datastok_gop = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `Stok` FROM `tbgudangpkmstok` 
WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas` = '$kodepuskesmas' ORDER BY Stok Desc"));
$stok_gop = $datastok_gop['Stok'];

if ($stok_gop < $jumlah){
	echo "<script>";
	echo "alert('Maaf, stok kurang dari jumlah pengeluaran...');";
	echo "document.location.href='index.php?page=apotik_gudang_retur_lihat&id=$id';";
	echo "</script>";
	echo $datastok_gop;
	die();
}

// insert ke tbgfkpengeluarandetail
$str1 = "INSERT INTO `tbgudangpkmreturdetail`(`IdRetur`,`NoFaktur`,`KodeBarang`,`NoBatch`,`Jumlah`,`StatusPengeluaran`,`KeteranganRetur`)
VALUES ('$id','$nofaktur','$kodebarang','$nobatch','$jumlah','$penerima','$keterangan')";;
$query1=mysqli_query($koneksi,$str1);
// echo $str1;
// die();

// ngurangin stok gudang puskesmas
// $stok_gop = $datastok_gop['Stok'] - $jumlah;
// $str4 = "UPDATE `tbgudangpkmstok` SET `Stok`= '$stok_gop' WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas` = '$kodepuskesmas' AND `NoBatch`='$nobatch'";
// mysqli_query($koneksi,$str4);

// cek barang, ingat berdasarkan Status Barang (LOKET OBAT, PUSTU..dll)
// $cek_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang`,`Stok` FROM `tbapotikstok` WHERE `KodeBarang` = '$kodebarang' AND `NoBatch`='$nobatch' and `KodePuskesmas`='$kodepuskesmas' and `StatusBarang`='$penerima'"));
// if($cek_barang == 0){
	// $str_input_brg = "INSERT INTO `tbapotikstok`(`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Stok`,`StatusBarang`,`SumberAnggaran`,`TahunAnggaran`) 
	// VALUES ('$kodepuskesmas','$kodebarang','$namabarang','$satuan','$nobatch','$jumlah','$penerima','$sumberanggaran','$tahunanggaran')";
	// $query = mysqli_query($koneksi,$str_input_brg);
// }else{
	// $stok_apotik = $cek_barang['Stok'] + $jumlah;
	// $str7 = "UPDATE `tbapotikstok` SET `Stok`= '$stok_apotik' 
	// WHERE `KodeBarang`='$kodebarang' and `KodePuskesmas` = '$kodepuskesmas' AND `NoBatch`='$nobatch'";
	// mysqli_query($koneksi,$str7);
// }

if($query1){	
	echo "<script>";
	echo "alert('Data berhasil disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_retur_lihat&id=$id';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan...');";
	echo "document.location.href='index.php?page=apotik_gudang_retur_lihat&id=$id';";
	echo "</script>";
} 
?>