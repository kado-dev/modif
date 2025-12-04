<?php
	session_start();
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];	
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
	$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);
	$qry = mysqli_query($koneksi, "SELECT * FROM `$tbgudangpkmstok`");
	while($data = mysqli_fetch_array($qry)){
		$idbaranggdgpkm = $data['IdBarangGdgPkm'];
		$kodebarang = $data['KodeBarang'];
		$namabarang = mysqli_real_escape_string($koneksi, $data['NamaBarang']);
		$nobatch = $data['NoBatch'];
		$expire = $data['Expire'];
		$hargasatuan = $data['HargaSatuan'];
		$satuan = $data['Satuan'];
		$stok = $data['Stok'];		
		$sumberanggaran = $data['SumberAnggaran'];		
		$tahunanggaran = $data['TahunAnggaran'];		
		$str1[]= "('$idbaranggdgpkm','$kodebarang','$namabarang','$satuan','$nobatch','$expire','$hargasatuan','$stok','LOKET OBAT','$sumberanggaran','$tahunanggaran')";
	}
	
	if(isset($str1)){
		$str2 = implode(",",$str1);
		$str = "INSERT INTO `$tbapotikstok`(`IdBarangGdgPkm`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`Stok`,`StatusBarang`,`SumberAnggaran`,`TahunAnggaran`) 
		VALUES ".$str2;		
		// echo $str;
		// die();
		$query = mysqli_query($koneksi,$str);
		if($query){
			echo "<script>";
			echo "alert('Data berhasil di Export...');";
			echo "document.location.href='index.php?page=apotik_gudang_stok';";
			echo "</script>";
		}
	}else{
		echo "<script>";
		echo "alert('Tidak ada data obat baru...');";
		echo "document.location.href='index.php?page=apotik_gudang_stok';";
		echo "</script>";
	}
?>