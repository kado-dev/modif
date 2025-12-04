<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$nofaktur = $_POST['nofaktur'];
$idbrggudangpkm = $_POST['idbrggudangpkm'];		
$kodebarang = $_POST['kodebarang'];		
$namabarang = $_POST['namabarang'];		
$satuan = $_POST['satuan'];		
$nobatch = $_POST['nobatch'];		
$expire = $_POST['expire'];		
$harga = $_POST['hargasatuan'];		
$jumlah = $_POST['jumlah'];
$penerima = $_POST['penerima'];			
$sumberanggaran = $_POST['sumberanggaran'];			
$tahunanggaran = $_POST['tahunanggaran'];	

// tahap 1, cek barang
$cekobat = mysqli_num_rows(mysqli_query($koneksi,"SELECT `KodeBarang` FROM `tbgudangpkmpengeluarandetail` WHERE `IdBarangGdgPkm` = '$idbrggudangpkm' AND `NoFaktur` = '$nofaktur'"));
if($cekobat > 0){
	echo "<script>";
	echo "alert('Obat sudah diinputkan di faktur yang sama...');";
	echo "document.location.href='index.php?page=apotik_permintaan_depot_lihat&nf=$nofaktur';";
	echo "</script>";
	die();
}

// tahap 2, ngecek stok gudang puskesmas
$datastok_gop = mysqli_fetch_assoc( mysqli_query($koneksi,"SELECT `IdBarangGdgPkm`,`Stok` FROM `tbgudangpkmstok` WHERE `IdBarangGdgPkm` = '$idbrggudangpkm'"));
$stok_gop = $datastok_gop['Stok'];

if ($stok_gop < $jumlah){
	echo "<script>";
	echo "alert('Maaf, stok kurang dari jumlah pengeluaran...');";
	echo "document.location.href='index.php?page=apotik_permintaan_depot_lihat&nf=$nofaktur';";
	echo "</script>";
	die();
}

// tahap 3, insert ke tbgfkpengeluarandetail
$str = "INSERT INTO `tbgudangpkmpengeluarandetail`(`NoFaktur`,`IdBarangGdgPkm`,`KodeBarang`,`NoBatch`,`JumlahPermintaan`,`StatusBarang`)
VALUES ('$nofaktur','$idbrggudangpkm','$kodebarang','$nobatch','$jumlah','$penerima')";;
$query=mysqli_query($koneksi,$str);

if($query){	
	echo "<script>";
	echo "alert('Data berhasil disimpan');";
	echo "document.location.href='index.php?page=apotik_permintaan_depot_lihat&nf=$nofaktur';";
	echo "</script>";
}else{
	echo "<script>";
	echo "alert('Data gagal disimpan');";
	echo "document.location.href='index.php?page=apotik_permintaan_depot_lihat&nf=$nofaktur';";
	echo "</script>";
} 
?>