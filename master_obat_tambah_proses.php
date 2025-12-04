<?php
session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$namabarang = $_POST['namabarang'];
	$satuan = $_POST['satuan'];
	$namaprogram = $_POST['namaprogram'];
	$jenisbarang = $_POST['jenisbarang'];	
			
	// create kode barang
	if($namaprogram == "PROGRAM IMUNISASI"){
		$sql_cek="SELECT max(KodeBarang)as maxno FROM $ref_obat_lplpo WHERE substring(KodeBarang,4,4) AND SUBSTRING(KodeBarang,1,3) = 'VAC'";
	}else{
		$sql_cek="SELECT max(KodeBarang)as maxno FROM $ref_obat_lplpo WHERE substring(KodeBarang,4,4) AND SUBSTRING(KodeBarang,1,3) = 'GFK'";
	}
	
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$data=mysqli_fetch_array($query_cek);
	$no=substr($data['maxno'],-4);
	$no_next=$no+1;
		if(strlen($no_next)==1)
		{
			$no="000".$no_next;
		}
		elseif(strlen($no_next)==2)
		{
			$no="00".$no_next;
		}
		elseif(strlen($no_next)==3)
		{
			$no="0".$no_next;
		}
		else
		{
			$no=$no_next;
		}
		
	if($namaprogram == "PROGRAM IMUNISASI"){	
		$kodebarang="VAC".$no;		
	}else{
		$kodebarang="GFK".$no;
	}		
		
	// cek jika nama obat tidak ada dalam database pornas
	if($kota != "KOTA TARAKAN"){
		$cek_nm_barang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `ref_pornas` WHERE `NamaObat` = '$namabarang'"));
		if($cek_nm_barang == 0){
			echo "<script>";
			echo "document.location.href='?page=master_obat_tambah&stsvalidasi=Nama Barang tidak terdaftar di Database Fornas...';";
			echo "</script>";
			die();
		}
	}
	
	// insert
	$str = "INSERT INTO `ref_obat_lplpo`(`KodeBarang`,`NamaBarang`,`Satuan`,`NamaProgram`,`JenisBarang`)
	VALUES('$kodebarang','$namabarang','$satuan','$namaprogram','$jenisbarang')";
	// echo $str;
	// die();
	$query=mysqli_query($koneksi,$str);	
	
	if($query){	
		echo "<script>";
		echo "alert('Data berhasil disimpan');";
		echo "document.location.href='index.php?page=master_obat'";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal disimpan');";
		echo "document.location.href='index.php?page=master_obat_tambah';";
		echo "</script>";
	} 	
?>