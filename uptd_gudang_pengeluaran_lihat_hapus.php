<?php
$no = $_GET['no'];
$kd = $_GET['kd'];


	$getstok1 = mysqli_fetch_assoc(mysqli_query($koneksi,"Select Jumlah from tbgudanguptdpengeluarandetail Where `NoFaktur` = '$no' AND KodeBarang = '$kd'"));
	$getstok = mysqli_fetch_assoc(mysqli_query($koneksi,"Select Stok from tbgudanguptdstok where KodeBarang = '$kd'"));
	$stok = $getstok['Stok'] + $getstok1['Jumlah'];
	$update = mysqli_query($koneksi,"UPDATE `tbgudanguptdstok` SET `Stok`='$stok' where KodeBarang = '$kd'");
	
	$str = "DELETE FROM `tbgudanguptdpengeluarandetail` Where `NoFaktur` = '$no' AND KodeBarang = '$kd'";
	$query=mysqli_query($koneksi,$str);
	
	$str2 = "DELETE FROM `tbgudangpkmpenerimaandetail` Where `NoFaktur` = '$no' AND KodeBarang = '$kd'";
	$query=mysqli_query($koneksi,$str2);
	
	if($query){
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=uptd_gudang_pengeluaran_lihat&id=$no';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=uptd_gudang_pengeluaran_lihat&id=$no';";
		echo "</script>";
	} 	
?>