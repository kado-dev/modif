<?php
if($_SESSION['otoritas'] == 'PROGRAMMER'){
$nf = $_GET['nf'];
$id = $_GET['id'];

// cek dulu tabel tbgfkpengeluaran
$datapengeluaran=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluaran` WHERE `NoFaktur`='$nf'"));
$kodepuskesmas = $datapengeluaran['KodePenerima'];

// Delete dulu faktur dan id distribusi
mysqli_query ($koneksi, "DELETE FROM `tbgudangpkmpenerimaandetail` WHERE `IdDistribusi`='$id' AND `NoFaktur`='$nf'");

// proses kirim ulang, cukup detail aja yang dikirim faktur utama gak perlu 
$strkirim_ulang_detail = mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$nf'"); 
while($data = mysqli_fetch_assoc($strkirim_ulang_detail)){
	$kdbarang = $data['KodeBarang'];
	$nobatch = $data['NoBatch'];
	
	// tbgfkstok
	$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfkstok` WHERE `KodeBarang`='$kdbarang' AND `NoBatch`='$nobatch'"));
	$expire = $dt_gfkstok['Expire'];
	$hargabeli = $dt_gfkstok['HargaBeli'];
	
	// tbgudangpkmpenerimaandetail
	$strdetail_kirimulang = "REPLACE INTO `tbgudangpkmpenerimaandetail`(`IdDistribusi`,`NoFaktur`,`KodePuskesmas`,`KodeBarang`,`Jumlah`,`NoBatch`,`Expire`,`HargaBeli`,`StatusValidasi`)
	VALUES ('$id','$nf','$kodepuskesmas[KodePuskesmas]','$kdbarang ','$data[Jumlah]','$nobatch','$expire','$hargabeli','Belum')";
	$query = mysqli_query($koneksi,$strdetail_kirimulang); 
} 

	if($query){
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_pengeluaran_lihat&id=$id&nf=$nf';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=gudang_besar_pengeluaran_lihat&id=$id&nf=$nf';";
		echo "</script>";
	} 
}
?>